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
//��Ŀ
$fcfile="../../data/fc/ListEnews.php";
$class="<script src=../../data/fc/cmsclass.js></script>";
if(!file_exists($fcfile))
{$class=ShowClass_AddClass("",0,0,"|-",0,0);}
//ˢ�±�
$retable="";
$selecttable="";
$cleartable='';
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
	$cleartable.="<option value='".$tr[tid]."'>".$tr[tname]."</option>";
}
//ר��
$ztclass="";
$ztsql=$empire->query("select ztid,ztname from {$dbtbpre}enewszt order by ztid desc");
while($ztr=$empire->fetch($ztsql))
{
	$ztclass.="<option value='".$ztr['ztid']."'>".$ztr['ztname']."</option>";
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
<title>��������</title>
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
    <td width="12%" height="25">λ�ã�<a href="DoUpdateData.php<?=$ecms_hashur['whehref']?>">��������</a></td>
    <td width="42%"><table width="460" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> <div align="center">[<a href="#IfTotalPlNum">����������Ϣ������</a>]</div></td>
          <td> <div align="center">[<a href="#IfOtherInfo">���������������</a>]</div></td>
          <td><div align="center">[<a href="#IfClearBreakInfo">���������Ϣ</a>]</div></td>
        </tr>
    </table></td>
    <td width="46%"><div align="right" class="emenubutton">
      <input type="button" name="Submit52" value="���ݸ�������" onclick="self.location.href='ChangeData.php<?=$ecms_hashur['whehref']?>';">
      &nbsp;&nbsp;
      <input type="button" name="Submit522" value="������Ϣҳ��ַ" onclick="self.location.href='ReInfoUrl.php<?=$ecms_hashur['whehref']?>';">
	  &nbsp;&nbsp;
      <input type="button" name="Submit522" value="���¶�̬ҳ����" onclick="self.location.href='ChangePageCache.php<?=$ecms_hashur['whehref']?>';">
    </div></td>
  </tr>
</table>
<form action="../ecmspl.php" method="get" name="form1" target="_blank" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=IfTotalPlNum>
  <?=$ecms_hashur['form']?>
    <input name="from" type="hidden" id="from" value="ReHtml/DoUpdateData.php<?=$ecms_hashur['whehref']?>">
    <tr class="header"> 
      <td height="25"> <div align="center">����������Ϣ������</div></td>
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
              <td height="25">ָ���̶���ϢID��</td>
              <td height="25"><input name="doids" type="text" id="doids" size="50">
                <font color="#666666">�����ID���ð�Ƕ��š�,��������</font></td>
            </tr>
            <tr> 
              <td height="25">&nbsp;</td>
              <td height="25"><input type="submit" name="Submit62" value="��ʼ����"> 
                <input type="reset" name="Submit72" value="����"> <input name="enews" type="hidden" value="UpdateAllInfoPlnum">              </td>
            </tr>
            <tr> 
              <td height="25" colspan="2"><font color="#666666">˵��������Ϣ�������������ʵ������������ʱʹ�á�</font></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<form action="../ecmscom.php" method="get" name="form1" target="_blank" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id=IfOtherInfo>
  <?=$ecms_hashur['form']?>
    <input name="from" type="hidden" id="from" value="ReHtml/DoUpdateData.php<?=$ecms_hashur['whehref']?>">
    <tr class="header"> 
      <td height="25"> <div align="center">���������������</div></td>
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
                <input type="reset" name="Submit72" value="����"> <input name="enews" type="hidden" value="ChangeInfoOtherLink"> 
              </td>
            </tr>
            <tr> 
              <td height="25" colspan="2"><font color="#666666">�������ѣ��˹��ܱȽϺ���Դ���Ǳ�Ҫʱ�����á�</font></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form>
<form action="../ecmscom.php" method="POST" name="form1" onsubmit="return confirm('ȷ��Ҫ����?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" id="IfClearBreakInfo">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"> <div align="center">���������Ϣ</div></td>
    </tr>
    <tr> 
      <td width="20%" height="25" bgcolor="#FFFFFF">ѡ��Ҫ��������ݱ�</td>
      <td width="80%" bgcolor="#FFFFFF"><select name="tid" id="tid">
          <option value=''>------ ѡ�����ݱ� ------</option>
          <?=$cleartable?>
        </select>
        *</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"><input type="submit" name="Submit6" value="��������"> 
        <input name="enews" type="hidden" id="enews2" value="ClearBreakInfo"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25"><font color="#666666">˵��: ��������Ϣ����ҳʱ��ʾ���´���ʱʹ�ñ����������������Ϣ��<br>
      ��������ҳ��ʾ��Table '*.phome_ecms_' doesn't exist......update ***_ecms_ set havehtml=1   where id='' limit 1��ʱʹ�á�</font></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
</p>
</body>
</html>
<?
db_close();
$empire=null;
?>
