<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/8
 * Time: 下午 03:16
 */
class Post
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

    public function createPost($requset){   // 新增動態消息
        $contact = $requset['contact'];
        $group = (isset( $requset['group'])) ? ( $requset['group']) : ("NULL");
        $sql = "INSERT INTO post (post_id, SID, contact, post_time, group_id)";
        $sql = $sql . " VALUES (NULL, '".$this->sid."', '".$contact."', CURRENT_TIMESTAMP, '".$group."');";
        if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
            printf("Errormessage: %s\n", $this->mysqli->error);
        }else{
            return '成功';
        }
        unset($sql);
    }

//SELECT * FROM `post`,`friend` WHERE post.SID = friend.FID AND friend.FID in (1,2) ORDER by `post_time` DESC LIMIT 0,1
    public static function showPost($start,$val){ //從哪裡開始,取幾筆
        $mysqli = Connect::conn();
        $Friend = new Friend();
        $friends = $Friend->getFriend();
        $emFriend = implode(',',$friends); //將取得的朋友（鎮列） 轉換成","排列
        $sql = "SELECT * FROM `post`,`friend` WHERE friend.SID = post.SID AND friend.Fid in (".$emFriend.") ORDER by `post_time` DESC LIMIT ".$start.",".$val;
        $result= $mysqli->query($sql);
        while ($row = $result->fetch_array()){
            $posts[] = $row;
        }
        echo json_encode($posts);  //json 取出

    }

    public function deletePost($post_id){  //刪除
        $this->mysqli = Connect::conn();
        $check = self::check($post_id);
        if($check){
            $sql = "DELETE FROM `post` WHERE `post`.`post_id` = ". $post_id;
            if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
                printf("Errormessage: %s\n", $this->mysqli->error);
            }else {
                return "成功";
            }
        }else{
            return '權限不符';
        }

        unset($sqlsid);
        unset($sql);
    }



    public function editPost($post_id,$request){  //修改
        $check = self::check($post_id);
        if($check){
            $contact = $request['contact'];
            $sql = "UPDATE `post` SET `contact` = '".$contact."' WHERE `post`.`post_id` =".$post_id;
            if (!$this->mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
                printf("Errormessage: %s\n", $this->mysqli->error);
            }else {
                return "成功";
            }
        }else{
            return '權限不符';
        }

        unset($sqlsid);
        unset($sql);
    }



    public static function check($post_id){   //查看是否為作者
        $mysqli = Connect::conn();
        $sql = "SELECT * FROM `post` WHERE `post_id` =". $post_id;
        $result= $mysqli->query($sql);
        $user = $result->fetch_object();
        if($_SESSION['sid']==$user->SID){
            return true;
        }else{
            return false;
        }
        unset($sql);
        $result->close();
        $mysqli->close();
    }
}
/*          新增文章    */
//        $post = new Post();
//        $arr = [
//            "contact" => "hi~",
//            "group" =>  "1",
//        ];
//        $post->createPost($arr);
/*          修改文章    */
//$arr =[
//'contact' => 'ne1w one',
//];
//$s = Post::editPost(2,$arr);
/*          刪除文章    */
//Post::deletePost(2);
/*          讀取文章    */
//Post::showPost($a,$b);從哪裡開始,取幾筆