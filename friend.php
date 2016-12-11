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
include ('Controller/Auth.php');
include ('Controller/Gobal.php');
include ('Controller/Friend.php');
include ('Controller/Post.php');
$s = Auth::check();
if(!$s){
    return redirect('login.php?meg=nonlogin'); //沒有登入的話,跳到登入畫面
}else{
    $Auth = new Auth();
}
?>

<html>
    <?php include_once ('head.php'); ?>
    <body>
    <div class="container">
        <div class="header">
            <div class="input-group right" style="width: 20%;">
                <span class="input-group-addon">@</span>
                <input type="text" class="form-control" placeholder="Username">
            </div>
            <nav>
                <ul class="nav nav-pills pull-right">
                    <li role="presentation"><a href="logout.php">登出</a></li>
                </ul>
            </nav>
            <h3 class="text-muted">資管人聯絡簿</h3>
        </div>
        <div class="jumbotron">
            <div class="photo">
                <img style="max-width: 400px;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;" src="<?php echo $Auth->photo ;?>">
            </div>


            <div class="clear"></div>
            <div class="">

            </div>
            <div class="col-md-offset-3 col-md-2 ko" qw="好朋友">
                <img src="images/user.png" style="max-width: 80px;">
            </div>
            <div class="col-md-2 ko" qw="群組">
                <img src="images/team.png" style="max-width: 80px;">
            </div>
            <div class="col-md-2 ko" qw="訊息">
                <img src="images/networking.png" style="max-width: 80px;">
            </div>
        </div>
        <div class="row marketing">
            <div class="col-md-offset-3 col-lg-7" style="margin-top: 15px;">
                <?php
                    $cfriends = new Friend();
                    $friends = $cfriends->showFriend();
                    foreach ($friends as $friend){ ?>
                        <div class="friend-box" onclick="location='member.php?id=<?php echo $friend['SID'];?>'">
                            <div class="col-md-3">
                                <img src="<?php echo $friend['photo'];?>">
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
                ?>
            </div>
        </div>
        <footer class="footer">
            <?php include_once ('footer.php'); ?>
        </footer>
    </div>
    </body>
    <script>
        $('.ko').mouseenter(function() {
            layer.tips($(this).attr('qw'), this, {
                tips: [3, '#78BA32']
            });
        });
    </script>

</html>

