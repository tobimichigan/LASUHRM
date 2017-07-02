<?php
/*** LASUHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for the Academic/Non Academic Staff Establishments of Lagos State University respectively . This Software has been tested on a remote server and is capable of encapsulating large information of the Lagos State University staff.
 * Copyright (C) 1983-2014 LASUHRM., http://www.lasu.edu.ng. Software Developed and re-engineered by OWOEYE OLUWATOBI MICHAEL, BSc. Computer Science.
 *
 *
 */

/**
 * SchedulerService class - execute all the schedulers in the system through Scheduler Service
 *
 * $schedulerService = new SchedulerService();
 * $schedulerService->addSchedule(array('className', 'methodName', array(param1, param2, param3)));
 * $schedulerService->run();
 *
 * @author Priyantha Gunawardena
 *
 */

class SchedulerService
{


    private $scheduleCollector = array(); // collect all teh schedules added by the user

    const SCHEDULE_TRACK_START = 'start';
    const SCHEDULE_TRACK_FINISHED = 'finished';
    const SCHEDULE_TRACK_ERROR = 'error';
    const SCHEDULE_TRACK_SUCCESS = 'success';

    private $classObject = null;
    private $method = '';
    private $params = array();
    
    private $logger;
    
    /**
     * Get Logger instance. Creates if not already created.
     *
     * @return Logger
     */
    protected function getLogger() {
        if (is_null($this->logger)) {
            $this->logger = Logger::getLogger('core.SchedulerService');
        }

        return($this->logger);
    }
    
    /**
     * Public method for the user to add his chedule
     * @param string $className
     * @param string $methodName
     * @param array $params
     */
    public function addSchedule($className, $methodName, $params=array())
    {
        $this->scheduleCollector[] = array("class" => $className, "method"=>$methodName, "params" => $params);
    }

    /**
     * Run all the schedules
     * @return void
     */
    public function run()
    {
        try
        {
            foreach($this->scheduleCollector as $schedule)
            {
                $this->logSchedule($schedule, self::SCHEDULE_TRACK_START);
                if($this->isValidSchedule($schedule))
                {
                    //call the scheduler
                    call_user_func_array(array($this->classObject, $this->method), $this->params);
                    $this->logSchedule($schedule, self::SCHEDULE_TRACK_SUCCESS);
                }
                else
                {
                    $this->logSchedule($schedule, self::SCHEDULE_TRACK_ERROR);
                    return false;
                }
                $this->logSchedule($schedule, self::SCHEDULE_TRACK_FINISHED);
            }
            return true;
        }
        catch(Exception $e)
        {
            $this->logSchedule($schedule, self::SCHEDULE_TRACK_ERROR, "Could not execute the schedule".$e->getMessage());
            return false;
        }

    }

    /**
     * Validate the given scheduler
     * @param array $schedule
     * @return boolean
     */
    private function isValidSchedule($schedule)
    {

        $class = $schedule['class'];
        $method = $schedule['method'];
        $params = $schedule['params'];

        // check whether the class is exist
        if(class_exists($class))
        {
            $this->classObject = new $class;

            // check whether the method if exist
            if(!is_callable(array($this->classObject, $method)))
            {
                $this->logSchedule($schedule, self::SCHEDULE_TRACK_ERROR, 'Method not found');
                return false;
            }

        }else
        {
            $this->logSchedule($schedule, self::SCHEDULE_TRACK_ERROR, 'Class not found');
            return false;

        }

        $this->method = $method;
        $this->params = $params;
        return true;
        
    }

    /**
     * log errors in the scheduler
     * @param array $schedule
     * @param string $logType
     * @param string $message
     */
    private function logSchedule($schedule, $logType, $message='')
    {
        switch ($logType)
        {
            case self::SCHEDULE_TRACK_START;
                $msg = "\n==========================================\n";
                $msg .= "START ". $schedule['class'] . " => " . $schedule['method']. "\n";
                $msg .= ($message!="")?"\t [" . $message . "]\n\n":"\n";
                $this->getLogger()->info($msg);

                break;

            case self::SCHEDULE_TRACK_FINISHED:
                $msg = "FINISHED ". $schedule['class'] . " => " . $schedule['method']. "\n";
                $msg .= ($message!="")?"\t [" . $message . "]\n\n":"\n";
                $this->getLogger()->info($msg);
                break;

            case self::SCHEDULE_TRACK_SUCCESS:
                $msg =  "SUCCESS in ". $schedule['class'] . " => " . $schedule['method']. "\n";
                $msg .=  ($message!="")?"\t [" . $message . "]\n\n":"\n";
                $this->getLogger()->info($msg);
                break;

            case self::SCHEDULE_TRACK_ERROR:
                $msg = "ERROR found in ". $schedule['class'] . " => " . $schedule['method']. "\n";
                $msg .= ($message!="")?"\t [" . $message . "]\n\n":"\n";
                $this->getLogger()->error($msg);
                break;
        }
    }



}

?>