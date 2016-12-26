<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/26
 * Time: 下午 02:31
 */
class Leave
{
    public $post_id;
    public $leave_content;
    public $sid;
    public $mysqli;
    public function __construct($post_id=null,$leave_content=null)
    {
        if(Auth::check()==true){
            $this->sid = $_SESSION['sid'];
        }else{
            //return redirect('login.php');
        }
        $this->mysqli= Connect::conn();
    }


    public static function get($post_id){
        $mysqli = Connect::conn();
        $sql = "SELECT * FROM `leave` WHERE `post_id` = '".$post_id."' ORDER BY `leave_tine` DESC";
        $result = $mysqli->query($sql);
        $leave = array();
        while ($row = $result->fetch_array()){
            $leave[] = $row;
        }
        return $leave;

        $mysqli->close();
        unset($sql);
        unset($result);
        unset($leave);
    }

    public function add(){
        $sql = "INSERT INTO `leave` (`com_id`,`commiter`,`contast`,`leave_tome`,`post_id`) VALUES (NULL,'".$this->sid."','".$this->leave_content."',CURRENT_TIMESTAMP,'".$this->post_id."');";
        if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else {
            return true;
        }
        unset($sql);
    }

    public static function delete($com_id){
        $mysqli = Connect::conn();
        $sql = "DELETE FROM `leave` WHERE `com_id` = ".$com_id;
        if (!$mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
            printf("Errormessage: %s\n", $mysqli->error);
        }else {
            return true;
        }
    }
}