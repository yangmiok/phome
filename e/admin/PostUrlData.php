<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
$link=db_connect();
$empire=new mysqlquery();
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
CheckLevel($logininid,$loginin,$classid,"postdata");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>Զ�̷���</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
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
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="PostUrlData.php<?=$ecms_hashur['whehref']?>">Զ�̷���</a></td>
  </tr>
</table>
<form name="form1" method="post" action="enews.php" onsubmit="return confirm('ȷ��Ҫ������');">
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="2">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="6%" height="25"> <div align="center"></div></td>
      <td width="49%" height="25">����</td>
      <td width="45%" height="25">˵��</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"></div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>������ (/d)</strong></td>
      <td height="25" bgcolor="#DBEAF5">��Ÿ���Ŀ¼</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="d/file!!!0">
        </div></td>
      <td height="25">�ϴ������� (/d/file)</td>
      <td height="25">ϵͳ�ϴ��ĸ������Ŀ¼</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="d/js!!!0">
        </div></td>
      <td height="25">����JS�� (/d/js)</td>
      <td height="25">����JS�������JS,ͶƱJS,ͼƬ��ϢJS,������/����JS��</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="s!!!0">
        </div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>ר��� (/s)</strong></td>
      <td height="25" bgcolor="#DBEAF5">ר����Ŀ¼</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"></div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>ϵͳ��̬��[�����ݿ����] (/e)</strong></td>
      <td height="25" bgcolor="#DBEAF5">�����ݿ�򽻵��İ�</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]3" value="search!!!0">
        </div></td>
      <td height="25">��Ϣ�������� (/search)</td>
      <td height="25">��Ϣ������</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]5" value="e/pl!!!0">
        </div></td>
      <td height="25">��Ϣ���۰� (/e/pl)</td>
      <td height="25">��Ϣ����ҳ��</td>
    </tr>
    <tr> 
      <td height="25"><div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="e/DoPrint!!!0">
        </div></td>
      <td height="25">��Ϣ��ӡ��(/e/DoPrint)</td>
      <td height="25">��Ϣ��ӡҳ��</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]6" value="e/data/template!!!0">
        </div></td>
      <td height="25">��Ա�������ģ��� (/e/data/template)</td>
      <td height="25">��Ա�������ģ��</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]7" value="e/config/config.php,e/data/dbcache/class.php,e/data/dbcache/class1.php,e/data/dbcache/ztclass.php,e/data/dbcache/MemberLevel.php!!!1">
        </div></td>
      <td height="25">����� (/e/config/config.php,e/data/dbcache/class.php)</td>
      <td height="25">ϵͳ���õ�һЩ��������</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"></div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>վ��Ŀ¼�� (/)</strong></td>
      <td height="25" bgcolor="#DBEAF5">��Ϣ��Ŀ���Ŀ¼</td>
    </tr>
    <?
	$sql=$empire->query("select classid,classurl,classname,classpath from {$dbtbpre}enewsclass where bclassid=0 order by classid desc");
	while($r=$empire->fetch($sql))
	{
	if($r[classurl])
	{
	$classurl=$r[classurl];
	}
	else
	{
	$classurl="../../".$r[classpath];
	}
	?>
    <tr> 
      <td height="25"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]10" value="<?=$r[classpath]?>!!!0">
        </div></td>
      <td height="25"><a href='<?=$classurl?>' target=_blank> 
        <?=$r[classname]?>
        </a>&nbsp;(/ 
        <?=$r[classpath]?>
        )</td>
      <td height="25"> 
        <?=$r[classurl]?>
      </td>
    </tr>
    <?
	}
	?>
    <tr> 
      <td height="25" bgcolor="#DBEAF5"> <div align="center"> 
          <input name="postdata[]" type="checkbox" id="postdata[]" value="index<?=$public_r[indextype]?>!!!1">
        </div></td>
      <td height="25" bgcolor="#DBEAF5"><strong>��ҳ (/index 
        <?=$public_r[indextype]?>
        )</strong></td>
      <td height="25" bgcolor="#DBEAF5">��վ��ҳ</td>
    </tr>
    <tr> 
      <td height="25"> <div align="center"> 
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        </div></td>
      <td height="25"> <input type="submit" name="Submit" value="��ʼ����"> &nbsp;&nbsp; 
        <input type="button" name="Submit2" value="����FTP����" onclick="javascript:window.open('SetEnews.php<?=$ecms_hashur['whehref']?>');"> 
        <input name="enews" type="hidden" id="enews" value="AddPostUrlData"></td>
      <td height="25">ÿ <input name="line" type="text" id="line" value="10" size="6">
        ����ĿΪһ��</td>
    </tr>
    <tr> 
      <td height="25" colspan="3"><div align="left">(��ע��Զ�̷��������ѵ�ʱ��ϳ��������ĵȴ�.��ý���������ʱ����Ϊ�)</div></td>
    </tr>
  </table>
  <br>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
