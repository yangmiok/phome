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
CheckLevel($logininid,$loginin,$classid,"bq");
$mess="<script>alert('��ѡ��Ҫ�����ı�ǩ');window.close();</script>";
$bqid=(int)$_GET['bqid'];
if(empty($bqid))
{
	echo $mess;
	exit();
}
$r=$empire->fetch1("select bqid,bqname,bq from {$dbtbpre}enewsbq where bqid=$bqid");
if(empty($r['bqid']))
{
	echo $mess;
	exit();
}
$url="&nbsp;������ǩ��".$r['bqname'];
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>������ǩ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="98%%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="../ecmstemp.php" onsubmit="return confirm('ȷ��Ҫ������');">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center">������ǩ 
          <input name="enews" type="hidden" id="enews" value="LoadOutBq">
          <input name="bqid" type="hidden" id="bqid" value="<?=$bqid?>">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td width="37%"><div align="right">��ǩ���ƣ�</div></td>
            <td width="63%" height="27"><b><? echo $r[bqname]."&nbsp;(".$r[bq].")";?></b></td>
          </tr>
          <tr> 
            <td height="27" colspan="2"> 
              <div align="center">��ǩ��������(e/class/userfun.php)��</div></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center">
                <textarea name="funvalue" cols="86" rows="16" id="funvalue"></textarea>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><div align="center">
          <input type="submit" name="Submit" value="���ϵ���">&nbsp;&nbsp;
          <input type="reset" name="Submit2" value="����">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
