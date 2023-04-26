<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Site;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sm = $e->getApplication()->getServiceManager();
        $siteConfig = $sm->get('Configuration');
        $sm->setAllowOverride(true);
        $sm->setService('Site_Config', $siteConfig);
        $sm->setAllowOverride(false);
    }

    public function getConfig()
    {
        $config = array();

        // get config files
        $config_files = array(
            __DIR__ . '/../config/module.config.php',
            __DIR__ . '/../config/module.config.routes.php',
            __DIR__ . '/../config/module.config.services.php',
            __DIR__ . '/../config/module.config.templates.php',
            __DIR__ . '/../config/module.config.view-helpers.php',
        );

        // Merge all module config options
        foreach($config_files as $config_file) {
            $config = ArrayUtils::merge($config, include $config_file);
        }

        return $config;
    }
}
