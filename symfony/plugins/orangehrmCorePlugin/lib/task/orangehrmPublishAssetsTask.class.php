<?php
/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class orangehrmPublishAssetsTask extends sfBaseTask {
    
    const RESOURCE_DIR_PREFIX = 'webres_';
    const RESOURCE_DIR_INC_FILE = 'resource_dir_inc.php';
    
    protected $resourceDir;
    
    protected function configure() {
        $this->namespace = 'orangehrm';
        $this->name = 'publish-assets';

        $this->briefDescription = 'Publishes web assets of OrangeHRM plugins (copy -> no symlinks)';

        $this->detailedDescription = <<<EOF
The [plugin:publish-assets|INFO] Task will publish web assets of OrangeHRM plugins.

  [./symfony orangehrm:publish-assets|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {
        //only enabled plugins are here
        $plugins    = $this->configuration->getAllPluginPaths();

        // delete old resource directory:
        $oldResourceDirs = sfFinder::type('directory')->name(self::RESOURCE_DIR_PREFIX . '*')
                ->maxdepth(0)->in(sfConfig::get('sf_web_dir'));
        
        foreach ($oldResourceDirs as $oldResourceDir) {
            $this->directoryRecursiveDelete($oldResourceDir);
        }
        
        $uniqueResourceDir = uniqid('webres_', true);
        
        $this->resourceDir = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . $uniqueResourceDir;        
        mkdir($this->resourceDir);
        
        //check for enabled plugins
        foreach ($this->configuration->getPlugins() as $plugin)
        if (stripos($plugin, 'orangehrm') !== FALSE) {
            $pluginPath = $plugins[$plugin];
            $this->logSection('orangehrm', 'Publishing assets for plugin - ' . $pluginPath);
            $this->copyWebAssets($plugin, $pluginPath);
        }
        
        // Copy main resources
        $symfonyWeb = sfConfig::get('sf_web_dir');

        $toCopy = array('images', 'js', 'themes');
        
        foreach ($toCopy as $dir) {
            $this->logSection('orangehrm', 'Mirroring ' . $dir . ' to ' . $uniqueResourceDir . DIRECTORY_SEPARATOR . $dir);
            $this->mirrorDir($symfonyWeb . DIRECTORY_SEPARATOR . $dir, 
                    $this->resourceDir. DIRECTORY_SEPARATOR . $dir);            
        }
        
        // update resource dir in php file
        $resourceIncFile = sfConfig::get('sf_web_dir') . DIRECTORY_SEPARATOR . self::RESOURCE_DIR_INC_FILE;
        $fp = @fopen($resourceIncFile, 'w');

        if ($fp === false) {
            throw new Doctrine_Compiler_Exception("Couldn't write resource inc file data. Failed to open $resourceIncFile");
        }
        
        $propertiesToSet = array(
            'sf_web_css_dir_name' => $uniqueResourceDir .  '/css',
            'sf_web_js_dir_name' => $uniqueResourceDir . '/js',
            'sf_web_images_dir_name' => $uniqueResourceDir . '/images',
            );
        
        $content = "<?php \n";
        
        foreach ($propertiesToSet as $key => $value) {
            $content .= "sfConfig::set('$key','$value');\n";
        }
        
        $content .= "sfConfig::set('ohrm_resource_dir', '" . $uniqueResourceDir . "');";
        

        fwrite($fp, $content);
        fclose($fp);        
    }

    private function copyWebAssets($plugin, $dir) {
        $webDir = $dir.DIRECTORY_SEPARATOR.'web';

        
        if (is_dir($webDir)) {
            $this->mirrorDir($webDir, $this->resourceDir.DIRECTORY_SEPARATOR.$plugin);
        }
        return;
    }
    
    private function mirrorDir($src, $dest) {
        $finder = sfFinder::type('any');
        $filesystem = new sfFilesystem();                    
        $filesystem->mirror($src, $dest, $finder);        
    }

    private function directoryRecursiveDelete($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                 if (filetype($dir."/".$object) == "dir") $this->directoryRecursiveDelete($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
?>
