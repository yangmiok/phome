<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
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

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
//����
if($_GET['sear'])
{
	$search.="&sear=1";
	//�ؼ���
	$keyboard=RepPostVar2($_GET['keyboard']);
	if($keyboard)
	{
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$add=" where (classname like '%$keyboard%')";
		}
		elseif($show==2)
		{
			$add=" where (bz like '%$keyboard%')";
		}
		elseif($show==3)
		{
			$add=" where (infourl like '%$keyboard%')";
		}
		else
		{
			$add=" where (classname like '%$keyboard%' or bz like '%$keyboard%' or infourl like '%$keyboard%')";
		}
		$search.="&keyboard=$keyboard&show=$show";
	}
}
$totalquery="select count(*) as total from {$dbtbpre}enewsinfoclass".$add;
$query="select * from {$dbtbpre}enewsinfoclass".$add;
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by classid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>����ڵ�</title>
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
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%">λ�ã��ɼ� &gt; <a href="ListPageInfoClass.php<?=$ecms_hashur['whehref']?>">����ڵ�</a></td>
    <td><div align="right"> </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <form name="searchinfoclass" method="GET" action="ListPageInfoClass.php">
  <?=$ecms_hashur['eform']?>
    <tr>
      <td width="50%" class="emenubutton"><input type="button" name="Submit52" value="���ӽڵ�" onclick="self.location.href='AddInfoC.php?from=1<?=$ecms_hashur['ehref']?>';">
	  &nbsp;&nbsp;
        <input type="button" name="Submit52" value="����ɼ�����" onclick="self.location.href='cj/LoadInCj.php?from=1<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
		<input type="button" name="Submit6" value="���ݸ�������" onclick="window.open('ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>#ReIfInfoHtml');">
		</td>
      <td width="50%" height="32">
<div align="right">����: 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="0"<?=$show==0?' selected':''?>>����</option>
            <option value="1"<?=$show==1?' selected':''?>>�ڵ�����</option>
            <option value="2"<?=$show==2?' selected':''?>>��ע</option>
            <option value="3"<?=$show==3?' selected':''?>>�ɼ�ҳ���ַ</option>
          </select>
          <input type="submit" name="Submit8" value="����">
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
    </tr>
  </form>
</table>
<form name=form1 method=get action="DoCj.php" onsubmit="return confirm('ȷ��Ҫ�ɼ�?');" target=_blank>
  <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <input type=hidden name=enews value=DoCj>
	<input type=hidden name=from value=1>
    <tr class="header"> 
      <td width="3%"><div align="center"></div></td>
      <td width="8%" height="25"> <div align="center">�ɼ�</div></td>
      <td width="27%" height="25"> <div align="center">�ڵ�(������ʲɼ�ҳ)</div></td>
      <td width="6%" height="25"> <div align="center">Ԥ��</div></td>
      <td width="16%" height="25"> <div align="center">����Ŀ</div></td>
      <td width="9%" height="25"> <div align="center">��˲ɼ�</div></td>
      <td width="24%" height="25"> <div align="center">����</div></td>
    </tr>
    <?php
	while($r=$empire->fetch($sql))
	{
		//�ɼ�ҳ��
		$pager=explode("\r\n",$r[infourl]);
	    $infourl=$pager[0];
		if($r[newsclassid])
		{
			$lastcjtime=!$r['lasttime']?'��δ�ɼ�':date("Y-m-d H:i:s",$r['lasttime']);
			$cj="<a href='DoCj.php?enews=CjUrl&classid[]=".$r[classid]."&from=1".$ecms_hashur['href']."' title='���ɼ�ʱ�䣺".$lastcjtime."' target=_blank><u>".$fun_r['StartCj']."</u></a>";
			$emptydb="&nbsp;[<a href='ListInfoClass.php?enews=EmptyCj&classid=$r[classid]&from=1".$ecms_hashur['href']."' onclick=\"return confirm('".$fun_r['CheckEmptyCjRecord']."');\">".$fun_r['EmptyCjRecord']."</a>]";
			$loadoutcj="&nbsp;[<a href=ecmscj.php?enews=LoadOutCj&classid=$r[classid]&from=1".$ecms_hashur['href']." onclick=\"return confirm('ȷ��Ҫ����?');\">����</a>]";
			$checkbox="<input type=checkbox name=classid[] value='$r[classid]' onClick=\"if(this.checked){c".$r[classid].".style.backgroundColor='#DBEAF5';}else{c".$r[classid].".style.backgroundColor='#ffffff';}\">";
		}
		else
		{
			$cj=$fun_r['StartCj'];
			$emptydb="";
			$checkbox="";
		}
		//��Ŀ����
		$getcurlr['classid']=$r[newsclassid];
		$classurl=sys_ReturnBqClassname($getcurlr,9);
	?>
    <tr bgcolor="#FFFFFF" id="c<?=$r[classid]?>" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td> <div align="center">
          <?=$checkbox?>
        </div></td>
      <td height="25"> <div align="center">
          <?=$cj?>
        </div></td>
      <td height="25"> <div align="center"><a href='<?=$infourl?>' target=_blank>
          <?=$r[classname]?>
          </a></div></td>
      <td height="25"> <div align="center"><a href='ecmscj.php?enews=ViewCjList&classid=<?=$r[classid]?>&from=1<?=$ecms_hashur['href']?>' target=_blank>
          <?=$fun_r['view']?>
          </a></div></td>
      <td height="25"> <div align="center"><a href='<?=$classurl?>' target=_blank>
          <?=$class_r[$r[newsclassid]][classname]?>
          </a></div></td>
      <td height="25"> <div align="center"><a href='CheckCj.php?classid=<?=$r[classid]?>&from=1<?=$ecms_hashur['ehref']?>'>
          <?=$fun_r['CheckCj']?>
          </a></div></td>
      <td height="25"> <div align="center">
          <?="[<a href=AddInfoClass.php?enews=AddInfoClass&docopy=1&classid=".$r[classid]."&newsclassid=".$r[newsclassid]."&from=1".$ecms_hashur['ehref'].">".$fun_r['Copy']."</a>]&nbsp;[<a href=AddInfoClass.php?enews=EditInfoClass&classid=".$r[classid]."&from=1".$ecms_hashur['ehref'].">".$fun_r['edit']."</a>]&nbsp;[<a href=ListInfoClass.php?enews=DelInfoClass&classid=".$r[classid]."&from=1".$ecms_hashur['href']." onclick=\"return confirm('".$fun_r['CheckDelCj']."');\">".$fun_r['del']."</a>]".$emptydb.$loadoutcj;?>
        </div></td>
    </tr>
    <?php
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td> <div align="center"> 
          <input type=checkbox name=chkall value=on onClick="CheckAll(this.form)">
        </div></td>
      <td height="25" colspan="6"> <input type="submit" name="Submit" value="�����ɼ��ڵ�"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td height="25" colspan="6"> 
        <?=$returnpage?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td height="25" colspan="6"><font color="#666666">��ע�������ɼ����ڣ��밴ס&quot;Shift&quot;+�������ʼ�ɼ�&quot;</font></td>
    </tr>
  </table>
  </form>
</body>
</html>
<?
db_close();
$empire=null;
?>
