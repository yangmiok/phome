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
$enews=ehtmlspecialchars($_GET['enews']);
$cid=ehtmlspecialchars($_GET['cid']);
$url="<a href=ListBq.php".$ecms_hashur['whehref'].">�����ǩ</a>&nbsp;>&nbsp;���ӱ�ǩ";
//�޸ı�ǩ
if($enews=="EditBq")
{
	$bqid=(int)$_GET['bqid'];
	$url="<a href=ListBq.php".$ecms_hashur['whehref'].">�����ǩ</a>&nbsp;>&nbsp;�޸ı�ǩ";
	$r=$empire->fetch1("select bqname,bqsay,funname,bq,issys,bqgs,isclose,classid,myorder from {$dbtbpre}enewsbq where bqid='$bqid'");
}
//����
$cstr="";
$csql=$empire->query("select classid,classname from {$dbtbpre}enewsbqclass order by classid");
while($cr=$empire->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$empire=null;

//--------------------html�༭��
include('../ecmseditor/eshoweditor.php');
$loadeditorjs=ECMS_ShowEditorJS('../ecmseditor/infoeditor/');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>��ǩ����</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<?=$loadeditorjs?>
<script>
function on()
{
var f=document.add
f.HTML.value=f.bqsay.value;
}
function bs(){
var f=document.add
f.bqsay.value=f.HTML.value;
}
function br(){
if(!confirm("�Ƿ�λ��")){return false;}
document.add.title.select()
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form action="../ecmstemp.php" method="post" name="add" id="add">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">����ģ���ǩ 
        <input name="add[bqid]" type="hidden" id="add[bqid]" value="<?=$bqid?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="add[cid]" type="hidden" id="add[cid]" value="<?=$cid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="21%" height="25">��ǩ����</td>
      <td width="79%" height="25"><input name="add[bqname]" type="text" id="add[bqname]" value="<?=$r[bqname]?>" size="38">
        <font color="#666666">(�磢����������Ϣ��ǩ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ǩ���ţ�</td>
      <td height="25"><input name="add[bq]" type="text" id="add[bq]" value="<?=$r[bq]?>" size="38">
        <font color="#666666">(�磺[ad]����[/ad]�������Ϊ��ad��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�������</td>
      <td height="25"><select name="add[classid]" id="add[classid]">
          <option value="0">���������κ����</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit3" value="�������" onclick="window.open('BqClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��������</td>
      <td height="25"><input name="add[funname]" type="text" id="add[funname]" value="<?=$r[funname]?>" size="38"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <p>ϵͳ��ǩ��(�����e/class/t_functions.php�ļ��ĺ�����)<br>
          �û��Զ����ǩ��(�����e/class/userfun.php�ļ��ĺ������������������ԣ�<strong><font color="#FF0000">user_</font></strong>����ͷ)</p></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ǩ��ʽ��</td>
      <td height="25"><input name="add[bqgs]" type="text" id="add[bqgs]" value="<?=stripSlashes($r[bqgs])?>" size="80"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25">�磺<font color="#FF0000">[phomenews]��ĿID/ר��ID,��ʾ����,�����ȡ��,�Ƿ���ʾʱ��,��������[/phomenews]</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">��ǩ˵����</td>
      <td height="25"> 
        <?=ECMS_ShowEditorVar('bqsay',stripSlashes($r[bqsay]),'Default','../ecmseditor/infoeditor/')?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�Ƿ�����ǩ��</td>
      <td height="25"><input type="radio" name="add[isclose]" value="0"<?=$r[isclose]==0?' checked':''?>>
        �� 
        <input type="radio" name="add[isclose]" value="1"<?=$r[isclose]==1?' checked':''?>>
        �� <font color="#666666">�������Ż���ģ������Ч��</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">����</td>
      <td height="25"><input name="add[myorder]" type="text" id="add[myorder]" value="<?=$r[myorder]?>" size="38">
        <font color="#666666">(ֵԽ��Խǰ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>