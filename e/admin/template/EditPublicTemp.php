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
$tname=ehtmlspecialchars($_GET['tname']);
$r=$empire->fetch1("select * from ".GetDoTemptb('enewspubtemp',$gid)." limit 1");
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ģ��</title>
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
    <td width="83%"><p>λ��: 
        <?=$gname?>
        &nbsp;>&nbsp;<a href="EditPublicTemp.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>">����ģ�����</a></p></td>
    <td width="17%"> <div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="�������ݸ���" onclick="window.open('../ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>');">
      </div></td>
  </tr>
</table>
<?
if($tname=="indextemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=indextemp>
	<form name="formindex" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">�޸���ҳģ��(<a href="../../../" target="_blank">Ԥ��</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><div align="center">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formindex.temptext.value);document.formindex.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formindex.temptext.value&returnvar=opener.document.formindex.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</div></td>
    </tr>
    <tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[indextemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit" value="�޸�">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditPublicTemp">
          <input name="templatename" type="hidden" id="templatename" value="indextemp">
          <input type="reset" name="Submit2" value="����">
          <input name="gid" type="hidden" id="gid" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubindextemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
      <td bgcolor="#FFFFFF"><div align="right" class="emenubutton">
          <input type="button" name="Submit3" value="������ҳ����" onclick="window.open('ListIndexpage.php?gid=<?=$gid?><?=$ecms_hashur['ehref']?>');">
        </div></td>
    </tr>
	</form>
	<tr> 
      <td height="25" colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(indexshowtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">�鿴ģ���ǩ�﷨</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴��ǩģ��</a>]</td>
    </tr>
    <tr id="indexshowtempvar" style="display:none"> 
      <td height="25" colspan="2" bgcolor="#FFFFFF"><strong>��ҳģ��֧�ֵı���˵��</strong> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="50%" height="25"> <input name="textfield" type="text" value="[!--pagetitle--]">
              :��վ����</td>
            <td width="50%"> <input name="textfield2" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td width="50%"><input name="textfield923" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield72" type="text" value="[!--pagekey--]">
              :ҳ��ؼ���</td>
            <td><input name="textfield73" type="text" value="[!--pagedes--]">
              :ҳ������</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>֧�ֹ���ģ�����</strong></td>
            <td><strong>֧������ģ���ǩ</strong></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="cptemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=cptemp>
	<form name="formcp" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">�������ģ�� (<a href="../../member/cp" target="_blank">Ԥ��</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formcp.temptext.value);document.formcp.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formcp.temptext.value&returnvar=opener.document.formcp.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[cptemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditCptemp">
          <input name="templatename" type="hidden" id="templatename" value="cptemp">
          <input type="reset" name="Submit22" value="����">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubcptemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
	</form>
	<tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(cpshowtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>]</td>
    </tr>
    <tr id="cpshowtempvar" style="display:none">
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"><input name="textfield30" type="text" value="[!--newsnav--]">
              :����λ�õ�����</td>
            <td width="34%"><input name="textfield31" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td width="33%"><input name="textfield3" type="text" value="[!--pagetitle--]">
              ��ҳ�����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield722" type="text" value="[!--pagekey--]">
              :ҳ��ؼ���</td>
            <td><input name="textfield732" type="text" value="[!--pagedes--]">
              :ҳ������</td>
            <td><input name="textfield922" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><strong>֧�ֹ���ģ�����</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">˵��: ��Ҫ��ʾ���ݵĵط�(��ע�ᣬ��½��)���ϡ�[!--empirenews.template--]��</td>
    </tr>
  </table>
<br>
<?
}
if($tname=="schalltemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=schalltemp>
	<form name="formschall" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">ȫվ����ģ��(<a href="../../sch/sch.html" target="_blank">����ģ��</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formschall.temptext.value);document.formschall.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formschall.temptext.value&returnvar=opener.document.formschall.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[schalltemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">����ȡ������ 
          <input name="schallsubnum" type="text" id="schallsubnum" value="<?=$r[schallsubnum]?>">
          ��ʱ���ʽ�� 
          <input name="schalldate" type="text" id="schalldate" value="<?=$r[schalldate]?>">
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditSchallTemp">
          <input name="tempname" type="hidden" id="tempname" value="schalltemp">
          <input type="reset" name="Submit22" value="����">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubschalltemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
	</form>
	<tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(schallshowtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>]</td>
    </tr>
    <tr id="schallshowtempvar" style="display:none">
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"><input name="textfield3023" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td width="34%"><input name="textfield3123" type="text" value="[!--newsnav--]">
              :������</td>
            <td width="33%"><input name="textfield31222" type="text" value="[!--keyboard--]">
              :�����ؼ���</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield302232" type="text" value="[!--num--]">
              :�ܼ�¼��</td>
            <td><input name="textfield57" type="text" value="[!--listpage--]">
              :��ҳ����</td>
            <td><input name="textfield58" type="text" value="[!--no.num--]">
              :���</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield55" type="text" value="[!--titleurl--]">
              :��Ϣ����</td>
            <td><input name="textfield56" type="text" value="[!--id--]">
              :��ϢID</td>
            <td><input name="textfield59" type="text" value="[!--classid--]">
              :��ĿID</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield60" type="text" value="[!--titlepic--]">
              :����ͼƬ</td>
            <td><input name="textfield61" type="text" value="[!--newstime--]">
              :����ʱ��</td>
            <td><input name="textfield62" type="text" value="[!--title--]">
              :��Ϣ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield63" type="text" value="[!--smalltext--]">
              :���</td>
            <td><input name="textfield92" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
            <td><strong>֧�ֹ���ģ�����</strong></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p>ģ���ʽ:�б�ͷ[!--empirenews.listtemp--]�б�����[!--empirenews.listtemp--]�б�β<br>
        </p></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="searchformtemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=searchtemp>
	<form name="formsearchform" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">�߼�������ģ�� (<a href="../../../search/" target="_blank">Ԥ��</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formsearchform.temptext.value);document.formsearchform.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formsearchform.temptext.value&returnvar=opener.document.formsearchform.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[searchtemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditSearchTemp">
          <input name="tempname" type="hidden" id="tempname" value="searchtemp">
          <input type="reset" name="Submit22" value="����">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubsearchtemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
	</form>
	<tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(searchformshowtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>]</td>
    </tr>
    <tr id="searchformshowtempvar" style="display:none"> 
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"><input name="textfield302" type="text" value="[!--class--]">
              :������Ŀ�б�</td>
            <td width="34%"><input name="textfield312" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td width="33%"><input name="textfield31232" type="text" value="[!--newsnav--]">
              :������</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield723" type="text" value="[!--pagekey--]">
              :ҳ��ؼ���</td>
            <td><input name="textfield733" type="text" value="[!--pagedes--]">
              :ҳ������</td>
            <td><input name="textfield924" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>֧�ֹ���ģ�����</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="searchformjs"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=searchjstemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">����JSģ��[����]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[searchjstemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditSearchTemp">
          <input name="tempname" type="hidden" id="tempname" value="searchjstemp">
          <input type="reset" name="Submit22" value="����">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubsearchjstemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ�����˵��:</strong> <br>
          վ���ַ: [!--news.url--]��������Ŀ�б�: [!--class--] <br>
          <br>
          <strong>���õ�ַ��</strong> 
          <input name="textfield1322" type="text" id="textfield1322" size="60" value="&lt;script src=&quot;<?=$public_r[newsurl]."d/js/js/search_news1.js";?>&quot;&gt;&lt;/script&gt;">
          [<a href="../view/js.php?classid=1&js=<?=$public_r[newsurl]."d/js/js/search_news1.js";?><?=$ecms_hashur['ehref']?>" target="_blank">Ԥ��</a>] 
        </p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="searchformjs1"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=searchjstemp1>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">����JSģ��[����]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[searchjstemp1]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditSearchTemp">
          <input name="tempname" type="hidden" id="tempname" value="searchjstemp1">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubsearchjstemp1&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ�����˵��:</strong> <br>
          վ���ַ: [!--news.url--]��������Ŀ�б�: [!--class--] <br>
          <br>
          <strong>���õ�ַ��</strong> 
          <input name="textfield13222" type="text" id="textfield13222" size="60" value="&lt;script src=&quot;<?=$public_r[newsurl]."d/js/js/search_news2.js";?>&quot;&gt;&lt;/script&gt;">
          [<a href="../view/js.php?classid=1&js=<?=$public_r[newsurl]."d/js/js/search_news2.js";?><?=$ecms_hashur['ehref']?>" target="_blank">Ԥ��</a>] 
        </p>
        </td>
    </tr>
  </table>
</form>
<?
}
if($tname=="otherlinktemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=otherlinktemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">�����Ϣ����ģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[otherlinktemp]))?></textarea>
        </div></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><div align="center">�����ȡ������
          <input name="otherlinktempsub" type="text" id="otherlinktempsub" value="<?=$r[otherlinktempsub]?>">
          ��ʱ���ʽ��
          <input name="otherlinktempdate" type="text" id="otherlinktempdate" value="<?=$r[otherlinktempdate]?>">
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditOtherLinkTemp">
          <input name="tempname" type="hidden" id="tempname" value="otherlinktemp">
          <input type="reset" name="Submit22" value="����">
          <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubotherlinktemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ���ʽ:</strong>�б�ͷ[!--empirenews.listtemp--]�б�����[!--empirenews.listtemp--]�б�β<br>
          <strong>ģ�����˵����</strong><br>
          ����: [!--title--]������alt��[!--oldtitle--], ��������: [!--titleurl--] <br>
          ����ʱ��: [!--newstime--], ����ͼƬ: [!--titlepic--]</p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="gbooktemp"||empty($tname))
{
?>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=gbooktemp>
	<form name="formgbook" method="post" action="../ecmstemp.php">
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">���԰�ģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.formgbook.temptext.value);document.formgbook.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.formgbook.temptext.value&returnvar=opener.document.formgbook.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r['gbooktemp']))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit" value="�޸�">
          &nbsp;&nbsp; 
          <input name="enews" type="hidden" id="enews" value="EditGbooktemp">
          <input name="templatename" type="hidden" id="templatename" value="gbooktemp">
          <input type="reset" name="Submit2" value="����">
          <input name="gid" type="hidden" id="gid" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubgbooktemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
	</form>
	<tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(gbookshowtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>]</td>
    </tr>
    <tr id="gbookshowtempvar" style="display:none">
      <td height="25" bgcolor="#FFFFFF"><strong>1������ҳ��֧�ֵı���</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield32" type="text" value="[!--newsnav--]">
              :����λ�õ�����</td>
            <td width="34%"><input name="textfield724" type="text" value="[!--pagekey--]">
              :ҳ��ؼ��� </td>
            <td width="33%"><input name="textfield734" type="text" value="[!--pagedes--]">
              :ҳ������ </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield33" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td><input name="textfield34" type="text" value="[!--bname--]">
              :���Է�������</td>
            <td><input name="textfield925" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield35" type="text" value="[!--bid--]">
              :���Է���ID</td>
            <td><input name="textfield36" type="text" value="[!--listpage--]">
              :��ҳ����</td>
            <td><input name="textfield37" type="text" value="[!--num--]">
              :�ܼ�¼��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>֧�ֹ���ģ�����</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <strong>2���б�����֧�ֵı���</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25">
<input name="textfield38" type="text" value="[!--lyid--]">
              :����ID</td>
            <td width="34%"> 
              <input name="textfield39" type="text" value="[!--name--]">
              :������</td>
            <td width="33%">
<input name="textfield40" type="text" value="[!--email--]">
              :����������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield41" type="text" value="[!--mycall--]">
              :�����ߵ绰</td>
            <td><input name="textfield42" type="text" value="[!--lytime--]">
              :����ʱ��</td>
            <td><input name="textfield43" type="text" value="[!--lytext--]">
              :��������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield44" type="text" value="[!--retext--]">
              :�ظ�����</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ҳ���ʽ:</strong> �б�ͷ[!--empirenews.listtemp--]�б�����[!--empirenews.listtemp--]�б�β<br>
          <strong>�ظ���ʾ��ʽ��</strong>[!--start.regbook--]�ظ���ʾ��ʽ����[!--end.regbook--]</p></td>
    </tr>
  </table>
<br>
<?
}
if($tname=="pljstemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=pljstemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">�޸�����JS����ģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[pljstemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="pljstemp">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubpljstemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ���ʽ:�б�ͷ[!--empirenews.listtemp--]�б�����[!--empirenews.listtemp--]�б�β<br>
          ģ�����˵����</strong><br>
          ��վ��ַ��[!--news.url--],��ĿID��[!--classid--],��ϢID��[!--id--]<br>
          ����ID��[!--plid--],�������ݣ�[!--pltext--],���۷���ʱ�䣺[!--pltime--],������IP��[!--plip--]<br>
          ������ID��[!--userid--],�����ߣ�[!--username--],֧������[!--zcnum--],��������[!--fdnum--]<br>
          <br>
          <strong>��Ϣ���۵��õ�ַ��</strong>&lt;script src=&quot;[!--news.url--]e/pl/more/?classid=[!--classid--]&amp;id=[!--id--]&amp;num=10&quot;&gt;&lt;/script&gt;<br>
          <strong>ר�����۵��õ�ַ��</strong>&lt;script src=&quot;[!--news.url--]e/pl/more/?doaction=dozt&amp;classid=[!--classid--]&amp;num=10&quot;&gt;&lt;/script&gt;<br>
        </p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="downpagetemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=downpagetemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">�޸���������ҳģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[downpagetemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="downpagetemp">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubdownpagetemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ�����˵����</strong><br>
          ��վ��ַ��[!--news.url--],ҳ����⣺[!--pagetitle--],��������[!--newsnav--]<br>
          ҳ��ؼ��֣�[!--pagekey--],ҳ��������[!--pagedes--],һ����Ŀ������[!--class.menu--],��ĿID��[!--classid--]<br>
          ��Ŀ���ƣ�[!--class.name--],����ĿID��[!--bclass.id--],����Ŀ���ƣ�[!--bclass.name--],��ϢID��[!--id--]<br>
          ��ַID:[!--pathid--],��ַ����:[!--down.name--],���ص�ַ:[!--down.url--],�ļ���ʵ��ַ��[!--true.down.url--]<br>
          �۳�����:[!--fen--],���صȼ�:[!--group--],��Ϣ��ַ��[!--titleurl--],��Ϣ���⣺[!--title--]<br>
          ����ʱ�䣺[!--newstime--],����ͼƬ��[!--titlepic--],�ؼ��֣�[!--keyboard--],�������[!--onclick--]<br>
          ��������[!--totaldown--],�����û�ID��[!--userid--],�����û�����[!--username--]</p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="downsofttemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=downsofttemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">���ص�ַģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[downsofttemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="downsofttemp">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubdownsofttemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ�����˵����</strong><br>
          ��������:[!--down.name--],�������ص�ַ:[!--down.url--],�ļ���ʵ��ַ��[!--true.down.url--]<br>
          ���ص�ַ��:[!--pathid--],��ĿID:[!--classid--],��ϢID:[!--id--],�۳�����:[!--fen--],���صȼ�:[!--group--]<br>
          ��վ��ַ��[!--news.url--],��Ϣ���⣺[!--title--] </p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="onlinemovietemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=onlinemovietemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">���߲��ŵ�ַģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[onlinemovietemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="onlinemovietemp">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=pubonlinemovietemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ�����˵����</strong><br>
          �ۿ�����:[!--down.name--],�����ۿ���ַ:[!--down.url--],�ļ���ʵ��ַ��[!--true.down.url--]<br>
          �ۿ���ַ��:[!--pathid--],��ĿID:[!--classid--],��ϢID:[!--id--],�۳�����:[!--fen--],���صȼ�:[!--group--]<br>
          ��վ��ַ��[!--news.url--],��Ϣ���⣺[!--title--]</p></td>
    </tr>
  </table>
</form>
<?
}
if($tname=="listpagetemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=listpagetemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">�б��ҳģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[listpagetemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditOtherPubTemp">
          <input name="tempname" type="hidden" id="tempname" value="listpagetemp">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=publistpagetemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ�����˵����</strong><br>
          ��ҳҳ��:[!--thispage--], ��ҳ��:[!--pagenum--], ÿҳ��ʾ����:[!--lencord--] <br>
          ������:[!--num--], ��ҳ����:[!--pagelink--], ������ҳ:[!--options--] </p>
        </td>
    </tr>
  </table>
</form>
<?
}
if($tname=="loginiframe"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=loginiframe>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">��½״̬ģ�� (<a href="../../member/iframe" target="_blank">Ԥ��</a>)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="25" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[loginiframe]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditLoginIframe">
          <input name="tempname" type="hidden" id="tempname" value="loginiframe">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=publoginiframe&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ���ʽ��</strong>��½ǰ��ʾ����[!--empirenews.template--]��½����ʾ����<br>
          <strong>ģ�����˵���� </strong><br>
          �û�ID:[!--userid--]���û���:[!--username--]����վ��ַ��[!--news.url--]<br>
          ��Ա�ȼ�:[!--groupname--]���ֽ�:[!--money--]���ʻ���Ч����:[!--userdate--]<br>
          ������Ϣ:[!--havemsg--]������:[!--userfen--]</p>
        </td>
    </tr>
  </table>
</form>
<?
}
if($tname=="loginjstemp"||empty($tname))
{
?>
<form name="form1" method="post" action="../ecmstemp.php">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=loginjstemp>
	<?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">JS���õ�½״̬ģ��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <textarea name="temptext" cols="110" rows="25" id="temptext" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[loginjstemp]))?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="submit" name="Submit4" value="�޸�">
          <input name="enews" type="hidden" id="enews" value="EditLoginJstemp">
          <input name="tempname" type="hidden" id="tempname" value="loginjstemp">
          <input type="reset" name="Submit22" value="����">
		  <input name="gid" type="hidden" id="gid3" value="<?=$gid?>">
          &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=publoginjstemp&tempid=1&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>]</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><p><strong>ģ���ʽ��</strong>��½ǰ��ʾ����[!--empirenews.template--]��½����ʾ����<br>
          <strong>ģ�����˵����</strong> <br>
          �û�ID:[!--userid--]���û���:[!--username--]����վ��ַ��[!--news.url--]<br>
          ��Ա�ȼ�:[!--groupname--]���ֽ�:[!--money--]���ʻ���Ч����:[!--userdate--]<br>
          ������Ϣ:[!--havemsg--]������:[!--userfen--]<br>
          <br>
          <strong>���õ�ַ��</strong> 
          <input name="textfield132" type="text" id="textfield132" size="60" value="&lt;script src=&quot;<?=$public_r[newsurl]."e/member/login/loginjs.php";?>&quot;&gt;&lt;/script&gt;">
          [<a href="../view/js.php?classid=1&js=<?=$public_r[newsurl]."e/member/login/loginjs.php";?><?=$ecms_hashur['ehref']?>" target="_blank">Ԥ��</a>] 
        </p>
        </td>
    </tr>
  </table>
</form>
<?
}
?>
</body>
</html>
