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
include ('Controller/Group.php');
$s = Auth::check();
if(!$s){
    return redirect('login.php?meg=nonlogin'); //沒有登入的話,跳到登入畫面
}else{
    $Auth = new Auth();
}
$group = new Group();
$mygroups = $group->getMy();
$myjoins = $group->showMyJoin(false);

if(isset($_POST)){
    if(isset($_POST['addgroup'])){
        $r = $group->add($_POST);
        if(!$r['status']){
            return redirect('?meg=gnameused');
            unset($r);
        }
    }elseif(isset($_POST['editgroup'])){
        $r = $group->edit($_POST,$_POST['groupid']);
        if(!$r['status']){
            return redirect('?meg=editerror');
            unset($r);
        }
    }
}

if(isset($_GET)){
    if(isset($_GET['do'])){
        switch ($_GET['do']){
            case 'addmember':{
                $okjoine = $group->okjoin($_GET['group_id'],$_GET['id']);
            }
        }
    }
}
$title = "群組-資管人聯絡簿";
?>

<html>
    <?php include_once ('head.php'); ?>
    <body>
    <div class="container">
        <?php include_once ("header.php");?>
        <div class="row marketing">
            <div class="col-md-offset-3 col-lg-7" style="margin-top: 15px;">
                <button class="btn btn-success" onclick="addGroup()" style="margin-bottom: 10px;">創建群組</button>
                <?php if(!empty($mygroups)) {  //顯示自己辦的群組 ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">你創建的群組</div>
                                <ul class="list-group">
                            <?php foreach ($mygroups as $mygroup){ ?>

                                        <li class="list-group-item">
                                            <div class="friend-box">
                                                <div class="col-md-3">
                                                    <img src="<?php echo $mygroup['gphoto'];?>" style="max-width: 60px;" class="img-circle">
                                                </div>
                                                <div class="col-md-9"  onclick="location='group_detail.php?id=<?php echo $mygroup['group_id'];?>'">
                                                    <div class="col-md-6">
                                                        <h3><?php echo $mygroup['gname'];?></h3>
                                                    </div>
                                                </div>
                                                <div class="btn-group" style="float: right;">

                                                    <ul role="menu">
                                                        <li><a onclick="editGroup(<?php echo $mygroup['group_id']; ?>,'<?php echo $mygroup['gname'];?>')">修改</a></li>
                                                        <li><a onclick="deleteGroup(<?php echo $mygroup['group_id']; ?>)">刪除</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php if(count($mygroup['join'])>0){ ?>
                                            <div class="col-md-offset-1 col-lg-11" style="margin-top: 15px;">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading">加入請求</div>
                                                    <ul class="list-group">
                                                        <?php foreach ($mygroup['join'] as $join){ ?>
                                                            <li class="list-group-item">
                                                                <img class="img-circle" style="max-width: 22px;" src="<?php echo $join[0]['photo'];?>">
                                                                <?php echo $join[0]['name'];?>
                                                                <div class="right">
                                                                    <button type="button" class="btn btn-info btn-xs" onclick=(location="group.php?do=addmember&id=<?php echo $join[0]['sid'];?>&group_id=<?php echo $join[0]['group_id'];?>")>加入</button>
                                                                </div>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="clear"></div>
                                        </li>
                        <?php } ?>
                                </ul>
                    </div>
                <?php } ?>
                <?php if(!empty($myjoins)) {  //顯示自己辦的群組 ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">你加入的</div>
                        <ul class="list-group">
                            <?php foreach ($myjoins as $myjoin){ ?>

                                <li class="list-group-item">
                                    <div class="friend-box" onclick="location='group_detail.php?id=<?php echo $myjoin['group_id'];?>'">
                                        <div class="col-md-3">
                                            <img src="<?php echo $myjoin['gphoto'];?>" style="max-width: 60px;" class="img-circle">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="col-md-6">
                                                <h3><?php echo $myjoin['gname'];?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="addGroup" style="display: none;margin: 10px;">
            <form class="form-signin" role="form"  style="width: 300px;margin-left: auto;margin-right: auto;" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="addgroup" id="dd">
                <input type="hidden" name="groupid" id="groupid">
                <label for="inputEmail" class="sr-only">群組名稱</label>
                <div class="input-group">
                    <span class="input-group-addon"><img src="images/team.png" style="max-width: 18px;"> </span>
                    <input type="text" id="gname" name="gname" class="form-control" placeholder="群組名稱" required="true" autofocus="">
                </div>
                <label for="inputEmail" class="sr-only">群組照片</label>
                <div class="input-group" style="margin: 5px;">
                    <input type="file" id="gphoto" name="gphoto">
                </div>
                <button class="btn btn-ls btn-primary " style="margin-top: 15px;" type="submit">註冊</button>
            </form>
        </div>
        <footer class="footer">
            <?php include_once ('footer.php'); ?>
        </footer>
    </div>
    </body>
    <script>
        <?php include_once ('script.php');?>


        <?php  //顯示+好友數量
        $friend = new Friend();
        $resu = $friend->checkInvideFriend();
        if($resu){ ?>
        layer.tips('<?php echo count($resu);?>', '.goodfriend', {
            tips: [4, 'rgba(255, 10, 10, 0.75)']
        });
        <?php } ?>


        function addGroup() {
            layer.open({
                type: 1,
                shade: false,
                title: false, //不显示标题
                content: $('.addGroup'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            });
        }
        function deleteGroup(id) {
            layer.confirm('確定要刪除嗎？', {
                btn: ['確定','取消'] //按钮
            }, function(){
                location='deleteGroup.php?id='+id+"&page=group.php";
            });
        }
        function editGroup(id,gname) {
            $('.addGroup #gname').val("");
            $('.addGroup #gname').val(gname);
            $('.addGroup #dd').attr("name","editgroup")
            $('.addGroup #groupid').attr("value",id)
            layer.open({
                type: 1,
                shade: false,
                title: false, //不显示标题
                content: $('.addGroup'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            });
        }
    </script>

</html>

