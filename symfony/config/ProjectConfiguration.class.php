<?php

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__FILE__) . '/../../');
}
require_once dirname(__FILE__) . '/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
require_once dirname(__FILE__) . '/../lib/vendor/log4php/Logger.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
    $this->enableAllPluginsExcept(array());

    // Set up logging - use different config for test environment
    $logConfig = (sfConfig::get('sf_environment') == 'test') ? 'log4php_test.properties' : 'log4php.properties';

    Logger::configure(dirname(__FILE__) . '/' . $logConfig, 'OrangeHRMLogConfigurator');
    
    // set up resource dir
    $resourceIncFile = dirname(__FILE__) . '/../web/resource_dir_inc.php';
    
    if (file_exists($resourceIncFile)) {
        require_once $resourceIncFile;
    } else {
        sfConfig::set('ohrm_resource_dir', sfConfig::get('sf_web_dir'));
    }
  }
  
  public function configureDoctrine(Doctrine_Manager $manager)
  {
    // Enable callbacks so that softDelete behavior can be used
    $manager->setAttribute(Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true);
  }
}
