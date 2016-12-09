<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/9
 * Time: 下午 1:53
 */
class Friend
{
    public $sid;
    public $fid;
    public $mysqli;
    public function __construct()
    {
        if(Auth::check()==true){
            $this->sid = $_SESSION['sid'];
        }else{
            //return redirect('login.php');
        }

        $this->mysqli=Connect::conn();
    }

    public function addFriend($fid){
        $this->fid = $fid;
        $sql = "SELECT * FROM friend WHERE `sid` ='" .$this->sid."' AND `fid` = '".$this->fid."' AND `request` = '0'";
        $result = $this->mysqli->query($sql);  //察看是否加過好友
        if(($result->num_rows)==1) {    //如果加過 -> UPDATE
            $sqlf = "UPDATE friend SET `request` = `1` WHERE `sid`='".$this->sid."' AND `fid`='".$this->fid."'";
        }else{  //如果沒加過 -> Insert
            $sqlf = "INSERT INTO friend (`sid`,`fid`,`request`,`respond`) VALUES ('".$this->sid."','".$this->fid."','1','0')";
        }
        if (!$this->mysqli->query($sqlf)) {  //讀取錯誤訊息
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            return '成功';
        }
    }

    public static function checkInvideFriend(){ //察看誰加我好友
        $mysqli=Connect::conn();
        $sid = $_SESSION['sid'];
        $sql = "SELECT * FROM friend WHERE `fid`= '".$sid."' AND `request`= '1' AND `respond` = '0'";
        $result = $mysqli->query($sql);
        if(($result->num_rows)>0) {
            return $result->num_rows;
        }else{
            return false;
        }

    }
}