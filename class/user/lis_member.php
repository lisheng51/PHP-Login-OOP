<?php

/**
 * Member access class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_Member extends LIS_Profiel {

    /**
     * Constructor
     * 
     * @return LIS_Member
     */
    public function __construct() {
        parent::__construct();
        
    }
    
    public function execute() {
        $temp = new LIS_Template("member");
        $temp->set("name", $this->user["surname"].' '.$this->user["firstname"]);
        return $temp->execute();
    }

}
