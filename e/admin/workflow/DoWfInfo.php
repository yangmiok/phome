<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
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

$isclose=(int)$_GET['isclose'];
if($isclose)
{
	echo"<script>window.close();</script>";
	exit();
}

//���
$ecmscheck=(int)$_GET['ecmscheck'];
$addecmscheck='';
$indexchecked=1;
if($ecmscheck)
{
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}
$id=(int)$_GET['id'];
$classid=(int)$_GET['classid'];
if(!$id||!$classid||!$class_r[$classid][tbname])
{
	printerror('ErrorUrl','');
}
//������
$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id' limit 1");
//���ر�
$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
$nr=$empire->fetch1("select id,classid,userid,username,isqf,title from ".$infotb." where id='$id' limit 1");
if(!$nr['id']||$classid!=$nr[classid]||!$nr[isqf])
{
	printerror('ErrorUrl','');
}
$r=$empire->fetch1("select id,wfid,tid,groupid,userclass,username,checknum,tstatus,checktno from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid' limit 1");
if(!$r['id'])
{
	printerror('ErrorUrl','');
}
//������
if($r[tid])
{
	$cwfitemr=$empire->fetch1("select wfid,groupid,userclass,username from {$dbtbpre}enewsworkflowitem where tid='$r[tid]'");
	if(strstr(','.$cwfitemr[groupid].',',','.$lur[groupid].',')||strstr(','.$cwfitemr[userclass].',',','.$lur[classid].',')||strstr(','.$cwfitemr[username].',',','.$lur[username].','))
	{
	}
	else
	{
		//printerror("NotDoCheckUserLevel","history.go(-1)");
	}
}
//������
$wfr=$empire->fetch1("select wfname from {$dbtbpre}enewsworkflow where wfid='$r[wfid]'");
//�ڵ�
$endwfitem=0;
$wfitems='';
$wfitemsql=$empire->query("select tid,tname from {$dbtbpre}enewsworkflowitem where wfid='$r[wfid]' order by tno");
while($wfitemr=$empire->fetch($wfitemsql))
{
	if($r[checktno]=='100')
	{
		$endwfitem=1;
	}
	$wfitemsch='&nbsp;&nbsp;';
	$select='';
	if($wfitemr[tid]==$r[tid]&&$endwfitem==0)
	{
		$select=' selected';
		$wfitemsch='&gt;';
	}
	$wfitems.="<option value='".$wfitemr[tid]."'".$select.">".$wfitemsch.$wfitemr[tname]."</option>";
}
//��¼
$logsql=$empire->query("select tid,username,checktime,checktext,checknum,checktype from {$dbtbpre}enewswfinfolog where id='$id' and classid='$classid' order by logid desc");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>ǩ����Ϣ</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="41%">��Ϣ��<a href="ShowWfInfo.php?classid=<?=$classid?>&id=<?=$r[id]?><?=$addecmscheck?><?=$ecms_hashur['ehref']?>" target=_blank> 
      <?=stripSlashes($nr[title])?>
      </a></td>
    <td width="59%"><div align="right">��������<?=$wfr[wfname]?>�����ȣ� 
        <select name="select">
		<?=$wfitems?>
		<?=$endwfitem==1?'<option value="0" selected>&gt;���ͨ��</option>':'<option value="0">&nbsp;&nbsp;���ͨ��</option>'?>
        </select>
      </div></td>
  </tr>
</table>
<form name="wfform" method="post" action="../ecmsinfo.php" onsubmit="return confirm('ȷ��Ҫ�ύ?');">
  <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td colspan="2">ǩ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%">����</td>
      <td width="80%"> 
        <input name="doing" type="radio" value="1" checked>
        ͨ�� 
        <input type="radio" name="doing" value="2">
        ���� 
        <input type="radio" name="doing" value="3">
        ���</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>����</td>
      <td> 
        <textarea name="checktext" cols="60" rows="8" id="textarea"></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td> 
        <input type="submit" name="Submit3" value="�ύ">
        <input name="enews" type="hidden" id="enews" value="DoWfInfo">
        <input name="classid" type="hidden" id="classid" value="<?=$classid?>">
        <input name="id" type="hidden" id="id" value="<?=$id?>">
		<input name="ecmscheck" type="hidden" id="ecmscheck" value="<?=$ecmscheck?>">
      </td>
    </tr>
  </table>
</form>
<table width="98%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <tr class="header"> 
    <td colspan="5">������¼</td>
  </tr>
  <tr> 
    <td width="17%"><div align="center">�ڵ�</div></td>
    <td width="7%"><div align="center">����</div></td>
    <td width="13%"><div align="center">ǩ����</div></td>
    <td width="18%"><div align="center">ʱ��</div></td>
    <td width="45%"><div align="center">����</div></td>
  </tr>
  <?php
  while($logr=$empire->fetch($logsql))
  {
  	//�ڵ�
	$itemr=$empire->fetch1("select tname from {$dbtbpre}enewsworkflowitem where tid='$logr[tid]'");
  	//����
  	$st='';
  	if($logr['checktype']==1)
	{
		$st='ͨ��';
	}
	elseif($logr['checktype']==2)
	{
		$st='����';
	}
	elseif($logr['checktype']==3)
	{
		$st='���';
	}
	elseif($logr['checktype']==0)
	{
		$st='����';
	}
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td> 
      <div align="center"><?=$itemr[tname]?></div></td>
    <td> 
      <div align="center"><b><?=$st?></b></div></td>
    <td> 
      <div align="center"><?=$logr['username']?></div></td>
    <td> 
      <div align="center"><?=date('Y-m-d H:i:s',$logr['checktime'])?></div></td>
    <td> 
      <?=nl2br($logr['checktext'])?>
    </td>
  </tr>
  <?php
  }
  ?>
</table>
<br>
</body>
</html>
<?
db_close();
$empire=null;
?>
