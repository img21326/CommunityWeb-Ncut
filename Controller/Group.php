<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/12
 * Time: 下午 01:38
 */
class Group
{
    public $sid;
    public $mysqli;
    public $group_id;
    public function __construct($group_id = null){
        if(Auth::check()==true){
            $this->sid = $_SESSION['sid'];
            $this->group_id = $group_id;
        }else{
            return redirect('login.php');
        }
        $this->mysqli=Connect::conn();
    }
    public function add($request){  //新增群組
        $ret = array();
        if($this->checkName($request['gname'])){
            $photopath = $this->uploadPhoto($_FILES['gphoto'],$this->sid);
            $sql = "INSERT INTO `group_data` (`group_id`,`gname`,`manager`,`gphoto`) VALUE (NULL ,'".$request['gname']."','".$this->sid."','".$photopath."')";
            echo $sql;
            if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息
                printf("Errormessage: %s\n", $this->mysqli->error);
            }else{
                $ret = [
                    'status' => true,
                    'msg' => "",
                ];
            }
        }else{
            $ret = [
               'status' => false,
               'msg' => "名稱重複使用",
            ];
        }
        return $ret;
        unset($ret);
        unset($sql);
        unset($photopath);
    }

    public function delelte($id = null){
        if(is_null($this->group_id)){
            $this->group_id = $id;
        }
        if(isset($this->group_id)){
            $sql = "DELETE FROM `group_data` WHERE `group_id` = ".$this->group_id;
            if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息
                printf("Errormessage: %s\n", $this->mysqli->error);
            }else{
                $ret = [
                    status => true,
                    msg => "",
                ];
            }
        }else{
            $ret = [
                status => false,
                msg => "錯誤！",
            ];
        }
        return $ret;
        unset($ret);
        unset($sql);
    }

    public function edit($request,$id = null){
        if(is_null($this->group_id)){
            $this->group_id = $id;
        }
        echo $this->group_id;
        if(isset($this->group_id)){
            //UPDATE  `group1`.`group_data` SET  `gname` =  'test1' WHERE  `group_data`.`group_id` =1 LIMIT 1 ;
            $sql = "UPDATE  `group1`.`group_data` SET  `gname` =  '".$request['gname']."'";
            if(isset($request['gphoto'])){
                $photopath = $this->uploadPhoto($_FILES['photo'],$this->sid);
                $sql .= " `gphoto` = '" .$photopath."'";
            }
            $sql.= " WHERE `group_id` = ".$this->group_id;
            if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息
                printf("Errormessage: %s\n", $this->mysqli->error);
            }else{
                $ret = [
                    'status' => true,
                    'msg' => "",
                ];
            }
        }else{
            $ret = [
                'status' => false,
                'msg' => "錯誤！",
            ];
        }
        return $ret;
        unset($ret);
        unset($sql);
    }

    public function checkName($name){   //察看是否有重複的群足名稱
        $sql = "SELECT * FROM group_data WHERE `gname` = '".$name."'";
        $result = $this->mysqli->query($sql);
        if($result->num_rows>0){ //察看是否大於0
            return false;
        }else{
            return true;
        }
        unset($sql);
        unset($result);
    }

    public function uploadPhoto($file,$name){
        $uploaddir = 'images/group/';
        $uploadfile = $uploaddir . basename(rand(1111, 9999).$file['name']);
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            return $uploadfile;
        } else {
            return $uploadfile;
        }
    }
    
    public function getMy(){  //我自己開的群組
        $sql = "SELECT group_data.group_id,gname, manager, gphoto, COUNT( respond ) as total FROM  `group_data` LEFT JOIN  `group_q` ON ( group_data.group_id = group_q.group_id )  WHERE `manager` = '".$this->sid."' GROUP BY group_data.group_id,gname, manager, gphoto";
        $result = $this->mysqli->query($sql);
        $a = array();
        $joinmes = $this->JoinMe();
        while ($row = $result->fetch_array()){
            $b = array();
            foreach ($joinmes as $joinme){
                if($joinme['group_id']==$row['group_id']){
                    $b[]=[
                        $joinme,
                    ];
                }
            }
            $a[] = [
                'group_id' => $row['group_id'],
                'gname' => $row['gname'],
                'manager' => $row['manager'],
                'gphoto' => $row['gphoto'],
                'total' => $row['total'],
                'join' =>$b,
            ];

        }
        return $a;
        unset($a);
        unset($b);
        unset($sql);
        unset($result);
    }

    public function getMyJoin($manager = true){  //我加入的群組(陣列)     是否要加入自己的群組
        $sql = "SELECT * FROM `group_q` INNER JOIN `group_data` ON (`group_q`.`group_id`=`group_data`.`group_id`)";
        $sql.= "WHERE (  `sid` =  ".$this->sid." AND `request` = 1 AND `respond` = 1 ) ";
        $result = $this->mysqli->query($sql);
        $a = array();
        while ($row = $result->fetch_array()){
           $a[] = $row['group_id'];
        }
        if($manager){
            $sql1 = "SELECT * FROM `group_data` WHERE `manager` = ".$this->sid;
            $result1 = $this->mysqli->query($sql1);
            while ($row1 = $result1->fetch_array()){
                $a[] = $row1['group_id'];
            }
        }
        return $a;
        unset($a);
        unset($sql);
        unset($result);
        unset($sql1);
        unset($result1);
    }

    public function showMyJoin($manager = true){
        $getMyJoin = $this->getMyJoin($manager);
        if($getMyJoin){
            $emGroup = implode(',',$getMyJoin); //將取得的GROUP（鎮列） 轉換成","排列
            $sql = "SELECT * FROM `group_data` WHERE `group_id` IN (".$emGroup.")";
            $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_array()){
                $group[] = $row;
            }
            return $group;
        }else{
            return false;
        }
        unset($getMyJoin);
        unset($group);
        unset($emGroup);
        unset($sql);
        unset($result);

    }

    public function JoinMe(){
        $getMyJoin = $this->getMyJoin();
        $emGroup = implode(',',$getMyJoin); //將取得的GROUP（鎮列） 轉換成","排列
        if($getMyJoin) {
            $group=array();
            $sql = "SELECT * FROM `group_q` INNER JOIN `member_data` ON (group_q.sid = member_data.SID) WHERE `request` = 1 AND (`respond` = 0 or `respond` is null) AND `group_id` IN (" . $emGroup . ")";
            $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_array()) {
                $group[] = $row;
            }
            return $group;
        }else{
            return false;
        }
        unset($getMyJoin);
        unset($group);
        unset($emGroup);
        unset($sql);
        unset($result);
    }

    public function join(){
        $sql = "INSERT INTO `group_q` (`id`,`sid`,`group_id`,`request`,`respond`) VALUES (NULL,'".$this->sid."','".$this->group_id."','1',NULL)";
        if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            $ret = [
                'status' => true,
            ];
        }
        return $ret;
        unset($ret);
        unset($sql);
    }

    public function okjoin($group_id,$sid){   //回復答應加入
        $sql_check = "SELECT * FROM `group_data` WHERE `group_id` = ".$group_id;
        $manager =$this->mysqli->query($sql_check)->fetch_object()->manager;
        if($manager==$this->sid){
            $sql = "UPDATE `group_q` SET `respond` = 1 WHERE `group_id` = ".$group_id." AND `sid` = ".$sid;
            if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息
                printf("Errormessage: %s\n", $this->mysqli->error);
            }else{
                $ret = [
                    'status' => true,
                ];
            }
        }

        return $ret;
        unset($manager);
        unset($ret);
        unset($sql);
    }

    public function detial(){
        $sql = "SELECT * FROM `group_data` INNER JOIN `member_data` ON member_data.SID = group_data.manager WHERE `group_id` = ".$this->group_id;
        $result = $this->mysqli->query($sql);
        $a = array();
        while ($row = $result->fetch_array()){
            $a = [
                'group' => [
                    'group_id' => $row['group_id'],
                    'gname' => $row['gname'],
                    'manager' => $row['name'],
                    'name' => $row['gname'],
                    'gphoto' => $row['gphoto'],
                ],
            ];
        }
        $sql1 = "SELECT * FROM `post` INNER JOIN `member_data` ON member_data.SID = post.SID WHERE `group_id` = ".$this->group_id;
        $result1 = $this->mysqli->query($sql1);
        $a['posts'] = array();
        while ($row1 = $result1->fetch_array()){
            $a['posts'][] = [
                    'contact' => $row1['contact'],
                    'post_time' => $row1['post_time'],
                    'photo' => $row1['photo'],
                    'name' => $row1['name'],
                    'post_id'=>$row1['post_id'],
            ];
        }
        return $a;
        unset($a);
        unset($sql);
        unset($result);
        unset($sql1);
        unset($result1);

    }

    public function check(){
        $sql1 = "SELECT * FROM `group_data` WHERE `manager` = ".$this->sid ." AND `group_id` = ".$this->group_id;
        $result1 = $this->mysqli->query($sql1);
        if($result1->num_rows != 1){  //如果不是管理員
            $sql = "SELECT * FROM `group_q` WHERE `group_id` = ".$this->group_id ." AND `sid` = ".$this->sid;
            $result = $this->mysqli->query($sql);
            if($result->num_rows==1){
                $row = $result->fetch_array();
                if($row['request']==0){
                    return 0; //沒有申請加入
                }elseif($row['request']==1 && $row['respond']==0||NULL){
                    return 1; //沒有背確認加入
                }elseif($row['request']==1 && $row['respond']==1){
                    return 2; //群組成員
                }
            }else{
                return 0;//沒有申請加入
            }
        }
        return 3; //管理員


    }

}

//$sql = "SELECT * FROM `group_q` INNER JOIN `group_data` ON (`group_q`.`group_id`=`group_data`.`group_id`) INNER `member_data` ON(`group_q`.`sid`=`member_data`.`SID`)";
//        $sql.= "WHERE `manager` = ".$this->sid." AND `request` = 1";
//        $result = $this->mysqli->query($sql);
//        $a = array();
//        while ($row = $result->fetch_array()){
//            $b = [
//                'group_id' => $row['group_id'],
//                'sid' => $row['sid'],
//                'name' => $row['name'],
//                'photo' => $row['photo'],
//            ];
//            array_push($a,$b);
//        }
//        return $a;
//        unset($a);
//        unset($sql);
//        unset($result);