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

$getvar=ehtmlspecialchars($_GET['getvar']);
$returnvar=ehtmlspecialchars($_GET['returnvar']);
$fun=ehtmlspecialchars($_GET['fun']);
$notfullpage=ehtmlspecialchars($_GET['notfullpage']);
db_close();
$empire=null;
include('../ecmseditor/eshoweditortemp.php');
$loadeditorjs=ECMS_TempShowEditorJS('../ecmseditor/tempeditor/');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>���߱༭ģ��</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<?=$loadeditorjs?>
<script>
function eSetPageText(){
	var editor=CKEDITOR.instances.pagetext;
	var textvalue=<?=$getvar?>;
	editor.setData(textvalue);
}

function eGetPageText(){
	var editor=CKEDITOR.instances.pagetext;
	return editor.getData();
}

function SaveTemp(){
var isok=confirm('ȷ��Ҫ����?');
if(isok)
{
<?=$returnvar?>=eGetPageText();
window.close();
}
return false;
}
</script>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <form name="edittemp" method="post" action="../enews.php" onsubmit="return SaveTemp()">
  <?=$ecms_hashur['eform']?>
    <tr class="header"> 
      <td width="82%">���߱༭ģ��<font color="#FF0000">(���������װdreamweaver���Ƽ���dreamweaver�༭)</font></td>
      <td width="18%"> 
        <div align="right"> 
          <select name="notfullpage" onchange="self.location.href='editor.php?<?=$ecms_hashur['ehref']?>&getvar=<?=$getvar?>&returnvar=<?=$returnvar?>&fun=<?=$fun?>&notfullpage='+this.options[this.selectedIndex].value;">
            <option value='0'<?=$notfullpage==0?' selected':''?>>�༭����ҳ��(��body)</option>
            <option value='1'<?=$notfullpage==1?' selected':''?>>�༭�ֲ�����(����body)</option>
          </select>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="button" name="Submit" value=" �������� " onclick="return SaveTemp()">
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"><div align="center"> 
	  <?=ECMS_TempShowEditorVar('pagetext','','','','480','100%',$notfullpage?0:1)?>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"> <div align="center"> 
          <input type="button" name="Submit2" value=" �������� " onclick="return SaveTemp()">
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"> &nbsp;[<a href="#ecms" onclick="window.open('EnewsBq.php<?=$ecms_hashur['whehref']?>','','width=600,height=500,scrollbars=yes,resizable=yes');">�鿴ģ���ǩ�﷨</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴JS���õ�ַ</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListTempvar.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴����ģ�����</a>] 
        &nbsp;&nbsp;[<a href="#ecms" onclick="window.open('ListBqtemp.php<?=$ecms_hashur['whehref']?>','','width=800,height=600,scrollbars=yes,resizable=yes');">�鿴��ǩģ��</a>]</td>
    </tr>
  </form>
</table>
<script>
eSetPageText();
</script>
</body>
</html>
