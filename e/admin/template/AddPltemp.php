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
$enews=ehtmlspecialchars($_GET['enews']);
$url=$urlgname."<a href=ListPltemp.php?gid=$gid".$ecms_hashur['ehref'].">��������ģ��</a>&nbsp;>&nbsp;��������ģ��";
//����
if($enews=="AddPlTemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewspltemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListPltemp.php?gid=$gid".$ecms_hashur['ehref'].">��������ģ��</a>&nbsp;>&nbsp;��������ģ�壺<b>".$r[tempname]."</b>";
}
//�޸�
if($enews=="EditPlTemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewspltemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListPltemp.php?gid=$gid".$ecms_hashur['ehref'].">��������ģ��</a>&nbsp;>&nbsp;�޸�����ģ�壺<b>".$r[tempname]."</b>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��������ģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
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
  <form name="form1" method="post" action="ListPltemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">��������ģ�� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">ģ������</td>
      <td width="81%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>"> 
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
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����">
        <?php
		if($enews=='EditPlTemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pltemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><strong>1������ҳ��֧�ֵı���</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield3" type="text" value="[!--newsnav--]">
              :����λ�õ�����</td>
            <td width="34%"><input name="textfield72" type="text" value="[!--pagekey--]">
              :ҳ��ؼ��� </td>
            <td width="33%"><input name="textfield73" type="text" value="[!--pagedes--]">
              :ҳ������ </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield92" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
            <td><input name="textfield4" type="text" value="[!--titleurl--]">
              :��Ϣ����</td>
            <td><input name="textfield5" type="text" value="[!--title--]">
              :��Ϣ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield6" type="text" value="[!--classid--]">
              :��ĿID</td>
            <td><input name="textfield7" type="text" value="[!--id--]">
              :��ϢID</td>
            <td><input name="textfield8" type="text" value="[!--pinfopfen--]">
              :��Ϣƽ������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield9" type="text" value="[!--infopfennum--]">
              :����������</td>
            <td><input name="textfield10" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td><input name="textfield11" type="text" value="[!--key.url--]">
              :����������֤���ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield12" type="text" value="[!--lusername--]">
              :��½��Ա�ʺ�</td>
            <td><input name="textfield13" type="text" value="[!--lpassword--]">
              :��½�û�����(���ܹ�)</td>
            <td><input name="textfield14" type="text" value="[!--listpage--]">
              :��ҳ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield15" type="text" value="[!--plnum--]">
              :�ܼ�¼��</td>
            <td><input name="textfield16" type="text" value="[!--hotnews--]">
              :������ϢJS����(Ĭ�ϱ�)</td>
            <td><input name="textfield17" type="text" value="[!--newnews--]">
              :������ϢJS����(Ĭ�ϱ�)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield18" type="text" value="[!--goodnews--]">
              :�Ƽ���ϢJS����(Ĭ�ϱ�)</td>
            <td><input name="textfield19" type="text" value="[!--hotplnews--]">
              :����������ϢJS����(Ĭ�ϱ�)</td>
            <td><input name="textfield182" type="text" value="&lt;script src=&quot;[!--news.url--]d/js/js/plface.js&quot;&gt;&lt;/script&gt;">
:���۱���ѡ�����</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><strong>֧�ֹ���ģ�����</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br> <strong>2���б�����֧�ֵı���</strong><br> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield20" type="text" value="[!--plid--]">
              :����ID</td>
            <td width="34%"> <input name="textfield21" type="text" value="[!--pltext--]">
              :��������</td>
            <td width="33%"> <input name="textfield22" type="text" value="[!--pltime--]">
              :���۷���ʱ��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield23" type="text" value="[!--plip--]">
              :���۷�����IP</td>
            <td><input name="textfield24" type="text" value="[!--username--]">
              :������</td>
            <td><input name="textfield252" type="text" value="[!--userid--]">
              :������ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield26" type="text" value="[!--zcnum--]">
              :֧����</td>
            <td><input name="textfield27" type="text" value="[!--fdnum--]">
              :������</td>
            <td><input name="textfield28" type="text" value="[!--classid--]">
              :��ĿID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield29" type="text" value="[!--id--]">
              :��ϢID</td>
            <td><input name="textfield25" type="text" value="[!--includelink--]">
              :�����������ӵ�ַ</td>
            <td><strong>[!--�ֶ���--]:�Զ����ֶ����ݵ���</strong></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ģ���ʽ:</td>
      <td height="25">�б�ͷ[!--empirenews.listtemp--]�б�����[!--empirenews.listtemp--]�б�β</td>
    </tr>
  </table>
</body>
</html>
