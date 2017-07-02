<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class PerformanceKpi{
	
		public $id ;
		public $kpi;
        public $minRate ;
        public $maxRate;
        public $rate ;
		public $comment;

        
        function __construct() {
        }

        public function getId()
        {
        	return $this->id;
        }
        
        public function setId( $id)
        {
        	$this->id	=	$id ;
        }
        
        public function getKpi() {
            return $this->kpi;
        }

        public function setKpi($kpi) {
            $this->kpi = $kpi;
        }

        public function getMinRate() {
            return $this->minRate;
        }

        public function setMinRate($minRate) {
            $this->minRate = $minRate;
        }

        public function getMaxRate() {
            return $this->maxRate;
        }

        public function setMaxRate($maxRate) {
            $this->maxRate = $maxRate;
        }

        public function getRate() {
            return $this->rate;
        }

        public function setRate($rate) {
            $this->rate = $rate;
        }

        public function getComment() {
            return $this->comment;
        }

        public function setComment($comment) {
            $this->comment = htmlspecialchars($comment);
        }

       

}