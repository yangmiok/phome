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
CheckLevel($logininid,$loginin,$classid,"template");
$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;>&nbsp;";
$cid=ehtmlspecialchars($_GET['cid']);
$enews=ehtmlspecialchars($_GET['enews']);
$url=$urlgname."<a href=ListPagetemp.php?gid=$gid".$ecms_hashur['ehref'].">�����Զ���ҳ��ģ��</a>&nbsp;>&nbsp;�����Զ���ҳ��ģ��";
$postword='�����Զ���ҳ��ģ��';
//����
if($enews=="AddPagetemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewspagetemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListPagetemp.php?gid=$gid".$ecms_hashur['ehref'].">�����Զ���ҳ��ģ��</a>&nbsp;>&nbsp;�����Զ���ҳ��ģ��: ".$r[tempname];
	$postword='�޸��Զ���ҳ��ģ��';
}
//�޸�
if($enews=="EditPagetemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewspagetemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListPagetemp.php?gid=$gid".$ecms_hashur['ehref'].">�����Զ���ҳ��ģ��</a>&nbsp;>&nbsp;�޸��Զ���ҳ��ģ��: ".$r[tempname];
	$postword='�޸��Զ���ҳ��ģ��';
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$postword?></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ReturnHtml(html)
{
document.form1.temptext.value=html;
}
</script>
<SCRIPT lanuage="JScript">
<!--
function tempturnit(ss)
{
 if (ss.style.display=="") 
  ss.style.display="none";
 else
  ss.style.display=""; 
}
-->
</SCRIPT>
<script>
function ReTempBak(){
	self.location.reload();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListPagetemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">ģ������(*)</td>
      <td width="81%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>" size="30"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>ģ������</strong>(*)</td>
      <td height="25">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="temptext" cols="90" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="����ģ��"> &nbsp;
        <input type="reset" name="Submit2" value="����"> 
        <?php
		if($enews=='EditPagetemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pagetemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">�鿴ģ���ǩ�﷨</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴��ǩģ��</a>] 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield" type="text" value="[!--pagetitle--]">
              : ��ҳ����</td>
            <td width="34%"><input name="textfield2" type="text" value="[!--pagekeywords--]">
              : ��ҳ�ؼ���</td>
            <td width="33%"><input name="textfield3" type="text" value="[!--pagedescription--]">
              : ��ҳ����</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield32" type="text" value="[!--pagetext--]">
              : ��ҳ����</td>
            <td><input name="textfield322" type="text" value="[!--pagename--]">
              : ҳ������</td>
            <td><input name="textfield3222" type="text" value="[!--pageid--]">
              : ҳ��ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield4" type="text" value="[!--news.url--]">
              : ��վ��ַ</td>
            <td><strong>֧�ֹ���ģ�����</strong></td>
            <td><strong>֧������ģ���ǩ</strong></td>
          </tr>
        </table></td>
    </tr>
  </table>
</body>
</html>
