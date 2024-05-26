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

$enews=ehtmlspecialchars($_GET['enews']);
$classid=(int)$_GET['classid'];
if(empty($class_r[$classid][classid]))
{
	printerror("ErrorUrl","history.go(-1)");
}
//��֤Ȩ��
$doselfinfo=CheckLevel($logininid,$loginin,$classid,"news");
if(!$class_r[$classid][tbname]||!$class_r[$classid][classid])
{
	printerror("ErrorUrl","history.go(-1)");
}
//���ռ���Ŀ
if(!$class_r[$classid]['islast'])
{
	printerror("AddInfoErrorClassid","history.go(-1)");
}
$fun_r['AdminInfo']='������Ϣ';
$bclassid=$class_r[$classid][bclassid];
$id=(int)$_GET['id'];
//������֤��
if($enews=="AddNews")
{
	if(!$doselfinfo['doaddinfo'])//����Ȩ��
	{
		printerror("NotAddInfoLevel","history.go(-1)");
	}
	$filepass=time();
	$word='������Ϣ';
	$ecmsfirstpost=1;
}
else
{
	if(!$doselfinfo['doeditinfo'])//�༭Ȩ��
	{
		printerror("NotEditInfoLevel","history.go(-1)");
	}
	$filepass=$id;
	$word='�޸���Ϣ';
	$ecmsfirstpost=0;
}
//���
$ecmscheck=(int)$_GET['ecmscheck'];
$addecmscheck='';
$indexchecked=1;
if($ecmscheck)
{
	$addecmscheck='&ecmscheck='.$ecmscheck;
	$indexchecked=0;
}
//ģ��
$modid=$class_r[$classid][modid];
$enter=$emod_r[$modid]['enter'];
//����
$url=AdminReturnClassLink($classid).'&nbsp;>&nbsp;'.$word;
//������
$ygroup='';
$vgsql=$empire->query("select vgid,gname from {$dbtbpre}enewsvg order by vgid");
while($vgr=$empire->fetch($vgsql))
{
	$ygroup.="<option value=-".$vgr['vgid'].">".$vgr['gname']."</option>";
}
if($ygroup)
{
	$ygroup="<option value=''>--- ������ ---</option>".$ygroup."<option value=''>--- ��Ա�� ---</option>";
}
//��Ա��
$sql1=$empire->query("select groupid,groupname from {$dbtbpre}enewsmembergroup order by level");
while($l_r=$empire->fetch($sql1))
{
	$ygroup.="<option value=".$l_r[groupid].">".$l_r[groupname]."</option>";
}
if($enews=="AddNews")
{
	$group=str_replace(" value=".$class_r[$classid][groupid].">"," value=".$class_r[$classid][groupid]." selected>",$ygroup);
}
//��ʼ������
$r=array();
$newstime=time();
$r[newstime]=date("Y-m-d H:i:s");
$todaytime=$r[newstime];
$r[checked]=$class_r[$classid][checked];
$r[newspath]=date($class_r[$classid][newspath]);
$r[onclick]=0;
$r[userfen]=0;
$titlefontb="";
$titlefonti="";
$titlefonts="";
$voteeditnum=8;
$voter[width]=500;
$voter[height]=300;
$voter[dotime]='0000-00-00';
$r[dokey]=1;
$titleurl='';
if($public_r['onclickrnd'])
{
	$onclick_rndr=explode(',',$public_r['onclickrnd']);
	$r[onclick]=rand(intval($onclick_rndr[0]),intval($onclick_rndr[1]));
	$r[totaldown]=$r[onclick];
}
else
{
	$r[totaldown]=0;
	$r[onclick]=0;
}
//----------- ����ģ�ͳ�ʼ�� -----------
//���ص�ַǰ׺
if(strstr($enter,',downpath,')||strstr($enter,',onlinepath,'))
{
	$downurlqz="";
	$newdownqz="";
	$downsql=$empire->query("select urlname,url,urlid from {$dbtbpre}enewsdownurlqz order by urlid");
	while($downr=$empire->fetch($downsql))
	{
		$downurlqz.="<option value='".$downr[url]."'>".$downr[urlname]."</option>";
		$newdownqz.="<option value='".$downr[urlid]."'>".$downr[urlname]."</option>";
	}
}
//html�༭��
$loadeditorjs='';
if($emod_r[$modid]['editorf']&&$emod_r[$modid]['editorf']!=',')
{
	include('ecmseditor/eshoweditor.php');
	$loadeditorjs=ECMS_ShowEditorJS('ecmseditor/infoeditor/');
}

//Ԥ��ͶƱ
if($enews=="AddNews")
{
	$infoclassr=$empire->fetch1("select definfovoteid from {$dbtbpre}enewsclass where classid='$classid'");
	$definfovoteid=0;
	if($infoclassr['definfovoteid'])
	{
		$definfovoteid=$infoclassr['definfovoteid'];
	}
	elseif($emod_r[$modid]['definfovoteid'])
	{
		$definfovoteid=$emod_r[$modid]['definfovoteid'];
	}
	if($definfovoteid)
	{
		//ͶƱ
		$voter=$empire->fetch1("select * from {$dbtbpre}enewsvotemod where voteid='$definfovoteid'");
		if($voter['voteid']&&$voter[votetext])
		{
			$d_record=explode("\r\n",$voter[votetext]);
			for($i=0;$i<count($d_record);$i++)
			{
				$j=$i+1;
				$d_field=explode("::::::",$d_record[$i]);
				$allvote.="<tr><td width='9%'><div align=center>".$j."</div></td><td width='65%'><input name=vote_name[] type=text value='".$d_field[0]."' size=30></td><td width='26%'><input name=vote_num[] type=text value='".$d_field[1]."' size=6></td></tr>";
			}
			$voteeditnum=$j;
			$allvote="<table width='100%' border=0 cellspacing=1 cellpadding=3>".$allvote."</table>";
		}
	}
}

//-----------------------------------------�޸���Ϣ
if($enews=="EditNews")
{
	//������
	$index_r=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id' limit 1");
	if(!$index_r['id']||$index_r['classid']!=$classid)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//���ر�
	$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
	//����
	$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
	//ǩ����
	if($r[isqf])
	{
		$wfinfor=$empire->fetch1("select tstatus,checktno from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid' limit 1");
	}
	//ֻ�ܱ༭�Լ�����Ϣ
	if($doselfinfo['doselfinfo']&&($r[userid]<>$logininid||$r[ismember]))
	{
		printerror("NotDoSelfinfo","history.go(-1)");
	}
	//�������Ϣ�����޸�
	if($doselfinfo['docheckedit']&&$index_r['checked'])
	{
		printerror("NotEditCheckInfoLevel","history.go(-1)");
	}
	//���ر���Ϣ
	$infodatatb=ReturnInfoDataTbname($class_r[$classid][tbname],$index_r['checked'],$r['stb']);
	//����
	$finfor=$empire->fetch1("select ".ReturnSqlFtextF($modid)." from ".$infodatatb." where id='$id' limit 1");
	$r=array_merge($r,$finfor);
	//ʱ��
	$r['checked']=$index_r['checked'];
	$newstime=$r['newstime'];
	$r['newstime']=date("Y-m-d H:i:s",$r['newstime']);
	//���ӵ�ַ
	$titleurl=$r['titleurl'];
	if(!$r['isurl'])
	{
		$r['titleurl']='';
	}
	//��Ա��
	$group=str_replace(" value=".$r[groupid].">"," value=".$r[groupid]." selected>",$ygroup);
	//���ݴ��ı�
	$savetxtf=$emod_r[$modid]['savetxtf'];
	$newstext_url='';
	if($savetxtf)
	{
		$newstext_url=$r[$savetxtf];
		$r[$savetxtf]=GetTxtFieldText($r[$savetxtf]);
    }
	//��������
	if(strstr($r[titlefont],','))
	{
		$tfontr=explode(',',$r[titlefont]);
		$r[titlecolor]=$tfontr[0];
		$r[titlefont]=$tfontr[1];
	}
	if(strstr($r[titlefont],"b|"))
	{
		$titlefontb=" checked";
	}
	if(strstr($r[titlefont],"i|"))
	{
		$titlefonti=" checked";
	}
	if(strstr($r[titlefont],"s|"))
	{
		$titlefonts=" checked";
	}
	//ͶƱ
	$pubid=ReturnInfoPubid($classid,$id);
	$voter=$empire->fetch1("select * from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	if($voter['id']&&$voter[votetext])
	{
		$d_record=explode("\r\n",$voter[votetext]);
		for($i=0;$i<count($d_record);$i++)
		{
			$j=$i+1;
			$d_field=explode("::::::",$d_record[$i]);
			$allvote.="<tr><td width='9%'><div align=center>".$j."</div></td><td width='65%'><input name=vote_name[] type=text value='".$d_field[0]."' size=30></td><td width='26%'><input name=vote_num[] type=text value='".$d_field[1]."' size=6><input type=hidden name=vote_id[] value=".$j."><input type=checkbox name=delvote_id[] value=".$j.">ɾ��</td></tr>";
		}
		$voteeditnum=$j;
		$allvote="<table width='100%' border=0 cellspacing=1 cellpadding=3>".$allvote."</table>";
	}
}
//�������
$cttidswhere='';
$tts='';
$caddr=$empire->fetch1("select ttids from {$dbtbpre}enewsclassadd where classid='$classid'");
if($caddr['ttids']!='-')
{
	if($caddr['ttids']&&$caddr['ttids']!=',')
	{
		$cttidswhere=' and typeid in ('.substr($caddr['ttids'],1,-1).')';
	}
	$ttsql=$empire->query("select typeid,tname from {$dbtbpre}enewsinfotype where mid='$modid'".$cttidswhere." order by myorder");
	while($ttr=$empire->fetch($ttsql))
	{
		$select='';
		if($ttr[typeid]==$r[ttid])
		{
			$select=' selected';
		}
		$tts.="<option value='$ttr[typeid]'".$select.">$ttr[tname]</option>";
	}
}
//����ģ��
$t_sql=$empire->query("select tempid,tempname from ".GetTemptb("enewsnewstemp")." order by modid,tempid");
while($nt=$empire->fetch($t_sql))
{
	if($nt[tempid]==$r[newstempid])
	{
		$select=" selected";
	}
	else
	{
		$select="";
	}
	$newstemp.="<option value=".$nt[tempid].$select.">".$nt[tempname]."</option>";
}
//ģ��
$votetemp="";
$vtsql=$empire->query("select tempid,tempname from ".GetTemptb("enewsvotetemp")." order by tempid");
while($vtr=$empire->fetch($vtsql))
{
	if($voter[tempid]==$vtr[tempid])
	{
		$select=" selected";
	}
	else
	{
		$select="";
	}
	$votetemp.="<option value='".$vtr[tempid]."'".$select.">".$vtr[tempname]."</option>";
}
//ͬʱ����
if(empty($voter['copyids'])||$voter['copyids']=='1')
{
	$copyclassidshowiframe='<IFRAME frameBorder="0" id="showclassnav" name="showclassnav" scrolling="no" src="ShowClassNav.php?ecms=1'.$ecms_hashur['ehref'].'" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>';
	$copyclassids='<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
              <tr>
                <td>ͬʱ������������Ŀ: <input type="checkbox" name="copyinfotitleurl" value="1">������������</td>
              </tr>
              <tr>
                <td height="25" bgcolor="#FFFFFF" id="copyinfoshowclassnav"></td>
              </tr>
            </table>';
}
else
{
	$copyclassidshowiframe='';
	$copyclassids='<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
              <tr>
                <td>ͬʱ������������Ŀ:</td>
              </tr>
              <tr>
                <td height="25" bgcolor="#FFFFFF" id="copyinfoshowclassnav">����Ϣ��ͬ��������������Ŀ,��ϢID:<br>'.$voter[copyids].'</td>
              </tr>
            </table>';
}
//���ļ�
$modfile="../data/html/".$modid.".php";
//��Ŀ����
$getcurlr['classid']=$classid;
$classurl=sys_ReturnBqClassname($getcurlr,9);
//��ǰʹ�õ�ģ����
$thegid=GetDoTempGid();
$phpmyself=urlencode(eReturnSelfPage(1));
//����ͷ�����Ƽ���������
$ftnr=ReturnFirsttitleNameList($r['firsttitle'],$r['isgood']);

//��Ϣ״̬
$einfochecked=$index_r['checked'];
$einfoismember=$r['ismember'];

//------ �༭��������ʾ ------

$seteshoweditorhtml=3;

$eshoweditorhtml=0;
if($seteshoweditorhtml&&$r['id'])
{
	if($seteshoweditorhtml==1)//����
	{
		$eshoweditorhtml=1;
	}
	elseif($seteshoweditorhtml==2)//����δ���
	{
		if(!$einfochecked)
		{
			$eshoweditorhtml=1;
		}
	}
	elseif($seteshoweditorhtml==3)//����Ͷ��
	{
		if($einfoismember)
		{
			$eshoweditorhtml=1;
		}
	}
	elseif($seteshoweditorhtml==4)//����δ���Ͷ��
	{
		if($einfoismember&&!$einfochecked)
		{
			$eshoweditorhtml=1;
		}
	}
	else
	{
		$eshoweditorhtml=1;
	}
}

//------ �༭��������ʾ ------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?=$word?></title>
<link rel="stylesheet" href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" type="text/css">
<link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="adminstyle/<?=$loginadminstyleid?>/tab.winclassic.css" disabled="disabled" /> 
<!-- the id is not needed. It is used here to be able to change css file at runtime -->
<style type="text/css"> 
   .dynamic-tab-pane-control .tab-page { 
          width:                98%;
 } 
  .dynamic-tab-pane-control .tab-page .dynamic-tab-pane-control .tab-page { 
         height:                150px; 
 } 
  form { 
         margin:        0; 
         padding:        0; 
 } 
  /* over ride styles from webfxlayout */ 
  .dynamic-tab-pane-control h2 { 
         font-size:12px;
		 font-weight:normal;
		 text-align:        center; 
         width:                auto;
		 height:            20; 
 } 
   .dynamic-tab-pane-control h2 a { 
         display:        inline; 
         width:                auto; 
 } 
  .dynamic-tab-pane-control a:hover { 
         background: transparent; 
 } 
  </style>
 <script type="text/javascript" src="../data/images/tabpane.js"></script> <script type="text/javascript"> 
  function setLinkSrc( sStyle ) { 
         document.getElementById( "luna-tab-style-sheet" ).disabled = sStyle != "luna"; 
  
         //document.documentElement.style.background = "";
         //document.body.style.background = sStyle == "webfx" ? "white" : "ThreeDFace"; 
 } 
function chgBg(obj,color){
 if (document.all || document.getElementById)
   obj.style.backgroundColor=color;
 else if (document.layers)
   obj.bgColor=color;
}
  setLinkSrc( "luna" ); 
</script>
<script>
function dovoteadd(){
	var i;
	var str="";
	var oldi=0;
	var j=0;
	oldi=parseInt(document.add.v_editnum.value);
	for(i=1;i<=document.add.v_vote_num.value;i++)
	{
		j=i+oldi;
		str=str+"<tr><td width='9%' height=20> <div align=center>"+j+"</div></td><td width='65%'> <div align=center><input type=text name=vote_name[] size=30></div></td><td width='26%'> <div align=center><input type=text name=vote_num[] value=0 size=6></div></td></tr>";
	}
	document.getElementById('addvote').innerHTML="<table width='100%' border=0 cellspacing=1 cellpadding=3>"+str+"</table>";
}

function doSpChangeFile(name,url,filesize,filetype,idvar){
	document.getElementById(idvar).value=url;
	if(document.add.filetype!=null)
	{
		if(document.add.filetype.value=='')
		{
			document.add.filetype.value=filetype;
		}
	}
	if(document.add.filesize!=null)
	{
		if(document.add.filesize.value=='')
		{
			document.add.filesize.value=filesize;
		}
	}
}

function SpOpenChFile(type,field){
	window.open('ecmseditor/FileMain.php?<?=$ecms_hashur['ehref']?>&classid=<?=$classid?>&infoid=<?=$id?><?=$addecmscheck?>&filepass=<?=$filepass?>&type='+type+'&sinfo=1&tranfrom=2&field='+field,'','width=700,height=550,scrollbars=yes');
}

//�ϴ��฽��ʱ,ͼ��
function eTranMoreForMorepic(htmlstr,fnum){
	var morepicdiv=document.getElementById("defmorepicid").innerHTML;
	var thismorepicnum=parseInt(document.add.morepicnum.value);
	var enews="<?=$enews?>";
	if(enews=='AddNews')
	{
		if(document.add.havetmpic.value==0)
		{
			document.getElementById("defmorepicid").innerHTML+=htmlstr;
			document.add.morepicnum.value=thismorepicnum+fnum;
		}
		else
		{
			document.getElementById("defmorepicid").innerHTML+=htmlstr;
			document.add.morepicnum.value=thismorepicnum+fnum;
		}
	}
	else
	{
		document.getElementById("defmorepicid").innerHTML+=htmlstr;
		document.add.morepicnum.value=thismorepicnum+fnum;
	}
	document.getElementById("addpicdown").innerHTML="";
	document.add.havetmpic.value=1;
}

</script>
<script type="text/javascript" src="ecmseditor/js/jstime/WdatePicker.js"></script>
<script type="text/javascript" src="ecmseditor/js/jscolor/jscolor.js"></script>
<script src="../data/html/postinfo.js"></script>
<script>
function bs(){
	var f=document.add;
	if(f.title.value.length==0){alert("���⻹ûд");f.title.focus();return false;}
}
function foreColor(){
  if(!Error())	return;
  var arr = showModalDialog("../data/html/selcolor.html", "", "dialogWidth:296px; dialogHeight:280px; status:0");
  if (arr != null) document.add.titlecolor.value=arr;
  else document.add.titlecolor.focus();
}
function FieldChangeColor(obj){
  if(!Error())	return;
  var arr = showModalDialog("../data/html/selcolor.html", "", "dialogWidth:296px; dialogHeight:280px; status:0");
  if (arr != null) obj.value=arr;
  else obj.focus();
}
</script>
<?=$loadeditorjs?>
</head>

<body bgcolor="#FFFFFF" text="#000000" onload="document.add.title.focus();">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="55%" height="25">λ�ã� 
      <?=$url?>
    </td>
    <td width="45%"><div align="right">
	<?php
	if($enews=='EditNews'&&$r['eckuid'])
	{
		$eckuid=(int)$r['eckuid'];
		$eckuser_r=$empire->fetch1("select username,wname from {$dbtbpre}enewsuser where userid='$eckuid'");
		if($eckuser_r['username'])
		{
		?>
			[�����UID��<b><?=$eckuid?></b>�������UNAME��<b><?=$eckuser_r['username']?></b>]&nbsp;&nbsp;&nbsp;
		<?php
		}
	}
	?>
	<?=$enews=='EditNews'?'[<a href="user/ListDolog.php?classid='.$classid.'&id='.$id.$ecms_hashur['ehref'].'" target="_blank">�鿴����Ϣ������־</a>]':''?>
      </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <form name="searchinfo" method="GET" action="ListNews.php">
  <?=$ecms_hashur['eform']?>
    <tr> 
      <td width="42%" title="������Ϣ��ʹ�ñ���������Ϣ��ʾ��ǰ̨"> <select name="dore">
          <option value="1">ˢ�µ�ǰ��Ŀ</option>
          <option value="2">ˢ����ҳ</option>
          <option value="3">ˢ�¸���Ŀ</option>
          <option value="4">ˢ�µ�ǰ��Ŀ�븸��Ŀ</option>
          <option value="5">ˢ�¸���Ŀ����ҳ</option>
          <option value="6" selected>ˢ�µ�ǰ��Ŀ������Ŀ����ҳ</option>
        </select> <input type="button" name="Submit12" value="�ύ" onclick="self.location.href='ecmsinfo.php?<?=$ecms_hashur['href']?>&enews=AddInfoToReHtml<?=$addecmscheck?>&classid=<?=$classid?>&dore='+document.searchinfo.dore.value;"> 
      </td>
      <td width="58%"><div align="right">[<font color="#ffffff"><a href=../../ target=_blank>Ԥ����ҳ</a></font>] 
          [<font color="#ffffff"><a href="<?=$classurl?>" target=_blank>Ԥ����Ŀ</a></font>] 
          [<font color="#ffffff"><a href="file/ListFile.php?type=9&classid=<?=$classid?><?=$ecms_hashur['ehref']?>">��������</a></font>] 
          [<a href="AddClass.php?enews=EditClass&classid=<?=$classid?><?=$ecms_hashur['ehref']?>">��Ŀ����</a>] 
          [<a href="ecmschtml.php?enews=ReAllNewsJs&from=<?=$phpmyself?><?=$ecms_hashur['ehref']?>">ˢ��������ϢJS</a>] 
        </div></td>
    </tr>
	</form>
	<?php
	if($enews=='EditNews')
	{
	?>
	<form name="doinfoform" method="post" action="ecmsinfo.php" onsubmit="return confirm('ȷ��Ҫִ�д˲���?');">
		<?=$ecms_hashur['form']?>
    <tr bgcolor="#FFFFFF"> 
      <td height="32" colspan="2"> <div align="right">ԭ��: 
          <input name="causetext" type="text" id="causetext">
          <input type="submit" name="Submit3" value="���ͨ��" onclick="document.doinfoform.doing.value='2';">
          <input type="submit" name="Submit32" value="ȡ�����" onclick="document.doinfoform.doing.value='3';">
          <input type="submit" name="Submit33" value="ɾ��" onclick="document.doinfoform.doing.value='1';">
          <font color="#666666">������ԭ���ʾ��֪ͨ��Ա��</font>
          <input name="enews" type="hidden" id="enews" value="DoInfoAndSendNotice">
		  <input name="bclassid" type="hidden" id="bclassid" value="<?=$bclassid?>">
          <input name="classid" type="hidden" id="classid" value="<?=$classid?>">
          <input name="id" type="hidden" id="id" value="<?=$id?>">
          <input name="ecmsfrom" type="hidden" id="ecmsfrom" value="<?=RepPostStrUrl($_SERVER['HTTP_REFERER'])?>">
          <input name="doing" type="hidden" id="doing">
          <input name="ecmscheck" type="hidden" id="ecmscheck" value="<?=$ecmscheck?>">
        </div></td>
    </tr>
	</form>
	<?php
	}
	?>
</table>
<br>
<form name="add" method="post" enctype="multipart/form-data" action="ecmsinfo.php" onsubmit="return EmpireCMSInfoPostFun(document.add,'<?=$modid?>');">
<?=$ecms_hashur['form']?>
<div class="tab-pane" id="TabPane1">
	<script type="text/javascript">
	tb1 = new WebFXTabPane( document.getElementById( "TabPane1" ) );
	</script>
	<div class="tab-page" id="baseinfo">        
		<h2 class="tab">&nbsp;<font class=tabcolor>������Ϣ</font>&nbsp;</h2>
		<script type="text/javascript">tb1.addTabPage( document.getElementById( "baseinfo" ) );</script>
		<table width="100%" align="center" cellpadding="3" cellspacing="1" class="tableborder">
			<tr class="header"> 
				<td width="16%" height="25">
					<div align="left"><?=$word?></div>
				</td>
				<td>
					<input type="submit" name="addnews2" value="�ύ"> <input type="reset" name="Submit23" value="����">
					<input type=hidden value=<?=$enews?> name=enews> <input type=hidden value=<?=$classid?> name=classid> 
					<input type=hidden value=<?=$bclassid?> name=bclassid> <input name=id type=hidden value=<?=$id?>> 
					<input type=hidden value="<?=$filepass?>" name=filepass> <input type=hidden value="<?=$r[username]?>" name=username> 
					<input name="oldfilename" type="hidden" value="<?=$r[filename]?>">  
					<input name="oldgroupid" type="hidden" value="<?=$r[groupid]?>"> 
					<input name="oldchecked" type="hidden" value="<?=$r[checked]?>">  
					<input name="newstext_url" type="hidden" value="<?=$newstext_url?>">
					<input name="ecmsfrom" type="hidden" value="<?=RepPostStrUrl($_SERVER['HTTP_REFERER'])?>">
					<input name="ecmsnfrom" type="hidden" value="<?=RepPostStrUrl($_GET['ecmsnfrom'])?>">
					<input name="fstb" type="hidden" value="<?=$r[fstb]?>">
					<input name="oldttid" type="hidden" value="<?=$r[ttid]?>">
					<input name="ecmscheck" type="hidden" id="ecmscheck" value="<?=$ecmscheck?>">
            <input name="ztids" type="hidden" id="ztids">
            <input name="zcids" type="hidden" id="zcids">
            <input name="oldztids" type="hidden" id="oldztids">
            <input name="oldzcids" type="hidden" id="oldzcids">
			<input type="hidden" name="havetmpic" value="0"></td>
			</tr>
		</table>
		<?php
		include($modfile);
		?>
	</div>
	<div class="tab-page" id="spsetting"> 
		<h2 class="tab">&nbsp;<font class=tabcolor>ѡ������</font>&nbsp;</h2>
        <script type="text/javascript">tb1.addTabPage( document.getElementById( "spsetting" ) );</script>
		<table width=100% align=center cellpadding=3 cellspacing=1 class="tableborder">
			<tr><td class=header>ѡ������</td></tr>
			<tr>
				<td bgcolor='#ffffff'> 
					<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
              <tr> 
                <td height="25" bgcolor="#FFFFFF">�ö�����: 
                  <select name="istop">
                    <option value="0"<?=$r[istop]==0?' selected':''?>>���ö�</option>
                    <option value="1"<?=$r[istop]==1?' selected':''?>>һ���ö�</option>
                    <option value="2"<?=$r[istop]==2?' selected':''?>>�����ö�</option>
                    <option value="3"<?=$r[istop]==3?' selected':''?>>�����ö�</option>
                    <option value="4"<?=$r[istop]==4?' selected':''?>>�ļ��ö�</option>
                    <option value="5"<?=$r[istop]==5?' selected':''?>>�弶�ö�</option>
                    <option value="6"<?=$r[istop]==6?' selected':''?>>�����ö�</option>
                    <option value="7"<?=$r[istop]==7?' selected':''?>>�߼��ö�</option>
                    <option value="8"<?=$r[istop]==8?' selected':''?>>�˼��ö�</option>
					<option value="9"<?=$r[istop]==9?' selected':''?>>�ż��ö�</option>
                  </select>
                  ����ģ��: 
                  <select name="newstempid">
                    <option value="0"<?=$r[newstempid]==0?' selected':''?>>ʹ��Ĭ��ģ��</option>
                    <?=$newstemp?>
                  </select> <input type="button" name="Submit62222" value="��������ģ��" onclick="window.open('template/ListNewstemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"> 
                </td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF">Ȩ������: 
                  <select name="groupid">
                    <option value="0">�ο�</option>
                    <?=$group?>
                  </select>
                  �鿴�۳�����: 
                  <input name="userfen" type="text" value="<?=$r[userfen]?>" size="6">
                  , 
                  <input type=checkbox name=closepl value=1<?=$r[closepl]==1?" checked":""?>>
                  �ر����� </td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF">�����&nbsp;&nbsp;&nbsp;: 
                  <input name="onclick" type="text" id="onclick" value="<?=$r[onclick]?>">
                  ������&nbsp;&nbsp;&nbsp;: 
                  <input name="totaldown" type="text" id="totaldown" value="<?=$r[totaldown]?>"></td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF"> �ļ���&nbsp;&nbsp;&nbsp;: 
                  <input name="newspath" type="text" id="newspath" value="<?=$r[newspath]?>"<?=$doselfinfo['doinfofile']?'':' readonly'?>>
                  / 
                  <input name="filename" type="text" value="<?=$r[filename]?>"<?=$doselfinfo['doinfofile']?'':' readonly'?>>
                  <font color="#666666">(����Ŀ¼/�ļ���)</font></td>
              </tr>
              <?php
			  if(strstr($public_r['usetags'],','.$modid.','))
			  {
			  	$infotag_readonly='';
				$infotag_copykeyboard='&nbsp;&nbsp;<input type="button" name="Submit3" value="���ƹؼ���" onclick="document.add.infotags.value=document.add.keyboard.value;">';
			  	if(strstr($public_r['chtags'],','.$modid.','))
				{
					$infotag_readonly=' readonly';
					$infotag_copykeyboard='&nbsp;&nbsp;<input type="button" name="Submit3" value="���ѡ��" onclick="if(confirm(\'ȷ��Ҫ�����ѡTAGS��\')){document.add.infotags.value=\'\';}">';
				}
			  ?>
              <tr> 
                <td height="25" bgcolor="#FFFFFF">TAGS&nbsp;&nbsp;&nbsp;&nbsp;: 
                  <input name="infotags" type="text" id="infotags" value="<?=$r[infotags]?>" size="32"<?=$infotag_readonly?>> 
                  <input type="button" name="Submit" value="ѡ��" onclick="window.open('tags/ChangeTags.php?form=add&field=infotags<?=$ecms_hashur['ehref']?>','','width=700,height=550,scrollbars=yes');">
                  <?=$infotag_copykeyboard?>
                  <input name="oldinfotags" type="hidden" id="oldinfotags" value="<?=$r[infotags]?>">
                  <font color="#333333">(�����&quot;,&quot;���Ÿ�)</font></td>
              </tr>
              <?php
			  }
			  ?>
			  <?php
			  if($class_r[$classid]['link_num'])
			  {
			  ?>
			  <tr>
                <td height="25" bgcolor="#FFFFFF">�������:
                  <input type="radio" name="info_diyotherlink" value="0"<?=$voter[diyotherlink]==0?' checked':''?>>
                  ���ؼ��ֲ�ѯ 
                  <input type="radio" name="info_diyotherlink" value="1"<?=$voter[diyotherlink]==1?' checked':''?>>
                  <a href="#empirecms" title="�鿴�����ӵ��������" onclick="if(document.getElementsByName('info_diyotherlink')[1].checked==true){window.open('info/OtherLink.php?<?=$ecms_hashur['ehref']?>&classid=<?=$classid?>&id=<?=$id?>&enews=<?=$enews?>&form=add&field=info_keyid&keyid='+document.add.info_keyid.value+'&keyboard='+document.add.keyboard.value+'&title='+document.add.title.value,'','width=780,height=550,scrollbars=yes,resizable=yes');}else{alert('����ѡ���ֶ��������');}">�ֶ��������</a>
                  <input name="info_keyid" type="hidden" id="info_keyid" value="<?=$r[keyid]?>"></td>
              </tr>
			  <?php
			  }
			  ?>
            </table>
					<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
						<tr> 
							
                <td>����ר��</td>
						</tr>
						<tr> 
							<td height="25" bgcolor="#FFFFFF"><a href="#empirecms" onclick="window.open('special/PushToZt.php?sinfo=1&classid=<?=$classid?>&id=<?=$id?><?=$ecms_hashur['ehref']?>','PushToZt','width=360,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">���ѡ����Ϣ����ר��</a></td>
						</tr>
					</table>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
              <tr> 
                <td>��ʱ����</td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                    <tr> 
                      <td>����ʱ�䣺 <input name="info_infouptime" type="text" id="info_infouptime" value="<?=$voter[infouptime]?date('Y-m-d H:i:s',$voter[infouptime]):''?>" size="28" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                        [<a href="#empirecms" onclick="document.add.info_infouptime.value='<?=$todaytime?>'">��ǰʱ��</a>]</td>
                    </tr>
                    <tr> 
                      <td>����ʱ�䣺 <input name="info_infodowntime" type="text" id="info_infodowntime" value="<?=$voter[infodowntime]?date('Y-m-d H:i:s',$voter[infodowntime]):''?>" size="28" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                        [<a href="#empirecms" onclick="document.add.info_infodowntime.value='<?=$todaytime?>'">��ǰʱ��</a>]</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <?php
			if($wfinfor[checktno]==101)
			{
			?>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
              <tr> 
                <td>��Ϣ����</td>
              </tr>
              <tr> 
                <td height="25" bgcolor="#FFFFFF"><input name="reworkflow" type="checkbox" value="1">
                  ��������<font color="#333333">����Ϣ���������޸ĺ��ѡ����������</font> </td>
              </tr>
            </table>
			<?php
			}
			?>
					<?=$copyclassids?>
				</td>
			</tr>
		</table>
	</div>
	<div class="tab-page" id="votesetting">       
		<h2 class="tab">&nbsp;<font class=tabcolor>ͶƱ����</font>&nbsp;</h2>
        <script type="text/javascript">tb1.addTabPage( document.getElementById( "votesetting" ) );</script>
		<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
			<tr class="header"> 
				<td height="25" colspan="2">ͶƱ����</td>
			</tr>
			<tr bgcolor="#FFFFFF"> 
				<td width="21%" height="25">�������</td>
				<td width="79%" height="25"> <input name="vote_title" type="text" size="60" value="<?=$voter[title]?>"> 
				</td>
			</tr>
			<tr bgcolor="#FFFFFF"> 
				<td height="25" valign="top">ͶƱ��Ŀ</td>
				<td height="25">
					<table width="100%" border="0" cellspacing="1" cellpadding="3">
						<tr> 
							<td>
								<table width="100%" border="0" cellspacing="1" cellpadding="3">
									<tr bgcolor="#DBEAF5"> 
										<td width="9%" height="20"> <div align="center">���</div></td>
										<td width="65%"> <div align="center">��Ŀ����</div></td>
										<td width="26%"> <div align="center">ͶƱ��</div></td>
									</tr>
								</table>
								<?php
								if(($voter['id']&&$voter[votetext])||$definfovoteid)
								{
									echo"$allvote";
								}
								else
								{
								?>
									<table width="100%" border="0" cellspacing="1" cellpadding="3">
										<tr> 
											<td height="24" width="9%"> <div align="center">1</div></td>
											<td height="24" width="65%"> <div align="center"> 
											<input name="vote_name[]" type="text" size="30">
											</div></td>
											<td height="24" width="26%"> <div align="center"> 
											<input name="vote_num[]" type="text" value="0" size="6">
											</div></td>
                    </tr>
                    <tr> 
                      <td height="24"> <div align="center">2</div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_name[]" type="text" size="30">
                        </div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_num[]" type="text" value="0" size="6">
                        </div></td>
                    </tr>
                    <tr> 
                      <td height="24"> <div align="center">3</div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_name[]" type="text" size="30">
                        </div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_num[]" type="text" value="0" size="6">
                        </div></td>
                    </tr>
                    <tr> 
                      <td height="24"> <div align="center">4</div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_name[]" type="text" size="30">
                        </div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_num[]" type="text" value="0" size="6">
                        </div></td>
                    </tr>
                    <tr> 
                      <td height="24"> <div align="center">5</div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_name[]" type="text" size="30">
                        </div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_num[]" type="text" value="0" size="6">
                        </div></td>
                    </tr>
                    <tr> 
                      <td height="24"> <div align="center">6</div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_name[]" type="text" size="30">
                        </div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_num[]" type="text" value="0" size="6">
                        </div></td>
                    </tr>
                    <tr> 
                      <td height="24"> <div align="center">7</div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_name[]" type="text" size="30">
                        </div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_num[]" type="text" value="0" size="6">
                        </div></td>
                    </tr>
                    <tr> 
                      <td height="24"> <div align="center">8</div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_name[]" type="text" size="30">
                        </div></td>
                      <td height="24"> <div align="center"> 
                          <input name="vote_num[]" type="text" value="0" size="6">
                        </div></td>
                    </tr>
                  </table>
                  <?php
			  }
			  ?>
                </td>
              </tr>
              <tr> 
                <td>ͶƱ��չ����: 
                  <input name="v_vote_num" type="text" value="1" size="6"> <input type="button" name="Submit52" value="�����ַ" onclick="javascript:dovoteadd();"> 
                  <input name="v_editnum" type="hidden" value="<?=$voteeditnum?>"> 
                </td>
              </tr>
              <tr> 
                <td id="addvote"></td>
              </tr>
            </table></td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">ͶƱ����</td>
          <td height="25"><input name="vote_class" type="radio" value="0"<?=$voter['voteclass']==0?' checked':''?>>
            ��ѡ 
            <input type="radio" name="vote_class" value="1"<?=$voter['voteclass']==1?' checked':''?>>
            ��ѡ</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">����IP</td>
          <td height="25"><input type="radio" name="dovote_ip" value="0"<?=$voter['doip']==0?' checked':''?>>
            ������ 
            <input name="dovote_ip" type="radio" value="1"<?=$voter['doip']==1?' checked':''?>>
            ����(���ƺ�ͬһIPֻ��Ͷһ��Ʊ)</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">����ʱ��</td>
          <td height="25"> <input name="vote_olddotime" type=hidden value="<?=$voter[dotime]?>"> 
            <input name="vote_dotime" type="text" value="<?=$voter[dotime]?>" size="12" class="Wdate" onClick="WdatePicker({skin:'default',dateFmt:'yyyy-MM-dd'})">
            (����������,������ͶƱ,0000-00-00Ϊ������)</td>
        </tr>
		<tr bgcolor="#FFFFFF"> 
      	  <td height="25">�鿴ͶƱ����</td>
      	<td height="25">���: 
        <input name="vote_width" type="text" value="<?=$voter[width]?>" size="6">
        �߶�: 
        <input name="vote_height" type="text" value="<?=$voter[height]?>" size="6"></td>
    	</tr>
        <tr bgcolor="#FFFFFF"> 
          <td height="25">ѡ��ģ��</td>
          <td height="25"><select name="vote_tempid">
              <?=$votetemp?>
            </select> <input type="button" name="Submit62223" value="����ͶƱģ��" onclick="window.open('template/ListVotetemp.php?gid=<?=$thegid?><?=$ecms_hashur['ehref']?>');"> 
          </td>
        </tr>
      </table>
	</div>
</div>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr>
      <td width="16%">&nbsp;</td>
      <td><input type="submit" name="addnews" value=" �� �� "> &nbsp;&nbsp;&nbsp;<input type="reset" name="Submit2" value="����"></td>
    </tr>
  </table>
</form>
<?=$copyclassidshowiframe?>
</body>
</html>
<?php
db_close();
$empire=null;
?>