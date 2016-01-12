<?

session_start();
session_destroy();

include('config.php');

//*** DataBase Connection ***//
$objConnect = mysql_connect("$sys_hos","$sys_usr","$sys_pwd") or die(mysql_error());
$objDB = mysql_select_db("$sys_dbs");
#------------------------------------------------------------------------------#
function r_opr_chk($opr_cod,$opr_pwd) {
  $strSQL = "select opr_pos,opr_dep
              from opr_mas
              where opr_cod ='$opr_cod'
              and opr_pwd = old_password('$opr_pwd') ";
  $objQuery = mysql_query($strSQL);
  if(!$objQuery) {
    echo "Error Login [".mysql_error()."]";
  }
  $row_cnt = mysql_num_rows($objQuery);
  if ($row_cnt > 0) {
    return true;
  } else {
    return false;
  }
}     
  
#------------------------------------------------------------------------------#

$err_msg = "";
//*** Check User Condition ***//
if($_POST["hdnCmd"] == "Login")
{
   $hdnCmd == "";
   $opr_cod = $_POST["opr_cod"];
	 $opr_pwd = $_POST["opr_pwd"];
	 if ($opr_cod != "" && $opr_pwd != "") {
      $opr_chk = r_opr_chk($opr_cod,$opr_pwd);
      if ($opr_chk) {
        $err_msg = "";
        $hdnCmd = "Logined";
        session_register('logined');
        $_SESSION['ses_opr_cod'] = $opr_cod;
        $ses_opr_cod = $opr_cod;  
        mysql_close($objConnect);
        header( "refresh: 0; url=profile.php" );
        exit(0);
              
     } else {
        $err_msg = "Invalid User or Password";
        $hdnCmd = ""; 
     }
    }
}

echo "test";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Operation Phuket</title>
 <?php include('header.php'); ?>    
</head>
<body>
<? //if($hdnCmd == "Logined") { ?>
<? //include('mainmenu.php'); ?>
<? //} ?>


<? if($hdnCmd == "") { ?>
<div class="container">
  <form class="form-signin" name="frmMain" method="post" action="<?=$_SERVER["PHP_SELF"];?>">
     <input type="hidden" name="hdnCmd" value="<?=$hdnCmd;?>"> 
    <h2 class="form-signin-heading">Please sign in</h2>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="input" id="opr_cod" name="opr_cod" class="form-control" placeholder="User" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="opr_pwd" name="opr_pwd" class="form-control" placeholder="Password" required>
    <br>
    <button class="btn btn-lg btn-primary btn-block" OnClick="frmMain.hdnCmd.value='Login';frmMain.submit();">Sign in</button>
  </form>
</div> <!-- /container -->
<? } ?>

<? if ($err_msg != "") { ?>
<div class="container">
<div class="alert alert-dismissible alert-danger">
  <button class="close" type="button" data-dismiss="alert">�</button>
  <strong>Error!</strong>&nbsp;&nbsp;<? echo $err_msg; ?>
</div>
</div>
<? } ?>


<? mysql_close($objConnect); ?>
<?php include('footer.php'); ?>    
</body>
</html>