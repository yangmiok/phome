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
CheckLevel($logininid,$loginin,$classid,"f");
$tid=(int)$_GET['tid'];
$tbname=RepPostVar($_GET['tbname']);
if(empty($tid)||empty($tbname))
{
	printerror("ErrorUrl","history.go(-1)");
}
$enews=RepPostStr($_GET['enews'],1);
$fid=(int)$_GET['fid'];
$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">�ֶι���</a>&nbsp;>&nbsp;�޸�ϵͳ�ֶ�";
$r=$empire->fetch1("select * from {$dbtbpre}enewsf where fid='$fid' and tid='$tid'");
if(!$r[fid])
{
	printerror("ErrorUrl","history.go(-1)");
}
$oftype="type".$r[ftype];
$$oftype=" selected";
$ofform="form".$r[fform];
$$ofform=" selected";
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�޸�ϵͳ�ֶ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ShowFieldFormSet(obj,val){
	if(val=='text')
	{
		fsizediv.style.display="";
		flinkfielddiv.style.display="none";
	}
	else if(val=='img')
	{
		fsizediv.style.display="";
		flinkfielddiv.style.display="none";
	}
	else if(val=='linkfield')
	{
		fsizediv.style.display="";
		flinkfielddiv.style.display="";
	}
	else if(val=='linkfieldselect')
	{
		fsizediv.style.display="none";
		flinkfielddiv.style.display="";
	}
}
</script>
</head>

<body onload="ShowFieldFormSet(document.addfform,'<?=$r[fform]?$r[fform]:'text'?>')">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="addfform" method="post" action="../ecmsmod.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header"> �޸����ݱ�( 
        <?=$dbtbpre?>
        ecms_ 
        <?=$tbname?>
        )��ϵͳ�ֶ� 
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"> <input name="enews" type="hidden" id="enews" value="EditSysF"> 
        <input name="oldfform" type="hidden" id="oldfform" value="<?=$r[fform]?>"> 
        <input name="oldf" type="hidden" id="oldf" value="<?=$r[f]?>"> <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"> 
        <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> <input name="oldfvalue" type="hidden" id="oldfvalue" value="<?=ehtmlspecialchars(stripSlashes($r[fvalue]))?>"> 
        <input name="oldiskey" type="hidden" id="oldiskey" value="<?=$r[iskey]?>"> 
        <input name="oldsavetxt" type="hidden" id="oldsavetxt" value="<?=$r[savetxt]?>"> 
        <input name="oldisonly" type="hidden" id="oldisonly" value="<?=$r[isonly]?>"> 
        <input name="oldlinkfieldval" type="hidden" id="oldlinkfieldval" value="<?=$r[linkfieldval]?>"> 
        <input name="oldfformsize" type="hidden" id="oldfformsize" value="<?=$r[fformsize]?>"> 
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��������</td>
    </tr>
    <tr> 
      <td width="25%" height="25" bgcolor="#FFFFFF">�ֶ���</td>
      <td width="75%" height="25" bgcolor="#FFFFFF"><b> 
        <?=$r[f]?>
        <input name="f" type="hidden" id="f" value="<?=$r[f]?>">
        </b></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�ֶα�ʶ</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="fname" type="text" id="fname" value="<?=$r[fname]?>"></td>
    </tr>
	<?php
	if($r[f]=='title'||$r[f]=='titlepic')
	{
	?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�ֶ�����</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="ftype" id="select">
          <option value="CHAR"<?=$typeCHAR?>>�����ַ���0-255�ֽ�(CHAR)</option>
          <option value="VARCHAR"<?=$typeVARCHAR?>>�ַ���0-255�ֽ�(VARCHAR)</option>
        </select>
        ���� 
        <input name="flen" type="text" id="flen" value="<?=$r[flen]?>" size="6"> 
      </td>
    </tr>
	<?php
	}
	else
	{
	?>
	<input type="hidden" name="ftype" value="<?=$r[ftype]?>">
	<input type="hidden" name="flen" value="<?=$r[flen]?>">
	<?php
	}
	?>
    <tr> 
      <td height="25" colspan="2">��������</td>
    </tr>
	<?php
	if($r[f]!='special.field')
	{
	?>
	<?php
	if($r[f]!='newstime')
	{
	?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">������</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="iskey" value="1"<?=$r[iskey]==1?' checked':''?>>
        �� 
        <input type="radio" name="iskey" value="0"<?=$r[iskey]==0?' checked':''?>>
        ��</td>
    </tr>
	<?php
	}
	else
	{
	?>
	<input type="hidden" name="iskey" value="<?=$r[iskey]?>">
	<?php
	}
	?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ֵΨһ</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="isonly" value="1"<?=$r[isonly]==1?' checked':''?>>
        �� 
        <input type="radio" name="isonly" value="0"<?=$r[isonly]==0?' checked':''?>>
        ��</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��̨������Ϣ������</td>
      <td height="25" bgcolor="#FFFFFF"><input name="adddofun" type="text" id="adddofun" value="<?=$r[adddofun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��̨�޸���Ϣ������</td>
      <td height="25" bgcolor="#FFFFFF"><input name="editdofun" type="text" id="editdofun" value="<?=$r[editdofun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ǰ̨������Ϣ������</td>
      <td height="25" bgcolor="#FFFFFF"><input name="qadddofun" type="text" id="qadddofun" value="<?=$r[qadddofun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ǰ̨�޸���Ϣ������</td>
      <td height="25" bgcolor="#FFFFFF"><input name="qeditdofun" type="text" id="qeditdofun" value="<?=$r[qeditdofun]?>">
        <font color="#666666">(һ�㲻���ã���ʽ��������##�����������ɲ�����)</font></td>
    </tr>
	<?php
	}	
	?>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��ʾ˳��</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>"> 
        <font color="#666666">(����ԽСԽǰ��)</font></td>
    </tr>
	<tr> 
      <td height="25" colspan="2">����ʾ����</td>
    </tr>
	<?php
	if($r[f]!='special.field')
	{
	?>
    <tr> 
      <td bgcolor="#FFFFFF">�������ʾԪ��</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="fform" id="fform" onchange="ShowFieldFormSet(document.addfform,this.options[this.selectedIndex].value)">
          <option value="text"<?=$formtext?>>�����ı���(text)</option>
          <option value="img"<?=$formimg?>>ͼƬ(img)</option>
          <option value="linkfield"<?=$formlinkfield?>>ѡ���������ֶ�(linkfield)</option>
          <option value="linkfieldselect"<?=$formlinkfieldselect?>>�����������ֶ�(linkfieldselect)</option>
        </select> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ѡ��</td>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr id="fsizediv"> 
            <td height="23"><strong>Ԫ�س���</strong><br> <input name="fformsize" type="text" id="fformsize2" value="<?=$r[fformsize]?>"> 
              <font color="#666666">(��Ϊ��Ĭ��)</font></td>
          </tr>
          <tr id="flinkfielddiv"> 
            <td height="23"><strong>ѡ��ģ���ֶ�����</strong><br>
              ���ݱ��� 
              <input name="linkfieldtb" type="text" id="linkfieldtb" value="<?=$r[linkfieldtb]?>"> 
              <br>
              ֵ�ֶ��� 
              <input name="linkfieldval" type="text" id="linkfieldval" value="<?=$r[linkfieldval]?>"> 
              <input name="samedata" type="checkbox" id="samedata" value="1"<?=$r[samedata]==1?' checked':''?>>
              ����ͬ��<br>
              ��ʾ�ֶ� 
              <input name="linkfieldshow" type="text" id="linkfieldshow" value="<?=$r[linkfieldshow]?>"> 
              <input name="oldlinkfieldtb" type="hidden" id="oldlinkfieldtb" value="<?=$r[linkfieldtb]?>"> 
              <input name="oldlinkfieldshow" type="hidden" id="oldlinkfieldshow" value="<?=$r[linkfieldshow]?>"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF">��ʼֵ</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="fvalue" cols="65" rows="8" id="fvalue" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes(str_replace("|","\r\n",$r[fvalue])))?></textarea></td>
    </tr>
	<?php
	}
	?>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">������滻html����<br> <font color="#666666">(�����ֶ�ʱ������)</font></td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="fhtml" cols="65" rows="10" id="fhtml" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[fhtml]))?></textarea></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">Ͷ����滻html����<br> <font color="#666666">(�����ֶ�ʱ������)</font></td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="qfhtml" cols="65" rows="10" id="qfhtml" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[qfhtml]))?></textarea></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#FFFFFF">ע��</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="fzs" cols="65" rows="6" id="fzs" style="WIDTH: 100%"><?=stripSlashes($r[fzs])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="�ύ"> 
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
