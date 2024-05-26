<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../data/dbcache/class.php");
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
CheckLevel($logininid,$loginin,$classid,"cj");

//��ʾ���޼����[���ӽ��ʱ]
function ShowClass_AddInfoClass($obclassid,$bclassid,$exp,$enews=0){
	global $empire,$dbtbpre;
	if(empty($bclassid))
	{
		$bclassid=0;
		$exp="|-";
    }
	else
	{$exp="&nbsp;&nbsp;".$exp;}
	$sql=$empire->query("select classid,classname,bclassid from {$dbtbpre}enewsinfoclass where bclassid='$bclassid' order by classid");
	$returnstr="";
	while($r=$empire->fetch($sql))
	{
		if($r[classid]==$obclassid)
		{$select=" selected";}
		else
		{$select="";}
		$returnstr.="<option value=".$r[classid].$select.">".$exp.$r[classname]."</option>";
		$returnstr.=ShowClass_AddInfoClass($obclassid,$r[classid],$exp,$enews);
	}
	return $returnstr;
}

$enews=ehtmlspecialchars($_GET['enews']);
$r[newsclassid]=(int)$_GET['newsclassid'];
/*
if(empty($r[newsclassid])&&($enews=="AddInfoClass"||empty($enews)))
{
echo"<script>self.location.href='AddInfoC.php".$ecms_hashur['whehref']."';</script>";
exit();
}
*/
if($_GET['from'])
{
	$listclasslink="ListPageInfoClass.php";
}
else
{
	$listclasslink="ListInfoClass.php";
}

$docopy=ehtmlspecialchars($_GET['docopy']);
$url="�ɼ�&nbsp;>&nbsp;<a href=".$listclasslink.$ecms_hashur['whehref'].">����ڵ�</a>&nbsp;>&nbsp;���ӽڵ�";
//��ʹ������
$r[startday]=date("Y-m-d");
$r[endday]="2099-12-31";
$r[num]=0;
$r[renum]=2;
$r[relistnum]=1;
$r[insertnum]=10;
$r[keynum]=0;
$r[keeptime]=0;
$r[smalltextlen]=200;
$r[titlelen]=0;
$r['getfirstspicw']=$public_r['spicwidth'];
$r['getfirstspich']=$public_r['spicheight'];
$r['repf']=',title,newstext,';
$r['repadf']=',newstext,';
$r['loadkeeptime']=0;
$r['isnullf']=',newstext,';
$pagetype0="";
$pagetype1=" checked";
//���ƽ��
if($docopy)
{
	$classid=(int)$_GET['classid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//�ɼ��ڵ�
	if($r[newsclassid])
	{
		$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
		$r=TogTwoArray($r,$ra);
	}
	if(empty($r[pagetype]))
	{
		$pagetype0=" checked";
		$pagetype1="";
	}
	else
	{
		$pagetype0="";
		$pagetype1=" checked";
	}
	$url="�ɼ�&nbsp;>&nbsp;<a href=".$listclasslink.$ecms_hashur['whehref'].">����ڵ�</a>&nbsp;>&nbsp;���ƽڵ㣺".$r[classname];
	$r[classname].="(1)";
}
//�޸Ľڵ�
if($enews=="EditInfoClass")
{
	$classid=(int)$_GET['classid'];
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//�ɼ��ڵ�
	if($r[newsclassid])
	{
		$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
		$r=TogTwoArray($r,$ra);
	}
	if(empty($r[pagetype]))
	{
		$pagetype0=" checked";
		$pagetype1="";
	}
	else
	{
		$pagetype0="";
		$pagetype1=" checked";
	}
	$url="�ɼ�&nbsp;>&nbsp;<a href=".$listclasslink.$ecms_hashur['whehref'].">����ڵ�</a>&nbsp;>&nbsp;�޸Ľڵ�";
}
//ģ��
$modid=$class_r[$r[newsclassid]][modid];
$modr=$empire->fetch1("select enter from {$dbtbpre}enewsmod where mid='$modid'");
//��Ŀ
$options=ShowClass_AddClass("",$r[newsclassid],0,"|-",$class_r[$r[newsclassid]][modid],4);
if($r[retitlewriter])
{
	$retitlewriter=" checked";
}
if($r[copyimg])
{
	$copyimg=" checked";
}
if($r[copyflash])
{$copyflash=" checked";}
//�ڵ�
$infoclass=ShowClass_AddInfoClass($r[bclassid],0,"|-",0);

//�ɼ����ļ�
$cjfile="../data/html/cj".$class_r[$r[newsclassid]][modid].".php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>���ӽڵ�</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function AddRepAd(obj,val){
	var dh='';
	if(obj==1)
	{
		if(document.form1.pagerepad.value!='')
		{
			dh=',';
		}
		document.form1.pagerepad.value+=dh+val;
	}
	else
	{
		if(document.form1.repad.value!='')
		{
			dh=',';
		}
		document.form1.repad.value+=dh+val;
	}
}
</script>
<script type="text/javascript" src="ecmseditor/js/jstime/WdatePicker.js"></script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>λ�ã�<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListInfoClass.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="30%">������Ϣ</td>
      <td width="70%"><input type=hidden name=from value="<?=ehtmlspecialchars($_GET['from'])?>"> 
        <input name="enews" type="hidden" id="enews" value="<?=$enews?>"> <input name="add[classid]" type="hidden" id="add[classid]" value="<?=$classid?>"> 
        <input name="add[oldbclassid]" type="hidden" id="add[oldbclassid]" value="<?=$r[bclassid]?>"> 
        <input name="add[oldnewsclassid]" type="hidden" id="add[oldnewsclassid]" value="<?=$r[newsclassid]?>"></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">�ڵ����ƣ�</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[classname]" type="text" id="add[classname]" value="<?=$r[classname]?>" size=50> 
        <font color="#666666">(�磺���������ֵ�)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">���ڵ㣺</td>
      <td height="23" bgcolor="#FFFFFF"> <select name="bclassid" id="bclassid">
          <option value="0">�½����ڵ�</option>
          <?=$infoclass?>
        </select></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">�ɼ�ҳ���ַ��<br>
        <font color="#666666">(һ��Ϊһ���б�)<br>
        <br>
        <br>
        <input name="add[infourlispage]" type="checkbox" id="add[infourlispage]" value="1"<?=$r[infourlispage]?' checked':''?>>
        </font>�ɼ�ҳ��Ϊֱ������ҳ</td>
      <td height="23" bgcolor="#FFFFFF"> <textarea name="add[infourl]" cols="72" rows="10" id="add[infourl]"><?=stripSlashes($r[infourl])?></textarea></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">�ɼ�ҳ���ַ��ʽ����<br> <font color="#666666">(�˷�ʽ��ϵͳ�Զ�����ҳ���ַ)</font></td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td>��ַ�� 
              <input name="add[infourl1]" type="text" id="add[infourl1]2" size="42">
              (��ҳ������ 
              <input name="textfield" type="text" value="[page]" size="8">
              �滻)</td>
          </tr>
          <tr> 
            <td>ҳ��� 
              <input name="add[urlstart]" type="text" id="add[urlstart]4" value="1" size="6">
              �� 
              <input name="add[urlend]" type="text" id="add[urlend]3" value="1" size="6">
              ֮��,������� 
              <input name="add[urlbs]" type="text" id="add[urlbs]" value="1" size="6"> 
              <input name="add[urldx]" type="checkbox" id="add[urldx]" value="1">
              ���� 
              <input name="add[urlbl]" type="checkbox" id="add[urlbl]" value="1">
              ����</td>
          </tr>
          <tr> 
            <td><font color="#666666">(��:http://www.phome.net/index.php?page=[page])</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">����ҳ��ַǰ׺��</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[httpurl]" type="text" id="add[httpurl]" value="<?=$r[httpurl]?>" size="50"> 
        <br> <font color="#666666">(���ַǰ��û�����Ļ���ϵͳ����ϴ�ǰ׺)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">ͼƬ/FLASH��ַǰ׺(����)��</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[imgurl]" type="text" id="add[imgurl]" value="<?=$r[imgurl]?>" size="50"> 
        <font color="#666666">(ͼƬ��ַΪ��Ե�ַʱʹ��)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">�����Ŀ��</td>
      <td height="23" bgcolor="#FFFFFF"> <select name="newsclassid" id="newsclassid">
          <option value="0">ѡ����Ŀ</option>
          <?=$options?>
        </select> <input type="button" name="Submit622232" value="������Ŀ" onclick="window.open('ListClass.php<?=$ecms_hashur['whehref']?>');"> 
        <font color="#666666">(�籾�ڵ㲻�ǲɼ��ڵ㣬�벻ѡ)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">��ʼʱ�䣺</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[startday]" type="text" id="add[startday]" value="<?=$r[startday]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})"> 
        <font color="#666666">(��ʽ��2007-11-01)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">����ʱ�䣺</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[endday]" type="text" id="add[endday]" value="<?=$r[endday]?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})"> 
        <font color="#666666">(��ʽ��2007-11-01)</font></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">��ע��</td>
      <td height="23" bgcolor="#FFFFFF"> <textarea name="add[bz]" cols="72" rows="8" id="add[bz]"><?=ehtmlspecialchars(stripSlashes($r[bz]))?></textarea></td>
    </tr>
    <tr class="header"> 
      <td height="23" colspan="2">ѡ��</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">Ĭ����عؼ��֣�</td>
      <td height="23" bgcolor="#FFFFFF">��ȡ����ǰ 
        <input name="add[keynum]" type="text" id="add[keynum]" value="<?=$r[keynum]?>" size="6">
        ����</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"> <p>�ɼ���¼����</p></td>
      <td height="23" bgcolor="#FFFFFF">�ɼ�ǰ 
        <input name="add[num]" type="text" id="add[num]" value="<?=$r[num]?>" size="6">
        ����¼<font color="#666666">(&quot;0&quot;Ϊ���ޣ�ϵͳ���ͷ�ɵ�ҳ��β)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">Զ�̱���ͼƬ������(����)��</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[copyimg]" type="checkbox" id="add[copyimg]" value="1"<?=$copyimg?>>
        (���ʱ�Żᱣ��, 
        <input name="add[mark]" type="checkbox" id="add[mark]" value="1"<?=$r[mark]==1?' checked':''?>> 
        <a href="SetEnews.php<?=$ecms_hashur['whehref']?>" target="_blank">��ˮӡ</a>) </td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">Զ�̱���FLASH������(����)��</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[copyflash]" type="checkbox" id="add[copyflash]" value="1"<?=$copyflash?>>
        (���ʱ�Żᱣ��) </td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">����ͼƬ���ã�</td>
      <td height="23" bgcolor="#FFFFFF">ȡ�� 
        <input name="add[getfirstpic]" type="text" id="add[getfirstpic]" value="<?=$r[getfirstpic]?>" size="3">
        ��ͼƬΪ����ͼƬ( 
        <input name="add[getfirstspic]" type="checkbox" id="add[getfirstspic]" value="1"<?=$r[getfirstspic]==1?' checked':''?>>
        ��������ͼ:��� 
        <input name="add[getfirstspicw]" type="text" id="add[getfirstspicw]" value="<?=$r[getfirstspicw]?>" size="3">
        ���߶� 
        <input name="add[getfirstspich]" type="text" id="add[getfirstspich]" value="<?=$r[getfirstspich]?>" size="3">
        )</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">ÿ���б�ɼ�������</td>
      <td height="23" bgcolor="#FFFFFF">ÿ��ɼ� 
        <input name="add[relistnum]" type="text" id="add[relistnum]" value="<?=$r[relistnum]?>" size="6">
        ���б�ҳ<font color="#666666">(��ֹ�ɼ���ʱ) </font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">ÿ����Ϣ�ɼ�������</td>
      <td height="23" bgcolor="#FFFFFF">ÿ��ɼ� 
        <input name="add[renum]" type="text" id="add[renum]" value="<?=$r[renum]?>" size="6">
        ����Ϣҳ<font color="#666666">(��ֹ�ɼ���ʱ)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">ÿ���������</td>
      <td height="23" bgcolor="#FFFFFF">ÿ���� 
        <input name="add[insertnum]" type="text" id="add[insertnum]" value="<?=$r[insertnum]?>" size="6">
        ����¼<font color="#666666">(��ֹ��ⳬʱ) </font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">ÿ��ɼ�ʱ����</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[keeptime]" type="text" id="add[keeptime]" value="<?=$r[keeptime]?>" size="6">
        �� <font color="#666666">(0Ϊ�����ɼ�)</font></td>
    </tr>
    <tr>
      <td height="23" bgcolor="#FFFFFF">ÿ�����ʱ����</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[loadkeeptime]" type="text" id="add[loadkeeptime]" value="<?=$r[loadkeeptime]?>" size="6">
�� <font color="#666666">(0Ϊ�������)</font></td>
    </tr>
    <tr class="header"> 
      <td height="23" colspan="2">����ѡ��</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">ҳ�����ת��</td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellpadding="1" cellspacing="1">
          <?php
	  $trueenpagecode="<input type='radio' name='add[enpagecode]' value='0'".($r[enpagecode]==0?' checked':'').">��������";
	  if(empty($ecms_config['sets']['pagechar'])||$ecms_config['sets']['pagechar']=='gb2312')
	  {
	  ?>
          <tr> 
            <td height="22">
              <?=$trueenpagecode?>            </td>
            <td><input type="radio" name="add[enpagecode]" value="1"<?=$r[enpagecode]==1?' checked':''?>>
              UTF8-&gt;GB2312</td>
            <td> <input type="radio" name="add[enpagecode]" value="3"<?=$r[enpagecode]==3?' checked':''?>>
              BIG5-&gt;GB2312</td>
            <td><input type="radio" name="add[enpagecode]" value="5"<?=$r[enpagecode]==5?' checked':''?>>
              UNICODE-&gt;GB2312</td>
          </tr>
          <?php
		$trueenpagecode='';
		}
		if(empty($ecms_config['sets']['pagechar'])||$ecms_config['sets']['pagechar']=='big5')
		{
		?>
          <tr> 
            <td height="22">
              <?=$trueenpagecode?>            </td>
            <td> <input type="radio" name="add[enpagecode]" value="2"<?=$r[enpagecode]==2?' checked':''?>>
              UTF8-&gt;BIG5</td>
            <td> <input type="radio" name="add[enpagecode]" value="4"<?=$r[enpagecode]==4?' checked':''?>>
              GB2312-&gt;BIG5</td>
            <td><input type="radio" name="add[enpagecode]" value="6"<?=$r[enpagecode]==6?' checked':''?>>
              UNICODE-&gt;BIG5</td>
          </tr>
          <?php
		 $trueenpagecode='';
		 }
		 if($ecms_config['sets']['pagechar']=='utf-8')
		 {
		 ?>
          <tr> 
            <td height="22">
              <?=$trueenpagecode?>            </td>
            <td><input type="radio" name="add[enpagecode]" value="7"<?=$r[enpagecode]==7?' checked':''?>>
              GB2312-&gt;UTF8</td>
            <td><input type="radio" name="add[enpagecode]" value="8"<?=$r[enpagecode]==8?' checked':''?>>
              BIG5-&gt;UTF8</td>
            <td><input type="radio" name="add[enpagecode]" value="9"<?=$r[enpagecode]==9?' checked':''?>>
              UNICODE-&gt;UTF8</td>
          </tr>
          <?php
		  }
		  ?>
        </table></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">�Ƿ��ظ��ɼ�ͬһ����</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[recjtheurl]" type="checkbox" id="add[recjtheurl]" value="1"<?=$r[recjtheurl]==1?' checked':''?>>
        �ظ��ɼ�<font color="#666666">����ѡΪ���ظ��ɼ���</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"><p>�Ƿ������ѵ������Ϣ</p></td>
      <td height="23" bgcolor="#FFFFFF"><input type="radio" name="add[hiddenload]" value="0"<?=$r[hiddenload]==0?' checked':''?>>
        �� 
        <input type="radio" name="add[hiddenload]" value="1"<?=$r[hiddenload]==1?' checked':''?>>
        ��</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">�ɼ����Զ����</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[justloadin]" type="checkbox" id="add[justloadin]" value="1"<?=$r[justloadin]==1?' checked':''?>>
        �ǣ� 
        <input name="add[justloadcheck]" type="checkbox" id="add[justloadcheck]" value="1"<?=$r[justloadcheck]==1?' checked':''?>>
        ֱ�����<font color="#666666">(���Ƽ�ѡ����Ϊ������ⳬʱ)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[delloadinfo]" type="checkbox" id="add[delloadinfo]" value="1"<?=$r[delloadinfo]==1?' checked':''?>>
        �����Զ�ɾ���ѵ������Ϣ��¼</td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF">����ҳ���������<br> <font color="#666666">��ʽ����濪ʼ[!--pad--]������</font></td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td> <textarea name="pagerepad" cols="60" rows="10" id="textarea"><?=ehtmlspecialchars(stripSlashes($r[pagerepad]))?></textarea>            </td>
            <td valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<iframe[!--pad--]</iframe>,<IFRAME[!--pad--]</IFRAME>');">IFRAME</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<table[!--pad--]>,</table>,<TABLE[!--pad--]>,</TABLE>');">TABLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<form[!--pad--]</form>,<FORM[!--pad--]</FORM>');">FORM</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<object[!--pad--]</object>,<OBJECT[!--pad--]</OBJECT>');">OBJECT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<tr[!--pad--]>,</tr>,<TR[!--pad--]>,</TR>');">TR</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<tbody[!--pad--]>,</tbody>,<TBODY[!--pad--]>,</TBODY>');">TBODY</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<script[!--pad--]</script>,<SCRIPT[!--pad--]</SCRIPT>');">SCRIPT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<td[!--pad--]>,</td>,<TD[!--pad--]>,</TD>');">TD</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<style[!--pad--]</style>,<STYLE[!--pad--]</STYLE>');">STYLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<a[!--pad--]>,</a>,<A[!--pad--]>,</A>');">A</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<div[!--pad--]>,</div>,<DIV[!--pad--]>,</DIV>');">DIV</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<font[!--pad--]>,</font>,<FONT[!--pad--]>,</FONT>');">FONT</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(1,'<span[!--pad--]>,</span>,<SPAN[!--pad--]>,</SPAN>');">SPAN</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(1,'<img[!--pad--]>,<IMG[!--pad--]>');">IMG</a></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td><font color="#666666">(�������&quot;,&quot;��)</font></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="23" rowspan="2" valign="top" bgcolor="#FFFFFF">����ҳ���滻</td>
      <td height="11" bgcolor="#FFFFFF">�� 
        <textarea name="add[oldpagerep]" cols="36" rows="10" id="add[oldpagerep]"><?=ehtmlspecialchars(stripSlashes($r[oldpagerep]))?></textarea>
        �滻�� 
        <textarea name="add[newpagerep]" cols="36" rows="10" id="textarea4"><?=ehtmlspecialchars(stripSlashes($r[newpagerep]))?></textarea>      </td>
    </tr>
    <tr> 
      <td height="11" bgcolor="#FFFFFF"><font color="#666666">(ԭ�ַ��������&quot;,&quot;��,��������ַ��Ƕ����������&quot;,&quot;�񿪣�ϵͳ���Ӧ�滻)</font></td>
    </tr>
    <tr class="header"> 
      <td height="23" colspan="2">����ѡ��</td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">�ɼ��ؼ���(�����ؼ��ֲŻ��)��</td>
      <td height="23" bgcolor="#FFFFFF"> <input name="add[keyboard]" type="text" id="add[keyboard]" value="<?=$r[keyboard]?>"> 
        <font color="#666666">(ֻ��Ա��⡣�粻���ƣ������ա��������&quot;,&quot;��)</font></td>
    </tr>
    <tr> 
      <td rowspan="2" valign="top" bgcolor="#FFFFFF">�滻��<br>
        (��Ա���������) </td>
      <td height="23" bgcolor="#FFFFFF">�� 
        <textarea name="add[oldword]" cols="36" rows="10" id="add[oldword]"><?=ehtmlspecialchars(stripSlashes($r[oldword]))?></textarea>
        �滻�� 
        <textarea name="add[newword]" cols="36" rows="10" id="add[newword]"><?=ehtmlspecialchars(stripSlashes($r[newword]))?></textarea>      </td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF"><font color="#666666">(ԭ�ַ��������&quot;,&quot;��,��������ַ��Ƕ����������&quot;,&quot;�񿪣�ϵͳ���Ӧ�滻)</font></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">Ҫ�滻���ֶ���</td>
      <td height="23" bgcolor="#FFFFFF"><input name="repf" type="text" id="repf" value="<?=substr($r[repf],1,-1)?>" size="60">
        <font color="#666666">(����ֶ��ð�Ƕ���&quot;,&quot;��)</font></td>
    </tr>
    <tr> 
      <td height="23" valign="top" bgcolor="#FFFFFF"><strong>���˹������</strong><br> 
        <font color="#666666">��ʽ����濪ʼ[!--ad--]������<br>
        (�������) </font></td>
      <td height="23" bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td> <textarea name="repad" cols="60" rows="10" id="repad"><?=ehtmlspecialchars(stripSlashes($r[repad]))?></textarea>            </td>
            <td valign="top"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<iframe[!--ad--]</iframe>,<IFRAME[!--ad--]</IFRAME>');">IFRAME</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<table[!--ad--]>,</table>,<TABLE[!--ad--]>,</TABLE>');">TABLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<form[!--ad--]</form>,<FORM[!--ad--]</FORM>');">FORM</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<object[!--ad--]</object>,<OBJECT[!--ad--]</OBJECT>');">OBJECT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<tr[!--ad--]>,</tr>,<TR[!--ad--]>,</TR>');">TR</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<tbody[!--ad--]>,</tbody>,<TBODY[!--ad--]>,</TBODY>');">TBODY</a></td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<script[!--ad--]</script>,<SCRIPT[!--ad--]</SCRIPT>');">SCRIPT</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<td[!--ad--]>,</td>,<TD[!--ad--]>,</TD>');">TD</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<style[!--ad--]</style>,<STYLE[!--ad--]</STYLE>');">STYLE</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<a[!--ad--]>,</a>,<A[!--ad--]>,</A>');">A</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<div[!--ad--]>,</div>,<DIV[!--ad--]>,</DIV>');">DIV</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<font[!--ad--]>,</font>,<FONT[!--ad--]>,</FONT>');">FONT</a></td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td><a href="#ecms" onclick="AddRepAd(0,'<span[!--ad--]>,</span>,<SPAN[!--ad--]>,</SPAN>');">SPAN</a></td>
                  <td><a href="#ecms" onclick="AddRepAd(0,'<img[!--ad--]>,<IMG[!--ad--]>');">IMG</a></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td><font color="#666666">(�������&quot;,&quot;��)</font></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="23" bgcolor="#FFFFFF">Ҫ���˹����ֶ���</td>
      <td height="23" bgcolor="#FFFFFF"><input name="repadf" type="text" id="repadf" value="<?=substr($r[repadf],1,-1)?>" size="60">
        <font color="#666666">(����ֶ��ð�Ƕ���&quot;,&quot;��)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">����Ϊ�ղ��ɼ�</td>
      <td height="23" bgcolor="#FFFFFF"><input name="add[newstextisnull]" type="checkbox" id="add[newstextisnull]" value="1"<?=$r[newstextisnull]==1?' checked':''?>>
        �ǣ���֤�ֶ�����<font color="#666666">
        <input name="isnullf" type="text" id="isnullf" value="<?=substr($r['isnullf'],1,-1)?>" size="40">
        (����ֶ��ð�Ƕ���&quot;,&quot;��)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">�������ƣ�</td>
      <td height="23" bgcolor="#FFFFFF">���ɼ��������Ƴ��� 
        <input name="add[titlelen]" type="text" id="add[titlelen]" value="<?=$r[titlelen]?>" size="6">
        �ֵ���Ϣ[�������Ϣ�Ƚ�]<font color="#666666">(�粻��������&quot;0&quot;)</font></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="23" bgcolor="#FFFFFF">���ɼ�������ȫ��ͬ����Ϣ(�������Ϣ�Ƚ�) 
        <input name="add[retitlewriter]" type="checkbox" id="add[retitlewriter]" value="1"<?=$retitlewriter?>></td>
    </tr>
    <tr> 
      <td height="23" bgcolor="#FFFFFF">��ȡ���ݼ�飺</td>
      <td height="23" bgcolor="#FFFFFF"> <p>��ȡ��Ϣ���� 
          <input name="add[smalltextlen]" type="text" id="add[smalltextlen]" value="<?=$r[smalltextlen]?>" size="6">
          ����<font color="#666666">����û�����á����ݼ�顱����ϵͳ��ȡ�Ĵ�ʩ��</font></p></td>
    </tr>
    <tr class="header"> 
      <td height="25" colspan="2">�ɼ���������(���ɼ��������)</td>
    </tr>
    <tr> 
      <td bgcolor="#C7D4F7">�б�ҳ</td>
      <td bgcolor="#C7D4F7">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><strong>��Ϣ������������</strong><br>
        (<font color="#FF0000">�粻�ޣ���Ϊ��</font>)<br>
        ��ȡ�ĵط����� 
        <input name="textfield" type="text" id="textfield" value="[!--smallurl--]" size="20"> 
        <br>
        �磺&lt;tr&gt;&lt;td&gt;��������&lt;/td&gt;&lt;/tr&gt;<br>
        �������:<br> &lt;tr&gt;&lt;td&gt;[!--smallurl--]&lt;/td&gt;&lt;/tr&gt;</td>
      <td bgcolor="#FFFFFF"> <textarea name="add[zz_smallurl]" cols="60" rows="10" id="textarea8"><?=ehtmlspecialchars(stripSlashes($r[zz_smallurl]))?></textarea></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><strong>��Ϣҳ��������</strong><br>
        ��ȡ�ĵط����� 
        <input name="textfield" type="text" id="textfield3" value="[!--newsurl--]" size="20"> 
        <br>
        �磺&lt;a href=&quot;��Ϣ����&quot;&gt;����&lt;/a&gt;<br>
        �������:<br> &lt;a href=&quot;[!--newsurl--]&quot;&gt;*&lt;/a&gt;</td>
      <td bgcolor="#FFFFFF"> <textarea name="add[zz_newsurl]" cols="60" rows="10" id="add[zz_newsurl]"><?=ehtmlspecialchars(stripSlashes($r[zz_newsurl]))?></textarea></td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF"><p><strong>����ͼƬ����<br>
          (��ͼƬ������ҳ��������)</strong><br>
          <input name="textfield" type="text" id="textfield" value="[!--titlepic--]" size="20">
        </p></td>
      <td bgcolor="#FFFFFF"> <table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr> 
            <td>ͼƬ��ַǰ׺�� 
              <input name="add[qz_titlepicl]" type="text" id="add[qz_titlepicl]" value="<?=stripSlashes($r[qz_titlepicl])?>" size="32"> 
              <input name="add[save_titlepicl]" type="checkbox" id="add[save_titlepicl]" value=" checked"<?=$r[save_titlepicl]?>>
              ���汾�� </td>
          </tr>
          <tr> 
            <td><textarea name="add[zz_titlepicl]" cols="60" rows="10" id="add[zz_titlepicl]"><?=ehtmlspecialchars(stripSlashes($r[zz_titlepicl]))?></textarea></td>
          </tr>
          <tr> 
            <td><input name="add[z_titlepicl]" type="text" id="add[z_titlepicl]" value="<?=stripSlashes($r[z_titlepicl])?>" size="32">
              (���������Ϊ���ֶ�ֵ)</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="C7D4F7">����ҳ(�ļ�������벻Ҫѡ�񱣴汾��)</td>
    </tr>
    <?
	@include($cjfile);
	?>
    <tr> 
      <td colspan="2" bgcolor="C7D4F7">����ҳ��ҳ�ɼ�����:(��û�з�ҳ������,ֻ��newstext��Ч)</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">����Ƿ���ԭ��ҳ��</td>
      <td bgcolor="#FFFFFF"><input type="radio" name="add[doaddtextpage]" value="0"<?=$r[doaddtextpage]==0?' checked':''?>>
        ������ҳ
        <input type="radio" name="add[doaddtextpage]" value="1"<?=$r[doaddtextpage]==1?' checked':''?>>
        ��������ҳ</td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">��ҳ��ʽ:</td>
      <td bgcolor="#FFFFFF"> <input type="radio" name="add[pagetype]" value="0"<?=$pagetype0?>>
        ����ҳ����ʽ 
        <input type="radio" name="add[pagetype]" value="1"<?=$pagetype1?>>
        ȫ���г�ʽ </td>
    </tr>
    <tr> 
      <td valign="top" bgcolor="#FFFFFF">&quot;ȫ���г�&quot;ʽ��������:</td>
      <td bgcolor="#FFFFFF"> <table width="100%%" border="0" cellspacing="1" cellpadding="2">
          <tr> 
            <td width="50%" height="23"><strong>��ҳ��������(<font color="#FF0000">[!--smallpageallzz--]</font>)</strong></td>
            <td><strong>��ҳ��������(<font color="#FF0000">[!--pageallzz--]</font>)</strong></td>
          </tr>
          <tr> 
            <td><textarea name="add[smallpageallzz]" cols="42" rows="12" id="textarea2"><?=ehtmlspecialchars(stripSlashes($r[smallpageallzz]))?></textarea></td>
            <td><textarea name="add[pageallzz]" cols="42" rows="12" id="textarea3"><?=ehtmlspecialchars(stripSlashes($r[pageallzz]))?></textarea></td>
          </tr>
        </table></td>
    </tr>
	<tr> 
      <td valign="top" bgcolor="#FFFFFF">&quot;����ҳ����&quot;ʽ��������:</td>
      <td bgcolor="#FFFFFF"> <table width="100%%" border="0" cellspacing="1" cellpadding="2">
          <tr> 
            <td width="50%" height="23"><strong>��ҳ��������(<font color="#FF0000">[!--smallpagezz--]</font>)</strong></td>
            <td><strong>��ҳ��������(<font color="#FF0000">[!--pagezz--]</font>)</strong></td>
          </tr>
          <tr> 
            <td><textarea name="add[smallpagezz]" cols="42" rows="12" id="add[smallpagezz]"><?=ehtmlspecialchars(stripSlashes($r[smallpagezz]))?></textarea></td>
            <td><textarea name="add[pagezz]" cols="42" rows="12" id="add[pagezz]"><?=ehtmlspecialchars(stripSlashes($r[pagezz]))?></textarea></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="�ύ"> <input type="reset" name="Submit2" value="����">      </td>
    </tr>
  </table>
  <br>
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td><strong>ע�����<font color="#FF0000"><br>
        </font></strong>1.*:��ʾ���������ݡ�������֮��ļ�������*��<br>
        2.���ӽڵ������ȡ�Ԥ������<br>
        3.���������ַ�����ǰ����ϡ�\\������Ȼֱ�ӽ������ַ���Ϊ��*��������ˡ������ַ����£�<br>
        ),(,{,}��[,]��\��?<br>
        4.ͬһ��Ϣ����ϵͳ�����ظ��ɼ���</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
db_close();
$empire=null;
?>