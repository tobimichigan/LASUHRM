<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class JobCategoryDao extends BaseDao {
	
	/**
	 *
	 * @return type 
	 */
	public function getJobCategoryList() {

		try {
			$q = Doctrine_Query :: create()
				->from('JobCategory')
				->orderBy('name ASC');
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}
	
	public function getJobCategoryById($jobCatId){
		
		try {
			return Doctrine :: getTable('JobCategory')->find($jobCatId);
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}
}

?>
