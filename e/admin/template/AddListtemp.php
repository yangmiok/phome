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
$mid=ehtmlspecialchars($_GET['mid']);
$cid=ehtmlspecialchars($_GET['cid']);
$enews=ehtmlspecialchars($_GET['enews']);
$r[subnews]=0;
$r[rownum]=1;
$r[subtitle]=0;
$r[showdate]="Y-m-d H:i:s";
$url=$urlgname."<a href=ListListtemp.php?gid=$gid".$ecms_hashur['ehref'].">�����б�ģ��</a>&nbsp;>&nbsp;�����б�ģ��";
$autorownum=" checked";
//����
if($enews=="AddListtemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempname,temptext,subnews,listvar,rownum,modid,showdate,subtitle,classid,docode from ".GetDoTemptb("enewslisttemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListListtemp.php?gid=$gid".$ecms_hashur['ehref'].">�����б�ģ��</a>&nbsp;>&nbsp;�����б�ģ�壺".$r[tempname];
}
//�޸�
if($enews=="EditListtemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempname,temptext,subnews,listvar,rownum,modid,showdate,subtitle,classid,docode from ".GetDoTemptb("enewslisttemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListListtemp.php?gid=$gid".$ecms_hashur['ehref'].">�����б�ģ��</a>&nbsp;>&nbsp;�޸��б�ģ�壺".$r[tempname];
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
$csql=$empire->query("select classid,classname from {$dbtbpre}enewslisttempclass order by classid");
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
<title>�����б�ģ��</title>
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
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListListtemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="3">����ģ�� 
        <input type=hidden name=enews value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="mid" type="hidden" id="mid" value="<?=$mid?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="22%" height="25">ģ����(*)</td>
      <td height="25" colspan="2"><input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>" size="36"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ϵͳģ��(*)</td>
      <td height="25" colspan="2"><select name="modid" id="modid">
          <?=$mod?>
        </select> <input type="button" name="Submit6" value="����ϵͳģ��" onclick="window.open('../db/ListTable.php<?=$ecms_hashur['whehref']?>');"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������</td>
      <td height="25" colspan="2"><select name="classid" id="classid">
          <option value="0">���������κη���</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="�������" onclick="window.open('ListtempClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ȡ����</td>
      <td height="25" colspan="2"><input name="subnews" type="text" id="subnews" value="<?=$r[subnews]?>" size="6">
        ���ֽ�<font color="#666666">(0Ϊ����ȡ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�����ȡ����</td>
      <td height="25" colspan="2"><input name="subtitle" type="text" id="subtitle" value="<?=$r[subtitle]?>" size="6">
        ���ֽ�<font color="#666666">(0Ϊ����ȡ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ÿ����ʾ</td>
      <td height="25" colspan="2"><input name="rownum" type="text" id="rownum" value="<?=$r[rownum]?>" size="6">
        ����¼<font color="#666666">( 
        <input name="autorownum" type="checkbox" id="autorownum" value="1"<?=$autorownum?>>
        �Զ�ʶ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ʱ����ʾ��ʽ</td>
      <td colspan="2"> <input name="showdate" type="text" id="showdate" value="<?=$r[showdate]?>" size="20"> 
        <select name="select4" onchange="document.form1.showdate.value=this.value">
          <option value="Y-m-d H:i:s">ѡ��</option>
          <option value="Y-m-d H:i:s">2005-01-27 11:04:27</option>
          <option value="Y-m-d">2005-01-27</option>
          <option value="m-d">01-27</option>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>ҳ��ģ������</strong>(*)</td>
      <td colspan="2">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3" valign="top"><p> 
          <textarea name="temptext" cols="90" rows="27" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </p></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>�б�����ģ��(list.var) </strong>(*)</td>
      <td width="64%">�뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.listvar.value);document.form1.listvar.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.listvar.value&returnvar=opener.document.form1.listvar.value&fun=ReturnHtml&notfullpage=1<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
      <td width="14%"><div align="right">
          <input name="docode" type="checkbox" id="docode" value="1"<?=$r[docode]==1?' checked':''?>>
          <a title="list.varʹ�ó������">ʹ�ó������</a></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="3" valign="top"> <div align="center"> 
          <textarea name="listvar" cols="90" rows="12" id="listvar" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[listvar]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25" colspan="2"><input type="submit" name="Submit" value="����ģ��">
        &nbsp; <input type="reset" name="Submit2" value="����">
        <?php
		if($enews=='EditListtemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=listtemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3">&nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">�鿴ģ���ǩ�﷨</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴��ǩģ��</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="3"><strong>(1)��ҳ��ģ������֧�ֵı���</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield" type="text" value="[!--pagetitle--]">
              :ҳ�����</td>
            <td width="34%"><input name="textfield72" type="text" value="[!--pagekey--]">
              :ҳ��ؼ��� </td>
            <td width="33%"><input name="textfield73" type="text" value="[!--pagedes--]">
              :ҳ������ </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield2" type="text" value="[!--newsnav--]">
              :������</td>
            <td><input name="textfield92" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
            <td><input name="textfield132" type="text" value="[!--class.name--]">
              :��Ŀ��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield4" type="text" value="[!--self.classid--]">
              :����Ŀ/ר��ID</td>
            <td><input name="textfield5" type="text" value="[!--bclass.id--]">
              :����ĿID</td>
            <td><input name="textfield6" type="text" value="[!--bclass.name--]">
              :����Ŀ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield7" type="text" value="[!--class.intro--]">
              :��Ŀ/ר����</td>
            <td><input name="textfield8" type="text" value="[!--class.keywords--]">
              :��Ŀ/ר��ؼ���</td>
            <td><input name="textfield9" type="text" value="[!--class.classimg--]">
              :��Ŀ/ר������ͼ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield10" type="text" value="[!--show.page--]">
              :��ҳ����(����ʽ)<br></td>
            <td><input name="textfield11" type="text" value="[!--show.listpage--]">
              :��ҳ����(�б�ʽ)</td>
            <td><input name="textfield12" type="text" value="[!--list.pageno--]">
              :��ǰ��ҳ��</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield13" type="text" value="[!--hotnews--]">
              :������ϢJS����(Ĭ�ϱ�)<br> <input name="textfield14" type="text" value="[!--self.hotnews--]">
              :����Ŀ������ϢJS����</td>
            <td><input name="textfield15" type="text" value="[!--newnews--]">
              :������ϢJS����(Ĭ�ϱ�)<br> <input name="textfield16" type="text" value="[!--self.newnews--]">
              :����Ŀ������ϢJS����</td>
            <td><input name="textfield17" type="text" value="[!--goodnews--]">
              :�Ƽ���ϢJS����(Ĭ�ϱ�)<br> <input name="textfield18" type="text" value="[!--self.goodnews--]">
              :����Ŀ�Ƽ���ϢJS����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield19" type="text" value="[!--hotplnews--]">
              :����������ϢJS����(Ĭ�ϱ�)<br> <input name="textfield20" type="text" value="[!--self.hotplnews--]">
              :����Ŀ����������ϢJS����</td>
            <td><input name="textfield21" type="text" value="[!--firstnews--]">
              :ͷ����ϢJS����(Ĭ�ϱ�)<br> <input name="textfield22" type="text" value="[!--self.firstnews--]">
              :����Ŀͷ����ϢJS����</td>
            <td><strong>���ݱ����� &lt;!--list.var���--&gt; (�磺&lt;!--list.var1--&gt;,&lt;!--list.var2--&gt;) 
              </strong> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield3" type="text" value="[!--page.stats--]">
              :ͳ�Ʒ���</td>
            <td><strong>֧�ֹ���ģ�����</strong></td>
            <td><strong>֧������ģ���ǩ</strong></td>
          </tr>
        </table>
        <br> <strong>(2)���б�����ģ��(list.var)֧�ֵı���</strong><br> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield23" type="text" value="[!--id--]">
              :��ϢID</td>
            <td width="34%"> <input name="textfield24" type="text" value="[!--titleurl--]">
              :��������</td>
            <td width="33%"> <input name="textfield25" type="text" value="[!--oldtitle--]">
              :����ALT(����ȡ�ַ�)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield26" type="text" value="[!--classid--]">
              :��ĿID</td>
            <td><input name="textfield27" type="text" value="[!--class.name--]">
              :��Ŀ����(������)</td>
            <td><input name="textfield28" type="text" value="[!--this.classname--]">
              :��Ŀ����(��������)</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield29" type="text" value="[!--this.classlink--]">
              :��Ŀ��ַ</td>
            <td><input name="textfield30" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td><input name="textfield31" type="text" value="[!--no.num--]">
              :��Ϣ���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield32" type="text" value="[!--userid--]">
              :������ID</td>
            <td><input name="textfield33" type="text" value="[!--username--]">
              :������</td>
            <td><input name="textfield34" type="text" value="[!--userfen--]">
              :�鿴��Ϣ�۳�����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield35" type="text" value="[!--onclick--]">
              :�����</td>
            <td><input name="textfield36" type="text" value="[!--totaldown--]">
              :������</td>
            <td><input name="textfield37" type="text" value="[!--plnum--]">
              :������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield192" type="text" value="[!--ttid--]">
              :�������ID</td>
            <td><input name="textfield1922" type="text" value="[!--tt.name--]">
              :�����������</td>
            <td><input name="textfield19222" type="text" value="[!--tt.url--]">
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
      <td height="80">ģ���ʽ˵��</td>
      <td height="25" colspan="2"><p> <strong>ҳ��ģ�����ݣ�</strong>�б�ͷ[!--empirenews.listtemp--]�б�����[!--empirenews.listtemp--]�б�β<br>
          ҳ��ģ���ʽ���У�&lt;table&gt;[!--empirenews.listtemp--]&lt;tr&gt;&lt;td&gt;&lt;!--list.var1--&gt;&lt;/td&gt;&lt;td&gt;&lt;!--list.var2--&gt;&lt;/td&gt;&lt;/tr&gt;[!--empirenews.listtemp--]&lt;/table&gt;<font color="#FF0000">(ÿ����ʾ2����¼)</font><br>
          <strong>�б�����ģ�壺</strong>����ҳ��ģ�����ݣ��У�&lt;!--list.var*--&gt;����ǩ��ʾ�����ݣ�</p></td>
    </tr>
  </table>
</body>
</html>
