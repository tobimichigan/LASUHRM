<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * ListSorter 
 */
class ListSorter {
	
	const ASCENDING = 'ASC';
	const DESCENDING = 'DESC';
	
	protected $sessionVarName;
	protected $nameSpace;
	protected $sort;
	 
	protected $sortField = null;
	protected $sortOrder = null;
	protected $sortUrl = null;
	
	protected $user;
	
	/** Set via config */ 
	protected $desc_class;
	protected $asc_class;
	protected $default_class;
		 
	/**
	 * Constructor
	 */
	public function __construct($sessionVarName, $nameSpace, $user, $defaultSort) {
	    $this->sessionVarName = $sessionVarName;
	    $this->nameSpace = $nameSpace;	    
	    
	    $sort = $user->getAttribute($sessionVarName, null, $nameSpace);	    
	    $this->sort = is_null($sort) ? $defaultSort : $sort;
	    
	    $this->user = $user;
	    
	    $this->desc_class = sfConfig::get('app_sort_desc_class');
	    $this->asc_class = sfConfig::get('app_sort_asc_class');
	    $this->default_class = sfConfig::get('app_sort_default_class');
	    
	}	

    public function setSort(array $sort) {
        if (!is_null($sort[0]) && is_null($sort[1])) {
            $sort[1] = self::ASCENDING;
        }
        $this->sort = $sort;
        $this->user->setAttribute($this->sessionVarName, $sort, $this->nameSpace);
    }
        
    public function getSort() {
        return $this->sort;
    }
    
	public function sortLink($fieldName, $displayName = null, $url, $attributes = array(),$extraParam = '') {

		$class = $this->default_class;
		$nextOrder = self::ASCENDING;	

		/* Default order to Ascending and change if sorted ascending in current page */		
		if ($this->sort[0] === $fieldName) {
	
		    if ($this->sort[1] === self::ASCENDING) {
		        $nextOrder = self::DESCENDING;
		        $class = $this->asc_class;
			} else if ($this->sort[1] == self::DESCENDING) {
			    $class = $this->desc_class;
			} 
		} 
		$title = empty($displayName) ? $fieldName : $displayName;
		
                $i18n = sfContext::getInstance()->getI18N();
                if ($nextOrder == self::ASCENDING ) {
                    $toolTip = $i18n->__('Sort in Ascending Order');
                } else {
                    $toolTip = $i18n->__('Sort in Descending Order');
                }
                        
                $attributes['title'] = $toolTip;
		$attributes['class'] = $class;
                
                        
                
		$url .= '?sort=' . $fieldName . '&order=' . $nextOrder;	
		if($extraParam !='')
			$url .= '&'.$extraParam;	
		return link_to($title, $url, $attributes);
	}
}
