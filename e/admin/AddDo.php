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
CheckLevel($logininid,$loginin,$classid,"do");
$enews=ehtmlspecialchars($_GET['enews']);
$url="<a href=ListDo.php".$ecms_hashur['whehref'].">����ˢ������</a>&nbsp;>&nbsp;���Ӷ�ʱˢ������";
$cdoing=(int)$_GET['cdoing'];
$cname='';
$class='';
$r[dotime]=30;
$r[isopen]=1;
//�޸�
if($enews=="EditDo")
{
	$doid=(int)$_GET['doid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsdo where doid='$doid'");
	$url="<a href=ListDo.php".$ecms_hashur['whehref'].">����ˢ������</a>&nbsp;>&nbsp;�޸Ķ�ʱˢ������";
	if($cdoing&&$cdoing<>$r['doing'])
	{
		$r[classid]='';
	}
}
//��Ŀ
if($r['doing']==1||$cdoing==1)
{
	$cname='��Ŀ';
	$fcfile="../data/fc/ListEnews.php";
	$fcjsfile="../data/fc/cmsclass.js";
	if(file_exists($fcjsfile)&&file_exists($fcfile))
	{
		$class=GetFcfiletext($fcjsfile);
		$acr=explode(",",$r[classid]);
		$count=count($acr);
		for($i=1;$i<$count-1;$i++)
		{
			$class=str_replace("<option value='$acr[$i]'","<option value='$acr[$i]' selected",$class);
		}
	}
	else
	{
		$class=ShowClass_AddClass(str_replace(',','|',$r[classid]),"n",0,"|-",0,3);
	}
}
elseif($r['doing']==2||$cdoing==2)//ר��
{
	$cname='ר��';
	$ztsql=$empire->query("select ztid,ztname from {$dbtbpre}enewszt order by ztid");
	while($ztr=$empire->fetch($ztsql))
	{
		$selected=strstr($r[classid],','.$ztr[ztid].',')?' selected':'';
		$class.="<option value='$ztr[ztid]'".$selected.">$ztr[ztname]</option>";
	}
}
elseif($r['doing']==3||$cdoing==3)//�Զ����б�
{
	$cname='�б�';
	$ulsql=$empire->query("select listid,listname from {$dbtbpre}enewsuserlist order by listid");
	while($ulr=$empire->fetch($ulsql))
	{
		$selected=strstr($r[classid],','.$ulr[listid].',')?' selected':'';
		$class.="<option value='$ulr[listid]'".$selected.">$ulr[listname]</option>";
	}
}
elseif($r['doing']==4||$cdoing==4)//�Զ���ҳ��
{
	$cname='ҳ��';
	$upsql=$empire->query("select id,title from {$dbtbpre}enewspage order by id");
	while($upr=$empire->fetch($upsql))
	{
		$selected=strstr($r[classid],','.$upr[id].',')?' selected':'';
		$class.="<option value='$upr[id]'".$selected.">$upr[title]</option>";
	}
}
elseif($r['doing']==5||$cdoing==5)//�Զ���JS
{
	$cname='JS';
	$jssql=$empire->query("select jsid,jsname from {$dbtbpre}enewsuserjs order by jsid");
	while($jsr=$empire->fetch($jssql))
	{
		$selected=strstr($r[classid],','.$jsr[jsid].',')?' selected':'';
		$class.="<option value='$jsr[jsid]'".$selected.">$jsr[jsname]</option>";
	}
}
elseif($r['doing']==6||$cdoing==6)//�������ҳ��
{
	$cname='�������';
	$infotypesql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype order by typeid");
	while($infotyper=$empire->fetch($infotypesql))
	{
		$selected=strstr($r[classid],','.$infotyper[typeid].',')?' selected':'';
		$class.="<option value='$infotyper[typeid]'".$selected.">$infotyper[tname]</option>";
	}
}
if($cdoing)
{
	$r['doing']=$cdoing;
}
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��ʱˢ������</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
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
    <td height="25">λ�ã�<?=$url?></td>
  </tr>
</table>

<form name="form1" method="post" action="ListDo.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2">���Ӷ�ʱˢ������ 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="doid" type="hidden" value="<?=$doid?>"></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">�������ͣ�</td>
      <td height="25"> <select name="doing" size="8" style="width:270" onchange="self.location.href='AddDo.php?<?=$ecms_hashur['ehref']?>&enews=<?=$enews?>&doid=<?=$doid?>&cdoing='+this.options[this.selectedIndex].value;">
          <option value="0"<?=$r[doing]==0?' selected':''?>>ˢ����ҳ</option>
          <option value="1"<?=$r[doing]==1?' selected':''?>>ˢ����Ŀҳ��</option>
		  <option value="6"<?=$r[doing]==6?' selected':''?>>ˢ�±������ҳ��</option>
		  <option value="2"<?=$r[doing]==2?' selected':''?>>ˢ��ר��ҳ��</option>
		  <option value="3"<?=$r[doing]==3?' selected':''?>>ˢ���Զ����б�</option>
		  <option value="4"<?=$r[doing]==4?' selected':''?>>ˢ���Զ���ҳ��</option>
		  <option value="5"<?=$r[doing]==5?' selected':''?>>ˢ���Զ���JS</option>
        </select>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="22%" height="25">��������</td>
      <td width="78%" height="25"><input name="doname" type="text" value="<?=$r[doname]?>" size="38">
        <font color="#666666">(������ҳ��ʱˢ��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">����״̬��</td>
      <td height="25"><input type="radio" name="isopen" value="1"<?=$r[isopen]==1?' checked':''?>>
        ����
        <input type="radio" name="isopen" value="0"<?=$r[isopen]==0?' checked':''?>>
        �ر�</td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td height="25">ִ��ʱ������</td>
      <td height="25"><input name="dotime" type="text" value="<?=$r[dotime]?>" size="38">
        ����<font color="#666666">(С��5����ϵͳ����Ϊ5����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><p>ѡ��<?=$cname?>��<br>
          <br>
          <br>
          <font color="#666666">(��ҳˢ�´���ʧЧ��<br>
          ��ͬʱѡ������<br>
          ˵����ѡ��Խ��ռ����ԴԽ��.</font><font color="#666666">)</font></p>
        </td>
      <td height="25"><select name="classid[]" size="16" multiple style="width:270" id="classidselect">
          <?=$class?>
        </select>
        [<a href="#empirecms" onclick="selectalls(0,'classidselect')">ȫ��ȡ��</a>]</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
</body>
</html>
