<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
require("../../data/dbcache/class.php");
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

$ztid=(int)$_GET['ztid'];
//��֤Ȩ��
//CheckLevel($logininid,$loginin,$ztid,"zt");
$returnandlevel=CheckAndUsernamesLevel('dozt',$ztid,$logininid,$loginin,$loginlevel);

$search='';
$search.=$ecms_hashur['ehref'];
//ר��
$ztr=$empire->fetch1("select ztid,ztname,restb from {$dbtbpre}enewszt where ztid='$ztid' limit 1");
if(!$ztr['ztid'])
{
	printerror('ErrorUrl','');
}
$pubid='-'.$ztid;
$start=0;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
//ÿҳ��ʾ
$line=(int)$_GET['line'];
if($line>0&&$line<1000)
{
	$search.='&line='.$line;
}
else
{
	$line=30;
}
$page_line=12;
$offset=$page*$line;
$search.="&ztid=$ztid";
$add='';
//�Ƽ�
$isgood=(int)$_GET['isgood'];
if($isgood)
{
	$add.=' and isgood=1';
	$search.="&isgood=$isgood";
}
//���
$checked=(int)$_GET['checked'];
if($checked)
{
	$add.=" and checked='".($checked==1?0:1)."'";
	$search.="&checked=$checked";
}
//����
$keyboard=RepPostVar2($_GET['keyboard']);
if($keyboard)
{
	$show=(int)$_GET['show'];
	if($show==1)
	{
		$where="username like '%".$keyboard."%'";
	}
	elseif($show==3)
	{
		$where="saytext like '%".$keyboard."%'";
	}
	else
	{
		$where="sayip like '%".$keyboard."%'";
	}
	$add.=' and '.$where;
	$search.="&keyboard=$keyboard&show=$show";
}
$query="select plid,username,saytime,sayip,checked,zcnum,fdnum,userid,isgood,saytext,pubid,eipport from {$dbtbpre}enewspl_".$ztr['restb']." where pubid='$pubid'".$add;
$totalquery="select count(*) as total from {$dbtbpre}enewspl_".$ztr['restb']." where pubid='$pubid'".$add;
//ȡ��������
$totalnum=(int)$_GET['totalnum'];
if($totalnum>0)
{
	$num=$totalnum;
}
else
{
	$num=$empire->gettotal($totalquery);
}
$query.=" order by plid desc limit $offset,$line";
$sql=$empire->query($query);
$search.='&totalnum='.$num;
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//����
$zturl=sys_ReturnBqZtname($ztr);
$url='<a href="'.$zturl.'" target="_blank">'.$ztr['ztname'].'</a>&nbsp;>&nbsp;��������';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��������</title>
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
<style>
.ecomment {margin:0;padding:0;}
.ecomment {margin-bottom:12px;overflow-x:hidden;overflow-y:hidden;padding-bottom:3px;padding-left:3px;padding-right:3px;padding-top:3px;background:#FFFFEE;padding:3px;border:solid 1px #999;}
.ecommentauthor {float:left; color:#F96; font-weight:bold;}
.ecommenttext {clear:left;margin:0;padding:0;}
</style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ��:<?=$url?></td>
  </tr>
</table>

  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <form name="form2" method="get" action="ListZtPl.php">
  <?=$ecms_hashur['eform']?>
    <tr>
      <td>�ؼ��֣� 
        <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
        <select name="show" id="show">
          <option value="1"<?=$show==1?' selected':''?>>������</option>
          <option value="2"<?=$show==2?' selected':''?>>IP��ַ</option>
		  <option value="3"<?=$show==3?' selected':''?>>��������</option>
        </select>
		<select name="checked" id="checked">
          <option value="0"<?=$checked==0?' selected':''?>>����</option>
          <option value="1"<?=$checked==1?' selected':''?>>�����</option>
          <option value="2"<?=$checked==2?' selected':''?>>δ���</option>
        </select>
        <input name="isgood" type="checkbox" id="isgood" value="1"<?=$isgood==1?' checked':''?>>
        �Ƽ�
        <select name="line" id="line">
          <option value="30"<?=$line==30?' selected':''?>>ÿҳ30��</option>
          <option value="50"<?=$line==50?' selected':''?>>ÿҳ50��</option>
          <option value="100"<?=$line==100?' selected':''?>>ÿҳ100��</option>
        </select>
        <input type="submit" name="Submit2" value="��������">
        <input name=ztid type=hidden id="ztid" value=<?=$ztid?>>
      </td>
    </tr>
	</form>
  </table>

<form name="form1" method="post" action="../ecmspl.php">
<?=$ecms_hashur['form']?>
<input type=hidden name=ztid value=<?=$ztid?>>
  <input name="isgood" type="hidden" id="isgood" value="1">
  <input type=hidden name=restb value=<?=$ztr['restb']?>>
  <input name="docheck" type="hidden" id="docheck" value="0">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" style="WORD-BREAK: break-all; WORD-WRAP: break-word">
    <tr class="header"> 
      <td width="4%" height="25"><div align="center">ѡ��</div></td>
      <td width="19%" height="25"><div align="center">����</div></td>
      <td width="49%" height="25"><div align="center">��������</div></td>
      <td width="14%" height="25"><div align="center">����ʱ��</div></td>
      <td width="14%" height="25"><div align="center">IP</div></td>
    </tr>
    <?php
	while($r=$empire->fetch($sql))
	{
		if(!empty($r[checked]))
		{
			$checked=" title='δ���' style='background:#99C4E3'";
			$checkednc='<br>NC';
		}
		else
		{
			$checked="";
			$checkednc='';
		}
		if($r['userid'])
		{
			$r['username']="<a href='../member/AddMember.php?enews=EditMember&userid=$r[userid]".$ecms_hashur['ehref']."' target='_blank'><b>$r[username]</b></a>";
		}
		if(empty($r['username']))
		{
			$r['username']='����';
		}
		$r['saytime']=date('Y-m-d H:i:s',$r['saytime']);
		if($r[isgood])
		{
			$r[saytime]='<font color=red>'.$r[saytime].'</font>';
		}
		//�滻����
		$saytext=RepPltextFace(stripSlashes($r['saytext']));
	?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'" id=pl<?=$r[plid]?>> 
      <td height="25" valign="top"><div align="center"> 
          <input name="plid[]" type="checkbox" id="plid[]" value="<?=$r[plid]?>"<?=$checked?>><?=$checkednc?>
        </div></td>
      <td height="25" valign="top"><div align="center"> 
          <?=$r[username]?>
        </div></td>
      <td height="25" valign="top"> 
        <?=$saytext?>
      </td>
      <td height="25" valign="top"><div align="center"> 
          <?=$r['saytime']?>
        </div></td>
      <td height="25" valign="top"><div align="center"> 
          <?=$r[sayip]?>:<?=$r[eipport]?>
        </div></td>
    </tr>
    <?
	}
	db_close();
	$empire=null;
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> <div align="center"> 
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        </div></td>
      <td height="25" colspan="4"> <div align="right"> 
          <input type="submit" name="Submit" value="�������" onClick="document.form1.enews.value='CheckPl_all';document.form1.docheck.value='0';">
          &nbsp;&nbsp;&nbsp; 
		  <input type="submit" name="Submit" value="ȡ���������" onClick="document.form1.enews.value='CheckPl_all';document.form1.docheck.value='1';">
          &nbsp;&nbsp;&nbsp; 
          <input type="submit" name="Submit3" value="�Ƽ�����" onClick="document.form1.enews.value='DoGoodPl_all';document.form1.isgood.value='1';">
          &nbsp;&nbsp;&nbsp; 
          <input type="submit" name="Submit4" value="ȡ���Ƽ�����" onClick="document.form1.enews.value='DoGoodPl_all';document.form1.isgood.value='0';">
          &nbsp;&nbsp; &nbsp; 
          <input type="submit" name="Submit" value="ɾ��" onClick="document.form1.enews.value='DelPl_all';">
          <input name="enews" type="hidden" id="enews" value="DelPl_all">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp; </td>
      <td height="25" colspan="4">
        <?=$returnpage?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="5"><font color="#666666">˵������ѡ��Ϊ��ɫ����δ������ۣ��Ӵ�����Ϊ��½��Ա������ʱ���ɫΪ�Ƽ�����</font></td>
    </tr>
  </table>
</form>
</body>
</html>
