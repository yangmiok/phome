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
CheckLevel($logininid,$loginin,$classid,"wap");

//����
function SetWap($add,$userid,$username){
	global $empire,$dbtbpre;
	$wapopen=(int)$add['wapopen'];
	$wapdefstyle=(int)$add['wapdefstyle'];
	$wapshowmid=RepPostVar($add['wapshowmid']);
	$waplistnum=(int)$add['waplistnum'];
	$wapsubtitle=(int)$add['wapsubtitle'];
	$wapchar=(int)$add['wapchar'];
	$add['wapshowdate']=hRepPostStr($add['wapshowdate'],1);
	$add['wapchstyle']=(int)$add['wapchstyle'];
	$sql=$empire->query("update {$dbtbpre}enewspublic set wapopen=$wapopen,wapdefstyle=$wapdefstyle,wapshowmid='$wapshowmid',waplistnum=$waplistnum,wapsubtitle=$wapsubtitle,wapshowdate='$add[wapshowdate]',wapchar='$wapchar',wapchstyle='$add[wapchstyle]' limit 1");
	//������־
	insert_dolog("");
	printerror("SetWapSuccess","SetWap.php".hReturnEcmsHashStrHref2(1));
}

$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=='SetWap')
{
	SetWap($_POST,$logininid,$loginin);
}

$r=$empire->fetch1("select wapopen,wapdefstyle,wapshowmid,waplistnum,wapsubtitle,wapshowdate,wapchar from {$dbtbpre}enewspublic limit 1");
//wapģ��
$wapdefstyles='';
$stylesql=$empire->query("select styleid,stylename from {$dbtbpre}enewswapstyle order by styleid");
while($styler=$empire->fetch($stylesql))
{
	$select='';
	if($styler['styleid']==$r['wapdefstyle'])
	{
		$select=' selected';
	}
	$wapdefstyles.="<option value='".$styler[styleid]."'".$select.">".$styler[stylename]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>WAP����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã�<a href="SetWap.php<?=$ecms_hashur['whehref']?>">WAP����</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit522" value="����WAPģ��" onclick="self.location.href='WapStyle.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="setwapform" method="post" action="SetWap.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">WAP���� 
        <input name=enews type=hidden value=SetWap></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����WAP</td>
      <td height="25"><input type="radio" name="wapopen" value="1"<?=$r[wapopen]==1?' checked':''?>>
        �� 
        <input type="radio" name="wapopen" value="0"<?=$r[wapopen]==0?' checked':''?>>
        �� </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">WAP�ַ���</td>
      <td height="25"><input type="radio" name="wapchar" value="2"<?=$r[wapchar]==2?' checked':''?>>
Ĭ�ϱ���
  <input type="radio" name="wapchar" value="1"<?=$r[wapchar]==1?' checked':''?>>
        UTF-8 
        <input type="radio" name="wapchar" value="0"<?=$r[wapchar]==0?' checked':''?>>
        UNICODE <font color="#666666">(һ�㰴Ĭ�ϼ���)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ֻ��ʾϵͳģ���б�</td>
      <td height="25"><input name="wapshowmid" type="text" id="wapshowmid" value="<?=$r[wapshowmid]?>"> 
        <font color="#666666">(���ģ��ID��&quot;,&quot;����,��Ϊ��ʾ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="20%" height="25">Ĭ��ʹ��WAPģ��</td>
      <td width="80%" height="25"><select name="wapdefstyle" id="wapdefstyle">
          <?=$wapdefstyles?>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">֧�ָı�ʹ��ģ��</td>
      <td height="25"><input type="radio" name="wapchstyle" value="1"<?=$r['wapchstyle']==1?' checked':''?>>��
          <input type="radio" name="wapchstyle" value="0"<?=$r['wapchstyle']==0?' checked':''?>>��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�б�ÿҳ��ʾ</td>
      <td height="25"> <input name="waplistnum" type="text" id="waplistnum" value="<?=$r[waplistnum]?>">
        ����Ϣ</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����ȡ</td>
      <td height="25"> <input name="wapsubtitle" type="text" id="wapsubtitle" value="<?=$r[wapsubtitle]?>">
        ���ֽ� <font color="#666666">(0Ϊ����ȡ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ʱ����ʾ��ʽ</td>
      <td height="25"><input name="wapshowdate" type="text" id="wapshowdate" value="<?=$r[wapshowdate]?>"> 
        <font color="#666666">(��ʽ��Y��ʾ��,m��ʾ��,d��ʾ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25">WAP��ַ��<a href="<?=$public_r[newsurl]?>e/wap/" target="_blank"><?=$public_r[newsurl]?>e/wap/</a></td>
    </tr>
  </table>
</form>
</body>
</html>
