<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//ehash
$ecms_hashur=hReturnEcmsHashStrAll();

//�޸�����
function EditPassword($userid,$username,$oldpassword,$password,$repassword,$styleid,$oldstyleid,$add){
	global $empire,$dbtbpre,$gr;
	$userid=(int)$userid;
	$styleid=(int)$styleid;
	$oldstyleid=(int)$oldstyleid;
	$username=RepPostVar($username);
	$oldpassword=RepPostVar($oldpassword);
	$password=RepPostVar($password);
	$truename=RepPostStr($add[truename]);
	$email=RepPostStr($add[email]);
	if(!$userid||!$username)
	{
		printerror("EmptyOldPassword","history.go(-1)");
	}
	//�޸�����
	$a='';
	if($oldpassword)
	{
		if(!$username||!$oldpassword)
		{
			printerror("EmptyOldPassword","history.go(-1)");
		}
		if(!trim($password)||!trim($repassword))
		{
			printerror("EmptyNewPassword","history.go(-1)");
		}
		if($password<>$repassword)
		{
			printerror("NotRepassword","history.go(-1)");
		}
		if(strlen($password)<6)
		{
			printerror("LessPassword","history.go(-1)");
		}
		$user_r=$empire->fetch1("select userid,password,salt,salt2 from {$dbtbpre}enewsuser where username='".$username."' limit 1");
		if(!$user_r['userid'])
		{
			printerror("OldPasswordFail","history.go(-1)");
		}
		$ch_oldpassword=DoEmpireCMSAdminPassword($oldpassword,$user_r['salt'],$user_r['salt2']);
		if($user_r['password']!=$ch_oldpassword)
		{
			printerror("OldPasswordFail","history.go(-1)");
		}
		$salt=make_password(8);
		$salt2=make_password(20);
		$password=DoEmpireCMSAdminPassword($password,$salt,$salt2);
		$a=",password='$password',salt='$salt',salt2='$salt2'";
	}
	//���
	if($gr['dochadminstyle'])
	{
		$a.=",styleid='$styleid'";
	}
	$sql=$empire->query("update {$dbtbpre}enewsuser set truename='$truename',email='$email'".$a." where username='$username'");
	//��ȫ����
	$equestion=(int)$_POST['equestion'];
	$eanswer=$_POST['eanswer'];
	$uadd='';
	if($equestion)
	{
		if($equestion!=$_POST['oldequestion']&&!$eanswer)
		{
			printerror('EmptyEAnswer','');
		}
		if($eanswer)
		{
			$eanswer=ReturnHLoginQuestionStr($userid,$username,$equestion,$eanswer);
			$uadd=",eanswer='$eanswer'";
		}
	}
	else
	{
		$uadd=",eanswer=''";
	}
	$empire->query("update {$dbtbpre}enewsuseradd set equestion='$equestion'".$uadd." where userid='$userid'");
	if($sql)
	{
		//������־
		insert_dolog("");
		//�ı���
		if($styleid!=$oldstyleid)
		{
			$styler=$empire->fetch1("select path from {$dbtbpre}enewsadminstyle where styleid='$styleid'");
			if($styler['path'])
			{
				$set=esetcookie("loginadminstyleid",$styler['path'],0,1);
			}
			printerror("EditPasswordSuccessLogin","../index.php");
			//echo"Edit password success!<script>parent.location.href='../admin.php".hReturnEcmsHashStrHref2(1)."';</script>";
			exit();
		}
		else
		{
			printerror("EditPasswordSuccess","EditPassword.php".hReturnEcmsHashStrHref2(1));
		}
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$gr=$empire->fetch1("select dochadminstyle from {$dbtbpre}enewsgroup where groupid='$loginlevel'");

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//�޸�����
if($enews=="EditPassword")
{
	$oldpassword=$_POST['oldpassword'];
	$password=$_POST['password'];
	$repassword=$_POST['repassword'];
	$styleid=(int)$_POST['styleid'];
	$oldstyleid=(int)$_POST['oldstyleid'];
	EditPassword($logininid,$loginin,$oldpassword,$password,$repassword,$styleid,$oldstyleid,$_POST);
}

$r=$empire->fetch1("select userid,styleid,truename,email from {$dbtbpre}enewsuser where userid='$logininid'");
$addur=$empire->fetch1("select equestion from {$dbtbpre}enewsuseradd where userid='$r[userid]'");
if($gr['dochadminstyle'])
{
	//��̨��ʽ
	$stylesql=$empire->query("select styleid,stylename,path from {$dbtbpre}enewsadminstyle order by styleid");
	$style="";
	while($styler=$empire->fetch($stylesql))
	{
		if($r[styleid]==$styler[styleid])
		{$sselect=" selected";}
		else
		{$sselect="";}
		$style.="<option value=".$styler[styleid].$sselect.">".$styler[stylename]."</option>";
	}
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>�޸�����</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="EditPassword.php<?=$ecms_hashur['whehref']?>">�޸ĸ�������</a></td>
  </tr>
</table>
<form name="form1" method="post" action="EditPassword.php" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�޸����� 
        <input name="enews" type="hidden" id="enews" value="EditPassword"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">�û�����</td>
      <td width="81%" height="25"> 
        <?=$loginin?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����룺</td>
      <td height="25"><input name="oldpassword" type="password" id="oldpassword" size="32"> 
        <font color="#666666">(���޸�����,������) </font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����룺</td>
      <td height="25"><input name="password" type="password" id="password" size="32"> 
        <font color="#666666">(���޸�����,������) </font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�ظ������룺</td>
      <td height="25"><input name="repassword" type="password" id="repassword" size="32"> 
        <font color="#666666">(���޸�����,������) </font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25"><font color="#666666">(˵������������6λ���ϣ����ִ�Сд�������벻�ܰ�����$ 
      &amp; * # &lt; &gt; ' &quot; / \ % ; �ո�)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ȫ���ʣ�</td>
      <td height="25"> <select name="equestion" id="equestion">
          <option value="0"<?=$addur[equestion]==0?' selected':''?>>�ް�ȫ����</option>
          <option value="1"<?=$addur[equestion]==1?' selected':''?>>ĸ�׵�����</option>
          <option value="2"<?=$addur[equestion]==2?' selected':''?>>үү������</option>
          <option value="3"<?=$addur[equestion]==3?' selected':''?>>���׳����ĳ���</option>
          <option value="4"<?=$addur[equestion]==4?' selected':''?>>������һλ��ʦ������</option>
          <option value="5"<?=$addur[equestion]==5?' selected':''?>>�����˼�������ͺ�</option>
          <option value="6"<?=$addur[equestion]==6?' selected':''?>>����ϲ���Ĳ͹�����</option>
          <option value="7"<?=$addur[equestion]==7?' selected':''?>>��ʻִ�յ������λ����</option>
        </select> <font color="#666666"> 
        <input name="oldequestion" type="hidden" id="oldequestion" value="<?=$addur[equestion]?>">
        (������ð�ȫ���ʣ���¼ʱ��������Ӧ����Ŀ���ܵ�¼)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ȫ�ش�</td>
      <td height="25"><input name="eanswer" type="text" id="eanswer" size="32"> 
        <font color="#666666">(����޸Ĵ𰸣����ڴ������´𰸡����ִ�Сд)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������</td>
      <td height="25"><input name="truename" type="text" id="truename" value="<?=$r[truename]?>" size="32"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���䣺</td>
      <td height="25"><input name="email" type="text" id="email" value="<?=$r[email]?>" size="32"></td>
    </tr>
    <?php
	if($gr['dochadminstyle'])
	{
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�������棺</td>
      <td height="25"><select name="styleid" id="styleid">
          <?=$style?>
        </select> <input type="button" name="Submit6222322" value="�����̨��ʽ" onclick="window.open('../template/AdminStyle.php<?=$ecms_hashur['whehref']?>');"> 
        <input name="oldstyleid" type="hidden" id="oldstyleid" value="<?=$r[styleid]?>">      </td>
    </tr>
    <?php
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><font color="#666666">˵������������6λ���ϣ����ִ�Сд�������벻�ܰ�����$ 
        &amp; * # &lt; &gt; ' &quot; / \ % ; �ո�</font></td>
    </tr>
  </table>
</form>

</body>
</html>
