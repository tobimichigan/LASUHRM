<?php

/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class CustomerDao extends BaseDao {

    /**
     *
     * @param type $limit
     * @param type $offset
     * @param type $sortField
     * @param type $sortOrder
     * @param type $activeOnly
     * @return type 
     */
    public function getCustomerList($limit = 50, $offset = 0, $sortField = 'name', $sortOrder = 'ASC', $activeOnly = true) {

        $sortField = ($sortField == "") ? 'name' : $sortField;
        $sortOrder = ($sortOrder == "") ? 'ASC' : $sortOrder;

        try {
            $q = Doctrine_Query :: create()
                    ->from('Customer');
            if ($activeOnly == true) {
                $q->addWhere('is_deleted = 0');
            }
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
     * @param type $activeOnly
     * @return type 
     */
    public function getCustomerCount($activeOnly = true) {

        try {
            $q = Doctrine_Query :: create()
                    ->from('Customer');
            if ($activeOnly == true) {
                $q->addWhere('is_deleted = ?', 0);
            }
            $count = $q->execute()->count();
            return $count;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param type $customerId
     * @return type 
     */
    public function getCustomerById($customerId) {

        try {
            return Doctrine :: getTable('Customer')->find($customerId);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param type $customerId 
     */
    public function deleteCustomer($customerId) {

        try {
            $customer = Doctrine :: getTable('Customer')->find($customerId);
            $customer->setIsDeleted(Customer::DELETED);
            $customer->save();
            $this->_deleteRelativeProjectsForCustomer($customerId);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    public function undeleteCustomer($customerId) {

        try {
            $customer = Doctrine :: getTable('Customer')->find($customerId);
            $customer->setIsDeleted(Customer::ACTIVE);
            $customer->save();
            $this->_undeleteRelativeProjectsForCustomer($customerId);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    private function _deleteRelativeProjectsForCustomer($customerId) {

        try {
            $q = Doctrine_Query :: create()
                    ->from('Project')
                    ->where('is_deleted = ?', Project::ACTIVE_PROJECT)
                    ->andWhere('customer_id = ?', $customerId);
            $projects = $q->execute();

            foreach ($projects as $project) {
                $project->setIsDeleted(Project::DELETED_PROJECT);
                $project->save();
                $this->_deleteRelativeProjectActivitiesForProject($project->getProjectId());
                $this->_deleteRelativeProjectAdminsForProject($project->getProjectId());
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    private function _undeleteRelativeProjectsForCustomer($customerId) {

        try {
            $q = Doctrine_Query :: create()
                    ->from('Project')
                    ->where('is_deleted = ?', Project::DELETED_PROJECT)
                    ->andWhere('customer_id = ?', $customerId);
            $projects = $q->execute();

            foreach ($projects as $project) {
                $project->setIsDeleted(Project::ACTIVE_PROJECT);
                $project->save();
                $this->_undeleteRelativeProjectActivitiesForProject($project->getProjectId());
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    private function _deleteRelativeProjectActivitiesForProject($projectId) {

        try {
            $q = Doctrine_Query :: create()
                    ->from('ProjectActivity')
                    ->where('is_deleted = ?', ProjectActivity::ACTIVE_PROJECT_ACTIVITY)
                    ->andWhere('project_id = ?', $projectId);
            $projectActivities = $q->execute();

            foreach ($projectActivities as $projectActivity) {
                $projectActivity->setIsDeleted(ProjectActivity::DELETED_PROJECT_ACTIVITY);
                $projectActivity->save();
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    private function _undeleteRelativeProjectActivitiesForProject($projectId) {

        try {
            $q = Doctrine_Query :: create()
                    ->from('ProjectActivity')
                    ->where('is_deleted = ?', ProjectActivity::DELETED_PROJECT_ACTIVITY)
                    ->andWhere('project_id = ?', $projectId);
            $projectActivities = $q->execute();

            foreach ($projectActivities as $projectActivity) {
                $projectActivity->setIsDeleted(ProjectActivity::ACTIVE_PROJECT_ACTIVITY);
                $projectActivity->save();
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    private function _deleteRelativeProjectAdminsForProject($projectId) {

        try {
            $q = Doctrine_Query :: create()
                    ->delete('ProjectAdmin pa')
                    ->where('pa.project_id = ?', $projectId);
            $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *
     * @param type $activeOnly
     * @return type 
     */
    public function getAllCustomers($activeOnly = true) {

        try {
            $q = Doctrine_Query :: create()
                    ->from('Customer');
            if ($activeOnly == true) {
                $q->where('is_deleted =?', 0);
            }
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Return an array of Customer Names
     * 
     * @version 2.7.1
     * @param Array $customerIdList List of Customer Ids
     * @param Boolean $excludeDeletedCustomers Exclude deleted Customers or not
     * @return Array of Customer Names
     */
    public function getCustomerNameList($customerIdList, $excludeDeletedCustomers = true) {

        try {

            if (!empty($customerIdList)) {

                $customerIdString = implode(',', $customerIdList);

                $q = "SELECT c.customer_id AS customerId, c.name
                		FROM ohrm_customer AS c
                		WHERE c.customer_id IN ({$customerIdString})";

                if ($excludeDeletedCustomers) {
                    $q .= ' AND c.is_deleted = 0';
                }

                $pdo = Doctrine_Manager::connection()->getDbh();
                $query = $pdo->prepare($q);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
            }

            return $results;

            // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     *
     * @param type $customerId
     * @return type 
     */
    public function hasCustomerGotTimesheetItems($customerId) {

        try {
            $q = Doctrine_Query :: create()
                    ->select("COUNT(*)")
                    ->from('TimesheetItem ti')
                    ->leftJoin('ti.Project p')
                    ->leftJoin('p.Customer c')
                    ->where('c.customerId = ?', $customerId);
            $count = $q->fetchOne(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
            return ($count > 0);
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}

?>