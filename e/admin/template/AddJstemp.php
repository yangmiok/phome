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
$r[showdate]="[m-d]";
$url=$urlgname."<a href=ListJstemp.php?gid=$gid".$ecms_hashur['ehref'].">����JSģ��</a>&nbsp;>&nbsp;����JSģ��";
//����
if($enews=="AddJstemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select * from ".GetDoTemptb("enewsjstemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListJstemp.php?gid=$gid".$ecms_hashur['ehref'].">����JSģ��</a>&nbsp;>&nbsp;����JSģ��: ".$r[tempname];
}
//�޸�
if($enews=="EditJstemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select * from ".GetDoTemptb("enewsjstemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListJstemp.php?gid=$gid".$ecms_hashur['ehref'].">����JSģ��</a>&nbsp;>&nbsp;�޸�JSģ��: ".$r[tempname];
}
//ϵͳģ��
$msql=$empire->query("select mid,mname from {$dbtbpre}enewsmod where usemod=0 order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	if($mr[mid]==$r[modid])
	{$select=" selected";}
	else
	{$select="";}
	$mod.="<option value=".$mr[mid].$select.">".$mr[mname]."</option>";
}
//����
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsjstempclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����JSģ��</title>
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
  <form name="form1" method="post" action="ListJstemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">����JSģ�� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="gid" type="hidden" id="gid" value="<?=$gid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">ģ������(*)</td>
      <td width="81%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>"> 
      </td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">����ϵͳģ��(*)</td>
      <td height="25"><select name="modid" id="modid">
          <?=$mod?>
        </select> <input type="button" name="Submit6" value="����ϵͳģ��" onclick="window.open('../db/ListTable.php<?=$ecms_hashur['whehref']?>');"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������</td>
      <td height="25"><select name="classid" id="classid">
          <option value="0">���������κ����</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="�������" onclick="window.open('JsTempClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">����ȡ����</td>
      <td height="25"><input name="subnews" type="text" id="subnews" value="<?=$r[subnews]?>" size="6">
        ���ֽ�<font color="#666666">(0Ϊ����ȡ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����ȡ����</td>
      <td height="25"><input name="subtitle" type="text" id="subtitle" value="<?=$r[subtitle]?>" size="6">
        ���ֽ�<font color="#666666">(0Ϊ����ȡ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ʱ����ʾ��ʽ</td>
      <td height="25"><input name="showdate" type="text" id="showdate" value="<?=$r[showdate]?>" size="20"> 
        <select name="select4" onchange="document.form1.showdate.value=this.value">
          <option value="Y-m-d H:i:s">ѡ��</option>
          <option value="Y-m-d H:i:s">2005-01-27 11:04:27</option>
          <option value="Y-m-d">2005-01-27</option>
          <option value="m-d">01-27</option>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>ģ������</strong>(*)</td>
      <td height="25">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml&notfullpage=1<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="temptext" cols="90" rows="18" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����">
        <?php
		if($enews=='EditJstemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=jstemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
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
      <td height="25" colspan="2"> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield42" type="text" value="[!--id--]">
              :��ϢID</td>
            <td width="34%"> <input name="textfield52" type="text" value="[!--titleurl--]">
              :��������</td>
            <td width="33%"> <input name="textfield62" type="text" value="[!--oldtitle--]">
              :����ALT(����ȡ�ַ�)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield72" type="text" value="[!--classid--]">
              :��ĿID</td>
            <td><input name="textfield82" type="text" value="[!--class.name--]">
              :��Ŀ����(������)</td>
            <td><input name="textfield92" type="text" value="[!--this.classname--]">
              :��Ŀ����(��������)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield10" type="text" value="[!--this.classlink--]">
              :��Ŀ��ַ</td>
            <td><input name="textfield11" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td><input name="textfield12" type="text" value="[!--no.num--]">
              :��Ϣ���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield13" type="text" value="[!--userid--]">
              :������ID</td>
            <td><input name="textfield14" type="text" value="[!--username--]">
              :������</td>
            <td><input name="textfield15" type="text" value="[!--userfen--]">
              :�鿴��Ϣ�۳�����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield16" type="text" value="[!--onclick--]">
              :�����</td>
            <td><input name="textfield17" type="text" value="[!--totaldown--]">
              :������</td>
            <td><input name="textfield18" type="text" value="[!--plnum--]">
              :������</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield19" type="text" value="[!--ttid--]">
              :�������ID</td>
            <td><input name="textfield192" type="text" value="[!--tt.name--]">
              :�����������</td>
            <td><input name="textfield1922" type="text" value="[!--tt.url--]">
:��������ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>[!--�ֶ���--]:���ݱ��ֶ����ݵ��ã��� 
              <input type="button" name="Submit3" value="����" onclick="window.open('ShowVar.php?<?=$ecms_hashur['ehref']?>&modid='+document.form1.modid.value,'','width=300,height=520,scrollbars=yes');">
              �ɲ鿴</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ģ���ʽ��</td>
      <td height="25">�б�ͷ[!--empirenews.listtemp--]�б�����[!--empirenews.listtemp--]�б�β</td>
    </tr>
  </table>
</body>
</html>
