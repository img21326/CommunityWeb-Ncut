<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:45
 */
include ('Connect/Connect.php');
include ('Controller/Gobal.php');
include ('Controller/Auth.php');
include ('Controller/Friend.php');
//
session_start();
//$arr =[
//    "username" => "user",
//    "password" => "user",
//];
//$s = Auth::login($arr);

//
//$s = new Friend();
//$q = $s->getFriend();
//echo implode(',',$q);



//檢查是否登入
$s = Auth::check();
if(!$s){
    return redirect('login.php'); //沒有登入的話,跳到登入畫面
}else{
    $Auth = new Auth();
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset=utf-8>
        <meta http-equiv=X-UA-Compatible content="IE=edge">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="style.css">
    </head>
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
            <div class="col-md-3">
                <img src="images/attach.png" style="max-width: 120px;">
            </div>
            <div class="col-md-3">
                <img src="images/brainstorming.png" style="max-width: 120px;">
            </div>
            <div class="col-md-3">
                <img src="images/content.png" style="max-width: 120px;">
            </div>
            <div class="col-md-3">
                <img src="images/message.png" style="max-width: 120px;">
            </div>
        </div>
        <div class="row marketing">
            <div class="col-lg-6">
                <h4>Subheading</h4><p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
                <h4>Subheading</h4><p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
                <h4>Subheading</h4><p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p></div><div class="col-lg-6">
                <h4>Subheading</h4><p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
                <h4>Subheading</h4><p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>
                <h4>Subheading</h4><p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
            </div>
        </div>
        <footer class="footer">
            <p>© Company 2014</p>
        </footer>
    </div>
    </body>


</html>

