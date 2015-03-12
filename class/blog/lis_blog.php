<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lis_blog
 *
 * @author lisheng51
 */
class LIS_Blog implements LIS_Admin_Access{
    
    private $get_access;

    public function __construct() {
        $this->check_access();
        
    }
    
    public function check_access() {
        $obj_admin = new LIS_Admin();
        $modules = $obj_admin->get_access_module();
        if(in_array('Blog', $modules)===true) {
            $this->get_access = true;
        }else{
            $this->get_access = false;
            die($obj_admin->show_error_code(1));
        }
    }
    
    public function add_items() {
        if($this->get_access === false){
            return;
        }
        
        echo "yes1";
    }
}
