<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 *
 */

/**
 * Description of LeaveEvents
 */
class LeaveEvents {
    const ENTITLEMENT_ADD = 'leave_entitlement_add';
    const ENTITLEMENT_UPDATE = 'leave_entitlement_update';
    const ENTITLEMENT_BULK_ADD = 'leave_entitlement_bulk_update';
    const LEAVE_TYPE_ADD = 'leave_type_add';
    const LEAVE_TYPE_UPDATE = 'leave_type_update';
    
    const LEAVE_APPROVE = 'leave.approve';
    const LEAVE_CANCEL = 'leave.cancel';
    const LEAVE_REJECT = 'leave.reject';
    const LEAVE_ASSIGN = 'leave.assign';
    const LEAVE_APPLY = 'leave.apply';
    const LEAVE_CHANGE = 'leave.change';
}