<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:45
 */
//
session_start();
include ('Connect/Connect.php');
include('Controller/Auth.php');
include ('Controller/Gobal.php');
include ('Controller/Friend.php');
include ('Controller/Post.php');
include ('Controller/Group.php');
$s = Auth::check();
if(!$s) {
    return redirect('login.php?meg=nonlogin'); //沒有登入的話,跳到登入畫面
}elseif (!isset($_GET['id'])){
    return redirect('index.php');
}else{
    $Auth = new Auth();
}

if(isset($_POST['button_post'])){
    $post = new Post();
    $re = $post->createPost($_POST);
    var_dump($re);
    if($re){
        return redirect('group_detail.php?meg=postfinish&id='.$_GET['id']);
    }
} //看看是否有新增貼文
if(isset($_POST['button_edit'])){
    $edit = new Post();
    $redit = $edit->editPost($_POST['post_id'],$_POST);
    if($redit){
        redirect('group_detail.php?meg=editfinish&id='.$_GET['id']);
    }else{
        redirect('group_detail.php?meg=editerror&id='.$_GET['id']);
    }
}

$group = new Group($_GET['id']);
$group_array = $group->detial();
$group_check = ($group->check());
$join = $group->getMyJoin();

if(isset($_GET['do'])){
    switch ($_GET['do']){
        case 'addgroup':
        {
            $q = $group->join();
            if($q['status']){
                redirect("group_detail.php?id=".$_GET['id']."&meg=addgroupok") ;
            }
            break;
        }
    }


}
?>


<html>
<?php include_once ('head.php'); ?>
<body>
<div class="container">
    <div class="header">
        <div class="input-group right" style="width: 20%;">
            <span class="input-group-addon">@</span>
            <input type="text" class="form-control" placeholder="名子或信箱" id="searchname">
        </div>
        <div class="search-friend-result right">
            <img id="search-ajax" src="images/ajax.gif" style="max-height: 16px;margin-left: 30%;display: none;">
            <ul class="list-group" style="display: none;">

            </ul>
        </div>
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="logout.php">登出</a></li>
            </ul>
        </nav>
        <h3 class="text-muted"><a href="/">資管人聯絡簿</a></h3>
    </div>
    <div class="jumbotron">
        <div class="photo">
            <img style="max-width: 400px;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;" src="<?php echo$group_array['group']['gphoto'];?>">
        </div>


        <div class="clear"></div>
        <div class="">

        </div>



        <div class="col-md-offset-3 col-md-5">
            <ul class="list-group">
                <li class="list-group-item list-group-item-success">群組名稱：<?php echo $group_array['group']['gname'];?></li>
                <li class="list-group-item list-group-item-info">群組管理員：<?php echo $group_array['group']['manager'];?></li>
                <li class="list-group-item list-group-item-warning">好友選項：<?php if($group_check==0){ ?>
                        <img src="images/add-contact.png" style="max-width: 22px;" class="ko addgroup" qw="加入群組">加入群組
                    <?php }elseif($group_check==1){ ?>
                        <img src="images/add-contact%20(1).png"  style="max-width: 22px;" class="ko" qw="群組確認中">群組確認中
                    <?php }elseif($group_check==2){ ?>
                        <img src="images/friends-talking.png"  style="max-width: 22px;" class="ko" qw="已成為群組成員">已成為群組成員
                    <?php }elseif($group_check==3){ ?>
                        <img src="images/friends-talking.png"  style="max-width: 22px;" class="ko addfriend" qw="群組管理員">群組管理員
                    <?php } ?></li>
            </ul>
        </div>
    </div>
    <div class="row marketing">
        <div class="col-md-offset-3 col-lg-7">
            <?php if(in_array($_GET['id'],$join)){?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>
                        新增貼文在此群組
                    </label>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <textarea type="text"  name ="contact" class="form-control"  rows="3" placeholder="請輸入..."></textarea>
                        <input type="submit" name="button_post" id="button" value="送出" class="btn btn-default" style="margin-top: 5px;">
                        <input type="hidden" name="group" value="<?php echo $_GET['id'];?>">
                    </form>
                </div>
            </div>
            <?php } ?>
            <?php

                if(in_array($_GET['id'],$join)){   //是否為群組成員
                    if($group_array['posts']){
                        foreach ($group_array['posts'] as $post){ ?>
                            <div class="postbox" id="post-<?php echo $post['post_id'];?>">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4><?php echo $post['name'];?></h4>
                                            <span><?php echo $post['post_time'];?></span>
                                    </div>
                                    <div class="panel-body">
                                        <p><?php echo $post['contact'];?></p>
                                        <?php if (Post::check($post['post_id'])){ ?>
                                            <div class="btn-group"  style="float: right;">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">選項 <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a onclick="editpost(<?php echo $post['post_id']; ?>)">修改</a></li>
                                                    <li><a onclick="deletecheck(<?php echo $post['post_id']; ?>)">刪除</a></li>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php   }
                    }else{
                        echo "<div class=\"alert alert-warning\" role=\"alert\">並沒有發布任何消息</div>";
                    }
                }else{
                    echo "<div class=\"alert alert-danger\" role=\"alert\">你並沒有加入此群組</div>";
                }

            ?>



        </div>
    </div>
    <footer class="footer">
        <?php include_once ('footer.php'); ?>
    </footer>
</div>
</body>
<script>
    <?php include_once ('script.php');?>
    <?php
    $friend = new Friend();
    $resu = $friend->checkInvideFriend();
    if($resu){ ?>
    layer.tips('<?php echo count($resu);?>', '.goodfriend', {
        tips: [4, 'rgba(255, 10, 10, 0.75)']
    });
    <?php } ?>

    $('.addgroup').click(function () {
        location="group_detail.php?do=addgroup&id=<?php echo $_GET['id'];?>";
    });


    function deletecheck(post_id) {
        layer.confirm('確定要刪除嗎？', {
            btn: ['確定','取消'] //按钮
        }, function(){
            location='deletePost.php?id='+post_id+"&page=group_detail.php?id=<?php echo $_GET['id'];?>";
        });
    }
    function editpost(post_id) {
        var html = "<form method=\"post\"><input type='hidden' name='post_id' value='"+post_id+"'><textarea type=\"text\"  name =\"contact\" class=\"form-control\"  rows=\"3\">"+$("#post-"+post_id+" p").html()+"</textarea><input type=\"submit\" name=\"button_edit\" id=\"button\" value=\"送出\" class=\"btn btn-default\" style=\"margin-top: 5px;\"></form>"
        $("#post-"+post_id+" p").html(html);
    }
</script>

</html>

