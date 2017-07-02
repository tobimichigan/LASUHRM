<?php

/** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

class CustomFieldConfigurationDao extends BaseDao {

    /**
     * Retrieve Custom Fields
     * @param String $orderField
     * @param String $orderBy
     * @returns Collection
     * @throws DaoException
     */
    public function getCustomFieldList($screen = null, $orderField = "name", $orderBy = "ASC") {
        
        try {
            
            $q = Doctrine_Query::create()
                            ->from('CustomField');

            if (!empty($screen)) {
                $q->where('screen = ?', $screen);
            }

            $q->orderBy($orderField . ' ' . $orderBy);

            return $q->execute();
            
        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
        
    }

    /**
     * Save CustomField
     * @param CustomField $customField
     * @returns CustomField
     * @throws DaoException, DataDuplicationException
     */
    public function saveCustomField(CustomField $customField) {
        
        try {
            
            $q = Doctrine_Query::create()
                            ->from('CustomField c')
                            ->where('c.name = ?', $customField->name)
                            ->andWhere('c.id <> ?', $customField->id);

            $freeNum = null;

            if (empty($customField->id)) {
                
                $q = Doctrine_Query::create()
                                ->select('c.field_num')
                                ->from('CustomField c')
                                ->orderBy('id');
                
                $fieldNumbers = $q->execute(array(), Doctrine::HYDRATE_SCALAR);
                $count = count($fieldNumbers);

                $i = 1;
                foreach ($fieldNumbers as $num) {

                    if ($num['c_id'] > $i) {
                        $freeNum = $i;
                        break;
                    }
                    $i++;

                    if ($i > 10) {
                        break;
                    }
                    
                }

                if (empty($freeNum) && ($i <= 10)) {
                    $freeNum = $i;
                }

                $customField->id = $freeNum;
                
            }

            if (!empty($customField->id)) {
                $customField->save();
            }

            return $customField;

        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
        
    }

    /**
     * Delete CustomField
     * @param array() $customFieldList
     * @returns integer
     * @throws DaoException
     */
    public function deleteCustomFields($customFieldIdList) {
        
        try {
            
            if (!is_array($customFieldIdList) || empty($customFieldIdList)) {
                throw new DaoException('Invalid parameter: $customFieldList should be an array and should not be empty');
            }            
            
            $this->_deleteReletedEmployeeCustomFields($customFieldIdList);

            $q = Doctrine_Query::create()
                            ->delete('CustomField')
                            ->whereIn('id', $customFieldIdList);

            return $q->execute();
            
        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
        
    }

    private function _deleteReletedEmployeeCustomFields($customFieldIdList) {

        try {
            
            $rows = 0;
            
            foreach ($customFieldIdList as $id) {
                
                $actualFieldName = "custom" . $id;

                $q = Doctrine_Query::create()
                                ->update('Employee')
                                ->set($actualFieldName, '?', '');

                $rows += $q->execute();
                
            }
            
            return $rows;
            
        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Returns CustomField by Id
     * @param int $id
     * @returns CustomField
     * @throws DaoException
     */
    public function getCustomField($id) {
        
        try {
            
            $result = Doctrine::getTable('CustomField')->find($id);
            
            if (!$result) {
                return null;
            }
            
            return $result;
            
        // @codeCoverageIgnoreStart
        } catch (Exception $e) {
            throw new DaoException($e->getMessage(), $e->getCode(), $e);
        }
        // @codeCoverageIgnoreEnd
        
    }

    
    
}
