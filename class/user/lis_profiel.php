<?php

/**
 * User profile class
 * 
 * @author Lisheng Ye
 * @version 1.0
 */
class LIS_Profiel extends LIS_User {

    /**
     *
     * @var boolean $isadmin
     * @var array $access 
     */
    protected $isadmin;
    protected $ismember;
    protected $access;

    /**
     * Constructor
     * 
     * @return LIS_Profiel
     */
    public function __construct() {
        parent::__construct();
        $this->ismember = false;
        $this->isadmin = false;
        $this->access = array();
        $this->fetch_user_access();
    }

    public function execute() {
        $getgendervalue = ($this->user["gender"] == 'male') ? 'selected' : '';
        $getgendervalue2 = ($this->user["gender"] == 'female') ? 'selected' : '';

        $temp = new LIS_Template("profiel");

        $temp->set("getgendervalue", $getgendervalue);
        $temp->set("getgendervalue2", $getgendervalue2);
        $temp->set("email", $this->user["email"]);
        $temp->set("surname", $this->user["surname"]);
        $temp->set("firstname", $this->user["firstname"]);
        $temp->set("groupurl", $this->get_group_url());
        $temp->set("accesslist", $this->show_access());
        $temp->set("groupname", $this->get_groupname());

        return $temp->execute();
    }

    /**
     * Fetch user access
     * 
     */
    private function fetch_user_access() {
        switch ($this->get_groupname()) {
            case 'Admin':
                $this->isadmin = true;
                $this->access = array("add", "edit", "remove", "search");
                break;
            case 'Member':
                $this->ismember = true;
                $this->access = array("view", "email", "search");
                break;
        }
    }

    /**
     * Show access value
     * 
     * @return string $string
     */
    private function show_access() {
        $string = "";
        if (empty($this->access) === false) {
            foreach ($this->access as $value) {
                $string .= ' - ' . $value;
            }
        } else {
            $string .= "No access!!";
        }

        return $string;
    }

    public function edit_profiel() {

        $email = strip_tags($_POST["email"]);
        $firstname = strip_tags($_POST["firstname"]);
        $surname = strip_tags($_POST["surname"]);
        $sql_insert = "
            UPDATE 
                `users`
            SET
                `email`= :email,
                `firstname` = :firstname,
                `surname` = :surname,
                `gender` = :gender
            WHERE
                `uid` = :uid
        ";


        try {
            $obj_db = LIS_PDO::get_connection();

            $obj_result = $obj_db->prepare($sql_insert);
            $obj_result->bindValue("uid", $this->user["uid"], PDO::PARAM_INT);
            $obj_result->bindValue("firstname", $firstname, PDO::PARAM_STR);
            $obj_result->bindValue("surname", $surname, PDO::PARAM_STR);
            $obj_result->bindValue("email", $email, PDO::PARAM_STR);
            $obj_result->bindValue("gender", $_POST["gender"], PDO::PARAM_STR);
            $obj_result->execute();
            header("location: profiel.php");
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

}
