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
CheckLevel($logininid,$loginin,$classid,"setsafe");
if($ecms_config['esafe']['openonlinesetting']==0||$ecms_config['esafe']['openonlinesetting']==1)
{
	echo"û�п�����̨�������ò��������Ҫʹ�������������޸�/e/config/config.php�ļ���\$ecms_config['esafe']['openonlinesetting']�������ÿ���";
	exit();
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	include('setfun.php');
}
if($enews=='SetSafe')
{
	SetSafe($_POST,$logininid,$loginin);
}

db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��ȫ��������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>λ�ã�<a href="SetSafe.php<?=$ecms_hashur['whehref']?>">��ȫ��������</a> 
      <div align="right"> </div></td>
  </tr>
</table>
<form name="setform" method="post" action="SetSafe.php" onsubmit="return confirm('ȷ������?');" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">��ȫ�������� 
        <input name="enews" type="hidden" id="enews" value="SetSafe"> </td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��̨��ȫ�������</td>
    </tr>
    <tr> 
      <td width="17%" height="25" bgcolor="#FFFFFF"> <div align="left">��̨��¼��֤��</div></td>
      <td width="83%" height="25" bgcolor="#FFFFFF"> <input name="loginauth" type="password" id="loginauth" value="<?=$ecms_config['esafe']['loginauth']?>" size="35"> 
        <font color="#666666">(������õ�¼��Ҫ�������֤�����ͨ��)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="left">��̨��¼COOKIE��֤��</div></td>
      <td height="25" bgcolor="#FFFFFF"> <input name="ecookiernd" type="text" id="ecookiernd" value="<?=$ecms_config['esafe']['ecookiernd']?>" size="35"> 
        <input type="button" name="Submit3" value="���" onclick="document.setform.ecookiernd.value='<?=make_password(36)?>';"> 
        <font color="#666666">(��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��̨������֤��¼IP</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="ckhloginip" value="1"<?=$ecms_config['esafe']['ckhloginip']==1?' checked':''?>>
        ���� 
        <input type="radio" name="ckhloginip" value="0"<?=$ecms_config['esafe']['ckhloginip']==0?' checked':''?>>
        �ر� <font color="#666666">(���������IP�Ǳ䶯�ģ���Ҫ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��̨����SESSION��֤</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="ckhsession" value="1"<?=$ecms_config['esafe']['ckhsession']==1?' checked':''?>>
        ���� 
        <input type="radio" name="ckhsession" value="0"<?=$ecms_config['esafe']['ckhsession']==0?' checked':''?>>
        �ر� <font color="#666666">(����ȫ����ռ�֧��SESSION)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��¼��½��־</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="theloginlog" value="0"<?=$ecms_config['esafe']['theloginlog']==0?' checked':''?>>
        ���� 
        <input type="radio" name="theloginlog" value="1"<?=$ecms_config['esafe']['theloginlog']==1?' checked':''?>>
        �ر�</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��¼������־</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="radio" name="thedolog" value="0"<?=$ecms_config['esafe']['thedolog']==0?' checked':''?>>
        ���� 
        <input type="radio" name="thedolog" value="1"<?=$ecms_config['esafe']['thedolog']==1?' checked':''?>>
        �ر�</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">����������Դ��֤</td>
      <td height="25" bgcolor="#FFFFFF"><select name="ckfromurl" id="ckfromurl">
          <option value="0"<?=$ecms_config['esafe']['ckfromurl']==0?' selected':''?>>��������֤</option>
          <option value="1"<?=$ecms_config['esafe']['ckfromurl']==1?' selected':''?>>����ǰ��̨��֤</option>
          <option value="2"<?=$ecms_config['esafe']['ckfromurl']==2?' selected':''?>>��������̨��֤</option>
          <option value="3"<?=$ecms_config['esafe']['ckfromurl']==3?' selected':''?>>������ǰ̨��֤</option>
		  <option value="4"<?=$ecms_config['esafe']['ckfromurl']==4?' selected':''?>>����ǰ��̨��֤(�ϸ�)</option>
		  <option value="5"<?=$ecms_config['esafe']['ckfromurl']==5?' selected':''?>>��������̨��֤(�ϸ�)</option>
		  <option value="6"<?=$ecms_config['esafe']['ckfromurl']==6?' selected':''?>>������ǰ̨��֤(�ϸ�)</option>
        </select>
        <font color="#666666">(���ý�ֹ�Ǳ�վ���ʵ�ַ��Դ)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">������̨��Դ��֤��</td>
      <td height="25" bgcolor="#FFFFFF"><select name="ckhash" id="ckhash">
        <option value="0"<?=$ecms_config['esafe']['ckhash']==0?' selected':''?>>���ģʽ</option>
        <option value="1"<?=$ecms_config['esafe']['ckhash']==1?' selected':''?>>���ģʽ</option>
        <option value="2"<?=$ecms_config['esafe']['ckhash']==2?' selected':''?>>�ر���֤</option>
      </select>
        <font color="#666666">(�Ƽ����á����ģʽ�������ⲿ�������ύ���з���)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF">���ʱ�������
        <input name="ckhashename" type="text" id="ckhashename" value="<?=$ecms_config['esafe']['ckhashename']?>" size="12">
      ���ύ��������
      <input name="ckhashrname" type="text" id="ckhashrname" value="<?=$ecms_config['esafe']['ckhashrname']?>" size="12">
      <font color="#666666">(������ĸ��ͷ,����ֻ������ĸ�����֡��»������)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">��̨���ʵ�UserAgent����</td>
      <td height="25" bgcolor="#FFFFFF"><input name="ckhuseragent" type="text" id="ckhuseragent" value="<?=$ecms_config['esafe']['ckhuseragent']?>" size="35">
        <font color="#666666">(���ִ�Сд������á�||�����˫���߸��������ú�UserAgent��Ϣ���������Щ�ַ����ܷ��ʺ�̨)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">COOKIE����</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE������</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="cookiedomain" type="text" id="fw_pass3" value="<?=$ecms_config['cks']['ckdomain']?>" size="35">      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE����·��</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookiepath" type="text" id="cookiedomain" value="<?=$ecms_config['cks']['ckpath']?>" size="35"></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">COOKIE��HttpOnly����</td>
      <td height="25" bgcolor="#FFFFFF"><select name="ckhttponly" id="ckhttponly">
        <option value="0"<?=$ecms_config['cks']['ckhttponly']==0?' selected':''?>>�ر�</option>
        <option value="1"<?=$ecms_config['cks']['ckhttponly']==1?' selected':''?>>����</option>
        <option value="2"<?=$ecms_config['cks']['ckhttponly']==2?' selected':''?>>ֻ��̨����</option>
        <option value="3"<?=$ecms_config['cks']['ckhttponly']==3?' selected':''?>>ֻǰ̨����</option>
      </select>      </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">COOKIE��secure����</td>
      <td height="25" bgcolor="#FFFFFF"><select name="cksecure" id="cksecure">
        <option value="0"<?=$ecms_config['cks']['cksecure']==0?' selected':''?>>�Զ�ʶ��</option>
		<option value="1"<?=$ecms_config['cks']['cksecure']==1?' selected':''?>>�ر�</option>
        <option value="2"<?=$ecms_config['cks']['cksecure']==2?' selected':''?>>����</option>
        <option value="3"<?=$ecms_config['cks']['cksecure']==3?' selected':''?>>ֻ��̨����</option>
        <option value="4"<?=$ecms_config['cks']['cksecure']==4?' selected':''?>>ֻǰ̨����</option>
      </select>
        <font color="#666666">(������Ҫhttps֧��)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ǰ̨COOKIE����ǰ׺</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookievarpre" type="text" id="cookievarpre" value="<?=$ecms_config['cks']['ckvarpre']?>" size="35"> 
        <font color="#666666">(��Ӣ����ĸ���,5~12���ַ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��̨COOKIE����ǰ׺</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookieadminvarpre" type="text" id="cookieadminvarpre" value="<?=$ecms_config['cks']['ckadminvarpre']?>" size="35"> 
        <font color="#666666">(��Ӣ����ĸ���,5~12���ַ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">COOKIE��֤�����</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="cookieckrnd" type="text" id="cookieckrnd" value="<?=$ecms_config['cks']['ckrnd']?>" size="35"> 
        <input type="button" name="Submit32" value="���" onclick="document.setform.cookieckrnd.value='<?=make_password(36)?>';"> 
        <font color="#666666">(��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">COOKIE��֤�����2</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookieckrndtwo" type="text" id="cookieckrndtwo" value="<?=$ecms_config['cks']['ckrndtwo']?>" size="35">
        <input type="button" name="Submit322" value="���" onclick="document.setform.cookieckrndtwo.value='<?=make_password(36)?>';">
        <font color="#666666">(��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">COOKIE��֤�����3</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookieckrndthree" type="text" id="cookieckrndthree" value="<?=$ecms_config['cks']['ckrndthree']?>" size="35">
        <input type="button" name="Submit3222" value="���" onclick="document.setform.cookieckrndthree.value='<?=make_password(36)?>';">
        <font color="#666666">(��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">COOKIE��֤�����4</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookieckrndfour" type="text" id="cookieckrndfour" value="<?=$ecms_config['cks']['ckrndfour']?>" size="35">
        <input type="button" name="Submit32222" value="���" onclick="document.setform.cookieckrndfour.value='<?=make_password(36)?>';">
        <font color="#666666">(��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">COOKIE��֤�����5</td>
      <td height="25" bgcolor="#FFFFFF"><input name="cookieckrndfive" type="text" id="cookieckrndfive" value="<?=$ecms_config['cks']['ckrndfive']?>" size="35">
        <input type="button" name="Submit322222" value="���" onclick="document.setform.cookieckrndfive.value='<?=make_password(36)?>';">
        <font color="#666666">(��д10~50�������ַ�����ö����ַ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"></td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value=" �� �� "> 
        &nbsp;&nbsp;&nbsp; <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
