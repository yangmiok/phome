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

//���ذ�ť�¼�
function ToReturnDoFilepButton($doing,$tranfrom,$field,$file,$filename,$fileid,$filesize,$filetype,$no,$type){
	if($doing==1)//���ص�ַ
	{
		$bturl="ChangeFile1(1,'".$file."');";
		$button="<input type=button name=button value='ѡ��' onclick=\"javascript:".$bturl."\">";
	}
	elseif($doing==2)//���ص�ַ
	{
		$bturl="ChangeFile1(2,'".$file."');";
		$button="<input type=button name=button value='ѡ��' onclick=\"javascript:".$bturl."\">";
	}
	else
	{
		if($tranfrom==1)//�༭��ѡ��
		{
			$bturl="EditorChangeFile('".$file."','".addslashes($filename)."','".$filetype."','".$filesize."','".addslashes($no)."');";
			$button="<input type=button name=button value='ѡ��' onclick=\"javascript:".$bturl."\">";
		}
		elseif($tranfrom==2)//�����ֶ�ѡ��
		{
			$bturl="SFormIdChangeFile('".addslashes($no)."','$file','$filesize','$filetype','$field');";
			$button="<input type=button name=button value='ѡ��' onclick=\"javascript:".$bturl."\">";
		}
		else
		{
			$bturl="InsertFile('".$file."','".addslashes($filename)."','".$fileid."','".$filesize."','".$filetype."','','".$type."');";
			$button="<input type=button name=button value='����' onclick=\"javascript:".$bturl."\">";
		}
	}
	$retr['button']=$button;
	$retr['bturl']=$bturl;
	return $retr;
}

$classid=(int)$_GET['classid'];
$infoid=(int)$_GET['infoid'];
$filepass=(int)$_GET['filepass'];
$type=(int)$_GET['type'];
$modtype=(int)$_GET['modtype'];
$fstb=(int)$_GET['fstb'];
$doing=(int)$_GET['doing'];
$field=RepPostVar($_GET['field']);
$tranfrom=ehtmlspecialchars($_GET['tranfrom']);
$fileno=ehtmlspecialchars($_GET['fileno']);
$doecmspage=RepPostStr($_GET['doecmspage'],1);
if(empty($field))
{
	$field="ecms";
}
include('eshoweditor.php');

$search="&classid=$classid&infoid=$infoid&filepass=$filepass&type=$type&modtype=$modtype&fstb=$fstb&doing=$doing&tranfrom=$tranfrom&field=$field&fileno=$fileno&doecmspage=$doecmspage".$ecms_hashur['ehref'];

//��Ŀ¼
$basepath=eReturnEcmsMainPortPath()."d/file";//moreport
$filepath=ehtmlspecialchars($_GET['filepath']);
if(strstr($filepath,".."))
{
	$filepath="";
}
$filepath=eReturnCPath($filepath,'');
$openpath=$basepath."/".$filepath;
if(!file_exists($openpath))
{
	$openpath=$basepath;
}
$hand=@opendir($openpath);
db_close();
$empire=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>ѡ���ļ�</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function InsertFile(filename,fname,fileid,filesize,filetype,fileno,dotype){
	var vstr="";
	if(dotype!=undefined)
	{
		vstr=showModalDialog("infoeditor/epage/insertfile.php?<?=$ecms_hashur['ehref']?>&ecms="+dotype+"&fname="+fname+"&fileid="+fileid+"&filesize="+filesize+"&filetype="+filetype+"&filename="+filename, "", "dialogWidth:45.5em; dialogHeight:27.5em; status:0");
		if(vstr==undefined)
		{
			return false;
		}
	}
	parent.opener.DoFile(vstr);
	parent.window.close();
}
function TInsertFile(vstr){
	parent.opener.DoFile(vstr);
	parent.window.close();
}
//ѡ���ֶ�
function ChangeFile1(obj,str){
<?php
if(strstr($field,'.'))
{
?>
	parent.<?=$field?>.value=str;
<?php
}
else
{
?>
	if(obj==1)
	{
		parent.opener.document.add.<?=$field?>.value=str;
	}
	else
	{
		parent.opener.document.form1.<?=$field?>.value=str;
	}
<?php
}
?>
	parent.window.close();
}
//�༭��ѡ��
function EditorChangeFile(fileurl,filename,filetype,filesize,name){
	var returnstr;
	returnstr=fileurl;
	<?php
	$useeditor_r=ECMS_EditorReturnType('');
	if($useeditor_r['ftype']==0)
	{
	?>
	returnstr=fileurl+'##'+name+'##'+filesize;
	<?php
	}
	?>
	window.parent.opener.<?=$useeditor_r['jsfun']?>(returnstr);
	parent.window.close();
}
//������ѡ��
function SFormIdChangeFile(name,url,filesize,filetype,idvar){
	parent.opener.doSpChangeFile(name,url,filesize,filetype,idvar);
	parent.window.close();
}
//ȫѡ
function CheckAll(form){
  for(var i=0;i<form.elements.length;i++)
  {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
}
//��������ҳ��
function ReloadChangeFilePage(){
	self.location.reload();
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td> ��ǰĿ¼��<strong>/ 
      <?=$filepath?>
      </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href="#ecms" onclick="javascript:history.go(-1);">������һҳ</a>]</td>
  </tr>
</table>
<br>
  
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="dofile" method="post" action="../ecmsfile.php">
  <?=$ecms_hashur['form']?>
    <input name="enews" type="hidden" id="enews" value="DelPathFile">
	<input type=hidden name=doecmspage value="<?=$doecmspage?>">
    <tr class="header">
      <td><div align="center">ѡ��</div></td>
      <td height="25"><div align="center">�ļ���</div></td>
      <td><div align="center">��С</div></td>
      <td><div align="center">����</div></td>
      <td><div align="center">�޸�ʱ��</div></td>
    </tr>
    <?php
	$efileurl=eReturnFileUrl(1);
	while($file=@readdir($hand))
	{
		if(empty($filepath))
		{
			$truefile=$file;
		}
		else
		{
			$truefile=$filepath."/".$file;
		}
		if($file=="."||$file=="..")
		{
			continue;
		}
		//Ŀ¼
		$pathfile=$openpath."/".$file;
		if(is_dir($pathfile))
		{
			$filelink="'filep.php?filepath=".$truefile.$search."'";
			$filename=$file;
			$img="../../data/images/dir/folder.gif";
			$target="";
			//����ʱ��
			$ftime=@filemtime($pathfile);
			$filetime=date("Y-m-d H:i:s",$ftime);
			$filesize='<Ŀ¼>';
			$filetype='�ļ���';
			$button="";
		}
		//�ļ�
		else
		{
			$filelink="'".eReturnFileUrl().$truefile."'";
			$filename=$file;
			$ftype=GetFiletype($file);
			$img='../../data/images/dir/'.substr($ftype,1,strlen($ftype))."_icon.gif";
			if(!file_exists($img))
			{
				$img='../../data/images/dir/unknown_icon.gif';
			}
			$target=" target='_blank'";
			//����ʱ��
			$ftime=@filemtime($pathfile);
			$filetime=date("Y-m-d H:i:s",$ftime);
			//�ļ���С
			$fsize=@filesize($pathfile);
			$filesize=ChTheFilesize($fsize);
			//�ļ�����
			if(strstr($ecms_config['sets']['tranpicturetype'],','.$ftype.','))
			{
				$filetype='ͼƬ';
			}
			elseif(strstr($ecms_config['sets']['tranflashtype'],','.$ftype.','))
			{
				$filetype='FLASH';
			}
			elseif(strstr($ecms_config['sets']['mediaplayertype'],','.$ftype.',')||strstr($ecms_config['sets']['realplayertype'],','.$ftype.','))
			{
				$filetype='��Ƶ';
			}
			else
			{
				$filetype='����';
			}
			$furl=$efileurl.$truefile;
			$buttonr=ToReturnDoFilepButton($doing,$tranfrom,$field,$furl,$file,0,$filesize,$ftype,'',$type);
			$button=$buttonr['button'];
			$buttonurl=$buttonr['bturl'];
		}
	 ?>
    <tr bgcolor="#FFFFFF"> 
      <td width="9%"> 
        <div align="center">
          <?=$button?>
        </div></td>
      <td width="39%" height="25"><img src="<?=$img?>" width="23" height="22"><a href=<?=$filelink?><?=$target?>> 
        <?=$filename?>
        </a></td>
      <td width="20%"> 
        <div align="right"><?=$filesize?></div></td>
      <td width="11%"> 
        <div align="center"><?=$filetype?></div></td>
      <td width="21%"> 
        <div align="center"><?=$filetime?></div></td>
    </tr>
    <?
	}
	@closedir($hand);
	?>
  </form>
</table>
</body>
</html>