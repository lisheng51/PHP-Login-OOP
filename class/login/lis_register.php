<?php

/**
 * User register class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_Register {

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
            case 'doubledata':
                $msg = "Username is used!";
                break;
            case 'error':
                $msg = "Can not insert!";
                break;
        }
        self::show_form($msg);
    }

    /**
     * Check double username
     * 
     * @param string $username
     * @return boolean
     */
    private static function check_double_username($username) {
        $sql_check = "
            SELECT 
                `uid`
            FROM
                `user_login` 
            WHERE
                `username` = :username
        ";
        try {
            $obj_db = LIS_PDO::get_connection();
            $obj_result = $obj_db->prepare($sql_check);
            $obj_result->bindValue("username", $username, PDO::PARAM_STR);
            $obj_result->execute();
            if ($obj_result->fetchColumn() > 0) {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * Do user register
     * 
     * @return string
     */
    public static function do_register() {
        $username = strip_tags($_POST["username"]);
        $password = strip_tags($_POST["password"]);
        $firstname = strip_tags($_POST["firstname"]);
        $surname = strip_tags($_POST["surname"]);
        if (empty($password) === true || empty($username) === true) {
            return self::show_msg("emptyckdata");
        }

        if (self::check_double_username($username) === false) {
            return self::show_msg("doubledata");
        }

        $md5password = md5($password);

        $sql_insert = "
            INSERT INTO 
                `user_login`
            SET
                `username` = :username,
                `password` = :password
        ";
        try {
            $obj_db = LIS_PDO::get_connection();
            $obj_result = $obj_db->prepare($sql_insert);
            $obj_result->bindValue("username", $username, PDO::PARAM_STR);
            $obj_result->bindValue("password", $md5password, PDO::PARAM_STR);
            $obj_result->execute();
            $uid = $obj_db->lastInsertId();
            if ($uid > 0) {
                self::insert_user_data($uid, $firstname, $surname);
            }
        } catch (PDOException $e) {
            return self::show_msg("error");
        }
    }

    private static function insert_user_data($uid, $firstname, $surname) {
        $sql_insert = "
            INSERT INTO 
                `users`
            SET
                `uid` = :uid,
                `firstname` = :firstname,
                `surname` = :surname
        ";
        try {
            $obj_db = LIS_PDO::get_connection();
            $obj_result = $obj_db->prepare($sql_insert);
            $obj_result->bindValue("uid", $uid, PDO::PARAM_INT);
            $obj_result->bindValue("firstname", $firstname, PDO::PARAM_STR);
            $obj_result->bindValue("surname", $surname, PDO::PARAM_STR);
            $obj_result->execute();

            header("location: index.php");
        } catch (PDOException $e) {
            return self::show_msg("error");
        }
    }

    /**
     * Show register form
     * 
     * @param string $message
     * @return string
     */
    public static function show_form($message = "") {
        if (LIS_Session::check_session() === true) {
            header("location: profiel.php");
        }

        $temp = new LIS_Template("index");
        $form = new LIS_Template("element/form_register");
        $form->set("message", $message);
        $temp->set("form", $form->parse());
        return $temp->execute();
    }

}
