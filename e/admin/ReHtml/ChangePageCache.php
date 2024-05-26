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

//�������¶�̬ҳ����
function ChangePageCache($add,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"changedata");
	if(empty($public_r['ctimeopen']))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$dopage=(int)$add['dopage'];
	if(!$dopage)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$chall=(int)$add['chall'];
	$tid=(int)$add['tid'];
	$classid=$add['classid'];
	$ttid=$add['ttid'];
	$from=$add['from'];
	$time=time();
	if($dopage==2)//��Ŀ
	{
		if($chall)
		{
			$cids=eArrayReturnInids($classid);
			if($cids)
			{
				$empire->query("update {$dbtbpre}enewsclass set fclast='$time' where classid in (".$cids.")");
			}
		}
		else
		{
			$empire->query("update {$dbtbpre}enewsclass set fclast='$time'");
		}
	}
	elseif($dopage==3)//����
	{
		if(!$tid)
		{
			printerror("ErrorUrl","history.go(-1)");
		}
		$tbr=$empire->fetch1("select tid,tbname from {$dbtbpre}enewstable where tid='$tid' limit 1");
		if(!$tbr['tbname'])
		{
			printerror("ErrorUrl","history.go(-1)");
		}
		$empire->query("update {$dbtbpre}ecms_".$tbr['tbname']." set lastdotime='$time'");
	}
	elseif($dopage==4)//�������
	{
		if($chall)
		{
			$ttids=eArrayReturnInids($ttid);
			if($ttids)
			{
				$empire->query("update {$dbtbpre}enewsinfotype set fclast='$time' where typeid in (".$ttids.")");
			}
		}
		else
		{
			$empire->query("update {$dbtbpre}enewsinfotype set fclast='$time'");
		}
	}
	elseif($dopage==5)//TAGS
	{
		$empire->query("update {$dbtbpre}enewstags set fclast='$time'");
	}
	else//��ҳ
	{
		$empire->query("update {$dbtbpre}enewspublic_fc set fclastindex='$time' limit 1");
	}
	insert_dolog("");//������־
	printerror("ChangePageCacheSuccess",$from);
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
if($enews=="ChangePageCache")//�������»���
{
	ChangePageCache($_POST,$logininid,$loginin);
}

$dopage=(int)$_GET['dopage'];

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
	$selecttable.="<option value='".$tr[tid]."'>".$tr[tname]."</option>";
}
//�������
$tts='';
$infotypesql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype order by typeid");
while($infotyper=$empire->fetch($infotypesql))
{
	$tts.="<option value='$infotyper[typeid]'".$selected.">$infotyper[tname]</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���¶�̬ҳ�滺��</title>
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
    <td width="39%" height="25">λ�ã�<a href="ChangePageCache.php<?=$ecms_hashur['whehref']?>">�������¶�̬ҳ�滺��</a></td>
    <td width="61%"><div align="right" class="emenubutton">
      <input type="button" name="Submit52" value="���ݸ�������" onclick="self.location.href='ChangeData.php<?=$ecms_hashur['whehref']?>';">
	  &nbsp;&nbsp;
      <input type="button" name="Submit522" value="������Ϣҳ��ַ" onclick="self.location.href='ReInfoUrl.php<?=$ecms_hashur['whehref']?>';">
	  &nbsp;&nbsp;
      <input type="button" name="Submit52" value="��������" onclick="self.location.href='DoUpdateData.php<?=$ecms_hashur['whehref']?>';">
    </div></td>
  </tr>
</table>
<form action="ChangePageCache.php" method="post" name="form1" target="_blank" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="ChangePageCache">
  <?=$ecms_hashur['form']?>
    <input name="from" type="hidden" id="from" value="ChangePageCache.php<?=$ecms_hashur['whehref']?>">
    <tr class="header"> 
      <td height="25"> <div align="center">�������¶�̬ҳ�滺��</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"> 
          <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
            <tr>
              <td width="23%" height="25">���»����ҳ�棺</td>
              <td width="77%" height="25"><select name="dopage" id="dopage" onchange="self.location.href='ChangePageCache.php?<?=$ecms_hashur['ehref']?>&dopage='+this.options[this.selectedIndex].value;">
                <option value="1"<?=$dopage==1?' selected':''?>>��ҳ</option>
                <option value="2"<?=$dopage==2?' selected':''?>>��Ŀҳ</option>
                <option value="3"<?=$dopage==3?' selected':''?>>����ҳ</option>
                <option value="4"<?=$dopage==4?' selected':''?>>�������ҳ</option>
                <option value="5"<?=$dopage==5?' selected':''?>>TAGSҳ</option>
              </select>              </td>
            </tr>
			<?php
			if($dopage==2||$dopage==4)
			{
			?>
            <tr>
              <td height="25">ѡ����»��淶Χ��</td>
              <td height="25"><input name="chall" type="radio" value="0" checked>�������л���
                <input type="radio" name="chall" value="1">������ѡ�����»���</td>
            </tr>
			<?php
			}
			?>
			<?php
			if($dopage==3)
			{
			?>
            <tr> 
              <td height="25">���ݱ�</td>
              <td height="25"> <select name="tid" id="tid">
                  <option value=''>------ ѡ�����ݱ� ------</option>
                  <?=$selecttable?>
                </select></td>
            </tr>
			<?php
			}
			if($dopage==2)
			{
			?>
            <tr> 
              <td height="25" valign="top">��Ŀ��<br>
			  <br>
			  <br>
			  <br>
			  <br>
			  <font color="#999999">(�����CTRL/SHIFT)</font></td>
              <td height="25"><select name="classid[]" size="18" multiple id="classid[]" style="width:180">
                  <?=$class?>
                </select></td>
            </tr>
			<?php
			}
			if($dopage==4)
			{
			?>
            <tr>
              <td height="25" valign="top">������ࣺ<br>
                <br>
                <br>
                <br>
				<br>
				<br>
                <font color="#999999">(�����CTRL/SHIFT)</font></td>
              <td height="25"><select name="ttid[]" size="18" multiple id="ttid[]" style="width:180">
			  <?=$tts?>
              </select>              </td>
            </tr>
			<?php
			}
			?>
            <tr> 
              <td height="25">&nbsp;</td>
              <td height="25">
			  <?php
			  if(empty($public_r['ctimeopen']))
			  {
			  ?>
					��̬ҳ�滺��δ���ã�����ʹ�ô˸��£�
			  <?php
			  }
			  else
			  {
			  ?>
			  <input type="submit" name="Submit62" value="��ʼ���»���"> 
			  &nbsp;
                <input type="reset" name="Submit72" value="����"> 
                <input name="enews" type="hidden" value="ChangePageCache">
			  <?php
			  }
			  ?>
              </td>
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
