<?php
/**
 * Admin access class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_Admin extends LIS_Profiel {

    private $access_module;

    /**
     * Constructor
     * 
     * @return LIS_Admin
     */
    public function __construct() {
        parent::__construct();
        $this->access_module = $this->fetch_access_module();
    }
    
    public function execute() {
        if ($this->isadmin === false) {
            die($this->show_error_code(1));
        }
        $temp = new LIS_Template("admin");
        $temp->set("name", $this->user["surname"].' '.$this->user["firstname"]);
        $temp->set("accessmodule", $this->show_access_module());
        return $temp->execute();
    }


    public function show_error_code($num) {
        switch ($num) {
            case 1:
                $msg = "Wrong group";
                break;
            case 2:
                $msg = "Access_module is empty";
                break;
            default:
                break;
        }
        return "Lis Error($num): " . $msg;
    }

    public function get_access_module() {
        return $this->access_module;
    }
    
    
    private function show_access_module() {
        if (empty($this->access_module) === true) {
            die($this->show_error_code(2));
        }
 
        $string = '';
        foreach ($this->access_module as $value) {
            $filename = "module/$value.php";
            $string .= "<a href='$filename'>$value</a> \n";
        }


        return $string;
    }

    /**
     * Fetch all access module
     * 
     * @return array
     */
    private function fetch_access_module() {
        if ($this->isadmin === true) {
            return array("Blog", "Poll", "Faq", "Panel");
        } else {
            return array();
        }
    }

}
