<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require("../data/dbcache/class.php");
require LoadLang("pub/fun.php");
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
$line=50;
$page_line=12;
$classid=(int)$_GET['classid'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$offset=$page*$line;
//�ڵ�����
$cr=$empire->fetch1("select classname,newsclassid,tbname,hiddenload from {$dbtbpre}enewsinfoclass where classid='$classid'");
$addwhere=" and checked=0";
//��ʾ�ѵ������Ϣ
if($cr['hiddenload'])
{
	$addwhere="";
}
$query="select * from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where classid='$classid'".$addwhere;
$totalquery="select count(*) as total from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where classid='$classid'".$addwhere;
$num=$empire->gettotal($totalquery);
$query.=" order by id desc limit $offset,$line";
$sql=$empire->query($query);
//��Ŀ����
$newsclassid=$cr[newsclassid];
$newsclassname=$class_r[$newsclassid][classname];
$newsbclassname=$class_r[$class_r[$newsclassid][bclassid]][classname];
$newsclass="<font color=red>".$newsbclassname."&nbsp;>&nbsp;".$newsclassname."</font>";
$checked=" checked";
$search="&classid=$classid".$ecms_hashur['ehref'];
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
if($_GET['from'])
{
	$listclasslink="ListPageInfoClass.php";
}
else
{
	$listclasslink="ListInfoClass.php";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>��˲ɼ�</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
	if(e.name=='checked'||e.name=='uptime')
		{
		continue;
	    }
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
  function LoadIn(obj)
  {
	var checkedval=0;
	var uptimeval=0;
	if(confirm("ȷ�ϲ���?"))
	{
		if(obj.checked.checked)
		{
			checkedval=1;
		}
		if(obj.uptime.checked)
		{
			uptimeval=1;
		}
  		self.location.href='ecmscj.php?<?=$ecms_hashur['href']?>&enews=CjNewsIn_all&from=<?=RepPostStr($_GET['from'],1)?>&classid='+obj.classid.value+'&checked='+checkedval+'&uptime='+uptimeval;
	}
  }
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> 
    <td width="90%" height="25">λ�ã��ɼ� &gt; <a href="<?=$listclasslink?><?=$ecms_hashur['whehref']?>">����ڵ�</a> &gt; <a href="CheckCj.php?classid=<?=$classid?>&from=<?=ehtmlspecialchars($_GET['from'])?><?=$ecms_hashur['ehref']?>">��˲ɼ�</a> 
      &gt; �ڵ����ƣ� 
      <?=$cr[classname]?>
      &nbsp;(��<b><font color=red> 
      <?=$num?>
      </font></b>��δ����¼) </td>
    <td width="10%"><div align="right" class="emenubutton">
        <input type="button" name="Submit6" value="���ݸ�������" onclick="window.open('ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>#ReIfInfoHtml');">
      </div></td>
  </tr>
  <tr> 
    <td height="25" colspan="2">�����Ŀ�� 
      <?=$newsclass?>
    </td>
  </tr>
</table>
<form name="listform" method="post" action="ecmscj.php" onsubmit="return confirm('ȷ�ϲ�����');">
<?=$ecms_hashur['form']?>
<input type=hidden name=from value="<?=ehtmlspecialchars($_GET['from'])?>">
<input type=hidden name=classid value=<?=$classid?>>
<input type=hidden name=enews value=DelCjNews_all>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="3%"><div align="center"></div></td>
      <td width="7%" height="25"><div align="center">ID</div></td>
      <td width="38%" height="25"><div align="center">����</div></td>
      <td width="14%" height="25"><div align="center">�ɼ���</div></td>
      <td width="16%" height="25"><div align="center">�ɼ�ʱ��</div></td>
      <td width="8%" height="25"><div align="center">�ɼ���ַ</div></td>
      <td width="14%" height="25"><div align="center">����</div></td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
	$r[title]=stripSlashes(sub($r[title],0,30,false));
	if($r[checked])
	{
		$tcolor="";
	}
	else
	{
		$tcolor=" bgcolor='#FFFFFF'";
	}
	?>
    <tr<?=$tcolor?> id=news<?=$r[id]?>> 
      <td><div align="center"> 
          <input name="id[]" type="checkbox" id="id[]" onclick="if(this.checked){news<?=$r[id]?>.style.backgroundColor='#DBEAF5';}else{news<?=$r[id]?>.style.backgroundColor='#ffffff';}" value="<?=$r[id]?>"<?=$checked?>>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[id]?>
        </div></td>
      <td height="25"><div align="left"><a href="EditCjNews.php?classid=<?=$classid?>&id=<?=$r[id]?>&enews=EditCjNews&from=<?=ehtmlspecialchars($_GET['from'])?><?=$ecms_hashur['ehref']?>" title="�鿴"> 
          <?=$r[title]?>
          </a></div></td>
      <td height="25"><div align="center"> 
          <?=$r[username]?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[tmptime]?>
        </div></td>
      <td height="25"><div align="center"><a href="<?=$r[oldurl]?>" target="_blank">�鿴��ַ</a></div></td>
      <td height="25"><div align="center"><a href="EditCjNews.php?classid=<?=$classid?>&id=<?=$r[id]?>&enews=EditCjNews&from=<?=ehtmlspecialchars($_GET['from'])?><?=$ecms_hashur['ehref']?>">�޸�</a> 
          | <a href="ecmscj.php?enews=DelCjNews&classid=<?=$classid?>&id=<?=$r[id]?>&from<?=ehtmlspecialchars($_GET['from'])?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ����');">ɾ��</a></div></td>
    </tr>
    <?
	}
	db_close();
	$empire=null;
	?>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center"> 
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form) title="ȫѡ">
        </div></td>
      <td height="25" colspan="6"><div align="right"> 
          <input name="checked" type="checkbox" id="checked" value="1"<?=$checked?>>
          ֱ����� 
          <input name="uptime" type="checkbox" id="uptime" value="1">
          ����ʱ����Ϊ���ʱ�� 
          <input type="submit" name="Submit32" value="���ѡ��" onclick="document.listform.enews.value='CjNewsIn';">
          &nbsp;&nbsp; 
          <input type="button" name="Submit" value="���ȫ����Ϣ" onclick="return LoadIn(document.listform)">
          &nbsp;&nbsp; 
          <input type="submit" name="Submit3" value="ɾ��" onclick="document.listform.enews.value='DelCjNews_all';">
          &nbsp;&nbsp; </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">
      </td>
      <td height="25" colspan="6"><?=$returnpage?></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="7"><font color="#666666">˵������������ϢΪ��ɫ��������ⲻ����htmlҳ��,��Ҫ�����ݸ���ˢ�µ�����Ϣ.</font></td>
    </tr>
  </table>
</form>
</body>
</html>
