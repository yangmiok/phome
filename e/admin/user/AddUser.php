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
CheckLevel($logininid,$loginin,$classid,"user");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListUser.php".$ecms_hashur['whehref'].">�����û�</a>&nbsp;>�����û�";
if($enews=="EditUser")
{
	$userid=(int)$_GET['userid'];
	$r=$empire->fetch1("select username,adminclass,groupid,checked,styleid,filelevel,truename,email,classid,wname,tel,wxno,qq from {$dbtbpre}enewsuser where userid='$userid'");
	$addur=$empire->fetch1("select equestion,openip from {$dbtbpre}enewsuseradd where userid='$userid'");
	$url="<a href=ListUser.php".$ecms_hashur['whehref'].">�����û�</a>&nbsp;>�޸��û���<b>".$r[username]."</b>";
	if($r[checked])
	{$checked=" checked";}
}
//-----------�û���
$sql=$empire->query("select groupid,groupname from {$dbtbpre}enewsgroup order by groupid desc");
while($gr=$empire->fetch($sql))
{
	if($r[groupid]==$gr[groupid])
	{$select=" selected";}
	else
	{$select="";}
	$group.="<option value=".$gr[groupid].$select.">".$gr[groupname]."</option>";
}
//-----------��̨��ʽ
$stylesql=$empire->query("select styleid,stylename,path from {$dbtbpre}enewsadminstyle order by styleid");
$style="";
while($styler=$empire->fetch($stylesql))
{
	if($r[styleid]==$styler[styleid])
	{$sselect=" selected";}
	else
	{$sselect="";}
	$style.="<option value=".$styler[styleid].$sselect.">".$styler[stylename]."</option>";
}
//-----------����
$userclasssql=$empire->query("select classid,classname from {$dbtbpre}enewsuserclass order by classid");
$userclass='';
while($ucr=$empire->fetch($userclasssql))
{
	if($r[classid]==$ucr[classid])
	{$select=" selected";}
	else
	{$select="";}
	$userclass.="<option value='$ucr[classid]'".$select.">".$ucr[classname]."</option>";
}
//--------------------��������Ŀ
$fcfile="../../data/fc/ListEnews.php";
$fcjsfile="../../data/fc/cmsclass.js";
if(file_exists($fcjsfile)&&file_exists($fcfile))
{
	$class=GetFcfiletext($fcjsfile);
	$acr=explode("|",$r[adminclass]);
	$count=count($acr);
	for($i=1;$i<$count-1;$i++)
	{
		$class=str_replace("<option value='$acr[$i]'","<option value='$acr[$i]' selected",$class);
	}
}
else
{
	$class=ShowClass_AddClass($r[adminclass],"n",0,"|-",0,3);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����û���</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function selectalls(doselect,formvar)
{  
	 var bool=doselect==1?true:false;
	 var selectform=document.getElementById(formvar);
	 for(var i=0;i<selectform.length;i++)
	 { 
		  selectform.all[i].selected=bool;
	 } 
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListUser.php" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">�����û� 
        <input name="userid" type="hidden" id="userid" value="<?=$userid?>"> <input name="oldusername" type="hidden" id="oldusername" value="<?=$r[username]?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="oldadminclass" type="hidden" id="oldadminclass" value="<?=$r[adminclass]?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="22%" height="25">�û�����</td>
      <td width="78%" height="25"><input name="username" type="text" id="username" value="<?=$r[username]?>" size="32">
        *</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�Ƿ��ֹ��</td>
      <td height="25"><input name="checked" type="checkbox" id="checked" value="1"<?=$checked?>>
        ��</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���룺</td>
      <td height="25"><input name="password" type="password" id="password" size="32">
        * <font color="#666666">(�����޸�������)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�ظ����룺</td>
      <td height="25"><input name="repassword" type="password" id="repassword" size="32">
        * <font color="#666666">(�����޸�������)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25"><font color="#666666">(˵������������6λ���ϣ����ִ�Сд�������벻�ܰ�����$ 
      &amp; * # &lt; &gt; ' &quot; / \ % ; �ո�)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ȫ���ʣ�</td>
      <td height="25"> <select name="equestion" id="equestion">
          <option value="0"<?=$addur[equestion]==0?' selected':''?>>�ް�ȫ����</option>
          <option value="1"<?=$addur[equestion]==1?' selected':''?>>ĸ�׵�����</option>
          <option value="2"<?=$addur[equestion]==2?' selected':''?>>үү������</option>
          <option value="3"<?=$addur[equestion]==3?' selected':''?>>���׳����ĳ���</option>
          <option value="4"<?=$addur[equestion]==4?' selected':''?>>������һλ��ʦ������</option>
          <option value="5"<?=$addur[equestion]==5?' selected':''?>>�����˼�������ͺ�</option>
          <option value="6"<?=$addur[equestion]==6?' selected':''?>>����ϲ���Ĳ͹�����</option>
          <option value="7"<?=$addur[equestion]==7?' selected':''?>>��ʻִ�յ������λ����</option>
        </select> <font color="#666666"> 
        <input name="oldequestion" type="hidden" id="oldequestion" value="<?=$addur[equestion]?>">
        (������ð�ȫ���ʣ���¼ʱ��������Ӧ����Ŀ���ܵ�¼)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��ȫ�ش�</td>
      <td height="25"><input name="eanswer" type="text" id="eanswer" size="32"> 
        <font color="#666666">(����޸Ĵ𰸣����ڴ������´𰸡����ִ�Сд)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">������</td>
      <td height="25"><input name="truename" type="text" id="truename" value="<?=$r[truename]?>" size="32"></td>
    </tr>
	<tr bgcolor="#FFFFFF">
      <td height="25">������</td>
      <td height="25"><input name="wname" type="text" id="wname" value="<?=$r[wname]?>" size="32">
        <font color="#666666">(��Ϣ������������Ա�����ô����ƣ�����Ϊ��ʾ������Ա��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">���䣺</td>
      <td height="25"><input name="email" type="text" id="email" value="<?=$r[email]?>" size="32"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�ֻ��ţ�</td>
      <td height="25"><input name="tel" type="text" id="tel" value="<?=$r[tel]?>" size="32"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">QQ���룺</td>
      <td height="25"><input name="qq" type="text" id="qq" value="<?=$r[qq]?>" size="32"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">΢�ţ�</td>
      <td height="25"><input name="wxno" type="text" id="wxno" value="<?=$r[wxno]?>" size="32"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�û���(*)��</td>
      <td height="25"><select name="groupid" id="groupid">
          <?=$group?>
        </select> <input type="button" name="Submit62223222" value="�����û���" onclick="window.open('ListGroup.php<?=$ecms_hashur['whehref']?>');">
        *</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�������ţ�</td>
      <td height="25"><select name="classid" id="classid">
          <option value="0">δ����</option>
          <?=$userclass?>
        </select> <input type="button" name="Submit622232222" value="������" onclick="window.open('UserClass.php<?=$ecms_hashur['whehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">��̨��ʽ(*)��</td>
      <td height="25"><select name="styleid" id="styleid">
          <?=$style?>
        </select> <input type="button" name="Submit6222322" value="�����̨��ʽ" onclick="window.open('../template/AdminStyle.php<?=$ecms_hashur['whehref']?>');">
        *</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td rowspan="2" valign="top"> <p><strong>�������Ŀ��Ϣ��</strong><br>
          <br>
          <input name="filelevel" type="checkbox" id="filelevel" value="1"<?=$r[filelevel]==1?' checked':''?>>
          Ӧ���ڸ���Ȩ��<br>
          <br>
          (���������ctrl��)</p></td>
      <td height="25" valign="top"> <select name="adminclass[]" size="12" multiple id="adminclassselect" style="width:270;">
          <?=$class?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'adminclassselect')">ȫ��ȡ��</a>]      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top"> ע�����<font color="#FF0000">ѡ����Ŀ��Ӧ��������Ŀ���������ѡ����Ŀ������ѡ��������Ŀ</font>)</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25"><strong>�����¼��̨�� IP �б�:</strong><br>
        ֻ�е�����Ա���ڱ��б��е� IP ��ַʱ�ſ��Ե�¼��̨���б�����ĵ�ַ���ʽ���Ϊ IP ����ֹ.ÿ�� IP һ�У��ȿ�����������ַ��Ҳ��ֻ���� 
        IP ��ͷ������ &quot;192.168.&quot;(��������) ��ƥ�� 192.168.0.0��192.168.255.255 ��Χ�ڵ����е�ַ������Ϊ����</td>
      <td height="25"><textarea name="openip" cols="50" rows="8" id="openip"><?=$addur[openip]?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><font color="#666666">˵������������6λ���ϣ����ִ�Сд�������벻�ܰ�����$ 
        &amp; * # &lt; &gt; ' &quot; / \ % ; �ո�</font></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>
