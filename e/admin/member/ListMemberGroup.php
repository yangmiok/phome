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
CheckLevel($logininid,$loginin,$classid,"membergroup");
$url="<a href=ListMemberGroup.php".$ecms_hashur['whehref'].">�����Ա��</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����Ա��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%">λ�ã� 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӻ�Ա��" onclick="self.location.href='AddMemberGroup.php?enews=AddMemberGroup<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="35%" height="25"> <div align="center">��Ա������</div></td>
    <td width="11%"><div align="center">����ֵ</div></td>
    <td width="16%"><div align="center">���Ͷ���Ϣ</div></td>
    <td width="14%"><div align="center">ע���ַ</div></td>
    <td width="18%" height="25"> <div align="center">����</div></td>
  </tr>
  <?
  $sql=$empire->query("select * from {$dbtbpre}enewsmembergroup order by groupid");
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[groupid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[groupname]?>
      </div></td>
    <td><div align="center"> 
        <?=$r[level]?>
      </div></td>
    <td><div align="center"><a href="SendMsg.php?groupid=<?=$r[groupid]?><?=$ecms_hashur['ehref']?>" target=_blank>������Ϣ</a></div></td>
    <td><div align="center"><a href="../../member/register/?groupid=<?=$r[groupid]?>" target="_blank">ע���ַ</a></div></td>
    <td height="25"> <div align="center">[<a href="AddMemberGroup.php?enews=EditMemberGroup&groupid=<?=$r[groupid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="../ecmsmember.php?enews=DelMemberGroup&groupid=<?=$r[groupid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ���˻�Ա�飿');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  db_close();
  $empire=null;
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="6"><font color="#666666">˵��������ֵԽ�ߣ��鿴��Ϣ��Ȩ��Խ��</font></td>
  </tr>
</table>
</body>
</html>
