<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"pay");

//����ɾ��
function DelPayRecord_all($id,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"pay");
	$count=count($id);
	if(!$count)
	{
		printerror("NotDelPayRecordid","history.go(-1)");
	}
	for($i=0;$i<$count;$i++)
	{
		$add.=" id='".intval($id[$i])."' or";
	}
	$add=substr($add,0,strlen($add)-3);
	$sql=$empire->query("delete from {$dbtbpre}enewspayrecord where".$add);
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("DelPayRecordSuccess","ListPayRecord.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//����ɾ��
if($enews=="DelPayRecord_all")
{
	$id=$_POST['id'];
	DelPayRecord_all($id,$logininid,$loginin);
}

$line=25;//ÿҳ��ʾ����
$page_line=18;//ÿҳ��ʾ������
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$offset=$page*$line;//��ƫ����
$query="select id,userid,username,orderid,money,posttime,paybz,type,payip from {$dbtbpre}enewspayrecord";
$totalquery="select count(*) as total from {$dbtbpre}enewspayrecord";
//����
$search='';
$search.=$ecms_hashur['ehref'];
$where='';
if($_GET['sear']==1)
{
	$search.="&sear=1";
	$a='';
	$startday=RepPostVar($_GET['startday']);
	$endday=RepPostVar($_GET['endday']);
	if($startday&&$endday)
	{
		$search.="&startday=$startday&endday=$endday";
		$a.="posttime<='".$endday." 23:59:59' and posttime>='".$startday." 00:00:00'";
	}
	$keyboard=RepPostVar($_GET['keyboard']);
	if($keyboard)
	{
		$and=$a?' and ':'';
		$show=RepPostStr($_GET['show'],1);
		if($show==1)
		{
			$a.=$and."username like '%$keyboard%'";
		}
		elseif($show==2)
		{
			$a.=$and."payip like '%$keyboard%'";
		}
		elseif($show==3)
		{
			$a.=$and."paybz like '%$keyboard%'";
		}
		else
		{
			$a.=$and."orderid like '%$keyboard%'";
		}
		$search.="&keyboard=$keyboard&show=$show";
	}
	if($a)
	{
		$where.=" where ".$a;
	}
	$query.=$where;
	$totalquery.=$where;
}
$num=$empire->gettotal($totalquery);//ȡ��������
$query=$query." order by id desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<html>
<head>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css"> 
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����֧��</title>
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
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>λ�ã�����֧��&gt; <a href="ListPayRecord.php<?=$ecms_hashur['whehref']?>">����֧����¼</a></td>
    <td width="50%"><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="����֧���ӿ�" onclick="self.location.href='PayApi.php<?=$ecms_hashur['whehref']?>';">
		&nbsp;&nbsp;
		<input type="button" name="Submit5" value="֧����������" onclick="self.location.href='SetPayFen.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
  
<br>
<table width="100%" align=center cellpadding=0 cellspacing=0>
  <form name=searchlogform method=get action='ListPayRecord.php'>
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td height="25"> <div align="center">ʱ��� 
          <input name="startday" type="text" value="<?=$startday?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
          �� 
          <input name="endday" type="text" value="<?=$endday?>" size="15" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
          ���ؼ��֣� 
          <input name="keyboard" type="text" id="keyboard" value="<?=$keyboard?>">
          <select name="show" id="show">
            <option value="0"<?=$show==0?' selected':''?>>������</option>
            <option value="1"<?=$show==1?' selected':''?>>�����</option>
            <option value="2"<?=$show==2?' selected':''?>>���IP</option>
			<option value="3"<?=$show==3?' selected':''?>>��ע</option>
          </select>
          <input name=submit1 type=submit id="submit12" value=����>
          <input name="sear" type="hidden" id="sear" value="1">
        </div></td>
    </tr>
  </form>
</table>
<form name="form2" method="post" action="ListPayRecord.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="3%"><div align="center"> 
          <input type=checkbox name=chkall value=on onClick="CheckAll(this.form)">
        </div></td>
      <td width="19%"><div align="center">������</div></td>
      <td width="13%"><div align="center">�����</div></td>
      <td width="10%" height="25"><div align="center">���</div></td>
      <td width="15%"><div align="center">���ʱ��</div></td>
      <td width="12%" height="25"><div align="center">���IP</div></td>
      <td width="20%"><div align="center">��ע</div></td>
      <td width="8%" height="25"><div align="center">�ӿ�</div></td>
    </tr>
    <?
  while($r=$empire->fetch($sql))
  {
  	if($r['userid'])
	{
		$username="<a href='../member/AddMember.php?enews=EditMember&userid=$r[userid]".$ecms_hashur['ehref']."'>$r[username]</a>";
	}
	else
	{
		$username="�ο�(".$r[username].")";
	}
  ?>
    <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
      <td><div align="center"> 
          <input name="id[]" type="checkbox" id="id[]" value="<?=$r[id]?>">
        </div></td>
      <td><div align="center"> 
          <?=$r[orderid]?>
        </div></td>
      <td><div align="center"> 
          <?=$username?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[money]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[posttime]?>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[payip]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[paybz]?>
        </div></td>
      <td height="25"><div align="center"><?=$r[type]?></div></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="8">&nbsp;
        <?=$returnpage?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="Submit" value="����ɾ��"> <input name="enews" type="hidden" id="enews" value="DelPayRecord_all"></td>
    </tr>
  </table>
</form>
<?
db_close();
$empire=null;
?>
</body>
</html>