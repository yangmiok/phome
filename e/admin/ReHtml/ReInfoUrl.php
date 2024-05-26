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
CheckLevel($logininid,$loginin,$classid,"changedata");

//����������Ϣҳ��ַ
function ReInfoUrl($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"changedata");
	$start=(int)$start;
	$tbname=RepPostVar($tbname);
	if(empty($tbname)||!eCheckTbname($tbname))
	{
		printerror("ErrorUrl","history.go(-1)");
    }
	$add1='';
	//����Ŀˢ��
	$classid=(int)$classid;
	if($classid)
	{
		if(empty($class_r[$classid][islast]))//����Ŀ
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//�ռ���Ŀ
		{
			$where="classid='$classid'";
		}
		$add1=" and (".$where.")";
    }
	//��IDˢ��
	if($retype)
	{
		$startid=(int)$startid;
		$endid=(int)$endid;
		if($endid)
		{
			$add1.=" and id>=$startid and id<=$endid";
	    }
    }
	else
	{
		$startday=RepPostVar($startday);
		$endday=RepPostVar($endday);
		if($startday&&$endday)
		{
			$add1.=" and truetime>=".to_time($startday." 00:00:00")." and truetime<=".to_time($endday." 23:59:59");
	    }
    }
	$b=0;
	$sql=$empire->query("select id,classid,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[delnewsnum]);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r[id];
		//���ر�
		$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
		$infor=$empire->fetch1("select newspath,filename,groupid,isurl,titleurl from ".$infotb." where id='$r[id]' limit 1");
		$infourl=GotoGetTitleUrl($r['classid'],$r['id'],$infor['newspath'],$infor['filename'],$infor['groupid'],$infor['isurl'],$infor['titleurl']);
		$empire->query("update ".$infotb." set titleurl='$infourl' where id='$r[id]' limit 1");
	}
	if(empty($b))
	{
	    insert_dolog("");//������־
		printerror("ReInfoUrlSuccess",$from);
	}
	echo $fun_r[OneReInfoUrlSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ReInfoUrl.php?enews=ReInfoUrl&tbname=$tbname&classid=$classid&start=$new_start&from=".urlencode($from)."&retype=$retype&startday=$startday&endday=$endday&startid=$startid&endid=$endid".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
	@set_time_limit(0);
	include('../../data/dbcache/class.php');
}
if($enews=="ReInfoUrl")//����������Ϣҳ��ַ
{
	$start=$_GET['start'];
	$classid=$_GET['classid'];
	$from=$_GET['from'];
	$retype=$_GET['retype'];
	$startday=$_GET['startday'];
	$endday=$_GET['endday'];
	$startid=$_GET['startid'];
	$endid=$_GET['endid'];
	$tbname=$_GET['tbname'];
	ReInfoUrl($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$logininid,$loginin);
}

//��Ŀ
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//ˢ�±�
$retable="";
$selecttable="";
$i=0;
$tsql=$empire->query("select tid,tbname,tname from {$dbtbpre}enewstable where intb=0 order by tid");
while($tr=$empire->fetch($tsql))
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
	$retable.="<input type=checkbox name=tbname[] value='$tr[tbname]' checked>$tr[tname]&nbsp;&nbsp;".$br;
	$selecttable.="<option value='".$tr[tbname]."'>".$tr[tname]."</option>";
}
//ѡ������
$todaydate=date("Y-m-d");
$todaytime=time();
$changeday="<select name=selectday onchange=\"document.reform.startday.value=this.value;document.reform.endday.value='".$todaydate."'\">
<option value='".$todaydate."'>--ѡ��--</option>
<option value='".$todaydate."'>����</option>
<option value='".ToChangeTime($todaytime,7)."'>һ��</option>
<option value='".ToChangeTime($todaytime,30)."'>һ��</option>
<option value='".ToChangeTime($todaytime,90)."'>����</option>
<option value='".ToChangeTime($todaytime,180)."'>����</option>
<option value='".ToChangeTime($todaytime,365)."'>һ��</option>
</select>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����������Ϣҳ��ַ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
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
    <td width="39%" height="25">λ�ã�<a href="ReInfoUrl.php<?=$ecms_hashur['whehref']?>">����������Ϣҳ��ַ</a></td>
    <td width="61%"><div align="right" class="emenubutton">
      <input type="button" name="Submit52" value="���ݸ�������" onclick="self.location.href='ChangeData.php<?=$ecms_hashur['whehref']?>';">
	  &nbsp;&nbsp;
      <input type="button" name="Submit52" value="��������" onclick="self.location.href='DoUpdateData.php<?=$ecms_hashur['whehref']?>';">
	  &nbsp;&nbsp;
      <input type="button" name="Submit522" value="���¶�̬ҳ�滺��" onclick="self.location.href='ChangePageCache.php<?=$ecms_hashur['whehref']?>';">
    </div></td>
  </tr>
</table>
<form action="ReInfoUrl.php" method="get" name="form1" target="_blank" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ReInfoUrl">
  <?=$ecms_hashur['form']?>
    <input name="from" type="hidden" id="from" value="ReInfoUrl.php<?=$ecms_hashur['whehref']?>">
    <tr class="header"> 
      <td height="25"> <div align="center">����������Ϣҳ��ַ</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr> 
              <td height="25">���ݱ�</td>
              <td height="25"> <select name="tbname" id="tbname">
                  <option value=''>------ ѡ�����ݱ� ------</option>
                  <?=$selecttable?>
                </select>
                (*) </td>
            </tr>
            <tr> 
              <td height="25">��Ŀ</td>
              <td height="25"><select name="classid">
                  <option value="0">������Ŀ</option>
                  <?=$class?>
                </select>
                <font color="#666666">(��ѡ����Ŀ����������������Ŀ)</font></td>
            </tr>
            <tr> 
              <td width="23%" height="25"> <input name="retype" type="radio" value="0" checked>
                ��ʱ����£�</td>
              <td width="77%" height="25">�� 
                <input name="startday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                �� 
                <input name="endday" type="text" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
                ֮�����Ϣ <font color="#666666">(�������������Ϣ)</font></td>
            </tr>
            <tr> 
              <td height="25"> <input name="retype" type="radio" value="1">
                ��ID���£�</td>
              <td height="25">�� 
                <input name="startid" type="text" value="0" size="6">
                �� 
                <input name="endid" type="text" value="0" size="6">
                ֮�����Ϣ <font color="#666666">(����ֵΪ0������������Ϣ)</font></td>
            </tr>
            <tr> 
              <td height="25">&nbsp;</td>
              <td height="25"><input type="submit" name="Submit62" value="��ʼ����"> 
                <input type="reset" name="Submit72" value="����"> 
                <input name="enews" type="hidden" value="ReInfoUrl"> 
              </td>
            </tr>
            <tr> 
              <td height="25" colspan="2"><font color="#666666">˵�������ı���ϢĿ¼��ʽʱ�����ô˹�����������������ҳ��ַ��</font></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
