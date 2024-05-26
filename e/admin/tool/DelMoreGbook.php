<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../class/com_functions.php");
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
CheckLevel($logininid,$loginin,$classid,"gbook");

//����ɾ������(����)
function DelMoreGbook($add,$logininid,$loginin){
	global $empire,$dbtbpre;
    CheckLevel($logininid,$loginin,$classid,"gbook");//��֤Ȩ��
	//��������
	$name=RepPostStr($add['name']);
	$ip=RepPostVar($add['ip']);
	$email=RepPostStr($add['email']);
	$mycall=RepPostStr($add['mycall']);
	$lytext=RepPostStr($add['lytext']);
	$startlyid=(int)$add['startlyid'];
	$endlyid=(int)$add['endlyid'];
	$startlytime=RepPostVar($add['startlytime']);
	$endlytime=RepPostVar($add['endlytime']);
	$checked=(int)$add['checked'];
	$ismember=(int)$add['ismember'];
	$bid=(int)$add['bid'];
	$havere=(int)$add['havere'];
	$where='';
	//���Է���
	if($bid)
	{
		$where.=" and bid='$bid'";
	}
	//�Ƿ��Ա
	if($ismember)
	{
		if($ismember==1)
		{
			$where.=" and userid=0";
		}
		else
		{
			$where.=" and userid>0";
		}
	}
	//����ID
	if($endlyid)
	{
		$where.=' and lyid BETWEEN '.$startlyid.' and '.$endlyid;
	}
	//����ʱ��
	if($startlytime&&$endlytime)
	{
		$where.=" and lytime>='$startlytime' and lytime<='$endlytime'";
	}
	//�Ƿ����
	if($checked)
	{
		$checkval=$checked==1?0:1;
		$where.=" and checked='$checkval'";
	}
	//�Ƿ�ظ�
	if($havere)
	{
		if($havere==1)
		{
			$where.=" and retext<>''";
		}
		else
		{
			$where.=" and retext=''";
		}
	}
	//����
	if($name)
	{
		$where.=" and name like '%$name%'";
	}
	//����IP
	if($ip)
	{
		$where.=" and ip like '%$ip%'";
	}
	//����
	if($email)
	{
		$where.=" and email like '%$email%'";
	}
	//�绰
	if($mycall)
	{
		$where.=" and `mycall` like '%$mycall%'";
	}
	//��������
	if($lytext)
	{
		$where.=" and lytext like '%$lytext%'";
	}
    if(!$where)
	{
		printerror("EmptyDelMoreGbook","history.go(-1)");
	}
	$where=substr($where,5);
	$sql=$empire->query("delete from {$dbtbpre}enewsgbook where ".$where);
	insert_dolog("");//������־
	printerror("DelGbookSuccess","DelMoreGbook.php".hReturnEcmsHashStrHref2(1));
}

$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='DelMoreGbook')
{
	@set_time_limit(0);
	DelMoreGbook($_POST,$logininid,$loginin);
}

$gbclass=ReturnGbookClass(0,0);

db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ɾ������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href=gbook.php<?=$ecms_hashur['whehref']?>>��������</a>&nbsp;>&nbsp;����ɾ������</td>
  </tr>
</table>
<form name="form1" method="post" action="DelMoreGbook.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">����ɾ������ <input name="enews" type="hidden" id="enews" value="DelMoreGbook"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�������Է��ࣺ</td>
      <td height="25"><select name="bid" id="bid">
          <option value="0">����</option>
		  <?=$gbclass?>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����IP������</td>
      <td height="25"><input name=ip type=text id="ip"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">����������</td>
      <td width="81%" height="25"><input name=name type=text id="name"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���������</td>
      <td height="25"><input name=email type=text id="email"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�绰������</td>
      <td height="25"><input name=mycall type=text id="mycall"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�������ݰ�����</td>
      <td height="25"><textarea name="lytext" cols="70" rows="5" id="lytext"></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ID ���ڣ�</td>
      <td height="25"><input name="startlyid" type="text" id="startlyid">
        -- 
        <input name="endlyid" type="text" id="endlyid"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">����ʱ�� ���ڣ�</td>
      <td height="25"><input name="startlytime" type="text" id="startlytime" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        -- 
        <input name="endlytime" type="text" id="endlytime" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        <font color="#666666">(��ʽ��2011-01-27)</font></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">�Ƿ��Ա������</td>
      <td height="25"><input name="ismember" type="radio" value="0" checked>
        ���� 
        <input type="radio" name="ismember" value="1">
        �οͷ��� 
        <input type="radio" name="ismember" value="2">
        ��Ա����</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25" valign="top">�Ƿ��лظ���</td>
      <td height="25"><input name="havere" type="radio" value="0" checked>
        ���� 
        <input name="havere" type="radio" value="1">
        �ѻظ����� 
        <input name="havere" type="radio" value="2">
        δ�ظ�����</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�Ƿ���ˣ�</td>
      <td height="25"><input name="checked" type="radio" value="0" checked>
        ���� 
        <input name="checked" type="radio" value="1">
        ���������
<input name="checked" type="radio" value="2">
        δ�������</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="ɾ������"> </td>
    </tr>
  </table>
</form>
</body>
</html>
