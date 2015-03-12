<?php

/**
 * User data class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_User {

    /**
     *
     * @var array $user 
     */
    protected $user;

    /**
     * Constructor
     * 
     * @return LIS_User
     */
    public function __construct() {
        $this->user = array();
        $this->login_check();
    }
    
    /**
     * Check of login
     */
    protected function login_check() {
        if (LIS_Session::check_session() === true) {
            list ($uid, $hash) = explode("_", LIS_Session::get_session());
            $this->user = $this->fetch_user($uid);
        }else{
            header("location: index.php");
        }
    }

    /**
     * Get user data
     * 
     * @return void
     */
    public function get_user() {
        return $this->user;
    }
    
    /**
     * Get user group
     * 
     * @return string
     */
    public function get_groupname() {
        return ($this->user["group"] == 2) ? "Admin" : "Member";
    }
    
    /**
     * Get group url
     * 
     * @return string
     */
    public function get_group_url() {
        return ($this->user["group"] == 2) ? "admin.php" : "member.php";
    }

    /**
     * Fetch user data
     * 
     * @param integer $uid
     * 
     * @return array $value
     */
    protected function fetch_user($uid) {
        $value = array();
        $uid = (int) $uid;
        if ($uid < 0) {
            return $value;
        }
        $sql_fetch = "
            SELECT 
                *
            FROM
               `users` 
            WHERE
              `uid` = :uid
        ";
        try {
            $obj_db = LIS_PDO::get_connection();
            $obj_result = $obj_db->prepare($sql_fetch);
            $obj_result->bindValue("uid", $uid, PDO::PARAM_INT);
            $obj_result->execute();
            $value = $obj_result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
        return $value;
    }

}
