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
$r[iscj]=1;
$r[tobr]=0;
$r[dohtml]=1;
$r[myorder]=0;
$disabled='';
$tbdatafhidden='';
$savetxthidden='';
$fmvnum=1;
$fmvline=3;
$fmvmust=1;
$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">�ֶι���</a>&nbsp;>&nbsp;�����ֶ�";
$postword='����';
//�޸��ֶ�
if($enews=="EditF")
{
	$fid=(int)$_GET['fid'];
	$url="���ݱ�:[".$dbtbpre."ecms_".$tbname."]&nbsp;>&nbsp;<a href=ListF.php?tid=$tid&tbname=$tbname".$ecms_hashur['ehref'].">�ֶι���</a>&nbsp;>&nbsp;�޸��ֶ�";
	$postword='�޸�';
	$r=$empire->fetch1("select * from {$dbtbpre}enewsf where fid='$fid' and tid='$tid'");
	if(!$r[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//Ԫ�س���
	if($r[fform]=='textarea'||$r[fform]=='editor')
	{
		$fsr=explode(',',$r['fformsize']);
		$fformwidth=$fsr[0];
		$fformheight=$fsr[1];
	}
	//��ֵԪ��
	if($r[fform]=='morevaluefield')
	{
		$fmvr=explode(',',$r['fmvnum']);
		$fmvnum=$fmvr[0];
		$fmvline=$fmvr[1];
		$fmvmust=$fmvr[2];
	}
	$oftype="type".$r[ftype];
	$$oftype=" selected";
	$ofform="form".$r[fform];
	$$ofform=" selected";
	$disabled=' disabled';
	$tbdatafhidden='<input type="hidden" name="tbdataf" value="'.$r[tbdataf].'">';
	$savetxthidden='<input type="hidden" name="savetxt" value="'.$r[savetxt].'">';
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$postword?>�ֶ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ShowFieldFormSet(obj,val){
	if(val=='text'||val=='password'||val=='flash'||val=='file'||val=='date'||val=='color'||val=='datetime')
	{
		fsizediv.style.display="";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='img')
	{
		fsizediv.style.display="";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='editor')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='textarea'||val=='ubbeditor')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='select'||val=='radio'||val=='checkbox')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="";
		fmorevaluediv.style.display="none";
	}
	else if(val=='linkfield')
	{
		fsizediv.style.display="";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='linkfieldselect')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="none";
	}
	else if(val=='morevaluefield')
	{
		fsizediv.style.display="none";
		fwidthdiv.style.display="none";
		flinkfielddiv.style.display="none";
		feditordiv.style.display="none";
		defvaldiv.style.display="none";
		fmorevaluediv.style.display="";
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
    <tr> 
      <td height="25" colspan="2" class="header"> 
        <?=$postword?>
        ���ݱ�( 
        <?=$dbtbpre?>
        ecms_ 
        <?=$tbname?>
        )�ֶ� 
        <input name="fid" type="hidden" id="fid" value="<?=$fid?>"> <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> 
        <input name="oldfform" type="hidden" id="oldfform" value="<?=$r[fform]?>"> 
        <input name="oldf" type="hidden" id="oldf" value="<?=$r[f]?>"> <input name="tbname" type="hidden" id="tbname" value="<?=$tbname?>"> 
        <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> <input name="oldfvalue" type="hidden" id="oldfvalue" value="<?=ehtmlspecialchars(stripSlashes($r[fvalue]))?>"> 
        <input name="oldsavetxt" type="hidden" id="oldsavetxt" value="<?=$r[savetxt]?>"> 
        <input name="oldlinkfieldval" type="hidden" id="oldlinkfieldval" value="<?=$r[linkfieldval]?>"> 
        <input name="oldfformsize" type="hidden" id="oldfformsize" value="<?=$r[fformsize]?>"> 
		<?=$ecms_hashur['form']?>
      </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��������</td>
    </tr>
    <tr> 
      <td width="25%" height="25" bgcolor="#FFFFFF">�ֶ���</td>
      <td width="75%" height="25" bgcolor="#FFFFFF"> <input name="f" type="text" id="f" value="<?=$r[f]?>">
        <font color="#666666">(��Ӣ����������ɣ��Ҳ��������ֿ�ͷ�����磺&quot;title&quot;)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�ֶα�ʶ</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="fname" type="text" id="fname" value="<?=$r[fname]?>"> 
        <font color="#666666">(���磺&quot;����&quot;)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�ֶ�����</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="ftype" id="select">
          <option value="VARCHAR"<?=$typeVARCHAR?>>�ַ���0-255�ֽ�(VARCHAR)</option>
		  <option value="CHAR"<?=$typeCHAR?>>�����ַ���0-255�ֽ�(CHAR)</option>
          <option value="TEXT"<?=$typeTEXT?>>С���ַ���(TEXT)</option>
          <option value="MEDIUMTEXT"<?=$typeMEDIUMTEXT?>>�����ַ���(MEDIUMTEXT)</option>
          <option value="LONGTEXT"<?=$typeLONGTEXT?>>�����ַ���(LONGTEXT)</option>
          <option value="TINYINT"<?=$typeTINYINT?>>С��ֵ��(TINYINT)</option>
          <option value="SMALLINT"<?=$typeSMALLINT?>>����ֵ��(SMALLINT)</option>
          <option value="INT"<?=$typeINT?>>����ֵ��(INT)</option>
          <option value="BIGINT"<?=$typeBIGINT?>>������ֵ��(BIGINT)</option>
          <option value="FLOAT"<?=$typeFLOAT?>>��ֵ������(FLOAT)</option>
          <option value="DOUBLE"<?=$typeDOUBLE?>>��ֵ˫������(DOUBLE)</option>
          <option value="DATE"<?=$typeDATE?>>������(DATE)</option>
          <option value="DATETIME"<?=$typeDATETIME?>>����ʱ����(DATETIME)</option>
        </select>
        ���� 
        <input name="flen" type="text" id="flen" value="<?=$r[flen]?>" size="6"> 
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��ű�</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="tbdataf" value="0"<?=$r[tbdataf]==0?' checked':''?><?=$disabled?>>
        ���� 
        <input type="radio" name="tbdataf" value="1"<?=$r[tbdataf]==1?' checked':''?><?=$disabled?>>
        ����<?=$tbdatafhidden?><font color="#666666"> (���ú����޸�)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">������</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="iskey" value="1"<?=$r[iskey]==1?' checked':''?>>
        �� 
        <input type="radio" name="iskey" value="0"<?=$r[iskey]==0?' checked':''?>>
        �� 
        <input name="oldiskey" type="hidden" id="oldiskey" value="<?=$r[iskey]?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ֵΨһ</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="isonly" value="1"<?=$r[isonly]==1?' checked':''?>>
        �� 
        <input type="radio" name="isonly" value="0"<?=$r[isonly]==0?' checked':''?>>
        �� 
        <input name="oldisonly" type="hidden" id="oldisonly" value="<?=$r[isonly]?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�ɼ���</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="iscj" type="radio" value="1"<?=$r[iscj]==1?' checked':''?>>
        �� 
        <input name="iscj" type="radio" value="0"<?=$r[iscj]==0?' checked':''?>>
        �� 
        <input name="oldiscj" type="hidden" id="oldiscj" value="<?=$r[iscj]?>"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��ҳ�ֶ�</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ispage" value="1"<?=$r[ispage]==1?' checked':''?>>
        �� 
        <input type="radio" name="ispage" value="0"<?=$r[ispage]==0?' checked':''?>>
        ��<font color="#666666">(��ֻ������һ���ֶ�)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">����ֶ�</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="issmalltext" value="1"<?=$r[issmalltext]==1?' checked':''?>>
        �� 
        <input type="radio" name="issmalltext" value="0"<?=$r[issmalltext]==0?' checked':''?>>
        ��<font color="#666666">(ģ�������ý�ȡ����������ֶ�)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">���ݴ��ı�</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="savetxt" value="1"<?=$r[savetxt]==1?' checked':''?><?=$disabled?>>
        �� 
        <input type="radio" name="savetxt" value="0"<?=$r[savetxt]==0?' checked':''?><?=$disabled?>>
        ��<?=$savetxthidden?><font color="#666666">(���ú����޸�,��ֻ������һ���ֶ�)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ǰ̨������ʾ</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="tobr" type="checkbox" id="tobr" value="1"<?=$r[tobr]==1?' checked':''?>>
        ���س��滻�ɻ��з�, 
        <input name="dohtml" type="checkbox" id="dohtml" value="1"<?=$r[dohtml]==1?' checked':''?>>
        ֧��html����</td>
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
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��ʾ˳��</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>"> 
        <font color="#666666">(����ԽСԽǰ��)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">����ʾ����</td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">�������ʾԪ��</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="fform" id="fform" onchange="ShowFieldFormSet(document.addfform,this.options[this.selectedIndex].value)">
          <option value="text"<?=$formtext?>>�����ı���(text)</option>
          <option value="password"<?=$formpassword?>>�����(password)</option>
          <option value="select"<?=$formselect?>>������(select)</option>
          <option value="radio"<?=$formradio?>>��ѡ��(radio)</option>
          <option value="checkbox"<?=$formcheckbox?>>��ѡ��(checkbox)</option>
          <option value="textarea"<?=$formtextarea?>>�����ı���(textarea)</option>
          <option value="editor"<?=$formeditor?>>�༭��(editor)</option>
          <option value="img"<?=$formimg?>>ͼƬ(img)</option>
          <option value="flash"<?=$formflash?>>FLASH�ļ�(flash)</option>
          <option value="file"<?=$formfile?>>�ļ�(file)</option>
          <option value="date"<?=$formdate?>>����(date)</option>
		  <option value="datetime"<?=$formdatetime?>>����ʱ��(datetime)</option>
          <option value="color"<?=$formcolor?>>��ɫ(color)</option>
		  <option value="morevaluefield"<?=$formmorevaluefield?>>��ֵ�ֶ�(morevaluefield)</option>
          <option value="linkfield"<?=$formlinkfield?>>ѡ���������ֶ�(linkfield)</option>
          <option value="linkfieldselect"<?=$formlinkfieldselect?>>�����������ֶ�(linkfieldselect)</option>
        </select> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ѡ��</td>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="2">
          <tr id="fsizediv"> 
            <td height="23"><strong>Ԫ�س���</strong><br> <input name="fformsize" type="text" id="fformsize" value="<?=$r[fformsize]?>"> 
              <font color="#666666">(��Ϊ��Ĭ��)</font></td>
          </tr>
          <tr id="fwidthdiv"> 
            <td height="23"><strong>Ԫ�ش�С</strong><br>
              ��� 
              <input name="fformwidth" type="text" id="fformwidth" value="<?=$fformwidth?>" size="6">
              ���߶� 
              <input name="fformheight" type="text" id="fformheight" value="<?=$fformheight?>" size="6"> 
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
            </td>
          </tr>
          <tr id="feditordiv"> 
            <td height="23"><strong>�༭����ʽ</strong><br> <input type="radio" name="editorys" value="0"<?=$r[editorys]==0?' checked':''?>>
              ��׼�� 
              <input type="radio" name="editorys" value="1"<?=$r[editorys]==1?' checked':''?>>
              �����</td>
          </tr>
		  <tr id="fmorevaluediv"> 
            <td height="23"><strong>��ֵ�ֶ�Ԫ�ظ�ʽ</strong><br>
              �������� 
              <input name="fmvnum" type="text" id="fmvnum" value="<?=$fmvnum?>" size="6">
              ��Ĭ������ 
              <input name="fmvline" type="text" id="fmvline" value="<?=$fmvline?>" size="6">
              ����
              <input name="fmvmust" type="text" id="fmvmust" value="<?=$fmvmust?>" size="6">
              �б���</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><p>��ʼֵ<br>
          <font color="#666666"><span id="defvaldiv">(���ֵ��&quot;�س�&quot;�񿪣�<br>
          ������/��ѡ/��ѡ����ʽ�ã�ֵ==���ƣ�<br>
          ��ֵ��������ʱ�����ƿ�ʡ�ԣ�<br>
          Ĭ��ѡ�����ӣ�:default)</span></font></p></td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="fvalue" cols="65" rows="8" id="fvalue" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes(str_replace("|","\r\n",$r[fvalue])))?></textarea></td>
    </tr>
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
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td height="25"><font color="#666666">˵���������ֶ�Խ��Ч��Խ�ߣ������б�����ֶν��齫�ֶδ��ڸ���</font></td>
    </tr>
  </table>
</form>
</body>
</html>
