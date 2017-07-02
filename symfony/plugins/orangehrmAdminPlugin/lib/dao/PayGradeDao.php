<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class PayGradeDao extends BaseDao {

	/**
	 *
	 * @param type $payGradeId
	 * @return type 
	 */
	public function getPayGradeById($payGradeId) {

		try {
			return Doctrine :: getTable('PayGrade')->find($payGradeId);
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	/**
	 *
	 * @return type 
	 */
	public function getPayGradeList($sortField='name', $sortOrder='ASC') {

		$sortField = ($sortField == "") ? 'name' : $sortField;
		$sortOrder = ($sortOrder == "") ? 'ASC' : $sortOrder;

		try {
			$q = Doctrine_Query :: create()
				->from('PayGrade')
				->orderBy($sortField . ' ' . $sortOrder);
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getCurrencyListByPayGradeId($payGradeId) {

		try {
			$q = Doctrine_Query :: create()
				->from('PayGradeCurrency pgc')
                                ->leftJoin('pgc.CurrencyType ct')
				->where('pgc.pay_grade_id = ?', $payGradeId)
                                ->orderBy('ct.currency_name ASC');
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getCurrencyByCurrencyIdAndPayGradeId($currencyId, $payGradeId) {

		try {
			$q = Doctrine_Query :: create()
				->from('PayGradeCurrency')
				->where('pay_grade_id = ?', $payGradeId)
				->andWhere('currency_id = ?', $currencyId);
			return $q->fetchOne();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

}

?>
