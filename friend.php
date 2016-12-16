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
$s = Auth::check();
if(!$s){
    return redirect('login.php?meg=nonlogin'); //沒有登入的話,跳到登入畫面
}else{
    $Auth = new Auth();
}
$Friend = new Friend();
if(isset($_GET['do'])){
    switch ($_GET['do']){
        case 'resaddFriend':
            $q = $Friend->resaddFriend($_GET['id'],$_GET['res']);
            if($q){
                //return redirect($_SERVER['PHP_SELF']);
            }
            break;
    }

}
?>

<html>
    <?php include_once ('head.php'); ?>
    <body>
    <div class="container">
        <?php include_once ("header.php");?>
        <div class="row marketing">
            <div class="col-md-offset-3 col-lg-7" style="margin-top: 15px;">

                <?php
                    $cfriends = new Friend();
                    $addmefriends = $cfriends->checkInvideFriend();
                    if(!empty($addmefriends)) {  //顯示+的朋友
                        echo "<h3>未確認好友</h3>";
                        foreach ($addmefriends as $addmefriend){ ?>

                            <div class="friend-box">
                                <div class="col-md-3">
                                    <img src="<?php echo $addmefriend['photo'];?>" style="max-width: 60px;">
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li>姓名：<?php echo $addmefriend['name'];?></li>
                                        <li>電話：<?php echo $addmefriend['phone'];?></li>
                                        <li>email：<?php echo $addmefriend['email'];?></li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success" onclick="location='friend.php?do=resaddFriend&id=<?php echo $addmefriend['SID'];?>&res=1'">成為好友</button>
                                    <button class="btn btn-warning" onclick="location='friend.php?do=resaddFriend&id=<?php echo $addmefriend['SID'];?>&res=0'">拒絕好友</button>
                                </div>
                            </div>
                            <hr>


                    <?php }
                    }
                    $friends = $cfriends->showFriend();
                    if(!empty($friends)){  //顯示好朋友
                        foreach ($friends as $friend){ ?>
                        <div class="friend-box" onclick="location='member.php?id=<?php echo $friend['SID'];?>'">
                            <div class="col-md-3">
                                <img src="<?php echo $friend['photo'];?>" style="max-width: 60px;">
                            </div>
                            <div class="col-md-9">
                                <ul>
                                    <li>姓名：<?php echo $friend['name'];?></li>
                                    <li>電話：<?php echo $friend['phone'];?></li>
                                    <li>email：<?php echo $friend['email'];?></li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                    <?php    }

                    }else{?>

                        <h3>您還沒有好友哦</h3>
                <?php } ?>
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
    </script>

</html>

