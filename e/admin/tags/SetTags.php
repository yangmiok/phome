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
CheckLevel($logininid,$loginin,$classid,"tags");
$r=$empire->fetch1("select opentags,tagstempid,usetags,chtags,tagslistnum from {$dbtbpre}enewspublic limit 1");
//ϵͳģ��
$usetags='';
$chtags='';
$i=0;
$modsql=$empire->query("select mid,mname from {$dbtbpre}enewsmod order by myorder,mid");
while($modr=$empire->fetch($modsql))
{
	$i++;
	if($i%4==0)
	{
		$br="<br>";
	}
	else
	{
		$br="";
	}
	$select='';
	if(strstr($r[usetags],','.$modr[mid].','))
	{
		$select=' checked';
	}
	$usetags.="<input type=checkbox name=umid[] value='$modr[mid]'".$select.">$modr[mname]&nbsp;&nbsp;".$br;
	$chselect='';
	if(strstr($r[chtags],','.$modr[mid].','))
	{
		$chselect=' checked';
	}
	$chtags.="<input type=checkbox name=cmid[] value='$modr[mid]'".$chselect.">$modr[mname]&nbsp;&nbsp;".$br;
}
//�б�ģ��
$listtemp_options='';
$msql=$empire->query("select mid,mname from {$dbtbpre}enewsmod order by myorder,mid");
while($mr=$empire->fetch($msql))
{
	$listtemp_options.="<option value=0 style='background:#99C4E3'>".$mr[mname]."</option>";
	$l_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewslisttemp")." where modid='$mr[mid]'");
	while($l_r=$empire->fetch($l_sql))
	{
		if($l_r[tempid]==$r[tagstempid])
		{$l_d=" selected";}
		else
		{$l_d="";}
		$listtemp_options.="<option value=".$l_r[tempid].$l_d."> |-".$l_r[tempname]."</option>";
	}
}
//��ǰʹ�õ�ģ����
$thegid=GetDoTempGid();
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>TAGS</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<a href="ListTags.php<?=$ecms_hashur['whehref']?>">����TAGS</a> &gt; ����TAGS</td>
  </tr>
</table>
<form name="form1" method="post" action="ListTags.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> ����TAGS 
        <input name="enews" type="hidden" id="enews" value="SetTags"> </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="18%" height="25">ǰ̨����TAGS:</td>
      <td width="82%" height="25"><input type="radio" name="opentags" value="1"<?=$r[opentags]==1?' checked':''?>>
        ���� 
        <input type="radio" name="opentags" value="0"<?=$r[opentags]==0?' checked':''?>>
        �ر�</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">Ĭ��ʹ�õ�ģ��:</td>
      <td height="25"><select name="tagstempid" id="tagstempid">
          <?=$listtemp_options?>
        </select> <input type="button" name="Submit62223" value="�����б�ģ��" onclick="window.open('../template/ListListtemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">ÿҳ��ʾ��Ϣ:</td>
      <td height="25"><input name="tagslistnum" type="text" id="tagslistnum" value="<?=$r[tagslistnum]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ʹ��TAGS��ϵͳģ��:</td>
      <td height="25">
        <?=$usetags?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">ֻ��ѡ��TAGS��ϵͳģ��:</td>
      <td height="25">
        <?=$chtags?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"> <input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>