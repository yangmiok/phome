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
CheckLevel($logininid,$loginin,$classid,"ad");
$t=ehtmlspecialchars($_GET['t']);
$enews=ehtmlspecialchars($_GET['enews']);
$time=ehtmlspecialchars($_GET['time']);
$url="<a href=ListAd.php".$ecms_hashur['whehref'].">������</a>&nbsp;>&nbsp;���ӹ��";
//��ʼ������
$r[starttime]=date("Y-m-d");
$r[endtime]=date("Y-m-d",time()+30*24*3600);
$r[pic_width]=468;
$r[pic_height]=60;
$filepass=ReturnTranFilepass();
//�޸Ĺ��
if($enews=="EditAd")
{
	$adid=(int)$_GET['adid'];
	$filepass=$adid;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsad where adid='$adid'");
	$url="<a href=ListAd.php".$ecms_hashur['whehref'].">������</a>&nbsp;>&nbsp;�޸Ĺ�棺<b>".$r[title]."</b>";
	$a="adtype".$r[adtype];
	$$a=" selected";
	if($r[target]=="_blank")
	{$target1=" selected";}
	elseif($r[target]=="_self")
	{$target2=" selected";}
	else
	{$target3=" selected";}
	$t=$r[t];
}
//���ģʽ
if(strlen($_GET[changet])!=0)
{
	$t=RepPostStr($_GET['changet'],1);
}
//������
$sql=$empire->query("select classid,classname from {$dbtbpre}enewsadclass");
while($cr=$empire->fetch($sql))
{
	if($r[classid]==$cr[classid])
	{$s=" selected";}
	else
	{$s="";}
	$options.="<option value=".$cr[classid].$s.">".$cr[classname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function foreColor()
{
  if (!Error())	return;
  var arr = showModalDialog("../ecmseditor/fieldfile/selcolor.html", "", "dialogWidth:296px; dialogHeight:280px; status:0");
  if (arr != null) document.form1.titlecolor.value=arr;
  else document.form1.titlecolor.focus();
}
</script>
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
<script type="text/javascript" src="../ecmseditor/js/jscolor/jscolor.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="30%" height="25">λ�ã� 
      <?=$url?>
    </td>
    <td><table width="500" border="0" align="right" cellpadding="3" cellspacing="1">
        <tr> 
          <td height="25"> <div align="center">[<a href="AddAd.php?enews=AddAd&t=0<?=$ecms_hashur['ehref']?>"><strong>����ͼƬ/FLASH���</strong></a>]</div></td>
          <td><div align="center">[<a href="AddAd.php?enews=AddAd&t=1<?=$ecms_hashur['ehref']?>"><strong>�������ֹ��</strong></a>]</div></td>
          <td><div align="center">[<a href="AddAd.php?enews=AddAd&t=2<?=$ecms_hashur['ehref']?>"><strong>����HTML���</strong></a>]</div></td>
          <td><div align="center">[<a href="AddAd.php?enews=AddAd&t=3<?=$ecms_hashur['ehref']?>"><strong>���ӵ������</strong></a>]</div></td>
        </tr>
      </table></td>
  </tr>
</table>

<br>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td><div align="center"> 
        <?
	//���ֹ��
	if($t==1)
	{
	?>
        <form name="form1" method="post" action="ListAd.php">
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
		<?=$ecms_hashur['form']?>
            <tr class="header"> 
              <td height="25" colspan="2">�������ֹ�� 
                <input name="add[adid]" type="hidden" id="add[adid]" value="<?=$adid?>"> 
                <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
                <input name="add[t]" type="hidden" id="add[t]" value="<?=$t?>"> 
                <input name="time" type="hidden" id="time" value="<?=$time?>">
                <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"><strong>���ģʽ��</strong></td>
              <td height="25"><select name="changet" id="changet" onchange=window.location='AddAd.php?<?=$ecms_hashur['ehref']?>&enews=<?=$enews?>&adid=<?=$adid?>&time=<?=$time?>&changet='+this.options[this.selectedIndex].value>
                  <option value="0">ͼƬ/FLASH���</option>
                  <option value="1" selected>���ֹ��</option>
                  <option value="2">HTML���</option>
                  <option value="3">�������</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">�����ࣺ</td>
              <td height="25"> <select name="add[classid]" id="add[classid]">
                  <?=$options?>
                </select> <input type="button" name="Submit3" value="�������" onclick="window.open('AdClass.php<?=$ecms_hashur['whehref']?>');"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td width="27%" height="25">������ƣ�</td>
              <td width="73%" height="25"> <input name="add[title]" type="text" id="add[title]" value="<?=$r[title]?>">
                <font color="#666666">(�磺��վBanner���)</font></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">������ͣ�</td>
              <td height="25"> <select name="add[adtype]" id="add[adtype]">
                  <option value="1"<?=$adtype1?>>��ͨ��ʾ</option>
                  <option value="3"<?=$adtype3?>>���ƶ�͸���Ի���</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���֣�</td>
              <td height="25"> <input name="picurl" type="text" id="picurl" value="<?=$r[picurl]?>" size="42"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">&nbsp;</td>
              <td height="25"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td width="51%">���ԣ� 
                      <input name="titlefont[b]" type="checkbox" id="titlefont[b]" value="b"<?=strstr($r[titlefont],'b|')?' checked':''?>>
                      ���� 
                      <input name="titlefont[i]" type="checkbox" id="titlefont[i]" value="i"<?=strstr($r[titlefont],'i|')?' checked':''?>>
                      б�� 
                      <input name="titlefont[s]" type="checkbox" id="titlefont[s]" value="s"<?=strstr($r[titlefont],'s|')?' checked':''?>>
                      ɾ����</td>
                    <td width="49%">��ɫ�� 
                      <input name="titlecolor" type="text" id="titlecolor" value="<?=$r[titlecolor]?>" size="10" class="color"> 
                      </td>
                  </tr>
                </table></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���ӵ�ַ��</td>
              <td height="25"> <input name="add[url]" type="text" id="add[url]" value="<?=$r[url]?>" size="42"> 
                <input name="add[ylink]" type="checkbox" id="add[ylink]" value="1"<?=$r[ylink]==1?' checked':''?>>
                ��ʾԭ����</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">&nbsp;</td>
              <td height="25"> <select name="add[target]" id="select">
                  <option value="_blank"<?=$target1?>>���´��ڴ�</option>
                  <option value="_self"<?=$target2?>>��ԭ���ڴ�</option>
                  <option value="_parent"<?=$target3?>>�ڸ����ڴ�</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���</td>
              <td height="25"><input name="add[pic_width]" type="text" id="add[pic_width]" value="<?=$r[pic_width]?>" size="4">
                �� 
                <input name="add[pic_height]" type="text" id="add[pic_height]" value="<?=$r[pic_height]?>" size="4">
                (�����)<font color="#666666">[���ƶ�͸���Ի�����Ч]</font></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">��ʾ���֣�</td>
              <td height="25"> <input name="add[alt]" type="text" id="add[alt]" value="<?=$r[alt]?>"> 
              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">����ʱ�䣺</td>
              <td height="25">�� 
                <input name="add[starttime]" type="text" id="add[starttime]" value="<?=$r[starttime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                �� 
                <input name="add[endtime]" type="text" id="add[endtime]" value="<?=$r[endtime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                ֹ <font color="#666666">(��ʽ��2004-09-01���������ڿ���0000-00-00)</font></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td height="25">���ں���ʾ��</td>
              <td height="25"><textarea name="add[reptext]" cols="65" rows="8" id="add[reptext]"><?=ehtmlspecialchars($r[reptext])?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���õ������</td>
              <td height="25"><input name="add[reset]" type="checkbox" id="add[reset]" value="1">
                ����</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">��ע�ͣ�</td>
              <td height="25"> <textarea name="add[adsay]" cols="65" rows="5" id="add[adsay]"><?=$r[adsay]?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">&nbsp;</td>
              <td height="25"> <input type="submit" name="Submit" value="�ύ"> 
                <input type="reset" name="Submit2" value="����"></td>
            </tr>
          </table>
        </form>
        <?
	}
	//html���
	elseif($t==2)
	{
	?>
        <form name="form1" method="post" action="ListAd.php">
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
		<?=$ecms_hashur['form']?>
            <tr class="header"> 
              <td height="25" colspan="2">����HTML��� 
                <input name="add[adid]" type="hidden" id="add[adid]" value="<?=$adid?>"> 
                <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
                <input name="add[t]" type="hidden" id="add[t]" value="<?=$t?>"> 
                <input name="time" type="hidden" id="time" value="<?=$time?>"> 
                <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"><strong>���ģʽ��</strong></td>
              <td height="25"><select name="changet" id="select2" onchange=window.location='AddAd.php?<?=$ecms_hashur['ehref']?>&enews=<?=$enews?>&adid=<?=$adid?>&time=<?=$time?>&changet='+this.options[this.selectedIndex].value>
                  <option value="0">ͼƬ/FLASH���</option>
                  <option value="1">���ֹ��</option>
                  <option value="2" selected>HTML���</option>
                  <option value="3">�������</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">�����ࣺ</td>
              <td height="25"> <select name="add[classid]" id="add[classid]">
                  <?=$options?>
                </select> <input type="button" name="Submit32" value="�������" onclick="window.open('AdClass.php<?=$ecms_hashur['whehref']?>');"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td width="27%" height="25">������ƣ�</td>
              <td width="73%" height="25"> <input name="add[title]" type="text" id="add[title]" value="<?=$r[title]?>">
                <font color="#666666">(�磺��վBanner���)</font></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">������ͣ�</td>
              <td height="25"> <select name="add[adtype]" id="add[adtype]">
                  <option value="1"<?=$adtype1?>>��ͨ��ʾ</option>
                  <option value="3"<?=$adtype3?>>���ƶ�͸���Ի���</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���</td>
              <td height="25"><input name="add[pic_width]" type="text" id="add[pic_width]" value="<?=$r[pic_width]?>" size="4">
                �� 
                <input name="add[pic_height]2" type="text" id="add[pic_height]2" value="<?=$r[pic_height]?>" size="4">
                (�����)<font color="#666666">[���ƶ�͸���Ի�����Ч]</font></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">HTML���룺</td>
              <td height="25"> <textarea name="add[htmlcode]" cols="42" rows="12" id="add[htmlcode]" style="WIDTH: 100%"><?=ehtmlspecialchars($r[htmlcode])?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">����ʱ�䣺</td>
              <td height="25">�� 
                <input name="add[starttime]" type="text" id="add[starttime]" value="<?=$r[starttime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                �� 
                <input name="add[endtime]" type="text" id="add[endtime]" value="<?=$r[endtime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                ֹ <font color="#666666">(��ʽ��2004-09-01���������ڿ���0000-00-00)</font></td>
            </tr>
			<tr bgcolor="#FFFFFF">
              <td height="25">���ں���ʾ��</td>
              <td height="25"><textarea name="add[reptext]" cols="65" rows="8" id="add[reptext]"><?=ehtmlspecialchars($r[reptext])?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���õ������</td>
              <td height="25"><input name="add[reset]" type="checkbox" id="add[reset]" value="1">
                ����</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">��ע�ͣ�</td>
              <td height="25"> <textarea name="add[adsay]" cols="65" rows="5" id="add[adsay]"><?=$r[adsay]?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">&nbsp;</td>
              <td height="25"> <input type="submit" name="Submit" value="�ύ"> 
                <input type="reset" name="Submit2" value="����"></td>
            </tr>
          </table>
        </form>
        <?
	}
	//�������
	elseif($t==3)
	{
	?>
        <form name="form1" method="post" action="ListAd.php">
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
		<?=$ecms_hashur['form']?>
            <tr class="header"> 
              <td height="25" colspan="2">���ӵ������ 
                <input name="add[adid]" type="hidden" id="add[adid]" value="<?=$adid?>"> 
                <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
                <input name="add[t]" type="hidden" id="add[t]3" value="<?=$t?>"> 
                <input name="time" type="hidden" id="time" value="<?=$time?>">
                <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"><strong>���ģʽ��</strong></td>
              <td height="25"><select name="changet" id="select3" onchange=window.location='AddAd.php?<?=$ecms_hashur['ehref']?>&enews=<?=$enews?>&adid=<?=$adid?>&time=<?=$time?>&changet='+this.options[this.selectedIndex].value>
                  <option value="0">ͼƬ/FLASH���</option>
                  <option value="1">���ֹ��</option>
                  <option value="2">HTML���</option>
                  <option value="3" selected>�������</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">�����ࣺ</td>
              <td height="25"> <select name="add[classid]" id="add[classid]">
                  <?=$options?>
                </select> <input type="button" name="Submit33" value="�������" onclick="window.open('AdClass.php<?=$ecms_hashur['whehref']?>');"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td width="27%" height="25">������ƣ�</td>
              <td width="73%" height="25"> <input name="add[title]" type="text" id="add[title]" value="<?=$r[title]?>">
                <font color="#666666">(�磺��վBanner���)</font></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">������ͣ�</td>
              <td height="25"> <select name="add[adtype]" id="add[adtype]">
                  <option value="8"<?=$adtype8?>>���´���</option>
                  <option value="9"<?=$adtype9?>>�����´���</option>
                  <option value="10"<?=$adtype10?>>��ͨ��ҳ�Ի���</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">������ַ��</td>
              <td height="25"> <input name="add[url]" type="text" id="add[url]" value="<?=$r[url]?>" size="42"> 
              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���</td>
              <td height="25"><input name="add[pic_width]" type="text" id="add[pic_width]" value="<?=$r[pic_width]?>" size="4">
                �� 
                <input name="add[pic_height]" type="text" id="add[pic_height]" value="<?=$r[pic_height]?>" size="4">
                (�����)</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">����ʱ�䣺</td>
              <td height="25">�� 
                <input name="add[starttime]" type="text" id="add[starttime]" value="<?=$r[starttime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                �� 
                <input name="add[endtime]" type="text" id="add[endtime]" value="<?=$r[endtime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                ֹ <font color="#666666">(��ʽ��2004-09-01���������ڿ���0000-00-00)</font></td>
            </tr>
			<tr bgcolor="#FFFFFF">
              <td height="25">���ں���ʾ��</td>
              <td height="25"><textarea name="add[reptext]" cols="65" rows="8" id="add[reptext]"><?=ehtmlspecialchars($r[reptext])?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���õ������</td>
              <td height="25"><input name="add[reset]" type="checkbox" id="add[reset]" value="1">
                ����</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">��ע�ͣ�</td>
              <td height="25"> <textarea name="add[adsay]" cols="65" rows="5" id="add[adsay]"><?=$r[adsay]?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">&nbsp;</td>
              <td height="25"> <input type="submit" name="Submit" value="�ύ"> 
                <input type="reset" name="Submit2" value="����"></td>
            </tr>
          </table>
        </form>
        <?
	}
	//ͼƬ/flash���
	else
	{
	?>
        <form name="form1" method="post" action="ListAd.php">
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
		<?=$ecms_hashur['form']?>
            <tr class="header"> 
              <td height="25" colspan="2">����ͼƬ/FLASH��� 
                <input name="add[adid]" type="hidden" id="add[adid]" value="<?=$adid?>"> 
                <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
                <input name="add[t]" type="hidden" id="add[t]4" value="<?=$t?>"> 
                <input name="time" type="hidden" id="time" value="<?=$time?>">
                <input name="filepass" type="hidden" id="filepass" value="<?=$filepass?>"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"><strong>���ģʽ��</strong></td>
              <td height="25"><select name="changet" id="select4" onchange=window.location='AddAd.php?<?=$ecms_hashur['ehref']?>&enews=<?=$enews?>&adid=<?=$adid?>&time=<?=$time?>&changet='+this.options[this.selectedIndex].value>
                  <option value="0" selected>ͼƬ/FLASH���</option>
                  <option value="1">���ֹ��</option>
                  <option value="2">HTML���</option>
                  <option value="3">�������</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">�����ࣺ</td>
              <td height="25"> <select name="add[classid]" id="add[classid]">
                  <?=$options?>
                </select> <input type="button" name="Submit34" value="�������" onclick="window.open('AdClass.php<?=$ecms_hashur['whehref']?>');"></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td width="27%" height="25">������ƣ�</td>
              <td width="73%" height="25"> <input name="add[title]" type="text" id="add[title]" value="<?=$r[title]?>">
                <font color="#666666">(�磺��վBanner���)</font></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">������ͣ�</td>
              <td height="25"> <select name="add[adtype]" id="add[adtype]">
                  <option value="1"<?=$adtype1?>>��ͨ��ʾ</option>
                  <option value="4"<?=$adtype4?>>����������ʾ</option>
                  <option value="5"<?=$adtype5?>>���¸�����ʾ - ��</option>
                  <option value="6"<?=$adtype6?>>���¸�����ʾ - ��</option>
                  <option value="7"<?=$adtype7?>>ȫ��Ļ������ʧ</option>
                  <option value="3"<?=$adtype3?>>���ƶ�͸���Ի���</option>
                  <option value="11"<?=$adtype11?>>����ʽ���</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">ͼƬ/FLASH��ַ��</td>
              <td height="25"> <input name="picurl" type="text" id="picurl" value="<?=$r[picurl]?>" size="42"> 
                <a onclick="window.open('../ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&modtype=3&type=1&classid=&doing=2&field=picurl&filepass=<?=$filepass?>&sinfo=1','','width=700,height=550,scrollbars=yes');" title="ѡ�����ϴ���ͼƬ"><img src="../../data/images/changeimg.gif" alt="ѡ��/�ϴ�ͼƬ" width="22" height="22" border="0" align="absbottom"></a> 
                <a onclick="window.open('../ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&modtype=3&type=2&classid=&doing=2&field=picurl&filepass=<?=$filepass?>&sinfo=1','','width=700,height=550,scrollbars=yes');" title="ѡ�����ϴ���ͼƬ"><img src="../../data/images/changeflash.gif" alt="ѡ��/�ϴ�FLASH" width="22" height="22" border="0" align="absbottom"></a> 
              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���</td>
              <td height="25"> <input name="add[pic_width]" type="text" id="add[pic_width]" value="<?=$r[pic_width]?>" size="4">
                �� 
                <input name="add[pic_height]" type="text" id="add[pic_height]" value="<?=$r[pic_height]?>" size="4">
                (�����)</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���ӵ�ַ��</td>
              <td height="25"> <input name="add[url]" type="text" id="add[url]" value="<?=$r[url]?>" size="42"> 
                <input name="add[ylink]" type="checkbox" id="add[ylink]" value="1"<?=$r[ylink]==1?' checked':''?>>
                ��ʾԭ����</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">&nbsp;</td>
              <td height="25"> <select name="add[target]" id="select">
                  <option value="_blank"<?=$target1?>>���´��ڴ�</option>
                  <option value="_self"<?=$target2?>>��ԭ���ڴ�</option>
                  <option value="_parent"<?=$target3?>>�ڸ����ڴ�</option>
                </select></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">��ʾ���֣�</td>
              <td height="25"> <input name="add[alt]" type="text" id="add[alt]" value="<?=$r[alt]?>">
                <font color="#666666">(FLASH�����Ч)</font></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">����ʱ�䣺</td>
              <td height="25">�� 
                <input name="add[starttime]" type="text" id="add[starttime]" value="<?=$r[starttime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                �� 
                <input name="add[endtime]" type="text" id="add[endtime]" value="<?=$r[endtime]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                ֹ <font color="#666666">(��ʽ��2004-09-01���������ڿ���0000-00-00)</font></td>
            </tr>
			<tr bgcolor="#FFFFFF">
              <td height="25">���ں���ʾ��</td>
              <td height="25"><textarea name="add[reptext]" cols="65" rows="8" id="add[reptext]"><?=ehtmlspecialchars($r[reptext])?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">���õ������</td>
              <td height="25"><input name="add[reset]" type="checkbox" id="add[reset]" value="1">
                ����</td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">��ע�ͣ�</td>
              <td height="25"> <textarea name="add[adsay]" cols="65" rows="5" id="add[adsay]"><?=$r[adsay]?></textarea></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">&nbsp;</td>
              <td height="25"> <input type="submit" name="Submit" value="�ύ"> 
                <input type="reset" name="Submit2" value="����"></td>
            </tr>
          </table>
        </form>
        <?
	}
	?>
      </div></td>
  </tr>
</table>
</body>
</html>
