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
CheckLevel($logininid,$loginin,$classid,"yh");
$enews=RepPostStr($_GET['enews'],1);
$url="<a href=ListYh.php".$ecms_hashur['whehref'].">�����Ż�����</a> &gt; �����Ż�����";
$r[hlist]=30;
$r[qlist]=30;
$r[bqnew]=30;
$r[bqhot]=30;
$r[bqpl]=30;
$r[bqgood]=30;
$r[bqfirst]=30;
$r[bqdown]=30;
$r[otherlink]=30;
$r[qmlist]=0;
$r[dobq]=1;
$r[dojs]=1;
$r[dosbq]=0;
$r[rehtml]=0;
//����
if($enews=="AddYh"&&$_GET['docopy'])
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsyh where id='$id'");
	$url="<a href=ListYh.php".$ecms_hashur['whehref'].">�����Ż�����</a> &gt; �����Ż�������<b>".$r[yhname]."</b>";
}
//�޸�
if($enews=="EditYh")
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsyh where id='$id'");
	$url="<a href=ListYh.php".$ecms_hashur['whehref'].">�����Ż�����</a> -&gt; �޸��Ż�������<b>".$r[yhname]."</b>";
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>�Ż�����</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListYh.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�����Ż����� 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="id" type="hidden" id="id" value="<?=$id?>"> 
      </td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">��������:</td>
      <td width="80%" height="25" bgcolor="#FFFFFF"> <input name="yhname" type="text" id="yhname" value="<?=$r[yhname]?>" size="42"> 
      </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">����˵����</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="yhtext" cols="45" rows="4" id="yhtext"><?=ehtmlspecialchars($r[yhtext])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��Ϣ�б�</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">��̨�����б�</td>
      <td height="25" bgcolor="#FFFFFF"> ��ʾ 
        <input name="hlist" type="text" id="hlist" value="<?=$r[hlist]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ǰ̨�����б�</td>
      <td height="25" bgcolor="#FFFFFF">��ʾ 
        <input name="qmlist" type="text" id="qmlist" value="<?=$r[qmlist]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ǰ̨��Ϣ�б�</td>
      <td height="25" bgcolor="#FFFFFF">��ʾ 
        <input name="qlist" type="text" id="qlist" value="<?=$r[qlist]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">��ǩ���� </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�Ż���Χ��</td>
      <td height="25" bgcolor="#FFFFFF"><input name="dobq" type="checkbox" id="dobq" value="1"<?=$r[dobq]==1?' checked':''?>>
        ��ǩ���� 
        <input name="dojs" type="checkbox" id="dojs" value="1"<?=$r[dojs]==1?' checked':''?>>
        JS���� 
        <input name="dosbq" type="checkbox" id="dosbq" value="1"<?=$r[dosbq]==1?' checked':''?>>
        ��Ա�ռ��ǩ����</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">������Ϣ��</td>
      <td height="25" bgcolor="#FFFFFF">���� 
        <input name="bqnew" type="text" id="hlist3" value="<?=$r[bqnew]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">������У�</td>
      <td height="25" bgcolor="#FFFFFF">���� 
        <input name="bqhot" type="text" id="bqnew" value="<?=$r[bqhot]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�Ƽ���Ϣ��</td>
      <td height="25" bgcolor="#FFFFFF">���� 
        <input name="bqgood" type="text" id="bqnew2" value="<?=$r[bqgood]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�������У�</td>
      <td height="25" bgcolor="#FFFFFF">���� 
        <input name="bqpl" type="text" id="bqnew3" value="<?=$r[bqpl]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">ͷ����Ϣ��</td>
      <td height="25" bgcolor="#FFFFFF">���� 
        <input name="bqfirst" type="text" id="bqnew4" value="<?=$r[bqfirst]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">�������У�</td>
      <td height="25" bgcolor="#FFFFFF">���� 
        <input name="bqdown" type="text" id="bqnew5" value="<?=$r[bqdown]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">�������</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">����ҳ���ɷ�Χ��</td>
      <td height="25" bgcolor="#FFFFFF">���� 
        <input name="rehtml" type="text" id="rehtml" value="<?=$r[rehtml]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">������Ӽ�����Χ��</td>
      <td height="25" bgcolor="#FFFFFF"> ��ѯ 
        <input name="otherlink" type="text" id="otherlink" value="<?=$r[otherlink]?>" size="8">
        ���ڵ���Ϣ <font color="#666666">(0Ϊ����)</font></td>
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
