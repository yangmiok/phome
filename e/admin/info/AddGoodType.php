<?php
define('EmpireCMSAdmin','1');
require('../../class/connect.php');
require('../../class/db_sql.php');
require('../../class/functions.php');
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
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"class");
$ttype=(int)$_GET['ttype'];
$ttypetitle=$ttype==0?'�Ƽ�':'ͷ��';
$enews=RepPostStr($_GET['enews'],1);
$url="<a href='ListGoodType.php?ttype=".$ttype.$ecms_hashur['ehref']."'>����".$ttypetitle."����</a>&nbsp;>&nbsp;����".$ttypetitle."����";
$postword="����".$ttypetitle."����";
$docopy=ehtmlspecialchars($_GET['docopy']);
//��ʹ������
$tid=0;
$r[myorder]=0;
$r[levelid]=1;
$r[showall]=0;
$ecmsfirstpost=1;
//����
if($docopy)
{
	$tid=(int)$_GET['tid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsgoodtype where tid='$tid'");
	$url="<a href='ListGoodType.php?ttype=".$ttype.$ecms_hashur['ehref']."'>����".$ttypetitle."����</a>&nbsp;>&nbsp;����".$ttypetitle."����".$r['tname'];
	$r['tname'].='(1)';
}
//�޸�
if($enews=="EditGoodType")
{
	$ecmsfirstpost=0;
	$tid=(int)$_GET['tid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsgoodtype where tid='$tid'");
	$url="<a href='ListGoodType.php?ttype=".$ttype.$ecms_hashur['ehref']."'>����".$ttypetitle."����</a>&nbsp;>&nbsp;�޸�".$ttypetitle."����".$r['tname'];
	$postword="�޸�".$ttypetitle."����";
}
if($ecmsfirstpost==1)
{
	$maxr=$empire->fetch1("select levelid from {$dbtbpre}enewsgoodtype where ttype='$ttype' order by levelid desc limit 1");
	$r['levelid']=$maxr['levelid']+1;
}
//�û���
$group='';
$groupsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsgroup order by groupid");
while($groupr=$empire->fetch($groupsql))
{
	$select='';
	if(strstr($r[groupid],','.$groupr[groupid].','))
	{
		$select=' selected';
	}
	$group.="<option value='".$groupr[groupid]."'".$select.">".$groupr[groupname]."</option>";
}
//��ǰʹ�õ�ģ����
$thegid=GetDoTempGid();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$ttypetitle?>����</title>
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
    <td>λ�ã� 
      <?=$url?>
    </td>
  </tr>
</table>
<br>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListGoodType.php">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input type=hidden name=enews value="<?=$enews?>"> <input name="tid" type="hidden" id="tid" value="<?=$tid?>">
        <input name="ttype" type="hidden" id="ttype" value="<?=$ttype?>"></td>
    </tr>
    
    <tr>
      <td height="25" bgcolor="#FFFFFF"><?=$ttypetitle?>����</td>
      <td bgcolor="#FFFFFF"><input name="levelid" type="text" id="levelid" value="<?=$r[levelid]?>" size="38">
        <font color="#666666">(��1~255֮������)</font></td>
    </tr>
    <tr> 
      <td width="24%" height="25" bgcolor="#FFFFFF">��������</td>
      <td width="76%" bgcolor="#FFFFFF"> <input name="tname" type="text" id="tname" value="<?=$r[tname]?>" size="38"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">����</td>
      <td bgcolor="#FFFFFF"><input name="myorder" type="text" id="myorder" value="<?=$r[myorder]?>" size="38"> 
        <font color="#666666"> (ֵԽ����ʾԽǰ��)</font></td>
    </tr>
    <tr>
      <td height="25" valign="top" bgcolor="#FFFFFF">��ѡ����û���<br>
        <br>
          <font color="#666666">(��ѡΪ���ޣ�<br>
          ѡ������CTRL/SHIFT)</font></td>
      <td bgcolor="#FFFFFF"><select name="groupid[]" size="8" multiple id="groupidselect" style="width:180">
        <?=$group?>
            </select>
[<a href="#empirecms" onclick="selectalls(0,'groupidselect')">ȫ��ȡ��</a>]</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">�ڹ���������Ϣҳ��ʾ</td>
      <td bgcolor="#FFFFFF"><input type="radio" name="showall" value="0"<?=$r['showall']==0?' checked':''?>>
        ��
          <input type="radio" name="showall" value="1"<?=$r['showall']==1?' checked':''?>>
        ��</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">ֻ����Щ�ռ���Ŀ��ʾ</td>
      <td bgcolor="#FFFFFF"><input name="showcid" type="text" id="showcid" value="<?=substr($r['showcid'],1,-1)?>" size="38">
      <input type="button" name="Submit622232" value="������Ŀ" onclick="window.open('../ListClass.php<?=$ecms_hashur['whehref']?>');">
      <font color="#666666">(�����ĿID�ð�Ƕ��š�,������)</font></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">������Щ�ռ���Ŀ��ʾ</td>
      <td bgcolor="#FFFFFF"><input name="hiddencid" type="text" id="hiddencid" value="<?=substr($r['hiddencid'],1,-1)?>" size="38">
      <font color="#666666">(��д�ռ���ĿID�������ĿID�ð�Ƕ��š�,������)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> <div align="center"></div></td>
      <td bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="�ύ"> &nbsp;&nbsp; 
        <input type="reset" name="Submit2" value="����"> </td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
db_close();
$empire=null;
?>