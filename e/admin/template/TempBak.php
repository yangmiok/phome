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

$temptype=RepPostVar($_GET['temptype']);
$gid=(int)$_GET['gid'];
if(!$gid)
{
	$gid=GetDoTempGid();
}
if($temptype=='indexpage')
{
	$gid=1;
}
$tempid=(int)$_GET['tempid'];
if(!$temptype||!$gid||!$tempid)
{
	printerror("ErrorUrl","history.go(-1)");
}
//����Ȩ��
if($temptype=='tempvar')
{
	CheckLevel($logininid,$loginin,$classid,"tempvar");
}
else
{
	CheckLevel($logininid,$loginin,$classid,"template");
}
$gname=CheckTempGroup($gid);
$sql=$empire->query("select bid,tempname,baktime,lastuser from {$dbtbpre}enewstempbak where temptype='$temptype' and gid='$gid' and tempid='$tempid' order by bid desc");
$url='';
$urlgname=$gname."&nbsp;>&nbsp;";
//ģ������
if($temptype=='bqtemp')//��ǩģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewsbqtemp",$gid)." where tempid='$tempid'");
	$tname='��ǩģ��';
	$url=$urlgname."<a href='ListBqtemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>�����ǩģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='classtemp')//����ģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewsclasstemp",$gid)." where tempid='$tempid'");
	$tname='����ģ��';
	$url=$urlgname."<a href='ListClasstemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>�������ģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='jstemp')//JSģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewsjstemp",$gid)." where tempid='$tempid'");
	$tname='JSģ��';
	$url=$urlgname."<a href='ListJstemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>����JSģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='listtemp')//�б�ģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewslisttemp",$gid)." where tempid='$tempid'");
	$tname='�б�ģ��';
	$url=$urlgname."<a href='ListListtemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>�����б�ģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='newstemp')//����ģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewsnewstemp",$gid)." where tempid='$tempid'");
	$tname='����ģ��';
	$url=$urlgname."<a href='ListNewstemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>��������ģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='pltemp')//����ģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewspltemp",$gid)." where tempid='$tempid'");
	$tname='����ģ��';
	$url=$urlgname."<a href='ListPltemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>��������ģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='printtemp')//��ӡģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewsprinttemp",$gid)." where tempid='$tempid'");
	$tname='��ӡģ��';
	$url=$urlgname."<a href='ListPrinttemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>�����ӡģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='searchtemp')//����ģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewssearchtemp",$gid)." where tempid='$tempid'");
	$tname='����ģ��';
	$url=$urlgname."<a href='ListSearchtemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>��������ģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='tempvar')//����ģ�����
{
	$tr=$empire->fetch1("select myvar,varname from ".GetDoTemptb("enewstempvar",$gid)." where varid='$tempid'");
	$tname='����ģ�����';
	$url=$urlgname."<a href='ListTempvar.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>������ģ�����</a>&nbsp;>&nbsp;���� <b>".$tr[myvar]." (".$tr[varname].")</b> ���޸ļ�¼";
}
elseif($temptype=='votetemp')//ͶƱģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewsvotetemp",$gid)." where tempid='$tempid'");
	$tname='ͶƱģ��';
	$url=$urlgname."<a href='ListVotetemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>����ͶƱģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='pagetemp')//�Զ���ҳ��ģ��
{
	$tr=$empire->fetch1("select tempname from ".GetDoTemptb("enewspagetemp",$gid)." where tempid='$tempid'");
	$tname='�Զ���ҳ��ģ��';
	$url=$urlgname."<a href='ListPagetemp.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>�����Զ���ҳ��ģ��</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
elseif($temptype=='indexpage')//��ҳ����ģ��
{
	$tr=$empire->fetch1("select tempname from {$dbtbpre}enewsindexpage where tempid='$tempid'");
	$tname='��ҳ����';
	$url=$urlgname."<a href='ListIndexpage.php?gid=$gid".$ecms_hashur['ehref']."' target='_blank'>������ҳ����</a>&nbsp;>&nbsp;ģ�� <b>$tr[tempname]</b> ���޸ļ�¼";
}
//����ģ��
elseif($temptype=='pubindextemp')//��ҳģ��
{
	$tname='��ҳģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>��ҳģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubcptemp')//�������ģ��
{
	$tname='�������ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>�������ģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubsearchtemp')//�߼�������ģ��
{
	$tname='�߼�������ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>�߼�������ģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubsearchjstemp')//����JSģ��[����]
{
	$tname='����JSģ��[����]';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>����JSģ��[����]</b> ���޸ļ�¼";
}
elseif($temptype=='pubsearchjstemp1')//����JSģ��[����]
{
	$tname='����JSģ��[����]';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>����JSģ��[����]</b> ���޸ļ�¼";
}
elseif($temptype=='pubotherlinktemp')//�������ģ��
{
	$tname='�������ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>�������ģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubdownsofttemp')//���ص�ַģ��
{
	$tname='���ص�ַģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>���ص�ַģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubonlinemovietemp')//���߲��ŵ�ַģ��
{
	$tname='���߲��ŵ�ַģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>���߲��ŵ�ַģ��</b> ���޸ļ�¼";
}
elseif($temptype=='publistpagetemp')//�б��ҳģ��
{
	$tname='�б��ҳģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>�б��ҳģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubpljstemp')//����JS����ģ��
{
	$tname='����JS����ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>����JS����ģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubdownpagetemp')//��������ҳģ��
{
	$tname='��������ҳģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>��������ҳģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubgbooktemp')//���԰�ģ��
{
	$tname='���԰�ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>���԰�ģ��</b> ���޸ļ�¼";
}
elseif($temptype=='publoginiframe')//��½״̬ģ��
{
	$tname='��½״̬ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>��½״̬ģ��</b> ���޸ļ�¼";
}
elseif($temptype=='publoginjstemp')//JS���õ�½״̬ģ��
{
	$tname='JS���õ�½״̬ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>JS���õ�½״̬ģ��</b> ���޸ļ�¼";
}
elseif($temptype=='pubschalltemp')//ȫվ����ģ��
{
	$tname='ȫվ����ģ��';
	$url=$urlgname."����ģ��&nbsp;>&nbsp;<b>ȫվ����ģ��</b> ���޸ļ�¼";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$tname?> ���޸ļ�¼</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script language="javascript">
window.resizeTo(550,600);
window.focus();
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr> 
    <td height="25">λ�ã�<?=$url?></td>
    </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="52%" height="25"> <div align="center">�޸�ʱ��</div></td>
    <td width="29%" height="25"> <div align="center">�޸���</div></td>
    <td width="19%"><div align="center">��ԭ</div></td>
  </tr>
  <?php
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25"><div align="center"> 
        <?=date("Y-m-d H:i:s",$r['baktime'])?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r['lastuser']?>
      </div></td>
    <td><div align="center">[<a href="../ecmstemp.php?enews=ReEBakTemp&bid=<?=$r['bid']?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫ��ԭ?');">��ԭ</a>]</div></td>
  </tr>
  <?php
  }
  ?>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>