<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/11
 * Time: 下午 8:04
 */
class member
{
    public $name;
    public $phone;
    public $email;
    public $photo;

    public $mysqli;

    /**
     * member constructor.
     */
    public function __construct($SID)
    {
        $this->mysqli = Connect::conn();
        $friend = new Friend();
        $friends = $friend->getFriend();

            $sql = "SELECT * FROM `member_data` WHERE `SID` = ".$SID;
            $result= $this->mysqli->query($sql);
            $r = $result->fetch_object();
            $this->name = $r->name;
            $this->phone= $r->phone;
            $this->email= $r->email;
            $this->photo= $r->photo;
            return true;

        unset($friends);
        unset($friend);
        unset($result);
        unset($r);
    }
}