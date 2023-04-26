<?php
namespace Site\Model;

/**
 * Class AbstractTable
 * @package Dri\Lib\Cart\Model
 */
class AbstractTable
{
    /**
     * @param $row_fields
     * @param $rec_values
     */
    public function insertRows($row_fields, $rec_values)
    {
        if (sizeof($row_fields) > 0 && sizeof($rec_values) > 0) {

            $tmp_values = '';
            $str_row_fields = '';
            $str_row_values = '';
            $records = array();

            // convert array $row_fields to string row fields
            $str_row_fields = implode(", ", $row_fields);

            for ($i=0; $i < sizeof($row_fields); $i++) {
                $tmp_values .= ($tmp_values ? ", " : "") . "?";
            }

            foreach ($rec_values as $record) {
                $str_row_values .= ($str_row_values ? "," : ""). "({$tmp_values})";
                $records = array_merge($records, $record);
            }

            // construct insert query
            $query = "INSERT INTO {$this->tableGateway->getTable()} ({$str_row_fields}) VALUES {$str_row_values}";

            // prepare query
            $adapter = $this->tableGateway->getAdapter();

            $adapter->query($query, $records);
        }
    }

    public function forceToMaster()
    {
        if (!$this->tableGateway instanceof AbstractTableGateway) {
            throw new \Exception("TableGateway must be an instance of " . AbstractTableGateway::class);
        }
        $this->tableGateway->forceToMaster();
    }
}