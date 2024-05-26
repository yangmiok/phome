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
CheckLevel($logininid,$loginin,$classid,"vote");

//����ͶƱ
function AddVote($title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $empire,$dbtbpre;
	if(!$title||!$tempid)
	{printerror("EmptyVoteTitle","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"vote");
	//�������
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,0);
	//ͳ����Ʊ��
	for($i=0;$i<count($votename);$i++)
	{$t_votenum+=$votenum[$i];}
	$votetime=to_date($dotime);
	$addtime=date("Y-m-d H:i:s");
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$votetime=(int)$votetime;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$title=hRepPostStr($title,1);
	$votetext=AddAddsData($votetext);
	$dotime=hRepPostStr($dotime,1);
	$sql=$empire->query("insert into {$dbtbpre}enewsvote(title,votetext,votenum,voteip,voteclass,doip,votetime,dotime,width,height,addtime,tempid) values('$title','$votetext',$t_votenum,'',$voteclass,$doip,$votetime,'$dotime',$width,$height,'$addtime',$tempid);");
	//����ͶƱjs
	$voteid=$empire->lastid();
	GetVoteJs($voteid);
	if($sql)
	{
		//������־
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("AddVoteSuccess","AddVote.php?enews=AddVote".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸�ͶƱ
function EditVote($voteid,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $empire,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid||!$title||!$tempid)
	{printerror("EmptyVoteTitle","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"vote");
	//�������
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,1);
	//ͳ����Ʊ��
	for($i=0;$i<count($votename);$i++)
	{$t_votenum+=$votenum[$i];}
	$r=$empire->fetch1("select dotime,votetime from {$dbtbpre}enewsvote where voteid='$voteid'");
	$votetime=to_date($dotime);
	//�������
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$votetime=(int)$votetime;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$title=hRepPostStr($title,1);
	$votetext=AddAddsData($votetext);
	$dotime=hRepPostStr($dotime,1);
	$sql=$empire->query("update {$dbtbpre}enewsvote set title='$title',votetext='$votetext',votenum=$t_votenum,voteclass=$voteclass,doip=$doip,dotime='$dotime',votetime=$votetime,width=$width,height=$height,tempid=$tempid where voteid='$voteid'");
	//����ͶƱjs
	GetVoteJs($voteid);
	if($sql)
	{
		//������־
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("EditVoteSuccess","ListVote.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ��ͶƱ
function DelVote($voteid,$userid,$username){
	global $empire,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid)
	{printerror("NotDelVoteid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"vote");
	$r=$empire->fetch1("select title from {$dbtbpre}enewsvote where voteid='$voteid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsvote where voteid='$voteid'");
	$file="../../../d/js/vote/vote".$voteid.".js";
	DelFiletext($file);
	if($sql)
	{
		//������־
		insert_dolog("voteid=".$voteid."<br>title=".$r[title]);
		printerror("DelVoteSuccess","ListVote.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//��������ͶƱ
function ReVoteJs_all($start=0,$from,$userid,$username){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$moreportpid=(int)$_GET['moreportpid'];
	$mphref='';
	if($moreportpid)
	{
		$mphref=Moreport_ReturnUrlCsPid($moreportpid,0,0,'');
	}
	$start=(int)$start;
	$b=0;
	$sql=$empire->query("select voteid from {$dbtbpre}enewsvote where voteid>$start order by voteid limit ".$public_r['revotejsnum']);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[voteid];
		GetVoteJs($r[voteid]);
	}
	if(empty($b))
	{
		//������־
	    insert_dolog("");
		printerror("ReVoteJsSuccess",$from);
	}
	echo $fun_r['OneReVoteJsSuccess']."(ID:<font color=red><b>".$newstart."</b></font>)<script>self.location.href='ListVote.php?enews=ReVoteJs_all&start=$newstart&from=".urlencode($from).hReturnEcmsHashStrHref(0).$mphref."';</script>";
	exit();
}

//����ͶƱjs
function GetVoteJs($voteid){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsvote where voteid='$voteid'");
	//ģ��
	$votetemp=ReturnVoteTemp($r[tempid],1);
	$votetemp=RepVoteTempAllvar($votetemp,$r);
	$listexp="[!--empirenews.listtemp--]";
	$listtemp_r=explode($listexp,$votetemp);
	$file=eReturnTrueEcmsPath()."d/js/vote/vote".$voteid.".js";
	$r_exp="\r\n";
	$f_exp="::::::";
	//��Ŀ��
	$r_r=explode($r_exp,$r[votetext]);
	$checked=0;
	for($i=0;$i<count($r_r);$i++)
	{
		$checked++;
		$f_r=explode($f_exp,$r_r[$i]);
		//ͶƱ����
		if($r[voteclass])
		{$vote="<input type=checkbox name=vote[] value=".$checked.">";}
		else
		{$vote="<input type=radio name=vote value=".$checked.">";}
		$votetext.=RepVoteTempListvar($listtemp_r[1],$vote,$f_r[0]);
    }
	$votetext="document.write(\"".addslashes(stripSlashes($listtemp_r[0].$votetext.$listtemp_r[2]))."\");";
	WriteFiletext_n($file,$votetext);
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//���÷��ʶ�
$moreportpid=0;
if($enews=='ReVoteJs_all')
{
	$moreportpid=Moreport_hDoSetSelfPath(0);
}
//����ͶƱ
if($enews=="AddVote")
{
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	AddVote($title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//�޸�ͶƱ
elseif($enews=="EditVote")
{
	$voteid=$_POST['voteid'];
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	EditVote($voteid,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//ɾ��ͶƱ
elseif($enews=="DelVote")
{
	$voteid=$_GET['voteid'];
	DelVote($voteid,$logininid,$loginin);
}
//����ˢ��ͶƱJS
elseif($enews=="ReVoteJs_all")
{
	ReVoteJs_all($_GET['start'],$_GET['from'],$logininid,$loginin);
}

$search=$ecms_hashur['ehref'];
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//ÿҳ��ʾ����
$page_line=12;//ÿҳ��ʾ������
$offset=$page*$line;//��ƫ����
$query="select voteid,title,addtime from {$dbtbpre}enewsvote";
$num=$empire->num($query);//ȡ��������
$query=$query." order by voteid desc limit $offset,$line";
$sql=$empire->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListVote.php".$ecms_hashur['whehref'].">����ͶƱ</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ͶƱ</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">λ��: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="����ͶƱ" onclick="self.location.href='AddVote.php?enews=AddVote<?=$ecms_hashur['ehref']?>';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="32%" height="25"><div align="center">ͶƱ����</div></td>
    <td width="18%" height="25"><div align="center">����ʱ��</div></td>
    <td width="26%" height="25">���õ�ַ</td>
    <td width="19%" height="25"><div align="center">����</div></td>
  </tr>
  <?
  while($r=$empire->fetch($sql))
  {
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"><?=$r[voteid]?></div></td>
    <td height="25"><?=$r[title]?></td>
    <td height="25"><div align="center"><?=$r[addtime]?></div>
      </td>
    <td height="25"><input name="textfield" type="text" value="<?=$public_r[newsurl]?>d/js/vote/vote<?=$r[voteid]?>.js">
      [<a href="../view/js.php?js=vote<?=$r[voteid]?>&p=vote<?=$ecms_hashur['ehref']?>" target="_blank">Ԥ��</a>]</td>
    <td height="25"><div align="center">[<a href="AddVote.php?enews=EditVote&voteid=<?=$r[voteid]?><?=$ecms_hashur['ehref']?>">�޸�</a>] 
        [<a href="ListVote.php?enews=DelVote&voteid=<?=$r[voteid]?><?=$ecms_hashur['href']?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF">
    <td height="25" colspan="5">&nbsp;<?=$returnpage?></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="5"><font color="#666666">˵��:ģ������ʾͶƱ�ĵط�����:&lt;script 
      src=���õ�ַ&gt;&lt;/script&gt; ���� [phomevote]ͶƱID[/phomevote]</font></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
