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
$url=$urlgname."<a href=ListVotetemp.php?gid=$gid".$ecms_hashur['ehref'].">����ͶƱģ��</a>&nbsp;>&nbsp;����ͶƱģ��";
//����
if($enews=="AddVoteTemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewsvotetemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListVotetemp.php?gid=$gid".$ecms_hashur['ehref'].">����ͶƱģ��</a>&nbsp;>&nbsp;����ͶƱģ�壺<b>".$r[tempname]."</b>";
}
//�޸�
if($enews=="EditVoteTemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempid,tempname,temptext from ".GetDoTemptb("enewsvotetemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListVotetemp.php?gid=$gid".$ecms_hashur['ehref'].">����ͶƱģ��</a>&nbsp;>&nbsp;�޸�ͶƱģ�壺<b>".$r[tempname]."</b>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ͶƱģ��</title>
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
  <form name="form1" method="post" action="ListVotetemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">����ͶƱģ�� 
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
      <td height="25">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml&notfullpage=1<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="temptext" cols="90" rows="23" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����">
        <?php
		if($enews=='EditVoteTemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=votetemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">��ʾģ�����˵��</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><strong>(1)��ͶƱ���ʹ��ʱ֧�ֵ�ģ������б� </strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF">
            <td height="25"><div align="center">[!--news.url--]</div></td>
            <td>��վ��ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="36%" height="25"> <div align="center">[!--vote.action--]</div></td>
            <td width="64%">ͶƱ���ύ��ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--title--]</div></td>
            <td>��ʾͶƱ�ı���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.view--]</div></td>
            <td>�鿴ͶƱ�����ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--width--](���)��[!--height--](�߶�)</div></td>
            <td>����ͶƱ������ڴ�С</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--voteid--]</div></td>
            <td>��ͶƱ��ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.box--]</div></td>
            <td>ͶƱѡ���ѡ�� 
              <input type="radio" name="radiobutton" value="radiobutton">
              �븴ѡ�� 
              <input type="checkbox" name="checkbox" value="checkbox">
              ��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.name--]</div></td>
            <td>ͶƱѡ������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">ͶƱ�¼�����</div></td>
            <td>&lt;input type=&quot;hidden&quot; name=&quot;<strong>enews</strong>&quot; 
              value=&quot;<strong>AddVote</strong>&quot;&gt;</td>
          </tr>
        </table>
        <br> <strong>(2)����ϢͶƱʹ��ʱ֧�ֵ�ģ������б� </strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF">
            <td height="25"><div align="center">[!--news.url--]</div></td>
            <td>��վ��ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="36%" height="25"> <div align="center">ͶƱ���ύ��ַ</div></td>
            <td width="64%">/e/enews/index.php</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">�鿴ͶƱ�����ַ</div></td>
            <td>/e/public/vote/?classid=[!--classid--]&amp;id=[!--id--]</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--title--]</div></td>
            <td>��ʾͶƱ�ı���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--width--](���)��[!--height--](�߶�)</div></td>
            <td>����ͶƱ������ڴ�С</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--id--]</div></td>
            <td>��ϢID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">[!--classid--]</div></td>
            <td>��ĿID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.box--]</div></td>
            <td>ͶƱѡ���ѡ�� 
              <input type="radio" name="radiobutton" value="radiobutton">
              �븴ѡ�� 
              <input type="checkbox" name="checkbox2" value="checkbox">
              ��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <div align="center">[!--vote.name--]</div></td>
            <td>ͶƱѡ������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><div align="center">ͶƱ�¼�����</div></td>
            <td>&lt;input type=&quot;hidden&quot; name=&quot;<strong>enews</strong>&quot; 
              value=&quot;<strong>AddInfoVote</strong>&quot;&gt;</td>
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
