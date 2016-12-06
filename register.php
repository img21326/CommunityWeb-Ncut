<?php
include("conn.php")
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>個人資料</title>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>

<body>
<?php
if(isset($_SESSION['SID'])){
	if(isset($_POST['actionOK'])){
		$sql="INSERT INTO `contact` (`SID`, `num_txt`, `password`, `name`, `phone`, `email`, `FID`, `group_id`, `sday`, `status`) VALUES ('".$_POST['SID']."', '".$_POST['numtxt']."', '".$_POST['password']."','".$_POST['name']."', '".$_POST['phone']."', '".$_POST['FID']."', '".$_POST['group_id']."', '".$_POST['sday']."', '".$_POST['status']."');";
		if(mysql_query($sql)){
			echo("資料更新成功");
		}else{
			echo("資料更新失敗");
		}
	}
?>
<form id="form1" name="form1" method="post" action="">
<table width="37%" border="1">
  <tr>
    <td>SID</td>
    <td>
      <label for="SID"></label>
      <input type="text" name="name" id="name" />
    </td>
  </tr>
  <tr>
    <td>帳號</td>
    <td><label for="numtxt"></label>
        <input type="text" name="numtxt" id="numtxt" /></td>
  </tr>
    <tr>
        <td>密碼</td>
        <td><label for="password"></label>
            <input type="text" name="password" id="password" /></td>
    </tr>
  <tr>
    <td>姓名</td>
    <td> <label for = "name"></label>
        <label for="name"></label>
        <input type="text" name="name" id="name" />
</td>
  </tr>
  <tr>
    <td>電話</td>
    <td><label for="phone"></label>
      <input type="text" name="phone" id="phone" /></td>
  </tr>
  <tr>
    <td height="25">email</td>
    <td><label for="email"></label>
      <input type="text" name="email" id="email" /></td>
  </tr>
  <tr>
    <td>好友ID</td>
    <td><label for="FID"></label>
        <input type="text" name="name" id="name" />
  </tr>
  <tr>
    <td>社團ID</td>
    <td><label for="group_id"></label>
          <input type="text" name="name" id="name" />
  </tr>
        <td>創辦日期</td>
        <td><label for="sday"></label>
            <input type="text" name="sday" id="sday" /></td>
  <tr>
    <td colspan="2"><input type="submit" name="actionOK" id="button" value="送出" /></td>
  </tr>
</table>
</form>
<?php
}else{
	echo("還沒登入系統!!");
}
?>
<p><a href="mysql.php">回登入首頁</a></p>
</body>
</html>