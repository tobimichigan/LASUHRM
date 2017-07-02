<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class EmailNotificationDao extends BaseDao {

	public function getEmailNotificationList() {
		try {
			$q = Doctrine_Query :: create()
				->from('EmailNotification');
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}
        
	public function getEmailNotification($id) {
		try {
			$q = Doctrine_Query :: create()
				->from('EmailNotification')
                                ->where('id = ?', $id);
			return $q->fetchOne();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}        

	public function updateEmailNotification($toBeEnabledIds) {
		try {
			$this->disableEmailNotification($toBeEnabledIds);				
			if (!empty($toBeEnabledIds)) {
				$this->enableEmailNotification($toBeEnabledIds);
			}
			return true;
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	private function disableEmailNotification($toBeEnabledIds) {
		try {
			$q = Doctrine_Query :: create()->update('EmailNotification')
				->set('isEnable', '?', EmailNotification::DISABLED);
			if (!empty($toBeEnabledIds)) {
				$q->whereNotIn('id', $toBeEnabledIds);
			}
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	private function enableEmailNotification($toBeEnabledIds) {
		try {
			$q = Doctrine_Query :: create()->update('EmailNotification')
				->set('isEnable', '?', EmailNotification::ENABLED)
				->whereIn('id', $toBeEnabledIds);
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getEnabledEmailNotificationIdList() {
		try {
			$q = Doctrine_Query :: create()->select('id')
				->from('EmailNotification')
				->where('isEnable = ?', EmailNotification::ENABLED);
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getSubscribersByNotificationId($emailNotificationId) {
		try {
			$q = Doctrine_Query :: create()
				->from('EmailSubscriber')
				->where('notificationId = ?', $emailNotificationId)
				->orderBy('name ASC');
			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function getSubscriberById($subscriberId) {

		try {
			return Doctrine :: getTable('EmailSubscriber')->find($subscriberId);
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

	public function deleteSubscribers($subscriberIdList) {
		try {
			$q = Doctrine_Query::create()
				->delete('EmailSubscriber')
				->whereIn('id', $subscriberIdList);

			return $q->execute();
		} catch (Exception $e) {
			throw new DaoException($e->getMessage());
		}
	}

}

