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
CheckLevel($logininid,$loginin,$classid,"table");
$enews=RepPostStr($_GET['enews'],1);
$url="<a href=ListTable.php".$ecms_hashur['whehref'].">�������ݱ�</a>&nbsp;>&nbsp;�½����ݱ�";
//�޸�
if($enews=="EditTable")
{
	$tid=(int)$_GET['tid'];
	$url="<a href=ListTable.php".$ecms_hashur['whehref'].">�������ݱ�</a>&nbsp;>&nbsp;�޸����ݱ�";
	$r=$empire->fetch1("select tid,tbname,tname,tsay,yhid,intb from {$dbtbpre}enewstable where tid='$tid'");
}
//�Ż�����
$yh_options='';
$yhsql=$empire->query("select id,yhname from {$dbtbpre}enewsyh order by id");
while($yhr=$empire->fetch($yhsql))
{
	$select='';
	if($r[yhid]==$yhr[id])
	{
		$select=' selected';
	}
	$yh_options.="<option value='".$yhr[id]."'".$select.">".$yhr[yhname]."</option>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�½����ݱ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>λ�ã� 
      <?=$url?>
    </td>
  </tr>
</table>
<form name="form1" method="post" action="../ecmsmod.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr> 
      <td height="25" colspan="2" class="header">����/�޸����ݱ�</td>
    </tr>
    <tr> 
      <td width="23%" height="25" bgcolor="#F8F8F8">���ݱ���:</td>
      <td width="77%" height="25" bgcolor="#FFFFFF"><strong> 
        <?=$dbtbpre?>
        ecms_</strong> <input name="tbname" type="text" id="tbname" value="<?=$r[tbname]?>">
        *<font color="#666666">(��:news,ֻ������ĸ���������)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#F8F8F8">���ݱ��ʶ:</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="tname" type="text" id="tname" value="<?=$r[tname]?>" size="38">
        *<font color="#666666">(��:�������ݱ�)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#F8F8F8">ʹ���Ż�����:</td>
      <td height="25" bgcolor="#FFFFFF"><select name="yhid" id="yhid">
          <option name="0">��ʹ��</option>
          <?=$yh_options?>
        </select> <input type="button" name="Submit63" value="�����Ż�����" onclick="window.open('../db/ListYh.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#F8F8F8">�Ƿ��ڲ���:</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="intb" value="0"<?=$r['intb']==0?' checked':''?>>
        ������ 
        <input type="radio" name="intb" value="1"<?=$r['intb']==1?' checked':''?>>
        �ڲ��� <font color="#666666">(�ڲ���ǰ̨����ʾ�����ɣ�ֻ�к�̨���ܲ鿴)</font></td>
    </tr>
    <tr> 
      <td height="25" valign="top" bgcolor="#F8F8F8">��ע:</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="tsay" cols="70" rows="8" id="tsay"><?=stripSlashes($r[tsay])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#F8F8F8">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="�ύ"> 
        <input type="reset" name="Submit2" value="����"> <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="oldtbname" type="hidden" id="oldtbname" value="<?=$r[tbname]?>"></td>
    </tr>
  </table>
</form>
</body>
</html>
