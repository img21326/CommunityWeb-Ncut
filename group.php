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
?>

<html>
    <?php include_once ('head.php'); ?>
    <body>
    <div class="container">
        <?php include_once ("header.php");?>
        <div class="row marketing">
            <div class="col-md-offset-3 col-lg-7" style="margin-top: 15px;">
                <button class="btn btn-success" onclick="addGroup()" style="margin-bottom: 10px;">創建群組</button>
                <?php
                    $mygroups = $group->getMy();
                    if(!empty($mygroups)) {  //顯示擬辦的群組 ?>
                <div class="panel panel-default">
                    <div class="panel-heading">你創建的群組</div>
                            <ul class="list-group">
                        <?php foreach ($mygroups as $mygroup){ ?>

                                    <li class="list-group-item">
                                        <div class="group-box">
                                            <div class="col-md-3">
                                                <img src="<?php echo $mygroup['gphoto'];?>" style="max-width: 60px;" class="img-circle">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="col-md-6">
                                                    <h3><?php echo $mygroup['gname'];?></h3>
                                                </div>
                                            </div>
                                            <div class="btn-group" style="float: right;">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">選項 <span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a onclick="editGroup(<?php echo $mygroup['group_id']; ?>,'<?php echo $mygroup['gname'];?>')">修改</a></li>
                                                    <li><a onclick="deleteGroup(<?php echo $mygroup['group_id']; ?>)">刪除</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </li>


                    <?php } ?>
                            </ul>
                </div>
                   <?php }
                    //$friends = $cfriends->showFriend();
                    //if(!empty($friends)){  //顯示好朋友
                     //   foreach ($friends as $friend){ ?>
                        <div class="friend-box" onclick="location='member.php?id=<?php //echo $friend['SID'];?>'">
                            <div class="col-md-3">
                                <img src="<?php //echo $friend['photo'];?>" style="max-width: 60px;">
                            </div>
                            <div class="col-md-9">
<!--                                <ul>-->
<!--                                    <li>姓名：--><?php ////echo $friend['name'];?><!--</li>-->
<!--                                    <li>電話：--><?php ////echo $friend['phone'];?><!--</li>-->
<!--                                    <li>email：--><?php ////echo $friend['email'];?><!--</li>-->
<!--                                </ul>-->
                            </div>
                        </div>

                    <?php    //}

                    //}else{?>

<!--                        <h3>您還沒有好友哦</h3>-->
                <?php //} ?>
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

