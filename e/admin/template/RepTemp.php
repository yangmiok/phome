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
$enews=$_POST['enews'];
if($enews)
{
	hCheckEcmsRHash();
}
if($enews=="RepTemp")
{
	include("../../class/tempfun.php");
	DoRepTemp($_POST,$logininid,$loginin);
}
$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;->&nbsp;";
$url=$urlgname."<a href=RepTemp.php?gid=$gid".$ecms_hashur['ehref'].">�����滻ģ������</a>";
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����滻ģ������</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="RepTemp.php" onsubmit="return confirm('ȷ��Ҫ�滻��');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25"><div align="center"><strong>�����滻ģ������</strong> 
          <input name="enews" type="hidden" id="enews" value="RepTemp">
          <input name="gid" type="hidden" id="gid" value="<?=$gid?>">
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="21%" height="23"><div align="center"> </div>
              <div align="center"><strong>ԭ�ַ�</strong></div></td>
            <td width="79%" height="23"><textarea name="oldword" cols="78" rows="8" id="textarea3"></textarea></td>
          </tr>
          <tr> 
            <td height="23"><div align="center"><strong>���ַ�</strong></div></td>
            <td height="23"><textarea name="newword" cols="78" rows="8" id="textarea4"></textarea></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="center"> 
          <table width="98%" border="0" cellspacing="1" cellpadding="3">
            <tr> 
              <td width="16%" height="25"> <div align="left"> 
                  <input name="classtemp" type="checkbox" id="classtemp" value="1">
                  ����ģ��</div></td>
              <td width="16%"> <div align="left"> 
                  <input name="bqtemp" type="checkbox" id="bqtemp" value="1">
                  ��ǩģ��</div></td>
              <td width="16%"> <div align="left"> 
                  <input name="listtemp" type="checkbox" id="listtemp" value="1">
                  �б�ģ��</div></td>
              <td width="16%"> <div align="left"> 
                  <input name="newstemp" type="checkbox" id="classtemp3" value="1">
                  ����ģ��</div></td>
              <td width="16%"> <div align="left"> 
                  <input name="searchtemp" type="checkbox" id="newstemp" value="1">
                  ����ģ��</div></td>
            </tr>
            <tr> 
              <td height="25"> <div align="left"> 
                  <input name="pltemp" type="checkbox" id="pltemp3" value="1">
                  �����б�ģ�� </div></td>
              <td> <div align="left"> 
                  <input name="indextemp" type="checkbox" id="indextemp2" value="1">
                  ��ҳģ��</div></td>
              <td> <div align="left"> 
                  <input name="cptemp" type="checkbox" id="cptemp" value="1">
                  �������ģ��</div></td>
              <td> <div align="left"> 
                  <input name="sformtemp" type="checkbox" id="sformtemp" value="1">
                  �߼�������ģ��</div></td>
              <td> <div align="left"> 
                  <input name="printtemp" type="checkbox" id="searchtemp" value="1">
                  ��ӡģ��</div></td>
            </tr>
            <tr> 
              <td height="25"> <input name="userpage" type="checkbox" id="userpage" value="1">
                �Զ���ҳ��</td>
              <td> <input name="tempvar" type="checkbox" id="tempvar" value="1">
                ģ�����</td>
              <td><input name="gbooktemp" type="checkbox" id="gbooktemp" value="1">
                ���԰�ģ��</td>
              <td><input name="loginiframe" type="checkbox" id="loginiframe" value="1">
                ��½״̬ģ��</td>
              <td><input name="votetemp" type="checkbox" id="votetemp" value="1">
                ͶƱģ��</td>
            </tr>
            <tr> 
              <td height="25"><input name="pagetemp" type="checkbox" id="pagetemp" value="1">
                �Զ���ҳ��ģ��</td>
              <td> <input name="pljstemp" type="checkbox" id="pljstemp" value="1">
                ����JSģ��</td>
              <td> <input name="schalltemp" type="checkbox" id="schalltemp" value="1">
                ȫվ����ģ��</td>
              <td><input name="loginjstemp" type="checkbox" id="loginjstemp" value="1">
                JS���õ�½״̬ģ�� </td>
              <td><input name="downpagetemp" type="checkbox" id="downpagetemp" value="1">
                ��������ҳģ��</td>
            </tr>
            <tr>
              <td height="25"><input name="jstemp" type="checkbox" id="feedbackbtemp" value="1">
                JSģ��</td>
              <td><input name="otherlinktemp" type="checkbox" id="jstemp" value="1">
                �����Ϣģ��</td>
              <td><input name="feedbackbtemp" type="checkbox" id="feedbackbtemp3" value="1">
                ������ģ��</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="30">
<div align="center">
          <input type="submit" name="Submit" value=" �� �� ">&nbsp;&nbsp;
          <input type="reset" name="Submit2" value="����">
          &nbsp;&nbsp;<input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
          ѡ��ȫ��</div></td>
    </tr>
  </table>
</form>
</body>
</html>
