<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/9
 * Time: 下午 1:53
 */

/*
 * 以下全部都是非動態化
 * 所以每當要使用時接需要 new Friend
 *
 * getFriend回傳為陣列值
 */
class Friend
{
    public $sid;
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
        $sql = "SELECT * FROM friend WHERE `sid` ='" .$this->sid."' AND `fid` = '".$fid."' AND `request` = '0'";
        $result = $this->mysqli->query($sql);  //察看是否加過好友
        if(($result->num_rows)==1) {    //如果加過 -> UPDATE
            $sqlf = "UPDATE friend SET `request` = `1` WHERE `sid`='".$this->sid."' AND `fid`='".$fid."'";
        }else{  //如果沒加過 -> Insert
            $sqlf = "INSERT INTO friend (`sid`,`fid`,`request`,`respond`) VALUES ('".$this->sid."','".$fid."','1','0')";
        }
        if (!$this->mysqli->query($sqlf)) {  //讀取錯誤訊息
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            return '成功';
        }
        unset($sql);
        unset($sqlf);
        unset($result);
    }

    public function checkInvideFriend(){ //察看誰加我好友
        $sql = "SELECT * FROM friend WHERE `fid`= '".$this->sid."' AND `request`= '1' AND `respond` = '0'";
        $result = $this->mysqli->query($sql);
        if(($result->num_rows)>0) {
            return $result->num_rows;
        }else{
            return false;
        }
        unset($sql);
        unset($result);
    }

    public function resaddFriend($fid,$bool){  //回應是否成為好友
        if($bool){
            $sql = "UPDATE SET `respond` = 1 WHERE `fid` = '".$fid."' AND `sid` = '" .$this->sid."';";
            $re = true;
        }else{
            $sql = "UPDATE SET `requset` = 0 WHERE `fid` = '".$fid."' AND `sid` = '" .$this->sid."';";
            $re = false;
        }
        if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            return $re;
        }

    }

    public function getFriend(){
        $sql = "SELECT `FID` FROM `friend` WHERE `request` = 1 AND `respond` = 1 AND `SID` = ".$this->sid;
        $result = $this->mysqli->query($sql);
        while ($row = $result->fetch_array()){
            $friends[] = $row;
        }
        foreach ($friends as $friend){
            $reFriend[] = $friend['FID'];
        }
        return $reFriend;
        unset($sql);
        unset($reFriend);
        unset($friends);
    }

    public function showFriend(){
        $friends = $this->getFriend();
        $emFriend = implode(',',$friends); //將取得的朋友（鎮列） 轉換成","排列
        $sql = "SELECT * FROM `member_data` WHERE SID IN (".$emFriend.")";
        $result = $this->mysqli->query($sql);
        while ($row = $result->fetch_array()){
            $sfriends[] = $row;
        }
        return $sfriends;
        unset($sql);
        unset($emFriend);
        unset($result);
        unset($sfriends);
    }

}