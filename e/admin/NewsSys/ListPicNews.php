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
CheckLevel($logininid,$loginin,$classid,"picnews");

//����ͼƬ��Ϣ
function AddPicNews($add,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$userid,$username){
	global $empire,$dbtbpre;
	if(!$title||!$pic_url||!$url||!$add[classid])
	{printerror("MustEnter","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"picnews");
	$add[classid]=(int)$add[classid];
	$border=(int)$border;
	$title=hRepPostStr($title,1);
	$pic_url=hRepPostStr2($pic_url);
	$url=hRepPostStr2($url);
	$pic_width=hRepPostStr($pic_width,1);
	$pic_height=hRepPostStr($pic_height,1);
	$open_pic=hRepPostStr($open_pic,1);
	$pictext=hRepPostStr2($pictext);
	$sql=$empire->query("insert into {$dbtbpre}enewspic(title,pic_url,url,pic_width,pic_height,open_pic,border,pictext,classid) values('$title','$pic_url','$url','$pic_width','$pic_height','$open_pic',$border,'$pictext',$add[classid]);");
	//����js
	$picid=$empire->lastid();
	GetPicJs($picid);
	if($sql)
	{
		//������־
		insert_dolog("picid=".$picid."<br>title=".$title);
		printerror("AddPicNewsSuccess","AddPicNews.php?enews=AddPicNews".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//����ͼƬ��Ϣjs
function GetPicJs($picid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewspic where picid='$picid'");
	$string="<a href='".$r[url]."' title='".$r[title]."' target='".$r[open_pic]."'><img src='".$r[pic_url]."' width=".$r[pic_width]." height=".$r[pic_height]." border=".$r[border]."><br>".$r[title]."</a>";
	$string="document.write(\"".addslashes($string)."\");";
	$filename="../../../d/js/pic/pic_".$picid.".js";
	WriteFiletext_n($filename,$string);
}

//ɾ��ͼƬ��Ϣjs
function DelPicJs($picid){
	$filename="../../../d/js/pic/pic_".$picid.".js";
	DelFiletext($filename);
}

//�޸�ͼƬ��Ϣ
function EditPicNews($add,$picid,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$userid,$username){
	global $empire,$dbtbpre;
	$picid=(int)$picid;
	if(!$picid||!$title||!$pic_url||!$url||!$add[classid])
	{printerror("MustEnter","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"picnews");
	$add[classid]=(int)$add[classid];
	$border=(int)$border;
	$title=hRepPostStr($title,1);
	$pic_url=hRepPostStr2($pic_url);
	$url=hRepPostStr2($url);
	$pic_width=hRepPostStr($pic_width,1);
	$pic_height=hRepPostStr($pic_height,1);
	$open_pic=hRepPostStr($open_pic,1);
	$pictext=hRepPostStr2($pictext);
	$sql=$empire->query("update {$dbtbpre}enewspic set title='$title',pic_url='$pic_url',url='$url',pic_width='$pic_width',pic_height='$pic_height',open_pic='$open_pic',border=$border,pictext='$pictext',classid=$add[classid] where picid='$picid'");
	//����js
	GetPicJs($picid);
	if($sql)
	{
		//������־
		insert_dolog("picid=".$picid."<br>title=".$title);
		printerror("EditPicNewsSuccess","ListPicNews.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ��ͼƬ��Ϣ
function DelPicNews($picid,$userid,$username){
	global $empire,$dbtbpre;
	$picid=(int)$picid;
	if(!$picid)
	{printerror("NotDelPicnewsid","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"picnews");
	$r=$empire->fetch1("select title from {$dbtbpre}enewspic where picid='$picid'");
	$sql=$empire->query("delete from {$dbtbpre}enewspic where picid='$picid'");
	//ɾ��ͼƬjs
	DelPicJs($picid);
	if($sql)
	{
		//������־
		insert_dolog("picid=".$picid."<br>title=".$r[title]);
		printerror("DelPicNewsSuccess","ListPicNews.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//����ɾ��ͼƬ��Ϣ
function DelPicNews_all($picid,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"picnews");
	$count=count($picid);
	if(!$count)
	{printerror("NotDelPicnewsid","history.go(-1)");}
	for($i=0;$i<$count;$i++)
	{
		$picid[$i]=(int)$picid[$i];
		$add.="picid='$picid[$i]' or ";
		//ɾ��ͼƬjs
		DelPicJs($picid[$i]);
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("delete from {$dbtbpre}enewspic where ".$add);
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("DelPicNewsSuccess","ListPicNews.php".hReturnEcmsHashStrHref2(1));
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
//����ͼƬ����
if($enews=="AddPicNews")
{
	$add=$_POST['add'];
	$title=$_POST['title'];
	$pic_url=$_POST['pic_url'];
	$url=$_POST['url'];
	$pic_width=$_POST['pic_width'];
	$pic_height=$_POST['pic_height'];
	$open_pic=$_POST['open_pic'];
	$border=$_POST['border'];
	$pictext=$_POST['pictext'];
	AddPicNews($add,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$logininid,$loginin);
}
//�޸�ͼƬ����
elseif($enews=="EditPicNews")
{
	$add=$_POST['add'];
	$picid=$_POST['picid'];
	$title=$_POST['title'];
	$pic_url=$_POST['pic_url'];
	$url=$_POST['url'];
	$pic_width=$_POST['pic_width'];
	$pic_height=$_POST['pic_height'];
	$open_pic=$_POST['open_pic'];
	$border=$_POST['border'];
	$pictext=$_POST['pictext'];
	EditPicNews($add,$picid,$title,$pic_url,$url,$pic_width,$pic_height,$open_pic,$border,$pictext,$logininid,$loginin);
}
//ɾ��ͼƬ����
elseif($enews=="DelPicNews")
{
	$picid=$_GET['picid'];
	DelPicNews($picid,$logininid,$loginin);
}
//����ɾ��ͼƬ����
elseif($enews=="DelPicNews_all")
{
	$picid=$_POST['picid'];
	DelPicNews_all($picid,$logininid,$loginin);
}

$start=0;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$add="";
$search="";
$search.=$ecms_hashur['ehref'];
$classid=(int)$_GET['classid'];
if($classid)
{
	$add=" where classid='$classid'";
    $search.="&classid=$classid";
}
$line=10;//ÿ����ʾ
$page_line=15;
$offset=$page*$line;
$totalquery="select count(*) as total from {$dbtbpre}enewspic".$add;
$num=$empire->gettotal($totalquery);//ȡ��������
$query="select picid,title,pic_url,url,pic_width,pic_height,open_pic,border,pictext from {$dbtbpre}enewspic".$add;
$query.=" order by picid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//ͼƬ���
$csql=$empire->query("select classid,classname from {$dbtbpre}enewspicclass order by classid");
while($cr=$empire->fetch($csql))
{
	if($classid==$cr[classid])
	{$select=" selected";}
	else
	{$select="";}
	$class.="<option value=".$cr[classid].$select.">".$cr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ͼƬ��Ϣ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">λ�ã�<a href="ListPicNews.php<?=$ecms_hashur['whehref']?>">����ͼƬ��Ϣ</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="����ͼƬ��Ϣ" onclick="self.location.href='AddPicNews.php?enews=AddPicNews<?=$ecms_hashur['ehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit52" value="����ͼƬ��Ϣ����" onclick="self.location.href='PicClass.php<?=$ecms_hashur['whehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td>���ࣺ
      <select name="classid" id="classid" onchange=window.location='ListPicNews.php?<?=$ecms_hashur['ehref']?>&classid='+this.options[this.selectedIndex].value>
        <option value="0">�������</option>
		<?=$class?>
      </select></td>
  </tr>
</table>
<form name="form1" method="post" action="ListPicNews.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
<input type=hidden name=enews value=DelPicNews_all>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <?=$ecms_hashur['form']?>
    <tr class="header"> 
      <td width="10%" height="25"><div align="center">ID</div></td>
      <td width="64%" height="25"><div align="center">Ԥ��</div></td>
      <td width="26%" height="25"><div align="center">����</div></td>
    </tr>
    <?
	while($r=$empire->fetch($sql))
	{
	?>
    <tr bgcolor="#FFFFFF" id=pic<?=$r[picid]?>> 
      <td height="25"><div align="center">
          <?=$r[picid]?>
        </div></td>
      <td height="25"><div align="center"><a href="<?=$r[url]?>" target="<?=$r[open_pic]?>" title="<?=$r[title]?>"><img src="<?=$r[pic_url]?>" height="<?=$r[pic_height]?>" width="<?=$r[pic_width]?>" border="<?=$r[border]?>"></a><br>
          <?=$r[title]?>
        </div></td>
      <td height="25"><div align="center">[<a href="AddPicNews.php?enews=EditPicNews&picid=<?=$r[picid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
          [<a href="ListPicNews.php?enews=DelPicNews&picid=<?=$r[picid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a> 
          <input name="picid[]" type="checkbox" id="picid[]" value="<?=$r[picid]?>" onclick="if(this.checked){pic<?=$r[picid]?>.style.backgroundColor='#DBEAF5';}else{pic<?=$r[picid]?>.style.backgroundColor='#ffffff';}">
          ]</div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="3">&nbsp;
        <?=$returnpage?>
        &nbsp;&nbsp;
        <input type="submit" name="Submit" value="����ɾ��"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25" colspan="3"><font color="#666666">JS���÷�ʽ��&lt;script src= 
        <?=$public_r[newsurl]?>
        d/js/pic/pic_ͼƬ��ϢID.js&gt;&lt;/script&gt;</font></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$empire=null;
?>
