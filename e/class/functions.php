<?php
define('InEmpireCMSHfun',TRUE);
//-------------- ������ ----------------------

//���غ�̨���
function EcmsReturnAdminStyle(){
	global $public_r;
	$adminstyle=(int)getcvar('loginadminstyleid',1);
	if(!strstr($public_r['adminstyle'],','.$adminstyle.','))
	{
		$adminstyle=$public_r['defadminstyle']?$public_r['defadminstyle']:1;
	}
	return $adminstyle;
}

//���غ�̨������Ϣ��Ŀ�����ַ���
function AdminReturnClassLink($classid){
	global $class_r,$editor,$fun_r,$ecmscheck,$ecms_hashur;
	$addcheck='';
	if($ecmscheck)
	{
		$addcheck='&ecmscheck=1';
	}
	if($editor==1)
	{
		$addurl='../';
	}
	if(empty($class_r[$classid][featherclass]))
	{
		$class_r[$classid][featherclass]="|";
	}
	$r=explode("|",$class_r[$classid][featherclass].$classid."|");
	$string="<a href=\"".$addurl."ListAllInfo.php?tbname=".$class_r[$classid][tbname].$addcheck.$ecms_hashur['ehref']."\">".$fun_r['AdminInfo']."</a>";
	$count=count($r)-1;
	for($i=1;$i<$count;$i++)
	{
		$curl=$class_r[$r[$i]][islast]?"ListNews.php?classid=".$r[$i].$addcheck.$ecms_hashur['ehref']:"ListAllInfo.php?tbname=".$class_r[$r[$i]][tbname]."&classid=".$r[$i].$addcheck.$ecms_hashur['ehref'];
		$string.="&nbsp;>&nbsp;<a href=\"".$addurl."$curl\">".$class_r[$r[$i]][classname]."</a>";
    }
	return $string;
}

//����֤����
function AddCheckViewCode(){
	$code="if(!defined('InEmpireCMS'))
{
	exit();
}";
	return $code;
}

//��ģ����֤����
function AddCheckViewTempCode(){
	$code="<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>";
	return $code;
}

//��̨��ҳ
function page2($num,$line,$page_line,$start,$page,$search){
	global $fun_r;
	if($num<=$line)
	{
		return '<span class="epages"><a title="'.$fun_r['admintrecord'].'">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;</span>';
	}
	$search=RepPostStr($search,1);
	$url=eReturnSelfPage(0).'?page';
	$snum=2;//��Сҳ��
	$totalpage=ceil($num/$line);//ȡ����ҳ��
	$firststr='<a title="'.$fun_r['admintrecord'].'">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;';
	//��һҳ
	if($page<>0)
	{
		$toppage='<a href="'.$url.'=0'.$search.'">'.$fun_r['adminstartpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		$prepage='<a href="'.$url.'='.$pagepr.$search.'">'.$fun_r['adminpripage'].'</a>';
	}
	//��һҳ
	if($page!=$totalpage-1)
	{
		$pagenex=$page+1;
		$nextpage='&nbsp;<a href="'.$url.'='.$pagenex.$search.'">'.$fun_r['adminnextpage'].'</a>';
		$lastpage='&nbsp;<a href="'.$url.'='.($totalpage-1).$search.'">'.$fun_r['adminlastpage'].'</a>';
	}
	$starti=$page-$snum<0?0:$page-$snum;
	$no=0;
	for($i=$starti;$i<$totalpage&&$no<$page_line;$i++)
	{
		$no++;
		if($page==$i)
		{
			$is_1="<b>";
			$is_2="</b>";
		}
		else
		{
			$is_1='<a href="'.$url.'='.$i.$search.'">';
			$is_2="</a>";
		}
		$pagenum=$i+1;
		$returnstr.="&nbsp;".$is_1.$pagenum.$is_2;
	}
	$returnstr=$firststr.$toppage.$prepage.$returnstr.$nextpage.$lastpage;
	return '<span class="epages">'.$returnstr.'</span>';
}

//��̨��ҳ
function postpage($num,$line,$page_line,$start,$page,$form){
	global $fun_r;
	if($num<=$line)
	{
		return '';
	}
	$snum=2;//��Сҳ��
	$totalpage=ceil($num/$line);//ȡ����ҳ��
	$firststr='<a title="'.$fun_r['admintrecord'].'">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;';
	//��һҳ
	if($page<>0)
	{
		$toppage='<a href="#ecms" onclick="javascript:GotoPostPage(0,0);">'.$fun_r['adminstartpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		$prepage='<a href="#ecms" onclick="javascript:GotoPostPage('.$pagepr.',0);">'.$fun_r['adminpripage'].'</a>';
	}
	//��һҳ
	if($page!=$totalpage-1)
	{
		$pagenex=$page+1;
		$nextpage='&nbsp;<a href="#ecms" onclick="javascript:GotoPostPage('.$pagenex.',0);">'.$fun_r['adminnextpage'].'</a>';
		$lastpage='&nbsp;<a href="#ecms" onclick="javascript:GotoPostPage('.($totalpage-1).',0);">'.$fun_r['adminlastpage'].'</a>';
	}
	$starti=$page-$snum<0?0:$page-$snum;
	$no=0;
	for($i=$starti;$i<$totalpage&&$no<$page_line;$i++)
	{
		$no++;
		if($page==$i)
		{
			$is_1="<b>";
			$is_2="</b>";
		}
		else
		{
			$is_1='<a href="#ecms" onclick="javascript:GotoPostPage('.$i.',0);">';
			$is_2="</a>";
		}
		$pagenum=$i+1;
		$returnstr.="&nbsp;".$is_1.$pagenum.$is_2;
	}
	$returnstr=$firststr.$toppage.$prepage.$returnstr.$nextpage.$lastpage;
	$returnstr.="<script>
	function GotoPostPage(page,start){
		".$form.".page.value=page;
		".$form.".start.value=start;
		".$form.".submit();
	}
	</script>";
	return $returnstr;
}

//ȡ��ģ�ͱ���
function GetModTable($mid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select tid,tbname from {$dbtbpre}enewsmod where mid='$mid'");
	return $r;
}

//����ר��Ŀ¼
function CreateZtPath($ztpath){
	$createpath=eReturnTrueEcmsPath().$ztpath;
    $mk=DoMkdir($createpath);
	$createfilepath=$createpath.'/uploadfile';//��������Ŀ¼
    $mk1=DoMkdir($createfilepath);
}

//������ĿĿ¼
function CreateClassPath($classpath){
	$createpath=eReturnTrueEcmsPath().$classpath;
	$mk=DoMkdir($createpath);
	$createfilepath=eReturnTrueEcmsPath().'d/file/'.$classpath;//��������Ŀ¼
    $mk1=DoMkdir($createfilepath);
}

//�����������Ŀ¼
function CreateInfoTypePath($tpath){
	$createpath=eReturnTrueEcmsPath().$tpath;
    $mk=DoMkdir($createpath);
}

//������ĿĿ¼
function FormatClassPath($classpath,$islast){
	$r=explode("/",$classpath);
	$returnpath="";
	for($i=0;$i<count($r);$i++)
	{
		if($i>0)
		{
			$returnpath.="/".$r[$i];
		}
		else
		{
			$returnpath.=$r[$i];
		}
		CreateClassPath($returnpath);
	}
	return $returnpath;
}

//�Խ�Ŀ¼
function eAutodo_eCreatePath($dotype,$classid,$ecms=0){
	global $empire,$dbtbpre,$public_r,$class_r,$class_zr,$class_tr,$ecms_config;
	$classid=(int)$classid;
	$path='';
	if($dotype=='cpage')//��Ŀ
	{
		if(!$class_r[$classid]['classpath'])
		{
			return '';
		}
		$path=$class_r[$classid]['classpath'];
		$truepath=eReturnTrueEcmsPath().$path;
		if(file_exists($truepath))
		{
			return '';
		}
		$islast=$class_r[$classid]['islast'];
		FormatClassPath($path,$islast);
	}
	elseif($dotype=='zpage')//ר��
	{
		if(!$class_zr[$classid]['ztpath'])
		{
			return '';
		}
		$path=$class_zr[$classid]['ztpath'];
		$truepath=eReturnTrueEcmsPath().$path;
		if(file_exists($truepath))
		{
			return '';
		}
		CreateZtPath($path);
	}
	elseif($dotype=='tpage')//�������
	{
		if(!$class_tr[$classid]['tpath'])
		{
			return '';
		}
		$path=$class_tr[$classid]['tpath'];
		$truepath=eReturnTrueEcmsPath().$path;
		if(file_exists($truepath))
		{
			return '';
		}
		CreateInfoTypePath($path);
	}
	else
	{
		return '';
	}
}

//ɾ����Ŀ�����ļ�
function DelListEnews(){
	$file=ECMS_PATH."e/data/fc/ListEnews.php";
	DelFiletext($file);
	$file1=ECMS_PATH."e/data/fc/ListClass0.php";
	DelFiletext($file1);
	$file2=ECMS_PATH."e/data/fc/ListClass1.php";
	DelFiletext($file2);
}

//ɾ��ģ����ʱ�����ļ�
function DelOneTempTmpfile($classid){
	$file=ECMS_PATH.'e/data/tmp/dt_temp'.$classid.'.php';
	if(file_exists($file))
	{
		DelFiletext($file);
	}
}

//�滻php����
function RepPhpAspJspcode($string){
	global $public_r;
	if(!$public_r[candocode]){
		//$string=str_replace("<?xml","[!--ecms.xml--]",$string);
		$string=str_replace("<\\","&lt;\\",$string);
		$string=str_replace("\\>","\\&gt;",$string);
		$string=str_replace("<?","&lt;?",$string);
		$string=str_replace("<%","&lt;%",$string);
		if(@stristr($string,' language'))
		{
			$string=preg_replace(array('!<script!i','!</script>!i'),array('&lt;script','&lt;/script&gt;'),$string);
		}
		//$string=str_replace("[!--ecms.xml--]","<?xml",$string);
	}
	return $string;
}

//�滻php����
function RepPhpAspJspcodeText($string){
	//$string=str_replace("<?xml","[!--ecms.xml--]",$string);
	$string=str_replace("<\\","&lt;\\",$string);
	$string=str_replace("\\>","\\&gt;",$string);
	$string=str_replace("<?","&lt;?",$string);
	$string=str_replace("<%","&lt;%",$string);
	if(@stristr($string,' language'))
	{
		$string=preg_replace(array('!<script!i','!</script>!i'),array('&lt;script','&lt;/script&gt;'),$string);
	}
	//$string=str_replace("[!--ecms.xml--]","<?xml",$string);
	$string=str_replace("<!--code.start-->","&lt;!--code.start--&gt;",$string);
	$string=str_replace("<!--code.end-->","&lt;!--code.end--&gt;",$string);
	return $string;
}

//�滻�ļ�ǰ׺
function RepFilenameQz($qz,$ecms=0){
	if(empty($ecms))
	{
		$qz=str_replace("/","",$qz);
		$qz=str_replace("\\","",$qz);
	}
	$qz=str_replace("#","",$qz);
	$qz=str_replace("&","",$qz);
	$qz=str_replace(":","",$qz);
	$qz=str_replace(";","",$qz);
	$qz=str_replace("<","",$qz);
	$qz=str_replace(">","",$qz);
	$qz=str_replace("?","",$qz);
	$qz=str_replace("*","",$qz);
	$qz=str_replace("%","",$qz);
	$qz=str_replace("|","",$qz);
	$qz=str_replace("\"","",$qz);
	$qz=str_replace("'","",$qz);
	$qz=str_replace(".","",$qz);
	return $qz;
}

//�滻Ŀ¼ֵ
function RepPathStr($path){
	$path=str_replace("\\","",$path);
	$path=str_replace("/","",$path);
	return $path;
}

//�����滻�ַ�
function ReturnCheckDoRep(){
	global $empire,$dbtbpre;
	//��Ϣ��Դ
	$befrom=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsbefrom");
	//����
	$writer=$empire->gettotal("select count(*) as total from {$dbtbpre}enewswriter");
	//�滻�ַ�
	$words=$empire->gettotal("select count(*) as total from {$dbtbpre}enewswords");
	//���ݹؼ���
	$key=$empire->gettotal("select count(*) as total from {$dbtbpre}enewskey");
	$str=",$befrom,$writer,$words,$key,";
	return $str;
}

//�����滻��֤
function ReturnCheckDoRepStr(){
	global $public_r;
	return explode(',',$public_r[checkdorepstr]);
}

//ȡ����ĿĿ¼����
function GetPathname($classname){
	$c=explode("/",$classname);
	$count=count($c)-1;
	$cr[0]=$c[$count];//��ĿĿ¼��
	$len=strlen($cr[0]);
	//�ϼ���ĿĿ¼��
	$cr[1]=substr($classname,0,strlen($classname)-$len);
	return $cr;
}

//���»���
function ChangeEnewsData($userid,$username){
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"changedata");
	//���²�������
	GetConfig(1);
	//�������
	GetClass();
	//���»�Ա��
	GetMemberLevel();
	//����ȫվ�������ݱ�
	GetSearchAllTb();
	//������־
	insert_dolog("");
	printerror("ChangeDataSuccess","history.go(-1)");
}

//�����ļ���
function ReturnPathFile($filename){
	$fr=explode("/",$filename);
	$count=count($fr)-1;
	return $fr[$count];
}

//������Ŀ����(�޻���)
function sys_ReturnBqClassUrl($r){
	global $public_r;
	//�ⲿ��Ŀ
	if($r[wburl])
	{
		$classurl=$r[wburl];
	}
	//��̬�б�
	elseif($r['listdt'])
	{
		$rewriter=eReturnRewriteClassUrl($r['classid'],1);
		$classurl=$rewriter['pageurl'];
	}
	elseif($r['classurl'])
	{
		$classurl=$r['classurl'];
	}
	else
	{
		$classurl=$public_r['newsurl'].$r['classpath']."/";
	}
	return $classurl;
}

//����ר������(�޻���)
function sys_ReturnBqZtUrl($r){
	global $public_r;
	if($r['zturl'])
	{
		$zturl=$r['zturl'];
    }
	else
	{
		$zturl=$public_r['newsurl'].$r['ztpath']."/";
    }
	return $zturl;
}

//���������
function TogTwoArray($r,$ra){
	$returnr=array_merge($r,$ra);
	return $returnr;
}

//����
function DownLoadFile($file,$filepath,$ecms=0){
	if(empty($file))
	{
		printerror("FileNotExist","history.go(-1)");
    }
	if(!file_exists($filepath))
	{
		printerror("FileNotExist","");
	}
	$filesize=@filesize($filepath);
	//����
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: ".$filesize);
	Header("Content-Disposition: attachment; filename=".$file);
	echo ReadFiletext($filepath);
	if($ecms==1)
	{
		DelFiletext($filepath);
	}
}

//��������
function DownLoadFileText($filetext,$filename){
	if(empty($filetext)||empty($filename))
	{
		return '';
    }
	$filesize=strlen($filetext);
	//����
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: ".$filesize);
	Header("Content-Disposition: attachment; filename=".$filename);
	echo $filetext;
}

//ȡ�û����ļ�����
function GetFcfiletext($file){
	$str1="document.write(\"";
	$str2="\");";
	$text=ReadFiletext($file);
	$text=stripSlashes(str_replace($str2,"",str_replace($str1,"",$text)));
	return $text;
}

//��֤ģ�����Ƿ����
function CheckTempGroup($gid){
	global $empire,$dbtbpre;
	if(empty($gid))
	{
		$gid=GetDoTempGid();
	}
	$gid=(int)$gid;
	$r=$empire->fetch1("select gid,gname from {$dbtbpre}enewstempgroup where gid='$gid'");
	if(empty($r['gid']))
	{
		printerror("ErrorUrl","");
	}
	return $r['gname'];
}

//�������ر���
function ReturnFormHidden($vname,$value){
	$value=ehtmlspecialchars(ClearAddsData($value));
	return "<input type=hidden name=\"".$vname."\" value=\"".$value."\">";
}

//��֤��ѡ�ϴ�����Ƿ���
function TranmoreIsOpen($ecms='addinfo'){
	$open=0;
	$file='ecmseditor/tranmore/tranmore.php';
	if($ecms=='addinfo')
	{
		$file='ecmseditor/tranmore/tranmore.php';
	}
	elseif($ecms=='editor')
	{
		$file='../tranmore/tranmore.php';
	}
	elseif($ecms=='filemain')
	{
		$file='tranmore/tranmore.php';
	}
	if(file_exists($file))
	{
		$open=1;
	}
	return $open;
}

//-------------- ��Ϣ������ ----------------------

//�滻�ؼ���
function ReplaceKey($newstext,$classid=0){
	global $empire,$dbtbpre,$public_r,$class_r;
	if(empty($newstext)||$class_r[$classid]['keycid']==-1)
	{return $newstext;}
	$where='';
	if(!empty($class_r[$classid]['keycid']))
	{
		$where=" where cid='".$class_r[$classid]['keycid']."'";
	}
	$sql=$empire->query("select keyname,keyurl from {$dbtbpre}enewskey".$where);
	while($r=$empire->fetch($sql))
	{
		if(STR_IREPLACE)
		{
			$newstext=empty($public_r[repkeynum])?str_ireplace($r[keyname],'<a href='.$r[keyurl].' target=_blank class=infotextkey>'.$r[keyname].'</a>',$newstext):preg_replace('/'.$r[keyname].'/i','<a href='.$r[keyurl].' target=_blank class=infotextkey>'.$r[keyname].'</a>',$newstext,$public_r[repkeynum]);
		}
		else
		{
			$newstext=empty($public_r[repkeynum])?str_replace($r[keyname],'<a href='.$r[keyurl].' target=_blank class=infotextkey>'.$r[keyname].'</a>',$newstext):preg_replace('/'.$r[keyname].'/i','<a href='.$r[keyurl].' target=_blank class=infotextkey>'.$r[keyname].'</a>',$newstext,$public_r[repkeynum]);
		}
	}
	return $newstext;
}

//�滻�����ַ�
function ReplaceWord($newstext){
	global $empire,$dbtbpre;
	if(empty($newstext))
	{return $newstext;}
	$sql=$empire->query("select newword,oldword from {$dbtbpre}enewswords");
	while($r=$empire->fetch($sql))
	{
		$newstext=str_replace($r[oldword],$r[newword],$newstext);
	}
	return $newstext;
}

//�༭��Ϣʱ�滻�ؼ��ֺ͹����ַ�
function DoReplaceKeyAndWord($newstext,$dokey,$classid=0){
	global $public_r;
	$docheckrep=ReturnCheckDoRepStr();//�����滻��֤�ַ�
	if($public_r['dorepword']==1&&$docheckrep[3])//�����ַ�
	{
		$newstext=ReplaceWord($newstext);
	}
	if($public_r['dorepkey']==1&&$docheckrep[4]&&!empty($dokey))//���ݹؼ���
	{
		$newstext=ReplaceKey($newstext,$classid);
	}
	return $newstext;
}

//�������б��ļ�
function RenameListfile($classid,$lencord,$num,$type,$newtype,$classpath){
	$page=ceil($num/$lencord);
	for($j=1;$j<=$page;$j++)
	{
		if($j==1)
		{
			$listfile=ECMS_PATH.$classpath."/index";
		}
		else
		{
			$listfile=ECMS_PATH.$classpath."/index_".$j;
		}
		@rename($listfile.$type,$listfile.$newtype);
	}
}

//��֤�Ƿ�������ͷ������Ȩ��
function eFirstTitleCheckLevel($levelid,$ttype=0){
	global $empire,$dbtbpre,$lur,$classid,$class_r;
	$levelid=(int)$levelid;
	$ttype=(int)$ttype;
	if(!$levelid)
	{
		return 1;
	}
	$r=$empire->fetch1("select tid,groupid from {$dbtbpre}enewsgoodtype where levelid='$levelid' and ttype='$ttype' limit 1");
	if(!$r['tid'])
	{
		return 0;
	}
	if($r['groupid'])
	{
		if(!strstr($r['groupid'],','.$lur['groupid'].','))
		{
			return 0;
		}
	}
	return 1;
}

//��ϱ�������
function TitleFont($titlefont,$titlecolor=''){
	$add=$titlecolor.',';
	if($titlecolor=='no')
	{
		$add='';
	}
	if($titlefont[b])//����
	{$add.='b|';}
	if($titlefont[i])//б��
	{$add.='i|';}
	if($titlefont[s])//ɾ����
	{$add.='s|';}
	if($add==',')
	{
		$add='';
	}
	return $add;
}

//����Ϣ����ר��
function AddInfoToZt($ztid,$zcid,$classid,$id,$newstime,$isgood=0,$ecms=0){
	global $empire,$dbtbpre,$class_r;
	if($ecms==1)//����Ƿ����ӹ�
	{
		$infor=$empire->fetch1("select zid,ztid,cid from {$dbtbpre}enewsztinfo where ztid='$ztid' and classid='$classid' and id='$id' limit 1");
		if($infor['ztid'])
		{
			if($infor['cid']!=$zcid)
			{
				$empire->query("update {$dbtbpre}enewsztinfo set cid='$zcid',newstime='$newstime' where zid='$infor[zid]' limit 1");
			}
		}
		else
		{
			$mid=$class_r[$classid]['modid'];
			$empire->query("insert into {$dbtbpre}enewsztinfo(ztid,cid,classid,id,newstime,mid,isgood) values('$ztid','$zcid','$classid','$id','$newstime','$mid','$isgood');");
		}
	}
	else
	{
		$mid=$class_r[$classid]['modid'];
		$empire->query("insert into {$dbtbpre}enewsztinfo(ztid,cid,classid,id,newstime,mid,isgood) values('$ztid','$zcid','$classid','$id','$newstime','$mid','$isgood');");
	}
}

//����Ϣ����ר��
function AddMoreInfoToZt($ztid,$zcid,$tbname,$where,$ecms=0){
	global $empire,$dbtbpre,$class_r;
	if(empty($where))
	{
		return '';
	}
	$sql=$empire->query("select id,classid,newstime from {$dbtbpre}ecms_".$tbname.($ecms==0?'':'_index')." where ".$where);
	while($r=$empire->fetch($sql))
	{
		$zinfor=$empire->fetch1("select zid,ztid,cid from {$dbtbpre}enewsztinfo where ztid='$ztid' and classid='$r[classid]' and id='$r[id]' limit 1");
		if($zinfor['ztid'])
		{
			if($zinfor['cid']!=$zcid)
			{
				$empire->query("update {$dbtbpre}enewsztinfo set cid='$zcid' where zid='$zinfor[zid]' limit 1");
			}
		}
		else
		{
			$mid=$class_r[$r[classid]]['modid'];
			$empire->query("insert into {$dbtbpre}enewsztinfo(ztid,cid,classid,id,newstime,mid,isgood) values('$ztid','$zcid','$r[classid]','$r[id]','$r[newstime]','$mid','0');");
		}
	}
}

//����ר��
function InsertZtInfo($ztids,$zcids,$oldztids,$oldzcids,$classid,$id,$newstime){
	global $empire,$dbtbpre,$class_r;
	if($zcids==$oldzcids)
	{
		return '';
	}
	$haveztids='';
	$dh='';
	//����ר�����
	if($zcids)
	{
		$r=explode(',',$zcids);
		$count=count($r);
		for($i=0;$i<$count;$i++)
		{
			$cid=(int)$r[$i];
			if(!$cid)
			{
				continue;
			}
			if($cid<0)
			{
				$thisztid=abs($cid);
				$cid=0;
			}
			else
			{
				$zcr=$empire->fetch1("select ztid from {$dbtbpre}enewszttype where cid='$cid' limit 1");
				if(!$zcr['ztid'])
				{
					continue;
				}
				$thisztid=$zcr['ztid'];
			}
			AddInfoToZt($thisztid,$cid,$classid,$id,$newstime,0,1);
			$haveztids.=$dh.$thisztid;
			$dh=',';
		}
	}
	//����ûѡר��
	if($oldztids)
	{
		$dr=explode(',',$oldztids);
		$dcount=count($dr);
		for($di=0;$di<$dcount;$di++)
		{
			$dztid=(int)$dr[$di];
			if(!$dztid||strstr(','.$haveztids.',',','.$dztid.','))
			{
				continue;
			}
			$empire->query("delete from {$dbtbpre}enewsztinfo where ztid='$dztid' and classid='$classid' and id='$id'");
		}
	}
}

//ȡ������ר��
function DelZtInfo($where){
	global $empire,$dbtbpre,$class_r;
	if(!$where)
	{
		return '';
	}
	$empire->query("delete from {$dbtbpre}enewsztinfo where ".$where);
}

//��Ϣ����
function InfoInsertToWorkflow($id,$classid,$wfid,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$wfitemr=$empire->fetch1("select tid,tno,groupid,userclass,username,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfid' order by tno limit 1");
	//״̬����
	$empire->query("insert into {$dbtbpre}enewswfinfo(id,classid,wfid,tid,groupid,userclass,username,checknum,tstatus,checktno) values('$id','$classid','$wfid','$wfitemr[tid]','$wfitemr[groupid]','$wfitemr[userclass]','$wfitemr[username]',1,'$wfitemr[tstatus]',0);");
	//��־
	InsertWfLog($classid,$id,$wfid,0,$username,'',1,0);
}

//��Ϣ��������
function InfoUpdateToWorkflow($id,$classid,$wfid,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$wfinfor=$empire->fetch1("select checknum,wfid,tid,checktno from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid' limit 1");
	if($wfinfor[checktno]!='101')
	{
		return '';
	}
	if($wfinfor[tid])
	{
		$ywfitemr=$empire->fetch1("select tno from {$dbtbpre}enewsworkflowitem where tid='$wfinfor[tid]'");
		$wfitemr=$empire->fetch1("select tid,tno,groupid,userclass,username,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfinfor[wfid]' and tno>$ywfitemr[tno] order by tno limit 1");
	}
	else
	{
		$wfitemr=$empire->fetch1("select tid,tno,groupid,userclass,username,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfinfor[wfid]' order by tno limit 1");
	}
	//״̬����
	$empire->query("update {$dbtbpre}enewswfinfo set tid='$wfitemr[tid]',groupid='$wfitemr[groupid]',userclass='$wfitemr[userclass]',username='$wfitemr[username]',checknum=checknum+1,tstatus='$wfitemr[tstatus]',checktno='0' where id='$id' and classid='$classid' limit 1");
	//��־
	InsertWfLog($classid,$id,$wfinfor[wfid],0,$username,'',$wfinfor[checknum],0);
}

//д��ǩ����־
function InsertWfLog($classid,$id,$wfid,$tid,$username,$checktext,$checknum,$checktype){
	global $empire,$dbtbpre,$class_r,$lur;
	$checktime=time();
	$checktext=RepPostStr($checktext);
	$empire->query("insert into {$dbtbpre}enewswfinfolog(id,classid,wfid,tid,username,checktime,checktext,checknum,checktype) values('$id','$classid','$wfid','$tid','$username','$checktime','$checktext','$checknum','$checktype');");
}

//�����Ƿ�ǩ��
function EcmsReturnDoIsqf($userid,$username,$ugroupid,$ecms=0){
	global $empire,$public_r,$dbtbpre,$emod_r,$lur;
	$ugroupid=(int)$ugroupid;
	$ugr=ReturnLeftLevel($ugroupid);
	$qf=$ugr['doisqf']?1:0;
	return $qf;
}

//����TAG��
function eInsertTags($tags,$classid,$id,$newstime){
	global $empire,$dbtbpre,$class_r;
	if(!trim($tags))
	{
		return '';
	}
	$tags=RepPostVar($tags);
	$classid=(int)$classid;
	$id=(int)$id;
	$mid=(int)$class_r[$classid][modid];
	$tr=explode(',',$tags);
	$count=count($tr);
	for($i=0;$i<$count;$i++)
	{
		$tagname=$tr[$i];
		if(empty($tagname))
		{
			continue;
		}
		$r=$empire->fetch1("select tagid from {$dbtbpre}enewstags where tagname='$tagname' limit 1");
		if($r[tagid])
		{
			$datar=$empire->fetch1("select tagid,classid,newstime from {$dbtbpre}enewstagsdata where tagid='$r[tagid]' and id='$id' and mid='$mid' limit 1");
			if($datar[tagid])
			{
				if($datar[classid]!=$classid||$datar[newstime]!=$newstime)
				{
					$empire->query("update {$dbtbpre}enewstagsdata set classid='$classid',newstime='$newstime' where tagid='$r[tagid]' and id='$id' and mid='$mid' limit 1");
				}
			}
			else
			{
				$empire->query("update {$dbtbpre}enewstags set num=num+1 where tagid='$r[tagid]'");
				$empire->query("insert into {$dbtbpre}enewstagsdata(tagid,classid,id,newstime,mid) values('$r[tagid]','$classid','$id','$newstime','$mid');");
			}
		}
		else
		{
			$empire->query("insert into {$dbtbpre}enewstags(tagname,num,isgood,cid) values('$tagname',1,0,0);");
			$tagid=$empire->lastid();
			$empire->query("insert into {$dbtbpre}enewstagsdata(tagid,classid,id,newstime,mid) values('$tagid','$classid','$id','$newstime','$mid');");
		}
	}
}

//������ϢTAGS
function eReturnInfoTags($classid,$id,$mid){
	global $empire,$dbtbpre,$class_r;
	if(!$mid||!$id)
	{
		return '';
	}
	$tags='';
	$dh='';
	$sql=$empire->query("select tagid from {$dbtbpre}enewstagsdata where id='$id' and mid='$mid' order by tagid");
	while($r=$empire->fetch($sql))
	{
		$tr=$empire->fetch1("select tagname from {$dbtbpre}enewstags where tagid='$r[tagid]'");
		$tags.=$dh.$tr[tagname];
		$dh=',';
	}
	return $tags;
}

//δ��˱���Ϣת��
function MoveCheckInfoData($tbname,$checked,$stb,$where){
	global $empire,$dbtbpre;
	if(empty($checked))
	{
		$ytbname=$dbtbpre.'ecms_'.$tbname.'_check';
		$ydatatbname=$dbtbpre.'ecms_'.$tbname.'_check_data';
		$ntbname=$dbtbpre.'ecms_'.$tbname;
		$ndatatbname=$dbtbpre.'ecms_'.$tbname.'_data_'.$stb;
	}
	else
	{
		$ytbname=$dbtbpre.'ecms_'.$tbname;
		$ydatatbname=$dbtbpre.'ecms_'.$tbname.'_data_'.$stb;
		$ntbname=$dbtbpre.'ecms_'.$tbname.'_check';
		$ndatatbname=$dbtbpre.'ecms_'.$tbname.'_check_data';
	}
	$empire->query("replace into ".$ntbname." select * from ".$ytbname." where ".$where);
	$empire->query("replace into ".$ndatatbname." select * from ".$ydatatbname." where ".$where);
	//ɾ��ԭ��
	$empire->query("delete from ".$ytbname." where ".$where);
	$empire->query("delete from ".$ydatatbname." where ".$where);
}

//���¸����ֶ�����
function UpdateAllDataTbField($tbname,$update,$where,$upcheck=1,$updoc=1){
	global $empire,$dbtbpre;
	//�����
	$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
	if($tbr['datatbs'])
	{
		$dtbr=explode(',',$tbr['datatbs']);
		$count=count($dtbr);
		for($i=1;$i<$count-1;$i++)
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." set ".$update.$where);
		}
	}
	//δ���
	if($upcheck==1)
	{
		$empire->query("update {$dbtbpre}ecms_".$tbname."_check_data set ".$update.$where);
	}
	//�鵵
	if($updoc==1)
	{
		$empire->query("update {$dbtbpre}ecms_".$tbname."_doc_data set ".$update.$where);
	}
}

//ɾ��������Ϣ(����)
function DelAllDataTbInfo($tbname,$where,$delcheck=1,$deldoc=1){
	global $empire,$dbtbpre;
	if(empty($where))
	{
		return '';
	}
	//�����
	$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
	if($tbr['datatbs'])
	{
		$dtbr=explode(',',$tbr['datatbs']);
		$count=count($dtbr);
		for($i=1;$i<$count-1;$i++)
		{
			$empire->query("delete from {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." where ".$where);
		}
	}
	//δ���
	if($delcheck==1)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_check_data where ".$where);
	}
	//�鵵
	if($deldoc==1)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_doc_data where ".$where);
	}
}

//����������ʽ
function ReturnInfoFilename($classid,$id,$filenameqz){
	global $class_r;
	if($class_r[$classid][filename]==1)	//time����
	{
		$filename=$class_r[$classid][filename_qz].time().$id;
	}
	elseif($class_r[$classid][filename]==2)	//md5����
	{
		$filename=$class_r[$classid][filename_qz].md5(uniqid(microtime()).$id);
	}
	elseif($class_r[$classid][filename]==3)	//Ŀ¼
	{
		$filename=$class_r[$classid][filename_qz].$id.'/index';
	}
	elseif($class_r[$classid][filename]==4)	//date����
	{
		$filename=$class_r[$classid][filename_qz].date('Ymd').$id;
	}
	elseif($class_r[$classid][filename]==5)	//������ϢID
	{
		$filename=$class_r[$classid][filename_qz].ReturnInfoPubid($classid,$id);
	}
	else	//id
	{
		$filename=$class_r[$classid][filename_qz].$id;
	}
	$filename=$filenameqz.$filename;
	return $filename;
}

//ɾ��������ظ���
function DelFileOtherTable($where,$tb='other'){
	global $empire,$dbtbpre,$public_r;
	if(empty($where))
	{
		return '';
	}
	//ɾ������
	$filesql=$empire->query("select filename,path,modtype,fpath from {$dbtbpre}enewsfile_{$tb} where ".$where);
	while($filer=$empire->fetch($filesql))
	{
		DoDelFile($filer);
	}
	$empire->query("delete from {$dbtbpre}enewsfile_{$tb} where ".$where);
}

//������ɾ����Ϣ����
function DelFileAllTable($where){
	global $empire,$dbtbpre,$public_r;
	if(empty($where))
	{
		return '';
	}
	if($public_r['filedatatbs'])
	{
		$dtbr=explode(',',$public_r['filedatatbs']);
		$count=count($dtbr);
		for($i=1;$i<$count-1;$i++)
		{
			//ɾ������
			$filesql=$empire->query("select filename,path,classid,fpath from {$dbtbpre}enewsfile_".$dtbr[$i]." where ".$where);
			while($filer=$empire->fetch($filesql))
			{
				DoDelFile($filer);
			}
			$empire->query("delete from {$dbtbpre}enewsfile_".$dtbr[$i]." where ".$where);
		}
	}
}

//������ɾ����Ϣ����
function DelPlAllTable($where){
	global $empire,$dbtbpre,$public_r;
	if(empty($where))
	{
		return '';
	}
	if($public_r['pldatatbs'])
	{
		$pldtbr=explode(',',$public_r['pldatatbs']);
		$count=count($pldtbr)-1;
		for($i=1;$i<$count;$i++)
		{
			$empire->query("delete from {$dbtbpre}enewspl_".$pldtbr[$i]." where ".$where);
		}
	}
}

//������Ӧ�ĸ���
function UpdateTheFile($id,$checkpass,$classid,$fstb=1){
	global $empire,$dbtbpre;
	if(empty($id)||empty($checkpass))
	{
		return "";
    }
	$id=(int)$id;
	$checkpass=(int)$checkpass;
	$classid=(int)$classid;
	$pubid=ReturnInfoPubid($classid,$id);
	$sql=$empire->query("update {$dbtbpre}enewsfile_{$fstb} set pubid='$pubid',classid='$classid',id='$id',cjid=0 where cjid='$checkpass'");
}

//�޸�ʱ���¸���
function UpdateTheFileEdit($classid,$id,$fstb=1){
	global $empire,$dbtbpre;
	$pubid=ReturnInfoPubid($classid,$id);
	$sql=$empire->query("update {$dbtbpre}enewsfile_{$fstb} set pubid='$pubid',cjid=0 where id='$id' and classid='$classid'");
}

//��ȡ��Ϣ�ֱ�
function GetInfoTranFstb($classid,$id,$fstb){
	global $empire,$dbtbpre,$public_r,$class_r;
	if($id)
	{
		$classid=(int)$classid;
		$id=(int)$id;
		if(!$classid||!$class_r[$classid]['tbname'])
		{
			return $public_r['filedeftb'];
		}
		$index_r=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$class_r[$classid]['tbname']."_index where id='$id' limit 1");
		if(!$index_r['id'])
		{
			return $public_r['filedeftb'];
		}
		//����
		$infotb=ReturnInfoMainTbname($class_r[$classid]['tbname'],$index_r['checked']);//���ر�
		$infor=$empire->fetch1("select fstb from ".$infotb." where id='$id' limit 1");
		$fstb=$infor['fstb'];
	}
	elseif($fstb)
	{
		$fstb=eReturnFileStb($fstb);
	}
	else
	{
		$fstb=$public_r['filedeftb'];
	}
	$fstb=(int)$fstb;
	return $fstb;
}

//����ispic��ʶ
function UpdateTheIspic($classid,$id,$checked){
	global $empire,$dbtbpre,$class_r;
	$infotb=empty($checked)?$dbtbpre.'ecms_'.$class_r[$classid][tbname].'_check':$dbtbpre.'ecms_'.$class_r[$classid][tbname];
	$r=$empire->fetch1("select titlepic,ispic from ".$infotb." where id='$id' limit 1");
	$ispic=$r['titlepic']?1:0;
	if($ispic<>$r['ispic'])
	{
		$empire->query("update ".$infotb." set ispic='$ispic' where id='$id'");
	}
}

//ȡ�ڼ���ͼƬ
function GetFpicToTpic($classid,$id,$num=1,$getfirsttitlespic=0,$swidth=0,$sheight=0,$fstb=1){
	global $empire,$dbtbpre,$public_r,$class_r,$loginin,$logininid;
	$pubid=ReturnInfoPubid($classid,$id);
	$num=(int)$num;
	$num=$num-1;
	if($num<0)
	{
		return '';
	}
	$logininid=(int)$logininid;
	$loginin=RepPostVar($loginin);
	$picr=$empire->fetch1("select fileid,filename,path,id,classid,no,fpath from {$dbtbpre}enewsfile_{$fstb} where pubid='$pubid' and type=1 order by fileid limit $num,1");
	$firsttitlepic="";
	if($picr['fileid'])
	{
		$rpath=$picr['path']?$picr['path'].'/':$picr['path'];
		$fspath=ReturnFileSavePath($picr[classid],$picr[fpath]);
		if($getfirsttitlespic==1&&$swidth&&$sheight)//����ͼ
		{
			$path=eReturnEcmsMainPortPath().$fspath['filepath'].$rpath;//moreport
			$yname=$path.$picr[filename];
			$filetype=GetFiletype($picr[filename]);
			$insertfile=substr($picr[filename],0,strlen($picr[filename])-strlen($filetype)).time();
			$name=$path."small".$insertfile;
			$sfiler=GetMySmallImg($classid,$picr[no],$insertfile,$picr[path],$yname,$swidth,$sheight,$name,$id,$add['filepass'],$logininid,$loginin,0,$fstb);
			$firsttitlepic=$fspath['fileurl'].$rpath."small".$insertfile.$sfiler['filetype'];
		}
		else
		{
			$firsttitlepic=$fspath['fileurl'].$rpath.$picr[filename];
		}
	}
	return $firsttitlepic;
}

//�����滻ͼƬ��һҳ��������
function UpdateImgNexturl($classid,$id,$checked=1){
	global $empire,$dbtbpre,$class_r,$public_r,$emod_r;
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$pf=$emod_r[$mid]['pagef'];
	$stf=$emod_r[$mid]['savetxtf'];
	if(!$pf)
	{
		return '';
	}
	$infotbname=$checked?$dbtbpre.'ecms_'.$tbname:$dbtbpre.'ecms_'.$tbname.'_check';
	//��ҳ�ֶ�
	$tbdataf=strstr($emod_r[$mid]['tbdataf'],','.$pf.',')?1:0;
	if($tbdataf)
	{
		$r=$empire->fetch1("select id,classid,titleurl,groupid,newspath,filename,stb from ".$infotbname." where id='$id'");
		$infodatatbname=$checked?$dbtbpre.'ecms_'.$tbname.'_data_'.$r[stb]:$dbtbpre.'ecms_'.$tbname.'_check_data';
		$finfor=$empire->fetch1("select ".$pf." from ".$infodatatbname." where id='$id'");
		$r[$pf]=$finfor[$pf];
	}
	else
	{
		$r=$empire->fetch1("select id,classid,titleurl,groupid,newspath,filename,".$pf." from ".$infotbname." where id='$id'");
	}
	//���ı�
	if($stf&&$stf==$pf)
	{
		$newstextfile=$r[$stf];
		$r[$stf]=GetTxtFieldText($r[$stf]);
	}
	if(!$r[$pf])
	{
		return '';
	}
	$newstext=RepNewstextImgLink($r[$pf],$r);
	if(empty($newstext))
	{
		return '';
	}
	//���ı�
	if($stf&&$stf==$pf)
	{
		EditTxtFieldText($newstextfile,$newstext);
		return '';
	}
	if($tbdataf)
	{
		$empire->query("update ".$infodatatbname." set ".$pf."='$newstext' where id='$id'");
	}
	else
	{
		$empire->query("update ".$infotbname." set ".$pf."='$newstext' where id='$id'");
	}
}

//��ͼƬ����һҳ����
function RepNewstextImgLink($newstext,$add){
	global $public_r;
	$expage='[!--empirenews.page--]';//��ҳ��
	if(!stristr($newstext,$expage)||!stristr($newstext,'<img '))
	{
		return '';
	}
	$newstext=stripSlashes($newstext);
	$repurl='[!--empirecms.rep.nextpageurl--]';
	$newstext=DoRepImgLink($newstext,$repurl);
	$nr=explode($expage,$newstext);
	$count=count($nr);
	//ҳ���ַ
	$urlqzr=ReturnInfoPageQz($add);
	$lastpageurl=$public_r['newsurl'].'e/public/ClassUrl/?classid='.$add['classid'];	//���һҳ���ӵ�ַ
	$new_newstext='';
	$addexpage='';
	for($i=0;$i<$count;$i++)
	{
		$thispagetext=$nr[$i];
		if(stristr($thispagetext,'<img '))
		{
			if($i==$count-1)
			{
				$newurl=$lastpageurl;
			}
			else
			{
				//��һҳ����
				if($urlqzr['nametype']==1)
				{
					$newurl=eReturnRewritePageLink($urlqzr,$i+1);
				}
				else
				{
					$newurl=$urlqzr['titleurl'].'_'.($i+2).$urlqzr['filetype'];
				}
			}
			$thispagetext=str_replace($repurl,$newurl,$thispagetext);
		}
		$new_newstext.=$addexpage.$thispagetext;
		$addexpage=$expage;
	}
	return addslashes($new_newstext);
}

//�������������ϢID
function GetKeyid($keyboard,$classid,$id,$link_num){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre,$eyh_r,$etable_r;
	if($keyboard)
	{
		$link_num=(int)$link_num;
		if(empty($link_num))
		{
			return '';
		}
		$where='';
		$add='';
		$repadd='';
		$classid=(int)$classid;
		$id=(int)$id;
		$keyboard=str_replace('[!--f--!]','ecms',$keyboard);
		$keyboard=RepDyh($keyboard);
		$r=explode(",",$keyboard);
		for($i=0;$i<count($r);$i++)
		{
			if($i==0)
			{
				$or="";
			}
			else
			{
				$or=" or ";
			}
			$r[$i]=RepPostVar($r[$i]);
			$repadd.=$or."[!--f--!]"." like '%".$r[$i]."%'";
	    }
		//������Χ
		if($public_r['newslink']==1)
		{
			$add='('.str_replace('[!--f--!]','keyboard',$repadd).')';
		}
		elseif($public_r['newslink']==2)
		{
			$add='('.str_replace('[!--f--!]','keyboard',$repadd).' or '.str_replace('[!--f--!]','title',$repadd).')';
		}
		else
		{
			$add='('.str_replace('[!--f--!]','title',$repadd).')';
		}
		//ģ��
		if(!empty($class_r[$classid][modid]))
		{
			$mr=$empire->fetch1("select sonclass from {$dbtbpre}enewsmod where mid='".$class_r[$classid][modid]."'");
			$where=" and (".ReturnClass($mr[sonclass]).")";
		}
		//�Ż�
		$tbname=$class_r[$classid][tbname];
		$yhvar='otherlink';
		$yhid=$etable_r[$tbname][yhid];
		$yhadd='';
		if($yhid)
		{
			$yhadd=ReturnYhSql($yhid,$yhvar,1);
		}
		//ID����
		$keyid="";
		$first=0;
		$key_sql=$empire->query("select id from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$yhadd.$add.$where." and id<>$id order by newstime desc limit $link_num");
		while($link_r=$empire->fetch($key_sql))
		{
			if(empty($first))
			{
				$dh="";
				$first=1;
			}
			else
			{
				$dh=",";
			}
			$keyid.=$dh.$link_r[id];
		}
	}
	else
	{
		$keyid="";
	}
	return $keyid;
}

//ɾ����Ϣ���ı��ļ�
function DelInfoSaveTxtfile($mid,$tbname,$where){
	global $empire,$dbtbpre,$public_r,$class_r,$emod_r;
	if(empty($where))
	{
		return '';
	}
	$savetxtf=$emod_r[$mid]['savetxtf'];
	if($savetxtf)
	{
		//�����
		$txtsql=$empire->query("select ".$savetxtf." from {$dbtbpre}ecms_".$tbname." where ".$where);
		while($txtr=$empire->fetch($txtsql))
		{
			$newstextfile=$txtr[$savetxtf];
			//$txtr[$savetxtf]=GetTxtFieldText($txtr[$savetxtf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		//δ���
		$txtsql=$empire->query("select ".$savetxtf." from {$dbtbpre}ecms_".$tbname."_check where ".$where);
		while($txtr=$empire->fetch($txtsql))
		{
			$newstextfile=$txtr[$savetxtf];
			//$txtr[$savetxtf]=GetTxtFieldText($txtr[$savetxtf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		//�鵵
		$txtsql=$empire->query("select ".$savetxtf." from {$dbtbpre}ecms_".$tbname."_doc where ".$where);
		while($txtr=$empire->fetch($txtsql))
		{
			$newstextfile=$txtr[$savetxtf];
			//$txtr[$savetxtf]=GetTxtFieldText($txtr[$savetxtf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
	}
}

//ɾ����Ϣ��ؼ�¼
function DelSingleInfoOtherData($classid,$id,$r,$delfile=0,$delpl=0){
	global $empire,$dbtbpre,$public_r,$class_r,$emod_r;
	$pubid=ReturnInfoPubid($classid,$id);
	//ɾ���������¼
	$empire->query("delete from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid'");
	$empire->query("delete from {$dbtbpre}enewswfinfolog where id='$id' and classid='$classid'");
	$empire->query("delete from {$dbtbpre}enewsinfovote where pubid='$pubid'");
	$empire->query("delete from {$dbtbpre}enewsdiggips where id='$id' and classid='$classid'");
	$empire->query("delete from {$dbtbpre}enewsztinfo where id='$id' and classid='$classid'");
	if($delfile==0)
	{
		DelNewsTheFile($id,$classid,$r['fstb'],$delpl,$r['restb']);//ɾ������
	}
}

//ɾ����Ϣ��ؼ�¼(����Ŀ)
function DelMoreInfoOtherData($classid,$delfile=0,$delpl=0){
	global $empire,$dbtbpre,$public_r,$class_r,$emod_r;
	//ɾ���������¼
	$empire->query("delete from {$dbtbpre}enewswfinfo where classid='$classid'");
	$empire->query("delete from {$dbtbpre}enewswfinfolog where classid='$classid'");
	$empire->query("delete from {$dbtbpre}enewsinfovote where classid='$classid'");
	$empire->query("delete from {$dbtbpre}enewsdiggips where classid='$classid'");
	$empire->query("delete from {$dbtbpre}enewsztinfo where classid='$classid'");
	//����
	if($delfile==0)
	{
		DelFileAllTable("classid='$classid'");
	}
	//����
	if($delpl==0)
	{
		DelPlAllTable("classid='$classid'");
	}
}

//������Ϣ��ؼ�¼
function UpdateSingleInfoOtherData($classid,$id,$to_classid,$r,$updatefile=0,$updatepl=0){
	global $empire,$dbtbpre,$public_r,$class_r,$emod_r;
	$pubid=ReturnInfoPubid($classid,$id);
	//�����������¼
	$empire->query("update {$dbtbpre}enewswfinfo set classid='$to_classid' where id='$id' and classid='$classid'");
	$empire->query("update {$dbtbpre}enewswfinfolog set classid='$to_classid' where id='$id' and classid='$classid'");
	$empire->query("update {$dbtbpre}enewsinfovote set classid='$to_classid' where pubid='$pubid'");
	$empire->query("update {$dbtbpre}enewsdiggips set classid='$to_classid' where id='$id' and classid='$classid'");
	$empire->query("update {$dbtbpre}enewsztinfo set classid='$to_classid' where id='$id' and classid='$classid'");
	//����
	if($updatefile==0)
	{
		$empire->query("update {$dbtbpre}enewsfile_".$r['fstb']." set classid='$to_classid' where pubid='$pubid'");
	}
	//����
	if($updatepl==0)
	{
		$empire->query("update {$dbtbpre}enewspl_".$r['restb']." set classid='$to_classid' where pubid='$pubid'");
	}
}

//������Ϣ��ؼ�¼(����Ŀ)
function UpdateMoreInfoOtherData($classid,$to_classid,$updatefile=0,$updatepl=0){
	global $empire,$dbtbpre,$public_r,$class_r,$emod_r;
	//�����������¼
	$empire->query("update {$dbtbpre}enewswfinfo set classid='$to_classid' where classid='$classid'");
	$empire->query("update {$dbtbpre}enewswfinfolog set classid='$to_classid' where classid='$classid'");
	$empire->query("update {$dbtbpre}enewsinfovote set classid='$to_classid' where classid='$classid'");
	$empire->query("update {$dbtbpre}enewsdiggips set classid='$to_classid' where classid='$classid'");
	$empire->query("update {$dbtbpre}enewsztinfo set classid='$to_classid' where classid='$classid'");
	//����
	if($updatefile==0)
	{
		if($public_r['filedatatbs'])
		{
			$dtbr=explode(',',$public_r['filedatatbs']);
			$count=count($dtbr);
			for($i=1;$i<$count-1;$i++)
			{
				$empire->query("update {$dbtbpre}enewsfile_".$dtbr[$i]." set classid='$to_classid' where classid='$classid'");
			}
		}
	}
	//����
	if($updatepl==0)
	{
		if($public_r['pldatatbs'])
		{
			$pldtbr=explode(',',$public_r['pldatatbs']);
			$count=count($pldtbr)-1;
			for($i=1;$i<$count;$i++)
			{
				$empire->query("update {$dbtbpre}enewspl_".$pldtbr[$i]." set classid='$to_classid' where classid='$classid'");
			}
		}
	}
}

//ɾ����Ϣ����
function DelNewsTheFile($id,$classid,$fstb='1',$delpl=0,$restb='1'){
	global $empire,$dbtbpre;
	if(empty($id))
	{
		return "";
	}
	$pubid=ReturnInfoPubid($classid,$id);
	$i=0;
	$sql=$empire->query("select classid,filename,path,fpath from {$dbtbpre}enewsfile_{$fstb} where pubid='$pubid'");
	while($r=$empire->fetch($sql))
	{
		$i=1;
		DoDelFile($r);
    }
	if($i)
	{
		$empire->query("delete from {$dbtbpre}enewsfile_{$fstb} where pubid='$pubid'");
	}
	//ɾ������
	if($delpl==0)
	{
		$empire->query("delete from {$dbtbpre}enewspl_{$restb} where pubid='$pubid'");
	}
}

//ɾ����Ϣ�ļ�
function DelNewsFile($filename,$newspath,$classid,$newstext,$groupid=0){
	global $class_r,$addgethtmlpath;
	if(!trim($filename)||!$classid||!$class_r[$classid][classpath])
	{
		return '';
	}
	if(strstr($filename,'/'))
	{
		$etfilename=ReturnInfoSPath($filename);
		if(!trim($etfilename)||strstr($etfilename,'/'))
		{
			return '';
		}
	}
	//�ļ�����
	if($groupid)
	{
		$filetype=".php";
	}
	else
	{
		$filetype=$class_r[$classid][filetype];
	}
	//�Ƿ�������Ŀ¼
	if(empty($newspath))
	{
		$mynewspath="";
    }
	else
	{
		$mynewspath=$newspath."/";
    }
	$iclasspath=ReturnSaveInfoPath($classid,$id);
	$r=explode("[!--empirenews.page--]",$newstext);
	$pagecount=count($r);
	for($i=1;$i<=$pagecount;$i++)
	{
		if(strstr($filename,'/'))
		{
			DelPath(eReturnTrueEcmsPath().$iclasspath.$mynewspath.ReturnInfoSPath($filename));
			break;
		}
		else
		{
			if($i==1)
			{
				$file=eReturnTrueEcmsPath().$iclasspath.$mynewspath.$filename.$filetype;
			}
			else
			{
				$file=eReturnTrueEcmsPath().$iclasspath.$mynewspath.$filename."_".$i.$filetype;
			}
			DelFiletext($file);
		}
	}
	//moreportdo
	if($filename)
	{
		if(strstr($filename,'/'))
		{
			$eautodofile=$iclasspath.$mynewspath.ReturnInfoSPath($filename);
			$eautodofname='delpath|'.$eautodofile.'||';
			eAutodo_AddDo('eDelFileInfo',0,0,0,0,0,$eautodofname);
		}
		else
		{
			$eautodofile=$iclasspath.$mynewspath.$filename;
			$eautodofname='delfile|'.$eautodofile.'|'.$filetype.'|'.$pagecount;
			eAutodo_AddDo('eDelFileInfo',0,0,0,0,0,$eautodofname);
		}
	}
}

//ɾ��ר�������б��ļ�
function DelZtcFile($cid,$cr){
	global $empire,$dbtbpre,$class_zr;
	//$cr=$empire->fetch1("select ztid,islist,maxnum,tnum,ttype,tfile from {$dbtbpre}enewszttype where cid='$cid'");
	if(!$cr['ztid'])
	{
		return '';
	}
	//�ļ�����
	$filetype=$cr['ttype'];
	$tfile=$cr['tfile'];
	$doclasspath=ReturnSaveZtPath($cr['ztid'],0);
	$dopath=ECMS_PATH.$doclasspath."/";
	//��ҳ
	if($cr['islist']!=1)
	{
		$file=$dopath.$tfile.$filetype;
		DelFiletext($file);
		//moreportdo
		if($tfile)
		{
			$eautodofile=$doclasspath."/".$tfile.$filetype;
			$eautodofname='delfile|'.$eautodofile.'||';
			eAutodo_AddDo('eDelFileZTC',0,0,0,0,0,$eautodofname);
		}
		return '';
	}
	//����
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsztinfo where cid='$cid'");
	if(!$num)
	{
		$num=1;
	}
	$totalpage=ceil($num/$cr['tnum']);
	for($i=1;$i<=$totalpage;$i++)
	{
		if($i==1)
		{
			$file=$dopath.$tfile.$filetype;
		}
		else
		{
			$file=$dopath.$tfile.'_'.$i.$filetype;
		}
		DelFiletext($file);
	}
	//moreportdo
	if($tfile)
	{
		$eautodofile=$doclasspath."/".$tfile;
		$eautodofname='delfile|'.$eautodofile.'|'.$filetype.'|'.$totalpage;
		eAutodo_AddDo('eDelFileZTC',0,0,0,0,0,$eautodofname);
	}
}

//�滻ͼƬ��ǩ
function RepImg($text,$copyflash){
	global $ecms_config;
	$exp1="[--copyimg--]";
	$exp2="[/--copyimg--]";
	//ȥ��ͼƬ����
	if($ecms_config['sets']['saveurlimgclearurl']==1)
	{
		$zz2="/\<(a|A) (.*?)(href|Href)=('|\"|\\\\\"|)(.+?)><(img|IMG) (.*?)(src|SRC)=('|\"|\\\\\"|)(.+?)(\.jpg|\.JPG|\.gif|\.GIF|\.png|\.PNG|\.bmp|\.BMP|\.jpeg|\.JPEG)(.*?)><\/(a|A)>/is";
		$text=preg_replace($zz2,"<\\6 \\7\\8=\\9\\10\\11\\12>",$text);
	}
	$zz1="/\<(img|IMG) (.*?)(src|SRC)=('|\"|\\\\\"|)(.+?)(\.jpg|\.JPG|\.gif|\.GIF|\.png|\.PNG|\.bmp|\.BMP|\.jpeg|\.JPEG)(.*?)>/is";
	$text=preg_replace($zz1,"<\\1 \\2\\3=\\4".$exp1."\\5\\6".$exp2."\\7>",$text);
	return $text;
}

//�滻flash��ǩ
function RepFlash($text,$copyflash){
	$exp1="[--copyimg--]";
	$exp2="[/--copyimg--]";
	//ȥ��flash��������
	$zz2="/\<(embed|EMBED) (.*?)(src|SRC)=('|\"|\\\\\"|)(.+?)(\.swf|\.SWF)(.*?)>(.*?)<\/(embed|EMBED)>/is";
	$text=preg_replace($zz2,"",$text);
	$zz3="/\<(param|PARAM) (name|NAME)=\"(Src|src|SRC)\" (.*?)(value|VALUE)=('|\"|\\\\\"|)(.+?)(\.swf|\.SWF)(.*?)>/is";
	$text=preg_replace($zz3,"",$text);

	$zz1="/\<(param|PARAM) (.*?)(name|NAME)=\"(movie|MOVIE)\" (.*?)(value|VALUE)=('|\"|\\\\\"|)(.+?)(\.swf|.SWF)(\.*?)>/is";
	$text=preg_replace($zz1,"<\\1 \\2\\3=\"\\4\" \\5\\6=\\7".$exp1."\\8\\9".$exp2."\\10>",$text);
	return $text;
}

//�滻ͼƬ����
function DoRepImgLink($text,$newurl){
	//ȥ��ͼƬ����
	$zz2="/\<(a|A) (.*?)(href|Href)=('|\"|\\\\\"|)(.+?)><(img|IMG) (.*?)(src|SRC)=('|\"|\\\\\"|)(.*?)><\/(a|A)>/is";
	$text=preg_replace($zz2,"<\\6 \\7\\8=\\9\\10>",$text);
	//������
	$zz1="/\<(img|IMG) (.*?)(src|SRC)=('|\"|\\\\\"|)(.*?)>/is";
	$text=preg_replace($zz1,"<a href=\"".$newurl."\"><\\1 \\2\\3=\\4\\5></a>",$text);
	return $text;
}

//��ȡͼƬ
function CopyImg($text,$copyimg,$copyflash,$classid,$qz,$username,$theid,$cjid,$mark,$fstb=1){
	global $empire,$public_r,$cjnewsurl,$navtheid,$dbtbpre;
	if(empty($text))
	{return "";}
	$navtheid=(int)$navtheid;
	$fstb=(int)$fstb;
	if($copyimg)
	{
		$text=RepImg($text,$copyflash);
	}
	if($copyflash)
	{$text=RepFlash($text,$copyflash);}
	$exp1="[--copyimg--]";
	$exp2="[/--copyimg--]";
	$r=explode($exp1,$text);
	for($i=1;$i<count($r);$i++)
	{
		$r1=explode($exp2,$r[$i]);
		if(strstr($r1[0],"http://")||strstr($r1[0],"https://"))
	    {
			$dourl=$r1[0];
		}
		else
	    {
			//�Ƿ��Ǳ���ַ
			if(!strstr($r1[0],"/")&&$cjnewsurl)
			{
				$fileqz_r=GetPageurlQz($cjnewsurl);
				$fileqz=$fileqz_r['selfqz'];
				$dourl=$fileqz.$r1[0];
			}
			else
			{
				$dourl=$qz.$r1[0];
			}
		}
		$return_r=DoTranUrl($dourl,$classid);
		$text=str_replace($exp1.$r1[0].$exp2,$return_r[url],$text);
		if($return_r[tran])
	    {
			//��¼���ݿ�
			//��������
			$return_r[filesize]=(int)$return_r[filesize];
			$classid=(int)$classid;
			$return_r[type]=(int)$return_r[type];
			$theid=(int)$theid;
			$cjid=(int)$cjid;
			eInsertFileTable($return_r[filename],$return_r[filesize],$return_r[filepath],$username,$classid,'[URL]'.$return_r[filename],$return_r[type],$theid,$cjid,$public_r[fpath],0,0,$fstb);
			//��ˮ
			if($mark&&$return_r[type]==1)
			{
				GetMyMarkImg($return_r['yname']);
			}
        }
	}
	return $text;
}

//��������ͼ
function GetMySmallImg($classid,$no,$insertfile,$filepath,$yname,$maxwidth,$maxheight,$name,$id,$cjid,$userid,$username,$modtype=0,$fstb=1){
	global $empire,$dbtbpre,$public_r,$efileftp_fr;
	if(empty($yname))
	{
		return "";
    }
	$no="[s]".$no;
	$maxwidth=(int)$maxwidth;
	$maxheight=(int)$maxheight;
	$filer=ResizeImage($yname,$name,$maxwidth,$maxheight,$public_r['spickill']);
	if($filer['file'])
	{
		$insertfile="small".$insertfile.$filer['filetype'];
		$filesize=@filesize($filer['file']);
		//д�����ݿ�
		$pubid=0;
		if($id&&!$cjid)
		{
			$pubid=ReturnInfoPubid($classid,$id);
		}
		//��������
		$filesize=(int)$filesize;
		$classid=(int)$classid;
		$id=(int)$id;
		$cjid=(int)$cjid;
		eInsertFileTable($insertfile,$filesize,$filepath,$username,$classid,$no,1,$id,$cjid,$public_r[fpath],$pubid,$modtype,$fstb);
		//FileServer
		if($public_r['openfileserver'])
		{
			$efileftp_fr[]=$name.$filer['filetype'];
		}
    }
	return $filer;
}

//ͼƬ��ˮӡ
function GetMyMarkImg($groundImage){
	global $public_r;
	if(empty($groundImage))
	{
		return "";
    }
	imageWaterMark($groundImage,$public_r['markpos'],$public_r['markimg'],$public_r['marktext'],$public_r['markfontsize'],$public_r['markfontcolor'],$public_r['markfont'],$public_r['markpct'],$public_r['jpgquality']);
}

//ͶƱ���
function ReturnVote($votename,$votenum,$delvid,$vid,$enews=0){
	global $empire,$dbtbpre;
	$f_exp="::::::";
	$r_exp="\r\n";
	$returnstr="";
	//����ͶƱ
	if(empty($enews))
	{
		for($i=0;$i<count($votename);$i++)
		{
			//�滻�Ƿ��ַ�
			$name=str_replace($f_exp,"",$votename[$i]);
			$name=str_replace($r_exp,"",$name);
			$num=str_replace($f_exp,"",$votenum[$i]);
			$num=str_replace($r_exp,"",$num);
			if($name)
			{
				if(empty($num))
				{$num=0;}
				$returnstr.=$name.$f_exp.$num.$r_exp;
			}
		}
	}
	//�޸�ͶƱ
	else
	{
		for($i=0;$i<count($votename);$i++)
		{
			//ɾ�����ص�ַ
			$del=0;
			for($j=0;$j<count($delvid);$j++)
			{
				if($delvid[$j]==$vid[$i])
				{$del=1;}
			}
			if($del)
			{continue;}
			//�滻�Ƿ��ַ�
			$name=str_replace($f_exp,"",$votename[$i]);
			$name=str_replace($r_exp,"",$name);
			$num=str_replace($f_exp,"",$votenum[$i]);
			$num=str_replace($r_exp,"",$num);
			if($name)
			{
				if(empty($num))
				{$num=0;}
				$returnstr.=$name.$f_exp.$num.$r_exp;
			}
		}
	}
	/*
	if(empty($returnstr))
	{printerror("EmptyVotenum","history.go(-1)");}
	*/
	//ȥ�������ַ�
	$returnstr=substr($returnstr,0,strlen($returnstr)-2);
	return $returnstr;
}

//��ʾ���޼���Ŀ[������Ŀʱ]
function ShowClass_AddClass($adminclass,$obclassid,$bclassid,$exp,$modid,$enews=0,$addminfocid=''){
	global $empire,$dbtbpre,$public_r;
	if(empty($bclassid))
	{
		$bclassid=0;
		$exp="|-";
		if($enews==2)
		{
			$modr=$empire->fetch1("select sonclass from {$dbtbpre}enewsmod where mid='$modid'");
			$addminfocid=$modr['sonclass'];
		}
    }
	else
	{$exp="&nbsp;&nbsp;".$exp;}
	$sql=$empire->query("select classid,classname,bclassid,islast,openadd,modid,sonclass from {$dbtbpre}enewsclass where bclassid='$bclassid' and wburl='' order by myorder,classid");
	$returnstr="";
	while($r=$empire->fetch($sql))
	{
		//Ͷ����ʾ
		if($enews==2)
		{
			if($r[openadd])
			{
				continue;
			}
			if(CheckHaveInClassid($r,$addminfocid)==0)
			{
				continue;
			}
		}
		if($r[islast])
		{
			if(empty($enews)||$enews==2||$enews==3||$enews==4)
			{
				$color=" style='background:#".$public_r['chclasscolor']."'";
			}
			//���ز���Ͷ�����Ŀ
			if($enews==2)
			{
				if($modid)
				{
					if($r[modid]<>$modid)
				    {continue;}
				}
			}
			//ģ��
			if($enews==4)
			{
				if($r[modid]<>$modid)
				{continue;}
			}
		}
		else
		{$color="";}
		if($r[classid]==$obclassid)
		{$select=" selected";}
		else
		{$select="";}
		//-----------�����û�ʱ
		if($enews==3)
		{
			$c=explode("|".$r[classid]."|",$adminclass);
			if(count($c)>1)
			{$select=" selected";}
			else
			{$select="";}
	    }
		$returnstr.="<option value=".$r[classid].$select.$color.">".$exp.$r[classname]."</option>";
		if(empty($r[islast]))
		{
			$returnstr.=ShowClass_AddClass($adminclass,$obclassid,$r[classid],$exp,$modid,$enews,$addminfocid);
		}
	}
	return $returnstr;
}

//��������
function SetDisplayClass($open){
	$time=time()+365*24*3600;
	$set=esetcookie("displayclass",$open,$time,1);
	echo"<script>self.location.href='ListClass.php".hReturnEcmsHashStrHref2(1)."';</script>";
	exit();
}

//ɾ��Ŀ¼����
function DelPath($DelPath){
	if($DelPath=="../../"||$DelPath=="../../d/file/")
	{return "";}
	$wm_chief=new del_path();
	$wm_chief_ok=$wm_chief->wm_chief_delpath($DelPath);
	return $wm_chief_ok;
}

//����Ŀ¼
function CopyPath($oldpath,$newpath){
	$wm_chief=new copy_path();
    $wm_chief_ok=$wm_chief->wm_chief_copypath($oldpath,$newpath);
	return $wm_chief_ok;
}

//�ƶ�Ŀ¼
function MovePath($oldpath,$newpath){
	//����
	CopyPath($oldpath,$newpath);
	//ɾ��
	DelPath($oldpath);
}

//�滻�ַ�
function RepInfoZZ($text,$exp,$enews=0){
	$text=str_replace(".","\\.",$text);
	$text=str_replace("(","\\(",$text);
	$text=str_replace(")","\\)",$text);
	$text=str_replace("?","\\?",$text);
	$text=str_replace("*","(.*?)",$text);
	$text=str_replace("[!--".$exp."--]","(.*?)",$text);
	//$text=str_replace("\\","\\\\",$text);
	//$text=str_replace("\"","\"",$text);
	$text=str_replace("/","\\/",$text);
	$text=str_replace("-","\\-",$text);
	$text=str_replace("|","\\|",$text);
	$text=str_replace("+","\\+",$text);
	$text=str_replace("^","\\^",$text);
	$text=str_replace("{","\\{",$text);
	$text=str_replace("}","\\}",$text);
	$text=str_replace("[","\\[",$text);
	$text=str_replace("]","\\]",$text);
	$text=str_replace("\$","\\\$",$text);
	$text="/".$text."/is";
	return $text;
}

//ȡ�õ�ַǰ׺
function GetPageurlQz($self){
	$sr=explode("/",$self);
	$count=count($sr)-1;
	$sfile=$sr[$count];
	$r['selfqz']=substr($self,0,strlen($self)-strlen($sfile));
	//ȡ������
	$expstr=stristr($self,'https://')?'https://':'http://';
	$sr1=explode($expstr,$self);
	$sr2=explode("/",$sr1[1]);
	$r['domain']=$expstr.$sr2[0];
	return $r;
}

//ȥ��������
function RepDyh($text){
	//$text=str_replace("\'","\\\'",stripSlashes($text));
	$text=addslashes(stripSlashes($text));
	return $text;
}

//����
function AddNumZero($no,$endno){
	$len=strlen($endno);
	$forlen=$len-strlen($no);
	for($i=1;$i<=$forlen;$i++)
	{
		$no="0".$no;
	}
	return $no;
}

//�Զ���ҳ
function AutoDoPage($mybody,$spsize){
  $sptag="[!--empirenews.page--]";
  if(strlen($mybody)<$spsize) return $mybody;
  $bds = explode('<',$mybody);
  $npageBody = "";
  $istable = 0;
  $mybody = "";
  foreach($bds as $i=>$k)
  {
  	 if($i==0){ $npageBody .= $bds[$i]; continue;}
  	 $bds[$i] = "<".$bds[$i];
  	 if(strlen($bds[$i])>6){
  		  $tname = substr($bds[$i],1,5);
  		  if(strtolower($tname)=='table') $istable++;
  		  else if(strtolower($tname)=='/tabl') $istable--;
  		  if($istable>0){ $npageBody .= $bds[$i]; continue; }
  		  else $npageBody .= $bds[$i];
  	 }else{
  		  $npageBody .= $bds[$i];
  	 }
  	 if(strlen($npageBody)>$spsize){
  		  $mybody .= $npageBody.$sptag;
  		  $npageBody = "";
     }
  }
  if($npageBody!="") $mybody .= $npageBody;
  return $mybody;
}



//-------------- ģ���� ----------------------

//ȡ��ģ��ID
function GetListtempMid($tempid){
	global $empire;
	$r=$empire->fetch1("select modid from ".GetTemptb("enewslisttemp")." where tempid='$tempid'");
	return $r[modid];
}

//�滻ģ��JS��ַ
function RepTemplateJsUrl($temp,$classid,$enews=0){
	global $public_r,$class_r,$class_zr;
	$allpath='[!--news.url--]d/js/js/';
	$temp=str_replace("[!--hotnews--]","<script src='".$allpath."hotnews.js'></script>",$temp);
	$temp=str_replace("[!--newnews--]","<script src='".$allpath."newnews.js'></script>",$temp);
	$temp=str_replace("[!--goodnews--]","<script src='".$allpath."goodnews.js'></script>",$temp);
	$temp=str_replace("[!--hotplnews--]","<script src='".$allpath."hotplnews.js'></script>",$temp);
	$temp=str_replace("[!--firstnews--]","<script src='".$allpath."firstnews.js'></script>",$temp);
	if(!empty($classid))
	{
		$path=$enews==1?'[!--news.url--]d/js/class/zt[!--self.classid--]_':'[!--news.url--]d/js/class/class[!--self.classid--]_';
		$temp=str_replace("[!--self.hotnews--]","<script src='".$path."hotnews.js'></script>",$temp);
		$temp=str_replace("[!--self.newnews--]","<script src='".$path."newnews.js'></script>",$temp);
		$temp=str_replace("[!--self.goodnews--]","<script src='".$path."goodnews.js'></script>",$temp);
		$temp=str_replace("[!--self.hotplnews--]","<script src='".$path."hotplnews.js'></script>",$temp);
		$temp=str_replace("[!--self.firstnews--]","<script src='".$path."firstnews.js'></script>",$temp);
	}
	return $temp;
}




//-------------- ������ ----------------------

//ȡ���б�ģ��
function GetListTemp($tempid){
	global $empire;
	$r=$empire->fetch1("select temptext,subnews,listvar,rownum,showdate,modid,subtitle,docode from ".GetTemptb("enewslisttemp")." where tempid='$tempid'");
	$r[temptext]=InfoNewsBq('list'.$tempid,$r[temptext]);
	return $r;
}

//ȡ�÷���ģ��
function GetClassTemp($tempid){
	global $empire;
	$r=$empire->fetch1("select temptext from ".GetTemptb("enewsclasstemp")." where tempid='$tempid'");
	return $r['temptext'];
}

//ȡ����Ŀҳ������
function GetClassText($classid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select classtext from {$dbtbpre}enewsclassadd where classid='$classid'");
	return $r['classtext'];
}

//ȡ��ר��ҳ������
function GetZtText($ztid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select classtext from {$dbtbpre}enewsztadd where ztid='$ztid'");
	return $r['classtext'];
}

//ȡ��ר������ҳ������
function GetZtcText($cid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select classtext from {$dbtbpre}enewszttypeadd where cid='$cid'");
	return $r['classtext'];
}

//ȡ����ҳģ��
function GetIndextemp(){
	global $empire,$dbtbpre,$public_r;
	if($public_r['indexpageid'])
	{
		$r=$empire->fetch1("select temptext from {$dbtbpre}enewsindexpage where tempid='".$public_r['indexpageid']."'");
		return $r['temptext'];
	}
	$r=$empire->fetch1("select indextemp from ".GetTemptb("enewspubtemp")." limit 1");
	return $r['indextemp'];
}

//ȡ������ģ��
function GetNewsTemp($newstempid){
	global $empire,$public_r;
	$r=$empire->fetch1("select temptext,showdate from ".GetTemptb("enewsnewstemp")." where tempid='$newstempid'");
	$r[temptext]=InfoNewsBq('news'.$newstempid,$r[temptext]);
	if($public_r[opennotcj])//���÷��ɼ�
	{
		$r[temptext]=ReturnNotcj($r[temptext]);
    }
	return $r;
}

//ȡ��jsģ��
function GetTheJstemp($tempid){
	global $empire;
	$r=$empire->fetch1("select temptext,showdate,modid,subnews,subtitle from ".GetTemptb("enewsjstemp")." where tempid='$tempid'");
	return $r;
}

//�滻ȫ��ģ�����
function ReplaceTempvar($temp){
	global $empire;
	if(empty($temp))
	{return $temp;}
	$sql=$empire->query("select myvar,varvalue from ".GetTemptb("enewstempvar")." where isclose=0 order by myorder desc,varid");
	while($r=$empire->fetch($sql))
	{
		$temp=str_replace('[!--temp.'.$r[myvar].'--]',$r[varvalue],$temp);
    }
	return $temp;
}

//��Ŀҳ�滻�������
function Class_ReplaceSvars($temp,$url,$classid,$title,$key,$des,$classimg,$add,$enews=0){
	global $public_r,$class_r,$class_zr;
	$temp=str_replace('[!--class.menu--]',$public_r['classnavs'],$temp);//��Ŀ����
	$temp=str_replace('[!--pagetitle--]',$title,$temp);
	$temp=str_replace('[!--pagekey--]',$key,$temp);
	$temp=str_replace('[!--pagedes--]',$des,$temp);
	$temp=str_replace('[!--class.intro--]',$des,$temp);
	$temp=str_replace('[!--class.keywords--]',$key,$temp);
	$temp=str_replace('[!--class.classimg--]',$classimg,$temp);
	$temp=str_replace('[!--self.classid--]',$classid,$temp);
	if($enews==0)//��Ŀ
	{
		$temp=str_replace('[!--class.name--]',$class_r[$classid]['classname'],$temp);
		$bclassid=$class_r[$classid]['bclassid'];
		$temp=str_replace('[!--bclass.id--]',$bclassid,$temp);
		$temp=str_replace('[!--bclass.name--]',$class_r[$bclassid]['classname'],$temp);
		$path=$public_r['newsurl'].'d/js/class/class'.$classid.'_';
	}
	else//ר��
	{
		$temp=str_replace('[!--class.name--]',$class_zr[$classid]['ztname'],$temp);
		$path=$public_r['newsurl'].'d/js/class/zt'.$classid.'_';
	}
	$allpath=$public_r[newsurl].'d/js/js/';
	//��������
	$temp=str_replace("[!--hotnews--]","<script src='".$allpath."hotnews.js'></script>",$temp);
	$temp=str_replace("[!--self.hotnews--]","<script src='".$path."hotnews.js'></script>",$temp);
	//�������
	$temp=str_replace("[!--newnews--]","<script src='".$allpath."newnews.js'></script>",$temp);
	$temp=str_replace("[!--self.newnews--]","<script src='".$path."newnews.js'></script>",$temp);
	//�Ƽ�
	$temp=str_replace("[!--goodnews--]","<script src='".$allpath."goodnews.js'></script>",$temp);
	$temp=str_replace("[!--self.goodnews--]","<script src='".$path."goodnews.js'></script>",$temp);
	//��������
	$temp=str_replace("[!--hotplnews--]","<script src='".$allpath."hotplnews.js'></script>",$temp);
	$temp=str_replace("[!--self.hotplnews--]","<script src='".$path."hotplnews.js'></script>",$temp);
	//ͷ������
	$temp=str_replace("[!--firstnews--]","<script src='".$allpath."firstnews.js'></script>",$temp);
	$temp=str_replace("[!--self.firstnews--]","<script src='".$path."firstnews.js'></script>",$temp);
	$temp=str_replace('[!--news.url--]',$public_r['newsurl'],$temp);
	return $temp;
}

//����ҳ�滻�������
function Info_ReplaceSvars($temp,$url,$classid,$title,$key,$des){
	global $public_r,$class_r;
	$temp=str_replace('[!--class.menu--]',$public_r['classnavs'],$temp);//��Ŀ����
	$temp=str_replace('[!--newsnav--]','<?=$grurl?>',$temp);//λ�õ���
	$temp=str_replace('[!--pagetitle--]','<?=$grpagetitle?>',$temp);
	$temp=str_replace('[!--pagekey--]','<?=$ecms_gr[keyboard]?>',$temp);
	$temp=str_replace('[!--pagedes--]','<?=$grpagetitle?>',$temp);
	$temp=str_replace('[!--self.classid--]','<?=$ecms_gr[classid]?>',$temp);
	$bclassid=$class_r[$classid]['bclassid'];
	$temp=str_replace('[!--bclass.id--]','<?=$grbclassid?>',$temp);
	$temp=str_replace('[!--bclass.name--]','<?=$class_r[$grbclassid][classname]?>',$temp);
	$temp=str_replace('[!--news.url--]',$public_r['newsurl'],$temp);
	return $temp;
}

//��̬����ҳ�滻�������
function DtInfo_ReplaceSvars($temp,$url,$classid,$title,$key,$des){
	global $public_r,$class_r;
	$temp=str_replace('[!--class.menu--]',$public_r['classnavs'],$temp);//��Ŀ����
	$temp=str_replace('[!--newsnav--]',$url,$temp);//λ�õ���
	$temp=str_replace('[!--pagetitle--]',$title,$temp);
	$temp=str_replace('[!--pagekey--]',$key,$temp);
	$temp=str_replace('[!--pagedes--]',$des,$temp);
	$temp=str_replace('[!--self.classid--]',$classid,$temp);
	$bclassid=$class_r[$classid]['bclassid'];
	$temp=str_replace('[!--bclass.id--]',$bclassid,$temp);
	$temp=str_replace('[!--bclass.name--]',$class_r[$bclassid]['classname'],$temp);
	$temp=str_replace('[!--news.url--]',$public_r['newsurl'],$temp);
	return $temp;
}

//�滻����ģ���ļ�
function ReplaceStemp($temptext,$class,$url,$classid,$title,$key,$des,$repvar=1){
	global $public_r;
	if($repvar==1)//ȫ��ģ�����
	{
		$temptext=ReplaceTempvar($temptext);
	}
	$temptext=str_replace('[!--class.menu--]',$public_r['classnavs'],$temptext);//��Ŀ����
	$temptext=str_replace("[!--class--]",$class,$temptext);
	$temptext=str_replace('[!--pagetitle--]',$title,$temptext);
	$temptext=str_replace('[!--pagekey--]',$key,$temptext);
	$temptext=str_replace('[!--pagedes--]',$des,$temptext);
	$temptext=str_replace('[!--self.classid--]',$classid,$temptext);
	//��������
	$temptext=str_replace("[!--hotnews--]","<script src='".$public_r[newsurl]."d/js/js/hotnews.js'></script>",$temptext);
	//�������
	$temptext=str_replace("[!--newnews--]","<script src='".$public_r[newsurl]."d/js/js/newnews.js'></script>",$temptext);
	//�Ƽ�
	$temptext=str_replace("[!--goodnews--]","<script src='".$public_r[newsurl]."d/js/js/goodnews.js'></script>",$temptext);
	//��������
	$temptext=str_replace("[!--hotplnews--]","<script src='".$public_r[newsurl]."d/js/js/hotplnews.js'></script>",$temptext);
	//������
	$temptext=str_replace("[!--url--]",$url,$temptext);
	$temptext=str_replace('[!--newsnav--]',$url,$temptext);//λ�õ���
	$temptext=str_replace("[!--news.url--]",$public_r[newsurl],$temptext);
	$temptext=str_replace("[!--newsurl--]",$public_r[newsurl],$temptext);
	return $temptext;
}

//��Ŀҳ��֤
function AddCheckClassLevel($classid,$groupid,$classpath){
	$classpath=ReturnSaveClassPath($classid);
	$pr=explode('/',$classpath);
	$pcount=count($pr);
	for($i=0;$i<$pcount;$i++)
	{
		$include.='../';
	}
	$include1=$include;
	$include.='e/class/CheckClassLevel.php';
	$addlevel="<?php
	define('empirecms','wm_chief');
	\$check_groupid=\"".$groupid."\";
	\$check_classid=".$classid.";
	\$check_path=\"".$include1."\";
	require(\"".$include."\");
	?>";
	return $addlevel;
}

//������Ŀ����Ϣҳ��
function ReClassBdInfo($classid){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	$cr=$empire->fetch1("select classid,bdinfoid from {$dbtbpre}enewsclass where classid='$classid'");
	if(!$cr['classid']||!$cr['bdinfoid'])
	{
		return '';
	}
	eAutodo_AddDo('ReListHtml',$classid,0,0,0,0);//moreportdo
	$infor=explode(',',$cr['bdinfoid']);
	$infofile=GetInfoFilename(intval($infor[0]),intval($infor[1]));
	$classtext='';
	if($infofile)
	{
		if(file_exists($infofile))
		{
			$classtext=ReadFiletext($infofile);
		}
		else
		{
			$classtext=ReClassBdInfoDtHtml($infor[0],$infor[1]);
		}
	}
	$classfile=eReturnTrueEcmsPath().ReturnSaveClassPath($classid,1);//moreport
	WriteFiletext_n($classfile,$classtext);
}

//��Ŀ�󶨶�̬��Ϣ
function ReClassBdInfoDtHtml($classid,$id){
	global $empire,$dbtbpre,$public_r;
	$classid=(int)$classid;
	$id=(int)$id;
	if(!$classid||!$id)
	{
		return '';
	}
	$infourl=$public_r['newsurl'].'e/public/InfoUrl/?classid='.$classid.'&id='.$id;
	$html='<meta http-equiv="refresh" content="0;url='.$infourl.'">';
	return $html;
}

//������Ƭ�ļ�
function DoSpReFile($r,$spid=0){
	global $empire,$dbtbpre;
	if($spid)
	{
		$r=$empire->fetch1("select spid,varname,refile,spfile,spfileline,spfilesub from {$dbtbpre}enewssp where spid='$spid' limit 1");
	}
	if(!$r['refile'])
	{
		return '';
	}
	eAutodo_AddDo('ReSp',$r['spid'],0,0,0,0);//moreportdo
	ob_start();
	sys_eShowSpInfo($r['varname'],$r['spfileline'],$r['spfilesub']);
	$string=ob_get_contents();
	ob_end_clean();
	$filename=eReturnTrueEcmsPath().$r['spfile'];
	WriteFiletext($filename,$string);
}

//��ǩ�滻
function NewsBq($classid,$indextext,$enews=0,$doing=0){
	global $empire,$dbtbpre,$public_r,$emod_r,$class_r,$class_zr,$fun_r,$navclassid,$navinfor,$class_tr,$level_r,$etable_r;
	$indextext=stripSlashes($indextext);
	$indextext=ReplaceTempvar($indextext);//�滻ȫ��ģ�����
	$classlevel='';
	if($enews==0)//���ɴ���Ŀ
	{
		if($class_r[$classid]['listdt']||$class_r[$classid]['wburl']||strstr($public_r['nreclass'],','.$classid.',')||InfoIsInTable($class_r[$classid]['tbname']))//��������Ŀ
		{
			return '';
		}
		$GLOBALS['navclassid']=$classid;
		$url=ReturnClassLink($classid);//����
		$cf=$doing==1?',classpath,classtype,classname':'';
		$cr=$empire->fetch1("select classpagekey,intro,classimg,cgroupid".$cf." from {$dbtbpre}enewsclass where classid='$classid'");
		if(!empty($cf))
		{
			$class_r[$classid][classpath]=$cr[classpath];
			$class_r[$classid][classtype]=$cr[classtype];
			$class_r[$classid][classname]=$cr[classname];
		}
		eAutodo_AddDo('ReListHtml',$classid,0,0,0,0);//moreportdo
		//Ȩ��
		if($cr['cgroupid'])
		{
			$classlevel=AddCheckClassLevel($classid,$cr['cgroupid'],'');
		}
		//ҳ��
		$pagetitle=ehtmlspecialchars($class_r[$classid][classname]);
		$pagekey=ehtmlspecialchars($cr['classpagekey']);
		$pagedes=ehtmlspecialchars($cr['intro']);
		$classimg=$cr['classimg'];
		$onclick="<script src=".$public_r[newsurl]."e/public/onclick/?enews=doclass&classid=$classid></script>";
		$truefile=eReturnTrueEcmsPath().ReturnSaveClassPath($classid,1);//moreport
		$file=eReturnTrueEcmsPath().'e/data/tmp/class'.$classid.'.php';
		$indextext=str_replace("[!--newsnav--]",$url,$indextext);//λ�õ���
		$indextext=Class_ReplaceSvars($indextext,$url,$classid,$pagetitle,$pagekey,$pagedes,$classimg,$add,0);
	}
	elseif($enews==3)//ר��
	{
		$GLOBALS['navclassid']=$classid;
		$url=ReturnZtLink($classid);//����
		$cf=$doing==1?',ztpath,zttype,ztname':'';
		$cr=$empire->fetch1("select ztpagekey,intro,ztimg".$cf." from {$dbtbpre}enewszt where ztid='$classid'");
		if(!empty($cf))
		{
			$class_zr[$classid][ztpath]=$cr[ztpath];
			$class_zr[$classid][zttype]=$cr[zttype];
			$class_zr[$classid][ztname]=$cr[ztname];
	    }
		eAutodo_AddDo('ReZtListHtml',$classid,0,0,0,0);//moreportdo
		$pagetitle=ehtmlspecialchars($class_zr[$classid][ztname]);
		$pagekey=ehtmlspecialchars($cr['ztpagekey']);
		$pagedes=ehtmlspecialchars($cr['intro']);
		$classimg=$cr['ztimg'];
		$onclick="<script src=".$public_r[newsurl]."e/public/onclick/?enews=dozt&ztid=$classid></script>";
		$truefile=eReturnTrueEcmsPath().ReturnSaveZtPath($classid,1);//moreport
		$file=eReturnTrueEcmsPath().'e/data/tmp/zt'.$classid.'.php';
		$indextext=str_replace("[!--newsnav--]",$url,$indextext);//λ�õ���
		$indextext=Class_ReplaceSvars($indextext,$url,$classid,$pagetitle,$pagekey,$pagedes,$classimg,$add,1);
	}
	elseif($enews==4)//ר������
	{
		$cr=$empire->fetch1("select ztid,cname,ttype,tfile from {$dbtbpre}enewszttype where cid='$classid'");
		eAutodo_AddDo('ReZtcListHtml',$classid,0,0,0,0);//moreportdo
		$GLOBALS['navclassid']=$classid;
		$GLOBALS['navinfor']['ecmsbid']=$cr['ztid'];
		$url=ReturnZtLink($cr['ztid']);//����
		$pagetitle=ehtmlspecialchars($cr['cname']);
		$pagekey=ehtmlspecialchars($cr['cname']);
		$pagedes=ehtmlspecialchars($cr['cname']);
		$onclick="<script src=".$public_r[newsurl]."e/public/onclick/?enews=dozt&ztid=$cr[ztid]></script>";
		$truefile=eReturnTrueEcmsPath().ReturnSaveZtPath($cr['ztid'],0).'/'.$cr['tfile'].$cr['ttype'];//moreport
		$file=eReturnTrueEcmsPath().'e/data/tmp/ztc'.$classid.'.php';
		$indextext=str_replace("[!--newsnav--]",$url,$indextext);//λ�õ���
		$indextext=Class_ReplaceSvars($indextext,$url,$classid,$pagetitle,$pagekey,$pagedes,$classimg,$add,1);
	}
	elseif($enews==1)//������ҳ�ļ�
	{
		$pr=$empire->fetch1("select sitekey,siteintro,indexpagedt from {$dbtbpre}enewspublic limit 1");
		if($pr['indexpagedt']||(Moreport_ReturnMustDt()&&!defined('ECMS_SELFPATH')))//moreport
		{
			return '';
		}
		eAutodo_AddDo('ReIndex',0,0,0,0,0,'',1);//moreportdo
		//ҳ��
		$pagetitle=ehtmlspecialchars($public_r['sitename']);
		$pagekey=ehtmlspecialchars($pr['sitekey']);
		$pagedes=ehtmlspecialchars($pr['siteintro']);
		$url="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";//��Ŀ����
		$onclick='';
		$truefile=eReturnTrueEcmsPath().ReturnSaveIndexFile();//moreport
		$file=eReturnTrueEcmsPath().'e/data/tmp/index.php';
		$indextext=ReplaceSvars($indextext,$url,0,$pagetitle,$pagekey,$pagedes,$add,0);
	}
	$indextext=str_replace("[!--page.stats--]",$onclick,$indextext);
	//�滻��ǩ
	$indextext=DoRepEcmsLoopBq($indextext);
	$indextext=RepBq($indextext);
	//д�ļ�
	WriteFiletext($file,AddCheckViewTempCode().$indextext);
	//��ȡ�ļ�����
    ob_start();
	include($file);
	$string=ob_get_contents();
	ob_end_clean();
	$string=RepExeCode($string);//��������
	WriteFiletext($truefile,$classlevel.$string);
	return $string;
}

//��ǩ�滻2
function InfoNewsBq($classid,$indextext){
	global $empire,$dbtbpre,$public_r,$emod_r,$class_r,$class_zr,$fun_r,$navclassid,$navinfor,$class_tr,$level_r,$etable_r;
	if(!defined('EmpireCMSAdmin'))
	{
		$_GET['reallinfotime']=0;
	}
	if($_GET['reallinfotime'])
	{
		$classid.='_all';
	}
	$file=eReturnTrueEcmsPath().'e/data/tmp/temp'.$classid.'.php';
	if($_GET['reallinfotime']&&file_exists($file))
	{
		$filetime=filemtime($file);
		if($_GET['reallinfotime']<=$filetime)
		{
			ob_start();
			include($file);
			$string=ob_get_contents();
			ob_end_clean();
			$string=RepExeCode($string);//��������
			return $string;
		}
	}
	$indextext=stripSlashes($indextext);
	$indextext=ReplaceTempvar($indextext);//�滻ȫ��ģ�����
	//�滻��ǩ
	$indextext=DoRepEcmsLoopBq($indextext);
	$indextext=RepBq($indextext);
	//д�ļ�
	WriteFiletext($file,AddCheckViewTempCode().$indextext);
	//��ȡ�ļ�����
    ob_start();
	include($file);
	$string=ob_get_contents();
	ob_end_clean();
	$string=RepExeCode($string);//��������
	return $string;
}

//��ǩ�滻3
function GetInfoNewsBq($classid,$newstemp_r,$ecms_gr,$docheckrep){
	global $empire,$dbtbpre,$public_r,$emod_r,$class_r,$class_zr,$fun_r,$navclassid,$navinfor,$class_tr,$level_r,$etable_r;
	if(!defined('EmpireCMSAdmin'))
	{
		$_GET['reallinfotime']=0;
	}
	if($_GET['reallinfotime'])
	{
		$file=eReturnTrueEcmsPath().'e/data/tmp/tempnews'.$newstemp_r['tempid'].'_all.php';
	}
	else
	{
		$file=eReturnTrueEcmsPath().'e/data/tmp/tempnews'.$newstemp_r['tempid'].'.php';
	}
	//��������
	$grurl=ReturnClassLink($ecms_gr['classid']);//����
	$grpagetitle=ehtmlspecialchars($ecms_gr['title']);
	$grbclassid=$class_r[$ecms_gr['classid']]['bclassid'];
	$grtitleurl=sys_ReturnBqTitleLink($ecms_gr);
	$grclassurl=sys_ReturnBqClassname($ecms_gr,9);

	if($_GET['reallinfotime']&&file_exists($file))
	{
		$filetime=filemtime($file);
		if($_GET['reallinfotime']<=$filetime)
		{
			ob_start();
			include($file);
			$string=ob_get_contents();
			ob_end_clean();
			$string=RepExeCode($string);//��������
			return $string;
		}
	}
	$formatdate=$newstemp_r['showdate'];
	
	$newstemp_r['temptext']=stripSlashes($newstemp_r['temptext']);
	$newstemp_r['temptext']=ReplaceTempvar($newstemp_r['temptext']);//�滻ȫ��ģ�����
	//�滻��ǩ
	$newstemp_r['temptext']=DoRepEcmsLoopBq($newstemp_r['temptext']);
	$newstemp_r['temptext']=RepBq($newstemp_r['temptext']);
	//�滻����
	$indextext=GetHtmlRepVar($newstemp_r,$ecms_gr['classid']);
	//д�ļ�
	WriteFiletext($file,AddCheckViewTempCode().$indextext);
	//��ȡ�ļ�����
    ob_start();
	include($file);
	$string=ob_get_contents();
	ob_end_clean();
	$string=RepExeCode($string);//��������
	return $string;
}

//��ǩ�滻4
function DtNewsBq($classid,$indextext,$ecms=0){
	global $empire,$dbtbpre,$public_r,$emod_r,$class_r,$class_zr,$fun_r,$navclassid,$navinfor,$class_tr,$level_r,$etable_r;
	$cachetime=$ecms==1?$public_r['dtncachetime']:$public_r['dtcachetime'];
	$file=ECMS_PATH.'e/data/tmp/dt_temp'.$classid.'.php';
	if($cachetime&&file_exists($file))
	{
		$filetime=filemtime($file);
		if(time()-$cachetime*60<=$filetime)
		{
			ob_start();
			include($file);
			$string=ob_get_contents();
			ob_end_clean();
			$string=RepExeCode($string);//��������
			return $string;
		}
	}
	$indextext=stripSlashes($indextext);
	$indextext=ReplaceTempvar($indextext);//�滻ȫ��ģ�����
	//�滻��ǩ
	$indextext=DoRepEcmsLoopBq($indextext);
	$indextext=RepBq($indextext);
	//д�ļ�
	WriteFiletext($file,AddCheckViewTempCode().$indextext);
	//��ȡ�ļ�����
    ob_start();
	include($file);
	$string=ob_get_contents();
	ob_end_clean();
	$string=RepExeCode($string);//��������
	return $string;
}

//��������
function RepExeCode($string){
	global $public_r;
	if($public_r['candocode']&&$public_r['candocodetag'])
	{
		$string=str_replace('<!--code.start-->','<',$string);
		$string=str_replace('<!--code.end-->','>',$string);
    }
	return $string;
}

function ClearRepDoECode($string){
	$string=str_replace('<!--code.start-->','&lt;!--code.start--&gt;',$string);
	$string=str_replace('<!--code.end-->','&lt;!--code.end--&gt;',$string);
	return $string;
}

//�滻��ǩ
function RepBq($indextext){
	global $empire,$dbtbpre;
	$sql=$empire->query("select bq,funname from {$dbtbpre}enewsbq where isclose=0 order by bqid");
	while($r=$empire->fetch($sql))
	{
        $preg_str="/\[".$r[bq]."\](.+?)\[\/".$r[bq]."\]/is";
		$indextext=preg_replace($preg_str,"<? @".$r[funname]."(\\1);?>",$indextext);
	}
	return $indextext;
}

//�滻�鶯��ǩ
function DoRepEcmsLoopBq($temp){
	$yzz="/\[e:loop={(.+?)}\](.+?)\[\/e:loop\]/is";
	$xzz="<?php
\$bqno=0;
\$ecms_bq_sql=sys_ReturnEcmsLoopBq(\\1);
if(\$ecms_bq_sql){
while(\$bqr=\$empire->fetch(\$ecms_bq_sql)){
\$bqsr=sys_ReturnEcmsLoopStext(\$bqr);
\$bqno++;
?>\\2<?php
}
}
?>";
	$temp=preg_replace($yzz,$xzz,$temp);
	$temp=DoRepEcmsIndexLoopBq($temp);
	return $temp;
}

//�滻�����鶯��ǩ
function DoRepEcmsIndexLoopBq($temp){
	$yzz="/\[e:indexloop={(.+?)}\](.+?)\[\/e:indexloop\]/is";
	$xzz="<?php
\$bqno=0;
\$ecms_bq_sql=sys_ReturnEcmsIndexLoopBq(\\1);
if(\$ecms_bq_sql){
while(\$indexbqr=\$empire->fetch(\$ecms_bq_sql)){
if(empty(\$class_r[\$indexbqr['classid']]['tbname'])){continue;}
\$bqr=\$empire->fetch1(\"select * from {\$dbtbpre}ecms_\".\$class_r[\$indexbqr['classid']]['tbname'].\" where id='\$indexbqr[id]'\");
\$bqsr=sys_ReturnEcmsLoopStext(\$bqr);
\$bqno++;
?>\\2<?php
}
}
?>";
	return preg_replace($yzz,$xzz,$temp);
}

//����Ϣ����Ϣ�б�
function NotinfoListHtml($path,$list_r,$classlevel){
	global $fun_r;
	$word=$fun_r['HaveNotListInfo'];
	$pagetext=$list_r[0].$word.$list_r[2];
	$pagetext=str_replace('[!--show.page--]','',$pagetext);
	$pagetext=str_replace('[!--show.listpage--]','',$pagetext);
	$pagetext=str_replace('[!--list.pageno--]','',$pagetext);
	WriteFiletext($path,$classlevel.$pagetext);
}

//������Ϣ�б�
function ListHtml($classid,$fields,$enews=0,$userlistr=""){
	global $empire,$dbtbpre,$emod_r,$public_r,$class_r,$class_zr,$fun_r,$class_tr,$level_r,$etable_r;
	//��������Ŀ
	if(($enews==0||$enews==3)&&($class_r[$classid]['listdt']||$class_r[$classid]['wburl']||strstr($public_r['nreclass'],','.$classid.',')))
	{
		return '';
	}
	$GLOBALS['navclassid']=$classid;
	$doclass="index";
	$classlevel='';
	$yhvar='qlist';
	if($enews==0)//����Ŀ�б�
	{
		if(InfoIsInTable($class_r[$classid][tbname]))//�ڲ���
		{
			return '';
		}
		$selfclassid=$classid;
		$doenews=0;
		$cr=$empire->fetch1("select classpagekey,intro,classimg,cgroupid,repagenum,bdinfoid,addsql from {$dbtbpre}enewsclass where classid='$classid'");
		//����Ϣ
		if(!empty($cr['bdinfoid']))
		{
			ReClassBdInfo($classid);
			return '';
		}
		eAutodo_AddDo('ReListHtml',$classid,0,0,0,0);//moreportdo
		$mid=$class_r[$classid][modid];
		//Ȩ��
		if($cr['cgroupid'])
		{
			$classlevel=AddCheckClassLevel($classid,$cr['cgroupid'],'');
		}
		//ҳ��
		$pagetitle=ehtmlspecialchars($class_r[$classid][classname]);
		$pagekey=ehtmlspecialchars($cr['classpagekey']);
		$pagedes=ehtmlspecialchars($cr['intro']);
		$classimg=$cr['classimg'];
		$url=ReturnClassLink($classid);
		$haveclass=0;
		//����
		if(empty($class_r[$classid][reorder]))
		{
			$addorder="newstime desc";
	    }
		else
		{
			$addorder=$class_r[$classid][reorder];
	    }
		//��ҳ����
		$pagefunr=eReturnRewriteLink('classpage',$classid,0);
		$pagefunr['repagenum']=$cr['repagenum'];
		$totalrepage=$cr['repagenum']*$class_r[$classid][lencord];
		if($totalrepage)
		{
			$limit=" limit ".$totalrepage;
		}
		if($class_r[$classid][maxnum])//�ܼ�¼��
		{
			if($class_r[$classid][maxnum]<$totalrepage)
			{
				$limit=" limit ".$class_r[$classid][maxnum];
			}
			$limitnum=$class_r[$classid][maxnum];
		}
		//�Ż�
		$yhid=$class_r[$classid][yhid];
		if($yhid)
		{
			$yhadd=ReturnYhSql($yhid,$yhvar,1);
		}
		$caddsql=$cr['addsql']?' and ('.$cr['addsql'].')':'';
		$query="select ".ReturnSqlListF($mid)." from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$yhadd."classid='$classid'".$caddsql." order by ".ReturnSetTopSql('list').$addorder.$limit;
		$totalquery="select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$yhadd."classid='$classid'".$caddsql;//ͳ��
		$doclasspath=ReturnSaveClassPath($classid,0);
		$dopath=eReturnTrueEcmsPath().$doclasspath."/";//moreport
		if(empty($class_r[$classid][classurl]))
		{
			$dolink=$public_r[newsurl].$doclasspath."/";
		}
		else
		{
			$dolink=$class_r[$classid][classurl]."/";
		}
		$dotype=$class_r[$classid][classtype];
		$classname=$class_r[$classid][classname];
		$lencord=$class_r[$classid][lencord];//��¼��
		$onclick="<script src='".$public_r[newsurl]."e/public/onclick/?enews=doclass&classid=$classid'></script>";
		//ģ��
		$listtempid=$class_r[$classid][listtempid];
	}
	elseif($enews==5)//��������б�
	{
		$mid=$class_tr[$classid]['mid'];
		$tbname=$emod_r[$mid]['tbname'];
		if(InfoIsInTable($tbname))//�ڲ���
		{
			return '';
		}
		$selfclassid=$classid;
		$doenews=1;
		$cr=$empire->fetch1("select tnum,listtempid,maxnum,reorder,timg,intro,pagekey,listdt,repagenum from {$dbtbpre}enewsinfotype where typeid='$classid'");
		//ҳ��
		$pagetitle=ehtmlspecialchars($class_tr[$classid]['tname']);
		$pagekey=ehtmlspecialchars($cr['pagekey']);
		$pagedes=ehtmlspecialchars($cr['intro']);
		$classimg=$cr['timg'];
		$url=ReturnInfoTypeLink($classid);
		$haveclass=1;
		if($cr['listdt'])//��̬ҳ��
		{
			return '';
		}
		eAutodo_AddDo('ReTtListHtml',$classid,0,0,0,0);//moreportdo
		//����
		if(empty($cr['reorder']))
		{
			$addorder='newstime desc';
	    }
		else
		{
			$addorder=$cr['reorder'];
	    }
		//��ҳ����
		$pagefunr=eReturnRewriteLink('ttpage',$classid,0);
		$pagefunr['repagenum']=$cr['repagenum'];
		$totalrepage=$cr['repagenum']*$cr['tnum'];
		if($totalrepage)
		{
			$limit=" limit ".$totalrepage;
		}
		if($cr['maxnum'])
		{
			if($cr['maxnum']<$totalrepage)
			{
				$limit=" limit ".$cr['maxnum'];
			}
			$limitnum=$cr['maxnum'];
		}
		//�Ż�
		$yhid=$class_tr[$classid]['yhid'];
		if($yhid)
		{
			$yhadd=ReturnYhSql($yhid,$yhvar,1);
		}
		$query="select ".ReturnSqlListF($mid)." from {$dbtbpre}ecms_".$tbname." where ".$yhadd."ttid='$classid' order by ".ReturnSetTopSql('list').$addorder.$limit;
		$totalquery="select count(*) as total from {$dbtbpre}ecms_".$tbname." where ".$yhadd."ttid='$classid'";//ͳ��
		$doclasspath=ReturnSaveInfoTypePath($classid,0);
		$dopath=eReturnTrueEcmsPath().$doclasspath."/";//moreport
		$dolink=$public_r[newsurl].$doclasspath."/";
		$dotype=$class_tr[$classid]['ttype'];
		$classname=$class_tr[$classid]['tname'];
		$lencord=$cr['tnum'];//��¼��
		$onclick="";
		//ģ��
		$listtempid=$cr['listtempid'];
	}
	elseif($enews==3)//����Ŀ�б�
	{
		if(InfoIsInTable($class_r[$classid][tbname]))//�ڲ���
		{
			return '';
		}
		eAutodo_AddDo('ReListHtml',$classid,0,0,0,0);//moreportdo
		$selfclassid=$classid;
		$doenews=0;
		$cr=$empire->fetch1("select classpagekey,intro,classimg,cgroupid,repagenum,addsql from {$dbtbpre}enewsclass where classid='$classid'");
		$mid=$class_r[$classid][modid];
		//Ȩ��
		if($cr['cgroupid'])
		{
			$classlevel=AddCheckClassLevel($classid,$cr['cgroupid'],'');
		}
		//ҳ��
		$pagetitle=ehtmlspecialchars($class_r[$classid][classname]);
		$pagekey=ehtmlspecialchars($cr['classpagekey']);
		$pagedes=ehtmlspecialchars($cr['intro']);
		$classimg=$cr['classimg'];
		$url=ReturnClassLink($classid);
		$haveclass=1;
		//����
		if(empty($class_r[$classid][reorder]))
		{
			$addorder="newstime desc";
	    }
		else
		{
			$addorder=$class_r[$classid][reorder];
	    }
		//��ҳ����
		$pagefunr=eReturnRewriteLink('classpage',$classid,0);
		$pagefunr['repagenum']=$cr['repagenum'];
		$totalrepage=$cr['repagenum']*$class_r[$classid][lencord];
		if($totalrepage)
		{
			$limit=" limit ".$totalrepage;
		}
		if($class_r[$classid][maxnum])
		{
			if($class_r[$classid][maxnum]<$totalrepage)
			{
				$limit=" limit ".$class_r[$classid][maxnum];
			}
			$limitnum=$class_r[$classid][maxnum];
		}
		$whereclass=ReturnClass($class_r[$classid][sonclass]);
		//�Ż�
		$yhid=$class_r[$classid][yhid];
		if($yhid)
		{
			$yhadd=ReturnYhSql($yhid,$yhvar,1);
		}
		$caddsql=$cr['addsql']?' and ('.$cr['addsql'].')':'';
		$query="select ".ReturnSqlListF($mid)." from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$yhadd."(".$whereclass.")".$caddsql." order by ".ReturnSetTopSql('list').$addorder.$limit;
		$totalquery="select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$yhadd."(".$whereclass.")".$caddsql;//ͳ��
		$doclasspath=ReturnSaveClassPath($classid,0);
		$dopath=eReturnTrueEcmsPath().$doclasspath."/";//moreport
		if(empty($class_r[$classid][classurl]))
		{
			$dolink=$public_r[newsurl].$doclasspath."/";
		}
		else
		{
			$dolink=$class_r[$classid][classurl]."/";
		}
		$dotype=$class_r[$classid][classtype];
		$classname=$class_r[$classid][classname];
		$lencord=$class_r[$classid][lencord];//��¼��
		$onclick="<script src='".$public_r[newsurl]."e/public/onclick/?enews=doclass&classid=$classid'></script>";
		//ģ��
		$listtempid=$class_r[$classid][listtempid];
	}
	elseif($enews==4)//��sql��������б�
	{
		$selfclassid=0;
		$doenews=1;
		$userlistr['listsql']=RepSqlTbpre($userlistr['listsql']);
		$userlistr['totalsql']=RepSqlTbpre($userlistr['totalsql']);
		//ҳ��
		$pagetitle=ehtmlspecialchars($userlistr['pagetitle']);
		$pagekey=ehtmlspecialchars($userlistr['pagekeywords']);
		$pagedes=ehtmlspecialchars($userlistr['pagedescription']);
		$haveclass=1;
		if($userlistr['maxnum'])//����ѯ��
		{
			$limit=" limit ".$userlistr['maxnum'];
			$limitnum=$userlistr['maxnum'];
		}
		$query=stripSlashes($userlistr['listsql']).$limit;
		//ͳ��
		$totalquery=stripSlashes($userlistr['totalsql']);
		$dopath=eReturnTrueEcmsPath().'e/data/'.$userlistr['filepath'];//maddpath
		$dolink=$public_r[newsurl].str_replace('../../','',$userlistr['filepath']);
		$dotype=$userlistr['filetype'];
		$classname=$userlistr['pagetitle'];
		$lencord=$userlistr['lencord'];//��¼��
		$onclick='';
		$url=ReturnUserPLink($pagetitle,$dolink);
		//ģ��
		$listtempid=$userlistr['listtempid'];
	}
	if(empty($lencord))
	{
		$lencord=25;
	}
	//�б�ģ��
	$listtemp_r=GetListTemp($listtempid);
    $listtemp=$listtemp_r[temptext];
	$subnews=$listtemp_r[subnews];
	$subtitle=$listtemp_r[subtitle];
	$docode=$listtemp_r[docode];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$listtemp_r[listvar]);
	$rownum=$listtemp_r[rownum];
	$formatdate=$listtemp_r[showdate];
	if(empty($rownum))
	{
		$rownum=1;
	}
	if(empty($mid))
	{
		$mid=$listtemp_r[modid];
	}
	$field=ReturnReplaceListF($mid);
	//��ҳ����
	$pagefunr['dofile']=$dofile;
	//��ҳ�б���
	if(!empty($public_r['listpagefun'])||!empty($public_r['listpagelistfun']))
	{
		if(strstr($listtemp,'[!--show.page--]'))//����ʽ
		{
			$thefun=$public_r['listpagefun'];
			$bereplistpage='[!--show.page--]';
		}
		else//�б�ʽ
		{
			$thefun=$public_r['listpagelistfun'];
			$bereplistpage='[!--show.listpage--]';
		}
	}
	else
	{
		$thefun='sys_ShowListPage';
		$bereplistpage='[!--show.page--]';
	}
	//�滻ģ�����
	$listtemp=str_replace('[!--newsnav--]',$url,$listtemp);//λ�õ���
	$listtemp=Class_ReplaceSvars($listtemp,$url,$selfclassid,$pagetitle,$pagekey,$pagedes,$classimg,$add,$doenews);
	$listtemp=str_replace('[!--page.stats--]',$onclick,$listtemp);
	$no=1;
	$ok=0;
	$changerow=1;
	$num=$empire->gettotal($totalquery);
	//�����
	if($limitnum&&$limitnum<$num)
	{
		$num=$limitnum;
	}
	$page=ceil($num/$lencord);
	//ȡ���б�ģ��
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	//����Ϣ
	if(empty($num))
	{
		$noinfopath=$dopath."index".$dotype;
		NotinfoListHtml($noinfopath,$list_r,$classlevel);
		return "";
	}
	$sql=$empire->query($query);
	$listtext=$list_r[1];
	while($k=$empire->fetch($sql))
	{
		//�滻�б����
		$repvar=ReplaceListVars($no,$listvar,$subnews,$subtitle,$formatdate,$url,$haveclass,$k,$field,$docode);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		if($no%$lencord==0||($num%$lencord<>0&&$num==$no))
		{
			$ok+=1;
			$pagenum=ceil($no/$lencord);
			//��ҳ
			if($pagenum==1)
			{
				$path=$dopath."index".$dotype;
			}
			else
			{
				$path=$dopath."index_".$ok.$dotype;
			}
			//ȡ�÷�ҳ����
			$returnpager=$thefun($num,$pagenum,$dolink,$dotype,$page,$lencord,$ok,$myoptions,$pagefunr);
			$showpage=$returnpager['showpage'];
			$myoptions=$returnpager['option'];
			$list1=str_replace($bereplistpage,$showpage,$list_r[0]);
			$list2=str_replace($bereplistpage,$showpage,$list_r[2]);
			//��������
			if($changerow<=$rownum&&$listtext<>$list_r[1])
			{
				$string.=$listtext;
			}
			$listtext=$list_r[1];
			$changerow=1;
			$string=$list1.$string.$list2;
			//�滻��ҳ��
			$string=str_replace('[!--list.pageno--]',($pagenum==1?'':$pagenum),$string);
			WriteFiletext($path,$classlevel.$string);
			$string='';
		}
		$no++;
	}
	$empire->free($sql);
}

//������������Ϣ�б�
function ListHtmlIndex($classid,$fields,$enews=0,$userlistr=""){
	global $empire,$dbtbpre,$emod_r,$public_r,$class_r,$class_zr,$fun_r,$class_tr,$level_r,$etable_r;
	$GLOBALS['navclassid']=$classid;
	$dofile="index";
	$classlevel='';
	$yhvar='qlist';
	$mid=0;
	if($enews==0)//ר���б�
	{
		$selfclassid=$classid;
		$doenews=1;
		$cr=$empire->fetch1("select ztpagekey,intro,ztimg,classtempid from {$dbtbpre}enewszt where ztid='$classid'");
		//ҳ��
		$pagetitle=ehtmlspecialchars($class_zr[$classid][ztname]);
		$pagekey=ehtmlspecialchars($cr['ztpagekey']);
		$pagedes=ehtmlspecialchars($cr['intro']);
		$classimg=$cr['ztimg'];
		$url=ReturnZtLink($classid);
		$haveclass=1;
		if($class_zr[$classid][islist]!=1)//���б�ʽ
		{
			$classtemp=$class_zr[$classid][islist]==2?GetZtText($classid):GetClassTemp($cr['classtempid']);
			NewsBq($classid,$classtemp,3,0);
			return "";
		}
		eAutodo_AddDo('ReZtListHtml',$classid,0,0,0,0);//moreportdo
		//����
		if(empty($class_zr[$classid][reorder]))
		{
			$addorder='newstime desc';
	    }
		else
		{
			$addorder=$class_zr[$classid][reorder];
	    }
		if($class_zr[$classid][maxnum])
		{
			$limit=' limit '.$class_zr[$classid][maxnum];
			$limitnum=$class_zr[$classid][maxnum];
		}
		//�Ż�
		$yhid=$class_zr[$classid][yhid];
		if($yhid)
		{
			$yhadd=ReturnYhSql($yhid,$yhvar,1);
		}
		$query="select ztid,cid,classid,id,isgood from {$dbtbpre}enewsztinfo where ".$yhadd."ztid='$classid' order by ".$addorder.$limit;
		$totalquery="select count(*) as total from {$dbtbpre}enewsztinfo where ".$yhadd."ztid='$classid'";//ͳ��
		$doclasspath=ReturnSaveZtPath($classid,0);
		$dopath=eReturnTrueEcmsPath().$doclasspath."/";
		if(empty($class_zr[$classid][zturl]))
		{
			$dolink=$public_r[newsurl].$doclasspath."/";
		}
		else
		{
			$dolink=$class_zr[$classid][zturl]."/";
		}
		$dotype=$class_zr[$classid][zttype];
		$classname=$class_zr[$classid][ztname];
		$lencord=$class_zr[$classid][ztnum];//��¼��
		$onclick="<script src='".$public_r[newsurl]."e/public/onclick/?enews=dozt&ztid=$classid'></script>";
		//ģ��
		$listtempid=$class_zr[$classid][listtempid];
	}
	elseif($enews==1)//ר�������б�
	{
		$selfclassid=$classid;
		$doenews=1;
		$cr=$empire->fetch1("select ztid,cname,islist,listtempid,maxnum,tnum,reorder,ttype,tfile from {$dbtbpre}enewszttype where cid='$classid'");
		$GLOBALS['navinfor']['ecmsbid']=$cr['ztid'];
		//ҳ��
		$pagetitle=ehtmlspecialchars($cr['cname']);
		$pagekey=ehtmlspecialchars($cr['cname']);
		$pagedes=ehtmlspecialchars($cr['cname']);
		$url=ReturnZtLink($cr['ztid']);
		$haveclass=1;
		if($cr['islist']!=1)//���б�ʽ
		{
			$classtemp=GetZtcText($classid);
			NewsBq($classid,$classtemp,4,0);
			return '';
		}
		eAutodo_AddDo('ReZtcListHtml',$classid,0,0,0,0);//moreportdo
		//����
		if(empty($cr['reorder']))
		{
			$addorder='newstime desc';
	    }
		else
		{
			$addorder=$cr['reorder'];
	    }
		if($cr['maxnum'])
		{
			$limit=" limit ".$cr['maxnum'];
			$limitnum=$cr['maxnum'];
		}
		//�Ż�
		$ztid=$cr['ztid'];
		$yhid=$class_zr[$ztid][yhid];
		if($yhid)
		{
			$yhadd=ReturnYhSql($yhid,$yhvar,1);
		}
		$query="select ztid,cid,classid,id,isgood from {$dbtbpre}enewsztinfo where ".$yhadd."cid='$classid' order by ".$addorder.$limit;
		$totalquery="select count(*) as total from {$dbtbpre}enewsztinfo where ".$yhadd."cid='$classid'";//ͳ��
		$doclasspath=ReturnSaveZtPath($ztid,0);
		$dopath=eReturnTrueEcmsPath().$doclasspath."/";
		if(empty($class_zr[$ztid][zturl]))
		{
			$dolink=$public_r[newsurl].$doclasspath."/";
		}
		else
		{
			$dolink=$class_zr[$ztid][zturl]."/";
		}
		$dofile=$cr['tfile'];//�ļ���
		$dotype=$cr['ttype'];
		$classname=$cr['cname'];
		$lencord=$cr['tnum'];//��¼��
		$onclick="<script src='".$public_r[newsurl]."e/public/onclick/?enews=dozt&ztid=$ztid'></script>";
		//ģ��
		$listtempid=$cr['listtempid'];
	}
	elseif($enews==4)//��sql��������б�
	{
		$selfclassid=0;
		$doenews=1;
		$userlistr['listsql']=RepSqlTbpre($userlistr['listsql']);
		$userlistr['totalsql']=RepSqlTbpre($userlistr['totalsql']);
		//ҳ��
		$pagetitle=ehtmlspecialchars($userlistr['pagetitle']);
		$pagekey=ehtmlspecialchars($userlistr['pagekeywords']);
		$pagedes=ehtmlspecialchars($userlistr['pagedescription']);
		$haveclass=1;
		if($userlistr['maxnum'])//����ѯ��
		{
			$limit=" limit ".$userlistr['maxnum'];
			$limitnum=$userlistr['maxnum'];
		}
		$query=stripSlashes($userlistr['listsql']).$limit;
		//ͳ��
		$totalquery=stripSlashes($userlistr['totalsql']);
		$dopath=eReturnTrueEcmsPath().'e/data/'.$userlistr['filepath'];//maddpath
		$dolink=$public_r[newsurl].str_replace('../../','',$userlistr['filepath']);
		$dotype=$userlistr['filetype'];
		$classname=$userlistr['pagetitle'];
		$lencord=$userlistr['lencord'];//��¼��
		$onclick='';
		$url=ReturnUserPLink($pagetitle,$dolink);
		//ģ��
		$listtempid=$userlistr['listtempid'];
	}
	if(empty($lencord))
	{
		$lencord=25;
	}
	//�б�ģ��
	$listtemp_r=GetListTemp($listtempid);
    $listtemp=$listtemp_r[temptext];
	$subnews=$listtemp_r[subnews];
	$subtitle=$listtemp_r[subtitle];
	$docode=$listtemp_r[docode];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$listtemp_r[listvar]);
	$rownum=$listtemp_r[rownum];
	$formatdate=$listtemp_r[showdate];
	if(empty($rownum))
	{
		$rownum=1;
	}
	if(empty($mid))
	{
		$mid=$listtemp_r[modid];
	}
	$field=ReturnReplaceListF($mid);
	//��ҳ����
	$pagefunr['dofile']=$dofile;
	//��ҳ�б���
	if(!empty($public_r['listpagefun'])||!empty($public_r['listpagelistfun']))
	{
		if(strstr($listtemp,'[!--show.page--]'))//����ʽ
		{
			$thefun=$public_r['listpagefun'];
			$bereplistpage='[!--show.page--]';
		}
		else//�б�ʽ
		{
			$thefun=$public_r['listpagelistfun'];
			$bereplistpage='[!--show.listpage--]';
		}
	}
	else
	{
		$thefun='sys_ShowListPage';
		$bereplistpage='[!--show.page--]';
	}
	//�滻ģ�����
	$listtemp=str_replace('[!--newsnav--]',$url,$listtemp);//λ�õ���
	$listtemp=Class_ReplaceSvars($listtemp,$url,$selfclassid,$pagetitle,$pagekey,$pagedes,$classimg,$add,$doenews);
	$listtemp=str_replace('[!--page.stats--]',$onclick,$listtemp);
	$no=1;
	$ok=0;
	$changerow=1;
	$num=$empire->gettotal($totalquery);
	//�����
	if($limitnum&&$limitnum<$num)
	{
		$num=$limitnum;
	}
	$page=ceil($num/$lencord);
	//ȡ���б�ģ��
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	//����Ϣ
	if(empty($num))
	{
		$noinfopath=$dopath.$dofile.$dotype;
		NotinfoListHtml($noinfopath,$list_r,$classlevel);
		return "";
	}
	$sql=$empire->query($query);
	$listtext=$list_r[1];
	while($k=$empire->fetch($sql))
	{
		if(empty($class_r[$k[classid]][tbname]))
		{
			$no++;
			continue;
		}
		$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$k[classid]][tbname]." where id='$k[id]' limit 1");
		if(empty($infor['id']))
		{
			$no++;
			continue;
		}
		//�滻�б����
		$repvar=ReplaceListVars($no,$listvar,$subnews,$subtitle,$formatdate,$url,$haveclass,$infor,$field,$docode);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		if($no%$lencord==0||($num%$lencord<>0&&$num==$no))
		{
			$ok+=1;
			$pagenum=ceil($no/$lencord);
			//��ҳ
			if($pagenum==1)
			{
				$path=$dopath.$dofile.$dotype;
			}
			else
			{
				$path=$dopath.$dofile.'_'.$ok.$dotype;
			}
			//ȡ�÷�ҳ����
			$returnpager=$thefun($num,$pagenum,$dolink,$dotype,$page,$lencord,$ok,$myoptions,$pagefunr);
			$showpage=$returnpager['showpage'];
			$myoptions=$returnpager['option'];
			$list1=str_replace($bereplistpage,$showpage,$list_r[0]);
			$list2=str_replace($bereplistpage,$showpage,$list_r[2]);
			//��������
			if($changerow<=$rownum&&$listtext<>$list_r[1])
			{
				$string.=$listtext;
			}
			$listtext=$list_r[1];
			$changerow=1;
			$string=$list1.$string.$list2;
			//�滻��ҳ��
			$string=str_replace('[!--list.pageno--]',($pagenum==1?'':$pagenum),$string);
			WriteFiletext($path,$classlevel.$string);
			$string='';
		}
		$no++;
	}
	$empire->free($sql);
}

//���ط�ҳ
function ReturnListpageStr($pagenum,$page,$lencord,$num,$pagelink,$options){
	global $public_r;
	$temp=$public_r['listpagetemp'];
	$temp=str_replace('[!--thispage--]',$pagenum,$temp);//ҳ��
	$temp=str_replace('[!--pagenum--]',$page,$temp);//��ҳ��
	$temp=str_replace('[!--lencord--]',$lencord,$temp);//ÿҳ��ʾ����
	$temp=str_replace('[!--num--]',$num,$temp);//������
	$temp=str_replace('[!--pagelink--]',$pagelink,$temp);//ҳ������
	$temp=str_replace('[!--options--]',$options,$temp);//������ҳ
	return $temp;
}

//Ͷ������html
function DoGetHtml($classid,$id){
	global $empire,$class_r,$public_r,$dbtbpre;
	$classid=intval($classid);
	$id=intval($id);
	$tbname=$class_r[$classid][tbname];
	//������
	if(!$id||!$classid||!$tbname)
	{
		echo"<script>self.location.href='".$public_r['newsurl']."';</script>";
		exit();
	}
	$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id='$id'");
	if(!$r['id']||$classid!=$r['classid'])
	{
		echo"<script>self.location.href='".$public_r['newsurl']."';</script>";
		exit();
	}
	$titleurl=sys_ReturnBqAutoTitleLink($r);
	//������
	if(!empty($r[havehtml]))
	{
		return $titleurl;
	}
	//����html
	GetHtml($r['classid'],$r['id'],$r,1);
	return $titleurl;
}

//���ݱ�������
function GetHtmlRepVar($tempr,$classid){
	global $public_r,$class_r,$class_zr,$fun_r,$empire,$dbtbpre,$emod_r,$class_tr,$level_r,$etable_r;
	$mid=$class_r[$classid]['modid'];
	$tbname=$class_r[$classid][tbname];
	$newstemptext=$tempr[temptext];
	$formatdate=$tempr[showdate];
	//��ҳ�ֶ�
	$expage='[!--empirenews.page--]';//��ҳ��
	$pf=$emod_r[$mid]['pagef'];
	//����
	$tempf=$emod_r[$mid]['tempf'];
	$fr=explode(',',$tempf);
	$fcount=count($fr)-1;
	//�����滻
	$newstempstr=$newstemptext;//ģ��
	//����ҳ�����
	$newstempstr=str_replace('[!--class.menu--]',$public_r['classnavs'],$newstempstr);//��Ŀ����
	$newstempstr=str_replace('[!--newsnav--]','<?=$grurl?>',$newstempstr);//λ�õ���
	$newstempstr=str_replace('[!--pagetitle--]','<?=$grpagetitle?>',$newstempstr);
	$newstempstr=str_replace('[!--pagekey--]','<?=$ecms_gr[keyboard]?>',$newstempstr);
	$newstempstr=str_replace('[!--pagedes--]','<?=$grpagetitle?>',$newstempstr);
	$newstempstr=str_replace('[!--self.classid--]','<?=$ecms_gr[classid]?>',$newstempstr);
	$newstempstr=str_replace('[!--bclass.id--]','<?=$grbclassid?>',$newstempstr);
	$newstempstr=str_replace('[!--bclass.name--]','<?=$class_r[$grbclassid][classname]?>',$newstempstr);
	$newstempstr=str_replace('[!--news.url--]',$public_r['newsurl'],$newstempstr);
	//��Ϣ�ֶα���
	for($i=1;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$value='$ecms_gr['.$f.']';
		if($f==$pf)//��ҳ�ֶ�
		{
			$value='strstr('.$value.',\''.$expage.'\')?\'[!--'.$f.'--]\':'.$value;
		}
		elseif($f=='downpath')//���ص�ַ
		{
			$value='ReturnDownSoftHtml($ecms_gr)';
		}
		elseif($f=='onlinepath')//�ۿ���ַ
		{
			$value='ReturnOnlinepathHtml($ecms_gr)';
		}
		elseif($f=='morepic')//ͼƬ��
		{
			$value='ReturnMorepicpathHtml($ecms_gr)';
		}
		elseif($f=='newstime')//ʱ��
		{
			$value='date(\''.$formatdate.'\','.$value.')';
		}
		elseif($f=='befrom')//��Ϣ��Դ
		{
			$value='$docheckrep[1]?ReplaceBefrom('.$value.'):'.$value;
		}
		elseif($f=='writer')//����
		{
			$value='$docheckrep[2]?ReplaceWriter('.$value.'):'.$value;
		}
		elseif($f=='titlepic')//����ͼƬ
		{
			$value='empty('.$value.')?$public_r[newsurl].\'e/data/images/notimg.gif\':'.$value;
		}
		elseif($f=='title')//����
		{
		}
		else//�����ֶ�
		{
			if(!strstr($emod_r[$mid]['editorf'],','.$f.','))
			{
				if(strstr($emod_r[$mid]['tobrf'],','.$f.','))//��br
				{
					$value='nl2br('.$value.')';
				}
				if(!strstr($emod_r[$mid]['dohtmlf'],','.$f.','))//ȥ��html
				{
					$value='RepFieldtextNbsp(ehtmlspecialchars('.$value.'))';
				}
			}
		}
		$newstempstr=str_replace('[!--'.$f.'--]','<?='.$value.'?>',$newstempstr);
	}
	//�̶�����
	$newstempstr=str_replace('[!--id--]','<?=$ecms_gr[id]?>',$newstempstr);
	$newstempstr=str_replace('[!--classid--]','<?=$ecms_gr[classid]?>',$newstempstr);
	$newstempstr=str_replace('[!--class.name--]','<?=$class_r[$ecms_gr[classid]][classname]?>',$newstempstr);
	$newstempstr=str_replace('[!--ttid--]','<?=$ecms_gr[ttid]?>',$newstempstr);
	$newstempstr=str_replace('[!--tt.name--]','<?=$class_tr[$ecms_gr[ttid]][tname]?>',$newstempstr);
	$newstempstr=str_replace('[!--tt.url--]','<?=sys_ReturnBqInfoTypeUrl($ecms_gr[ttid])?>',$newstempstr);
	$newstempstr=str_replace('[!--onclick--]','<?=$ecms_gr[onclick]?>',$newstempstr);
	$newstempstr=str_replace('[!--userfen--]','<?=$ecms_gr[userfen]?>',$newstempstr);
	$newstempstr=str_replace('[!--username--]','<?=$ecms_gr[username]?>',$newstempstr);
	//�����ӵ��û���
	$newstempstr=str_replace('[!--linkusername--]','<?=$ecms_gr[ismember]==1&&$ecms_gr[userid]?\'<a href="\'.$public_r[newsurl].\'e/space/?userid=\'.$ecms_gr[userid].\'" target=_blank>\'.$ecms_gr[username].\'</a>\':$ecms_gr[username]?>',$newstempstr);
	$newstempstr=str_replace('[!--userid--]','<?=$ecms_gr[userid]?>',$newstempstr);
	//�������
	$keyboardtext='<?=GetKeyboard($ecms_gr[keyboard],$ecms_gr[keyid],$ecms_gr[classid],$ecms_gr[id],$class_r[$ecms_gr[classid]][link_num])?>';
	$newstempstr=str_replace('[!--other.link--]',$keyboardtext,$newstempstr);
	$newstempstr=str_replace('[!--plnum--]','<?=$ecms_gr[plnum]?>',$newstempstr);
	$newstempstr=str_replace('[!--totaldown--]','<?=$ecms_gr[totaldown]?>',$newstempstr);
	$newstempstr=str_replace('[!--keyboard--]','<?=$ecms_gr[keyboard]?>',$newstempstr);
	//����
	$newstempstr=str_replace('[!--titleurl--]','<?=$grtitleurl?>',$newstempstr);
	//���
	$onclick='<?=\'<script src="\'.$public_r[newsurl].\'e/public/onclick/?enews=donews&classid=\'.$ecms_gr[classid].\'&id=\'.$ecms_gr[id].\'"></script>\'?>';
	$newstempstr=str_replace('[!--page.stats--]',$onclick,$newstempstr);
	$newstempstr=str_replace('[!--class.url--]','<?=$grclassurl?>',$newstempstr);
	//��һƪ
	if(strstr($newstemptext,'[!--info.next--]'))
	{
	$infonext='<?php
	$next_r=$empire->fetch1("select isurl,titleurl,classid,id,title from {$dbtbpre}ecms_".$class_r[$ecms_gr[classid]][tbname]." where id>$ecms_gr[id] and classid=\'$ecms_gr[classid]\' order by id limit 1");
	if(empty($next_r[id]))
	{$infonext="<a href=\'".$grclassurl."\'>'.$fun_r['HaveNoNextLink'].'</a>";}
	else
	{
		$nexttitleurl=sys_ReturnBqTitleLink($next_r);
		$infonext="<a href=\'".$nexttitleurl."\'>".$next_r[title]."</a>";
	}
	echo $infonext;
	?>';
	$newstempstr=str_replace('[!--info.next--]',$infonext,$newstempstr);
	}
	//��һƪ
	if(strstr($newstemptext,'[!--info.pre--]'))
	{
	$infopre='<?php
	$next_r=$empire->fetch1("select isurl,titleurl,classid,id,title from {$dbtbpre}ecms_".$class_r[$ecms_gr[classid]][tbname]." where id<$ecms_gr[id] and classid=\'$ecms_gr[classid]\' order by id desc limit 1");
	if(empty($next_r[id]))
	{$infonext="<a href=\'".$grclassurl."\'>'.$fun_r['HaveNoNextLink'].'</a>";}
	else
	{
		$nexttitleurl=sys_ReturnBqTitleLink($next_r);
		$infonext="<a href=\'".$nexttitleurl."\'>".$next_r[title]."</a>";
	}
	echo $infonext;
	?>';
	$newstempstr=str_replace('[!--info.pre--]',$infopre,$newstempstr);
	}
	//ͶƱ
	if(strstr($newstemptext,'[!--info.vote--]'))
	{
		$newstempstr=str_replace('[!--info.vote--]','<?=sys_GetInfoVote($ecms_gr[classid],$ecms_gr[id])?>',$newstempstr);
	}
	return $newstempstr;
}

//���������ļ�
function GetHtml($classid,$id,$add,$ecms=0,$doall=0){
	global $public_r,$class_r,$class_zr,$fun_r,$empire,$dbtbpre,$emod_r,$class_tr,$level_r,$etable_r;
	$mid=$class_r[$classid]['modid'];
	$tbname=$class_r[$classid][tbname];
	if(InfoIsInTable($tbname))//�ڲ���
	{
		return '';
	}
	if($ecms==0)//����
	{
		$add=$empire->fetch1("select ".ReturnSqlTextF($mid,1)." from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1");
	}
	$add['id']=$id;
	$add['classid']=$classid;
	if($add['isurl'])
	{
		return '';
	}
	if(empty($doall))
	{
		if(!$add['stb']||$class_r[$add[classid]][showdt]==2||strstr($public_r['nreinfo'],','.$add['classid'].','))//������
		{
			return '';
		}
	}
	//����
	$addr=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$add[stb]." where id='$add[id]' limit 1");
	$add=array_merge($add,$addr);
	//·��
	$iclasspath=ReturnSaveInfoPath($add[classid],$add[id]);
	$doclasspath=eReturnTrueEcmsPath().$iclasspath;//moreport
	$createinfopath=$doclasspath;
	//��������Ŀ¼
	$newspath='';
	if($add[newspath])
	{
		$createpath=$doclasspath.$add[newspath];
		if(!file_exists($createpath))
		{
			$r[newspath]=FormatPath($add[classid],$add[newspath],1);
		}
		$createinfopath.=$add[newspath].'/';
		$newspath=$add[newspath].'/';
	}
	//�½����Ŀ¼
	if($class_r[$add[classid]][filename]==3)
	{
		$createinfopath.=ReturnInfoSPath($add['filename']);
		DoMkdir($createinfopath);
		$fn3=1;
	}
	//���ı�
	if($emod_r[$mid]['savetxtf'])
	{
		$stf=$emod_r[$mid]['savetxtf'];
		if($add[$stf])
		{
			$add[$stf]=GetTxtFieldText($add[$stf]);
		}
	}
	eAutodo_AddDo('ReNewsHtml',$classid,$id,0,0,0);//moreportdo
	$GLOBALS['navclassid']=$add[classid];
	$GLOBALS['navinfor']=$add;
	//ȡ������ģ��
	$add[newstempid]=$add[newstempid]?$add[newstempid]:$class_r[$add[classid]][newstempid];
	$newstemp_r=$empire->fetch1("select temptext,showdate from ".GetTemptb("enewsnewstemp")." where tempid='$add[newstempid]' limit 1");
	$newstemp_r['tempid']=$add['newstempid'];
	if($public_r['opennotcj'])//���÷��ɼ�
	{
		$newstemp_r['temptext']=ReturnNotcj($newstemp_r['temptext']);
	}
	$newstemptext=$newstemp_r[temptext];
	$formatdate=$newstemp_r[showdate];
	//�ļ�����/Ȩ��
	if($add[groupid]||$class_r[$add[classid]]['cgtoinfo'])
	{
		if(empty($add[newspath]))
		{
			$include='';
	    }
		else
		{
			$pr=explode('/',$add[newspath]);
			for($i=0;$i<count($pr);$i++)
			{
				$include.='../';
			}
		}
		if($fn3==1)
		{
			$include.='../';
		}
		$pr=explode('/',$iclasspath);
		$pcount=count($pr);
		for($i=0;$i<$pcount-1;$i++)
		{
			$include.='../';
		}
		$include1=$include;
		$include.='e/class/CheckLevel.php';
		$filetype='.php';
		$addlevel="<?php
		define('empirecms','wm_chief');
		\$check_tbname='".$class_r[$add[classid]][tbname]."';
		\$check_infoid=".$add[id].";
		\$check_classid=".$add[classid].";
		\$check_path=\"".$include1."\";
		require(\"".$include."\");
		?>";
    }
	else
	{
		$filetype=$class_r[$add[classid]][filetype];
		$addlevel='';
	}
	//ȡ�ñ�Ŀ¼����
	if($class_r[$add[classid]][classurl]&&$class_r[$add[classid]][ipath]=='')//����
	{
		$dolink=$class_r[$add[classid]][classurl].'/'.$newspath;
	}
	else
	{
		$dolink=$public_r[newsurl].$iclasspath.$newspath;
	}
	//�����滻��֤�ַ�
	$docheckrep=ReturnCheckDoRepStr();
	if($add[newstext])
	{
		if(empty($public_r['dorepword'])&&$docheckrep[3])
		{
			$add[newstext]=ReplaceWord($add[newstext]);//�����ַ�
		}
		if(empty($public_r['dorepkey'])&&$docheckrep[4]&&!empty($add[dokey]))//�滻�ؼ���
		{
			$add[newstext]=ReplaceKey($add['newstext'],$add['classid']);
		}
		if($public_r['opencopytext'])
		{
			$add[newstext]=AddNotCopyRndStr($add[newstext]);//��������ַ�
		}
	}
	//���ر���
	$newstemptext=GetInfoNewsBq($classid,$newstemp_r,$add,$docheckrep);
	//��ҳ�ֶ�
	$expage='[!--empirenews.page--]';//��ҳ��
	$pf=$emod_r[$mid]['pagef'];
	//�����滻
	$newstempstr=$newstemptext;//ģ��
	//��ҳ
	if($pf&&strstr($add[$pf],$expage))//�з�ҳ
	{
		$n_r=explode($expage,$add[$pf]);
		$thispagenum=count($n_r);
		//ȡ�÷�ҳ
		$thefun=$public_r['textpagefun']?$public_r['textpagefun']:'sys_ShowTextPage';
		//����ʽ��ҳ
		if(strstr($newstemptext,'[!--title.select--]'))
		{
			$dotitleselect=sys_ShowTextPageSelect($thispagenum,$dolink,$add,$filetype,$n_r);
		}
		for($j=1;$j<=$thispagenum;$j++)
		{
			$string=$newstempstr;//ģ��
			$truepage='';
			$titleselect='';
			//��һҳ����
			if($thispagenum==$j)
			{
				$thisnextlink=$dolink.$add[filename].$filetype;
			}
			else
			{
				$thisj=$j+1;
				$thisnextlink=$dolink.$add[filename].'_'.$thisj.$filetype;
			}
			$k=$j-1;
			if($j==1)
			{
				$file=$doclasspath.$newspath.$add[filename].$filetype;
				$ptitle=$add[title];
			}
			else
			{
				$file=$doclasspath.$newspath.$add[filename].'_'.$j.$filetype;
				$ti_r=explode('[/!--empirenews.page--]',$n_r[$k]);
				if(count($ti_r)>=2)
				{
					$ptitle=$ti_r[0];
					$n_r[$k]=$ti_r[1];
				}
				else
				{
					$ptitle=$add[title].'('.$j.')';
				}
			}
			//ȡ�õ�ǰҳ
			if($thispagenum!=1)
			{
				$truepage=$thefun($thispagenum,$j,$dolink,$add,$filetype,'');
				$titleselect=str_replace("?".$j."\">","?".$j."\" selected>",$dotitleselect);
			}
			//�滻����
			$newstext=$n_r[$k];
			if(!strstr($emod_r[$mid]['editorf'],','.$pf.','))
			{
				if(strstr($emod_r[$mid]['tobrf'],','.$pf.','))//��br
				{
					$newstext=nl2br($newstext);
				}
				if(!strstr($emod_r[$mid]['dohtmlf'],','.$pf.','))//ȥ��html
				{
					$newstext=ehtmlspecialchars($newstext);
					$newstext=RepFieldtextNbsp($newstext);
				}
			}
			$string=str_replace('[!--'.$pf.'--]',$newstext,$string);
			$string=str_replace('[!--p.title--]',strip_tags($ptitle),$string);
			$string=str_replace('[!--next.page--]',$thisnextlink,$string);
			$string=str_replace('[!--page.url--]',$truepage,$string);
			$string=str_replace('[!--title.select--]',$titleselect,$string);
			//д�ļ�
			WriteFiletext($file,$addlevel.$string);
		}
	}
	else
	{
		$file=$doclasspath.$newspath.$add[filename].$filetype;
		$string=$newstempstr;//ģ��
		//�滻����
		$string=str_replace('[!--p.title--]',$add[title],$string);
		$string=str_replace('[!--next.page--]','',$string);
		$string=str_replace('[!--page.url--]','',$string);
		$string=str_replace('[!--title.select--]','',$string);
		//д�ļ�
		WriteFiletext($file,$addlevel.$string);
	}
	//��Ϊ������
	if(empty($doall)&&empty($add['havehtml']))
	{
		$empire->query("update {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index set havehtml=1 where id='$add[id]' limit 1");
		$empire->query("update {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." set havehtml=1 where id='$add[id]' limit 1");
	}
}

//��������ַ�
function ReturnNotcj($string){
	global $notcj_r,$notcjnum;
	if(empty($notcjnum))
	{
		$rep="";
    }
	else
	{
		$i=rand(1,$notcjnum);
		$rep=$notcj_r[$i];
    }
	$cjword="<!--ecms.*-->";
	$string=str_replace($cjword,$rep,$string);
	return $string;
}

//ȡ���������
function GetKeyboard($keyboard,$keyid,$classid,$id,$link_num){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	if($keyid&&$link_num)
	{
		$add="id in (".$keyid.")";
		$tr=$empire->fetch1("select otherlinktemp,otherlinktempsub,otherlinktempdate from ".GetTemptb("enewspubtemp")." limit 1");//ȡ���������ģ��
		$temp_r=explode("[!--empirenews.listtemp--]",$tr[otherlinktemp]);
		$key_sql=$empire->query("select id,newstime,title,isurl,titleurl,classid,titlepic from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$add." order by newstime desc limit $link_num");
		while($link_r=$empire->fetch($key_sql))
		{
			$keyboardtext.=RepOtherTemp($temp_r[1],$link_r,$tr);
		}
		$keyboardtext=$temp_r[0].$keyboardtext.$temp_r[2];
	}
	else
	{
		$keyboardtext=$fun_r['NotLinkNews'];
	}
	return $keyboardtext;
}

//�滻�������ģ��
function RepOtherTemp($temptext,$r,$tr){
	global $public_r,$class_r;
	$title=sub($r[title],0,$tr['otherlinktempsub'],false);
	$r['newstime']=date($tr['otherlinktempdate'],$r['newstime']);
	$titlelink=sys_ReturnBqTitleLink($r);//��������
	$temptext=str_replace("[!--title--]",$title,$temptext);
	$temptext=str_replace("[!--oldtitle--]",$r[title],$temptext);
	$temptext=str_replace("[!--titleurl--]",$titlelink,$temptext);
	$temptext=str_replace("[!--newstime--]",$r[newstime],$temptext);
	if(empty($r[titlepic]))
	{
		$titlepic=$public_r[newsurl]."e/data/images/notimg.gif";
	}
	else
	{
		$titlepic=$r[titlepic];
	}
	$temptext=str_replace("[!--titlepic--]",$titlepic,$temptext);
	return $temptext;
}

//�������ص�ַhtml����
function ReturnDownSoftHtml($add){
	global $class_r,$public_r,$fun_r,$level_r;
	if(empty($add[downpath]))
	{
		return '';
	}
	//ÿ����ʾ����
	$down_num=$class_r[$add[classid]][down_num]?$class_r[$add[classid]][down_num]:1;
	//�滻ģ��
	$ydownsofttemp=$public_r[downsofttemp];
	$ydownsofttemp=str_replace('[!--classid--]',$add[classid],$ydownsofttemp);
	$ydownsofttemp=str_replace('[!--id--]',$add[id],$ydownsofttemp);
	$ydownsofttemp=str_replace('[!--title--]',$add[title],$ydownsofttemp);
	$ydownsofttemp=str_replace('[!--news.url--]',$public_r[newsurl],$ydownsofttemp);
	//��ϵ�ַ
	$all_downpath='';
	$path_r=explode("\r\n",$add[downpath]);
	$count=count($path_r);
    for($pj=0;$pj<$count;$pj++)
    {
		$p=$pj+1;
        if($p%$down_num==0)
        {
			$ok='<br>';
		}
        else
        {
			$ok='';
		}
		//��ͬ
		if($count==$p)
		{
			$ok='';
		}
		if($pj%$down_num==0||$pj==0)
        {
			$nbsp='';
		}
        else
        {
			$nbsp='&nbsp;&nbsp;';
		}
	    $showdown_r=explode('::::::',$path_r[$pj]);
	    if(count($showdown_r)<2)
		{
			$showdown_r[0]=$fun_r['DownPath'].$p;
		}
		//ģ��
		$downsofttemp=RepDownOnlinePathTemp($add,$ydownsofttemp,$pj,$showdown_r,0);
        $all_downpath.=$nbsp.stripSlashes($downsofttemp).$ok;
    }
	$value=$all_downpath;
	return $value;
}

//�滻�������ߵ�ַģ��
function RepDownOnlinePathTemp($add,$downsofttemp,$pj,$showdown_r,$ecms){
	global $public_r,$level_r,$fun_r;
	if($ecms==0)//����
	{
		$downurl=$public_r[newsurl]."e/DownSys/DownSoft/?classid=$add[classid]&id=$add[id]&pathid=$pj";
	}
	else//����
	{
		$downurl=$public_r[newsurl]."e/DownSys/play/?classid=$add[classid]&id=$add[id]&pathid=$pj";
	}
	$downsofttemp=str_replace('[!--down.url--]',$downurl,$downsofttemp);
	$downsofttemp=str_replace('[!--down.name--]',$showdown_r[0],$downsofttemp);
	$downsofttemp=str_replace('[!--pathid--]',$pj,$downsofttemp);
	$downsofttemp=str_replace('[!--fen--]',$showdown_r[3],$downsofttemp);
	$group=$showdown_r[2]?$level_r[$showdown_r[2]][groupname]:$fun_r['hguest'];
	$downsofttemp=str_replace('[!--group--]',$group,$downsofttemp);
	if(strstr($downsofttemp,'[!--true.down.url--]'))
	{
		$durl=stripSlashes($showdown_r[1]);
		$durlr=ReturnDownQzPath($durl,$showdown_r[4]);
		$durl=$durlr['repath'];
		$downsofttemp=str_replace('[!--true.down.url--]',$durl,$downsofttemp);
	}
	return $downsofttemp;
}

//�������ߵ�ַhtml����
function ReturnOnlinepathHtml($add){
	global $class_r,$public_r,$fun_r,$level_r;
	if(empty($add[onlinepath]))
	{
		return '';
	}
	//ÿ����ʾ����
	$down_num=$class_r[$add[classid]][online_num]?$class_r[$add[classid]][online_num]:1;
	//�滻ģ��
	$yonlinemovietemp=$public_r[onlinemovietemp];
	$yonlinemovietemp=str_replace('[!--classid--]',$add[classid],$yonlinemovietemp);
	$yonlinemovietemp=str_replace('[!--id--]',$add[id],$yonlinemovietemp);
	$yonlinemovietemp=str_replace('[!--title--]',$add[title],$yonlinemovietemp);
	$yonlinemovietemp=str_replace('[!--news.url--]',$public_r[newsurl],$yonlinemovietemp);
	//��ַ
	$all_downpath='';
	$path_r=explode("\r\n",$add[onlinepath]);
	$count=count($path_r);
    for($pj=0;$pj<$count;$pj++)
    {
		$p=$pj+1;
        if($p%$down_num==0)
        {
			$ok='<br>';
		}
        else
        {
			$ok='';
		}
		//��ͬ
		if($count==$p)
		{
			$ok='';
		}
		if($pj%$down_num==0||$pj==0)
        {
			$nbsp='';
		}
        else
        {
			$nbsp='&nbsp;&nbsp;';
		}
	    $showdown_r=explode('::::::',$path_r[$pj]);
	    if(count($showdown_r)<2)
		{
			$showdown_r[0]=$p;
		}
		//ģ��
		$downsofttemp=RepDownOnlinePathTemp($add,$yonlinemovietemp,$pj,$showdown_r,1);
        $all_downpath.=$nbsp.stripSlashes($downsofttemp).$ok;
	}
	$value=$all_downpath;
	return $value;
}

//����ͼƬ��html����
function ReturnMorepicpathHtml($add){
	global $public_r,$fun_r;
	if(empty($add[morepic]))
	{
		return '';
	}
	$line=$add[num]?$add[num]:1;//ÿ����ʾ
	$picpath='';
	$path_r=explode("\r\n",$add[morepic]);
	for($pj=0;$pj<count($path_r);$pj++)
    {
		$p=$pj+1;
		if(($p-1)%$line==0||$p==1)
		{
			$picpath.='<tr>';
		}
	    $showdown_r=explode('::::::',$path_r[$pj]);
		//��ʾͼƬ����
		$name='';
		if(!empty($showdown_r[2]))
		{
			$name="<br><span style='line-height=18pt'>".$showdown_r[2]."</span>";
		}
		$width=$add[width]?" width='".$add[width]."'":'';//���
		$height=$add[height]?" height='".$add[height]."'":'';//�߶�
		$picpath.="<td align=center><a href='".$public_r[newsurl]."e/ViewImg/index.html?url=".$showdown_r[1]."' target=_blank><img src='".$showdown_r[0]."'".$width.$height." border=0>".$name."</a></td>";
		//�ָ�
        if($p%$line==0)
		{
			$picpath.='</tr>';
		}
	}
	if($p<>0)
	{
		$table="<table width='100%' border=0 cellpadding=4 cellspacing=4>";
		$table1="</table>";
        $ys=$line-$p%$line;
		$dotr=0;
        for($j=0;$j<$ys&&$ys!=$line;$j++)
		{
			$dotr=1;
            $picpath.='<td></td>';
        }
		if($dotr==1)
		{
			$picpath.='</tr>';
		}
	}
	$value=$table.$picpath.$table1;
	return $value;
}

//����js
function GetNewsJs($classid,$line,$sub,$showdate,$enews=0,$tempr){
	global $empire,$public_r,$class_r,$class_tr,$emod_r,$etable_r,$dbtbpre,$eyh_r;
	if(empty($line))
	{
		$line=10;
	}
	if(empty($sub))
	{
		$sub=26;
	}
	//��Ŀ
	if($enews==0||$enews==1||$enews==2||$enews==9||$enews==12||$enews==15)
	{
		$where=$class_r[$classid][islast]?"classid='$classid'":ReturnClass($class_r[$classid][sonclass]);
		$tbname=$class_r[$classid][tbname];
		$mid=$class_r[$classid][modid];
		$yhid=$class_r[$classid][yhid];
    }
	elseif($enews==25||$enews==26||$enews==27||$enews==28||$enews==29||$enews==30)//�������
	{
		$where="ttid='$classid'";
		$mid=$class_tr[$classid][mid];
		$tbname=$emod_r[$mid][tbname];
		$yhid=$class_tr[$classid][yhid];
	}
	$allpath=eReturnTrueEcmsPath().'d/js/js/';
	$ttpath=eReturnTrueEcmsPath().'d/js/class/tt'.$classid.'_';
	$classpath=eReturnTrueEcmsPath().'d/js/class/class'.$classid.'_';
	$query='';
	$qand=' and ';
	if($enews==0)//��Ŀ����
	{
	   $query=' where '.$where;
	   $order='newstime';
	   $newsjs=$classpath.'newnews.js';
	   $yhvar='bqnew';
    }
	elseif($enews==1)//��Ŀ����
	{
	   $query=' where '.$where;
	   $order="onclick";
	   $newsjs=$classpath.'hotnews.js';
	   $yhvar='bqhot';
    }
	elseif($enews==2)//��Ŀ�Ƽ�
	{
	   $query=' where '.$where.' and isgood>0';
	   $order='newstime';
	   $newsjs=$classpath.'goodnews.js';
	   $yhvar='bqgood';
    }
	elseif($enews==9)//����Ŀ��������
	{
	   $query=' where '.$where;
	   $order='plnum';
	   $newsjs=$classpath.'hotplnews.js';
	   $yhvar='bqpl';
    }
	elseif($enews==12)//����Ŀͷ��
	{
		$query=' where '.$where.' and firsttitle>0';
		$order='newstime';
		$newsjs=$classpath.'firstnews.js';
		$yhvar='bqfirst';
    }
	elseif($enews==3)//��������
	{
		$qand=' where ';
		$tbname=$public_r['tbname'];
		$order='newstime';
		$newsjs=$allpath.'newnews.js';
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqnew';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==4)//���е������
	{
		$qand=' where ';
		$tbname=$public_r['tbname'];
		$order='onclick';
		$newsjs=$allpath.'hotnews.js';
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqhot';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==5)//�����Ƽ�
	{
		$tbname=$public_r['tbname'];
		$query=' where isgood>0';
		$order='newstime';
		$newsjs=$allpath.'goodnews.js';
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqgood';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==10)//������������
	{
		$qand=' where ';
		$tbname=$public_r['tbname'];
		$order='plnum';
		$newsjs=$allpath.'hotplnews.js';
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqpl';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==13)//����ͷ��
	{
	   $tbname=$public_r['tbname'];
	   $query=' where firsttitle>0';
	   $order='newstime';
	   $newsjs=$allpath.'firstnews.js';
	   $mid=$etable_r[$tbname][mid];
	   $yhvar='bqfirst';
	   $yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==25)//�����������
	{
	   $query=' where '.$where;
	   $order='newstime';
	   $newsjs=$ttpath.'newnews.js';
	   $yhvar='bqnew';
    }
	elseif($enews==26)//�������������
	{
	   $query=' where '.$where;
	   $order='onclick';
	   $newsjs=$ttpath.'hotnews.js';
	   $yhvar='bqhot';
    }
	elseif($enews==27)//��������Ƽ�
	{
	   $query=' where '.$where.' and isgood>0';
	   $order='newstime';
	   $newsjs=$ttpath.'goodnews.js';
	   $yhvar='bqgood';
    }
	elseif($enews==28)//���������������
	{
	   $query=' where '.$where;
	   $order='plnum';
	   $newsjs=$ttpath.'hotplnews.js';
	   $yhvar='bqpl';
    }
	elseif($enews==29)//�������ͷ��
	{
	   $query=' where '.$where.' and firsttitle>0';
	   $order='newstime';
	   $newsjs=$ttpath.'firstnews.js';
	   $yhvar='bqfirst';
    }
	$ret_r=ReturnReplaceListF($tempr[modid]);//�ֶ�
	//�Ż�
	$yhadd='';
	if(!empty($eyh_r[$yhid]['dojs']))
	{
		$yhadd=ReturnYhSql($yhid,$yhvar);
		if(!empty($yhadd))
		{
			$query.=$qand.$yhadd;
			$qand=' and ';
		}
	}
	$query='select '.ReturnSqlListF($mid).' from '.$dbtbpre.'ecms_'.$tbname.$query.' order by '.ReturnSetTopSql('js').$order.' desc limit '.$line;
	$sql=$empire->query($query);
	//ȡ��jsģ��
	$tempr[temptext]=str_replace('[!--news.url--]',$public_r[newsurl],$tempr[temptext]);
	$temp_r=explode("[!--empirenews.listtemp--]",$tempr[temptext]);
	$no=1;
	while($r=$empire->fetch($sql))
	{
		$r[oldtitle]=$r[title];
		//�滻�б����
		$repvar=ReplaceListVars($no,$temp_r[1],$tempr[subnews],$tempr[subtitle],$tempr[showdate],$url,0,$r,$ret_r);
		$allnew.=$repvar;
		$no++;
	}
	$allnew="document.write(\"".addslashes(stripSlashes(str_replace("\r\n","",$temp_r[0].$allnew.$temp_r[2])))."\");";
	WriteFiletext_n($newsjs,$allnew);
}

//�����Զ���js
function ReUserjs($jsr,$addpath){
	global $empire,$public_r;
	$jsfilepath=eReturnTrueEcmsPath().'e/data/'.$jsr['jsfilename'];//maddpath
	DoFileMkDir($jsfilepath);//��Ŀ¼
	eAutodo_AddDo('ReUserjs',$jsr['jsid'],0,0,0,0);//moreportdo
	//ȡ��jsģ��
	$jstemptext=GetTheJstemp($jsr[jstempid]);
	$ret_r=ReturnReplaceListF($jstemptext[modid]);//�ֶ�
	$jstemptext[temptext]=str_replace('[!--news.url--]',$public_r[newsurl],$jstemptext[temptext]);
	$temp_r=explode("[!--empirenews.listtemp--]",$jstemptext[temptext]);
	$query=$jsr[jssql];
	$query=RepSqlTbpre($query);
	$sql=$empire->query($query);
	$no=1;
	while($r=$empire->fetch($sql))
	{
		$r[oldtitle]=$r[title];
		//�滻�б����
		$repvar=ReplaceListVars($no,$temp_r[1],$jstemptext[subnews],$jstemptext[subtitle],$jstemptext[showdate],$url,0,$r,$ret_r);
		$allnew.=$repvar;
		$no++;
	}
	$allnew="document.write(\"".addslashes(stripSlashes(str_replace("\r\n","",$temp_r[0].$allnew.$temp_r[2])))."\");";
	WriteFiletext_n($jsfilepath,$allnew);
}

//ˢ����Ϣ�б�
function ReListHtml($classid,$enews=0){
	global $empire,$class_r,$dbtbpre;
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror("NotChangeReClassid","history.go(-1)");
	}
	$r=$empire->fetch1("select classtempid,islist from {$dbtbpre}enewsclass where classid='$classid'");
	if($class_r[$classid][islast])//�ռ���Ŀ
	{
		ListHtml($classid,$ret_r,0);
	}
	else
	{
		if($r[islist]==1)
		{
			ListHtml($classid,$ret_r,3);
		}
		elseif($r[islist]==3)
		{
			ReClassBdInfo($classid);
		}
		else
		{
			$classtemp=$r[islist]==2?GetClassText($classid):GetClassTemp($r['classtempid']);
			NewsBq($classid,$classtemp,0,0);
		}
	}
	if($enews==1)//�ڲ�ˢ��
	{return "";}
	insert_dolog("");//������־
	printerror("ReClassidSuccess","history.go(-1)");
}

//ȡ���Զ���ҳ��ģ��
function GetPageTemp($tempid){
	global $empire;
	$r=$empire->fetch1("select temptext from ".GetTemptb("enewspagetemp")." where tempid='$tempid'");
	return $r['temptext'];
}

//�滻�Զ���ҳ���ǩ
function RepUserpageVar($pagetext,$title,$pagetitle,$pagekeywords,$pagedescription,$pagestr,$id){
	$pagestr=str_replace("[!--pagetext--]",$pagetext,$pagestr);
	$pagestr=str_replace("[!--pagetitle--]",$pagetitle,$pagestr);
	$pagestr=str_replace("[!--pagekeywords--]",$pagekeywords,$pagestr);
	$pagestr=str_replace("[!--pagedescription--]",$pagedescription,$pagestr);
	$pagestr=str_replace("[!--pageid--]",$id,$pagestr);
	$pagestr=str_replace("[!--pagename--]",$title,$pagestr);
	return $pagestr;
}

//�����Զ���ҳ��
function ReUserpage($id,$pagetext,$path,$title="",$pagetitle,$pagekeywords,$pagedescription,$tempid=0){
	global $public_r;
	if(empty($path))
	{
		return "";
	}
	$path=eReturnTrueEcmsPath().'e/data/'.$path;
	DoFileMkDir($path);//��Ŀ¼
	eAutodo_AddDo('ReUserpage',$id,0,0,0,0);//moreportdo
	if(empty($pagetitle))
	{
		$pagetitle=$title;
	}
	//ģ��ʽ
	if($tempid)
	{
		$pagestr=GetPageTemp($tempid);
	}
	else
	{
		$pagestr=$pagetext;
	}
	$pagestr=InfoNewsBq("page".$id,$pagestr);
	$pagestr=RepUserpageVar($pagetext,$title,$pagetitle,$pagekeywords,$pagedescription,$pagestr,$id);
	$pagestr=str_replace("[!--news.url--]",$public_r['newsurl'],$pagestr);
	WriteFiletext($path,$pagestr);
}

//�����Զ�����Ϣ�б�
function ReUserlist($listr,$addpath){
	$listr['addpath']=$addpath;
	DoFileMkDir(eReturnTrueEcmsPath().'e/data/'.$listr['filepath']);//��Ŀ¼maddpath
	eAutodo_AddDo('ReUserlist',$listr['listid'],0,0,0,0);//moreportdo
	ListHtml($listr['listid'],$field,4,$listr);
}

//���������ļ�
function GetSearch($mid=0){
	global $empire,$public_r,$fun_r,$dbtbpre;
	//ȡ��ģ��
	$tr=$empire->fetch1("select searchtemp,searchjstemp,searchjstemp1 from ".GetTemptb("enewspubtemp")." limit 1");
	//������Ŀ����
	$fcfile=eReturnTrueEcmsPath()."e/data/fc/ListEnews.php";
	$fcjsfile=eReturnTrueEcmsPath()."e/data/fc/cmsclass.js";
	if(file_exists($fcjsfile)&&file_exists($fcfile))
	{
		$options=GetFcfiletext($fcjsfile);
	}
	else
	{
		$options=ShowClass_AddClass("","n",0,"|-",0,1);
	}
	//$options="<script src=".$public_r[newsurl]."e/data/fc/searchclass.js></script>";
	$functions="function search_check(obj){if(obj.keyboard.value.length==0){alert('".$fun_r['EmptyKey']."');return false;}return true;}";
	//��������
	$searchjstemp=ReplaceStemp($tr[searchjstemp],$options,$url,0,'','','');
	$text2=$functions."document.write(\"".$searchjstemp."\");";
	//��������
	$searchjstemp1=ReplaceStemp($tr[searchjstemp1],$options,$url,0,'','','');
	$text3.=$functions."document.write(\"".$searchjstemp1."\");";
	//�߼�����
	$url="<a href='".ReturnSiteIndexUrl()."'>".$fun_r['index']."</a>&nbsp;>&nbsp;<a href='../search/'>".$fun_r['adsearch']."</a>&nbsp;>";//������
	//����ģ���滻
	$dbsearchtemp=ReplaceStemp($tr[searchtemp],$options,$url,0,$fun_r['adsearch'],$fun_r['adsearch'],$fun_r['adsearch'],1);
	$text4=$dbsearchtemp;
	//������Ϣ��Ŀ
	if($mid)
	{
		$options1=ShowClass_AddClass("","n",0,"|-",$mid,2);
		$addnews_class="document.write(\"".addslashes($options1)."\");";
		$filename3=eReturnTrueEcmsPath()."d/js/js/addinfo".$mid.".js";
		WriteFiletext_n($filename3,$addnews_class);
    }
	$filename=eReturnTrueEcmsPath()."d/js/js/search_news1.js";
	WriteFiletext_n($filename,$text2);
	$filename1=eReturnTrueEcmsPath()."d/js/js/search_news2.js";
	WriteFiletext_n($filename1,$text3);
	$filename2=eReturnTrueEcmsPath()."search/index".$public_r[searchtype];
	WriteFiletext($filename2,$text4);
}

//�滻�����������
function RepSearchRtemp($temptext,$url){
	global $public_r;
	//��������
	$temptext=str_replace("[!--hotnews--]","<script src=".$public_r[newsurl]."d/js/js/hotnews.js></script>",$temptext);
	//�������
	$temptext=str_replace("[!--newnews--]","<script src=".$public_r[newsurl]."d/js/js/newnews.js></script>",$temptext);
	//�Ƽ�
	$temptext=str_replace("[!--goodnews--]","<script src=".$public_r[newsurl]."d/js/js/goodnews.js></script>",$temptext);
	//��������
	$temptext=str_replace("[!--hotplnews--]","<script src=".$public_r[newsurl]."d/js/js/hotplnews.js></script>",$temptext);
	//��ҳ
	$temptext=str_replace("[!--listpage--]","<?=\$listpage?>",$temptext);
	//�ؼ���
	$temptext=str_replace("[!--keyboard--]","<?=\$keyboard?>",$temptext);
	//�ܼ�¼��
	$temptext=str_replace("[!--num--]","<?=\$num?>",$temptext);
	//������
	$temptext=str_replace("[!--url--]",$url,$temptext);
	$temptext=str_replace("[!--newsurl--]",$public_r[newsurl],$temptext);
	return $temptext;
}

//���������ļ�
function GetPlTempPage($pltempid=0){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$pl_t_filename=eReturnTrueEcmsPath().'e/data/template/pltemp.txt';
	$yplfiletemp=ReadFiletext($pl_t_filename);
	$yplfiletemp=str_replace("\\","\\\\",$yplfiletemp);
	//������
	$url="<a href='".ReturnSiteIndexUrl()."'>".$fun_r['index']."</a>&nbsp;>&nbsp;[!--title--]&nbsp;>&nbsp;".$fun_r['newspl']."&nbsp;>";
	$pagetitle="<?=\$pagetitle?> ".$fun_r['newspl'];
	$pagekey=$pagetitle;
	$pagedes=$pagetitle;
	$pr=$empire->fetch1("select plf from {$dbtbpre}enewspl_set limit 1");
	//�س��ֶ�
	$tobrf=',';
	$plfsql=$empire->query("select f from {$dbtbpre}enewsplf where ftype='VARCHAR' or ftype='TEXT' or ftype='MEDIUMTEXT' or ftype='LONGTEXT'");
	while($plfr=$empire->fetch($plfsql))
	{
		$tobrf.=$plfr[f].',';
	}
	$pr['pltobrf']=$tobrf;
	//ȡ������ҳ��ģ��
	$where=$pltempid?" where tempid='$pltempid'":'';
	$ptsql=$empire->query("select tempid,temptext from ".GetTemptb("enewspltemp").$where);
	while($ptr=$empire->fetch($ptsql))
	{
		$plfiletemp=$yplfiletemp;
		$pl_filename=eReturnTrueEcmsPath().'e/data/filecache/template/pl'.$ptr[tempid].'.php';
		$pltemp=$ptr['temptext'];
		//ͷ������
		$pltemp=ReplaceSvars($pltemp,$url,0,$pagetitle,$pagekey,$pagedes,$add,1);
		$pltemp=RepSearchRtemp($pltemp,$url);
		//����
		$pltemp=str_replace("[!--title--]","<?=\$title?>",$pltemp);
		$pltemp=str_replace("[!--titleurl--]","<?=\$titleurl?>",$pltemp);
		$pltemp=str_replace("[!--id--]","<?=\$id?>",$pltemp);
		$pltemp=str_replace("[!--classid--]","<?=\$classid?>",$pltemp);
		$pltemp=str_replace("[!--plnum--]","<?=\$num?>",$pltemp);
		//����
		$pltemp=str_replace("[!--pinfopfen--]","<?=\$pinfopfen?>",$pltemp);
		$pltemp=str_replace("[!--infopfennum--]","<?=\$infopfennum?>",$pltemp);
		//��¼
		$pltemp=str_replace("[!--key.url--]",$public_r[newsurl]."e/ShowKey/?v=pl",$pltemp);
		$pltemp=str_replace("[!--lusername--]","<?=\$lusername?>",$pltemp);
		$pltemp=str_replace("[!--lpassword--]","<?=\$lpassword?>",$pltemp);
		//�б����
		$listtemp_r=explode("[!--empirenews.listtemp--]",$pltemp);
		$plfiletemp=str_replace("<!--empire.listtemp.top-->",$listtemp_r[0],$plfiletemp);
		$plfiletemp=str_replace("<!--empire.listtemp.footer-->",$listtemp_r[2],$plfiletemp);
		//�б��м�
		$listtemp_center=str_replace("[!--plid--]","<?=\$r[plid]?>",$listtemp_r[1]);
		$listtemp_center=str_replace("[!--pltext--]","<?=\$saytext?>",$listtemp_center);
		$listtemp_center=str_replace("[!--pltime--]","<?=\$saytime?>",$listtemp_center);
		$listtemp_center=str_replace("[!--plip--]","<?=\$sayip?>",$listtemp_center);
		$listtemp_center=str_replace("[!--username--]","<?=\$plusername?>",$listtemp_center);
		$listtemp_center=str_replace("[!--userid--]","<?=\$r[userid]?>",$listtemp_center);
		$listtemp_center=str_replace("[!--includelink--]","<?=\$includelink?>",$listtemp_center);
		$listtemp_center=str_replace("[!--zcnum--]","<?=\$r[zcnum]?>",$listtemp_center);
		$listtemp_center=str_replace("[!--fdnum--]","<?=\$r[fdnum]?>",$listtemp_center);
		$listtemp_center=ReplacePlListVars($listtemp_center,$r,$pr,0);
		$plfiletemp=str_replace("<!--empire.listtemp.center-->",$listtemp_center,$plfiletemp);
		WriteFiletext($pl_filename,$plfiletemp);
	}
}

//�滻�����ֶ�
function ReplacePlListVars($temp,$r,$pr,$ecms=0){
	$fr=explode(',',$pr['plf']);
	$count=count($fr)-1;
	for($i=1;$i<$count;$i++)
	{
		$f=$fr[$i];
		if($ecms==1)
		{
			if(strstr($pr['pltobrf'],','.$f.','))
			{
				$temp=str_replace('[!--'.$f.'--]',"<?=addslashes(stripSlashes(str_replace(\"\\r\\n\",\"\",\$r[".$f."])))?>",$temp);
			}
			else
			{
				$temp=str_replace('[!--'.$f.'--]',"<?=\$r[".$f."]?>",$temp);
			}
		}
		else
		{
			if(strstr($pr['pltobrf'],','.$f.','))
			{
				$temp=str_replace('[!--'.$f.'--]',"<?=stripSlashes(\$r[".$f."])?>",$temp);
			}
			else
			{
				$temp=str_replace('[!--'.$f.'--]',"<?=\$r[".$f."]?>",$temp);
			}
		}
	}
	return $temp;
}

//��������JS�ļ�
function GetPlJsPage(){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$pl_t_filename=eReturnTrueEcmsPath()."e/data/template/pljstemp.txt";
	$pl_filename=eReturnTrueEcmsPath()."e/pl/more/index.php";
	$pltemp=ReadFiletext($pl_t_filename);
	$pr=$empire->fetch1("select plf from {$dbtbpre}enewspl_set limit 1");
	//�س��ֶ�
	$tobrf=',';
	$plfsql=$empire->query("select f from {$dbtbpre}enewsplf where ftype='VARCHAR' or ftype='TEXT' or ftype='MEDIUMTEXT' or ftype='LONGTEXT'");
	while($plfr=$empire->fetch($plfsql))
	{
		$tobrf.=$plfr[f].',';
	}
	$pr['pltobrf']=$tobrf;
	//ȡ������JSģ��
	$pl_r=$empire->fetch1("select pljstemp from ".GetTemptb("enewspubtemp")." limit 1");
	$pljstemp=str_replace("\r\n","",$pl_r['pljstemp']);
	$pljstemp=addslashes(stripSlashes($pljstemp));
	$pljstemp=str_replace("[!--id--]","<?=\$id?>",$pljstemp);
	$pljstemp=str_replace("[!--classid--]","<?=\$classid?>",$pljstemp);
	$pljstemp=str_replace("[!--news.url--]",$public_r[newsurl],$pljstemp);
	$listtemp_r=explode("[!--empirenews.listtemp--]",$pljstemp);
	$pltemp=str_replace("<!--empire.listtemp.top-->",$listtemp_r[0],$pltemp);
	$pltemp=str_replace("<!--empire.listtemp.footer-->",$listtemp_r[2],$pltemp);
	//�б��м�
	$listtemp_center=str_replace("[!--plid--]","<?=\$r[plid]?>",$listtemp_r[1]);
	$listtemp_center=str_replace("[!--pltext--]","<?=\$saytext?>",$listtemp_center);
	$listtemp_center=str_replace("[!--pltime--]","<?=\$saytime?>",$listtemp_center);
	$listtemp_center=str_replace("[!--plip--]","<?=\$sayip?>",$listtemp_center);
	$listtemp_center=str_replace("[!--username--]","<?=\$plusername?>",$listtemp_center);
	$listtemp_center=str_replace("[!--userid--]","<?=\$r[userid]?>",$listtemp_center);
	$listtemp_center=str_replace("[!--zcnum--]","<?=\$r[zcnum]?>",$listtemp_center);
	$listtemp_center=str_replace("[!--fdnum--]","<?=\$r[fdnum]?>",$listtemp_center);
	$listtemp_center=ReplacePlListVars($listtemp_center,$r,$pr,1);
	$pltemp=str_replace("<!--empire.listtemp.center-->",$listtemp_center,$pltemp);
    WriteFiletext_n($pl_filename,$pltemp);
}

//�������԰��ļ�
function ReGbooktemp(){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$tfile=eReturnTrueEcmsPath()."e/data/template/gbooktemp.txt";
	$file=eReturnTrueEcmsPath()."e/tool/gbook/index.php";
	$gbtemp=ReadFiletext($tfile);
	//ȡ������ҳ��ģ��
	$pr=$empire->fetch1("select gbooktemp from ".GetTemptb("enewspubtemp")." limit 1");
	$url="<?=\$url?>";
	$pagetitle="<?=\$bname?>";
	$pr['gbooktemp']=ReplaceSvars($pr['gbooktemp'],$url,0,$pagetitle,$pagetitle,$pagetitle,$add,1);
	$pr['gbooktemp']=RepSearchRtemp($pr['gbooktemp'],$url);
	$pr['gbooktemp']=str_replace("[!--bname--]","<?=\$bname?>",$pr['gbooktemp']);
	$pr['gbooktemp']=str_replace("[!--bid--]","<?=\$bid?>",$pr['gbooktemp']);

	$listtemp_r=explode("[!--empirenews.listtemp--]",$pr['gbooktemp']);
	$gbtemp=str_replace("<!--empire.listtemp.top-->",$listtemp_r[0],$gbtemp);
	$gbtemp=str_replace("<!--empire.listtemp.footer-->",$listtemp_r[2],$gbtemp);
	//---�б��м�
	//����ظ�
	$restart="
<?
if(\$r[retext])
{
?>
";
	$endstart="
<?
}
?>";
	$listtemp_center=str_replace("[!--start.regbook--]",$restart,$listtemp_r[1]);
	$listtemp_center=str_replace("[!--end.regbook--]",$endstart,$listtemp_center);

	$listtemp_center=str_replace("[!--lyid--]","<?=\$r[lyid]?>",$listtemp_center);
	$listtemp_center=str_replace("[!--name--]","<?=stripSlashes(\$r[name])?>",$listtemp_center);
	$listtemp_center=str_replace("[!--email--]","<?=stripSlashes(\$r[email])?>",$listtemp_center);
	$listtemp_center=str_replace("[!--mycall--]","<?=stripSlashes(\$r[mycall])?>",$listtemp_center);
	$listtemp_center=str_replace("[!--lytime--]","<?=\$r[lytime]?>",$listtemp_center);
	$listtemp_center=str_replace("[!--lytext--]","<?=\$r[lytext]?>",$listtemp_center);
	$listtemp_center=str_replace("[!--retext--]","<?=\$r[retext]?>",$listtemp_center);

	$gbtemp=str_replace("<!--empire.listtemp.center-->",$listtemp_center,$gbtemp);
	WriteFiletext($file,$gbtemp);
}

//���¿������ģ��
function ReCptemp(){
	global $empire,$public_r,$dbtbpre,$fun_r;
	$pr=$empire->fetch1("select cptemp from ".GetTemptb("enewspubtemp")." limit 1");
	$url="<?=\$url?>";
	$pagetitle="<?=defined('empirecms')?\$public_diyr[pagetitle]:'".$fun_r['membercp']."'?>";
	$temptext=ReplaceSvars($pr['cptemp'],$url,0,$pagetitle,$pagetitle,$pagetitle,$add,1);
	//����ͷβ�ļ�
	$r=explode("[!--empirenews.template--]",$temptext);
	$file1=eReturnTrueEcmsPath()."e/data/template/cp_1.php";
	WriteFiletext($file1,AddCheckViewTempCode().$r[0]);
	$file2=eReturnTrueEcmsPath()."e/data/template/cp_2.php";
	WriteFiletext($file2,AddCheckViewTempCode().$r[1]);
}

//���µ�½״̬ģ��
function ReLoginIframe(){
	global $empire,$public_r,$dbtbpre;
	$tfile=eReturnTrueEcmsPath()."e/data/template/loginiframetemp.txt";
	$loginiframetemp=ReadFiletext($tfile);
	$pr=$empire->fetch1("select loginiframe,loginjstemp from ".GetTemptb("enewspubtemp")." limit 1");
	//��ܵ�½״̬����
	$temptext=str_replace("[!--news.url--]",$public_r['newsurl'],$pr['loginiframe']);
	$temptext=str_replace("[!--userid--]","<?=\$myuserid?>",$temptext);
	$temptext=str_replace("[!--username--]","<?=\$myusername?>",$temptext);
	$temptext=str_replace("[!--groupname--]","<?=\$groupname?>",$temptext);
	$temptext=str_replace("[!--money--]","<?=\$money?>",$temptext);
	$temptext=str_replace("[!--userdate--]","<?=\$userdate?>",$temptext);
	$temptext=str_replace("[!--havemsg--]","<?=\$havemsg?>",$temptext);
	$temptext=str_replace("[!--userfen--]","<?=\$userfen?>",$temptext);
	$r=explode("[!--empirenews.template--]",$temptext);
	$text=str_replace("<!--login-->",$r[0],$loginiframetemp);
	$text=str_replace("<!--loginin-->",$r[1],$text);
	$file=eReturnTrueEcmsPath()."e/member/iframe/index.php";
	WriteFiletext($file,$text);
	//JS��½״̬����
	$temptext=str_replace("[!--news.url--]",$public_r['newsurl'],$pr['loginjstemp']);
	$temptext=str_replace("[!--userid--]","<?=\$myuserid?>",$temptext);
	$temptext=str_replace("[!--username--]","<?=\$myusername?>",$temptext);
	$temptext=str_replace("[!--groupname--]","<?=\$groupname?>",$temptext);
	$temptext=str_replace("[!--money--]","<?=\$money?>",$temptext);
	$temptext=str_replace("[!--userdate--]","<?=\$userdate?>",$temptext);
	$temptext=str_replace("[!--havemsg--]","<?=\$havemsg?>",$temptext);
	$temptext=str_replace("[!--userfen--]","<?=\$userfen?>",$temptext);
	$r=explode("[!--empirenews.template--]",$temptext);
	$login="document.write(\"".addslashes(stripSlashes(str_replace("\r\n","",$r[0])))."\");";
	$loginin="document.write(\"".addslashes(stripSlashes(str_replace("\r\n","",$r[1])))."\");";
	$text=str_replace("<!--login-->",$login,$loginiframetemp);
	$text=str_replace("<!--loginin-->",$loginin,$text);
	$file=eReturnTrueEcmsPath()."e/member/login/loginjs.php";
	WriteFiletext_n($file,$text);
}

//����ͶƱģ��
function ReturnVoteTemp($tempid,$enews=0){
	global $empire;
	$r=$empire->fetch1("select temptext from ".GetTemptb("enewsvotetemp")." where tempid='$tempid'");
	if($enews)
	{
		$r[temptext]=str_replace("\r\n","",$r[temptext]);
	}
	return $r[temptext];
}

//�滻ͶƱģ���������
function RepVoteTempAllvar($temptext,$r){
	global $public_r;
	$action=$public_r['newsurl']."e/enews/index.php";
	$temptext=str_replace("[!--vote.action--]",$action,$temptext);
	$temptext=str_replace("[!--title--]",$r[title],$temptext);
	$viewurl=$public_r[newsurl]."e/tool/vote/?voteid=".$r[voteid];
	$temptext=str_replace("[!--vote.view--]",$viewurl,$temptext);
	$temptext=str_replace("[!--width--]",$r[width],$temptext);
	$temptext=str_replace("[!--height--]",$r[height],$temptext);
	$temptext=str_replace("[!--voteid--]",$r[voteid],$temptext);
	$temptext=str_replace("[!--id--]",$r[id],$temptext);
	$temptext=str_replace("[!--classid--]",$r[classid],$temptext);
	$temptext=str_replace("[!--news.url--]",$public_r[newsurl],$temptext);
	return $temptext;
}

//�滻ͶƱģ���б�
function RepVoteTempListvar($temptext,$votebox,$votename){
	$temptext=str_replace("[!--vote.box--]",$votebox,$temptext);
	$temptext=str_replace("[!--vote.name--]",$votename,$temptext);
	return $temptext;
}

//���ɴ�ӡҳ��
function GetPrintPage($printtempid=0){
	global $empire,$dbtbpre,$fun_r,$public_r;
	$file=eReturnTrueEcmsPath().'e/data/template/printtemp.txt';
	$string=ReadFiletext($file);
	$url="<?=\$url?>";
	$pagetitle="<?=ehtmlspecialchars(\$r[title])?> ".$fun_r['PrintPage'];
	//ȡ������ҳ��ģ��
	$where=$printtempid?" where tempid='$printtempid'":'';
	$ptsql=$empire->query("select tempid,temptext,showdate,modid from ".GetTemptb("enewsprinttemp").$where);
	while($ptr=$empire->fetch($ptsql))
	{
		$ptr[temptext]=ReplaceSvars($ptr[temptext],$url,0,$pagetitle,$pagetitle,$pagetitle,$add,1);
		$printtemp=RepPrintTempV($ptr);
		$printtemp=str_replace("<!--empire.print-->",$printtemp,$string);
		$truefile=eReturnTrueEcmsPath().'e/data/filecache/template/print'.$ptr[tempid].'.php';
		WriteFiletext($truefile,$printtemp);
	}
}

//�滻��ӡģ�����
function RepPrintTempV($tr){
	global $empire,$dbtbpre,$fun_r,$public_r,$emod_r;
	$temptext=$tr['temptext'];
	$mid=$tr['modid'];
	//�ֶ�
	$tempf=$emod_r[$mid]['tempf'];
	$fr=explode(',',$tempf);
	$fcount=count($fr)-1;
	for($i=1;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$value="stripSlashes(\$r[".$f."])";
		if($f=='newstime')//ʱ��
		{
			$value="date('".$tr[showdate]."',\$r[".$f."])";
		}
		elseif($f=='title')//����
		{
		}
		else//�����ֶ�
		{
			if(!strstr($emod_r[$mid]['editorf'],','.$f.','))
			{
				if(strstr($emod_r[$mid]['tobrf'],','.$f.','))//��br
				{
					$value='nl2br('.$value.')';
				}
				if(!strstr($emod_r[$mid]['dohtmlf'],','.$f.','))//ȥ��html
				{
					$value='RepFieldtextNbsp(ehtmlspecialchars('.$value.'))';
				}
			}
		}
		$temptext=str_replace('[!--'.$f.'--]','<?='.$value.'?>',$temptext);
	}
	$temptext=str_replace("[!--id--]","<?=\$r[id]?>",$temptext);
	$temptext=str_replace("[!--classid--]","<?=\$r[classid]?>",$temptext);
	$temptext=str_replace("[!--keyboard--]","<?=\$r[keyboard]?>",$temptext);
	$temptext=str_replace("[!--class.name--]","<?=\$class_r[\$classid][classname]?>",$temptext);
	$temptext=str_replace("[!--bclass.id--]","<?=\$bclassid?>",$temptext);
	$temptext=str_replace("[!--bclass.name--]","<?=\$class_r[\$bclassid][classname]?>",$temptext);
	$temptext=str_replace('[!--ttid--]',"<?=\$r[ttid]?>",$temptext);
	$temptext=str_replace('[!--tt.name--]',"<?=\$class_tr[\$r[ttid]][tname]?>",$temptext);
	$temptext=str_replace('[!--tt.url--]',"<?=sys_ReturnBqInfoTypeUrl(\$r[ttid])?>",$temptext);
	$temptext=str_replace("[!--userfen--]","<?=\$r[userfen]?>",$temptext);
	$temptext=str_replace("[!--onclick--]","<?=\$r[onclick]?>",$temptext);
	$temptext=str_replace("[!--totaldown--]","<?=\$r[totaldown]?>",$temptext);
	$temptext=str_replace("[!--plnum--]","<?=\$r[plnum]?>",$temptext);
	$temptext=str_replace("[!--userid--]","<?=\$r[userid]?>",$temptext);
	$temptext=str_replace("[!--username--]","<?=\$r[username]?>",$temptext);
	$temptext=str_replace("[!--titlelink--]","<?=\$titleurl?>",$temptext);
	$temptext=str_replace("[!--titleurl--]","<?=\$titleurl?>",$temptext);
	$temptext=str_replace("[!--url--]","<?=\$url?>",$temptext);
	return $temptext;
}

//��������ҳ��ģ��
function GetDownloadPage(){
	global $empire,$public_r,$dbtbpre,$fun_r;
	$pr=$empire->fetch1("select downpagetemp from ".GetTemptb("enewspubtemp")." limit 1");
	$temptext=$pr['downpagetemp'];
	$url="<a href='".ReturnSiteIndexUrl()."'>".$fun_r['index']."</a>&nbsp;>&nbsp;<a href='<?=\$titleurl?>'><?=\$r[title]?></a>&nbsp;>&nbsp;<?=\$thisdownname?>";
	$pagetitle="<?=ehtmlspecialchars(\$r[title])?> - <?=ehtmlspecialchars(\$thisdownname)?>";
	$temptext=ReplaceSvars($temptext,$url,"<?=\$r[classid]?>",$pagetitle,$pagetitle,$pagetitle,$add,1);
	//����
	$temptext=str_replace("[!--classid--]","<?=\$r[classid]?>",$temptext);
	$temptext=str_replace("[!--class.name--]","<?=\$classname?>",$temptext);
	$temptext=str_replace("[!--bclass.id--]","<?=\$bclassid?>",$temptext);
	$temptext=str_replace("[!--bclass.name--]","<?=\$bclassname?>",$temptext);
	//���ص�ַ
	$temptext=str_replace("[!--down.url--]","<?=\$url?>",$temptext);
	$temptext=str_replace("[!--true.down.url--]","<?=\$trueurl?>",$temptext);
	$temptext=str_replace("[!--down.name--]","<?=\$thisdownname?>",$temptext);
	//����Ȩ��
	$temptext=str_replace("[!--fen--]","<?=\$fen?>",$temptext);
	$temptext=str_replace("[!--group--]","<?=\$downuser?>",$temptext);
	//��Ϣ
	$temptext=str_replace("[!--id--]","<?=\$r[id]?>",$temptext);
	$temptext=str_replace("[!--titleurl--]","<?=\$titleurl?>",$temptext);
	$temptext=str_replace("[!--title--]","<?=\$r[title]?>",$temptext);
	$temptext=str_replace("[!--newstime--]","<?=\$newstime?>",$temptext);
	$temptext=str_replace("[!--titlepic--]","<?=\$titlepic?>",$temptext);
	$temptext=str_replace("[!--keyboard--]","<?=\$r[keyboard]?>",$temptext);
	$temptext=str_replace("[!--userid--]","<?=\$r[userid]?>",$temptext);
	$temptext=str_replace("[!--username--]","<?=\$r[username]?>",$temptext);
	$temptext=str_replace("[!--pathid--]","<?=\$pathid?>",$temptext);
	$temptext=str_replace("[!--totaldown--]","<?=\$r[totaldown]?>",$temptext);
	$temptext=str_replace("[!--onclick--]","<?=\$r[onclick]?>",$temptext);
	$file=eReturnTrueEcmsPath()."e/data/template/downpagetemp.php";
	WriteFiletext($file,AddCheckViewTempCode().$temptext);
}

//����ȫվ�����ļ�
function ReSchAlltemp(){
	global $empire,$public_r,$fun_r,$dbtbpre;
	$tfile=eReturnTrueEcmsPath()."e/data/template/schalltemp.txt";
	$file=eReturnTrueEcmsPath()."e/sch/index.php";
	$temp=ReadFiletext($tfile);
	//ȡ��ҳ��ģ��
	$pr=$empire->fetch1("select schalltemp,schallsubnum,schalldate from ".GetTemptb("enewspubtemp")." limit 1");
	$url="<?=\$url?>";
	$pagetitle=$fun_r['SearchAllNav'];
	$pr['schalltemp']=ReplaceSvars($pr['schalltemp'],$url,0,$pagetitle,$pagetitle,$pagetitle,$add,1);
	$temp=str_replace("<!--empire.listtemp.subnum-->",$pr['schallsubnum'],$temp);
	$temp=str_replace("<!--empire.listtemp.formatdate-->",$pr['schalldate'],$temp);

	$pr['schalltemp']=str_replace("[!--keyboard--]","<?=\$keyboard?>",$pr['schalltemp']);
	$pr['schalltemp']=str_replace("[!--num--]","<?=\$num?>",$pr['schalltemp']);
	$pr['schalltemp']=str_replace("[!--listpage--]","<?=\$listpage?>",$pr['schalltemp']);

	$listtemp_r=explode("[!--empirenews.listtemp--]",$pr['schalltemp']);
	$temp=str_replace("<!--empire.listtemp.top-->",$listtemp_r[0],$temp);
	$temp=str_replace("<!--empire.listtemp.footer-->",$listtemp_r[2],$temp);
	//---�б��м�
	$listtemp_center=str_replace("[!--no.num--]","<?=\$no?>",$listtemp_r[1]);
	$listtemp_center=str_replace("[!--titleurl--]","<?=\$titleurl?>",$listtemp_center);
	$listtemp_center=str_replace("[!--id--]","<?=\$r[id]?>",$listtemp_center);
	$listtemp_center=str_replace("[!--classid--]","<?=\$r[classid]?>",$listtemp_center);
	$listtemp_center=str_replace("[!--titlepic--]","<?=\$titlepic?>",$listtemp_center);
	$listtemp_center=str_replace("[!--newstime--]","<?=\$newstime?>",$listtemp_center);
	$listtemp_center=str_replace("[!--title--]","<?=\$title?>",$listtemp_center);
	$listtemp_center=str_replace("[!--smalltext--]","<?=\$smalltext?>",$listtemp_center);

	$temp=str_replace("<!--empire.listtemp.center-->",$listtemp_center,$temp);
	WriteFiletext($file,$temp);
}


//-------------- �û��� ----------------------

//���ز���Ȩ��
function ReturnLeftLevel($groupid){
	global $empire,$dbtbpre;
	if(empty($groupid))
	{return "";}
	$groupid=(int)$groupid;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsgroup where groupid='$groupid'");
	return $r;
}

//password
function DoEmpireCMSAdminPassword($password,$salt,$salt2){
	$pw=md5($salt2.'E!m^p-i(r#e.C:M?S'.md5(md5($password).$salt).'d)i.g^o-d'.$salt);
	return $pw;
}

//���ز���Ȩ��
function CheckLevel($userid,$username,$classid,$enews){
	global $empire,$dbtbpre;
	$userid=(int)$userid;
	$r=$empire->fetch1("select groupid,adminclass from {$dbtbpre}enewsuser where userid='$userid' limit 1");
	//������Ϣ
	if($enews=="news")
	{
		//����������ĿȨ��
		$gr=$empire->fetch1("select doall,doselfinfo,doaddinfo,doeditinfo,dodelinfo,docheckinfo,dogoodinfo,dodocinfo,domoveinfo,domustcheck,docheckedit,docanhtml,doinfofile from {$dbtbpre}enewsgroup where groupid='$r[groupid]'");
		if(empty($gr[doall]))
		{
			$e_r=explode("|".$classid."|",$r[adminclass]);
			if(count($e_r)!=2)
			{printerror("NotNewsLevel","history.go(-1)");}
		}
		$gr['add_adminclass']=$r['adminclass'];
		return $gr;
    }
	else
	{
		//�û���
		$gr=$empire->fetch1("select * from {$dbtbpre}enewsgroup where groupid='$r[groupid]'");
		$enews="do".$enews;
		if(empty($gr[$enews]))
		{
			printerror("NotLevel","history.go(-1)");
	    }
		$gr['add_adminclass']=$r['adminclass'];
		return $gr;
    }
}

//��֤����Ȩ��
function CheckDoLevel($lur,$groupid,$userclass,$username,$ecms=0){
	$ret=0;
	if(strstr($groupid,','.$lur[groupid].','))
	{
		$ret=1;
	}
	elseif(strstr($userclass,','.$lur[classid].','))
	{
		$ret=1;
	}
	elseif(stristr($username,','.$lur[username].','))
	{
		$ret=1;
	}
	if($ecms==0&&$ret==0)
	{
		printerror('NotLevel','history.go(-1)');
	}
	return $ret;
}

//��֤�̶��û�Ȩ��
function CheckAndUsernamesLevel($level,$id,$userid,$username,$groupid){
	global $empire,$dbtbpre;
	$id=(int)$id;
	if(!$id)
	{
		printerror('ErrorUrl','history.go(-1)');
	}
	if($level=='dozt')//ר��
	{
		$getquery="select ztid,usernames from {$dbtbpre}enewszt where ztid='$id'";
		$id_field='ztid';
		$users_field='usernames';
	}
	else
	{
		printerror('ErrorUrl','history.go(-1)');
	}
	$getr=$empire->fetch1($getquery);
	if(!$getr[$id_field])
	{
		printerror('ErrorUrl','history.go(-1)');
	}
	$gr=$empire->fetch1("select groupid,".$level." from {$dbtbpre}enewsgroup where groupid='$groupid'");
	if(!$gr['groupid'])
	{
		printerror('NotLevel','history.go(-1)');
	}
	if($gr[$level])
	{
		return 2;
	}
	if(!stristr(','.$getr[$users_field].',',','.$username.','))
	{
		printerror('NotLevel','history.go(-1)');
	}
	return 1;
}

//�Ƿ��½
function is_login($uid=0,$uname='',$urnd=''){
	global $empire,$public_r,$dbtbpre;
	$userid=$uid?$uid:getcvar('loginuserid',1);
	$username=$uname?$uname:getcvar('loginusername',1);
	$rnd=$urnd?$urnd:getcvar('loginrnd',1);
	$userid=(int)$userid;
	$username=RepPostVar($username);
	$rnd=RepPostVar($rnd);
	if(!$userid||!$username||!$rnd)
	{
		printerror("NotLogin","index.php");
	}
	$groupid=(int)getcvar('loginlevel',1);
	$adminstyle=(int)getcvar('loginadminstyleid',1);
	if(!strstr($public_r['adminstyle'],','.$adminstyle.','))
	{
		$adminstyle=$public_r['defadminstyle']?$public_r['defadminstyle']:1;
	}
	$truelogintime=(int)getcvar('truelogintime',1);
	$cdbdata=0;
	//COOKIE��֤
	$cdbdata=getcvar('ecmsdodbdata',1)?1:0;
	DoChECookieRnd($userid,$username,$rnd,'',$cdbdata,$groupid,$adminstyle,$truelogintime);
	//db
	$adminr=$empire->fetch1("select userid,groupid,classid,userprikey,uprnd from {$dbtbpre}enewsuser where userid='$userid' and username='".$username."' and rnd='".$rnd."' and checked=0 limit 1");
	if(!$adminr['userid'])
	{
		printerror("SingleUser","index.php");
	}
	DoECheckAndAuthRnd($userid,$username,$rnd,$adminr['userprikey'],$cdbdata,$groupid,$adminstyle,$truelogintime);
	//��½��ʱ
	$logintime=getcvar('logintime',1);
	if($logintime)
	{
		if(time()-$logintime>$public_r['exittime']*60)
		{
			esetcookie("loginrnd","",0,1);
			printerror("LoginTime","index.php");
	    }
		esetcookie("logintime",time(),0,1);
	}
	if(getcvar('eloginlic',1)<>"empirecmslic")
	{
		printerror("NotLogin","index.php");
	}
	$ur[userid]=$userid;
	$ur[username]=$username;
	$ur[rnd]=$rnd;
	$ur[groupid]=$adminr[groupid];
	$ur[adminstyleid]=(int)$adminstyle;
	$ur[classid]=$adminr[classid];
	return $ur;
}

function is_login_ebak($userid,$username,$rnd){
	global $empire,$public_r;
	$userid=(int)$userid;
	$username=RepPostVar($username);
	$dodbdata=getcvar('ecmsdodbdata',1);
	if(!$userid||!$username)
	{
		printerror("NotLogin","index.php");
	}
	if($dodbdata!="empirecms")
	{
		printerror("NotLogin","index.php");
	}
	$rnd=RepPostVar($rnd);
	//COOKIE��֤
	$cdbdata=$dodbdata?1:0;
	$groupid=(int)getcvar('loginlevel',1);
	$adminstyle=(int)getcvar('loginadminstyleid',1);
	$truelogintime=(int)getcvar('truelogintime',1);
	DoChECookieRnd($userid,$username,$rnd,'',$cdbdata,$groupid,$adminstyle,$truelogintime);
	//��ʱ
	$logintime=getcvar('logintime',1);
	if($logintime)
	{
		if(time()-$logintime>$public_r['exittime']*60)
		{
			esetcookie("loginrnd","",0,1);
			printerror("LoginTime","index.php");
	    }
		esetcookie("logintime",time(),0,1);
	}
	$ur[userid]=$userid;
	$ur[username]=$username;
	$ur[rnd]=$rnd;
	$ur[groupid]=$groupid;
	$ur[adminstyleid]=$adminstyle;
	$ur[classid]=0;
	return $ur;
}

//�Ƿ��½
function is_login_other($userid,$username,$rnd){
	global $empire,$public_r,$dbtbpre;
	$userid=(int)$userid;
	$username=RepPostVar($username);
	$rnd=RepPostVar($rnd);
	if(!$userid||!$username||!$rnd)
	{
		printerror("NotLogin","index.php");
	}
	$adminstyle=1;
	//db
	$adminr=$empire->fetch1("select userid,groupid,classid,userprikey from {$dbtbpre}enewsuser where userid='$userid' and username='".$username."' and rnd='".$rnd."' and checked=0 limit 1");
	if(!$adminr['userid'])
	{
		printerror("NotLogin","index.php");
	}
	$ur[userid]=$userid;
	$ur[username]=$username;
	$ur[rnd]=$rnd;
	$ur[groupid]=$adminr[groupid];
	$ur[adminstyleid]=(int)$adminstyle;
	$ur[classid]=$adminr[classid];
	return $ur;
}

//���ü�����֤
function DoECreateOtherRnd($userid,$username,$rnd,$ckoi=0){
	global $ecms_config;
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$otherinfo=$ckoi==1?DoECkOtherInfo():'empire.cms';
	$r['otherrndtime']=time();
	$r['otherrndtwo']=make_password(12);
	$r['otherrndpass']=md5(md5($rnd.'-empirecms.2002!check.other-'.$ecms_config['cks']['ckrndtwo']).'-'.$ip.'empire.cms'.'-'.$otherinfo.'-'.$userid.'-'.$r['otherrndtime'].'-'.$username.'db.check.rnd'.'-'.$rnd.'-phome'.$r['otherrndtwo']);
	return $r;
}

//��֤������֤
function DoECheckOtherRnd($userid,$username,$rnd,$loginecmsotherpass,$loginecmsothertime,$loginecmsotherrndtwo,$ckoi=0,$outtime=1800){
	global $ecms_config;
	if(!$loginecmsotherpass||!$loginecmsothertime)
	{
		printerror("NotLogin","index.php");
	}
	$loginecmsothertime=(int)$loginecmsothertime;
	$todaytime=time();
	if($loginecmsothertime+$outtime<$todaytime||$loginecmsothertime>$todaytime)
	{
		printerror("NotLogin","index.php");
	}
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$otherinfo=$ckoi==1?DoECkOtherInfo():'empire.cms';
	$ecmsckpass=md5(md5($rnd.'-empirecms.2002!check.other-'.$ecms_config['cks']['ckrndtwo']).'-'.$ip.'empire.cms'.'-'.$otherinfo.'-'.$userid.'-'.$loginecmsothertime.'-'.$username.'db.check.rnd'.'-'.$rnd.'-phome'.$loginecmsotherrndtwo);
	if('dg'.$ecmsckpass<>'dg'.$loginecmsotherpass)
	{
		printerror("NotLogin","index.php");
	}
}

//����SESSION��֤
function DoESessionRnd(){
	global $ecms_config;
	if(empty($ecms_config['esafe']['ckhsession']))
	{
		return '';
	}
	$sessval=make_password(27);
	$_SESSION['ecmsckhspass']=$sessval;
	return $sessval;
}

function ReESessionRnd(){
	global $ecms_config;
	if(empty($ecms_config['esafe']['ckhsession']))
	{
		return '';
	}
	if(!$_SESSION['ecmsckhspass'])
	{
		printerror('NotLogin','index.php');
	}
	return $_SESSION['ecmsckhspass'];
}

function DelESessionRnd(){
	global $ecms_config;
	if(empty($ecms_config['esafe']['ckhsession']))
	{
		return '';
	}
	$_SESSION['ecmsckhspass']='';
	unset($_SESSION['ecmsckhspass']);
	session_destroy();
}

//����������֤��Ϣ
function DoECkOtherInfo(){
	$otherinfo=$_SERVER['HTTP_USER_AGENT'];
	return $otherinfo;
}

//COOKIE����
function DoECookieRnd($userid,$username,$rnd,$userkey,$dbdata,$groupid,$adminstyle,$truelogintime){
	global $ecms_config;
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$otherinfo=DoECkOtherInfo();
	//session
	$sessval=DoESessionRnd();
	$ecmsckpass=md5(md5($rnd.$ecms_config['esafe']['ecookiernd']).'-'.$ip.'-'.$otherinfo.'-'.$userid.'-'.$username.'-'.$dbdata.$rnd.$groupid.'-'.$adminstyle.$sessval);
	esetcookie("loginecmsckpass",$ecmsckpass,0,1);
	DoECreatFileRnd($userid,$username,$rnd,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval);
	DoECreatAndAuthRnd($userid,$username,$rnd,$userkey,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval);
}

function DoChECookieRnd($userid,$username,$rnd,$userkey,$dbdata,$groupid,$adminstyle,$truelogintime){
	global $ecms_config;
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$otherinfo=DoECkOtherInfo();
	$sessval=ReESessionRnd();
	$ecmsckpass=md5(md5($rnd.$ecms_config['esafe']['ecookiernd']).'-'.$ip.'-'.$otherinfo.'-'.$userid.'-'.$username.'-'.$dbdata.$rnd.$groupid.'-'.$adminstyle.$sessval);
	if('dg'.$ecmsckpass<>'dg'.getcvar('loginecmsckpass',1))
	{
		printerror("NotLogin","index.php");
	}
	DoECheckFileRnd($userid,$username,$rnd,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval);
	//ehash
	hCheckEcmsEHash();
}

function DelECookieRnd(){
	esetcookie("loginecmsckpass",'',0,1);
}

//�ļ���֤

//�����ļ���֤DEF�����ַ�
function hAdminLoginFileInfoDefStr($str){
	$defstr='dg'.md5('e-c,m@s'.md5($str.'-p.h!o-m5e').'-e.m-p!i8re');
	return $defstr;
}

//�����û�������Ϣ
function hReturnAdminLoginFileInfo($userid,$username,$rnd,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval){
	global $ecms_config;
	$adminlogins='';
	$ernd=make_password(27);
	$erndtwo=make_password(20);
	$erndadd=make_password(32);
	$ehash=make_password(20);
	$ehashname=$ecms_config['esafe']['ckhashename'].make_password(5);
	$rhash=make_password(12);
	$rhashname=$ecms_config['esafe']['ckhashrname'].make_password(5);
	$userid=(int)$userid;
	$dbdata=(int)$dbdata;
	$defhash=$ehashname.'='.$ehash.'||'.$rhashname.'='.$rhash.'||'.$ernd.'||'.$erndtwo;
	$ernddefine=make_password(22);
	$ernddefinemd5=hAdminLoginFileInfoDefStr($ernddefine);
	$eckdiyvar='emec'.abc_make_password(8);
	$eckdiyval=make_password(18);
	define('EmpireCMSHDefHash',$defhash);
	$adminlogins.="<?php
define('EcmsAdminLogin','EmpireCMS');
define('EcmsAdminLoginDEF','".$ernddefinemd5."');
\$ecms_adminloginr=array();
\$ecms_adminloginr=Array('userid'=>'".$userid."',
'ernd'=>'".addslashes($ernd)."',
'erndtwo'=>'".addslashes($erndtwo)."',
'erndadd'=>'".addslashes($erndadd)."',
'ehash'=>'".addslashes($ehash)."',
'ehashname'=>'".addslashes($ehashname)."',
'rhash'=>'".addslashes($rhash)."',
'rhashname'=>'".addslashes($rhashname)."',
'eckdiyvar'=>'".addslashes($eckdiyvar)."',
'eckdiyval'=>'".addslashes($eckdiyval)."',
'edbdata'=>'".$dbdata."');
?>";
	esetcookie("loginecmsckfrnd",$ernd,0,1);
	esetcookie("loginecmsckfdef",$ernddefine,0,1);
	esetcookie($eckdiyvar,$eckdiyval,0,1);
	return $adminlogins;
}

//�ļ�����������֤
function hCheckAadminLoginFileInfo(){
	global $ecms_config,$ecms_adminloginr;
	if(!$ecms_adminloginr['ernd']||$ecms_adminloginr['ernd']<>getcvar('loginecmsckfrnd',1))
	{
		printerror("NotLogin","index.php");
	}
	if(!defined('EcmsAdminLogin'))
	{
		printerror("NotLogin","index.php");
	}
	if(!defined('EcmsAdminLoginDEF'))
	{
		printerror("NotLogin","index.php");
	}
	$ckstr=getcvar('loginecmsckfdef',1);
	if(EcmsAdminLoginDEF==''||EcmsAdminLoginDEF=='EcmsAdminLoginDEF'||!$ckstr)
	{
		printerror("NotLogin","index.php");
	}
	$ckdefstr=hAdminLoginFileInfoDefStr($ckstr);
	if(EcmsAdminLoginDEF<>$ckdefstr)
	{
		printerror("NotLogin","index.php");
	}
	$diyck=getcvar($ecms_adminloginr['eckdiyvar'],1);
	if(!$diyck||!$ecms_adminloginr['eckdiyval']||$ecms_adminloginr['eckdiyval']<>$diyck)
	{
		printerror("NotLogin","index.php");
	}
}

function DelECookieAdminLoginFileInfo(){
	global $ecms_config,$ecms_adminloginr;
	esetcookie("loginecmsckfrnd",'',0,1);
	esetcookie("loginecmsckfdef",'',0,1);
	esetcookie($ecms_adminloginr['eckdiyvar'],'',0,1);
}

//��ԴHash��֤
//��֤rhash����
function hCheckEcmsRHash(){
	global $ecms_config,$ecms_adminloginr;
	if($ecms_config['esafe']['ckhash']==2)//�ر�HASHģʽ
	{
		return '';
	}
	//���ģʽ
	$rhashvar=$ecms_adminloginr['rhashname'];
	$rhash=$ecms_adminloginr['rhash'];
	if($_GET[$rhashvar]&&$_GET[$rhashvar]==$rhash)
	{
	}
	elseif($_POST[$rhashvar]&&$_POST[$rhashvar]==$rhash)
	{
	}
	else
	{
		printerror("FailHash","history.go(-1)");
	}
	//spurl
	if($ecms_config['esafe']['ckfromurl']>3)
	{
		hCheckSpFromUrl();
	}
}

//��֤ehash����
function hCheckEcmsEHash(){
	global $ecms_config,$ecms_adminloginr;
	if($ecms_config['esafe']['ckhash']==2)//�ر�HASHģʽ
	{
		return '';
	}
	if($ecms_config['esafe']['ckhash']==1)//���ģʽ
	{
		return '';
	}
	//���ģʽ
	$ehashvar=$ecms_adminloginr['ehashname'];
	$ehash=$ecms_adminloginr['ehash'];
	if($_GET[$ehashvar]&&$_GET[$ehashvar]==$ehash)
	{
	}
	elseif($_POST[$ehashvar]&&$_POST[$ehashvar]==$ehash)
	{
	}
	else
	{
		printerror("FailHash","history.go(-1)");
	}
}

//���ehash����form
function hReturnEcmsHashStrAddRnd($ern=2){
	global $ecms_config,$ecms_adminloginr;
	$num=EcmsRandInt(1,$ern);
	$addrnd='';
	$rndstr=uniqid(microtime()).EcmsRandInt();
	for($i=1;$i<=$num;$i++)
	{
		$str=md5($rndstr.$i);
		if($i%2==0)
		{
			$rndname='rhash_'.substr($str,22,4);
			$rndvalue=substr($str,4,12);
		}
		else
		{
			$rndname='ehash_'.substr($str,25,4);
			$rndvalue=substr($str,2,20);
		}
		$addrnd.='<input type=hidden name='.$rndname.' value='.$rndvalue.'>';
	}
	return $addrnd;
}

//����hash����
function hReturnEcmsHashStrAll(){
	global $ecms_config,$ecms_adminloginr;
	//���ģʽ
	$rhashvar=$ecms_adminloginr['rhashname'];
	$rhash=$ecms_adminloginr['rhash'];
	//���ģʽ
	$ehashvar=$ecms_adminloginr['ehashname'];
	$ehash=$ecms_adminloginr['ehash'];
	//����
	if($ecms_config['esafe']['ckhash']==2)//�ر�HASHģʽ
	{
		$hashhrefr['href']='';
		$hashhrefr['whhref']='';
		$hashhrefr['form']='';
		$hashhrefr['ehref']='';
		$hashhrefr['whehref']='';
		$hashhrefr['eform']='';
	}
	elseif($ecms_config['esafe']['ckhash']==1)//���ģʽ
	{
		$hashhrefr['href']='&'.$rhashvar.'='.$rhash;
		$hashhrefr['whhref']='?'.$rhashvar.'='.$rhash;
		$hashhrefr['form']=hReturnEcmsHashStrAddRnd(2).'<input type=hidden name='.$rhashvar.' value='.$rhash.'>'.hReturnEcmsHashStrAddRnd(2);
		$hashhrefr['ehref']='';
		$hashhrefr['whehref']='';
		$hashhrefr['eform']='';
	}
	else//���ģʽ
	{
		$ehaddrnd=hReturnEcmsHashStrAddRnd();
		$ehaddrnd2=hReturnEcmsHashStrAddRnd(2);
		$ehaddrnd3=hReturnEcmsHashStrAddRnd(2);
		$hashhrefr['href']='&'.$ehashvar.'='.$ehash.'&'.$rhashvar.'='.$rhash;
		$hashhrefr['whhref']='?'.$ehashvar.'='.$ehash.'&'.$rhashvar.'='.$rhash;
		$hashhrefr['form']=$ehaddrnd.'<input type=hidden name='.$ehashvar.' value='.$ehash.'>'.$ehaddrnd2.'<input type=hidden name='.$rhashvar.' value='.$rhash.'>'.$ehaddrnd3;
		$hashhrefr['ehref']='&'.$ehashvar.'='.$ehash;
		$hashhrefr['whehref']='?'.$ehashvar.'='.$ehash;
		$hashhrefr['eform']=$ehaddrnd.'<input type=hidden name='.$ehashvar.' value='.$ehash.'>'.$ehaddrnd2;
	}
	return $hashhrefr;
}

//����hash����(href)
function hReturnEcmsHashStrHref($wh=0){
	$hashhrefr=hReturnEcmsHashStrAll();
	return $wh?$hashhrefr['whhref']:$hashhrefr['href'];
}

//����hash����(ehref)
function hReturnEcmsHashStrHref2($wh=0){
	$hashhrefr=hReturnEcmsHashStrAll();
	return $wh?$hashhrefr['whehref']:$hashhrefr['ehref'];
}

//����hash����(form)
function hReturnEcmsHashStrForm($wh=0){
	$hashhrefr=hReturnEcmsHashStrAll();
	return $hashhrefr['form'];
}

//����hash����(eform)
function hReturnEcmsHashStrForm2($wh=0){
	$hashhrefr=hReturnEcmsHashStrAll();
	return $hashhrefr['eform'];
}

//����hash����(def)
function hReturnEcmsHashStrDef($wh=0,$ecms='ehref'){
	if($ecms_config['esafe']['ckhash']==2)//�ر�HASHģʽ
	{
		return '';
	}
	$str='';
	$fh=$wh?'?':'&';
	$hr=explode('||',EmpireCMSHDefHash);
	if($ecms=='href')
	{
		if($ecms_config['esafe']['ckhash']==1)//���ģʽ
		{
			$str=$fh.$hr[1];
		}
		else
		{
			$str=$fh.$hr[0].'&'.$hr[1];
		}
	}
	elseif($ecms=='ehref')
	{
		$str=$fh.$hr[0];
	}
	return $str;
}

//����hash����(erndtwo)
function hReturnEcmsHashErndDef($ecms=0){
	$str='';
	$hr=explode('||',EmpireCMSHDefHash);
	if($ecms==0)
	{
		$str=$hr[2];
	}
	else
	{
		$str=$hr[3];
	}
	return $str;
}

//�ļ���֤����
function DoECreatFileRnd($userid,$username,$rnd,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval){
	global $ecms_config;
	$file=ECMS_PATH.'e/data/adminlogin/user'.$userid.'_'.md5(md5($username.'-empirecms!check.file'.$truelogintime.'-'.$rnd.$ecms_config['esafe']['ecookiernd']).'-'.$ip.'-'.$userid.'-'.$rnd.$adminstyle.'-'.$groupid.'-'.$dbdata.$sessval).'.php';
	$filetext=hReturnAdminLoginFileInfo($userid,$username,$rnd,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval);
	WriteFiletext_n($file,$filetext);
}

function DoECheckFileRnd($userid,$username,$rnd,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval){
	global $ecms_config,$ecms_adminloginr;
	$file=ECMS_PATH.'e/data/adminlogin/user'.$userid.'_'.md5(md5($username.'-empirecms!check.file'.$truelogintime.'-'.$rnd.$ecms_config['esafe']['ecookiernd']).'-'.$ip.'-'.$userid.'-'.$rnd.$adminstyle.'-'.$groupid.'-'.$dbdata.$sessval).'.php';
	if(!file_exists($file))
	{
		printerror('NotLogin','index.php');
	}
	include($file);
	hCheckAadminLoginFileInfo();
	/*
	$filetime=filemtime($file);
	if($filetime>$truelogintime)
	{
		printerror('NotLogin','index.php');
	}
	*/
}

//�л����ʶ˺�̨
function Moreport_eChangeMoreportAdmin($pid,$ecms,$douserid,$dousername){
	global $empire,$dbtbpre,$public_r,$ecms_config;
	CheckLevel($douserid,$dousername,$classid,"chmoreport");//����Ȩ��
	$pid=(int)$pid;
	if(!$pid)
	{
		printerror("EmptyMoreportPid","history.go(-1)");
	}
	$pr=$empire->fetch1("select * from {$dbtbpre}enewsmoreport where pid='$pid'");
	if(!$pr['pid']||!$pr['purl'])
	{
		printerror("EmptyMoreportPid","history.go(-1)");
	}
	if(!$pr['ppath']||!file_exists($pr['ppath'].'e/config/config.php'))
	{
		printerror("EmptyMoreportPid","history.go(-1)");
	}
	if($pr['isclose']||$pr['openadmin']==2)
	{
		printerror("ChangeMoreportIsClose","history.go(-1)");
	}
	if($pid==$ecms_config['sets']['selfmoreportid']||($pid==1&&!$ecms_config['sets']['selfmoreportid']))
	{
		printerror("IsSelfMoreportPid","history.go(-1)");
	}
	//�ļ���
	$userid=intval(getcvar('loginuserid',1));
	$username=RepPostVar(getcvar('loginusername',1));
	$rnd=RepPostVar(getcvar('loginrnd',1));
	$dbdata=getcvar('ecmsdodbdata',1)?1:0;
	$groupid=(int)getcvar('loginlevel',1);
	$adminstyle=(int)getcvar('loginadminstyleid',1);
	$truelogintime=(int)getcvar('truelogintime',1);
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$otherinfo=DoECkOtherInfo();
	$sessval=ReESessionRnd();
	$userloginfile='user'.$userid.'_'.md5(md5($username.'-empirecms!check.file'.$truelogintime.'-'.$rnd.$ecms_config['esafe']['ecookiernd']).'-'.$ip.'-'.$userid.'-'.$rnd.$adminstyle.'-'.$groupid.'-'.$dbdata.$sessval).'.php';
	$fromfile=ECMS_PATH.'e/data/adminlogin/'.$userloginfile;
	$tofile=$pr['ppath'].'e/data/adminlogin/'.$userloginfile;
	if(!file_exists($fromfile))
	{
		printerror("EmptyMoreportPid","history.go(-1)");
	}
	@copy($fromfile,$tofile);
	if(!file_exists($tofile))
	{
		printerror("MoreportPidFailPath","history.go(-1)");
	}
	if($ecms==0)
	{
		DelFiletext($fromfile);
	}
	$selfurl=eReturnSelfPage(0);
	$gourl=substr($pr['purl'],0,-1).str_replace('/enews.php','/admin.php',$selfurl).hReturnEcmsHashStrHref2(1);
	printerror("ChangeMoreportAdminSuccess",$gourl);
}

function DoEDelFileRnd($userid){
	$path=ECMS_PATH.'e/data/adminlogin/';
	$hand=@opendir($path);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..')
		{
			continue;
		}
		if(stristr($file,'user'.$userid.'_'))
		{
			DelFiletext($path.$file);
		}
	}
}

//��������֤
function DoECreatAndAuthRnd($userid,$username,$rnd,$userkey,$dbdata,$groupid,$adminstyle,$truelogintime,$ip,$sessval){
	global $empire,$dbtbpre,$ecms_config;
	$andauth=md5(md5($rnd.'-'.$username.'-empirecms!check.andauth'.$truelogintime.'-'.$ecms_config['esafe']['ecookiernd'].$userkey).$sessval.'-'.$ip.'-'.$userid.$rnd.'-'.$adminstyle.'-'.$groupid.$username.'-'.$dbdata);
	DoEDelAndAuthRnd($userid);
	$empire->query("replace into {$dbtbpre}enewsuserloginck(userid,andauth) values('$userid','$andauth');");
}

function DoECheckAndAuthRnd($userid,$username,$rnd,$userkey,$dbdata,$groupid,$adminstyle,$truelogintime){
	global $empire,$dbtbpre,$ecms_config;
	$anduser_r=$empire->fetch1("select andauth from {$dbtbpre}enewsuserloginck where userid='$userid'");
	if(!$anduser_r['andauth'])
	{
		printerror('NotLogin','index.php');
	}	
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	//$otherinfo=DoECkOtherInfo();
	$sessval=ReESessionRnd();
	$ckandauth=md5(md5($rnd.'-'.$username.'-empirecms!check.andauth'.$truelogintime.'-'.$ecms_config['esafe']['ecookiernd'].$userkey).$sessval.'-'.$ip.'-'.$userid.$rnd.'-'.$adminstyle.'-'.$groupid.$username.'-'.$dbdata);
	if('dg'.$anduser_r['andauth']<>'dg'.$ckandauth)
	{
		printerror('NotLogin','index.php');
	}
}

function DoEDelAndAuthRnd($userid){
	global $empire,$dbtbpre;
	$empire->query("delete from {$dbtbpre}enewsuserloginck where userid='$userid'");
}

//д�������־
function insert_dolog($doing,$pubid=0){
	global $empire,$enews,$phome,$logininid,$loginin,$ecms_config,$dbtbpre;
	if($ecms_config['esafe']['thedolog'])
	{
		return "";
	}
	if(empty($doing))
	{$doing="---";}
	$doing=str_replace('<br>','[e.cms.br]',$doing);
	$doing=eDoRepPostComStr($doing);
	$doing=str_replace('[e.cms.br]','<br>',$doing);
	$doing=addslashes(stripSlashes($doing));
	//ip
	$logip=egetip();
	$ipport=egetipport();
	$logtime=date("Y-m-d H:i:s");
	if(empty($enews))
	{$enews=$phome;}
	$enews=RepPostVar($enews);
	$pubid=RepPostVar($pubid);
	$loginin=RepPostVar($loginin);
	$sql=$empire->query("insert into {$dbtbpre}enewsdolog(username,logip,logtime,enews,doing,pubid,ipport) values('$loginin','$logip','$logtime','$enews','$doing','$pubid','$ipport');");
}

//���ذ�ȫ��������
function ReturnHLoginQuestionStr($userid,$username,$question,$answer){
	$pass=md5(md5('-#20empire27#-'.$question.'-empirecms-'.$userid.'-www.phome.net-'.$answer.'-wm-').'-dg2002-'.$answer.'-wm_chief-'.$userid.'-wangmeng-');
	return $pass;
}


//-------------- Զ�̷����� ----------------------

//����FTPĿ¼���ļ����Ե�ַ
function FtpRTruePath($ftppath,$path){
	$truepath=$ftppath.'/'.$path;
	return $truepath;
}

//Ŀ¼ת��
function FtpChPath($e,$r){
	$path=$r[ftppath].'/e/ftp';
	$e->fChdir($path);
	return '';
}

//�ϴ�ftpĿ¼
function FtpTranPath($ftpid,$ldir,$hdir){
	$r=ReturnFtpInfo($ftpid);
	$e=new EmpireCMSFTP();
	$e->fconnect($r[ftphost],$r[ftpport],$r[ftpusername],$r[ftppassword],$r[ftppath],$r[ftpssl],$r[ftppasv],$r[ftpmode],$r[ftpouttime]);
	FtpChPath($e,$r);
    //�ϴ�Ŀ¼
    $e->ftp_copy($ldir,$hdir);
    $e->fExit();
}

//ɾ��ftpĿ¼
function FtpDelPath($ftpid,$dir){
	$r=ReturnFtpInfo($ftpid);
	$e=new EmpireCMSFTP();
	$e->fconnect($r[ftphost],$r[ftpport],$r[ftpusername],$r[ftppassword],$r[ftppath],$r[ftpssl],$r[ftppasv],$r[ftpmode],$r[ftpouttime]);
	FtpChPath($e,$r);
    //ɾ��Ŀ¼
    $e->ftp_rmAll($dir);
    $e->fExit();
}

//ɾ��ftp�ļ�
function FtpDelFile($ftpid,$fr){
	$r=ReturnFtpInfo($ftpid);
    $e=new EmpireCMSFTP();
	$e->fconnect($r[ftphost],$r[ftpport],$r[ftpusername],$r[ftppassword],$r[ftppath],$r[ftpssl],$r[ftppasv],$r[ftpmode],$r[ftpouttime]);
	FtpChPath($e,$r);
    //ɾ���ļ�
	$e->fMoreDelFile($fr);
    $e->fExit();
}

//�ϴ��ļ�
function FtpTranFile($ftpid,$fr,$fr1){
	$r=ReturnFtpInfo($ftpid);
    $e=new EmpireCMSFTP();
	$e->fconnect($r[ftphost],$r[ftpport],$r[ftpusername],$r[ftppassword],$r[ftppath],$r[ftpssl],$r[ftppasv],$r[ftpmode],$r[ftpouttime]);
	FtpChPath($e,$r);
    //�ϴ��ļ�
	$e->fMoreTranFile($fr1,$fr);
    $e->fExit();
}

//����ftpĿ¼
function FtpMkdir($ftpid,$pr,$mod){
	$r=ReturnFtpInfo($ftpid);
	$e=new EmpireCMSFTP();
	$e->fconnect($r[ftphost],$r[ftpport],$r[ftpusername],$r[ftppassword],$r[ftppath],$r[ftpssl],$r[ftppasv],$r[ftpmode],$r[ftpouttime]);
	FtpChPath($e,$r);
	for($i=0;$i<count($pr);$i++)
	{
		if(stristr($pr[$i],ECMS_PATH))
		{
			$pr[$i]=FtpRTruePath($r[ftppath],str_replace(ECMS_PATH,'',$pr[$i]));
		}
		if(!$e->fChdir($pr[$i]))
		{
			$e->fMkdir($pr[$i]);
			if($mod)
			{
				$e->fChmoddir($mod,$pr[$i]);
			}
		}
	}
    $e->fExit();
}

//����ftp��Ϣ
function ReturnFtpInfo($ftpid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewspublic limit 1");
	return $r;
}

//��ʹ����������
function AddPostUrlData($postdata,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	$count=count($postdata);
	if(empty($count))
	{printerror("NotPostData","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"postdata");
	$e="!!!";
	$rnd=md5(uniqid(microtime()).EcmsRandInt());
	for($i=0;$i<$count;$i++)
	{
		$r=explode($e,$postdata[$i]);
		$r[1]=(int)$r[1];
		$r[0]=AddAddsData($r[0]);
		$sql=$empire->query("insert into {$dbtbpre}enewspostdata(rnd,postdata,ispath) values('$rnd','$r[0]','$r[1]');");
    }
	$line=(int)$_POST['line'];
	if($line==0)
	{
		$line=10;
	}
	echo $fun_r[AddPostDataSuccess]."<script>self.location.href='enews.php?enews=PostUrlData&start=0&line=$line&rnd=$rnd".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//Զ�̷���
function PostUrlData($start,$rnd,$userid,$username){
	global $empire,$fun_r,$dbtbpre,$incftp;
	$rnd=RepPostVar($rnd);
	if(empty($rnd))
	{printerror("FailCX","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"postdata");
	//����FTP
	if(empty($incftp))
	{
		@include(ECMS_PATH."e/class/ftp.php");
	}
	$pr=ReturnFtpInfo($ftpid);
	$e=new EmpireCMSFTP();
	$e->fconnect($pr[ftphost],$pr[ftpport],$pr[ftpusername],$pr[ftppassword],$pr[ftppath],$pr[ftpssl],$pr[ftppasv],$pr[ftpmode],$pr[ftpouttime]);
	FtpChPath($e,$pr);

	$line=(int)$_GET['line'];//ÿ10��Ϊһ��
	$start=(int)$start;
	$b=0;
	$sql=$empire->query("select postid,postdata,ispath from {$dbtbpre}enewspostdata where rnd='$rnd' and postid>$start order by postid limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[postid];
		//�ļ�
		if($r[ispath])
		{
			$fr=explode(",",$r[postdata]);
			for($i=0;$i<count($fr);$i++)
			{
				$e->fTranFile(FtpRTruePath($pr[ftppath],$fr[$i]),ECMS_PATH.$fr[$i]);
			}
		}
		//Ŀ¼
		else
		{
			$e->ftp_copy(ECMS_PATH.$r[postdata],FtpRTruePath($pr[ftppath],$r[postdata]));
		}
	}
	$e->fExit();
	if(empty($b))
	{
		$sql=$empire->query("delete from {$dbtbpre}enewspostdata where rnd='$rnd'");
		//������־
		insert_dolog("");
		printerror("PostDataSuccess","PostUrlData.php".hReturnEcmsHashStrHref2(1));
	}
	echo $fun_r[OnePostDataSuccess]."<script>self.location.href='enews.php?enews=PostUrlData&start=$newstart&line=$line&rnd=$rnd".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//����FTP
function CheckFtpConnect($ftphost,$ftpport,$ftpusername,$ftppassword,$ftppath,$ftpssl=0,$pasv=0,$tranmode=0,$timeout=0){
	if(!defined('InEmpireCMSFtp'))
	{
		include(ECMS_PATH.'e/class/ftp.php');
	}
	$eftp=new EmpireCMSFTP();
	$result=$eftp->fconnect($ftphost,$ftpport,$ftpusername,$ftppassword,$ftppath,$ftpssl,$pasv,$tranmode,$timeout,1);
	if($result=='HostFail')
	{
		printerror('FtpHostFail','',8);
	}
	elseif($result=='UserFail')
	{
		printerror('FtpUserFail','',8);
	}
	elseif($result=='PathFail')
	{
		printerror('FtpPathFail','',8);
	}
	else
	{
		printerror('FtpConnectSuccess','',8);
	}
	$eftp->fExit();
}


//-------------- ģ���� ----------------------

//���Ʊ�
function CopyEcmsTb($otb,$tb){
	global $empire;
	$usql=$empire->query("SET SQL_QUOTE_SHOW_CREATE=1;");//��������
	$r=$empire->fetch1("SHOW CREATE TABLE `$otb`;");//���ݱ�ṹ
	$create=str_replace("\"","\\\"",$r[1]);
	$create=str_replace($otb,$tb,$create);
	$empire->query($create);
}

//�������ݱ�
function SetCreateTable($sql,$dbcharset) {
	global $ecms_config;
	$type=strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
		($ecms_config['db']['dbver']>='4.1'&&$dbcharset ? " ENGINE=$type DEFAULT CHARSET=$dbcharset" : " TYPE=$type");
}

//��ϴ��ı�
function TogSaveTxtF($ecms=0){
	global $empire,$dbtbpre;
	$savesql=$empire->query("select f,tbname from {$dbtbpre}enewsf where savetxt=1");
	$savef=',';
	while($saver=$empire->fetch($savesql))
	{
		$savef.=$saver[tbname].'.'.$saver[f].',';
	}
	$empire->query("update {$dbtbpre}enewspublic set savetxtf='$savef' limit 1");
	if($ecms==0)
	{
		GetConfig();
	}
}

//���ظ����ֶ�
function ReturnMFileF($enter,$tbname,$tid,$fform="file"){
	global $empire;
	$record="<!--record-->";
	$field="<!--field--->";
	if($tid)
	{
		$a=" and tid='$tid'";
	}
	$f=",";
	$sql=$empire->query("select f from ".$tbname." where fform='$fform'".$a);
	while($r=$empire->fetch($sql))
	{
		if(strstr($enter,$field.$r[f].$record))
		{
			$f.=$r[f].",";
		}
	}
	return $f;
}

//ִ���ֶκ���
function DoFFun($mid,$f,$value,$isadd=1,$isq=0){
	global $empire,$dbtbpre,$emod_r;
	if($isq==1)//ǰ̨
	{
		$dofun=$isadd==1?$emod_r[$mid]['qadddofunf']:$emod_r[$mid]['qeditdofunf'];
	}
	else//��̨
	{
		$dofun=$isadd==1?$emod_r[$mid]['adddofunf']:$emod_r[$mid]['editdofunf'];
	}
	if(!strstr($dofun,'||'.$f.'!#!'))
	{
		return $value;
	}
	$dfr=explode('||'.$f.'!#!',$dofun);
	$dfr1=explode('||',$dfr[1]);
	$r=explode('##',$dfr1[0]);
	if($r[0])
	{
		$fun=$r[0];
		$value=$fun($mid,$f,$isadd,$isq,$value,$r[1]);
	}
	return $value;
}

//ִ��ģ�ͺ���
function DoMFun($mid,$classid,$id,$isadd=1,$isq=0){
	global $empire,$dbtbpre,$emod_r;
	if($isq==1)//ǰ̨
	{
		if($isadd==1)//����
		{
			$dofun=$emod_r[$mid]['qmaddfun'];
		}
		else//�޸�
		{
			$dofun=$emod_r[$mid]['qmeditfun'];
		}
	}
	else//��̨
	{
		if($isadd==1)//����
		{
			$dofun=$emod_r[$mid]['maddfun'];
		}
		else//�޸�
		{
			$dofun=$emod_r[$mid]['meditfun'];
		}
	}
	if(!$dofun)
	{
		return '';
	}
	$r=explode('##',$dofun);
	if(!$r[0])
	{
		return '';
	}
	$fun=$r[0];
	$value=$fun($mid,$isadd,$isq,$classid,$id,$r[1]);
}

//ȡ���ֶ���
function ChGetFname($mid,$f){
	global $empire,$dbtbpre,$emod_r;
	$r=$empire->fetch1("select fname from {$dbtbpre}enewsf where f='$f' and tid='".$emod_r[$mid]['tid']."' limit 1");
	return $r[fname]?$r[fname]:$f;
}

//��֤������
function ChMustAddF($mid,$f,$value){
	global $empire,$dbtbpre,$emod_r;
	if(strstr($emod_r[$mid]['mustqenterf'],','.$f.','))
	{
		if(!trim($value))
		{
			$GLOBALS['msgmustf']=ChGetFname($mid,$f);
			printerror("EmptyMustF","history.go(-1)");
		}
	}
}

//��֤Ψһ��
function ChIsOnlyAddF($mid,$id,$f,$value,$isq=0){
	global $empire,$dbtbpre,$emod_r;
	$mid=(int)$mid;
	if(strstr($emod_r[$mid]['onlyf'],','.$f.','))
	{
		$id=(int)$id;
		$and='';
		if($id)
		{
			$and=" and id<>$id";
		}
		$value=RepPostStr($value);
		//�����
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$emod_r[$mid]['tbname']." where ".$f."='".addslashes($value)."'".$and." limit 1");
		//δ���
		if(empty($num))
		{
			$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$emod_r[$mid]['tbname']."_check where ".$f."='".addslashes($value)."'".$and." limit 1");
		}
		if($num)
		{
			$GLOBALS['msgisonlyf']=ChGetFname($mid,$f);
			if($isq==1)
			{
				printerror("ReIsOnlyF","history.go(-1)",1);
			}
			else
			{
				printerror("ReIsOnlyF","history.go(-1)");
			}
		}
	}
}

//����ͬ��
function SameDataAddF($id,$classid,$mid,$f,$value){
	global $empire,$public_r,$dbtbpre,$emod_r,$emod_pubr;
	if(strstr($emod_pubr['linkfields'],','.$emod_r[$mid]['tbname'].'.'.$f.'|'))
	{
		$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$emod_r[$mid]['tbname']."_index where id='$id' limit 1");
		//���ر�
		$infotb=empty($index_r['checked'])?$dbtbpre.'ecms_'.$emod_r[$mid]['tbname'].'_check':$dbtbpre.'ecms_'.$emod_r[$mid]['tbname'];
		$value=addslashes($value);
		$r=$empire->fetch1("select ".$f." from ".$infotb." where id='$id' limit 1");
		if($r[$f]<>$value)
		{
			$tbr=ReturnSameDataTb($emod_r[$mid]['tbname'],$f);
			$ltbname=$tbr[0];
			$lf=$tbr[1];
			if($ltbname&&$lf)
			{
				$empire->query("update {$dbtbpre}ecms_".$ltbname." set ".$lf."='$value' where ".$lf."='$r[$f]'");
			}
		}
	}
}

//��������ͬ�������ֶ���
function ReturnSameDataTb($tbname,$f){
	global $public_r,$emod_pubr;
	$expr=explode(','.$tbname.'.'.$f.'|',$emod_pubr['linkfields']);
	$expr1=explode('|',$expr[0]);
	$count=count($expr1)-1;
	$tbr=explode('.',$expr1[$count]);
	return $tbr;
}

//�Զ����ֶη���ģ���ֶδ���
function doReturnAddTempf($temp){
	$record="<!--record-->";
	$field="<!--field--->";
	$r=explode($record,$temp);
	$count=count($r);
	$str=',';
	for($i=0;$i<$count-1;$i++)
	{
		$r1=explode($field,$r[$i]);
		$str.=$r1[1].",";
	}
	if($str==',,')
	{
		$str=',';
	}
	return $str;
}

//�����ֵ�ֶ�
function DoFieldMoreValue($f,$add,$ecms=0){
	$rvarname=$f.'_1';
	$count=count($add[$rvarname]);
	if(empty($count))
	{
		return '';
	}
	//����
	$mvnumvar='mvnum_'.$f;
	$mvmustvar='mvmust_'.$f;
	$mvidvarname=$f.'_mvid';
	$mvid=$add[$mvidvarname];
	$mvdelidvarname=$f.'_mvdelid';
	$mvdelid=$add[$mvdelidvarname];
	//����
	$mvnum=(int)$add[$mvnumvar];
	if($mvnum<1||$mvnum>50)
	{
		$mvnum=1;
	}
	$mvmust=(int)$add[$mvmustvar];
	if($mvmust<1)
	{
		$mvmust=0;
	}
	if($ecms==1)
	{
		$delcount=count($mvdelid);
	}
	$rexp='||||||';
	$fexp='::::::';
	$rstr='';
	$rstrexp='';
	for($i=0;$i<$count;$i++)
	{
		//ɾ��
		if($ecms==1)
		{
			$del=0;
			for($d=0;$d<$delcount;$d++)
			{
				if($mvdelid[$d]==$mvid[$i])
				{
					$del=1;
					break;
				}
			}
			if($del)
			{continue;}
		}
		$fstr='';
		$fstrexp='';
		$fstrempty=0;
		for($j=0;$j<$mvnum;$j++)
		{
			$k=$j+1;
			$fsvarname=$f.'_'.$k;
			$fsval=$add[$fsvarname][$i];
			$fsval=str_replace($rexp,'',$fsval);
			$fsval=str_replace($fexp,'',$fsval);
			if(CheckValEmpty($fsval))
			{
				if($k==$mvmust)
				{
					break;
					$fstrempty=1;
				}
			}
			$fstr.=$fstrexp.$fsval;
			$fstrexp=$fexp;
		}
		if(empty($fstr)||$fstrempty)
		{
			continue;
		}
		$rstr.=$rstrexp.$fstr;
		$rstrexp=$rexp;
	}
	return $rstr;
}

//���ض�ֵ�ֶ�����
function ReturnMoreValueAddF($add,$r,$mid,$f,$ecms=0){
	global $public_r,$emod_r;
	$val=$r;
	if(strstr($emod_r[$mid]['morevaluef'],'|'.$f.','))
	{
		$varname=$f.'_1';
		if(is_array($add[$varname]))
		{
			$val=DoFieldMoreValue($f,$add,$ecms);
		}
		else
		{
			$val='';
		}
	}
	return $val;
}

//��ϸ�ѡ������
function ReturnCheckboxAddF($r,$mid,$f){
	global $public_r,$emod_r;
	$val=$r;
	if(is_array($r)&&strstr($emod_r[$mid]['checkboxf'],','.$f.','))
	{
		$val='';
		$count=count($r);
		for($i=0;$i<$count;$i++)
		{
			$val.=$r[$i].'|';
		}
		if($val)
		{
			$val='|'.$val;
		}
	}
	return $val;
}

//��Ϣ�ֶ�ֵ����
function DohFieldValue($mid,$f,$val,$gr){
	global $public_r,$emod_r,$lur;
	$val=RepPhpAspJspcodeText($val);
	if($gr['docanhtml'])
	{
		return $val;
	}
	if(strstr($emod_r[$mid]['editorf'],','.$f.','))//�༭��
	{
		$val=ClearNewsBadCode($val);
	}
	else
	{
		$val=eDoRepPostComStr($val,1);//�滻html
	}
	return $val;
}

//�����Զ����ֶ�
function ReturnAddF($add,$modid,$userid,$username,$do=0,$rdata=0,$ch=0){
	global $empire,$public_r,$dbtbpre,$emod_r,$lur;
	$ugroupid=(int)$lur['groupid'];
	$ugr=ReturnLeftLevel($ugroupid);
	if($do==0||$do==1)
	{
		//����gd�����ļ�
		if($add['mark']||$add['getfirsttitlespic']||$add['mcreatespic'])
		{
			include_once(ECMS_PATH.'e/class/gd.php');
		}
	}
	$ret_r['tb']=$emod_r[$modid]['deftb'];
	$pagef=$emod_r[$modid]['pagef'];
	$r=explode(',',$emod_r[$modid][enter]);
	$count=count($r)-1;
	if(empty($do))//����
	{
		//���ݿ����
		for($i=1;$i<$count;$i++)
		{
			$f=$r[$i];
			if($f=='special.field'||!strstr($emod_r[$modid]['canaddf'],','.$f.','))
			{
				continue;
			}
			$add[$f]=ReturnCheckboxAddF($add[$f],$modid,$f);//��ѡ��
			$add[$f]=ReturnMoreValueAddF($add,$add[$f],$modid,$f,$do);//��ֵ
			$value=RepPhpAspJspcodeText($add[$f]);
			if($f=='newstime')//ʱ��
			{
				$value=empty($value)?time():to_time($value);
			}
			elseif($f=="morepic")//ͼƬ��
			{
				$value=ReturnMorepicpath($add['msmallpic'],$add['mbigpic'],$add['mpicname'],$add['mdelpicid'],$add['mpicid'],$add,$add['mpicurl_qz'],0,0,$public_r['filedeftb']);
			}
			elseif($f=="downpath")//���ص�ַ
			{
				$value=ReturnDownpath($add['downname'],$add['downpath'],$add['delpathid'],$add['pathid'],$add['downuser'],$add['fen'],$add['thedownqz'],$add,$add['foruser'],$add['downurl_qz'],0);
			}
			elseif($f=="onlinepath")//���ߵ�ַ
			{
				$value=ReturnDownpath($add['odownname'],$add['odownpath'],$add['odelpathid'],$add['opathid'],$add['odownuser'],$add['ofen'],$add['othedownqz'],$add,$add['oforuser'],$add['onlineurl_qz'],0);
			}
			elseif($f=="smalltext")//���
			{
				if(!trim($value))
				{
					$value=SubSmalltextVal($add[newstext],$public_r[smalltextlen]);//��ȡ��������
				}
			}
			elseif($f=='infoip')//ip
			{
				$value=egetip();
			}
			elseif($f=='infoipport')//ip�˿�
			{
				$value=egetipport();
			}
			elseif($f=='infozm')//��ĸ
			{
				$value=$value?$value:GetInfoZm($add[title]);
			}
			$value=eDoInfoTbfToQj($emod_r[$modid]['tbname'],$f,$value,$public_r['toqjf']);
			//������
			$value=DoFFun($modid,$f,$value,1,0);
			$modispagef=$pagef==$f?1:0;
			$value=RepTempvarPostStrT($value,$modispagef);
			if($pagef!=$f)
			{
				$value=RepTempvarPostStr($value);
			}
			//�������ֶ�
			if($ch==1&&empty($add['titleurl']))
			{
				ChMustAddF($modid,$f,$value);
				ChIsOnlyAddF($modid,0,$f,$value,0);//Ψһֵ
			}
			$value=DohFieldValue($modid,$f,$value,$ugr);
			$value=hRepPostStr2($value);
			//�༭��
			if($f=="newstext")
			{
				//Զ�̱���
				$value=addslashes(CopyImg(stripSlashes($value),$add[copyimg],$add[copyflash],$add[classid],$add[qz_url],$username,$add['id'],$add['filepass'],$add['mark'],$public_r['filedeftb']));
				//�滻�ؼ��ֺ��ַ�
				$value=DoReplaceKeyAndWord($value,$add['dokey'],$add['classid']);
				//�Զ���ҳ
				if($add[autopage]&&!strstr($value,"[!--empirenews.page--]"))
				{
					if(empty($add[autosize]))
					{$add[autosize]=5000;}
					$value=AutoDoPage($value,$add[autosize]);
				}
			}
			//���ı�
			if($emod_r[$modid]['savetxtf']&&$f==$emod_r[$modid]['savetxtf'])
			{
				//����Ŀ¼
				$thetxtfile=GetFileMd5();
				$truevalue=MkDirTxtFile(date("Y/md"),$thetxtfile);
				//д���ļ�
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			if(strstr($emod_r[$modid]['tbdataf'],','.$f.','))//����
			{
				$ret_r['datafields'].=",".$f;
				$ret_r['datavalues'].=",'".addslashes($value)."'";
			}
			else//����
			{
				$ret_r['fields'].=",".$f;
				$ret_r['values'].=",'".addslashes($value)."'";
			}
		}
	}
	elseif($do==1)//�޸�
	{
		//���ݿ����
		for($i=1;$i<$count;$i++)
		{
			$f=$r[$i];
			if($f=="special.field"||!strstr($emod_r[$modid]['caneditf'],','.$f.','))
			{
				continue;
			}
			$add[$f]=ReturnCheckboxAddF($add[$f],$modid,$f);//��ѡ��
			$add[$f]=ReturnMoreValueAddF($add,$add[$f],$modid,$f,$do);//��ֵ
			$value=RepPhpAspJspcodeText($add[$f]);
			if($f=='newstime')//ʱ��
			{
				$value=empty($value)?time():to_time($value);
			}
			elseif($f=="morepic")//ͼƬ��
			{
				$value=ReturnMorepicpath($add['msmallpic'],$add['mbigpic'],$add['mpicname'],$add['mdelpicid'],$add['mpicid'],$add,$add['mpicurl_qz'],1,0,intval($add['fstb']));
			}
			elseif($f=="downpath")//���ص�ַ
			{
				$value=ReturnDownpath($add['downname'],$add['downpath'],$add['delpathid'],$add['pathid'],$add['downuser'],$add['fen'],$add['thedownqz'],$add,$add['foruser'],$add['downurl_qz'],1);
			}
			elseif($f=="onlinepath")//���ߵ�ַ
			{
				$value=ReturnDownpath($add['odownname'],$add['odownpath'],$add['odelpathid'],$add['opathid'],$add['odownuser'],$add['ofen'],$add['othedownqz'],$add,$add['oforuser'],$add['onlineurl_qz'],1);
			}
			elseif($f=="smalltext")//���
			{
				if(!trim($value))
				{
					$value=SubSmalltextVal($add[newstext],$public_r[smalltextlen]);//��ȡ��������
				}
			}
			elseif($f=='infozm')//��ĸ
			{
				$value=$value?$value:GetInfoZm($add[title]);
			}
			$value=eDoInfoTbfToQj($emod_r[$modid]['tbname'],$f,$value,$public_r['toqjf']);
			//������
			$value=DoFFun($modid,$f,$value,0,0);
			$modispagef=$pagef==$f?1:0;
			$value=RepTempvarPostStrT($value,$modispagef);
			if($pagef!=$f)
			{
				$value=RepTempvarPostStr($value);
			}
			//�������ֶ�
			if($ch==1&&empty($add['titleurl']))
			{
				ChMustAddF($modid,$f,$value);
				ChIsOnlyAddF($modid,$add[id],$f,$value,0);//Ψһֵ
			}
			$value=DohFieldValue($modid,$f,$value,$ugr);
			$value=hRepPostStr2($value);
			//����ͬ��
			SameDataAddF($add[id],$add[classid],$modid,$f,$value);
			//����
			if($f=="newstext")
			{
				//Զ�̱���
				$value=addslashes(CopyImg(stripSlashes($value),$add[copyimg],$add[copyflash],$add[classid],$add[qz_url],$username,$add['id'],$add['filepass'],$add['mark'],intval($add['fstb'])));
				//�Զ���ҳ
				if($add[autopage]&&!strstr($value,"[!--empirenews.page--]"))
				{
					if(empty($add[autosize]))
					{$add[autosize]=5000;}
					$value=AutoDoPage($value,$add[autosize]);
				}
			}
			//���ı�
			if($emod_r[$modid]['savetxtf']&&$f==$emod_r[$modid]['savetxtf'])
			{
				//����Ŀ¼
				$newstexttxt_r=explode("/",$add[newstext_url]);
				$thetxtfile=$newstexttxt_r[2];
				eCheckStrType(1,$newstexttxt_r[0],1);
				eCheckStrType(1,$newstexttxt_r[1],1);
				eCheckStrType(3,$thetxtfile,1);
				$truevalue=MkDirTxtFile($newstexttxt_r[0]."/".$newstexttxt_r[1],$thetxtfile);
				//д���ļ�
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			if(strstr($emod_r[$modid]['tbdataf'],','.$f.','))//����
			{
				$ret_r['datafields'].=",".$f;
				$ret_r['datavalues'].=",".$f."='".addslashes($value)."'";
			}
			else//����
			{
				$ret_r['fields'].=",".$f;
				$ret_r['values'].=",".$f."='".addslashes($value)."'";
			}
		}
	}
	elseif($do==8)//ͬ���޸�
	{
		//���ݿ����
		for($i=1;$i<$count;$i++)
		{
			$f=$r[$i];
			if($f=='special.field')
			{
				continue;
			}
			$value=$add[$f];
			//���ı�
			if($emod_r[$modid]['savetxtf']&&$f==$emod_r[$modid]['savetxtf'])
			{
				//����Ŀ¼
				$newstexttxt_r=explode("/",$add[newstext_url]);
				$thetxtfile=$newstexttxt_r[2];
				eCheckStrType(1,$newstexttxt_r[0],1);
				eCheckStrType(1,$newstexttxt_r[1],1);
				eCheckStrType(3,$thetxtfile,1);
				$truevalue=MkDirTxtFile($newstexttxt_r[0]."/".$newstexttxt_r[1],$thetxtfile);
				//д���ļ�
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			if(strstr($emod_r[$modid]['tbdataf'],','.$f.','))//����
			{
				$ret_r['datafields'].=",".$f;
				$ret_r['datavalues'].=",".$f."='".StripAddsData($value)."'";
			}
			else//����
			{
				$ret_r['fields'].=",".$f;
				$ret_r['values'].=",".$f."='".StripAddsData($value)."'";
			}
		}
	}
	elseif($do==9)//����
	{
		//���ݿ����
		for($i=1;$i<$count;$i++)
		{
			$f=$r[$i];
			if($f=='special.field')
			{
				continue;
			}
			$value=$add[$f];
			//���ı�
			if($emod_r[$modid]['savetxtf']&&$f==$emod_r[$modid]['savetxtf'])
			{
				//����Ŀ¼
				$thetxtfile=GetFileMd5();
				$truevalue=MkDirTxtFile(date("Y/md"),$thetxtfile);
				//д���ļ�
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			if(strstr($emod_r[$modid]['tbdataf'],','.$f.','))//����
			{
				$ret_r['datafields'].=",".$f;
				$ret_r['datavalues'].=",'".StripAddsData($value)."'";
			}
			else//����
			{
				$ret_r['fields'].=",".$f;
				$ret_r['values'].=",'".StripAddsData($value)."'";
			}
		}
	}
	elseif($do==10)//�鵵
	{
		//���ݿ����
		for($i=1;$i<$count;$i++)
		{
			$f=$r[$i];
			if($f=='special.field')
			{
				continue;
			}
			$value=$add[$f];
			if(strstr($emod_r[$modid]['tbdataf'],','.$f.','))//����
			{
				$ret_r['datafields'].=",".$f;
				$ret_r['datavalues'].=",'".StripAddsData($value)."'";
			}
			else//����
			{
				$ret_r['fields'].=",".$f;
				$ret_r['values'].=",'".StripAddsData($value)."'";
			}
		}
	}
	return $ret_r;
}

//���زɼ��ֶ�
function ReturnAddCj($add,$cj,$do=0){
	global $empire;
	$record="<!--record-->";
	$field="<!--field--->";
	$record_r=explode($record,$cj);
	for($i=0;$i<count($record_r)-1;$i++)
	{
		$field_r=explode($field,$record_r[$i]);
		//����
		if(empty($do))
		{
			$f1="zz_".$field_r[1];
			$f2="z_".$field_r[1];
			$f3="qz_".$field_r[1];
			$f4="save_".$field_r[1];
			$ret_r[0].=",".$f1.",".$f2.",".$f3.",".$f4;
			$ret_r[1].=",'".eaddslashes2($add[$f1])."','".eaddslashes2($add[$f2])."','".eaddslashes2($add[$f3])."','".$add[$f4]."'";
	    }
		//�޸�
		else
		{
			$f1="zz_".$field_r[1];
			$f2="z_".$field_r[1];
			$f3="qz_".$field_r[1];
			$f4="save_".$field_r[1];
			$ret_r[0].=",".$f1."='".eaddslashes2($add[$f1])."',".$f2."='".eaddslashes2($add[$f2])."',".$f3."='".eaddslashes2($add[$f3])."',".$f4."='".$add[$f4]."'";
	    }
    }
	return $ret_r;
}

//ͼƬ���ϴ�ͼƬ
function SaveMorepicFile($varname,$msavepic,$i,$picurl,$picname,$classid,$id,$add,$modtype=0,$fstb=1){
	global $public_r,$empire,$loginin,$dbtbpre,$ecms_config;
	if($varname=="mbigpfile")
	{
		$addname="[b]";
	}
	$type=1;
	$r[url]=$picurl;
	//�ϴ�
	if($_FILES[$varname]['name'][$i])
	{
		//ȡ���ļ�����
		$filetype=GetFiletype($_FILES[$varname]['name'][$i]);
		//�����ϴ�����
		if(CheckSaveTranFiletype($filetype))
		{
			return $r;
		}
		if(!strstr($public_r['filetype'],"|".$filetype."|"))
		{
			return $r;
		}
		//ͼƬ�ļ�
		if(!strstr($ecms_config['sets']['tranpicturetype'],','.$filetype.','))
		{
			return $r;
		}
		//�ļ���С
		if($_FILES[$varname]['size'][$i]>$public_r['filesize']*1024)
		{
			return $r;
		}
		//�ϴ�
		$r=DoTranFile($_FILES[$varname]['tmp_name'][$i],$_FILES[$varname]['name'][$i],$_FILES[$varname]['type'][$i],$_FILES[$varname]['size'][$i],$classid);
		//------------------------д�����ݿ�
		$r[filesize]=(int)$r[filesize];
		$classid=(int)$classid;
		if(empty($picname))
		{
			$picname=$r[filename];
		}
		else
		{
			$picname=$addname.$picname;
		}
		$picname=RepPostStr($picname);
		$id=(int)$id;
		$cjid=0;
		if(!$id)
		{
			$cjid=(int)$add['filepass'];
		}
		eInsertFileTable($r[filename],$r[filesize],$r[filepath],$loginin,$classid,$picname,$type,$id,$cjid,$public_r[fpath],0,0,$fstb);
		return $r;
	}
	//Զ�̱���
	else
	{
		if(empty($msavepic))
		{
			return $r;
		}
		if(empty($picurl))
		{
			return $r;
		}
		//----------------ȡ���ļ�����
		$filetype=GetFiletype($picurl);
		//�����ϴ�����
		if(CheckSaveTranFiletype($filetype))
		{
			return $r;
		}
		if(!strstr($public_r['filetype'],"|".$filetype."|"))
		{
			return $r;
		}
		//ͼƬ�ļ�
		if(!strstr($ecms_config['sets']['tranpicturetype'],','.$filetype.','))
		{
			return $r;
		}
		//����
		$r=DoTranUrl($picurl,$classid);
		if($r['tran'])
		{
			//��¼���ݿ�
			//��������
			$r[filesize]=(int)$r[filesize];
			$classid=(int)$classid;
			$r[type]=(int)$r[type];
			if(empty($picname))
			{
				$picname=$r[filename];
			}
			else
			{
				$picname=$addname.$picname;
			}
			$picname=RepPostStr($picname);
			$id=(int)$id;
			$cjid=0;
			if(!$id)
			{
				$cjid=(int)$add['filepass'];
			}

			eInsertFileTable($r[filename],$r[filesize],$r[filepath],$loginin,$classid,$picname,$type,$id,$cjid,$public_r[fpath],0,0,$fstb);
			return $r;
		}
		return $r;
	}
}

//���ʱԶ�̱���
function LoadInSaveMorepicFile($morepic,$msavepic,$classid,$id,$add,$modtype=0,$fstb=1){
	if(empty($morepic)||!$msavepic)
	{
		return $morepic;
	}
	$f_exp="::::::";
	$r_exp="\r\n";
	$returnstr="";
	$r=explode($r_exp,$morepic);
	$countr=count($r);
	for($i=0;$i<$countr;$i++)
	{
		$r1=explode($f_exp,$r[$i]);
		//Сͼ
		$smpr=SaveMorepicFile("msmallpfile",$msavepic,0,$r1[0],$r1[2],$classid,$id,$add,$modtype,$fstb);
		$spic=$smpr[url];
		//��ͼ
		if($r1[0]!=$r1[1])
		{
			$bmpr=SaveMorepicFile("mbigpfile",$msavepic,0,$r1[1],$r1[2],$classid,$id,$add,$modtype,$fstb);
			$bpic=$bmpr[url];
		}
		else
		{
			$bpic=$spic;
		}
		if($spic)
		{
			$returnstr.=$spic.$f_exp.$bpic.$f_exp.$r1[2].$r_exp;
		}
	}
	//ȥ�������ַ�
	$returnstr=substr($returnstr,0,strlen($returnstr)-2);
	return $returnstr;
}

//---------ͼƬ��ַ���
function ReturnMorepicpath($smallpic,$bigpic,$picname,$delpicid,$picid,$add,$downurl,$down=0,$modtype=0,$fstb=1){
	global $loginin,$logininid;
	$f_exp="::::::";
	$r_exp="\r\n";
	$returnstr="";
    $downurl=str_replace($f_exp,"",$downurl);
	$downurl=str_replace($r_exp,"",$downurl);
	$add[msavepic]=(int)$add[msavepic];
	$add[classid]=(int)$add[classid];
	$add[id]=(int)$add[id];
	$add[filepass]=(int)$add[filepass];
	$modtype=(int)$modtype;
	$fstb=(int)$fstb;
	$logininid=(int)$logininid;
	$loginin=RepPostVar($loginin);
	//������Ϣ
	if(empty($down))
	{
		for($i=0;$i<count($smallpic);$i++)
		{
			$name=str_replace($f_exp,"",$picname[$i]);
			$name=str_replace($r_exp,"",$name);
			//�滻�Ƿ��ַ�
			$spic=str_replace($f_exp,"",$smallpic[$i]);
			$spic=str_replace($r_exp,"",$spic);
			$spic=$spic?$downurl.$spic:'';
			//����ͼƬ
			$smpr=SaveMorepicFile("msmallpfile",$add[msavepic],$i,$spic,$name,$add[classid],$add[id],$add,$modtype,$fstb);
			$spic=$smpr[url];

			//��û�д�ͼ�Ļ�������ͼһ��
			if(empty($bigpic[$i])&&!$_FILES['mbigpfile']['name'][$i])
			{
				$bpic=$spic;
			}
			else
			{
				$bpic=str_replace($f_exp,"",$bigpic[$i]);
				$bpic=str_replace($r_exp,"",$bpic);
				$bpic=$bpic?$downurl.$bpic:'';
				//����ͼƬ
				$bmpr=SaveMorepicFile("mbigpfile",$add[msavepic],$i,$bpic,$name,$add[classid],$add[id],$add,$modtype,$fstb);
				$bpic=$bmpr[url];
				//������ͼ
				if(empty($spic)&&$bpic&&$bmpr[tran]&&$add[mcreatespic])
				{
					$picno='[b]'.($name?$name:$bmpr[filename]);
					$sfiler=GetMySmallImg($add['classid'],$picno,$bmpr[insertfile],$bmpr[filepath],$bmpr[yname],$add[mcreatespicwidth],$add[mcreatespicheight],$bmpr[name],$add['filepass'],$add['filepass'],$logininid,$loginin,$modtype,$fstb);
					$spic=str_replace("/".$bmpr[filename],"/small".$bmpr[insertfile].$sfiler['filetype'],$bmpr[url]);
				}
			}
			if(empty($spic))
			{
				$spic=$bpic;
			}
			if($spic)
			{$returnstr.=$spic.$f_exp.$bpic.$f_exp.$name.$r_exp;}
		}
	}
	//�޸���Ϣ
	else
	{
		for($i=0;$i<count($smallpic);$i++)
		{
			//ɾ����ַ
			$del=0;
			for($j=0;$j<count($delpicid);$j++)
			{
				if($delpicid[$j]==$picid[$i])
				{$del=1;}
			}
			if($del)
			{continue;}
			$name=str_replace($f_exp,"",$picname[$i]);
			$name=str_replace($r_exp,"",$name);
			//�滻�Ƿ��ַ�
			$spic=str_replace($f_exp,"",$smallpic[$i]);
			$spic=str_replace($r_exp,"",$spic);
			$spic=$spic?$downurl.$spic:'';
			//����ͼƬ
			$smpr=SaveMorepicFile("msmallpfile",$add[msavepic],$i,$spic,$name,$add[classid],$add[id],$add,$modtype,$fstb);
			$spic=$smpr[url];

			//��û�д�ͼ�Ļ�������ͼһ��
			if(empty($bigpic[$i])&&!$_FILES['mbigpfile']['name'][$i])
			{
				$bpic=$spic;
			}
			else
			{
				$bpic=str_replace($f_exp,"",$bigpic[$i]);
				$bpic=str_replace($r_exp,"",$bpic);
				$bpic=$bpic?$downurl.$bpic:'';
				//����ͼƬ
				$bmpr=SaveMorepicFile("mbigpfile",$add[msavepic],$i,$bpic,$name,$add[classid],$add[id],$add,$modtype,$fstb);
				$bpic=$bmpr[url];
				//������ͼ
				if(empty($spic)&&$bpic&&$bmpr[tran]&&$add[mcreatespic])
				{
					$picno='[b]'.($name?$name:$bmpr[filename]);
					$sfiler=GetMySmallImg($add['classid'],$picno,$bmpr[insertfile],$bmpr[filepath],$bmpr[yname],$add[mcreatespicwidth],$add[mcreatespicheight],$bmpr[name],$add['filepass'],$add['filepass'],$logininid,$loginin,$modtype,$fstb);
					$spic=str_replace("/".$bmpr[filename],"/small".$bmpr[insertfile].$sfiler['filetype'],$bmpr[url]);
				}
			}
			if(empty($spic))
			{
				$spic=$bpic;
			}
			if($spic)
			{$returnstr.=$spic.$f_exp.$bpic.$f_exp.$name.$r_exp;}
		}
	}
	//ȥ�������ַ�
	$returnstr=substr($returnstr,0,strlen($returnstr)-2);
	return $returnstr;
}

//---------���ص�ַ���
function ReturnDownpath($downname,$downpath,$delpathid,$pathid,$downuser,$fen,$thedownqz,$add,$foruser,$downurl,$down=0){
	$f_exp="::::::";
	$r_exp="\r\n";
	$returnstr="";
    $downurl=str_replace($f_exp,"",$downurl);
	$downurl=str_replace($r_exp,"",$downurl);
	//�������
	if(empty($down))
	{
		for($i=0;$i<count($downname);$i++)
		{
			//�滻�Ƿ��ַ�
			$name=str_replace($f_exp,"",$downname[$i]);
			$name=str_replace($r_exp,"",$name);
			$path=str_replace($f_exp,"",$downpath[$i]);
			$path=str_replace($r_exp,"",$path);
			//��������Ȩ��
			if($add[doforuser])
			{
				if(empty($foruser))
				{
					$foruser=0;
			    }
				$fuser=$foruser;
		    }
			else
			{
				if(empty($downuser[$i]))
				{
					$fuser=0;
			    }
				else
				{
					$fuser=$downuser[$i];
				}
		    }
			//�������µ���
			if($add[dodownfen])
			{
				if(empty($add[downfen]))
				{
					$add[downfen]=0;
				}
				$ffen=$add[downfen];
			}
			else
			{
				if(empty($fen[$i]))
				{
					$ffen=0;
				}
				else
				{
					$ffen=$fen[$i];
				}
			}
			$downqz=$thedownqz[$i];
			if($path&&$name)
			{$returnstr.=$name.$f_exp.$downurl.$path.$f_exp.$fuser.$f_exp.$ffen.$f_exp.$downqz.$r_exp;}
		}
	}
	//�޸����
	else
	{
		for($i=0;$i<count($downname);$i++)
		{
			//ɾ�����ص�ַ
			$del=0;
			for($j=0;$j<count($delpathid);$j++)
			{
				if($delpathid[$j]==$pathid[$i])
				{$del=1;}
			}
			if($del)
			{continue;}
			//�滻�Ƿ��ַ�
			$name=str_replace($f_exp,"",$downname[$i]);
			$name=str_replace($r_exp,"",$name);
			$path=str_replace($f_exp,"",$downpath[$i]);
			$path=str_replace($r_exp,"",$path);
			//��������Ȩ��
			if($add[doforuser])
			{
				if(empty($foruser))
				{
					$foruser=0;
			    }
				$fuser=$foruser;
		    }
			else
			{
				if(empty($downuser[$i]))
				{
					$fuser=0;
			    }
				else
				{
					$fuser=$downuser[$i];
				}
		    }
			//�������µ���
			if($add[dodownfen])
			{
				if(empty($add[downfen]))
				{
					$add[downfen]=0;
				}
				$ffen=$add[downfen];
			}
			else
			{
				if(empty($fen[$i]))
				{
					$ffen=0;
				}
				else
				{
					$ffen=$fen[$i];
				}
			}
			$downqz=$thedownqz[$i];
			if($path&&$name)
			{$returnstr.=$name.$f_exp.$downurl.$path.$f_exp.$fuser.$f_exp.$ffen.$f_exp.$downqz.$r_exp;}
		}
	}
	//ȥ�������ַ�
	$returnstr=substr($returnstr,0,strlen($returnstr)-2);
	return $returnstr;
}

//-------------- ������ ----------------------

//һ����Ŀ����
function GetClassNavCache($line,$navfh){
	global $empire,$dbtbpre,$public_r;
	$limit='';
	if($line)
	{
		$limit=" limit ".$line;
	}
	$navs='';
	$fh='';
	$sql=$empire->query("select classid,classname,wburl,listdt,classurl,classpath from {$dbtbpre}enewsclass where bclassid=0 and showclass=0 order by myorder,classid".$limit);
	while($r=$empire->fetch($sql))
	{
		$classurl=sys_ReturnBqClassUrl($r);
		if($navs)
		{
			$fh=$navfh;
		}
		$navs.=$fh."<a href=\"".$classurl."\">".$r[classname]."</a>";
	}
	return $navs;
}

//���������ļ�
function GetConfig($domod=0){
	$filename=eReturnTrueEcmsPath()."e/config/config.php";
	$exp='//-------EmpireCMS.Public.Cache-------';
	$text=ReadFiletext($filename);
	$r=explode($exp,$text);
	if($r[0]=='')
	{
		return false;
	}
	$r[1]=GetPubCache();
	if($domod==1)
	{
		$r[2]=GetModCache();
	}
	$setting=$r[0].$exp.$r[1].$exp.$r[2].$exp.$r[3];
	WriteFiletext_n($filename,$setting);
}

//���¹�������
function GetPubCache(){
	global $empire,$dbtbpre;
	//��չ����
	$pvstring='';
	$pvsql=$empire->query("select myvar,varvalue from {$dbtbpre}enewspubvar where tocache=1");
	while($pvr=$empire->fetch($pvsql))
	{
		$pvstring.=",'add_".$pvr['myvar']."'=>'".addslashes($pvr['varvalue'])."'";
	}
	//����ʶ�
	$ckhavemoreport=0;
	$mpnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmoreport");
	if($mpnum>1)
	{
		$ckhavemoreport=1;
	}
	//��������
	$r=$empire->fetch1("select * from {$dbtbpre}enewspublic limit 1");
	$tr=$empire->fetch1("select downsofttemp,onlinemovietemp,listpagetemp from ".GetTemptb("enewspubtemp")." limit 1");
	$fsr=$empire->fetch1("select purl from {$dbtbpre}enewspostserver where ptype=1 limit 1");
	$plr=$empire->fetch1("select * from {$dbtbpre}enewspl_set limit 1");
	$paddr=$empire->fetch1("select * from {$dbtbpre}enewspublicadd limit 1");
	$agcacher=eGetCacheMAdmin();
	$memberconnectnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmember_connect_app where isclose=0");
	$GLOBALS['public_r']['newsurl']=$r['newsurl'];
	$r[filedeftb]=1;
	$plr[pldeftb]=1;
	$classnavs=GetClassNavCache($r[classnavline],$r[classnavfh]);
	$checkdorepstr=ReturnCheckDoRep();
	$setting.="

//------------e_public
\$public_r=array('sitename'=>'".addslashes($r[sitename])."',
'newsurl'=>'".addslashes($r[newsurl])."',
'filetype'=>'".addslashes($r[filetype])."',
'filesize'=>".$r[filesize].",
'relistnum'=>".$r[relistnum].",
'renewsnum'=>".$r[renewsnum].",
'min_keyboard'=>".$r[min_keyboard].",
'max_keyboard'=>".$r[max_keyboard].",
'search_num'=>".$r[search_num].",
'search_pagenum'=>".$r[search_pagenum].",
'newslink'=>".$r[newslink].",
'checked'=>".$r[checked].",
'searchtime'=>".$r[searchtime].",
'loginnum'=>".$r[loginnum].",
'logintime'=>".$r[logintime].",
'addnews_ok'=>".$r[addnews_ok].",
'register_ok'=>".$r[register_ok].",
'indextype'=>'".addslashes($r[indextype])."',
'goodlencord'=>".$r[goodlencord].",
'goodtype'=>'".addslashes($r[goodtype])."',
'searchtype'=>'".addslashes($r[searchtype])."',
'exittime'=>".$r[exittime].",
'smalltextlen'=>".$r[smalltextlen].",
'defaultgroupid'=>".$r[defaultgroupid].",
'fileurl'=>'".addslashes($r[fileurl])."',
'install'=>".$r[install].",
'phpmode'=>".$r[phpmode].",
'dorepnum'=>".$r[dorepnum].",
'loadtempnum'=>".$r[loadtempnum].",
'bakdbpath'=>'".addslashes($r[bakdbpath])."',
'bakdbzip'=>'".addslashes($r[bakdbzip])."',
'downpass'=>'".addslashes($r[downpass])."',
'filechmod'=>".$r[filechmod].",
'loginkey_ok'=>".$r[loginkey_ok].",
'tbname'=>'".addslashes($r[tbname])."',
'limittype'=>".$r[limittype].",
'redodown'=>".$r[redodown].",
'downsofttemp'=>'".addslashes(stripSlashes($tr[downsofttemp]))."',
'onlinemovietemp'=>'".addslashes(stripSlashes($tr[onlinemovietemp]))."',
'lctime'=>".$r[lctime].",
'candocode'=>".$r[candocode].",
'opennotcj'=>".$r[opennotcj].",
'listpagetemp'=>'".addslashes(stripSlashes($tr[listpagetemp]))."',
'reuserpagenum'=>".$r[reuserpagenum].",
'revotejsnum'=>".$r[revotejsnum].",
'readjsnum'=>".$r[readjsnum].",
'qaddtran'=>".$r[qaddtran].",
'qaddtransize'=>".$r[qaddtransize].",
'ebakthisdb'=>".$r[ebakthisdb].",
'delnewsnum'=>".$r[delnewsnum].",
'markpos'=>".$r[markpos].",
'markimg'=>'".addslashes($r[markimg])."',
'marktext'=>'".addslashes($r[marktext])."',
'markfontsize'=>'".addslashes($r[markfontsize])."',
'markfontcolor'=>'".addslashes($r[markfontcolor])."',
'markfont'=>'".addslashes($r[markfont])."',
'adminloginkey'=>".$r[adminloginkey].",
'php_outtime'=>".$r[php_outtime].",
'listpagefun'=>'".addslashes($r[listpagefun])."',
'textpagefun'=>'".addslashes($r[textpagefun])."',
'adfile'=>'".addslashes($r[adfile])."',
'notsaveurl'=>'".addslashes($r[notsaveurl])."',
'rssnum'=>".$r[rssnum].",
'rsssub'=>".$r[rsssub].",
'savetxtf'=>'".addslashes($r[savetxtf])."',
'dorepdlevelnum'=>".$r[dorepdlevelnum].",
'listpagelistfun'=>'".addslashes($r[listpagelistfun])."',
'listpagelistnum'=>".$r[listpagelistnum].",
'infolinknum'=>".$r[infolinknum].",
'searchgroupid'=>".$r[searchgroupid].",
'opencopytext'=>".$r[opencopytext].",
'reuserjsnum'=>".$r[reuserjsnum].",
'reuserlistnum'=>".$r[reuserlistnum].",
'opentitleurl'=>".$r[opentitleurl].",
'searchtempvar'=>".$r[searchtempvar].",
'showinfolevel'=>".$r[showinfolevel].",
'navfh'=>'".addslashes($r[navfh])."',
'spicwidth'=>".$r[spicwidth].",
'spicheight'=>".$r[spicheight].",
'spickill'=>".$r[spickill].",
'jpgquality'=>".$r[jpgquality].",
'markpct'=>".$r[markpct].",
'redoview'=>".$r[redoview].",
'reggetfen'=>".$r[reggetfen].",
'regbooktime'=>".$r[regbooktime].",
'revotetime'=>".$r[revotetime].",
'fpath'=>".$r[fpath].",
'filepath'=>'".addslashes($r[filepath])."',
'nreclass'=>'".addslashes($r[nreclass])."',
'nreinfo'=>'".addslashes($r[nreinfo])."',
'nrejs'=>'".addslashes($r[nrejs])."',
'nottobq'=>'".addslashes($r[nottobq])."',
'defspacestyleid'=>".$r[defspacestyleid].",
'canposturl'=>'".addslashes($r[canposturl])."',
'openspace'=>".$r[openspace].",
'defadminstyle'=>".$r[defadminstyle].",
'realltime'=>".$r[realltime].",
'closeip'=>'".addslashes($r[closeip])."',
'openip'=>'".addslashes($r[openip])."',
'hopenip'=>'".addslashes($r[hopenip])."',
'textpagelistnum'=>".$r[textpagelistnum].",
'memberlistlevel'=>".$r[memberlistlevel].",
'ebakcanlistdb'=>".$r[ebakcanlistdb].",
'keytog'=>".$r[keytog].",
'keytime'=>".$r[keytime].",
'keyrnd'=>'".addslashes($r[keyrnd])."',
'checkdorepstr'=>'".addslashes($checkdorepstr)."',
'regkey_ok'=>".$r[regkey_ok].",
'opengetdown'=>".$r[opengetdown].",
'gbkey_ok'=>".$r[gbkey_ok].",
'fbkey_ok'=>".$r[fbkey_ok].",
'newaddinfotime'=>".$r[newaddinfotime].",
'classnavs'=>'".addslashes($classnavs)."',
'adminstyle'=>'".addslashes($r[adminstyle])."',
'docnewsnum'=>".$r[docnewsnum].",
'openschall'=>".$r[openschall].",
'schallfield'=>".$r[schallfield].",
'schallminlen'=>".$r[schallminlen].",
'schallmaxlen'=>".$r[schallmaxlen].",
'schallnum'=>".$r[schallnum].",
'schallpagenum'=>".$r[schallpagenum].",
'dtcanbq'=>".$r[dtcanbq].",
'dtcachetime'=>".$r[dtcachetime].",
'repkeynum'=>".$r[repkeynum].",
'regacttype'=>".$r[regacttype].",
'opengetpass'=>".$r[opengetpass].",
'hlistinfonum'=>".$r[hlistinfonum].",
'qlistinfonum'=>".$r[qlistinfonum].",
'dtncanbq'=>".$r[dtncanbq].",
'dtncachetime'=>".$r[dtncachetime].",
'readdinfotime'=>".$r[readdinfotime].",
'qeditinfotime'=>".$r[qeditinfotime].",
'onclicktype'=>".$r[onclicktype].",
'onclickfilesize'=>".$r[onclickfilesize].",
'onclickfiletime'=>".$r[onclickfiletime].",
'schalltime'=>".$r[schalltime].",
'defprinttempid'=>".$r[defprinttempid].",
'opentags'=>".$r[opentags].",
'tagstempid'=>".$r[tagstempid].",
'usetags'=>'".addslashes($r[usetags])."',
'chtags'=>'".addslashes($r[chtags])."',
'tagslistnum'=>".$r[tagslistnum].",
'closeqdt'=>".$r[closeqdt].",
'settop'=>".$r[settop].",
'qlistinfomod'=>".$r[qlistinfomod].",
'gb_num'=>".$r[gb_num].",
'member_num'=>".$r[member_num].",
'space_num'=>".$r[space_num].",
'infolday'=>".$r[infolday].",
'filelday'=>".$r[filelday].",
'dorepkey'=>".$r[dorepkey].",
'dorepword'=>".$r[dorepword].",
'onclickrnd'=>'".addslashes($r[onclickrnd])."',
'indexpagedt'=>".$r[indexpagedt].",
'keybgcolor'=>'".addslashes($r[keybgcolor])."',
'keyfontcolor'=>'".addslashes($r[keyfontcolor])."',
'keydistcolor'=>'".addslashes($r[keydistcolor])."',
'indexpageid'=>".$r[indexpageid].",
'closeqdtmsg'=>'".addslashes($r[closeqdtmsg])."',
'openfileserver'=>".$r[openfileserver].",
'fs_purl'=>'".addslashes($fsr[purl])."',
'closemods'=>'".addslashes($r[closemods])."',
'fieldandtop'=>".$r[fieldandtop].",
'fieldandclosetb'=>'".addslashes($r[fieldandclosetb])."',
'filedatatbs'=>'".addslashes($r[filedatatbs])."',
'filedeftb'=>".$r[filedeftb].",
'pldeftb'=>".$plr[pldeftb].",
'plurl'=>'".addslashes($plr[plurl])."',
'plkey_ok'=>".$plr[plkey_ok].",
'plface'=>'".addslashes($plr[plface])."',
'plf'=>'".addslashes($plr[plf])."',
'pldatatbs'=>'".addslashes($plr[pldatatbs])."',
'defpltempid'=>".$plr[defpltempid].",
'pl_num'=>".$plr[pl_num].",
'plgroupid'=>".$plr[plgroupid].",
'closelisttemp'=>'".addslashes($r[closelisttemp])."',
'chclasscolor'=>'".addslashes($r[chclasscolor])."',
'timeclose'=>'".addslashes($r[timeclose])."',
'timeclosedo'=>'".addslashes($r[timeclosedo])."',
'ipaddinfonum'=>".$r[ipaddinfonum].",
'ipaddinfotime'=>".$r[ipaddinfotime].",
'rewriteinfo'=>'".addslashes($r[rewriteinfo])."',
'rewriteclass'=>'".addslashes($r[rewriteclass])."',
'rewriteinfotype'=>'".addslashes($r[rewriteinfotype])."',
'rewritetags'=>'".addslashes($r[rewritetags])."',
'rewritepl'=>'".addslashes($r[rewritepl])."',
'memberconnectnum'=>".$memberconnectnum.",
'closehmenu'=>'".addslashes($r[closehmenu])."',
'indexaddpage'=>".$r[indexaddpage].",
'modmemberedittran'=>".$r[modmemberedittran].",
'modinfoedittran'=>".$r[modinfoedittran].",
'php_adminouttime'=>".$r[php_adminouttime].",
'httptype'=>".$r[httptype].",
'qinfoaddfen'=>".$r[qinfoaddfen].",
'bakescapetype'=>".$r[bakescapetype].",
'hkeytime'=>".$r[hkeytime].",
'hkeyrnd'=>'".addslashes($r[hkeyrnd])."',
'mhavedatedo'=>".$r[mhavedatedo].",
'reportkey'=>".$r[reportkey].",
'ctimeopen'=>".$paddr[ctimeopen].",
'ctimelast'=>".$paddr[ctimelast].",
'ctimeindex'=>".$paddr[ctimeindex].",
'ctimeclass'=>".$paddr[ctimeclass].",
'ctimelist'=>".$paddr[ctimelist].",
'ctimetext'=>".$paddr[ctimetext].",
'ctimett'=>".$paddr[ctimett].",
'ctimetags'=>".$paddr[ctimetags].",
'ctimegids'=>'".addslashes($paddr[ctimegids])."',
'ctimecids'=>'".addslashes($paddr[ctimecids])."',
'ctimernd'=>'".addslashes($paddr[ctimernd])."',
'qmadminuids'=>'".addslashes($agcacher[qmadminuids])."',
'qmforumuids'=>'".addslashes($agcacher[qmforumuids])."',
'qmotheruids'=>'".addslashes($agcacher[qmotheruids])."',
'ckhavemoreport'=>".$ckhavemoreport.",
'usetotalnum'=>".$r[usetotalnum].",
'autodoopen'=>".$paddr[autodoopen].",
'autodofile'=>".$paddr[autodofile].",
'autodoss'=>".$paddr[autodoss].",
'digglevel'=>".$paddr[digglevel].",
'diggcmids'=>'".addslashes($paddr[diggcmids])."',
'spacegids'=>'".addslashes($r[spacegids])."',
'candocodetag'=>".$r[candocodetag].",
'openern'=>'".addslashes($r[openern])."',
'ernurl'=>'".addslashes($r[ernurl])."',
'toqjf'=>'".addslashes($paddr[toqjf])."',
'qtoqjf'=>'".addslashes($paddr[qtoqjf])."',
'ctimeaddre'=>".$paddr[ctimeaddre].",
'ctimeqaddre'=>".$paddr[ctimeqaddre].",
'deftempid'=>".$r[deftempid].$pvstring.");
//------------e_public
".GetMoreportCache()."

";
	return $setting;
}

//����ģ�ͻ���
function GetModCache(){
	global $empire,$dbtbpre;
	//���ݱ�
	$tablesql=$empire->query("select tbname,deftb,yhid,mid,intb from {$dbtbpre}enewstable");
	while($tabler=$empire->fetch($tablesql))
	{
		$tables.="\$etable_r['".$tabler[tbname]."']=Array('deftb'=>'".addslashes($tabler[deftb])."',
'yhid'=>".$tabler[yhid].",
'intb'=>".$tabler[intb].",
'mid'=>".$tabler[mid].");
";
	}
	//ϵͳģ��
	$alllinkfields='|';//����ͬ��
	$modsql=$empire->query("select * from {$dbtbpre}enewsmod");
	while($mr=$empire->fetch($modsql))
	{
		$listtempf=doReturnAddTempf($mr['listtempvar']);//�б�ģ��
		$texttempf=doReturnAddTempf($mr['tempvar']);//����ģ��
		$enter=doReturnAddTempf($mr['enter']);//¼����
		$qenter=doReturnAddTempf($mr['qenter']);//Ͷ����
		$cj=doReturnAddTempf($mr['cj']);//�ɼ���
		//���ֶ�
		$mainf=',';//�����ֶ�
		$dataf=',';//�����ֶ�
		$tobrf=',';//�س��ֶ�
		$dohtmlf=',';//html�ֶ�
		$savetxtf='';//���ı��ֶ�
		$pagef='';//��ҳ�ֶ�
		$smalltextf=',';//����ֶ�
		$checkboxf=',';//��ѡ���ֶ�
		$filef=',';//�����ֶ�
		$imgf=',';//ͼƬ�ֶ�
		$flashf=',';//FLASH�ֶ�
		$onlyf=',';//Ψһ�ֶ�
		$linkfields='|';//����ͬ��
		$morevaluef='|';//��ֵ�ֶ�
		$editorf=',';//�༭���ֶ�
		$ubbeditorf=',';//UBB�༭���ֶ�
		$adddofunf='||';//���Ӵ�����
		$editdofunf='||';//�޸Ĵ�����
		$qadddofunf='||';//Ͷ�����Ӵ�����
		$qeditdofunf='||';//Ͷ���޸Ĵ�����
		$fsql=$empire->query("select * from {$dbtbpre}enewsf where tid='$mr[tid]'");
		while($fr=$empire->fetch($fsql))
		{
			if($fr['tbdataf'])
			{
				$dataf.=$fr['f'].',';
			}
			elseif($fr['f']!='special.field')
			{
				$mainf.=$fr['f'].',';
			}
			if($fr['tobr'])
			{
				$tobrf.=$fr['f'].',';
			}
			if($fr['dohtml'])
			{
				$dohtmlf.=$fr['f'].',';
			}
			if($fr['savetxt'])
			{
				$savetxtf=$fr['f'];
			}
			if($fr['ispage'])
			{
				$pagef=$fr['f'];
			}
			if($fr['issmalltext'])
			{
				$smalltextf.=$fr['f'].',';
			}
			if($fr['fform']=='checkbox')
			{
				$checkboxf.=$fr['f'].',';
			}
			if($fr['fform']=='file')
			{
				$filef.=$fr['f'].',';
			}
			if($fr['fform']=='img')
			{
				$imgf.=$fr['f'].',';
			}
			if($fr['fform']=='flash')
			{
				$flashf.=$fr['f'].',';
			}
			if($fr['isonly'])
			{
				$onlyf.=$fr['f'].',';
			}
			if(($fr['fform']=='linkfield'||$fr['fform']=='linkfieldselect')&&$fr['samedata']&&$fr['linkfieldval'])
			{
				$linkfields.=$fr[f].','.$fr[linkfieldtb].'.'.$fr[linkfieldval].'|';
				$alllinkfields.=$fr[tbname].'.'.$fr[f].','.$fr[linkfieldtb].'.'.$fr[linkfieldval].'|';
			}
			if($fr['fform']=='morevaluefield')
			{
				$morevaluef.=$fr[f].','.$fr[fmvnum].'|';
			}
			if($fr['fform']=='editor')
			{
				$editorf.=$fr['f'].',';
			}
			if($fr['fform']=='ubbeditor')
			{
				$ubbeditorf.=$fr['f'].',';
			}
			if($fr['adddofun'])
			{
				$adddofunf.=$fr[f].'!#!'.$fr[adddofun].'||';
			}
			if($fr['editdofun'])
			{
				$editdofunf.=$fr[f].'!#!'.$fr[editdofun].'||';
			}
			if($fr['qadddofun'])
			{
				$qadddofunf.=$fr[f].'!#!'.$fr[qadddofun].'||';
			}
			if($fr['qeditdofun'])
			{
				$qeditdofunf.=$fr[f].'!#!'.$fr[qeditdofun].'||';
			}
		}
		//������
		$tr=$empire->fetch1("select * from {$dbtbpre}enewstable where tid='$mr[tid]'");
		//�ַ�
		$mods.="\$emod_r[".$mr[mid]."]=Array('mid'=>".$mr[mid].",
'mname'=>'".addslashes($mr[mname])."',
'qmname'=>'".addslashes($mr[qmname])."',
'defaulttb'=>".$tr[isdefault].",
'datatbs'=>'".addslashes($tr[datatbs])."',
'deftb'=>'".addslashes($tr[deftb])."',
'enter'=>'".addslashes($enter)."',
'qenter'=>'".addslashes($qenter)."',
'listtempf'=>'".addslashes($listtempf)."',
'tempf'=>'".addslashes($texttempf)."',
'mustqenterf'=>'".addslashes($mr[mustqenterf])."',
'listandf'=>'".addslashes($mr[listandf])."',
'setandf'=>".$mr[setandf].",
'searchvar'=>'".addslashes($mr[searchvar])."',
'cj'=>'".addslashes($cj)."',
'canaddf'=>'".addslashes($mr[canaddf])."',
'caneditf'=>'".addslashes($mr[caneditf])."',
'tbmainf'=>'".addslashes($mainf)."',
'tbdataf'=>'".addslashes($dataf)."',
'tobrf'=>'".addslashes($tobrf)."',
'dohtmlf'=>'".addslashes($dohtmlf)."',
'checkboxf'=>'".addslashes($checkboxf)."',
'savetxtf'=>'".addslashes($savetxtf)."',
'editorf'=>'".addslashes($editorf)."',
'ubbeditorf'=>'".addslashes($ubbeditorf)."',
'pagef'=>'".addslashes($pagef)."',
'smalltextf'=>'".addslashes($smalltextf)."',
'filef'=>'".addslashes($filef)."',
'imgf'=>'".addslashes($imgf)."',
'flashf'=>'".addslashes($flashf)."',
'linkfields'=>'".addslashes($linkfields)."',
'morevaluef'=>'".addslashes($morevaluef)."',
'onlyf'=>'".addslashes($onlyf)."',
'adddofunf'=>'".addslashes($adddofunf)."',
'editdofunf'=>'".addslashes($editdofunf)."',
'qadddofunf'=>'".addslashes($qadddofunf)."',
'qeditdofunf'=>'".addslashes($qeditdofunf)."',
'definfovoteid'=>".$mr[definfovoteid].",
'orderf'=>'".addslashes($mr[orderf])."',
'sonclass'=>'".addslashes($mr[sonclass])."',
'maddfun'=>'".addslashes($mr['maddfun'])."',
'meditfun'=>'".addslashes($mr['meditfun'])."',
'qmaddfun'=>'".addslashes($mr['qmaddfun'])."',
'qmeditfun'=>'".addslashes($mr['qmeditfun'])."',
'tid'=>".$mr[tid].",
'tbname'=>'".addslashes($mr[tbname])."');
";
	}
	$mods="

\$emod_pubr=Array('linkfields'=>'".addslashes($alllinkfields)."');

\$etable_r=array();
".$tables."

\$emod_r=array();
".$mods."

";
	return $mods;
}

//���ػ�Ա������
function eGetCacheMAdmin(){
	global $empire,$dbtbpre;
	$qmr=array();
	$qmr['qmadminuids']='';
	$qmr['qmforumuids']='';
	$qmr['qmotheruids']='';
	//����
	$agcache='';
	$qmsql=$empire->query("select * from {$dbtbpre}enewsag");
	while($r=$empire->fetch($qmsql))
	{
		if($r['isadmin']==9)//����Ա
		{
			if($r['auids'])
			{
				$qmr['qmadminuids']=$qmr['qmadminuids']?substr($r['auids'],0,-1).$qmr['qmadminuids']:$r['auids'];
			}
		}
		elseif($r['isadmin']>=5)//����
		{
			if($r['auids'])
			{
				$qmr['qmforumuids']=$qmr['qmforumuids']?substr($r['auids'],0,-1).$qmr['qmforumuids']:$r['auids'];
			}
		}
		elseif($r['isadmin']>=1)//ʵϰ����
		{
			if($r['auids'])
			{
				$qmr['qmotheruids']=$qmr['qmotheruids']?substr($r['auids'],0,-1).$qmr['qmotheruids']:$r['auids'];
			}
		}
		else
		{
		}
		//����
		$agcache.="\$aglevel_r[".$r['agid']."]=Array('agid'=>".$r['agid'].",
'agname'=>'".addslashes($r['agname'])."',
'isadmin'=>".$r['isadmin'].");
";
	}
	$agcache="
\$aglevel_r=array();
".$agcache."
";
	$qmr['agcache']=$agcache;
	return $qmr;
}

//���ػ�Ա�ڲ���
function eGetCacheMInGroup(){
	global $empire,$dbtbpre;
	//����
	$igcache='';
	$sql=$empire->query("select * from {$dbtbpre}enewsingroup");
	while($r=$empire->fetch($sql))
	{
		//����
		$igcache.="\$iglevel_r[".$r['gid']."]=Array('gid'=>".$r['gid'].",
'gname'=>'".addslashes($r['gname'])."');
";
	}
	$igcache="
\$iglevel_r=array();
".$igcache."
";
	return $igcache;
}

//��Ա�黺��
function GetMemberLevel(){
	global $empire,$dbtbpre;
	$file=eReturnTrueEcmsPath()."e/data/dbcache/MemberLevel.php";
	$sql=$empire->query("select * from {$dbtbpre}enewsmembergroup order by groupid");
	while($r=$empire->fetch($sql))
	{
		$levels.="\$level_r[".$r[groupid]."]=Array('groupid'=>".$r[groupid].",
'groupname'=>'".addslashes($r[groupname])."',
'level'=>".$r[level].",
'checked'=>".$r[checked].",
'favanum'=>".$r[favanum].",
'daydown'=>".$r[daydown].",
'msglen'=>".$r[msglen].",
'regchecked'=>".$r[regchecked].",
'spacestyleid'=>".$r[spacestyleid].",
'dayaddinfo'=>".$r[dayaddinfo].",
'infochecked'=>".$r[infochecked].",
'plchecked'=>".$r[plchecked].",
'msgnum'=>".$r[msgnum].");
";
	}
	//������
	$agcacher=eGetCacheMAdmin();
	//�ڲ���
	$igcache=eGetCacheMInGroup();
	$levels="<?php
//level
\$level_r=array();
".$levels.$agcacher['agcache'].$igcache."
//level
?>";
	WriteFiletext_n($file,$levels);
}

//�Ż�����
function GetYh(){
	global $empire,$dbtbpre;
	$sql=$empire->query("select * from {$dbtbpre}enewsyh");
	while($r=$empire->fetch($sql))
	{
		$yhs.="\$eyh_r[".$r[id]."]=Array('id'=>".$r[id].",
'hlist'=>".$r[hlist].",
'qlist'=>".$r[qlist].",
'bqnew'=>".$r[bqnew].",
'bqhot'=>".$r[bqhot].",
'bqpl'=>".$r[bqpl].",
'bqgood'=>".$r[bqgood].",
'bqfirst'=>".$r[bqfirst].",
'qmlist'=>".$r[qmlist].",
'dobq'=>".$r[dobq].",
'dojs'=>".$r[dojs].",
'dosbq'=>".$r[dosbq].",
'rehtml'=>".$r[rehtml].",
'otherlink'=>".$r[otherlink].",
'bqdown'=>".$r[bqdown].");
";
	}
	$yhs="
".$yhs."
";
	return $yhs;
}

//�����ֶλ���
function ReturnEmptyFCache($f,$val,$isint=0){
	$str='';
	if($val)
	{
		if($isint)
		{
			$str="'".$f."'=>".$val.",";
		}
		else
		{
			$str="'".$f."'=>'".addslashes($val)."',";
		}
	}
	return $str;
}

//��Ŀ����
function GetClass(){
	global $empire,$dbtbpre;
	$fileqz=eReturnTrueEcmsPath().'e/data/dbcache/';
	$filename=$fileqz.'class.php';
	$line=250;//ÿ���ļ������Ŀ��
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsclass");
	$sql=$empire->query("select * from {$dbtbpre}enewsclass");
	$no=0;
	$p=0;
	$l="";
	$mod=array();
	$modstr=",";
	while($r=$empire->fetch($sql))
	{
		$no++;
		$l="";
		if($r[wburl])//�ⲿ��Ŀ
		{
			$l=",
'wburl'=>'".addslashes($r[wburl])."'";
		}
		elseif($r[islast])//�ռ���Ŀ
		{
			//���ģ��
			if(empty($mod[$r[modid]]))
			{
				$mod[$r[modid]]="|";
		    }
			$mod[$r[modid]].=$r[classid]."|";
			if(!strstr($modstr,",".$r[modid].","))
			{
				$modstr.=$r[modid].",";
			}
			$l=",
'lencord'=>".$r[lencord].",".ReturnEmptyFCache('link_num',$r[link_num],1)."
'newstempid'=>".$r[newstempid].",".ReturnEmptyFCache('oneinfo',$r[oneinfo],1)."
'listtempid'=>".$r[listtempid].",".ReturnEmptyFCache('pltempid',$r[pltempid],1)."
".ReturnEmptyFCache('newspath',$r[newspath],0).ReturnEmptyFCache('filename',$r[filename],1)."
'filetype'=>'".addslashes($r[filetype])."',".ReturnEmptyFCache('ipath',$r[ipath],0)."
".ReturnEmptyFCache('openpl',$r[openpl],1).ReturnEmptyFCache('openadd',$r[openadd],1)."
".ReturnEmptyFCache('groupid',$r[groupid],0).ReturnEmptyFCache('filename_qz',$r[filename_qz],0)."
'checked'=>".$r[checked].",".ReturnEmptyFCache('wfid',$r[wfid],1)."
'bname'=>'".addslashes($r[bname])."',".ReturnEmptyFCache('cgtoinfo',$r[cgtoinfo],1)."
".ReturnEmptyFCache('showdt',$r[showdt],1).ReturnEmptyFCache('checkpl',$r[checkpl],1).ReturnEmptyFCache('keycid',$r[keycid],1)."
'reorder'=>'".addslashes($r[reorder])."'";
	    }
		else
		{
			//�б�ʽ
			if($r[islist]==1&&empty($r[islast]))
			{
				$l=",
'lencord'=>".$r[lencord].",
'reorder'=>'".addslashes($r[reorder])."',
'listtempid'=>".$r[listtempid];
			}
			elseif($r[listtempid])
			{
				$l=",
'lencord'=>".$r[lencord].",
'reorder'=>'".addslashes($r[reorder])."',
'listtempid'=>".$r[listtempid];
			}
		}
		if($r[dtlisttempid])
		{
			$l.=",
'dtlisttempid'=>".$r[dtlisttempid];
		}
		$classes.="\$class_r[".$r[classid]."]=Array('classid'=>".$r[classid].",
'bclassid'=>".$r[bclassid].",
'classname'=>'".addslashes($r[classname])."',
'sonclass'=>'".addslashes($r[sonclass])."',
'featherclass'=>'".addslashes($r[featherclass])."',
'islast'=>".$r[islast].",
'classpath'=>'".addslashes($r[classpath])."',".ReturnEmptyFCache('searchtempid',$r[searchtempid],1)."
'classtype'=>'".addslashes($r[classtype])."',".ReturnEmptyFCache('classurl',$r[classurl],0)."
".ReturnEmptyFCache('maxnum',$r[maxnum],1).ReturnEmptyFCache('yhid',$r[yhid],1)."
'down_num'=>".$r[down_num].",
'online_num'=>".$r[online_num].",
'islist'=>".$r[islist].",".ReturnEmptyFCache('listdt',$r[listdt],1)."
'tid'=>".$r[tid].",
'tbname'=>'".addslashes($r[tbname])."',
'modid'=>".$r[modid].$l.");
";
		if($no%$line==0||($num%$line<>0&&$num==$no))
		{
			$p++;
			$file="class".$p.".php";
			$include.="require(ECMS_PATH.'e/data/dbcache/".$file."');\r\n";
			$classes="<?php
".$classes."?>";
			WriteFiletext_n($fileqz.$file,$classes);
			$classes="";
        }
	}
	//-----ר�⻺��
	$zsql=$empire->query("select * from {$dbtbpre}enewszt");
	$zt="";
	$zfile=$fileqz."ztclass.php";
	while($zr=$empire->fetch($zsql))
	{
		$zt.="\$class_zr[".$zr[ztid]."]=Array('ztid'=>".$zr[ztid].",
'ztname'=>'".addslashes($zr[ztname])."',
'ztnum'=>".$zr[ztnum].",
'listtempid'=>".$zr[listtempid].",
'ztpath'=>'".addslashes($zr[ztpath])."',".ReturnEmptyFCache('pltempid',$r[pltempid],1)."
'zttype'=>'".addslashes($zr[zttype])."',".ReturnEmptyFCache('zturl',$zr[zturl],0)."
'islist'=>".$zr[islist].",".ReturnEmptyFCache('maxnum',$zr[maxnum],1)."
'reorder'=>'".addslashes($zr[reorder])."',".ReturnEmptyFCache('yhid',$zr[yhid],1)."
'tbname'=>'".addslashes($zr[tbname])."');
";
	}
	$zt="<?php
".$zt.GetTitleTypeCache()."?>";
	WriteFiletext_n($zfile,$zt);
	$include.="require(ECMS_PATH.'e/data/dbcache/ztclass.php');\r\n";
	$include="<?php
".AddCheckViewCode()."
\$class_r=array();
\$class_zr=array();
\$class_tr=array();
\$eyh_r=array();
".$include."
".GetYh()."
?>";
	WriteFiletext_n($filename,$include);
	//���ģ��
	$er=explode(",",$modstr);
	for($i=1;$i<count($er)-1;$i++)
	{
		$mid=$er[$i];
		$usql=$empire->query("update {$dbtbpre}enewsmod set sonclass='".$mod[$mid]."' where mid='$mid'");
    }
}

//������໺��
function GetTitleTypeCache(){
	global $empire,$dbtbpre;
	$sql=$empire->query("select typeid,tname,mid,yhid,tpath,tid,tbname,listdt,ttype from {$dbtbpre}enewsinfotype");
	while($r=$empire->fetch($sql))
	{
		$string.="\$class_tr[".$r[typeid]."]=Array('typeid'=>".$r[typeid].",
'tname'=>'".addslashes($r[tname])."',
'tpath'=>'".addslashes($r[tpath])."',
'ttype'=>'".addslashes($r[ttype])."',
'yhid'=>".$r[yhid].",
'listdt'=>".$r[listdt].",
'tbname'=>'".addslashes($r[tbname])."',
'mid'=>".$r[mid].");
";
	}
	return $string;
}

//ȫվ��������Դ����
function GetSearchAllTb(){
	global $empire,$dbtbpre;
	$file=eReturnTrueEcmsPath()."e/data/dbcache/SearchAllTb.php";
	$sql=$empire->query("select tbname,titlefield,smalltextfield from {$dbtbpre}enewssearchall_load");
	while($r=$empire->fetch($sql))
	{
		$tbs.="\$schalltb_r['".$r[tbname]."']=Array('tbname'=>'".addslashes($r[tbname])."',
'titlefield'=>'".addslashes($r[titlefield])."',
'smalltextfield'=>'".addslashes($r[smalltextfield])."');
";
	}
	$tbs="<?php
//tbs
\$schalltb_r=array();
".$tbs."
//tbs
?>";
	WriteFiletext_n($file,$tbs);
}


//-------------- moreport ----------------------

//��վ���ʶ˻���
function GetMoreportCache(){
	global $empire,$dbtbpre;
	$sql=$empire->query("select * from {$dbtbpre}enewsmoreport");
	$i=0;
	while($r=$empire->fetch($sql))
	{
		$i++;
		$moreports.="\$emoreport_r['".$r[pid]."']=Array('pid'=>'".$r[pid]."',
'pname'=>'".addslashes($r[pname])."',
'purl'=>'".addslashes($r[purl])."',
'ppath'=>'".addslashes($r[ppath])."',
'postpass'=>'".addslashes($r[postpass])."',
'postfile'=>'".addslashes($r[postfile])."',
'tempgid'=>'".addslashes($r[tempgid])."',
'isclose'=>'".addslashes($r[isclose])."',
'closeadd'=>'".addslashes($r[closeadd])."',
'openadmin'=>'".addslashes($r[openadmin])."',
'rehtml'=>'".addslashes($r[rehtml])."',
'mustdt'=>'".$r[mustdt]."');
";
	}
	if($i>1)
	{
		$moreports="
//moreports
\$emoreport_r=array();
".$moreports."
//moreports
";
	}
	else
	{
		$moreports="
//moreports
\$emoreport_r=array();
//moreports
";
	}
	return $moreports;
}

//������رշ��ʶ���Ϣ
function Moreport_UpdateIsclose(){
	global $empire,$dbtbpre,$public_r;
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmoreport where isclose=0");
	if($num>1)
	{
		$purl=addslashes(eReturnDomainSiteUrl());
		$ppath=addslashes(ReturnAbsEcmsPath());
		$postpass=make_password(60);
		$empire->query("update {$dbtbpre}enewsmoreport set purl='$purl',ppath='$ppath',postpass='$postpass',rehtml='3' where pid=1");
	}
	else
	{
		$postpass=make_password(60);
		$empire->query("update {$dbtbpre}enewsmoreport set purl='',ppath='',postpass='$postpass',rehtml='0' where pid=1");
	}
	return $num;
}

//�Ƿ������ʶ˹���
function Moreport_CheckAdminIsMain(){
	global $ecms_config;
	if($ecms_config['sets']['selfmoreportid']>1)
	{
		printerror("NotMainMoreport","history.go(-1)");
	}
}

//��ʾ���ʶ�
function Moreport_eReturnMoreportSelect($pid,$varname=''){
	global $empire,$dbtbpre,$public_r,$ecms_config;
	if(!$varname)
	{
		$varname='moreportid';
	}
	$pid=(int)$pid;
	$selects='';
	$sql=$empire->query("select * from {$dbtbpre}enewsmoreport order by pid");
	while($r=$empire->fetch($sql))
	{
		if(!$r['purl'])
		{
			continue;
		}
		$selected='';
		if($pid==$r['pid'])
		{
			$selected=' selected';
		}
		$selects.="<option value='".$r['pid']."'".$selected.">".$r['pname']."</option>";
	}
	$selects="<select name='".$varname."' id='".$varname."'>".$selects."</select>";
	return $selects;
}

//������շ��ʶ�Ŀ¼
function Moreport_hDoSetSelfPath($ecms=0){
	$moreportpid=(int)$_GET['moreportpid'];
	if(!$moreportpid)
	{
		$moreportpid=(int)$_POST['moreportpid'];
	}
	if($moreportpid)
	{
		Moreport_eSetSelfPath($moreportpid,$ecms);
	}
	return $moreportpid;
}

//����moreport����
function Moreport_ReturnUrlCsPid($pid,$ecms=0,$wh=0,$ycs=''){
	$pid=(int)$pid;
	if(!$pid)
	{
		return '';
	}
	if($ecms==1)
	{
		$cs="<input type=hidden name=moreportpid id=moreportpid value='$pid'>";
	}
	else
	{
		$and='&';
		if($wh&&!$ycs)
		{
			$and='?';
		}
		$cs=$and.'moreportpid='.$pid;
	}
	return $cs;
}
?>