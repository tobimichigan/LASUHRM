<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class WorkShiftDao extends BaseDao {

    /**
     *
     * @return type 
     */
    public function getWorkShiftList() {

        try {
            $q = Doctrine_Query :: create()
                    ->from('WorkShift')
                    ->orderBy('name ASC');
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getWorkShiftById($workShiftId) {

        try {
            return Doctrine :: getTable('WorkShift')->find($workShiftId);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getWorkShiftEmployeeListById($workShiftId) {

        try {
            $q = Doctrine_Query :: create()
                    ->from('EmployeeWorkShift')
                    ->where('work_shift_id = ?', $workShiftId);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getWorkShiftEmployeeNameListById($workShiftId) {

        try {
            $q = Doctrine_Query :: create()
                    ->select('w.emp_number as empNumber, e.firstName as firstName, e.lastName as lastName, e.middleName as middleName')
                    ->from('EmployeeWorkShift w')
                    ->leftJoin('w.Employee e')
                    ->where('work_shift_id = ?', $workShiftId);

            $employeeNames = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);

            return $employeeNames;

            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

    public function getWorkShiftEmployeeList() {

        try {
            $q = Doctrine_Query :: create()
                    ->from('EmployeeWorkShift');
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function getWorkShiftEmployeeIdList() {

        try {
            $q = Doctrine_Query :: create()
                    ->select('emp_number')
                    ->from('EmployeeWorkShift');

            $employeeIds = $q->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);

            if (is_string($employeeIds)) {
                $employeeIds = array($employeeIds);
            }

            return $employeeIds;

            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

    public function updateWorkShift(WorkShift $workShift) {

		try {
			$q = Doctrine_Query:: create()->update('WorkShift')
				->set('name', '?', $workShift->name)
				->set('hours_per_day', '?', $workShift->hoursPerDay)
                                ->set('start_time', '?', $workShift->getStartTime())
                                ->set('end_time', '?', $workShift->getEndTime())
				->where('id = ?', $workShift->id);
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
    }

    public function saveEmployeeWorkShiftCollection(Doctrine_Collection $empWorkShiftCollection) {
        try {

            $empWorkShiftCollection->save();

            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

}

?>
