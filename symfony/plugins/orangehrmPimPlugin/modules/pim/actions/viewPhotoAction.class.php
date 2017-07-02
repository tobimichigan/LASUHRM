<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
/**
 * Displays Employee Photo
 *
 */
class viewPhotoAction extends basePimAction {

    private $employeeService;

    /**
     * Get EmployeeService
     * @returns EmployeeService
     */
    public function getEmployeeService() {
        if(is_null($this->employeeService)) {
            $this->employeeService = new EmployeeService();
            $this->employeeService->setEmployeeDao(new EmployeeDao());
        }
        return $this->employeeService;
    }

    /**
     * Set EmployeeService
     * @param EmployeeService $employeeService
     */
    public function setEmployeeService(EmployeeService $employeeService) {
        $this->employeeService = $employeeService;
    }
    
    public function execute($request) {
        $empNumber = $request->getParameter('empNumber');

        $employeeService = $this->getEmployeeService();
        $empPicture = $employeeService->getEmployeePicture($empNumber);

        $this->photographPermissions = $this->getDataGroupPermissions('photograph', $empNumber);
        if ((!empty($empPicture)) && ($this->photographPermissions->canRead())) {
            $contents = $empPicture->picture;
            $contentType = $empPicture->file_type;
            $fileSize = $empPicture->size;
            $fileName = $empPicture->filename;
        } else {
            $tmpName = ROOT_PATH . '/symfony/web/themes/' . $this->_getThemeName() . '/images/default-photo.png';
            $fp = fopen($tmpName,'r');
            $fileSize = filesize($tmpName);
            $contents = fread($fp, $fileSize);
            $contentType = "image/gif";
            fclose($fp);
        }
        
        $checksum = md5($contents);
        
        // Allow client side cache image unless image checksum changes.
        $eTag = $request->getHttpHeader('If-None-Match');
        
        $response = $this->getResponse();

        if ($eTag == $checksum) {
            $response->setStatusCode('304');
        } else {
            $response->setContentType($contentType);
            $response->setContent($contents);            
        }
        
        // Setting "Pragra" header to null does not prevent it being added automatically
        // Therefore, we set this to "Public" to override "Pragma: no-cache" added because of settings in factory.yml        
        $response->setHttpHeader('Pragma', 'Public');
        
        $response->setHttpHeader('ETag', $checksum);        
        $response->addCacheControlHttpHeader('public, max-age=0, must-revalidate');            
            
        $response->send();

        return sfView::NONE;
    }
    
    protected function _getThemeName() {
        
        $sfUser = $this->getUser();

        if (!$sfUser->hasAttribute('meta.themeName')) {
            $sfUser->setAttribute('meta.themeName', OrangeConfig::getInstance()->getAppConfValue(ConfigService::KEY_THEME_NAME));
        }

        return $sfUser->getAttribute('meta.themeName');     
        
    }
    
    
}