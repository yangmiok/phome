<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("class/functions.php");
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
CheckLevel($logininid,$loginin,$classid,"dbdata");
$bakpath=$public_r['bakdbpath'];
$mydbname=RepPostVar($_GET['mydbname']);
if(empty($mydbname))
{
	printerror("NotChangeBakTable","history.go(-1)");
}
//ѡ�����ݿ�
$udb=$empire->usequery("use `".$mydbname."`");
//��ѯ
$and="";
$keyboard=RepPostVar($_GET['keyboard']);
$sear=RepPostStr($_GET['sear'],1);
if(empty($sear))
{
	$keyboard=$dbtbpre;
}
if($keyboard)
{
	$and=" LIKE '%$keyboard%'";
}
$sql=$empire->query("SHOW TABLE STATUS".$and);
//���Ŀ¼
$mypath=$mydbname."_".date("YmdHis").make_password(6);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ѡ�����ݱ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
function reverseCheckAll(form)
{
  for (var i=0;i<form.elements.length;i++)
  {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
	{
		continue;
	}
	if (e.name != 'chkall')
	{
	   if(e.checked==true)
	   {
       		e.checked = false;
	   }
	   else
	   {
	  		e.checked = true;
	   }
	}
  }
}
function SelectCheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if(e.name=='bakstru'||e.name=='bakstrufour'||e.name=='beover'||e.name=='autoauf'||e.name=='baktype'||e.name=='bakdatatype')
		{
		continue;
	    }
	if (e.name != 'chkall')
	  	e.checked = true;
    }
  }
function check()
{
	var ok;
	ok=confirm("ȷ��Ҫִ�д˲���?");
	return ok;
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="searchtb" method="GET" action="ChangeTable.php">
<?=$ecms_hashur['eform']?>
<input name="sear" type="hidden" id="sear" value="1">
<input name="mydbname" type="hidden" value="<?=$mydbname?>">
  <tr> 
    <td width="58%">λ�ã��������� -&gt; <a href="ChangeDb.php<?=$ecms_hashur['whehref']?>">ѡ�����ݿ�</a> -&gt; <a href="ChangeTable.php?mydbname=<?=$mydbname?><?=$ecms_hashur['ehref']?>">ѡ�񱸷ݱ�</a>&nbsp;(<?=$mydbname?>)</td>
      <td width="42%"><div align="center">��ѯ: 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <input type="submit" name="Submit3" value="��ʾ���ݱ�">
        </div></td>
  </tr>
  <tr> 
    <td height="25" colspan="2"><div align="center">
          ���ݲ��裺ѡ�����ݿ� -&gt; <font color="#FF0000">ѡ��Ҫ���ݵı�</font> -&gt; ��ʼ���� -&gt; 
          ���</div></td>
  </tr>
</form>
</table>
<form action="phome.php" method="post" name="ebakchangetb" target="_blank" onsubmit="return check();" autocomplete="off">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td height="25">���ݲ������ã� 
        <input name="phome" type="hidden" id="phome2" value="DoEbak"> 
        <input name="mydbname" type="hidden" id="mydbname" value="<?=$mydbname?>">
        </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"> 
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="23%"><input type="radio" name="baktype" value="0"<?=$dbaktype==0?' checked':''?>> 
              <strong>���ļ���С����</strong> </td>
            <td width="77%" height="23"> ÿ�鱸�ݴ�С�� 
              <input name="filesize" type="text" id="filesize" value="300" size="6">
              KB <font color="#666666">(1 MB = 1024 KB)</font></td>
          </tr>
          <tr> 
            <td><input type="radio" name="baktype" value="1"<?=$dbaktype==1?' checked':''?>> 
              <strong>����¼������</strong></td>
            <td height="23">ÿ�鱸�� 
              <input name="bakline" type="text" id="bakline" value="500" size="6">
              ����¼�� 
              <input name="autoauf" type="checkbox" id="autoauf" value="1" checked>
              �Զ�ʶ�������ֶ�<font color="#666666">(�˷�ʽЧ�ʸ���)</font></td>
          </tr>
          <tr> 
            <td>�������ݿ�ṹ</td>
            <td height="23"><input name="bakstru" type="checkbox" id="bakstru" value="1" checked> 
              <font color="#666666">(û�����������ѡ��)</font></td>
          </tr>
          <tr> 
            <td valign="top">���ݱ���</td>
            <td height="23"> <select name="dbchar" id="dbchar">
                <option value="auto"<?=$ddbchar=='auto'?' selected':''?>>�Զ�ʶ�����</option>
                <option value=""<?=$ecms_config['db']['setchar']==''?' selected':''?>>������</option>
                <option value="gbk"<?=$ecms_config['db']['setchar']=='gbk'?' selected':''?>>gbk</option>
                <option value="utf8"<?=$ecms_config['db']['setchar']=='utf8'?' selected':''?>>utf8</option>
                <option value="gb2312"<?=$ecms_config['db']['setchar']=='gb2312'?' selected':''?>>gb2312</option>
                <option value="big5"<?=$ecms_config['db']['setchar']=='big5'?' selected':''?>>big5</option>
                <option value="latin1"<?=$ecms_config['db']['setchar']=='latin1'?' selected':''?>>latin1</option>
              </select> <font color="#666666">(��mysql4.0����mysql4.1���ϰ汾��Ҫѡ��̶����룬����ѡ�Զ�)</font></td>
          </tr>
          <tr>
            <td valign="top">���ݴ�Ÿ�ʽ</td>
            <td height="23"><input name="bakdatatype" type="radio" value="0">
              ���� 
              <input type="radio" name="bakdatatype" value="1" checked>
              ʮ�����Ʒ�ʽ<font color="#666666">(ʮ�����Ʊ����ļ���ռ�ø���Ŀռ�)</font></td>
          </tr>
          <tr> 
            <td>���Ŀ¼</td>
            <td height="23">admin/ebak/ 
              <?=$bakpath?>
              / 
              <input name="mypath" type="text" id="mypath" value="<?=$mypath?>"> 
              <input type="button" name="Submit2" value="ѡ��Ŀ¼" onclick="javascript:window.open('ChangePath.php?change=1&toform=ebakchangetb<?=$ecms_hashur['ehref']?>','','width=600,height=500,scrollbars=yes');"> 
              <font color="#666666">(Ŀ¼�����ڣ�ϵͳ���Զ�����)</font></td>
          </tr>
          <tr> 
            <td valign="top">����ѡ��</td>
            <td height="23">���뷽ʽ: 
              <select name="insertf" id="insertf">
                <option value="replace">REPLACE</option>
                <option value="insert">INSERT</option>
              </select>
              , 
              <input name="beover" type="checkbox" id="beover" value="1"<?=$dbeover==1?' checked':''?>>
              ��������, 
              <input name="bakstrufour" type="checkbox" id="bakstrufour" value="1"> 
              <a title="��Ҫת�����ݱ����ʱѡ��">ת��MYSQL4.0��ʽ</a>, ÿ�鱸�ݼ���� 
              <input name="waitbaktime" type="text" id="waitbaktime" value="0" size="2">
              ��</td>
          </tr>
          <tr> 
            <td valign="top">����˵��<br> <font color="#666666">(ϵͳ������һ��readme.txt)</font></td>
            <td height="23"><textarea name="readme" cols="80" rows="8" id="readme"></textarea></td>
          </tr>
          <tr> 
            <td valign="top">ȥ������ֵ���ֶ��б�<br> <font color="#666666">(��ʽ��<strong>����.�ֶ���</strong><br>
              �������&quot;,&quot;��)</font></td>
            <td height="23"><textarea name="autofield" cols="80" rows="5" id="autofield"></textarea></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr class="header"> 
      <td height="25">ѡ��Ҫ���ݵı�( <a href="#ebak" onclick="SelectCheckAll(document.ebakchangetb)"><u>ȫѡ</u></a> 
        | <a href="#ebak" onclick="reverseCheckAll(document.ebakchangetb);"><u>��ѡ</u></a> 
        )</td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
          <tr bgcolor="#DBEAF5"> 
            <td width="5%" height="23"> <div align="center">ѡ��</div></td>
            <td width="27%" height="23" bgcolor="#DBEAF5"> <div align="center">����(����鿴�ֶ�)</div></td>
            <td width="13%" height="23" bgcolor="#DBEAF5"> <div align="center">����</div></td>
            <td width="15%" bgcolor="#DBEAF5"><div align="center">����</div></td>
            <td width="15%" height="23"> <div align="center">��¼��</div></td>
            <td width="14%" height="23"> <div align="center">��С</div></td>
            <td width="11%" height="23"> <div align="center">��Ƭ</div></td>
          </tr>
          <?
		  $totaldatasize=0;//�����ݴ�С
		  $tablenum=0;//�ܱ���
		  $datasize=0;//���ݴ�С
		  $rownum=0;//�ܼ�¼��
		  while($r=$empire->fetch($sql))
		  {
		  $rownum+=$r[Rows];
		  $tablenum++;
		  $datasize=$r[Data_length]+$r[Index_length];
		  $totaldatasize+=$r[Data_length]+$r[Index_length]+$r[Data_free];
		  $collation=$r[Collation]?$r[Collation]:'---';
		  ?>
          <tr id=tb<?=$r[Name]?>> 
            <td height="23"> <div align="center"> 
                <input name="tablename[]" type="checkbox" id="tablename[]" value="<?=$r[Name]?>" onclick="if(this.checked){tb<?=$r[Name]?>.style.backgroundColor='#F1F7FC';}else{tb<?=$r[Name]?>.style.backgroundColor='#ffffff';}" checked>
              </div></td>
            <td height="23"> <a href="#ebak" onclick="window.open('ListField.php?mydbname=<?=$mydbname?>&mytbname=<?=$r[Name]?><?=$ecms_hashur['ehref']?>','','width=660,height=500,scrollbars=yes');" title="����鿴���ֶ��б�"> 
              <?=$r[Name]?>
              </a></td>
            <td height="23"> <div align="center">
                <?=$r[Type]?$r[Type]:$r[Engine]?>
              </div></td>
            <td><div align="center">
				<?=$collation?>
			</div></td>
            <td height="23"> <div align="right">
                <?=$r[Rows]?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($datasize)?>
              </div></td>
            <td height="23"> <div align="right">
                <?=Ebak_ChangeSize($r[Data_free])?>
              </div></td>
          </tr>
          <?
		  }
		  db_close();
		  $empire=null;
		  ?>
          <tr bgcolor="#DBEAF5"> 
            <td height="23"> <div align="center">
                <input type=checkbox name=chkall value=on onclick=CheckAll(this.form) checked>
              </div></td>
            <td height="23"> <div align="center"> 
                <?=$tablenum?>
              </div></td>
            <td height="23"> <div align="center">---</div></td>
            <td><div align="center">---</div></td>
            <td height="23"> <div align="center">
                <?=$rownum?>
              </div></td>
            <td height="23" colspan="2"> <div align="center">
                <?=Ebak_ChangeSize($totaldatasize)?>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr class="header"> 
      <td height="25">
<div align="center">
          <input type="submit" name="Submit" value="��ʼ����" onclick="document.ebakchangetb.phome.value='DoEbak';">
          &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit2" value="�޸����ݱ�" onclick="document.ebakchangetb.phome.value='DoRep';">
          &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="�Ż����ݱ�" onclick="document.ebakchangetb.phome.value='DoOpi';">
        &nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="ɾ�����ݱ�" onclick="document.ebakchangetb.phome.value='DoDrop';">
		&nbsp;&nbsp; &nbsp;&nbsp; 
          <input type="submit" name="Submit22" value="������ݱ�" onclick="document.ebakchangetb.phome.value='EmptyTable';">
		</div></td>
    </tr>
  </table>
</form>
</body>
</html>
