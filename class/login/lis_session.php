<?php

/**
 * Login session class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_Session {

    /**
     * Check the login user session
     * 
     * @return boolean
     */
    public static function check_session() {
        $value = array();
        if (self::get_session() === null) {
            return false;
        }
        list ($uid, $hash) = explode("_", self::get_session());
        if ($uid < 0) {
            return false;
        }
        $sql_fetch = "
            SELECT 
                `password`
            FROM
                `user_login` 
            WHERE
                `uid` = :uid
        ";
        try {
            $obj_db = LIS_PDO::get_connection();
            $obj_result = $obj_db->prepare($sql_fetch);
            $obj_result->bindValue("uid", $uid, PDO::PARAM_INT);
            $obj_result->execute();
            $value = $obj_result->fetch(PDO::FETCH_ASSOC);
            if (password_verify($value['password'], $hash) === true) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get the login user session
     * 
     * @return $_SESSION
     */
    public static function get_session() {
        if (isset($_SESSION['login_user_session']) === true) {
            return $_SESSION['login_user_session'];
        }
        return null;
    }

    /**
     * Set the login user session
     * 
     * @return void
     */
    public static function set_session($uid, $hash) {
        $_SESSION['login_user_session'] = $uid . "_" . $hash;
    }

}
