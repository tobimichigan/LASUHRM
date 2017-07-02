<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * Description of ResourcePermission
 *
 */
class ResourcePermission {
    private $canRead;
    private $canCreate;
    private $canUpdate;
    private $canDelete;
    
    function __construct($canRead, $canCreate, $canUpdate, $canDelete) {
        $this->canRead = $canRead;
        $this->canCreate = $canCreate;
        $this->canUpdate = $canUpdate;
        $this->canDelete = $canDelete;
    }

    public function canRead() {
        return $this->canRead;
    }

    public function canCreate() {
        return $this->canCreate;
    }
    
    public function canUpdate() {
        return $this->canUpdate;
    }

    public function canDelete() {
        return $this->canDelete;
    }
    
    public function andWith(ResourcePermission $permission) {
        $permission = new ResourcePermission($this->canRead() && $permission->canRead(),
                $this->canCreate() && $permission->canCreate(),
                $this->canUpdate() && $permission->canUpdate(),
                $this->canDelete() && $permission->canDelete());
        
        return $permission;
    }

}

