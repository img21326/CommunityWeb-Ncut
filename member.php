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
include ('Controller/member.php');
$s = Auth::check();
if(!$s) {
    return redirect('login.php?meg=nonlogin'); //沒有登入的話,跳到登入畫面
}elseif (!isset($_GET['id'])){
    return redirect('index.php');
}elseif ($_GET['id']==$_SESSION['sid']){
    return redirect('index.php'); //看自己的資料則回到INDEX
}else{
    $Auth = new Auth();
}
$member = new member($_GET['id']);
$Friend = new Friend();
$friends = $Friend->getFriend();

$addedFriend = ($Friend->checkAddFriend($_GET['id']));
if(isset($_GET['do'])){
    switch ($_GET['do']){
        case 'addfriend':
            $q = $Friend->addFriend($_GET['id']);
            if($q){
                return redirect($_SERVER['PHP_SELF']."?id=".$_GET['id']);
            }
            break;
        case 'resetfriend':
            $q = $Friend->resetFriend($_GET['id']);
            if($q){
                return redirect($_SERVER['PHP_SELF']."?id=".$_GET['id']);
            }
            break;
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
            <img style="max-width: 400px;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;" src="<?php echo $member->photo ;?>">
        </div>


        <div class="clear"></div>
        <div class="">

        </div>
        <div class="col-md-1">
            <?php if($addedFriend==0){ ?>
                <img src="images/add-contact.png" style="max-width: 64px;" class="ko addfriend" qw="加入好友">
            <?php }elseif($addedFriend==1){ ?>
                <img src="images/add-contact%20(1).png"  style="max-width: 64px;" class="ko resetfriend" qw="好友確認中">
            <?php }elseif($addedFriend==2){ ?>
                <img src="images/friends-talking.png"  style="max-width: 64px;" class="ko" qw="已成為好友">
            <?php }elseif($addedFriend==3){ ?>
                <img src="images/friends-talking.png"  style="max-width: 64px;" class="ko addfriend" qw="您還沒回復哦">
            <?php } ?>
        </div>
        <div class="col-md-offset-3 col-md-5">
            <ul>
                <li>姓名：<?php echo $member->name ;?></li>
                <li>電話：<?php echo $member->phone ;?></li>
                <li>email：<?php echo $member->email ;?></li>
            </ul>

        </div>
    </div>
    <div class="row marketing">
        <div class="col-md-offset-3 col-lg-7">
            <?php
            if($friends){ //先看是否有朋友
                if(in_array($_GET['id'],$friends)){   //是否成為朋友
                    $posts = Post::friendPost($_GET['id'],0,10);
                    if($posts){
                        foreach ($posts as $post){ ?>
                            <h4><?php echo $post['name'];
                                if(isset($post['gname'])){
                                    echo " 在 ".$post['gname']." 社團的貼文";
                                }else{
                                    echo " 在 自己 的貼文";
                                }
                                ?></h4>
                            <span><?php echo $post['post_time'];?></span>
                            <p><?php echo $post['contact'];?></p>
                            <hr>
                        <?php   }
                    }else{
                        echo "<h2>本人未發任何文章</h2>";
                    }
                }else{
                    echo "<h2>你們還沒有成為好友哦!</h2>";
                }
            }else{
                echo "<h2>你們還沒有成為好友哦!</h2>";
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
    $('.ko').mouseenter(function() {
        layer.tips($(this).attr('qw'), this, {
            tips: [3, '#78BA32']
        });
    });

    $('.addfriend').click(function () {
       location="member.php?do=addfriend&id=<?php echo $_GET['id'];?>";
    });

    $('.resetfriend').click(function () {
        location="member.php?do=resetfriend&id=<?php echo $_GET['id'];?>";
    });
</script>

</html>

