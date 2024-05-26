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
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"menu");

//��ʾ����
function MenuClassToShow(){
	global $empire,$dbtbpre;
	//���ò˵�
	$showfastmenu=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmenuclass where classtype=1 limit 1");
	if($showfastmenu)
	{
		echo"<script>if(parent.document.getElementById('dofastmenu')==null||parent.document.getElementById('dofastmenu')=='undefined'){}else{parent.document.getElementById('dofastmenu').style.display='';}</script>";
	}
	$showextmenu=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmenuclass where classtype=3 limit 1");
	if($showextmenu)
	{
		echo"<script>if(parent.document.getElementById('doextmenu')==null||parent.document.getElementById('doextmenu')=='undefined'){}else{parent.document.getElementById('doextmenu').style.display='';}</script>";
	}
}

//���Ӳ˵�����
function AddMenuClass($add,$userid,$username){
	global $empire,$dbtbpre;
	$classtype=(int)$add['classtype'];
	if(!$add[classname])
	{
		printerror("EmptyMenuClass","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"menu");
	$myorder=(int)$add['myorder'];
	$add['classname']=hRepPostStr($add['classname'],1);
	$sql=$empire->query("insert into {$dbtbpre}enewsmenuclass(classname,myorder,classtype) values('".$add[classname]."','$myorder','$classtype');");
	$lastid=$empire->lastid();
	if($sql)
	{
		MenuClassToShow();
		//������־
		insert_dolog("classid=".$lastid."<br>classname=".$add[classname]);
		printerror("AddMenuClassSuccess","MenuClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ĳ˵�����
function EditMenuClass($add,$userid,$username){
	global $empire,$dbtbpre;
	$classid=$add['classid'];
	$delclassid=$add['delclassid'];
	$classname=$add['classname'];
	$myorder=$add['myorder'];
	$classtype=$add['classtype'];
	$count=count($classid);
	if(!$count)
	{
		printerror("EmptyMenuClass","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"menu");
	//ɾ��
	$del=0;
	$ids='';
	$delcount=count($delclassid);
	if($delcount)
	{
		$dh='';
		for($j=0;$j<$delcount;$j++)
		{
			$ids.=$dh.intval($delclassid[$j]);
			$dh=',';
		}
		$empire->query("delete from {$dbtbpre}enewsmenuclass where classid in (".$ids.")");
		$empire->query("delete from {$dbtbpre}enewsmenu where classid in (".$ids.")");
		$del=1;
	}
	//�޸�
	for($i=0;$i<$count;$i++)
	{
		$classid[$i]=(int)$classid[$i];
		if(strstr(','.$ids.',',','.$classid[$i].','))
		{
			continue;
		}
		$myorder[$i]=(int)$myorder[$i];
		$classtype[$i]=(int)$classtype[$i];
		$classname[$i]=hRepPostStr($classname[$i],1);
		$empire->query("update {$dbtbpre}enewsmenuclass set classname='".$classname[$i]."',myorder='".$myorder[$i]."',classtype='".$classtype[$i]."' where classid='".$classid[$i]."'");
	}
	MenuClassToShow();
	//������־
	insert_dolog("del=$del");
	printerror("EditMenuClassSuccess","MenuClass.php".hReturnEcmsHashStrHref2(1));
}

//�޸Ĳ˵������û�Ȩ��
function EditMenuClassGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$add['classid'];
	if(!$classid)
	{
		printerror("EmptyMenuClass","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"menu");
	$cr=$empire->fetch1("select classid,classname from {$dbtbpre}enewsmenuclass where classid='$classid'");
	if(!$cr['classid'])
	{
		printerror("EmptyMenuClass","history.go(-1)");
	}
	$groupid=$add['groupid'];
	$groupids='';
	$count=count($groupid);
	if($count)
	{
		for($i=0;$i<$count;$i++)
		{
			$gid=(int)$groupid[$i];
			if(!$gid)
			{
				continue;
			}
			$groupids.=','.$gid;
		}
		if($groupids)
		{
			$groupids.=',';
		}
	}
	$sql=$empire->query("update {$dbtbpre}enewsmenuclass set groupids='$groupids' where classid='$classid';");
	if($sql)
	{
		MenuClassToShow();
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$cr[classname]);
		printerror("EditMenuClassSuccess","ListMenu.php?classid=$classid".hReturnEcmsHashStrHref2(0));
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
}
if($enews=="AddMenuClass")//���Ӳ˵�����
{
	AddMenuClass($_POST,$logininid,$loginin);
}
elseif($enews=="EditMenuClass")//�޸Ĳ˵�����
{
	EditMenuClass($_POST,$logininid,$loginin);
}
elseif($enews=="EditMenuClassGroup")//�޸Ĳ˵������û�Ȩ��
{
	EditMenuClassGroup($_POST,$logininid,$loginin);
}
else
{}

$sql=$empire->query("select classid,classname,issys,myorder,classtype from {$dbtbpre}enewsmenuclass order by myorder,classid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����˵�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="38%">
<p>λ�ã�<a href="MenuClass.php<?=$ecms_hashur['whehref']?>">����˵�</a></p></td>
    <td><div align="right"> </div></td>
  </tr>
</table>

  
<br>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form2" method="post" action="MenuClass.php" onsubmit="return confirm('ȷ��Ҫ�ύ?');">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="6%"><div align="center">ɾ��</div></td>
      <td width="8%">��ʾ˳��</td>
      <td width="40%" height="25">��������</td>
      <td width="14%">�˵�����</td>
      <td width="32%" height="25"><div align="center">����˵�</div></td>
    </tr>
    <?php
  while($r=$empire->fetch($sql))
  {
  	if($r['issys'])
	{
		$checkbox='';		
	}
	else
	{
		$checkbox='<input name="delclassid[]" type="checkbox" id="delclassid[]" value="'.$r[classid].'">';
	}
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#DBEAF5'"> 
      <td><div align="center"> 
          <?=$checkbox?>
        </div></td>
      <td> <input name="myorder[]" type="text" id="myorder[]" value="<?=$r[myorder]?>" size="4"> 
      </td>
      <td height="25"> <input name="classname[]" type="text" id="classname[]" value="<?=$r[classname]?>"> 
        <input name="classid[]" type="hidden" id="classid[]" value="<?=$r[classid]?>"> 
      </td>
      <td><select name="classtype[]" id="classtype[]">
          <option value="1"<?=$r[classtype]==1?' selected':''?>>���ò���</option>
          <option value="2"<?=$r[classtype]==2?' selected':''?>>����˵�</option>
          <option value="3"<?=$r[classtype]==3?' selected':''?>>��չ�˵�</option>
        </select></td>
      <td height="25"><div align="center">[<a href="ListMenu.php?classid=<?=$r[classid]?><?=$ecms_hashur['ehref']?>">����˵�</a>]</div></td>
    </tr>
    <?php
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center"> 
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        </div></td>
      <td height="25" colspan="4"><input type="submit" name="Submit2" value="�ύ"> 
        <input name="enews" type="hidden" id="enews" value="EditMenuClass"> &nbsp; 
        &nbsp; <font color="#666666">(˵����˳��ֵԽС��ʾԽǰ��) </font></td>
    </tr>
  </form>
</table>
<br>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="MenuClass.php">
  <?=$ecms_hashur['form']?>
    <tr class="header">
      <td height="25">���Ӳ˵�����: 
        <input name=enews type=hidden id="enews" value=AddMenuClass>
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> ��������: 
        <input name="classname" type="text" id="classname">
        ����:
        <select name="classtype" id="classtype">
          <option value="1">���ò���</option>
          <option value="2">����˵�</option>
          <option value="3" selected>��չ�˵�</option>
        </select>
        ��ʾ˳��: 
        <input name="myorder" type="text" id="myorder" value="0" size="4"> 
        <input type="submit" name="Submit" value="����">
      </td>
    </tr>
	</form>
  </table>
</body>
</html>
<?php
db_close();
$empire=null;
?>