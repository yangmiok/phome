<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require '../'.LoadLang("pub/fun.php");
require("../../data/dbcache/class.php");
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

$enews=ehtmlspecialchars($_GET['enews']);
$form=RepPostVar($_GET['form']);
$field=RepPostVar($_GET['field']);
$keyboard=RepPostVar($_GET['keyboard']);
//���ݱ�
$tbs='';
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable where intb=0 order by tid");
while($tr=$empire->fetch($tsql))
{
	$tbs.="<option value='".$tr[tbname]."'>".$tr[tname]."</option>";
}
//�¼�
$word='ѡ����Ϣ';
$word_button='����ѡ����Ϣ';
if($enews=='LoadInSpInfo')
{
	$word='ѡ����Ϣ';
	$word_button='����ѡ����Ϣ';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$word?></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function UpdateChangeInfoid(obj){
	var isok;
	isok=confirm('ȷ��Ҫ����?');
	if(isok==false)
	{
		return '';
	}
	opener.ChangeInfoDoAction(obj.truetbname.value,obj.trueinfoid.value);
	window.close();
}
function CheckSearchForm(obj){
	if(obj.keyboard.value=='')
	{
		alert('�����ؼ��ֲ���Ϊ��');
		obj.keyboard.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr> 
    <td height="25" class="header"><?=$word?></td>
  </tr>
  <tr> 
    <td width="100%" height="25" valign="top" bgcolor="#FFFFFF"> 
      <table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
        <form action="ChangeInfoShow.php" method="POST" name="searchinfoform" target="searchinfopage" id="searchinfoform" onsubmit="return CheckSearchForm(document.searchinfoform);">
		<?=$ecms_hashur['eform']?>
          <tr> 
            <td height="25">��ѯ��
              <select name="tbname" id="tbname">
			  <?=$tbs?>
              </select> 
              <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>"> 
              <select name="show" id="show">
                <option value="1" selected>����</option>
                <option value="2">�ؼ���</option>
                <option value="3">ID</option>
              </select>
              <span id="listfileclassnav"></span> <input type="submit" name="Submit" value="����"> 
              <input name="sear" type="hidden" id="sear" value="1">
              <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
              <font color="#666666">(��������ؼ��ֿ��ÿո����)</font></td>
          </tr>
          <tr> 
            <td height="405" valign="top" bgcolor="#FFFFFF"> <IFRAME frameBorder="0" id="searchinfopage" name="searchinfopage" scrolling="yes" src="ChangeInfoShow.php<?=$ecms_hashur['whehref']?>" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1"></IFRAME></td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="truechangeinfoform" id="truechangeinfoform" method="post" action="">
  <tr>
      <td height="25"><input type="button" name="Submit2" value="<?=$word_button?>" onclick="UpdateChangeInfoid(document.truechangeinfoform);">
        (������<span id="truechangeinfonum"><strong>0</strong></span>) 
        <input name="trueinfoid" type="hidden" id="trueinfoid"> 
        <input name="truetbname" type="hidden" id="truetbname"></td>
  </tr>
  </form>
</table>
<IFRAME frameBorder="0" id="showclassnav" name="showclassnav" scrolling="no" src="../ShowClassNav.php?ecms=5<?=$ecms_hashur['ehref']?>" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>
</body>
</html>
<?php
db_close();
$empire=null;
?>