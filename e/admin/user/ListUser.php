<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"user");

//------------------------�����û�
function AddUser($username,$password,$repassword,$groupid,$adminclass,$checked,$styleid,$loginuserid,$loginusername){
	global $empire,$class_r,$dbtbpre;
	$username=str_replace(',','',$username);
	$username=str_replace('|','',$username);
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	if(!$username||!$password||!$repassword)
	{printerror("EmptyUsername","history.go(-1)");}
	if($password!=$repassword)
	{printerror("NotRepassword","history.go(-1)");}
	if(strlen($password)<6)
	{
		printerror("LessPassword","history.go(-1)");
	}
	//����Ȩ��
	CheckLevel($loginuserid,$loginusername,$classid,"user");
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsuser where username='$username' limit 1");
	if($num)
	{printerror("ReUsername","history.go(-1)");}
	//����Ŀ¼
	$insert_class='';
	for($i=0;$i<count($adminclass);$i++)
	{
		$adminclass[$i]=(int)$adminclass[$i];
		//����Ŀ
		if(empty($class_r[$adminclass[$i]][islast]))
		{
			if(empty($class_r[$adminclass[$i]][sonclass])||$class_r[$adminclass[$i]][sonclass]=="|")
			{
				continue;
			}
			else
			{
				$andclass=substr($class_r[$adminclass[$i]][sonclass],1);
			}
			$insert_class.=$andclass;
		}
		else
		{
			$insert_class.=$adminclass[$i]."|";
		}
    }
	$insert_class="|".$insert_class;
	$styleid=(int)$styleid;
	$groupid=(int)$groupid;
	$checked=(int)$checked;
	$filelevel=(int)$_POST['filelevel'];
	$classid=(int)$_POST['classid'];
	$rnd=make_password(20);
	$salt=make_password(8);
	$salt2=make_password(20);
	$password=DoEmpireCMSAdminPassword($password,$salt,$salt2);
	$truename=hRepPostStr($_POST['truename'],1);
	$email=hRepPostStr($_POST['email'],1);
	$openip=hRepPostStr($_POST['openip'],1);
	$wname=hRepPostStr($_POST['wname'],1);
	$tel=hRepPostStr($_POST['tel'],1);
	$wxno=hRepPostStr($_POST['wxno'],1);
	$qq=hRepPostStr($_POST['qq'],1);
	$addtime=time();
	$addip=egetip();
	$addipport=egetipport();
	$userprikey=make_password(48);
	$insert_class=hRepPostStr2($insert_class);
	$sql=$empire->query("insert into {$dbtbpre}enewsuser(username,password,rnd,groupid,adminclass,checked,styleid,filelevel,salt,loginnum,lasttime,lastip,truename,email,classid,addtime,addip,userprikey,salt2,lastipport,preipport,addipport,wname,tel,wxno,qq) values('$username','$password','$rnd','$groupid','$insert_class','$checked','$styleid','$filelevel','$salt',0,0,'','$truename','$email','$classid','$addtime','$addip','$userprikey','$salt2','$addipport','$addipport','$addipport','$wname','$tel','$wxno','$qq');");
	$userid=$empire->lastid();
	//��ȫ����
	$equestion=(int)$_POST['equestion'];
	$eanswer=$_POST['eanswer'];
	if($equestion)
	{
		if(!$eanswer)
		{
			printerror('EmptyEAnswer','');
		}
		$eanswer=ReturnHLoginQuestionStr($userid,$username,$equestion,$eanswer);
	}
	else
	{
		$equestion=0;
		$eanswer='';
	}
	$empire->query("insert into {$dbtbpre}enewsuseradd(userid,equestion,eanswer,openip) values('$userid','$equestion','$eanswer','$openip');");
	if($sql)
	{
		$cache_enews='douserinfo';
		$cache_ecmstourl=urlencode('user/AddUser.php?enews=AddUser'.hReturnEcmsHashStrHref2(0));
		$cache_mess='AddUserSuccess';
		$cache_uid=$userid;
		$cache_url="../CreateCache.php?enews=$cache_enews&uid=$cache_uid&ecmstourl=$cache_ecmstourl&mess=$cache_mess".hReturnEcmsHashStrHref2(0);
		//������־
		insert_dolog("userid=".$userid."<br>username=".$username);
		//printerror("AddUserSuccess","AddUser.php?enews=AddUser".hReturnEcmsHashStrHref2(0));
		echo'<meta http-equiv="refresh" content="0;url='.$cache_url.'">';
		db_close();
		$empire=null;
		exit();
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//------------------------�޸��û�
function EditUser($userid,$username,$password,$repassword,$groupid,$adminclass,$oldusername,$checked,$styleid,$loginuserid,$loginusername){
	global $empire,$class_r,$dbtbpre;
	$userid=(int)$userid;
	$oldusername=RepPostVar($oldusername);
	$username=str_replace(',','',$username);
	$username=str_replace('|','',$username);
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	$add='';
	if(!$userid||!$username)
	{printerror("EnterUsername","history.go(-1)");}
	//����Ȩ��
	CheckLevel($loginuserid,$loginusername,$classid,"user");
	//�޸��û���
	if($oldusername<>$username)
	{
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsuser where username='$username' and userid<>$userid limit 1");
		if($num)
		{printerror("ReUsername","history.go(-1)");}
		//�޸���Ϣ
		//$nsql=$empire->query("update {$dbtbpre}enewsnews set username='$username' where username='$oldusername'");
		//�޸���־
		$lsql=$empire->query("update {$dbtbpre}enewslog set username='$username' where username='$oldusername'");
		$lsql=$empire->query("update {$dbtbpre}enewsdolog set username='$username' where username='$oldusername'");
	}
	//�޸�����
	if($password)
	{
		if($password!=$repassword)
		{printerror("NotRepassword","history.go(-1)");}
		if(strlen($password)<6)
		{
			printerror("LessPassword","history.go(-1)");
		}
		$salt=make_password(8);
		$salt2=make_password(20);
		$password=DoEmpireCMSAdminPassword($password,$salt,$salt2);
		$add=",password='$password',salt='$salt',salt2='$salt2'";
	}
	//����Ŀ¼
	$insert_class='';
	for($i=0;$i<count($adminclass);$i++)
	{
		$adminclass[$i]=(int)$adminclass[$i];
		//����Ŀ
		if(empty($class_r[$adminclass[$i]][islast]))
		{
			if(empty($class_r[$adminclass[$i]][sonclass])||$class_r[$adminclass[$i]][sonclass]=="|")
			{
				continue;
			}
			else
			{
				$andclass=substr($class_r[$adminclass[$i]][sonclass],1);
			}
			$insert_class.=$andclass;
		}
		else
		{
			$insert_class.=$adminclass[$i]."|";
		}
    }
	$insert_class="|".$insert_class;
	$styleid=(int)$styleid;
	$groupid=(int)$groupid;
	$checked=(int)$checked;
	$filelevel=(int)$_POST['filelevel'];
	$classid=(int)$_POST['classid'];
	$truename=hRepPostStr($_POST['truename'],1);
	$email=hRepPostStr($_POST['email'],1);
	$openip=hRepPostStr($_POST['openip'],1);
	$wname=hRepPostStr($_POST['wname'],1);
	$tel=hRepPostStr($_POST['tel'],1);
	$wxno=hRepPostStr($_POST['wxno'],1);
	$qq=hRepPostStr($_POST['qq'],1);
	$insert_class=hRepPostStr2($insert_class);
	$sql=$empire->query("update {$dbtbpre}enewsuser set username='$username',groupid='$groupid',adminclass='$insert_class',checked='$checked',styleid='$styleid',filelevel='$filelevel',truename='$truename',email='$email',classid='$classid',wname='$wname',tel='$tel',wxno='$wxno',qq='$qq'".$add." where userid='$userid'");
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
	$empire->query("update {$dbtbpre}enewsuseradd set equestion='$equestion',openip='$openip'".$uadd." where userid='$userid'");
	if($sql)
	{
		//������־
		insert_dolog("userid=".$userid."<br>username=".$username);
		if($_POST['oldadminclass']<>$insert_class)
		{
			DelFiletext('../../data/fc/ListEnews'.$userid.'.php');
			DelFiletext('../../data/fc/userclass'.$userid.'.js');
			//ɾ����������
			$empire->query("delete from {$dbtbpre}enewsclassnavcache where navtype='userenews' and userid='$userid'");
			$cache_enews='douserinfo';
			$cache_ecmstourl=urlencode('user/ListUser.php'.hReturnEcmsHashStrHref2(1));
			$cache_mess='EditUserSuccess';
			$cache_uid=$userid;
			$cache_url="../CreateCache.php?enews=$cache_enews&uid=$cache_uid&ecmstourl=$cache_ecmstourl&mess=$cache_mess".hReturnEcmsHashStrHref2(0);
			echo'<meta http-equiv="refresh" content="0;url='.$cache_url.'">';
			db_close();
			$empire=null;
			exit();
		}
		printerror("EditUserSuccess","ListUser.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//-----------------------ɾ���û�
function DelUser($userid,$loginuserid,$loginusername){
	global $empire,$dbtbpre;
	$userid=(int)$userid;
	if(!$userid)
	{printerror("NotDelUserid","history.go(-1)");}
	//����Ȩ��
	CheckLevel($loginuserid,$loginusername,$classid,"user");
	//��֤�Ƿ����һ������Ա
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsuser");
	if($num<=1)
	{
		printerror("LastUserNotToDel","history.go(-1)");
	}
	$r=$empire->fetch1("select username from {$dbtbpre}enewsuser where userid='$userid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsuser where userid='$userid'");
	$sql1=$empire->query("delete from {$dbtbpre}enewsuseradd where userid='$userid'");
	if($sql)
	{
		DelFiletext('../../data/fc/ListEnews'.$userid.'.php');
		DelFiletext('../../data/fc/userclass'.$userid.'.js');
		//ɾ����������
		$empire->query("delete from {$dbtbpre}enewsclassnavcache where navtype='userenews' and userid='$userid'");
		//������־
		insert_dolog("userid=".$userid."<br>username=".$r[username]);
		printerror("DelUserSuccess","ListUser.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include('../../data/dbcache/class.php');
}
//�����û�
if($enews=="AddUser")
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$repassword=$_POST['repassword'];
	$groupid=$_POST['groupid'];
	$adminclass=$_POST['adminclass'];
	$checked=$_POST['checked'];
	$styleid=$_POST['styleid'];
	AddUser($username,$password,$repassword,$groupid,$adminclass,$checked,$styleid,$logininid,$loginin);
}
//�޸��û�
elseif($enews=="EditUser")
{
	$userid=$_POST['userid'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$repassword=$_POST['repassword'];
	$groupid=$_POST['groupid'];
	$adminclass=$_POST['adminclass'];
	$oldusername=$_POST['oldusername'];
	$checked=$_POST['checked'];
	$styleid=$_POST['styleid'];
	EditUser($userid,$username,$password,$repassword,$groupid,$adminclass,$oldusername,$checked,$styleid,$logininid,$loginin);
}
//ɾ���û�
elseif($enews=="DelUser")
{
	$userid=$_GET['userid'];
	DelUser($userid,$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$url="<a href=ListUser.php".$ecms_hashur['whehref'].">�����û�</a>";
//����
$mydesc=(int)$_GET['mydesc'];
$desc=$mydesc?'asc':'desc';
$orderby=(int)$_GET['orderby'];
if($orderby==1)//�û���
{
	$order="username ".$desc.",userid desc";
	$usernamedesc=$mydesc?0:1;
}
elseif($orderby==2)//�û���
{
	$order="groupid ".$desc.",userid desc";
	$groupiddesc=$mydesc?0:1;
}
elseif($orderby==3)//״̬
{
	$order="checked ".$desc.",userid desc";
	$checkeddesc=$mydesc?0:1;
}
elseif($orderby==4)//��½����
{
	$order="loginnum ".$desc.",userid desc";
	$loginnumdesc=$mydesc?0:1;
}
elseif($orderby==5)//����½
{
	$order="lasttime ".$desc.",userid desc";
	$lasttimedesc=$mydesc?0:1;
}
else//�û�ID
{
	$order="userid ".$desc;
	$useriddesc=$mydesc?0:1;
}
$search="&orderby=$orderby&mydesc=$mydesc".$ecms_hashur['ehref'];
$query="select * from {$dbtbpre}enewsuser";
$num=$empire->num($query);//ȡ��������
$query=$query." order by ".$order." limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����û�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="�����û�" onclick="self.location.href='AddUser.php?enews=AddUser<?=$ecms_hashur['ehref']?>';">&nbsp;&nbsp;
		<input type="button" name="Submit52" value="������" onclick="self.location.href='UserClass.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="4%" height="25"><div align="center"><a href="ListUser.php?orderby=0&mydesc=<?=$useriddesc?><?=$ecms_hashur['ehref']?>">ID</a></div></td>
    <td width="22%" height="25"><div align="center"><a href="ListUser.php?orderby=1&mydesc=<?=$usernamedesc?><?=$ecms_hashur['ehref']?>">�û���</a></div></td>
    <td width="20%"><div align="center"><a href="ListUser.php?orderby=2&mydesc=<?=$groupiddesc?><?=$ecms_hashur['ehref']?>">�ȼ�</a></div></td>
    <td width="6%"><div align="center"><a href="ListUser.php?orderby=3&mydesc=<?=$checkeddesc?><?=$ecms_hashur['ehref']?>">״̬</a></div></td>
    <td width="8%"><div align="center">֤��</div></td>
    <td width="8%"><div align="center"><a href="ListUser.php?orderby=4&mydesc=<?=$loginnumdesc?><?=$ecms_hashur['ehref']?>">��½����</a></div></td>
    <td width="19%"><div align="center"><a href="ListUser.php?orderby=5&mydesc=<?=$lasttimedesc?><?=$ecms_hashur['ehref']?>">����½</a></div></td>
    <td width="13%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  	$classname='--';
	if($r[classid])
	{
  		$cr=$empire->fetch1("select classname from {$dbtbpre}enewsuserclass where classid='$r[classid]'");
		$classname=$cr['classname'];
	}
	$gr=$empire->fetch1("select groupname from {$dbtbpre}enewsgroup where groupid='$r[groupid]'");
  	if($r[checked])
  	{$zt="����";}
  	else
  	{$zt="����";}
  	$lasttime='---';
  	if($r[lasttime])
  	{
  		$lasttime=date("Y-m-d H:i:s",$r[lasttime]);
  	}
	$usercertkey='--';
  ?>
  <tr bgcolor="ffffff" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"> 
        <?=$r[userid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[username]?>
      </div></td>
    <td> <div align="left">�û��飺
        <?=$gr[groupname]?>
        <br>
        ����&nbsp;&nbsp;&nbsp;��
        <?=$classname?>
      </div></td>
    <td><div align="center"> 
        <?=$zt?>
      </div></td>
    <td><div align="center"><?=$usercertkey?></div></td>
    <td><div align="center">
        <?=$r[loginnum]?>
      </div></td>
    <td> ʱ�䣺
      <?=$lasttime?>
      <br>
      IP&nbsp;&nbsp;&nbsp;��
      <?=$r[lastip]?$r[lastip].':'.$r[lastipport]:'---'?>
    </td>
    <td height="25"><div align="center">[<a href="AddUser.php?enews=EditUser&userid=<?=$r[userid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="ListUser.php?enews=DelUser&userid=<?=$r[userid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25" colspan="8"> 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
