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
CheckLevel($logininid,$loginin,$classid,"precode");
$enews=ehtmlspecialchars($_GET['enews']);
$time=(int)$_GET['time'];
$endtime='';
$r[precode]=strtoupper(make_password(20));
$classid='';
$r[musttotal]=0;
$url="<a href=ListPrecode.php".$ecms_hashur['whehref'].">�����Ż���</a> &gt; �����Ż���";
if($enews=="EditPrecode")
{
	$id=(int)$_GET['id'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsshop_precode where id='$id' limit 1");
	$url="<a href=ListPrecode.php".$ecms_hashur['whehref'].">�����Ż���</a> &gt; �޸��Ż���";
	$endtime=$r['endtime']?date('Y-m-d',$r['endtime']):'';
	$classid=substr($r['classid'],1,strlen($r['classid'])-2);
}
//��Ա��
$membergroup='';
$line=5;//һ����ʾ���
$i=0;
$mgsql=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($level_r=$empire->fetch($mgsql))
{
	$i++;
	$br='';
	if($i%$line==0)
	{
		$br='<br>';
	}
	if(strstr($r['groupid'],','.$level_r['groupid'].','))
	{$checked=" checked";}
	else
	{$checked="";}
	$membergroup.="<input type='checkbox' name='groupid[]' value='$level_r[groupid]'".$checked.">".$level_r[groupname]."&nbsp;".$br;
}
$href="AddPrecode.php?enews=$enews&time=$time&id=$id".$ecms_hashur['ehref'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�����Ż���</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListPrecode.php" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25" colspan="2"><div align="center">�����Ż��� 
          <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
		  <input name="time" type="hidden" id="time" value="<?=$time?>">
          <input name="id" type="hidden" id="id" value="<?=$id?>">
      </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="17%" height="25">�Ż�������(*)��</td>
      <td width="83%" height="25"><input name="prename" type="text" id="prename" value="<?=$r[prename]?>" size="42"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�Ż���(*)��</td>
      <td height="25"><input name="precode" type="text" id="precode" value="<?=$r[precode]?>" size="42">
        <input type="button" name="Submit3" value="����Ż���" onclick="javascript:self.location.href='<?=$href?>'">
        <font color="#666666">(&lt;36λ)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�Ż����ͣ�</td>
      <td height="25"><select name="pretype" id="pretype">
        <option value="0"<?=$r['pretype']==0?' selected':''?>>�����</option>
        <option value="1"<?=$r['pretype']==1?' selected':''?>>��Ʒ�ٷֱ�</option>
      </select>
      <font color="#666666">�����������������-�Żݽ�����Ʒ�ٷֱȡ�������Ʒ������ۣ�</font>      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">�Żݽ��(*)��</td>
      <td height="25"><input name="premoney" type="text" id="premoney" value="<?=$r[premoney]?>" size="42">
        <font color="#666666">(�������ʱ�����λ��Ԫ������Ʒ�ٷֱ�ʱ��ٷֱȣ���λ��%)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">����ʱ�䣺</td>
      <td height="25"><input name="endtime" type="text" id="endtime" value="<?=$endtime?>" size="42" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
        <font color="#666666">(��Ϊ������)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�Ż����ظ�ʹ�ã�</td>
      <td height="25"><input type="radio" name="reuse" value="0"<?=$r['reuse']==0?' checked':''?>>
      һ����ʹ��
      <input type="radio" name="reuse" value="1"<?=$r['reuse']==1?' checked':''?>>
      �����ظ�ʹ��</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">&nbsp;</td>
      <td height="25">�����ظ�ʹ�ô�����
      <input name="usenum" type="text" id="usenum" value="<?=$r[usenum]?>"><?=$r[haveusenum]?'[��ʹ�ã�'.$r[haveusenum].']':''?>
	  <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">�����ٽ���ʹ�ã�</td>
      <td height="25"><input name="musttotal" type="text" id="musttotal" value="<?=$r[musttotal]?>" size="42">
        Ԫ <font color="#666666">(0Ϊ����)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ʹ�õĻ�Ա�飺<br>
        <font color="#666666">(��ѡΪ����)</font></td>
      <td height="25"><?=$membergroup?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">��ʹ�õ���Ŀ��Ʒ��</td>
      <td height="25"><input name="classid" type="text" id="classid" value="<?=$classid?>" size="42">
        <font color="#666666">(��Ϊ���ޣ�Ҫ��д�ռ���ĿID�����ID���ð�Ƕ��Ÿ�����,��)</font></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <input type="submit" name="Submit" value="�ύ">
          &nbsp; 
          <input type="reset" name="Submit2" value="����">
          &nbsp;</div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>