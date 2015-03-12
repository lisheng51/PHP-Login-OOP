<?php

/**
 * User login class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_Login {

    /**
     * User log out
     */
    public static function log_out() {
        if (session_destroy() === true) {
            header("location: index.php");
        }
    }
    
    /**
     * Show diffent message
     * 
     * @param string $type
     * @return string
     */
    private static function show_msg($type) {
         switch ($type) {
            case 'emptyckdata':
                $msg = "Username or password is empty!";
                break;
            case 'invalid':
                $msg = "Username or password is invalid!";
                break;
        }
        self::show_form($msg);
    }
    
    /**
     * Set the login user session
     * 
     * @return void/string
     */
    public static function do_login() {
        $username = strip_tags($_POST["username"]);
        $password = strip_tags($_POST["password"]);

        if (empty($password) === true || empty($username) === true) {
            return self::show_msg("emptyckdata");
        }

        $value = array();
        $md5password = md5($password);
        $hash = password_hash($md5password, PASSWORD_BCRYPT);

        $sql_fetch = "
            SELECT 
                `uid`,
                `password`
            FROM
                `user_login` 
            WHERE
                `username` = :username
            AND
                `password` = :password 
        ";
        try {
            $obj_db = LIS_PDO::get_connection();
            $obj_result = $obj_db->prepare($sql_fetch);
            $obj_result->bindValue("username", $username, PDO::PARAM_STR);
            $obj_result->bindValue("password", $md5password, PDO::PARAM_STR);
            $obj_result->execute();
            $value = $obj_result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return self::show_msg("invalid");
        }

        if ($value['uid'] > 0 && password_verify($value['password'], $hash) === true) {
            LIS_Session::set_session($value['uid'], $hash);
            header("location: profiel.php");
        } else {
            return self::show_msg("invalid");
        }
    }

    /**
     * Show login form
     * 
     * @param $string $form
     */
    public static function show_form($message = "") {
        if (LIS_Session::check_session() === true) {
            header("location: profiel.php");
        }

        $temp = new LIS_Template("index");
        $form = new LIS_Template("element/form_login");
        $form->set("message", $message);
        $temp->set("form", $form->parse());
        return $temp->execute();
    }

}