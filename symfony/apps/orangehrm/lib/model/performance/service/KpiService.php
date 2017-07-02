<?php
/* 
 ** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 * 
 */

/**
 * Description of DefineKpiService
 *
 * @author Samantha Jayasinghe
 */
class KpiService extends BaseService {
	
	private $kpiDao ;
	
	
	public function getKpiDao(){
		return $this->kpiDao;	
	}
	
	public function setKpiDao( KpiDao $kpiDao){
		$this->kpiDao	=	$kpiDao ;
	}
	
	/**
     * 
     * Get Kpi for Job Title
     * @return Kpi List
     */
    public function getKpiForJobTitle( $jobTitleId ){
    	try{
	    		    
			$kpiList = $this->getKpiDao()->getKpiForJobTitle( $jobTitleId  );
			
			return $kpiList;
			   
        }catch( Exception $e){
            throw new PerformanceServiceException($e->getMessage());
        }
    }
    
    /**
     * Get KPI List
     * @return unknown_type
     */
    public function getKpiList( $offset=0,$limit=10){
    	try{	
			$kpiList = $this->getKpiDao()->getKpiList($offset,$limit);
			return  $kpiList ;
			
        }catch( Exception $e){
            throw new PerformanceServiceException($e->getMessage());
        }
    }
    
    /**
     * Get KPI count
     * @return unknown_type
     */
    public function getCountKpiList( ){
    	try{
	    	return $this->getKpiDao()->getCountKpiList();
			
        }catch( Exception $e){
            throw new PerformanceServiceException($e->getMessage());
        }
    }
    
	/**
	 * Save Kpi
	 * @return None
	 */
	public function saveKpi(DefineKpi $Kpi) {
		try {
			$this->getKpiDao()->saveKpi( $Kpi );
			if($Kpi->getDefault() == 1)
				$this->getKpiDao()->overRideKpiDefaultRate($Kpi);
			return $Kpi;
        } catch ( Doctrine_Validator_Exception $e ) {
            // propagate validator exceptions
            throw $e;            
		} catch ( Exception $e ) {
			throw new PerformanceServiceException ( $e->getMessage () );
		}
	}
	
	/**
	 * Read Kpi
	 * @param $defineKpiId
	 * @return Array
	 */
	public function readKpi($defineKpiId) {
		try {
			return $this->getKpiDao()->readKpi( $defineKpiId );
		} catch ( Exception $e ) {
			throw new PerformanceServiceException ( $e->getMessage () );
		}
	}
	
	/**
	 * Delete Kpi
	 * @param $DefineKpiList
	 * @return none
	 */
	public function deleteKpi($DefineKpiList) {
		try {
			$this->getKpiDao()->deleteKpi( $DefineKpiList );
			
			return true ;
			
		} catch ( Exception $e ) {
			throw new PerformanceServiceException ( $e->getMessage () );
		}
	}
	
	/**
	 * Get Kpi default rating scale
	 * 
	 * @return Array
	 */
	public function getKpiDefaultRate() {
		
		$defaultRate	=	array();
		try {
			
			$defaultRate = $this->getKpiDao()->getKpiDefaultRate();
			return $defaultRate;
			
		} catch ( Exception $e ) {
			throw new PerformanceServiceException ( $e->getMessage () );
		}
		
	}
	
	
	/**
	 * overrides kpi default rating scale
	 * 
	 * @return Array
	 */
	private function overRideKpiDefaultRate( DefineKpi $Kpi) {
		try {
			
			$this->getKpiDao()->overRideKpiDefaultRate($Kpi);
			
			return true ;
			
		} catch ( Exception $e ) {
			throw new PerformanceServiceException ( $e->getMessage () );
		}
	}
	
	/**
	 * Save all defined kpi's from selected Job Title
	 * @param $jobTitleId
	 * @param $copiedKpis
	 * @return None
	 */
	public function copyKpi( $toJobTitle , $fromJobTitle)
	{
		try {
			$this->getKpiDao()->deleteKpiForJobTitle( $toJobTitle);
			
			$kpiList	=	$this->getKpiForJobTitle( $fromJobTitle );
			
			foreach( $kpiList as $fromKpi){
				$kpi	=	new DefineKpi ( );
				$kpi->setJobtitlecode ( $toJobTitle );
				$kpi->setDesc ( $fromKpi->getDesc() );
				$kpi->setMin ( $fromKpi->getMin() );
				$kpi->setMax ( $fromKpi->getMax() );
				$kpi->setDefault ( 0 );
				$kpi->setIsactive ( 1 );
				$this->saveKpi($kpi);
			}
			return true ;
		}catch ( Exception $e ) {
			throw new PerformanceServiceException ( $e->getMessage () );
		}
	}
}