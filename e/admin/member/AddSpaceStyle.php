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
CheckLevel($logininid,$loginin,$classid,"spacestyle");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href='ListSpaceStyle.php".$ecms_hashur['whehref']."'>�����Ա�ռ�ģ��</a>&nbsp;->&nbsp;���ӻ�Ա�ռ�ģ��";
if($enews=="EditSpaceStyle")
{
	$styleid=(int)$_GET['styleid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsspacestyle where styleid='$styleid'");
	$url="<a href='ListSpaceStyle.php".$ecms_hashur['whehref']."'>�����Ա�ռ�ģ��</a>&nbsp;->&nbsp;�޸Ļ�Ա�ռ�ģ�壺<b>".$r[stylename]."</b>";
}
//��Ա��
$line=5;//һ����ʾ���
$i=0;
$mgsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($mgsql))
{
	$i++;
	$br='';
	if($i%$line==0)
	{
		$br='<br>';
	}
	if(strstr($r['membergroup'],','.$level_r['groupid'].','))
	{$checked=" checked";}
	else
	{$checked="";}
	$membergroup.="<input type='checkbox' name='membergroup[]' value='$level_r[groupid]'".$checked.">".$level_r[groupname]."&nbsp;".$br;
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��Ա�ռ�ģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListSpaceStyle.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="21%" height="25">���ӻ�Ա�ռ�ģ��</td>
      <td width="79%" height="25"><input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="styleid" type="hidden" id="styleid" value="<?=$styleid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ģ������</td>
      <td height="25"> <input name="stylename" type="text" id="stylename" value="<?=$r[stylename]?>" size="30"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ģ������ͼ</td>
      <td height="25"> <input name="stylepic" type="text" id="stylepic" value="<?=$r[stylepic]?>" size="30"> 
        <a onclick="window.open('../ecmseditor/FileMain.php?modtype=5&type=1&classid=&doing=2&field=stylepic<?=$ecms_hashur['ehref']?>','','width=700,height=550,scrollbars=yes');" title="ѡ�����ϴ���ͼƬ"><img src="../../data/images/changeimg.gif" width="22" height="22" border="0" align="absbottom"></a> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ѡ���ģ��Ļ�Ա��<br>
        <font color="#666666">(��ѡΪ�����ƻ�Ա��)</font> </td>
      <td height="25"><?=$membergroup?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ģ��Ŀ¼</td>
      <td height="25"> e/space/template/ 
        <input name="stylepath" type="text" id="stylepath" value="<?=$r[stylepath]?>" size="9"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"> <p>ģ��˵��</p></td>
      <td height="25"><textarea name="stylesay" cols="60" rows="5"><?=$r[stylesay]?></textarea> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
