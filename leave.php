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

$title = "朋友-資管人聯絡簿";
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
            if(!empty($addmefriends)) {  //顯示+的朋友 ?>

            <?php }
            $friends = $cfriends->showFriend();
            if(!empty($friends)){  //顯示好朋友?>
            <div class="panel panel-success">
                <div class="panel-heading">選擇1位朋友傳送EMAIL</div>
                <ul class="list-group">
                    <?php    foreach ($friends as $friend){ ?>
                        <li class="list-group-item">
                            <div class="friend-box" onclick="beforesend('<?php echo $friend['name'];?>','<?php echo $friend['email'];?>')">
                                <div class="col-md-3">
                                    <img class="img-thumbnail" src="<?php echo $friend['photo'];?>" style="max-width: 60px;">
                                </div>
                                <div class="col-md-9">
                                    <ul>
                                        <li>姓名：<?php echo $friend['name'];?></li>
                                        <li>電話：<?php echo $friend['phone'];?></li>
                                        <li>email：<?php echo $friend['email'];?></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                </ul>
                    <?php    }
                    }else{ ?>

                        <h3>您還沒有好友哦</h3>
                    <?php } ?>
                <form role="form" method="post" id="sendmail" style="padding: 20px;display: none;">
                    <div class="form-group">
                        <label for="exampleInputEmail1">電子郵件：</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" disabled name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">朋友：</label>
                        <input class="form-control" id="disabledFrienName" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">標題</label>
                        <input class="form-control" type="text" placeholder="標題" name="subject" id="subject">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile" >內容</label>
                        <textarea class="form-control" rows="3" id="mailbody"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default" onclick="send();return false;">送出</button>
                </form>

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

    function beforesend(name,email) {
        $('.list-group-item').hide();
        $('.panel-heading').html('傳送給'+name);
        $('#exampleInputEmail1').val(email);
        $('#disabledFrienName').val(name);
        $('#sendmail').fadeIn();
    }
    
    function send() {
        var index;
            $.ajax({
                url: 'mail.php',
                type: "POST",
                data: {name:$('#disabledFrienName').val(),email:$('#exampleInputEmail1').val(),body:$('#mailbody').val(),subject:$('#subject').val()},
                dataType: "json",
                beforeSend: function () {
                    index = layer.load();
                },
                complete: function () {
                    layer.close(index);
                },
                success: function (data) {
                    if(data){
                        layer.alert('成功');
                    }
                }
            });

        return false;
    }
</script>

</html>

