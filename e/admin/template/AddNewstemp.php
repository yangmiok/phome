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
$r[showdate]="Y-m-d H:i:s";
$url=$urlgname."<a href=ListNewstemp.php?gid=$gid".$ecms_hashur['ehref'].">��������ģ��</a>&nbsp;>&nbsp;��������ģ��";
//����
if($enews=="AddNewstemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempname,temptext,modid,showdate,classid from ".GetDoTemptb("enewsnewstemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListNewstemp.php?gid=$gid".$ecms_hashur['ehref'].">��������ģ��</a>&nbsp;>&nbsp;��������ģ�壺".$r[tempname];
}
//�޸�
if($enews=="EditNewstemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$empire->fetch1("select tempname,temptext,modid,showdate,classid from ".GetDoTemptb("enewsnewstemp",$gid)." where tempid='$tempid'");
	$url=$urlgname."<a href=ListNewstemp.php?gid=$gid".$ecms_hashur['ehref'].">��������ģ��</a>&nbsp;>&nbsp;�޸�����ģ�壺".$r[tempname];
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
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsnewstempclass order by classid");
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
<title>��������ģ��</title>
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
  <form name="form1" method="post" action="ListNewstemp.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">����ģ�� 
        <input type=hidden name=enews value="<?=$enews?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="mid" type="hidden" id="mid" value="<?=$mid?>"> 
        <input name="gid" type="hidden" id="gid" value="<?=$gid?>"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">ģ����(*)</td>
      <td width="69%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>" size="30"> 
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
          <option value="0">���������κη���</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="�������" onclick="window.open('NewstempClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ʱ����ʾ��ʽ��</td>
      <td> <input name="showdate" type="text" id="showdate" value="<?=$r[showdate]?>" size="20"> 
        <select name="select4" onchange="document.form1.showdate.value=this.value">
          <option value="Y-m-d H:i:s">ѡ��</option>
          <option value="Y-m-d H:i:s">2005-01-27 11:04:27</option>
          <option value="Y-m-d">2005-01-27</option>
          <option value="m-d">01-27</option>
        </select> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>ģ������</strong>(*)</td>
      <td> �뽫ģ������<a href="#ecms" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="�������ģ������"><strong>���Ƶ�Dreamweaver(�Ƽ�)</strong></a>����ʹ��<a href="#ecms" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml<?=$ecms_hashur['ehref']?>','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>ģ�����߱༭</strong></a>���п��ӻ��༭</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" valign="top"> <div align="center">
          <textarea name="temptext" cols="90" rows="27" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="����ģ��">&nbsp;
        <input type="reset" name="Submit2" value="����">
        <?php
		if($enews=='EditNewstemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#empirecms" onclick="window.open('TempBak.php?temptype=newstemp&tempid=<?=$tempid?>&gid=<?=$gid?><?=$ecms_hashur['ehref']?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">�޸ļ�¼</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"> &nbsp;&nbsp;[<a href="#ecms" onclick="tempturnit(showtempvar);">��ʾģ�����˵��</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">�鿴ģ���ǩ�﷨</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴��ǩģ��</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><strong>ģ�����˵����</strong><br> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="34%" height="25"> <input name="textfield18" type="text" value="[!--pagetitle--]">
              :ҳ�����</td>
            <td width="33%"><input name="textfield72" type="text" value="[!--pagekey--]">
              :ҳ��ؼ��� </td>
            <td width="33%"><input name="textfield73" type="text" value="[!--pagedes--]">
              :ҳ������ </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield19" type="text" value="[!--newsnav--]">
              :������</td>
            <td><input name="textfield92" type="text" value="[!--class.menu--]">
              :һ����Ŀ����</td>
            <td><input name="textfield20" type="text" value="[!--page.stats--]">
              :ͳ�Ʒ���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"> <input name="textfield21" type="text" value="[!--id--]">
              :��ϢID</td>
            <td><input name="textfield22" type="text" value="[!--titleurl--]">
              :��������</td>
            <td><input name="textfield23" type="text" value="[!--keyboard--]">
              :�ؼ���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield24" type="text" value="[!--classid--]">
              :��ĿID</td>
            <td><input name="textfield25" type="text" value="[!--class.name--]">
              :��Ŀ����</td>
            <td><input name="textfield26" type="text" value="[!--self.classid--]">
              :����ĿID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield30" type="text" value="[!--bclass.id--]">
              :����ĿID<br></td>
            <td><input name="textfield31" type="text" value="[!--bclass.name--]">
              :����Ŀ����</td>
            <td><input name="textfield32" type="text" value="[!--other.link--]">
              :�������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield19222" type="text" value="[!--p.title--]">
              :��ҳ����</td>
            <td><input name="textfield34" type="text" value="[!--news.url--]">
              :��վ��ַ</td>
            <td><input name="textfield35" type="text" value="[!--no.num--]">
              :��Ϣ���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield36" type="text" value="[!--userid--]">
              :������ID</td>
            <td><input name="textfield37" type="text" value="[!--username--]">
              :������</td>
            <td><input name="textfield38" type="text" value="[!--linkusername--]">
              :�����ӵ��û���</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield39" type="text" value="[!--userfen--]">
              :�鿴��Ϣ�۳�����</td>
            <td><input name="textfield40" type="text" value="[!--pinfopfen--]">
              :ƽ������</td>
            <td><input name="textfield41" type="text" value="[!--infopfennum--]">
              :��������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield42" type="text" value="[!--onclick--]">
              :�����</td>
            <td><input name="textfield43" type="text" value="[!--totaldown--]">
              :������</td>
            <td><input name="textfield44" type="text" value="[!--plnum--]">
              :������</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield45" type="text" value="[!--page.url--]">
              :��ҳ����</td>
            <td><input name="textfield46" type="text" value="[!--title.select--]">
              :����ʽ��ҳ����</td>
            <td><input name="textfield47" type="text" value="[!--next.page--]">
              :������һҳ����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield48" type="text" value="[!--info.next--]">
              :��һƪ</td>
            <td><input name="textfield49" type="text" value="[!--info.pre--]">
              :��һƪ</td>
            <td><input name="textfield50" type="text" value="[!--info.vote--]">
              :��ϢͶƱ</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield192" type="text" value="[!--ttid--]">
              :�������ID</td>
            <td><input name="textfield1922" type="text" value="[!--tt.name--]">
              :�����������</td>
            <td><input name="textfield19223" type="text" value="[!--tt.url--]">
:��������ַ</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield252" type="text" value="[!--class.url--]">
:��Ŀҳ���ַ</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield51" type="text" value="[!--hotnews--]">
              :������ϢJS����(Ĭ�ϱ�)<br> <input name="textfield52" type="text" value="[!--self.hotnews--]">
              :����Ŀ������ϢJS����</td>
            <td><input name="textfield53" type="text" value="[!--newnews--]">
              :������ϢJS����(Ĭ�ϱ�)<br> <input name="textfield54" type="text" value="[!--self.newnews--]">
              :����Ŀ������ϢJS���� </td>
            <td><input name="textfield55" type="text" value="[!--goodnews--]">
              :�Ƽ���ϢJS����(Ĭ�ϱ�)<br> <input name="textfield56" type="text" value="[!--self.goodnews--]">
              :����Ŀ�Ƽ���ϢJS����</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield57" type="text" value="[!--hotplnews--]">
              :����������ϢJS����(Ĭ�ϱ�)<br> <input name="textfield58" type="text" value="[!--self.hotplnews--]">
              :����Ŀ����������ϢJS����</td>
            <td><input name="textfield59" type="text" value="[!--firstnews--]">
              :ͷ����ϢJS����(Ĭ�ϱ�)<br> <input name="textfield60" type="text" value="[!--self.firstnews--]">
              :����Ŀͷ����ϢJS����</td>
            <td>&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><strong>[!--�ֶ���--]:���ݱ��ֶ����ݵ��ã��� 
              <input type="button" name="Submit3" value="����" onclick="window.open('ShowVar.php?<?=$ecms_hashur['ehref']?>&modid='+document.form1.modid.value,'','width=300,height=520,scrollbars=yes');">
              �ɲ鿴</strong></td>
            <td><strong>֧�ֹ���ģ�����</strong></td>
            <td><strong>֧������ģ���ǩ</strong></td>
          </tr>
        </table>
        <br> <strong>����JS���ü���ַ˵�� </strong> <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="17%" height="25">ʵʱ��ʾ�����(��ͳ��)</td>
            <td width="83%"><input name="textfield61" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ʵʱ��ʾ�����(��ʾ+ͳ��)</td>
            <td><input name="textfield62" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;addclick=1&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ʵʱ��ʾ������</td>
            <td><input name="textfield63" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=1&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ʵʱ��ʾ������</td>
            <td><input name="textfield64" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=2&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ʵʱ��ʾƽ��������</td>
            <td><input name="textfield65" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=3&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ʵʱ��ʾ��������</td>
            <td><input name="textfield66" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=4&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ʵʱ��ʾ����</td>
            <td><input name="textfield67" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=5&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">ʵʱ��ʾ����</td>
            <td><input name="textfield672" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=[!--classid--]&amp;id=[!--id--]&amp;down=6&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">ʵʱ��ʾר��������</td>
            <td><input name="textfield6723" type="text" style="WIDTH: 100%" value="&lt;script src=[!--news.url--]e/public/ViewClick/?classid=ר��ID&amp;down=7&gt;&lt;/script&gt;"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td rowspan="2">��������ͬʱ��ʾ<br>
              (����1Ϊ��ʾ,0Ϊ����ʾ) </td>
            <td height="25"><input name="textfield6722" type="text" value="&lt;script src=[!--news.url--]e/public/ViewClick/ViewMore.php?classid=[!--classid--]&amp;id=[!--id--]&amp;onclick=1&amp;down=1&amp;plnum=1&amp;pfen=0&amp;pfennum=0&amp;diggtop=0&amp;diggdown=0&amp;addclick=0&gt;&lt;/script&gt;" size="85"></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">��ʾ���ݵط�Ҫ��id=&quot;����showdiv&quot;������������&lt;span id=&quot;onclickshowdiv&quot;&gt;0&lt;/span&gt;</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25">���ﳵ��ַ</td>
            <td><input name="textfield68" type="text" style="WIDTH: 100%" value="[!--news.url--]e/ShopSys/buycar/?classid=[!--classid--]&amp;id=[!--id--]"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25">����JS����</td>
            <td><input name="textfield682" type="text" style="WIDTH: 100%" value="&lt;script src=&quot;[!--news.url--]e/pl/more/?classid=[!--classid--]&amp;id=[!--id--]&amp;num=10&quot;&gt;&lt;/script&gt;"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</body>
</html>
