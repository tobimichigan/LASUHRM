<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmploymentStatusDao extends BaseDao {

	/**
	 *
	 * @return type 
	 */
	public function getEmploymentStatusList() {

		try {
			$q = Doctrine_Query :: create()
				->from('EmploymentStatus')
				->orderBy('name ASC');
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}
	
	/**
	 *
	 * @param type $id
	 * @return type 
	 */
	public function getEmploymentStatusById($id) {

		try {
			return Doctrine :: getTable('EmploymentStatus')->find($id);
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}
}

