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
CheckLevel($logininid,$loginin,$classid,"public");

//����ҳ�滺�����
function SetPageCache($add,$userid,$username){
	global $empire,$dbtbpre;
	CheckLevel($userid,$username,$classid,"public");//��֤Ȩ��
	$add['ctimeopen']=(int)$add['ctimeopen'];
	$add['ctimeindex']=(int)$add['ctimeindex'];
	$add['ctimeclass']=(int)$add['ctimeclass'];
	$add['ctimelist']=(int)$add['ctimelist'];
	$add['ctimetext']=(int)$add['ctimetext'];
	$add['ctimett']=(int)$add['ctimett'];
	$add['ctimetags']=(int)$add['ctimetags'];
	$add['ctimeaddre']=(int)$add['ctimeaddre'];
	$add['ctimeqaddre']=(int)$add['ctimeqaddre'];
	$ctimelast=$add['ctimelast'];
	if($ctimelast)
	{
		$ctimelast=to_time($ctimelast);
	}
	$ctimelast=(int)$ctimelast;
	
	$sql=$empire->query("update {$dbtbpre}enewspublicadd set ctimeopen='$add[ctimeopen]',ctimeindex='$add[ctimeindex]',ctimeclass='$add[ctimeclass]',ctimelist='$add[ctimelist]',ctimetext='$add[ctimetext]',ctimett='$add[ctimett]',ctimetags='$add[ctimetags]',ctimegids='".eaddslashes($add[ctimegids])."',ctimernd='".eaddslashes($add[ctimernd])."',ctimecids='".eaddslashes($add[ctimecids])."',ctimelast='$ctimelast',ctimeaddre='$add[ctimeaddre]',ctimeqaddre='$add[ctimeqaddre]' limit 1");
	if($sql)
	{
		GetConfig();
		//������־
		insert_dolog("");
		printerror("SetPageCacheSuccess","SetPageCache.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//��ն�̬ҳ�滺��
function ClearPageCache($add,$userid,$username){
	global $empire,$dbtbpre,$ecms_config,$public_r;
	$cpage=(int)$add['cpage'];
	if(!$cpage)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$cachepager=ePagenoGetPageCache($cpage);
	if(!$cachepager['esyspath'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$basepath=$ecms_config['sets']['ecmscachepath'].$cachepager['esyspath'];
	$cpath=$cachepager['cpath']?'/'.$cachepager['cpath']:'';
	$docpath=$basepath.$cpath;
	$del=DelPath($docpath);
	if($cpath=='')
	{
		Ecms_eMkdir($docpath);
	}
	//������־
	insert_dolog("cpage=$cpage");
	printerror("ClearPageCacheSuccess",EcmsGetReturnUrl());
}


$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include("../../class/delpath.php");
}
if($enews=="SetPageCache")//����ҳ�滺�����
{
	SetPageCache($_POST,$logininid,$loginin);
}
elseif($enews=="ClearPageCache")//���ҳ�滺��
{
	@set_time_limit(1000);
	ClearPageCache($_GET,$logininid,$loginin);
}
else
{}

$r=$empire->fetch1("select * from {$dbtbpre}enewspublicadd limit 1");
$ctimelast='';
if($r['ctimelast'])
{
	$ctimelast=date("Y-m-d H:i:s",$r['ctimelast']);
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��̬ҳ��������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td width="49%">λ�ã�<a href="SetPageCache.php<?=$ecms_hashur['whehref']?>">��̬ҳ��������</a>    </td>
    <td width="51%">
	<div align="right" class="emenubutton">
      <input type="button" name="Submit522" value="���¶�̬ҳ�滺��" onclick="self.location.href='../ReHtml/ChangePageCache.php<?=$ecms_hashur['whehref']?>';">
    </div>
	</td>
  </tr>
</table>
<form name="setpublic" method="post" action="SetPageCache.php" onsubmit="return confirm('ȷ������?');" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="3">��̬ҳ�������� 
        <input name="enews" type="hidden" value="SetPageCache"></td>
    </tr>
    
	<tr bgcolor="#FFFFFF">
	  <td height="25">��������</td>
	  <td><input type="radio" name="ctimeopen" value="1"<?=$r['ctimeopen']==1?' checked':''?>>����
        <input type="radio" name="ctimeopen" value="0"<?=$r['ctimeopen']==0?' checked':''?>>�ر�</td>
      <td>&nbsp;</td>
	</tr>
	<tr bgcolor="#FFFFFF">
      <td width="16%" height="25">��ҳ����ʱ��</td>
      <td width="42%"><input name="ctimeindex" type="text" id="ctimeindex" value="<?=$r[ctimeindex]?>" size="28">
        ����<font color="#666666"> (�����Ա�����棬������Ϊ����)</font></td>
      <td width="42%">[<a href="SetPageCache.php?enews=ClearPageCache&cpage=1<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ����� ��ҳ �����ļ�?')">�����ҳ�����ļ�</a>]</td>
	</tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��Ŀ����ҳ����ʱ��</td>
      <td><input name="ctimeclass" type="text" id="ctimeclass" value="<?=$r[ctimeclass]?>" size="28">
      ����<font color="#666666"> (�����Ա�����棬������Ϊ����)</font></td>
      <td>[<a href="SetPageCache.php?enews=ClearPageCache&cpage=2<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ����� ��Ŀ����ҳ �����ļ�?')">�����Ŀ����ҳ�����ļ�</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��Ŀ�б�ҳ����ʱ��</td>
      <td><input name="ctimelist" type="text" id="ctimelist" value="<?=$r[ctimelist]?>" size="28">
      ����<font color="#666666"> (�����Ա�����棬������Ϊ����)</font></td>
      <td>[<a href="SetPageCache.php?enews=ClearPageCache&cpage=3<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ����� ��Ŀ�б�ҳ �����ļ�?')">�����Ŀ�б�ҳ�����ļ�</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��Ŀ����ҳ����ʱ��</td>
      <td><input name="ctimetext" type="text" id="ctimetext" value="<?=$r[ctimetext]?>" size="28">
      ����<font color="#666666"> (�����Ա�����棬������Ϊ����)</font></td>
      <td>[<a href="SetPageCache.php?enews=ClearPageCache&cpage=4<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ����� ��Ŀ����ҳ �����ļ�?')">�����Ŀ����ҳ�����ļ�</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�������ҳ����ʱ��</td>
      <td><input name="ctimett" type="text" id="ctimett" value="<?=$r[ctimett]?>" size="28">
      ����<font color="#666666"> (�����Ա�����棬������Ϊ����)</font></td>
      <td>[<a href="SetPageCache.php?enews=ClearPageCache&cpage=5<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ����� �������ҳ �����ļ�?')">��ձ������ҳ�����ļ�</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">TAGSҳ����ʱ��</td>
      <td><input name="ctimetags" type="text" id="ctimetags" value="<?=$r[ctimetags]?>" size="28">
      ����<font color="#666666"> (�����Ա�����棬������Ϊ����)</font></td>
      <td>[<a href="SetPageCache.php?enews=ClearPageCache&cpage=6<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ����� TAGSҳ �����ļ�?')">���TAGSҳ�����ļ�</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">������Ļ�Ա��ID</td>
      <td><input name="ctimegids" type="text" id="ctimegids" value="<?=$r[ctimegids]?>" size="28">
        <font color="#666666">(�����Ա��ID�ð�Ƕ��š�,������)</font></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">���������ĿID</td>
      <td><input name="ctimecids" type="text" id="ctimecids" value="<?=$r[ctimecids]?>" size="28">
        <font color="#666666">(�����ĿID�ð�Ƕ��š�,������)</font></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ļ��������ַ���</td>
      <td><input name="ctimernd" type="text" id="ctimernd" value="<?=$r[ctimernd]?>" size="28">
	  <input type="button" name="Submit32222" value="���" onclick="document.setpublic.ctimernd.value='<?=make_password(42)?>';">
      <font color="#666666">(10~60�������ַ�����ö����ַ����)</font></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�����ڱ�ʱ��ǰ�Ļ���</td>
      <td><input name="ctimelast" type="text" class="Wdate" id="ctimelast" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?=$ctimelast?>" size="28">
        <font color="#666666">(��ʱ��ǰ�Ļ��潫���¸��£���Ϊ������)</font></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��̨����/�༭��Ϣʱ</td>
      <td>
              <select name="ctimeaddre" id="ctimeaddre">
                <option value="0"<?=$r['ctimeaddre']==0?' selected':''?>>�����»���</option>
                <option value="1"<?=$r['ctimeaddre']==1?' selected':''?>>���µ�ǰ��Ŀ</option>
                <option value="2"<?=$r['ctimeaddre']==2?' selected':''?>>������ҳ</option>
                <option value="3"<?=$r['ctimeaddre']==3?' selected':''?>>���¸���Ŀ</option>
				<option value="4"<?=$r['ctimeaddre']==4?' selected':''?>>���¸���Ŀ����ҳ</option>
                <option value="5"<?=$r['ctimeaddre']==5?' selected':''?>>���µ�ǰ��Ŀ�븸��Ŀ</option>
                <option value="6"<?=$r['ctimeaddre']==6?' selected':''?>>���µ�ǰ��Ŀ������Ŀ����ҳ</option>
				<option value="7"<?=$r['ctimeaddre']==7?' selected':''?>>���µ�ǰ��Ŀ������Ŀ����ҳ��������</option>
				<option value="8"<?=$r['ctimeaddre']==8?' selected':''?>>���µ�ǰ��Ŀ������Ŀ����ҳ�����������TAGSҳ</option>
              </select>	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">ǰ̨����/�༭��Ϣʱ</td>
      <td>
                <select name="ctimeqaddre" id="ctimeqaddre">
                  <option value="0"<?=$r['ctimeqaddre']==0?' selected':''?>>�����»���</option>
                  <option value="1"<?=$r['ctimeqaddre']==1?' selected':''?>>���µ�ǰ��Ŀ</option>
                  <option value="2"<?=$r['ctimeqaddre']==2?' selected':''?>>������ҳ</option>
                  <option value="3"<?=$r['ctimeqaddre']==3?' selected':''?>>���¸���Ŀ</option>
				  <option value="4"<?=$r['ctimeqaddre']==4?' selected':''?>>���¸���Ŀ����ҳ</option>
                  <option value="5"<?=$r['ctimeqaddre']==5?' selected':''?>>���µ�ǰ��Ŀ�븸��Ŀ</option>
                  <option value="6"<?=$r['ctimeqaddre']==6?' selected':''?>>���µ�ǰ��Ŀ������Ŀ����ҳ</option>
				  <option value="7"<?=$r['ctimeqaddre']==7?' selected':''?>>���µ�ǰ��Ŀ������Ŀ����ҳ��������</option>
				  <option value="8"<?=$r['ctimeqaddre']==8?' selected':''?>>���µ�ǰ��Ŀ������Ŀ����ҳ�����������TAGSҳ</option>
                </select>	  </td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
      <td>[<a href="SetPageCache.php?enews=ClearPageCache&cpage=10000<?=$ecms_hashur['href']?>" onclick="return confirm('ȷ�����ȫ�������ļ�?')">���ȫ�������ļ�</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25" colspan="3"><font color="#666666">˵�������ӻ�༭��Ϣ�Զ����������ҳ���档���Ҫ������һƪ����ҳ���棬������Ŀѡ��������ѡ��������һƪ��Ϣ����</font></td>
    </tr>
  </table>
</form>
</body>
</html>
