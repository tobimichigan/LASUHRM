<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */
class SimplePager extends sfPager implements Serializable {


  protected $results;

  protected $offset;

  public function __construct($class, $maxPerPage = 10) {
    parent::__construct($class, $maxPerPage);
    $this->offset = null;
  }

  public function setResults($results) {
    $this->results = $results;
  }

  public function setNumResults($count) {
      $this->setNbResults($count);
  }
  
  public function getNumResults(){
  		return $this->getNbResults();
  }

  // function to be called after parameters have been set
  public function init() {

    if ($this->getPage() == 0 || $this->getMaxPerPage() == 0 || $this->getNbResults() == 0) {
      $this->setLastPage(0);
    } else {
      $this->offset = ($this->getPage() - 1) * $this->getMaxPerPage();
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

    }
  }

  public function getOffset() {
      return $this->offset;
  }

  // main method: returns an array of result on the given page
  public function getResults() {
    return $results;
  }


  // used internally by getCurrent()
  protected function retrieveObject($offset) {
    return false;
  }

  /**
   * Serialize the pager object
   *
   * @return string $serialized
   */
  public function serialize() {
    $vars = get_object_vars($this);
    unset($vars['query']);
    return serialize($vars);
  }

  /**
   * Unserialize a pager object
   *
   * @param string $serialized
   * @return void
   */
  public function unserialize($serialized) {
    $array = unserialize($serialized);

    foreach($array as $name => $values)
    {
      $this->$name = $values;
    }
  }

}