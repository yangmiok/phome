<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../member/class/user.php");
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
CheckLevel($logininid,$loginin,$classid,"pay");
$enews=ehtmlspecialchars($_GET['enews']);
$payid=(int)$_GET['payid'];
$r=$empire->fetch1("select * from {$dbtbpre}enewspayapi where payid='$payid'");
$url="����֧��&gt; <a href=PayApi.php".$ecms_hashur['whehref'].">����֧���ӿ�</a>&nbsp;>&nbsp;����֧���ӿڣ�<b>".$r[paytype]."</b>";
$registerpay='';
//֧����
if($r[paytype]=='alipay')
{
	//$registerpay="<input type=\"button\" value=\"��������֧�����ӿ�\" onclick=\"javascript:window.open('http://www.phome.net/empireupdate/payapi/?ecms=alipay');\">";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>֧���ӿ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="����֧����¼" onclick="self.location.href='ListPayRecord.php<?=$ecms_hashur['whehref']?>';">
        &nbsp;&nbsp; 
        <input type="button" name="Submit52" value="֧����������" onclick="self.location.href='SetPayFen.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<form name="setpayform" method="post" action="PayApi.php" enctype="multipart/form-data" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">����֧���ӿ� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="payid" type="hidden" id="payid" value="<?=$payid?>"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">�ӿ����ͣ�</div></td>
      <td height="25"> 
        <?=$r[paytype]?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">�ӿ�״̬��</div></td>
      <td height="25"><input type="radio" name="isclose" value="0"<?=$r[isclose]==0?' checked':''?>>
        ���� 
        <input type="radio" name="isclose" value="1"<?=$r[isclose]==1?' checked':''?>>
        �ر�</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="23%" height="25"><div align="right">�ӿ����ƣ�</div></td>
      <td width="77%" height="25"><input name="payname" type="text" id="payname" value="<?=$r[payname]?>" size="35"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"><div align="right">�ӿ�������</div></td>
      <td height="25"><textarea name="paysay" cols="65" rows="6" id="paysay"><?=ehtmlspecialchars($r[paysay])?></textarea></td>
    </tr>
    <?php
	if($r[paytype]=='alipay')
	{
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">֧�������ͣ�</div></td>
      <td height="25"><select name="paymethod" id="paymethod">
          <option value="0"<?=$r[paymethod]==0?' selected':''?>>ʹ�ñ�׼˫�ӿ�</option>
          <option value="1"<?=$r[paymethod]==1?' selected':''?>>ʹ�ü�ʱ���ʽ��׽ӿ�</option>
          <option value="2"<?=$r[paymethod]==2?' selected':''?>>ʹ�õ������׽ӿ�</option>
        </select></td>
    </tr>
    <?php
	}
	?>
	<?php
	if($r[paytype]=='alipay')
	{
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">֧�����ʺţ�</div></td>
      <td height="25"><input name="payemail" type="text" id="payemail" value="<?=$r[payemail]?>" size="35"></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right"><?=$r[paytype]=='alipay'?'���������(parterID)':'�̻���(ID)'?>��</div></td>
      <td height="25"><input name="payuser" type="text" id="payuser" value="<?=$r[payuser]?>" size="35"> 
        <?=$registerpay?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right"><?=$r[paytype]=='alipay'?'���װ�ȫУ����(key)':'��Կ(KEY)'?>��</div></td>
      <td height="25"><input name="paykey" type="text" id="paykey" value="<?=$r[paykey]?>" size="35"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="right">�����ѣ�</div></td>
      <td height="25"><input name=payfee type=text id="payfee" value='<?=$r[payfee]?>' size="35">
        % </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="right">��ʾ����</div></td>
      <td height="25"><input name=myorder type=text id="myorder" value='<?=$r[myorder]?>' size="35">
        <font color="#666666">(ֵԽС��ʾԽǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value=" �� �� "> &nbsp;&nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
