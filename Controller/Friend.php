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
        $sqlt = "SELECT * FROM friend WHERE `sid` =".$fid." AND `FID` = " .$this->sid." AND `request` = '1' ";

        $result1 = $this->mysqli->query($sqlt);  //察看是否加過好友
        if(($result1->num_rows)==0) {//對方是否加你好友
            $sql = "SELECT * FROM friend WHERE `sid` ='" . $this->sid . "' AND `fid` = '" . $fid . "' AND `request` = '0'";
            $result = $this->mysqli->query($sql);  //察看是否加過好友
            if (($result->num_rows) > 0) {    //如果加過 -> UPDATE
                $sqlf = "UPDATE friend SET `request` = 1 WHERE `sid`='" . $this->sid . "' AND `fid`='" . $fid . "'";
            } else {  //如果沒加過 -> Insert
                $sqlf = "INSERT INTO friend (`sid`,`fid`,`request`,`respond`) VALUES ('" . $this->sid . "','" . $fid . "','1','0')";
            }
        }else{
            $sqlf = "UPDATE friend SET `respond` = 1 WHERE `sid`='" . $fid . "' AND `fid`='" . $this->sid . "'";
        }
        echo $sqlf;
        if (!$this->mysqli->query($sqlf)) {  //讀取錯誤訊息
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            return true;
        }
        unset($sql);
        unset($sqlf);
        unset($result);
    }

    public function resetFriend($fid){
        $sql = "SELECT * FROM friend WHERE `sid` ='" .$this->sid."' AND `fid` = '".$fid."' AND `request` = '1' AND `respond` = '0'";
        $result = $this->mysqli->query($sql);  //察看是否加過好友
        if(($result->num_rows)==1) {    //如果加過 -> UPDATE
            $sqlf = "UPDATE friend SET `request` = 0 WHERE `sid`='".$this->sid."' AND `fid`='".$fid."'";
        }
        if (!$this->mysqli->query($sqlf)) {  //讀取錯誤訊息
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            return true;
        }
        unset($sql);
        unset($sqlf);
        unset($result);
    }

    public function checkInvideFriend(){ //察看誰加我好友
        $sql = "SELECT * FROM friend ";
        $sql = $sql . " INNER JOIN member_data ON (friend.SID = member_data.SID)";
        $sql = $sql . " WHERE `FID`= '".$this->sid."' AND (`request`= '1' AND `respond` = '0') OR (`request`= '1' AND `respond` is NULL) ";
        $result = $this->mysqli->query($sql);
        if(($result->num_rows)>0) {
            while ($row = $result->fetch_array()){
                $checkfriends[] = $row;
            }
            return $checkfriends;
        }else{
            return false;
        }
        unset($sql);
        unset($result);
    }

    public function resaddFriend($fid,$bool){  //回應是否成為好友 //別人加我我回應
        if($bool){
            $sql = "UPDATE friend SET `respond` = 1 WHERE `fid` = '".$this->sid."' AND `sid` = '" .$fid."';";
        }else{
            $sql = "DELETE FROM `friend` WHERE `fid` = '".$this->sid."' AND `sid` = '" .$fid."';";
        }
        if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            return true;
        }

    }

    public function checkAddFriend($fid){
        $sql = "SELECT * FROM `friend` WHERE (`FID` = ".$fid ." AND `SID` = ".$this->sid.") OR (`FID` = ".$this->sid." AND `SID` = ".$fid.")";
        $result = $this->mysqli->query($sql);
        $r = $result->fetch_object();
        if(isset($r->SID)){
            if($r->SID == $this->sid){   //自己先加了
                if(($r->request==1)&&($r->respond==0||NULL)){
                    return 1; //加了再等
                }elseif(($r->request==0)&&($r->respond==0||NULL)){
                    return 0; //還沒加
                }elseif(($r->request==1)&&($r->respond==1)){
                    return 2;//已成為
                }
            }elseif($r->FID == $this->sid){ //別人加擬了
                if(($r->request==1)&&($r->respond==0||NULL)){
                    return 3; //等待你的回應中
                }elseif(($r->request==1)&&($r->respond==1)){
                    return 2;//已成為
                }
            }

        }else{
            return 0; //還沒加
        }

    }

    public function getFriend(){
        $sql = "SELECT `FID` FROM `friend` WHERE (`request` = 1 AND `respond` = 1 AND `SID` = ".$this->sid.")"; //我家的好友
        $result = $this->mysqli->query($sql);
        while ($row = $result->fetch_array()){
            $friends[] = $row;
        }
        $sql2 = "SELECT `SID` AS `FID` FROM `friend` WHERE (`request` = 1 AND `respond` = 1 AND `FID` = ".$this->sid.")"; //別人加我的好友
        $result2 = $this->mysqli->query($sql2);
        while ($row2 = $result2->fetch_array()){
            $friends[] = $row2;
        }
        if(!empty($friends)){
            foreach ($friends as $friend){
                $reFriend[] = $friend['FID'];
            }
            return $reFriend;
        }else{
            return false;
        }
        unset($sql);
        unset($reFriend);
        unset($friends);
    }

    public function showFriend(){
        $friends = $this->getFriend();
        if($friends){
            $emFriend = implode(',',$friends); //將取得的朋友（鎮列） 轉換成","排列
            $sql = "SELECT * FROM `member_data` WHERE SID IN (".$emFriend.")";
            $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_array()){
                $sfriends[] = $row;
            }
            return $sfriends;
        }else{
            return false;
        }
        unset($sql);
        unset($emFriend);
        unset($result);
        unset($sfriends);
    }

    public function find($request){
        if(isset($request)){
            $find = $request;
            $sql = "SELECT * FROM `member_data` ";
            $sql .= "WHERE  `name` LIKE '%".$find['search']."%'";
            $sql .= "OR  `email` LIKE '%".$find['search']."%'";
            $result = $this->mysqli->query($sql);
            $numrow = $result->num_rows;
            if($numrow>0){ //搜尋到資料
                $a = array();
                while ($row = $result->fetch_array()){
                    $b = [
                        'sid' => $row['SID'],
                        'name' => $row['name'],
                        'photo' => $row['photo'],
                    ];
                    array_push($a,$b);
                }
            }else{
                $a = [
                    'sid' => 'null',
                ];
            }
            return $a;
        }else{
            return false;
        }

        unset($find);
        unset($sql);
        unset($result);
        unset($findre);

    }

}