<?php

namespace Site\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\ParameterContainer;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\Exception\InvalidArgumentException;
use Zend\Db\TableGateway\Exception\RuntimeException;
use Zend\Db\TableGateway\Feature\AbstractFeature;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\Feature\EventFeature;
use Zend\Db\TableGateway\TableGateway;

class AbstractTableGateway extends TableGateway
{
    private $forcedToMaster = false;

    /**
     * Constructor
     *
     * @param string $table
     * @param AdapterInterface $adapter
     * @param AbstractFeature|FeatureSet|AbstractFeature[] $features
     * @param ResultSetInterface $resultSetPrototype
     * @param Sql $sql
     * @throws InvalidArgumentException
     */
    public function __construct(
        $table,
        AdapterInterface $adapter,
        $features = null,
        ResultSetInterface $resultSetPrototype = null,
        Sql $sql = null
    )
    {
        // table
        if (!(is_string($table) || $table instanceof TableIdentifier || is_array($table))) {
            throw new InvalidArgumentException('Table name must be a string or an instance of Zend\Db\Sql\TableIdentifier');
        }

        $this->table = $table;

        // adapter
        $this->adapter = $adapter;

        // process features
        if ($features !== null) {
            if ($features instanceof AbstractFeature) {
                $features = array($features);
            }
            if (is_array($features)) {
                $this->featureSet = new FeatureSet($features);
            } elseif ($features instanceof FeatureSet) {
                $this->featureSet = $features;
            } else {
                throw new InvalidArgumentException(
                    'TableGateway expects $feature to be an instance of an AbstractFeature or a FeatureSet, or an array of AbstractFeatures'
                );
            }
        } else {
            $this->featureSet = new FeatureSet();
        }

        // result prototype
        $this->resultSetPrototype = ($resultSetPrototype) ?: new ResultSet;

        // Sql object (factory for select, insert, update, delete)
        $this->sql = new Sql($this->adapter, $this->table);

        // check sql object bound to same table
        if ($this->sql->getTable() != $this->table) {
            throw new InvalidArgumentException('The table inside the provided Sql object must match the table of this TableGateway');
        }

        $this->initialize();
    }

    /**
     * Initialize
     *
     * @throws RuntimeException
     * @return null
     */
    public function initialize()
    {
        if ($this->isInitialized) {
            return;
        }

        if (!$this->featureSet instanceof FeatureSet) {
            $this->featureSet = new FeatureSet;
        }

        $this->featureSet->setTableGateway($this);
        $this->featureSet->apply(EventFeature::EVENT_PRE_INITIALIZE, array());

        if (!$this->adapter instanceof AdapterInterface) {
            throw new RuntimeException('This table does not have an Adapter setup');
        }

        if (!is_string($this->table) && !$this->table instanceof TableIdentifier && !is_array($this->table)) {
            throw new RuntimeException('This table object does not have a valid table set.');
        }

        if (!$this->resultSetPrototype instanceof ResultSetInterface) {
            $this->resultSetPrototype = new ResultSet;
        }

        if (!$this->sql instanceof Sql) {
            $this->sql = new Sql($this->adapter, $this->table);
        }

        $this->featureSet->apply(EventFeature::EVENT_POST_INITIALIZE, array());

        $this->isInitialized = true;
    }

    /**
     * Set TableGateway to execute query to Master
     * @return $this
     * @throws \Exception
     */
    public function forceToMaster()
    {
        $masterSlaveFeature = $this->featureSet->getFeatureByClassName('Zend\Db\TableGateway\Feature\MasterSlaveFeature');
        if (!$masterSlaveFeature) {
            throw new \Exception("Feature: Zend\Db\TableGateway\Feature\MasterSlaveFeature must be enabled to use this function.");
        }

        $this->forcedToMaster = true;
        return $this;
    }

    /**
     * @param Select $select
     * @return ResultSet
     * @throws \Exception
     */
    protected function executeSelect(Select $select)
    {
        $selectState = $select->getRawState();
        if ($selectState['table'] != $this->table && (is_array($selectState['table']) && end($selectState['table']) != $this->table)) {
            throw new \Exception('The table name of the provided select object must match that of the table');
        }

        if ($selectState['columns'] == array(Select::SQL_STAR)
            && $this->columns !== array()) {
            $select->columns($this->columns);
        }

        // check if force to master is enabled
        if ($this->forcedToMaster) {
            $this->featureSet->apply(EventFeature::EVENT_POST_SELECT, array($select));
        } else {
            // apply preSelect features
            $this->featureSet->apply(EventFeature::EVENT_PRE_SELECT, array($select));
        }

        // prepare and execute
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        // build result set
        $resultSet = clone $this->resultSetPrototype;
        $resultSet->initialize($result);

        // apply postSelect features
        $this->featureSet->apply(EventFeature::EVENT_POST_SELECT, array($statement, $result, $resultSet));

        // revert forced to master
        $this->forcedToMaster = false;

        return $resultSet;
    }

    /**
     * @return Sql
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * Use INSERT ... ON DUPLICATE KEY UPDATE Syntax
     * @param array $insertData - data on insert command
     * @param array $updateData - data to use on update on key duplication
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function upsert(array $insertData, array $updateData)
    {
        $sqlStringTemplate = 'INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s';

        /** @var Adapter $adapter */
        $adapter = $this->getAdapter(); /* Get adapter from tableGateway */
        $driver = $adapter->getDriver();
        $platform = $adapter->getPlatform();

        $tableName = $this->table;
        $parameterContainer = new ParameterContainer();
        $statementContainer = $adapter->createStatement();
        $statementContainer->setParameterContainer($parameterContainer);

        /* Preparation insert data */
        $insertQuotedValue = [];
        $insertQuotedColumns = [];
        foreach ($insertData as $column => $value) {
            $insertQuotedValue[] = $driver->formatParameterName($column);
            $insertQuotedColumns[] = $platform->quoteIdentifier($column);
            $parameterContainer->offsetSet($column, $value);
        }

        /* Preparation update data */
        $updateQuotedValue = [];
        foreach ($updateData as $column => $value) {
            $updateQuotedValue[] = $platform->quoteIdentifier($column) . '=' . $driver->formatParameterName('update_' . $column);
            $parameterContainer->offsetSet('update_'.$column, $value);
        }

        /* Preparation sql query */
        $query = sprintf(
            $sqlStringTemplate,
            $tableName,
            implode(',', $insertQuotedColumns),
            implode(',', array_values($insertQuotedValue)),
            implode(',', $updateQuotedValue)
        );

        $statementContainer->setSql($query);
        return $statementContainer->execute();
    }
}