<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class LocationDao extends BaseDao {

	/**
	 *
	 * @param type $locationId
	 * @return type 
	 */
	public function getLocationById($locationId) {

		try {
			return Doctrine :: getTable('Location')->find($locationId);
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	/**
	 *
	 * @param type $srchClues
	 * @return type 
	 */
	public function getSearchLocationListCount($srchClues) {

		try {
			$q = $this->_buildSearchQuery($srchClues);
			return $q->count();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	/**
	 *
	 * @param type $srchClues
	 * @return type 
	 */
	public function searchLocations($srchClues) {

                if (!isset($srchClues['sortField'])) {
                    $srchClues['sortField'] = 'name';
                }
                
                if (!isset($srchClues['sortOrder'])) {
                    $srchClues['sortOrder'] = 'ASC';
                }
                
                if (!isset($srchClues['offset'])) {
                    $srchClues['offset'] = 0;
                }
                
                if (!isset($srchClues['limit'])) {
                    $srchClues['limit'] = 50;
                }
                
		$sortField = $this->_getSortField($srchClues['sortField']);
		$sortOrder = ($srchClues['sortOrder'] == "") ? 'ASC' : $srchClues['sortOrder'];
		$offset = ($srchClues['offset'] == "") ? 0 : $srchClues['offset'];
		$limit = ($srchClues['limit'] == "") ? 50 : $srchClues['limit'];

		try {
			$q = $this->_buildSearchQuery($srchClues);            
			$q->orderBy($sortField . ' ' . $sortOrder)
				->offset($offset)
				->limit($limit);                        
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	/**
	 *
	 * @param type $srchClues
	 * @return type 
	 */
	private function _buildSearchQuery($srchClues) {

		$q = Doctrine_Query::create()
                ->select('l.* , IFNULL( Count(el.emp_number),0 ) as numberOfEmployees')
                ->from('Location l')
                ->leftJoin('l.country c')
                ->leftJoin('l.EmpLocations el');

        if (!empty($srchClues['name'])) {
            $q->addWhere('l.name LIKE ?', "%" . trim($srchClues['name']) . "%");
        }
        if (!empty($srchClues['city'])) {
            $q->addWhere('l.city LIKE ?', "%" . trim($srchClues['city']) . "%");
        }
        if (!empty($srchClues['country'])) {
            if (is_array($srchClues['country'])) {
                $q->andWhereIn('l.country_code', $srchClues['country']);
            } else {
                $q->addWhere('l.country_code = ?', $srchClues['country']);
            }
        }
        $q->groupBy('l.id');
        return $q;
	}

	/**
	 *
	 * @param type $locationId
	 * @return type 
	 */
	public function getNumberOfEmplyeesForLocation($locationId) {

		try {
			$q = Doctrine_Query :: create()
				->from('EmpLocations')
				->where('location_id = ?', $locationId);
			return $q->count();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	/**
	 *
	 * @return type 
	 */
	public function getLocationList() {
		
		try {
			$q = Doctrine_Query :: create()
				->from('Location l')
                                ->orderBy('l.name ASC');
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}
    
    /**
     * Returns corresponding sort field
     * 
     * @version 2.7.1
     * @param string $sortFieldName 
     * @return string 
     */
    private function _getSortField($sortFieldName){
        
        $sortField = 'l.name';
        if($sortFieldName === 'name') {
            $sortField = 'l.name';
        } else if ($sortFieldName === 'countryName') {
            $sortField = 'c.name';        
        } else if ($sortFieldName === 'city') {
            $sortField = 'l.city';
        } else if ($sortFieldName === 'numberOfEmployees') {
            $sortField = 'numberOfEmployees';
        } 
        
        return $sortField;
        
    }
}

?>
