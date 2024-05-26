<?php
error_reporting(E_ALL ^ E_NOTICE);

define('InEmpireCMS',TRUE);
define('ECMS_PATH',substr(dirname(__FILE__),0,-7));
define('MAGIC_QUOTES_GPC',function_exists('get_magic_quotes_gpc')&&get_magic_quotes_gpc());
define('STR_IREPLACE',function_exists('str_ireplace'));
define('ECMS_PNO',EcmsGetProgramNo());

$ecms_config=array();
$ecms_adminloginr=array();
$ecms_hashur=array();
$emoreport_r=array();
$public_r=array();
$public_diyr=array();
$emod_pubr=array();
$etable_r=array();
$emod_r=array();
$notcj_r=array();
$fun_r=array();
$message_r=array();
$qmessage_r=array();
$enews_r=array();
$class_r=array();
$class_zr=array();
$class_tr=array();
$eyh_r=array();
$schalltb_r=array();
$level_r=array();
$aglevel_r=array();
$iglevel_r=array();
$r=array();
$addr=array();
$paddr=array();
$search='';
$start=0;
$addgethtmlpath='';
$string='';
$notcjnum=0;
$editor=0;
$ecms_gr=array();
$navinfor=array();
$pagefunr=array();
$navclassid='';
$navnewsid='';
$cjnewsurl='';
$formattxt='';
$link='';
$linkrd='';
$empire='';
$dbtbpre='';
$efileftp='';
$efileftp_fr=array();
$efileftp_dr=array();
$doetran=0;
$ecmsvar_mbr=array();
$ecms_tofunr=array();
$ecms_topager=array();
$ecms_topagesetr=array();
$ecms_toboxr=array();
$add='';
$ecms_config['sets']['selfmoreportid']=0;
$ecms_config['sets']['mainportpath']='';
$ecms_config['sets']['pagemustdt']=0;
$emoreport_r[1]['ppath']='';

require_once ECMS_PATH.'e/config/config.php';

if(!defined('EmpireCMSConfig'))
{
	exit();
}

if($ecms_config['sets']['webdebug']==0)
{
	error_reporting(0);
}

//��ʱ����
if(defined('EmpireCMSAdmin'))
{
	if($public_r['php_adminouttime'])
	{
		@set_time_limit($public_r['php_adminouttime']);
	}
}
else
{
	if($public_r['php_outtime'])
	{
		@set_time_limit($public_r['php_outtime']);
	}
}

//ҳ�����
if($ecms_config['sets']['setpagechar']==1)
{
	if($ecms_config['sets']['pagechar']=='gb2312'||$ecms_config['sets']['pagechar']=='big5'||$ecms_config['sets']['pagechar']=='utf-8')
	{
		@header('Content-Type: text/html; charset='.$ecms_config['sets']['pagechar']);
	}
}

//ʱ��
if(function_exists('date_default_timezone_set'))
{
	@date_default_timezone_set($ecms_config['sets']['timezone']);
}

if($ecms_config['db']['usedb']=='mysqli')
{
	include(ECMS_PATH.'e/class/db/db_mysqli.php');
}
else
{
	include(ECMS_PATH.'e/class/db/db_mysql.php');
}

//��ֹIP
eCheckAccessIp(0);
DoSafeCheckFromurl();

if(defined('EmpireCMSAdmin'))
{
	eCheckAccessIp(1);//��ֹIP
	EcmsCheckUserAgent($ecms_config['esafe']['ckhuseragent']);
	//FireWall
	if(!empty($ecms_config['fw']['eopen']))
	{
		DoEmpireCMSFireWall();
	}
	if(!empty($ecms_config['esafe']['ckhsession']))
	{
		session_start();
		define('EmpireCMSDefSession',TRUE);
	}
}
else
{
	if(!empty($public_r['closeqdt']))
	{
		echo $public_r['closeqdtmsg'];
		exit();
	}
}

if($ecms_config['sets']['selfmoreportid']>1)
{
	EcmsDefMoreport($ecms_config['sets']['selfmoreportid']);
}

//--------------- ���ݿ� ---------------

function db_connect(){
	global $ecms_config;
	$dblink=do_dbconnect($ecms_config['db']['dbserver'],$ecms_config['db']['dbport'],$ecms_config['db']['dbusername'],$ecms_config['db']['dbpassword'],$ecms_config['db']['dbname']);
	return $dblink;
}

function return_dblink($query){
	$dblink=$GLOBALS['link'];
	return $dblink;
}

//���ñ���
function DoSetDbChar($dbchar){
	global $link;
	if($dbchar&&$dbchar!='auto')
	{
		do_DoSetDbChar($dbchar,$link);
	}
}

function db_close(){
	global $link;
	do_dbclose($link);
}


//--------------- ���� ---------------

//����COOKIE
function esetcookie($var,$val,$life=0,$ecms=0){
	global $ecms_config;
	//secure����
	$cksecure=$ecms_config['cks']['cksecure'];
	if(!empty($cksecure))
	{
		$secure=0;
		if($cksecure==2)//����
		{
			$secure=1;
		}
		elseif($cksecure==3)//��̨����
		{
			if(defined('EmpireCMSAdmin'))
			{
				$secure=1;
			}
		}
		elseif($cksecure==4)//ǰ̨����
		{
			if(!defined('EmpireCMSAdmin'))
			{
				$secure=1;
			}
		}
		else
		{}
	}
	else
	{
		$secure=eCheckUseHttps();
	}
	//httponly����
	$ckhttponly=$ecms_config['cks']['ckhttponly'];
	$httponly=0;
	if(!empty($ckhttponly))
	{
		if($ckhttponly==1)//����
		{
			$httponly=1;
		}
		elseif($ckhttponly==2)//��̨����
		{
			if(defined('EmpireCMSAdmin'))
			{
				$httponly=1;
			}
		}
		elseif($ckhttponly==3)//ǰ̨����
		{
			if(!defined('EmpireCMSAdmin'))
			{
				$httponly=1;
			}
		}
		else
		{}
	}
	//����
	$varpre=empty($ecms)?$ecms_config['cks']['ckvarpre']:$ecms_config['cks']['ckadminvarpre'];
	$ckpath=$ecms_config['cks']['ckpath'];
	if(PHP_VERSION<'5.2.0')
	{
		if($httponly)
		{
			$ckpath.='; HttpOnly';
		}
		return setcookie($varpre.$var,$val,$life,$ckpath,$ecms_config['cks']['ckdomain'],$secure);
	}
	else
	{
		return setcookie($varpre.$var,$val,$life,$ckpath,$ecms_config['cks']['ckdomain'],$secure,$httponly);
	}
}

//����cookie
function getcvar($var,$ecms=0){
	global $ecms_config;
	$tvar=empty($ecms)?$ecms_config['cks']['ckvarpre'].$var:$ecms_config['cks']['ckadminvarpre'].$var;
	return $_COOKIE[$tvar];
}

//������ʾ
function printerror($error="",$gotourl="",$ecms=0,$noautourl=0,$novar=0){
	global $empire,$editor,$public_r,$ecms_config;
	if($editor==1){$a="../";}
	elseif($editor==2){$a="../../";}
	elseif($editor==3){$a="../../../";}
	else{$a="";}
	if($ecms==1||$ecms==9)
	{
		$a=ECMS_PATH.'e/data/';
	}
	if(strstr($gotourl,"(")||empty($gotourl))
	{
		if(strstr($gotourl,"(-2"))
		{
			$gotourl_js="history.go(-2)";
			$gotourl="javascript:history.go(-2)";
		}
		else
		{
			$gotourl_js="history.go(-1)";
			$gotourl="javascript:history.go(-1)";
		}
	}
	else
	{$gotourl_js="self.location.href='$gotourl';";}
	if(empty($error))
	{$error="DbError";}
	if($ecms==9)//ǰ̨�����Ի���
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
		echo"<script>alert('".$error."');".$gotourl_js."</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==8)//��̨�����Ի���
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
		echo"<script>alert('".$error."');".$gotourl_js."</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==7)//ǰ̨�����Ի��򲢹رմ���
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
		echo"<script>alert('".$error."');window.close();</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==6)//��̨�����Ի��򲢹رմ���
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
		echo"<script>alert('".$error."');window.close();</script>";
		db_close();
		$empire=null;
		exit();
	}
	elseif($ecms==0)
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
		@include($a."message.php");
	}
	else
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
		@include($a."../message/index.php");
	}
	db_close();
	$empire=null;
	exit();
}

//������ʾ2��ֱ������
function printerror2($error='',$gotourl='',$ecms=0,$noautourl=0){
	global $empire,$public_r;
	if(strstr($gotourl,"(")||empty($gotourl))
	{
		if(strstr($gotourl,"(-2"))
		{
			$gotourl_js="history.go(-2)";
			$gotourl="javascript:history.go(-2)";
		}
		else
		{
			$gotourl_js="history.go(-1)";
			$gotourl="javascript:history.go(-1)";
		}
	}
	else
	{$gotourl_js="self.location.href='$gotourl';";}
	if($ecms==9)//�����Ի���
	{
		echo"<script>alert('".$error."');".$gotourl_js."</script>";
	}
	elseif($ecms==7)//�����Ի��򲢹رմ���
	{
		echo"<script>alert('".$error."');window.close();</script>";
	}
	else
	{
		@include(ECMS_PATH.'e/message/index.php');
	}
	db_close();
	exit();
}

//ajax������ʾ
function ajax_printerror($result='',$ajaxarea='ajaxarea',$error='',$ecms=0,$novar=0){
	global $empire,$editor,$public_r,$ecms_config;
	if($editor==1){$a="../";}
	elseif($editor==2){$a="../../";}
	elseif($editor==3){$a="../../../";}
	else{$a="";}
	if($ecms==1)
	{
		$a=ECMS_PATH.'e/data/';
	}
	if($ecms==0)
	{
		@include $a.LoadLang("pub/message.php");
		$error=empty($novar)?$message_r[$error]:$error;
	}
	else
	{
		@include $a.LoadLang("pub/q_message.php");
		$error=empty($novar)?$qmessage_r[$error]:$error;
	}
	if(empty($ajaxarea))
	{
		$ajaxarea='ajaxarea';
	}
	$ajaxarea=ehtmlspecialchars($ajaxarea,ENT_QUOTES);
	$string=$result.'|'.$ajaxarea.'|'.$error;
	echo $string;
	db_close();
	$empire=null;
	exit();
}

//ֱ��ת��
function printerrortourl($gotourl='',$error='',$sec=0){
	global $empire,$editor,$public_r,$ecms_config;
	echo'<meta http-equiv="refresh" content="'.$sec.';url='.$gotourl.'">'.$error;
	db_close();
	$empire=null;
	exit();
}

//����ת��
function DoIconvVal($code,$targetcode,$str,$inc=0){
	global $editor;
	if($editor==1){$a="../";}
	elseif($editor==2){$a="../../";}
	elseif($editor==3){$a="../../../";}
	else{$a="";}
	if($inc)
	{
		@include_once(ECMS_PATH."e/class/doiconv.php");
	}
	$iconv=new Chinese($a);
	$str=$iconv->Convert($code,$targetcode,$str);
	return $str;
}

//��ʼ�����ʶ�
function EcmsDefMoreport($pid){
	global $public_r,$ecms_config,$emoreport_r;
	if(empty($public_r['ckhavemoreport']))
	{
		exit();
	}
	$pid=(int)$pid;
	if($pid<=1||!$emoreport_r[$pid]['pid'])
	{
		exit();
	}
	if($emoreport_r[$pid]['isclose'])
	{
		echo'This visit port is close!';
		exit();
	}
	//�رպ�̨
	if(defined('EmpireCMSAdmin')&&$emoreport_r[$pid]['openadmin'])
	{
		if($emoreport_r[$pid]['openadmin']==1)
		{
			if(defined('EmpireCMSAPage'))
			{
				//echo'Admin close!';
				exit();
			}
		}
		else
		{
			//echo'Admin close!';
			exit();
		}
	}
	$ecms_config['sets']['deftempid']=$emoreport_r[$pid]['tempgid'];
	$ecms_config['sets']['pagemustdt']=$emoreport_r[$pid]['mustdt'];
	$ecms_config['sets']['mainportpath']=$emoreport_r[1]['ppath'];
	if($emoreport_r[$pid]['closeadd'])
	{
		$public_r['addnews_ok']=$emoreport_r[$pid]['closeadd'];
	}
}

//����Ϊ�����ʶ�ģ����ID
function Moreport_ResetMainTempGid(){
	global $ecms_config,$public_r,$emoreport_r;
	$pid=(int)$ecms_config['sets']['selfmoreportid'];
	if($pid<=1||!$emoreport_r[$pid]['pid'])
	{
		return '';
	}
	$ecms_config['sets']['deftempid']=$public_r['deftempid']?$public_r['deftempid']:1;
}

//ת����ʶ�Ŀ¼
function Moreport_eSetSelfPath($pid,$ecms=0){
	global $empire,$dbtbpre,$public_r,$ecms_config;
	$pid=(int)$pid;
	$defpr=array();
	$defpr['ppath']='';
	if($pid<=1)
	{
		$pid=1;
	}
	$pr=$empire->fetch1("select * from {$dbtbpre}enewsmoreport where pid='$pid'");
	if(!$pr['ppath']||!file_exists($pr['ppath'].'e/config/config.php'))
	{
		return $defpr;
	}
	define('ECMS_SELFPATH',$pr['ppath']);
	$ecms_config['sets']['deftempid']=$pr['tempgid'];
	//����ģ��
	if($ecms==1)
	{
		$tr=$empire->fetch1("select downsofttemp,onlinemovietemp,listpagetemp from ".GetTemptb("enewspubtemp")." limit 1");
		$public_r['downsofttemp']=addslashes(stripSlashes($tr['downsofttemp']));
		$public_r['onlinemovietemp']=addslashes(stripSlashes($tr['onlinemovietemp']));
		$public_r['listpagetemp']=addslashes(stripSlashes($tr['listpagetemp']));
	}
	return $pr;
}

//autodo
function eAutodo_AddDo($dotype,$classid,$id,$tid,$userid,$pid,$fname='',$ckdoall=1){
	return '';
}

//�����Ƿ�ǿ�ƶ�̬ҳ
function Moreport_ReturnMustDt(){
	global $ecms_config;
	return $ecms_config['sets']['pagemustdt'];
}

//�����Ƿ�ǿ�ƶ�̬ҳ(��״̬)
function Moreport_ReturnMustDtAnd(){
	global $ecms_config;
	if(defined('ECMS_SELFPATH')&&$ecms_config['sets']['pagemustdt'])
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

//����ǿ�ƶ�̬ҳ״̬
function Moreport_ReturnDtStatus($dt){
	global $ecms_config;
	if($ecms_config['sets']['pagemustdt'])
	{
		return 1;
	}
	else
	{
		return $dt;
	}
}

//��������ҳ��ַ(���ʶ�)
function Moreport_ReturnTitleUrl($classid,$id){
		$rewriter=eReturnRewriteInfoUrl($classid,$id,1);
		$titleurl=$rewriter['pageurl'];
		return $titleurl;
}

//������Ŀҳ��ַ(���ʶ�)
function Moreport_ReturnClassUrl($classid){
	global $public_r,$class_r;
	if($class_r[$classid]['wburl'])
	{
		$classurl=$class_r[$classid]['wburl'];
	}
	else
	{
		$rewriter=eReturnRewriteClassUrl($classid,1);
		$classurl=$rewriter['pageurl'];
	}
	return $classurl;
}

//���ر������ҳ��ַ(���ʶ�)
function Moreport_ReturnInfoTypeUrl($typeid){
	$rewriter=eReturnRewriteTitleTypeUrl($typeid,1);
	$url=$rewriter['pageurl'];
	return $url;
}

//������ҳ��ַ(���ʶ�)
function Moreport_ReturnIndexUrl(){
	global $public_r;
	$file=$public_r['newsurl'].'index.php';
	return $file;
}

//���ݱ�ŷ���ģ�����
function eTnoGetTempTbname($no){
	if($no==1)//��ǩģ��
	{
		$temptb='enewsbqtemp';
	}
	elseif($no==2)//JSģ��
	{
		$temptb='enewsjstemp';
	}
	elseif($no==3)//�б�ģ��
	{
		$temptb='enewslisttemp';
	}
	elseif($no==4)//����ģ��
	{
		$temptb='enewsnewstemp';
	}
	elseif($no==5)//����ģ��
	{
		$temptb='enewspubtemp';
	}
	elseif($no==6)//����ģ��
	{
		$temptb='enewssearchtemp';
	}
	elseif($no==7)//ģ�����
	{
		$temptb='enewstempvar';
	}
	elseif($no==8)//ͶƱģ��
	{
		$temptb='enewsvotetemp';
	}
	elseif($no==9)//����ģ��
	{
		$temptb='enewsclasstemp';
	}
	elseif($no==10)//����ģ��
	{
		$temptb='enewspltemp';
	}
	elseif($no==11)//��ӡģ��
	{
		$temptb='enewsprinttemp';
	}
	elseif($no==12)//�Զ���ҳ��ģ��
	{
		$temptb='enewspagetemp';
	}
	else
	{
		$temptb='';
	}
	return $temptb;
}

//ģ���ת��
function GetTemptb($temptb){
	global $public_r,$ecms_config,$dbtbpre;
	if(!empty($ecms_config['sets']['deftempid']))
	{
		$tempid=$ecms_config['sets']['deftempid'];
	}
	else
	{
		$tempid=$public_r['deftempid'];
	}
	if(!empty($tempid)&&$tempid!=1)
	{
		$en="_".$tempid;
	}
	return $dbtbpre.$temptb.$en;
}

//���ز���ģ���
function GetDoTemptb($temptb,$gid){
	global $dbtbpre;
	if(!empty($gid)&&$gid!=1)
	{
		$en="_".$gid;
	}
	return $dbtbpre.$temptb.$en;
}

//���ص�ǰʹ��ģ����ID
function GetDoTempGid(){
	global $ecms_config,$public_r;
	if($ecms_config['sets']['deftempid'])
	{
		$gid=$ecms_config['sets']['deftempid'];
	}
	elseif($public_r['deftempid'])
	{
		$gid=$public_r['deftempid'];
	}
	else
	{
		$gid=1;
	}
	return $gid;
}

//�������԰�
function LoadLang($file){
	global $ecms_config;
	return "../data/language/".$ecms_config['sets']['elang']."/".$file;
}

//ȡ��IP
function egetip(){
	global $ecms_config;
	if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')) 
	{
		$ip=getenv('HTTP_CLIENT_IP');
	} 
	elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown'))
	{
		$ip=getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown'))
	{
		$ip=getenv('REMOTE_ADDR');
	}
	elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown'))
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	if($ecms_config['sets']['getiptype']>0)
	{
		$ip=egetipadd();
	}
	$ip=RepPostVar(preg_replace("/^([\d\.]+).*/","\\1",$ip));
	return $ip;
}

//ȡ��IP����
function egetipadd(){
	global $ecms_config;
	if($ecms_config['sets']['getiptype']==2)
	{
		$ip=getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif($ecms_config['sets']['getiptype']==3)
	{
		$ip=getenv('HTTP_CLIENT_IP');
	}
	else
	{
		$ip=getenv('REMOTE_ADDR');
	}
	return $ip;
}

//ȡ�ö˿�
function egetipport(){
	$ipport=(int)$_SERVER['REMOTE_PORT'];
	return $ipport;
}

//����ַ
function ecms_eCheckNotUrl($str){
	if(stristr($str,'/')||stristr($str,':')||stristr($str,"\\")||stristr($str,'&')||stristr($str,'?')||stristr($str,'#')||stristr($str,'@')||stristr($str,'"')||stristr($str,"'")||stristr($str,'%'))
	{
		exit();
	}
	return $str;
}

//������Դ��ַ
function EcmsGetReturnUrl(){
	global $public_r;
	$from=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:$public_r['newsurl'];
	return RepPostStrUrl($from);
}

//checkdomain
function eToCheckThisDomain($url){
	$domain=eReturnDomain();
	if(!stristr($url,$domain))
	{
		exit();
	}
	if(eCheckHaveReStr($url,'://'))
	{
		exit();
	}
}

//checkotherurl
function eCheckOtherViewUrl($url,$havevar=0,$ecms=0){
	//fromurl
	if($ecms==1)
	{
		$fromurl=$_SERVER['HTTP_REFERER'];
		if(!$fromurl)
		{
			exit();
		}
		eToCheckThisDomain($fromurl);
	}
	if(!$url)
	{
		exit();
	}
	$url=RepPostStrUrl($url);
	if(!$havevar)
	{
		if(stristr($url,'?')||stristr($url,'&')||stristr($url,'#'))
		{
			exit();
		}
	}
	//url
	if(stristr($url,'://'))
	{
		eToCheckThisDomain($url);
	}
	else
	{
		if(stristr($str,':')||stristr($str,"\\")||stristr($str,'"')||stristr($str,"'"))
		{
			exit();
		}
	}
}

//checkrestr
function eCheckHaveReStr($str,$exp){
	$r=explode($exp,$str);
	if(count($r)>2)
	{
		return 1;
	}
	return 0;
}

//checkurl
function eToCheckIsUrl($url){
	$r=explode('://',$url);
	return eCheckStrType(2,$r[0],0);
}

//checkurl2
function eToCheckIsUrl2($url){
	if(substr($url,0,4)=='http')
	{
		return 1;
	}
	return 0;
}

//checkstrtype
function eCheckStrType($type,$str,$doing=0){
	$ret=0;
	if($type==1)//����
	{
		if(preg_match('/^[0-9]+$/',$str))
		{
			$ret=1;
		}
	}
	elseif($type==2)//��ĸ
	{
		if(preg_match('/^[A-Za-z]+$/',$str))
		{
			$ret=1;
		}
	}
	elseif($type==3)//��ĸ+����
	{
		if(preg_match('/^[A-Za-z0-9]+$/',$str))
		{
			$ret=1;
		}
	}
	elseif($type==4)//��ĸ+����+�»���
	{
		if(preg_match('/^[A-Za-z0-9_]+$/',$str))
		{
			$ret=1;
		}
	}
	elseif($type==5)//��ĸ+����+�»���+��
	{
		if(preg_match('/^[A-Za-z0-9\-\._]+$/',$str))
		{
			$ret=1;
		}
	}
	else
	{
		$ret=0;
	}
	if($doing)
	{
		if($ret<1)
		{
			exit();
		}
	}
	return $ret;
}

//���ص�ַ
function DoingReturnUrl($url,$from=''){
	if(empty($from))
	{
		return RepPostStrUrl($url);
	}
	elseif($from==9)
	{
		$from=$_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:$url;
	}
	return RepPostStrUrl($from);
}

//htmlspecialchars����
function ehtmlspecialchars($val,$flags=ENT_COMPAT){
	global $ecms_config;
	if(PHP_VERSION>='5.4.0')
	{
		if($ecms_config['sets']['pagechar']=='utf-8')
		{
			$char='UTF-8';
		}
		else
		{
			$char='ISO-8859-1';
		}
		$val=htmlspecialchars($val,$flags,$char);
	}
	else
	{
		$val=htmlspecialchars($val,$flags);
	}
	return $val;
}

//addslashes����
function eaddslashes($val,$ckmq=1){
	if($ckmq==1&&MAGIC_QUOTES_GPC)
	{
		return $val;
	}
	$val=addslashes($val);
	return $val;
}

//addslashes����
function eaddslashes2($val,$ckmq=1){
	if($ckmq==1&&MAGIC_QUOTES_GPC)
	{
		return addslashes($val);
	}
	$val=addslashes(addslashes($val));
	return $val;
}

//stripSlashes����
function estripSlashes($val,$ckmq=1){
	if($ckmq==1&&!MAGIC_QUOTES_GPC)
	{
		return $val;
	}
	$val=stripSlashes($val);
	return $val;
}

//stripSlashes����
function estripSlashes2($val,$ckmq=1){
	if($ckmq==1&&!MAGIC_QUOTES_GPC)
	{
		return stripSlashes($val);
	}
	$val=stripSlashes(stripSlashes($val));
	return $val;
}

//���������ʹ���
function RepPIntvar($val){
	$val=intval($val);
	if($val<0)
	{
		$val=0;
	}
	return $val;
}

//����������
function RepPostVar($val){
	if($val!=addslashes($val))
	{
		exit();
	}
	CkPostStrChar($val);
	$val=str_replace("%","",$val);
	$val=str_replace(" ","",$val);
	$val=str_replace("`","",$val);
	$val=str_replace("\t","",$val);
	$val=str_replace("%20","",$val);
	$val=str_replace("%27","",$val);
	$val=str_replace("*","",$val);
	$val=str_replace("'","",$val);
	$val=str_replace("\"","",$val);
	$val=str_replace("/","",$val);
	$val=str_replace(";","",$val);
	$val=str_replace("#","",$val);
	$val=str_replace("--","",$val);
	$val=RepPostStr($val,1);
	$val=addslashes($val);
	//FireWall
	FWClearGetText($val);
	return $val;
}

//����������2
function RepPostVar2($val){
	if($val!=addslashes($val))
	{
		exit();
	}
	CkPostStrChar($val);
	$val=str_replace("%","",$val);
	$val=str_replace("`","",$val);
	$val=str_replace("\t","",$val);
	$val=str_replace("%20","",$val);
	$val=str_replace("%27","",$val);
	$val=str_replace("*","",$val);
	$val=str_replace("'","",$val);
	$val=str_replace("\"","",$val);
	$val=str_replace("/","",$val);
	$val=str_replace(";","",$val);
	$val=str_replace("#","",$val);
	$val=str_replace("--","",$val);
	$val=RepPostStr($val,1);
	$val=addslashes($val);
	//FireWall
	FWClearGetText($val);
	return $val;
}

//����������3
function RepPostVar3($val){
	if($val!=addslashes($val))
	{
		exit();
	}
	CkPostStrChar($val);
	$val=str_replace("%","",$val);
	$val=str_replace("`","",$val);
	$val=str_replace("\t","",$val);
	$val=str_replace("%20","",$val);
	$val=str_replace("%27","",$val);
	$val=str_replace("*","",$val);
	$val=str_replace("'","",$val);
	$val=str_replace("\"","",$val);
	//$val=str_replace("/","",$val);
	$val=str_replace(";","",$val);
	$val=str_replace("#","",$val);
	$val=str_replace("--","",$val);
	$val=RepPostStr($val,1);
	$val=addslashes($val);
	//FireWall
	FWClearGetText($val);
	return $val;
}

//��֤�����ַ�
function CkPostStrCharYh($val){
	if($val!=addslashes($val))
	{
		exit();
	}
	return $val;
}

//�����ύ�ַ�
function RepPostStr($val,$ecms=0,$phck=0){
	if($phck==1)
	{
		CkPostStrCharYh($val);
	}
	$val=ehtmlspecialchars($val,ENT_QUOTES);
	if($ecms==0)
	{
		CkPostStrChar($val);
		$val=AddAddsData($val);
		//FireWall
		FWClearGetText($val);
	}
	return $val;
}

//�����ύ�ַ�2
function RepPostStr2($val,$phck=0){
	if($phck==1)
	{
		CkPostStrCharYh($val);
	}
	CkPostStrChar($val);
	$val=AddAddsData($val);
	//FireWall
	FWClearGetText($val);
	return $val;
}

//�����ַ
function RepPostStrUrl($val,$phck=0){
	$val=str_replace('&amp;','&',RepPostStr($val,1,$phck));
	return $val;
}

//�������ݴ���
function dgdb_tosave($val,$phck=0){
	$val=RepPostStr($val,0,$phck);
	$val=addslashes($val);
	return $val;
}

//�������ݴ���(url)
function dgdb_tosaveurl($val,$phck=0){
	$val=RepPostStr($val,0,$phck);
	$val=str_replace('&amp;','&',$val);
	$val=addslashes($val);
	return $val;
}

//������ʾ
function dgdb_toshow($val){
	$val=stripSlashes($val);
	return $val;
}

//������ʾ�ַ�
function eDoRepShowStr($val,$isurl=0){
	$val=ehtmlspecialchars($val,ENT_QUOTES);
	if($isurl==1)
	{
		$val=str_replace('&amp;','&',$val);
	}
	return $val;
}

//������ͨ�ַ�
function eDoRepPostComStr($val,$isurl=0){
	$val=ehtmlspecialchars($val,ENT_QUOTES);
	if($isurl==1)
	{
		$val=str_replace('&amp;','&',$val);
	}
	return $val;
}

//�����ύ�ַ�
function hRepPostStr($val,$ecms=0,$phck=0){
	if($phck==1)
	{
		CkPostStrCharYh($val);
	}
	if($ecms==1)
	{
		$val=ehtmlspecialchars($val,ENT_QUOTES);
	}
	CkPostStrChar($val);
	$val=AddAddsData($val);
	return $val;
}

//�����ύ�ַ�2
function hRepPostStr2($val,$phck=0){
	if($phck==1)
	{
		CkPostStrCharYh($val);
	}
	CkPostStrChar($val);
	$val=AddAddsData($val);
	return $val;
}

//��������ַ�
function CkPostStrChar($val){
	if(substr($val,-1)=="\\")
	{
		exit();
	}
}

//����ת��
function egetzy($n='2'){
	if($n=='rn')
	{
		$str="\r\n";
	}
	elseif($n=='n')
	{
		$str="\n";
	}
	elseif($n=='r')
	{
		$str="\r";
	}
	elseif($n=='t')
	{
		$str="\t";
	}
	elseif($n=='syh')
	{
		$str="\\\"";
	}
	elseif($n=='dyh')
	{
		$str="\'";
	}
	else
	{
		for($i=0;$i<$n;$i++)
		{
			$str.="\\";
		}
	}
	return $str;
}

//��֤�ַ��Ƿ��
function CheckValEmpty($val){
	return strlen($val)==0?1:0;
}

//����ID�б�
function eReturnInids($ids){
	if(empty($ids))
	{
		return 0;
	}
	$dh='';
	$retids='';
	$r=explode(',',$ids);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$r[$i];
		if(!$id)
		{
			continue;
		}
		$retids.=$dh.$id;
		$dh=',';
	}
	if(empty($retids))
	{
		return 0;
	}
	return $retids;
}

//���鷵��ID�б�
function eArrayReturnInids($r){
	$count=count($r);
	if(!$count)
	{
		return 0;
	}
	$dh='';
	$retids='';
	for($i=0;$i<$count;$i++)
	{
		$id=(int)$r[$i];
		if(!$id)
		{
			continue;
		}
		$retids.=$dh.$id;
		$dh=',';
	}
	if(empty($retids))
	{
		return 0;
	}
	return $retids;
}

//���ظ���ĿID�б�
function eReturnInFcids($featherclass){
	if(!$featherclass||$featherclass=='|')
	{
		return 0;
	}
	$cids='';
	$cdh='';
	$fcr=explode('|',$featherclass);
	$fcount=count($fcr);
	for($fi=1;$fi<$fcount-1;$fi++)
	{
		$fcr[$fi]=(int)$fcr[$fi];
		if(!$fcr[$fi])
		{
			continue;
		}
		$cids.=$cdh.$fcr[$fi];
		$cdh=',';
	}
	if(empty($cids))
	{
		return 0;
	}
	return $cids;
}

//�������б�
function eReturnSetGroups($groupid,$isnum=1){
	$count=count($groupid);
	if($count==0)
	{
		return '';
	}
	$ids=',';
	for($i=0;$i<$count;$i++)
	{
		if($isnum==1)
		{
			$groupid[$i]=(int)$groupid[$i];
		}
		$ids.=$groupid[$i].',';
	}
	return $ids;
}

//ȡ�ñ����ģ��ID
function eGetTableModids($tid,$tbname){
	global $empire,$dbtbpre;
	$mids='';
	$where=$tid?"tid='$tid'":"tbname='$tbname'";
	$sql=$empire->query("select mid from {$dbtbpre}enewsmod where ".$where);
	while($r=$empire->fetch($sql))
	{
		$mids.=$dh.$r['mid'];
		$dh=',';
	}
	if(empty($mids))
	{
		$mids=0;
	}
	return $mids;
}

//�滻ģ������ַ�
function RepTempvarPostStr($val){
	$val=str_replace('[!--','[!---',$val);
	return $val;
}

//�滻ģ������ַ�
function RepTempvarPostStrT($val,$ispagef=0){
	if($ispagef==1)
	{
		$val=str_replace('[!--empirenews.page--]','[!!!-empirecms.page-!!]',$val);
	}
	$val=str_replace('[!--','&#091;!--',$val);
	if($ispagef==1)
	{
		$val=str_replace('[!!!-empirecms.page-!!]','[!--empirenews.page--]',$val);
	}
	return $val;
}

//ȡ���ļ���չ��
function GetFiletype($filename){
	$filer=explode(".",$filename);
	$count=count($filer)-1;
	return strtolower(".".RepGetFiletype($filer[$count]));
}

function RepGetFiletype($filetype){
	$filetype=str_replace('|','_',$filetype);
	$filetype=str_replace(',','_',$filetype);
	$filetype=str_replace('.','_',$filetype);
	return $filetype;
}

//ȡ���ļ���
function GetFilename($filename){
	if(strstr($filename,"\\"))
	{
		$exp="\\";
	}
	else
	{
		$exp='/';
	}
	$filer=explode($exp,$filename);
	$count=count($filer)-1;
	return $filer[$count];
}

//����Ŀ¼����
function eReturnCPath($path,$ypath=''){
	if(strstr($path,'..')||strstr($path,"\\")||strstr($path,'%')||strstr($path,':'))
	{
		return $ypath;
	}
	return $path;
}

//��֤�ļ�����ʽ����
function eReturnCkCFile($path){
	if(strstr($path,'..')||strstr($path,"\\")||strstr($path,'/')||strstr($path,'%')||strstr($path,':'))
	{
		return 0;
	}
	return 1;
}

//�ַ���ȡ����
function sub($string,$start=0,$length,$mode=false,$dot='',$rephtml=0){
	global $ecms_config;
	$strlen=strlen($string);
	if($strlen<=$length)
	{
		return $string;
	}

	if($rephtml==0)
	{
		$string = str_replace(array('&nbsp;','&amp;','&quot;','&lt;','&gt;','&#039;'), array(' ','&','"','<','>',"'"), $string);
	}

	$strcut = '';
	if(strtolower($ecms_config['sets']['pagechar']) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < $strlen) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	if($rephtml==0)
	{
		$strcut = str_replace(array('&','"','<','>',"'"), array('&amp;','&quot;','&lt;','&gt;','&#039;'), $strcut);
	}

	return $strcut.$dot;
}

//��ȡ����
function esub($string,$length,$dot='',$rephtml=0){
	return sub($string,0,$length,false,$dot,$rephtml);
}

//ȡ�������
function make_password($pw_length){
	$low_ascii_bound=48;
	$upper_ascii_bound=122;
	$notuse=array(58,59,60,61,62,63,64,91,92,93,94,95,96);
	while($i<$pw_length)
	{
		if(PHP_VERSION<'4.2.0')
		{
			mt_srand((double)microtime()*1000000);
		}
		mt_srand();
		$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
		if(!in_array($randnum,$notuse))
		{
			$password1=$password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}

//ȡ�������(����)
function no_make_password($pw_length){
	$low_ascii_bound=48;
	$upper_ascii_bound=57;
	$notuse=array(58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
	while($i<$pw_length)
	{
		if(PHP_VERSION<'4.2.0')
		{
			mt_srand((double)microtime()*1000000);
		}
		mt_srand();
		$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
		if(!in_array($randnum,$notuse))
		{
			$password1=$password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}

//ȡ�������(��ĸ)
function abc_make_password($pw_length){
	$low_ascii_bound=65;
	$upper_ascii_bound=122;
	$notuse=array(91,92,93,94,95,96);
	while($i<$pw_length)
	{
		if(PHP_VERSION<'4.2.0')
		{
			mt_srand((double)microtime()*1000000);
		}
		mt_srand();
		$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
		if(!in_array($randnum,$notuse))
		{
			$password1=$password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}

//programno
function EcmsGetProgramNo(){
	$r=explode(' ',microtime());
	$pno=$r[1].$r[0];
	return $pno;
}

//�������
function EcmsRandInt($min=0,$max=0,$ecms=0){
	mt_srand();
	if($max)
	{
		$rnd=mt_rand($min,$max);
	}
	else
	{
		$rnd=mt_rand();
	}
	return $rnd;
}

//��ɫתRGB
function ToReturnRGB($rgb){
	$rgb=str_replace('#','',ehtmlspecialchars($rgb));
    return array(
        base_convert(substr($rgb,0,2),16,10),
        base_convert(substr($rgb,2,2),16,10),
        base_convert(substr($rgb,4,2),16,10)
    );
}

//��֤ҳ���Ƿ���Ч
function eCheckListPageNo($page,$line,$totalnum){
	$page=(int)$page;
	$line=(int)$line;
	$totalnum=(int)$totalnum;
	if(!$page)
	{
		return '';
	}
	if(!$line)
	{
		return '';
	}
	$totalpage=ceil($totalnum/$line);
	if($page>=$totalpage)
	{
		printerror('ErrorUrl','history.go(-1)',1);
	}
}

//ǰ̨��ҳ
function page1($num,$line,$page_line,$start,$page,$search){
	global $fun_r;
	$num=(int)$num;
	$line=(int)$line;
	$page_line=(int)$page_line;
	$start=(int)$start;
	$page=(int)$page;
	if($num<=$line)
	{
		return '';
	}
	$search=RepPostStr($search,1);
	$url=eReturnSelfPage(0).'?page';
	$snum=2;//��Сҳ��
	$totalpage=ceil($num/$line);//ȡ����ҳ��
	$firststr='<a title="'.$fun_r['trecord'].'">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;';
	//��һҳ
	if($page<>0)
	{
		$toppage='<a href="'.$url.'=0'.$search.'">'.$fun_r['startpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		$prepage='<a href="'.$url.'='.$pagepr.$search.'">'.$fun_r['pripage'].'</a>';
	}
	//��һҳ
	if($page!=$totalpage-1)
	{
		$pagenex=$page+1;
		$nextpage='&nbsp;<a href="'.$url.'='.$pagenex.$search.'">'.$fun_r['nextpage'].'</a>';
		$lastpage='&nbsp;<a href="'.$url.'='.($totalpage-1).$search.'">'.$fun_r['lastpage'].'</a>';
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
	return $returnstr;
}

//---------- α��̬ ----------

//��������α��̬
function eReturnRewriteInfoUrl($classid,$id,$ecms=0){
	global $public_r;
	if(empty($public_r['rewriteinfo']))
	{
		$r['pageurl']=$public_r['newsurl']."e/action/ShowInfo.php?classid=$classid&id=$id";
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--classid--]','[!--id--]','[!--page--]'),array($classid,$id,0),$public_r['rewriteinfo']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--classid--]','[!--id--]'),array($classid,$id),$public_r['rewriteinfo']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//������Ŀ�б�α��̬
function eReturnRewriteClassUrl($classid,$ecms=0){
	global $public_r;
	if(empty($public_r['rewriteclass']))
	{
		$r['pageurl']=$public_r['newsurl']."e/action/ListInfo/?classid=$classid";
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--classid--]','[!--page--]'),array($classid,0),$public_r['rewriteclass']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace('[!--classid--]',$classid,$public_r['rewriteclass']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//���ر�������б�α��̬
function eReturnRewriteTitleTypeUrl($ttid,$ecms=0){
	global $public_r;
	if(empty($public_r['rewriteinfotype']))
	{
		$r['pageurl']=$public_r['newsurl']."e/action/InfoType/?ttid=$ttid";
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--ttid--]','[!--page--]'),array($ttid,0),$public_r['rewriteinfotype']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace('[!--ttid--]',$ttid,$public_r['rewriteinfotype']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//����TAGS�б�α��̬
function eReturnRewriteTagsUrl($tagid,$tagname,$ecms=0){
	global $public_r;
	$tagname=urlencode($tagname);
	if(empty($public_r['rewritetags']))
	{
		$r['pageurl']=$public_r['newsurl']."e/tags/?tagname=".$tagname;
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--tagname--]','[!--page--]'),array($tagname,0),$public_r['rewritetags']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace('[!--tagname--]',$tagname,$public_r['rewritetags']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//���������б�α��̬
function eReturnRewritePlUrl($classid,$id,$doaction='doinfo',$myorder=0,$tempid=0,$ecms=0){
	global $public_r;
	if(empty($public_r['rewritepl']))
	{
		if($doaction=='dozt')
		{
			$r['pageurl']=$public_r['plurl']."?doaction=dozt&classid=$classid".($myorder?'&myorder='.$myorder:'').($tempid?'&tempid='.$tempid:'');
		}
		else
		{
			$r['pageurl']=$public_r['plurl']."?classid=$classid&id=$id".($myorder?'&myorder='.$myorder:'').($tempid?'&tempid='.$tempid:'');
		}
		$r['rewrite']=0;
	}
	else
	{
		if($ecms==1)
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--doaction--]','[!--classid--]','[!--id--]','[!--page--]','[!--myorder--]','[!--tempid--]'),array($doaction,$classid,$id,0,$myorder,$tempid),$public_r['rewritepl']);
		}
		else
		{
			$r['pageurl']=$public_r['newsurl'].str_replace(array('[!--doaction--]','[!--classid--]','[!--id--]','[!--myorder--]','[!--tempid--]'),array($doaction,$classid,$id,$myorder,$tempid),$public_r['rewritepl']);
		}
		$r['rewrite']=1;
	}
	return $r;
}

//α��̬���ӵ�ַ��ת
function eReturnRewriteLink($type,$classid,$id){
	if($type=='infopage')//��Ϣҳ
	{
		$url=eReturnRewriteInfoUrl($classid,$id);
	}
	elseif($type=='ttpage')//�������ҳ
	{
		$url=eReturnRewriteTitleTypeUrl($classid);
	}
	elseif($type=='tagspage')//Tags�б�ҳ
	{
		$url=eReturnRewriteTagsUrl($classid,$id);
	}
	else//��Ŀҳ
	{
		$url=eReturnRewriteClassUrl($classid);
	}
	return $url;
}

//α��̬�滻��ҳ��
function eReturnRewritePageLink($r,$page){
	//����
	$truepage=$page+1;
	if($r['repagenum']&&$truepage<=$r['repagenum'])
	{
		//�ļ���
		if(empty($r['dofile']))
		{
			$r['dofile']='index';
		}
		$url=$r['dolink'].$r['dofile'].($truepage==1?'':'_'.$truepage).$r['dotype'];
		return $url;
	}
	if($r['rewrite']==1)
	{
		$url=str_replace('[!--page--]',$page,$r['pageurl']);
	}
	else
	{
		$url=$r['pageurl'].'&page='.$page;
	}
	return $url;
}

//α��̬�滻��ҳ��(��̬)
function eReturnRewritePageLink2($r,$page){
	if($r['rewrite']==1)
	{
		$url=str_replace('[!--page--]',$page-1,$r['pageurl']);
	}
	else
	{
		$url=$r['pageurl'].'&page='.($page-1);
	}
	return $url;
}

//ǰ̨��ҳ(α��̬)
function InfoUsePage($num,$line,$page_line,$start,$page,$search,$add){
	global $fun_r;
	$num=(int)$num;
	$line=(int)$line;
	$page_line=(int)$page_line;
	$start=(int)$start;
	$page=(int)$page;
	if($num<=$line)
	{
		return '';
	}
	$search=RepPostStr($search,1);
	$snum=2;//��Сҳ��
	$totalpage=ceil($num/$line);//ȡ����ҳ��
	$firststr='<a title="'.$fun_r['trecord'].'">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;';
	//��һҳ
	if($page<>0)
	{
		$toppage='<a href="'.eReturnRewritePageLink($add,0).'">'.$fun_r['startpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		$prepage='<a href="'.eReturnRewritePageLink($add,$pagepr).'">'.$fun_r['pripage'].'</a>';
	}
	//��һҳ
	if($page!=$totalpage-1)
	{
		$pagenex=$page+1;
		$nextpage='&nbsp;<a href="'.eReturnRewritePageLink($add,$pagenex).'">'.$fun_r['nextpage'].'</a>';
		$lastpage='&nbsp;<a href="'.eReturnRewritePageLink($add,$totalpage-1).'">'.$fun_r['lastpage'].'</a>';
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
			$is_1='<a href="'.eReturnRewritePageLink($add,$i).'">';
			$is_2="</a>";
		}
		$pagenum=$i+1;
		$returnstr.="&nbsp;".$is_1.$pagenum.$is_2;
	}
	$returnstr=$firststr.$toppage.$prepage.$returnstr.$nextpage.$lastpage;
	return $returnstr;
}

//ʱ��ת������
function to_time($datetime){
	if(strlen($datetime)==10)
	{
		$datetime.=" 00:00:00";
	}
	$r=explode(" ",$datetime);
	$t=explode("-",$r[0]);
	$k=explode(":",$r[1]);
	$dbtime=@mktime($k[0],$k[1],$k[2],$t[1],$t[2],$t[0]);
	return intval($dbtime);
}

//ʱ��ת����
function date_time($time,$format="Y-m-d H:i:s"){
	$threadtime=date($format,$time);
	return $threadtime;
}

//��ʽ������
function format_datetime($newstime,$format){
	if($newstime=="0000-00-00 00:00:00")
	{return $newstime;}
	$time=is_numeric($newstime)?$newstime:to_time($newstime);
	$newdate=date_time($time,$format);
	return $newdate;
}

//ʱ��ת������
function to_date($date){
	$date.=" 00:00:00";
	$r=explode(" ",$date);
	$t=explode("-",$r[0]);
	$k=explode(":",$r[1]);
	$dbtime=@mktime($k[0],$k[1],$k[2],$t[1],$t[2],$t[0]);
	return intval($dbtime);
}

//ѡ��ʱ��
function ToChangeTime($time,$day){
	$truetime=$time-$day*24*3600;
	$date=date_time($truetime,"Y-m-d");
	return $date;
}

//ɾ���ļ�
function DelFiletext($filename){
	@unlink($filename);
}

//ȡ���ļ�����
function ReadFiletext($filepath){
	$filepath=trim($filepath);
	$ishttp=0;
	if(strstr($filepath,'://'))
	{
		if(!eToCheckIsUrl2($filepath))
		{
			return '';
		}
		$ishttp=1;
	}
	$htmlfp=@fopen($filepath,"r");
	//Զ��
	if($ishttp==1)
	{
		while($data=@fread($htmlfp,500000))
	    {
			$string.=$data;
		}
	}
	//����
	else
	{
		$string=@fread($htmlfp,@filesize($filepath));
	}
	@fclose($htmlfp);
	return $string;
}

//д�ļ�
function WriteFiletext($filepath,$string){
	global $public_r;
	$string=stripSlashes($string);
	$fp=@fopen($filepath,"w");
	@fputs($fp,$string);
	@fclose($fp);
	if(empty($public_r[filechmod]))
	{
		@chmod($filepath,0777);
	}
}

//д�ļ�
function WriteFiletext_n($filepath,$string){
	global $public_r;
	$fp=@fopen($filepath,"w");
	@fputs($fp,$string);
	@fclose($fp);
	if(empty($public_r[filechmod]))
	{
		@chmod($filepath,0777);
	}
}

//�������Ժ�
function DoTitleFont($titlefont,$title){
	if(empty($titlefont))
	{
		return $title;
	}
	$r=explode(',',$titlefont);
	if(!empty($r[0]))
	{
		$title="<font color='".$r[0]."'>".$title."</font>";
	}
	if(empty($r[1]))
	{return $title;}
	//����
	if(strstr($r[1],"b"))
	{$title="<strong>".$title."</strong>";}
	//б��
	if(strstr($r[1],"i"))
	{$title="<i>".$title."</i>";}
	//ɾ����
	if(strstr($r[1],"s"))
	{$title="<s>".$title."</s>";}
	return $title;
}

//����ͷ����������Ȩ��
function ReturnFirsttitleNameCkLevel($r,$groupid,$classid){
	if(defined('EmpireCMSAdmin'))
	{
		if($r['groupid'])
		{
			if(!strstr($r['groupid'],','.$groupid.','))
			{
				return 0;
			}
		}
	}
	if($classid)
	{
		if($r['showcid'])
		{
			if(!strstr($r['showcid'],','.$classid.','))
			{
				return 0;
			}
		}
		if($r['hiddencid'])
		{
			if(strstr($r['hiddencid'],','.$classid.','))
			{
				return 0;
			}
		}
	}
	else
	{
		if($r['showall']==1)
		{
			return 0;
		}
	}
	return 1;
}

//����ͷ����������
function ReturnFirsttitleNameList($firsttitle,$isgood){
	global $empire,$dbtbpre,$lur,$classid,$class_r;
	$classid=(int)$classid;
	if($classid&&!$class_r[$classid]['islast'])
	{
		$classid=0;
	}
	$groupid=(int)$lur['groupid'];
	$first_r=array();//ͷ��
	$ftn='';
	$good_r=array();//�Ƽ�
	$gn='';
	$sql=$empire->query("select tname,ttype,levelid,groupid,showall,showcid,hiddencid from {$dbtbpre}enewsgoodtype order by myorder desc,levelid");
	while($r=$empire->fetch($sql))
	{
		if($r['ttype']==1)//ͷ��
		{
			$first_r[$r['levelid']]=$r['tname'];
			$selected='';
			if($r['levelid']==$firsttitle)
			{
				$selected=' selected';
			}
			if(ReturnFirsttitleNameCkLevel($r,$groupid,$classid))
			{
				$ftn.='<option value="'.$r['levelid'].'"'.$selected.'>'.$r['tname'].'</option>';
			}
		}
		else//�Ƽ�
		{
			$good_r[$r['levelid']]=$r['tname'];
			$selected='';
			if($r['levelid']==$isgood)
			{
				$selected=' selected';
			}
			if(ReturnFirsttitleNameCkLevel($r,$groupid,$classid))
			{
				$gn.='<option value="'.$r['levelid'].'"'.$selected.'>'.$r['tname'].'</option>';
			}
		}
	}
	$ret_r['ftname']=$ftn;
	$ret_r['ftr']=$first_r;
	$ret_r['igname']=$gn;
	$ret_r['igr']=$good_r;
	return $ret_r;
}

//�滻ȫ�Ƕ���
function DoReplaceQjDh($text){
	return str_replace('��',',',$text);
}

//���תȫ��
function eDoBjToQj($text){
	$text=str_replace(array('&','"','\'','<','>'),array('��','��','��','��','��'),$text);
	return $text;
}

//����Ϣ�ֶ�תȫ��
function eDoInfoTbfToQj($tbname,$f,$fval,$qjf){
	global $public_r;
	if(empty($qjf))
	{
		return $fval;
	}
	if(!stristr('|'.$qjf.'|','|'.$tbname.'.'.$f.'|'))
	{
		return $fval;
	}
	$fval=eDoBjToQj($fval);
	return $fval;
}

//����Ŀ¼����
function DoMkdir($path){
	global $public_r;
	//����������
	if(!file_exists($path))
	{
		//��ȫģʽ
		if($public_r[phpmode])
		{
			$pr[0]=$path;
			FtpMkdir($ftpid,$pr,0777);
			$mk=1;
		}
		else
		{
			$mk=@mkdir($path,0777);
			@chmod($path,0777);
		}
		if(empty($mk))
		{
			echo Ecms_eReturnShowMkdir($path);
			printerror("CreatePathFail","history.go(-1)");
		}
	}
	return true;
}

//�����ϼ�Ŀ¼
function DoFileMkDir($file){
	$path=dirname($file.'empirecms.txt');
	DoMkdir($path);
}

//�����ϴ��ļ�Ȩ��
function DoChmodFile($file){
	global $public_r;
	if($public_r['filechmod']!=1)
	{
		@chmod($file,0777);
	}
}

//�滻б��
function DoRepFileXg($file){
	$file=str_replace("\\","/",$file);
	return $file;
}

//������Ŀ�����ַ���
function ReturnClassLink($classid){
	global $class_r,$public_r,$fun_r;
	if(empty($class_r[$classid][featherclass]))
	{$class_r[$classid][featherclass]="|";}
	$r=explode("|",$class_r[$classid][featherclass].$classid."|");
	$string="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";
	for($i=1;$i<count($r)-1;$i++)
	{
		//moreport
		if(Moreport_ReturnMustDt())
		{
			$class_r[$r[$i]][listdt]=1;
		}
		//��̬�б�
		if(empty($class_r[$r[$i]][listdt]))
		{
			//�ް�����
			if(empty($class_r[$r[$i]][classurl]))
			{$url=$public_r[newsurl].$class_r[$r[$i]][classpath]."/";}
			else
			{$url=$class_r[$r[$i]][classurl];}
		}
		else
		{
			$rewriter=eReturnRewriteClassUrl($r[$i],1);
			$url=$rewriter['pageurl'];
		}
		$string.="&nbsp;".$public_r[navfh]."&nbsp;<a href=\"".$url."\">".$class_r[$r[$i]][classname]."</a>";
	}
	return $string;
}

//����ר�������ַ���
function ReturnZtLink($ztid){
	global $class_zr,$public_r,$fun_r;
	$string="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";
	//�ް�����
	if(empty($class_zr[$ztid][zturl]))
	{$url=$public_r[newsurl].$class_zr[$ztid][ztpath]."/";}
	else
	{$url=$class_zr[$ztid][zturl];}
    $string.="&nbsp;".$public_r[navfh]."&nbsp;<a href=\"".$url."\">".$class_zr[$ztid][ztname]."</a>";
	return $string;
}

//���ر�����������ַ���
function ReturnInfoTypeLink($typeid){
	global $class_tr,$public_r,$fun_r;
	$string="<a href=\"".ReturnSiteIndexUrl()."\">".$fun_r['index']."</a>";
	//moreport
	if(Moreport_ReturnMustDt())
	{
		$class_tr[$typeid]['listdt']=1;
	}
	if($class_tr[$typeid]['listdt'])
	{
		$rewriter=eReturnRewriteTitleTypeUrl($typeid,1);
		$url=$rewriter['pageurl'];
	}
	else
	{
		$url=$public_r[newsurl].$class_tr[$typeid][tpath]."/";
	}
    $string.="&nbsp;".$public_r[navfh]."&nbsp;<a href=\"".$url."\">".$class_tr[$typeid][tname]."</a>";
	return $string;
}

//���ص�ҳ�����ַ���
function ReturnUserPLink($title,$titleurl){
	global $public_r,$fun_r;
	$string='<a href="'.ReturnSiteIndexUrl().'">'.$fun_r['index'].'</a>&nbsp;'.$public_r[navfh].'&nbsp;'.$title;
	return $string;
}

//���ر�������(��̬)
function sys_ReturnBqTitleLink($r){
	global $public_r;
	if(empty($r['isurl']))
	{
		//moreport
		if(Moreport_ReturnMustDt())
		{
			return Moreport_ReturnTitleUrl($r['classid'],$r['id']);
		}
		return $r['titleurl'];
	}
	else
	{
		if($public_r['opentitleurl'])
		{
			$titleurl=$r['titleurl'];
		}
		else
		{
			$titleurl=$public_r['newsurl'].'e/public/jump/?classid='.$r['classid'].'&id='.$r['id'];
		}
		return $titleurl;
	}
}

//���ر�������(��̬)
function sys_ReturnBqTitleLinkDt($r){
	global $public_r,$class_r;
	if(empty($r['isurl']))
	{
		if($class_r[$r[classid]][showdt]==1)//��̬����
		{
			$titleurl=$public_r[newsurl]."e/action/ShowInfo/?classid=$r[classid]&id=$r[id]";
			return $titleurl;
		}
		elseif($class_r[$r[classid]][showdt]==2)
		{
			$rewriter=eReturnRewriteInfoUrl($r['classid'],$r['id'],1);
			$titleurl=$rewriter['pageurl'];
			return $titleurl;
		}
		if($class_r[$r[classid]][filename]==3)
		{
			$filename=ReturnInfoSPath($r[filename]);
		}
		else
		{
			$filetype=$r[groupid]?'.php':$class_r[$r[classid]][filetype];
			$filename=$r[filename].$filetype;
		}
		$iclasspath=ReturnSaveInfoPath($r[classid],$r[id]);
		$newspath=empty($r[newspath])?'':$r[newspath]."/";
		if($class_r[$r[classid]][classurl]&&$class_r[$r[classid]][ipath]=='')//����
		{
			$titleurl=$class_r[$r[classid]][classurl]."/".$newspath.$filename;
		}
		else
		{
			$titleurl=$public_r[newsurl].$iclasspath.$newspath.$filename;
		}
	}
	else
	{
		$titleurl=$r['titleurl'];
	}
	return addslashes($titleurl);
}

//��תȡ����Ϣ��ַ
function GotoGetTitleUrl($classid,$id,$newspath,$filename,$groupid,$isurl,$titleurl){
	$r['classid']=$classid;
	$r['id']=$id;
	$r['newspath']=$newspath;
	$r['filename']=$filename;
	$r['groupid']=$groupid;
	$r['isurl']=$isurl;
	$r['titleurl']=$titleurl;
	$infourl=sys_ReturnBqTitleLinkDt($r);
	return $infourl;
}

//���ر�������(����)
function sys_ReturnBqAutoTitleLink($r){
	global $public_r,$class_r;
	if(empty($r['isurl']))
	{
		if($class_r[$r[classid]][showdt]==2)
		{
			$rewriter=eReturnRewriteInfoUrl($r['classid'],$r['id'],1);
			$titleurl=$rewriter['pageurl'];
			return $titleurl;
		}
		if($class_r[$r[classid]][filename]==3)
		{
			$filename=ReturnInfoSPath($r[filename]);
		}
		else
		{
			$filetype=$r[groupid]?'.php':$class_r[$r[classid]][filetype];
			$filename=$r[filename].$filetype;
		}
		$iclasspath=ReturnSaveInfoPath($r[classid],$r[id]);
		$newspath=empty($r[newspath])?'':$r[newspath]."/";
		if($class_r[$r[classid]][classurl]&&$class_r[$r[classid]][ipath]=='')//����
		{
			$titleurl=$class_r[$r[classid]][classurl]."/".$newspath.$filename;
		}
		else
		{
			$titleurl=$public_r[newsurl].$iclasspath.$newspath.$filename;
		}
	}
	else
	{
		if($public_r['opentitleurl'])
		{
			$titleurl=$r['titleurl'];
		}
		else
		{
			$titleurl=$public_r['newsurl']."e/public/jump/?classid=".$r['classid']."&id=".$r['id'];
		}
	}
	return $titleurl;
}

//��������ҳ��ַǰ׺
function ReturnInfoPageQz($r){
	global $public_r,$class_r;
	$ret_r['titleurl']='';
	$ret_r['filetype']='';
	$ret_r['nametype']=0;
	//��̬ҳ��
	if($class_r[$r[classid]][showdt]==2)
	{
		$rewriter=eReturnRewriteInfoUrl($r['classid'],$r['id'],0);
		$ret_r['pageurl']=$rewriter['pageurl'];
		$ret_r['rewrite']=$rewriter['rewrite'];
		$ret_r['titleurl']=$rewriter['pageurl'];
		$ret_r['filetype']='';
		$ret_r['nametype']=1;
		return $ret_r;
	}
	//��̬ҳ��
	$ret_r['filetype']=$r[groupid]?'.php':$class_r[$r[classid]][filetype];
	$filename=$r[filename];
	$iclasspath=ReturnSaveInfoPath($r[classid],$r[id]);
	$newspath=empty($r[newspath])?'':$r[newspath]."/";
	if($class_r[$r[classid]][classurl]&&$class_r[$r[classid]][ipath]=='')//����
	{
		$ret_r['titleurl']=$class_r[$r[classid]][classurl]."/".$newspath.$filename;
	}
	else
	{
		$ret_r['titleurl']=$public_r[newsurl].$iclasspath.$newspath.$filename;
	}
	return $ret_r;
}

//������Ŀ����
function sys_ReturnBqClassname($r,$have_class=0){
	global $public_r,$class_r;
	if($have_class)
	{
		//moreport
		if(Moreport_ReturnMustDt())
		{
			$class_r[$r[classid]][listdt]=1;
		}
		//�ⲿ��Ŀ
		if($class_r[$r[classid]][wburl])
		{
			$classurl=$class_r[$r[classid]][wburl];
		}
		//��̬�б�
		elseif($class_r[$r[classid]][listdt])
		{
			$rewriter=eReturnRewriteClassUrl($r['classid'],1);
			$classurl=$rewriter['pageurl'];
		}
		elseif($class_r[$r[classid]][classurl])
		{
			$classurl=$class_r[$r[classid]][classurl];
		}
		else
		{
			$classurl=$public_r[newsurl].$class_r[$r[classid]][classpath]."/";
		}
		if(empty($class_r[$r[classid]][bname]))
		{$classname=$class_r[$r[classid]][classname];}
		else
		{$classname=$class_r[$r[classid]][bname];}
		$myadd="[<a href=".$classurl.">".$classname."</a>]";
		//ֻ��������
		if($have_class==9)
		{$myadd=$classurl;}
	}
	else
	{$myadd="";}
	return $myadd;
}

//����ר������
function sys_ReturnBqZtname($r){
	global $public_r,$class_zr;
	if($class_zr[$r[ztid]][zturl])
	{
		$zturl=$class_zr[$r[ztid]][zturl];
    }
	else
	{
		$zturl=$public_r[newsurl].$class_zr[$r[ztid]][ztpath]."/";
    }
	return $zturl;
}

//���ر����������
function sys_ReturnBqInfoTypeUrl($typeid){
	global $public_r,$class_tr;
	//moreport
	if(Moreport_ReturnMustDt())
	{
		$class_tr[$typeid]['listdt']=1;
	}
	if($class_tr[$typeid]['listdt'])
	{
		$rewriter=eReturnRewriteTitleTypeUrl($typeid,1);
		$url=$rewriter['pageurl'];
	}
	else
	{
		$url=$public_r['newsurl'].$class_tr[$typeid]['tpath']."/";
	}
	return $url;
}

//�ļ���С��ʽת��
function ChTheFilesize($size){
	if($size>=1024*1024)//MB
	{
		$filesize=number_format($size/(1024*1024),2,'.','')." MB";
	}
	elseif($size>=1024)//KB
	{
		$filesize=number_format($size/1024,2,'.','')." KB";
	}
	else
	{
		$filesize=$size." Bytes";
	}
	return $filesize;
}

//ȡ�ñ��¼
function eGetTableRowNum($tbname){
	global $empire,$dbtbpre;
	$total_r=$empire->fetch1("SHOW TABLE STATUS LIKE '".$tbname."';");
	return $total_r['Rows'];
}

//������Ŀ��Ϣ��
function AddClassInfos($classid,$addallstr,$addstr,$checked=1){
	global $empire,$dbtbpre;
	$updatestr='';
	$dh='';
	if($addallstr)
	{
		$updatestr.='allinfos=allinfos'.$addallstr;
		$dh=',';
	}
	if($addstr)
	{
		if($checked)
		{
			$updatestr.=$dh.'infos=infos'.$addstr;
		}
	}
	if(empty($updatestr))
	{
		return '';
	}
	$empire->query("update {$dbtbpre}enewsclass set ".$updatestr." where classid='$classid' limit 1");
}

//������Ŀ��Ϣ��
function ReturnClassInfoNum($cr,$ecms=0){
	global $empire,$dbtbpre,$class_r;
	if($cr['islast'])
	{
		$num=$ecms==0?$cr['infos']:$cr['allinfos'];
	}
	else
	{
		$f=$ecms==0?'infos':'allinfos';
		$num=$empire->gettotal("select sum(".$f.") as total from {$dbtbpre}enewsclass where ".ReturnClass($class_r[$cr[classid]][sonclass]));
		$num=(int)$num;
	}
	return $num;
}

//������Ŀ��Ϣ��
function ResetClassInfos($classid){
	global $empire,$dbtbpre,$class_r;
	$infos=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid]['tbname']." where classid='$classid'");
	$checkinfos=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid]['tbname']."_check where classid='$classid'");
	$allinfos=$infos+$checkinfos;
	$empire->query("update {$dbtbpre}enewsclass set allinfos='$allinfos',infos='$infos' where classid='$classid' limit 1");
}

//����Ϣ������
function UpdateSingleInfoPlnum($classid,$id,$checked=1){
	global $empire,$dbtbpre,$class_r;
	$tbname=$class_r[$classid]['tbname'];
	if(empty($tbname))
	{
		return '';
	}
	$infotb=ReturnInfoMainTbname($tbname,$checked);
	$r=$empire->fetch1("select id,restb,plnum from ".$infotb." where id='$id' limit 1");
	if(empty($r['restb']))
	{
		return '';
	}
	$pubid=ReturnInfoPubid($classid,$id);
	$plnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewspl_".$r['restb']." where pubid='$pubid' limit 1");
	if($plnum==$r['plnum'])
	{
		return '';
	}
	$empire->query("update ".$infotb." set plnum='$plnum' where id='$id' limit 1");
}

//��Ϣ��ͳ�Ƽ�1
function DoUpdateAddDataNum($type='info',$stb,$addnum=1){
	global $empire,$dbtbpre;
	if($type=='info')//��Ϣ
	{
		$lasttimef='lasttimeinfo';
		$lastnumf='lastnuminfo';
		$lastnumtbf='lastnuminfotb';
		$todaytimef='todaytimeinfo';
		$todaynumf='todaynuminfo';
		$yesterdaynumf='yesterdaynuminfo';
		$sqladdf=',todaytimeinfo,todaytimepl,todaynuminfo,todaynumpl';
	}
	elseif($type=='pl')//����
	{
		$lasttimef='lasttimepl';
		$lastnumf='lastnumpl';
		$lastnumtbf='lastnumpltb';
		$todaytimef='todaytimepl';
		$todaynumf='todaynumpl';
		$yesterdaynumf='yesterdaynumpl';
		$sqladdf=',todaytimepl,todaytimeinfo,todaynuminfo,todaynumpl';
	}
	else
	{
		return '';
	}
	$sqladdupdate='';
	$time=time();
	$pur=$empire->fetch1("select ".$lasttimef.",".$lastnumtbf.$sqladdf." from {$dbtbpre}enewspublic_up limit 1");
	if($stb)
	{
		if(empty($pur[$lastnumtbf]))
		{
			$pur[$lastnumtbf]='|';
		}
		if(strstr($pur[$lastnumtbf],'|'.$stb.','))
		{
			$numr=explode('|'.$stb.',',$pur[$lastnumtbf]);
			$numrt=explode('|',$numr[1]);
			$newnum=$numrt[0]+$addnum;
			$tbnums=str_replace('|'.$stb.','.$numrt[0].'|','|'.$stb.','.$newnum.'|',$pur[$lastnumtbf]);
		}
		else
		{
			$tbnums=$pur[$lastnumtbf].$stb.','.$addnum.'|';
		}
		$sqladdupdate.=",".$lastnumtbf."='".$tbnums."'";
	}
	//����ͳ��
	if($sqladdf)
	{
		$todaydate=date('Y-m-d');
		if($todaydate<>date('Y-m-d',$pur['todaytimeinfo'])||$todaydate<>date('Y-m-d',$pur['todaytimepl']))
		{
			if($type=='info')
			{
				$todaynuminfo=$addnum;
				$todaynumpl=0;
			}
			else
			{
				$todaynuminfo=0;
				$todaynumpl=$addnum;
			}
			$yesterdaynuminfo=$pur['todaynuminfo'];
			$yesterdaynumpl=$pur['todaynumpl'];
			if($todaydate<>date('Y-m-d',$pur['todaytimeinfo']+24*3600))
			{
				$yesterdaynuminfo=0;
			}
			if($todaydate<>date('Y-m-d',$pur['todaytimepl']+24*3600))
			{
				$yesterdaynumpl=0;
			}
			$sqladdupdate.=",todaytimeinfo='$time',todaytimepl='$time',todaynuminfo='$todaynuminfo',todaynumpl='$todaynumpl',yesterdaynuminfo='$yesterdaynuminfo',yesterdaynumpl='$yesterdaynumpl'";
		}
		else
		{
			$sqladdupdate.=",".$todaynumf."=".$todaynumf."+".$addnum;
		}
	}
	$empire->query("update {$dbtbpre}enewspublic_up set ".$lastnumf."=".$lastnumf."+".$addnum.$sqladdupdate." limit 1");
}

//������Ϣ��ͳ��
function DoResetAddDataNum($type='info'){
	global $empire,$dbtbpre;
	if($type=='info')//��Ϣ
	{
		$lasttimef='lasttimeinfo';
		$lastnumf='lastnuminfo';
		$lastnumtbf='lastnuminfotb';
	}
	elseif($type=='pl')//����
	{
		$lasttimef='lasttimepl';
		$lastnumf='lastnumpl';
		$lastnumtbf='lastnumpltb';
	}
	else
	{
		return '';
	}
	$time=time();
	$empire->query("update {$dbtbpre}enewspublic_up set ".$lasttimef."='$time',".$lastnumf."=0,".$lastnumtbf."='' limit 1");
}

//����������Ϣ��ͳ��
function DoUpdateYesterdayAddDataNum(){
	global $empire,$dbtbpre;
	$pur=$empire->fetch1("select * from {$dbtbpre}enewspublic_up limit 1");
	$todaydate=date('Y-m-d');
	if($todaydate==date('Y-m-d',$pur['todaytimeinfo'])&&$todaydate==date('Y-m-d',$pur['todaytimepl']))
	{
		return '';
	}
	$yesterdaynuminfo=$pur['todaynuminfo'];
	$yesterdaynumpl=$pur['todaynumpl'];
	if($todaydate<>date('Y-m-d',$pur['todaytimeinfo']+24*3600))
	{
		$yesterdaynuminfo=0;
	}
	if($todaydate<>date('Y-m-d',$pur['todaytimepl']+24*3600))
	{
		$yesterdaynumpl=0;
	}
	$time=time();
	$empire->query("update {$dbtbpre}enewspublic_up set todaytimeinfo='$time',todaytimepl='$time',todaynuminfo=0,yesterdaynuminfo='$yesterdaynuminfo',todaynumpl=0,yesterdaynumpl='$yesterdaynumpl' limit 1");
}

//������Ŀ�Զ����ֶ�����
function ReturnClassAddField($classid,$f){
	global $empire,$dbtbpre,$navclassid;
	if(empty($classid))
	{
		$classid=$navclassid;
	}
	$fr=$empire->fetch1("select ".$f." from {$dbtbpre}enewsclassadd where classid='$classid' limit 1");
	if(strstr($f,','))
	{
		return $fr;
	}
	else
	{
		return $fr[$f];
	}
}

//����ר���Զ����ֶ�����
function ReturnZtAddField($classid,$f){
	global $empire,$dbtbpre,$navclassid;
	if(empty($classid))
	{
		$classid=$navclassid;
	}
	$fr=$empire->fetch1("select ".$f." from {$dbtbpre}enewsztadd where ztid='$classid' limit 1");
	if(strstr($f,','))
	{
		return $fr;
	}
	else
	{
		return $fr[$f];
	}
}

//������չ����ֵ
function ReturnPublicAddVar($myvar){
	global $empire,$dbtbpre;
	if(strstr($myvar,','))
	{
		$myvr=explode(',',$myvar);
		$count=count($myvr);
		for($i=0;$i<$count;$i++)
		{
			$v=$myvr[$i];
			$vr=$empire->fetch1("select varvalue from {$dbtbpre}enewspubvar where myvar='$v' limit 1");
			$ret_vr[$v]=$vr['varvalue'];
		}
		return $ret_vr;
	}
	else
	{
		$vr=$empire->fetch1("select varvalue from {$dbtbpre}enewspubvar where myvar='$myvar' limit 1");
		return $vr['varvalue'];
	}
}

//���������ֶ�
function ReturnDoOrderF($mid,$orderby,$myorder){
	global $emod_r;
	$orderby=str_replace(',','',$orderby);
	$orderf=',newstime,id,onclick,totaldown,plnum';
	if(!empty($emod_r[$mid]['orderf']))
	{
		$orderf.=$emod_r[$mid]['orderf'];
	}
	else
	{
		$orderf.=',';
	}
	if(strstr($orderf,','.$orderby.','))
	{
		$rr['returnorder']=$orderby;
		$rr['returnf']=$orderby;
	}
	else
	{
		$rr['returnorder']='newstime';
		$rr['returnf']='newstime';
	}
	if(empty($myorder))
	{
		$rr['returnorder'].=' desc';
	}
	return $rr;
}

//�����ö�
function ReturnSetTopSql($ecms){
	global $public_r;
	if(empty($public_r['settop']))
	{
		return '';
	}
	$top='istop desc,';
	if($ecms=='list')
	{
		if($public_r['settop']==1||$public_r['settop']==4||$public_r['settop']==5||$public_r['settop']==6)
		{
			return $top;
		}
	}
	elseif($ecms=='bq')
	{
		if($public_r['settop']==2||$public_r['settop']==4||$public_r['settop']==5||$public_r['settop']==7)
		{
			return $top;
		}
	}
	elseif($ecms=='js')
	{
		if($public_r['settop']==3||$public_r['settop']==4||$public_r['settop']==6||$public_r['settop']==7)
		{
			return $top;
		}
	}
	return '';
}

//�����Ż�����SQL
function ReturnYhSql($yhid,$yhvar,$ecms=0){
	global $eyh_r;
	if(empty($yhid))
	{
		return '';
	}
	$query='';
	if($eyh_r[$yhid][$yhvar])
	{
		$t=time()-($eyh_r[$yhid][$yhvar]*86400);
		$query='newstime>'.$t.(empty($ecms)?'':' and ');
	}
	return $query;
}

//�����Ż�+����SQL
function ReturnYhAndSql($yhadd,$where,$ecms=0){
	if($yhadd.$where=='')
	{
		return '';
	}
	elseif($yhadd&&$where)
	{
		return $ecms==1?' where '.$yhadd.$where:' where '.$yhadd.' and '.$where;
	}
	elseif($yhadd&&!$where)
	{
		return ' where '.$yhadd;
	}
	else
	{
		return $ecms==1?' where '.substr($where,5):' where '.$where;
	}
}

//�����б��ѯ�ֶ�
function ReturnSqlListF($mid){
	global $emod_r;
	if(empty($mid))
	{
		return '*';
	}
	$f='id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard,eckuid'.substr($emod_r[$mid]['listtempf'],0,-1);
	return $f;
}

//�������ݲ�ѯ�ֶ�
function ReturnSqlTextF($mid,$ecms=0){
	global $emod_r;
	if(empty($mid))
	{
		return '*';
	}
	$f=($ecms==0?'id,classid,':'').'ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard,eckuid'.substr($emod_r[$mid]['tbmainf'],0,-1);
	return $f;
}

//�������ݸ����ѯ�ֶ�
function ReturnSqlFtextF($mid){
	global $emod_r;
	if(empty($mid))
	{
		return '*';
	}
	$f='keyid,dokey,newstempid,closepl,infotags'.substr($emod_r[$mid]['tbdataf'],0,-1);
	return $f;
}

//������Ϣ��
function ReturnInfoTbname($tbname,$checked=1,$stb=1){
	global $dbtbpre;
	if(empty($checked))//�����
	{
		$r['tbname']=$dbtbpre.'ecms_'.$tbname.'_check';
		$r['datatbname']=$dbtbpre.'ecms_'.$tbname.'_check_data';
	}
	else//�����
	{
		$r['tbname']=$dbtbpre.'ecms_'.$tbname;
		$r['datatbname']=$dbtbpre.'ecms_'.$tbname.'_data_'.$stb;
	}
	return $r;
}

//������Ϣ����
function ReturnInfoMainTbname($tbname,$checked=1){
	global $dbtbpre;
	return empty($checked)?$dbtbpre.'ecms_'.$tbname.'_check':$dbtbpre.'ecms_'.$tbname;
}

//������Ϣ����
function ReturnInfoDataTbname($tbname,$checked=1,$stb=1){
	global $dbtbpre;
	return empty($checked)?$dbtbpre.'ecms_'.$tbname.'_check_data':$dbtbpre.'ecms_'.$tbname.'_data_'.$stb;
}

//������Ϣ
function ReturnIndexTableInfo($tbname,$f,$classid,$id){
	global $dbtbpre;
	$r=$empire->fetch1("select ".$f." from {$dbtbpre}ecms_".$tbname."_index where id='$id' limit 1");
	return $r;
}

//�������۱���
function eReturnRestb($restb){
	global $public_r,$dbtbpre;
	$restb=(int)$restb;
	if(!strstr($public_r['pldatatbs'],','.$restb.','))
	{
		$restb=$public_r['pldeftb'];
	}
	return $dbtbpre.'enewspl_'.$restb;
}

//���ظ�������
function eReturnFstb($fstb){
	global $public_r,$dbtbpre;
	$fstb=(int)$fstb;
	if(!strstr($public_r['filedatatbs'],','.$fstb.','))
	{
		$fstb=$public_r['filedeftb'];
	}
	return $dbtbpre.'enewsfile_'.$fstb;
}

//���ع���������ID
function ReturnInfoPubid($classid,$id,$tid=0){
	global $class_r;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($tid))
	{
		$tid=$class_r[$classid]['tid'];
	}
	$tid=(int)$tid;
	$pubid='1'.ReturnAllInt($tid,5).ReturnAllInt($id,10);
	return $pubid;
}

//�Ƿ��ڲ���
function InfoIsInTable($tbname){
	global $etable_r;
	return $etable_r[$tbname]['intb']==1?true:false;
}

//�����ֶ��Ƿ����
function eCheckTbHaveField($tid,$tbname,$f){
	global $empire,$dbtbpre;
	$where=$tid?"tid='$tid' and ":"tbname='$tbname' and ";
	if(strstr($f,','))
	{
		$fr=explode(',',$f);
		$where.="f='".$fr[0]."' or f='".$fr[1]."'";
	}
	else
	{
		$where.="f='$f'";
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where ".$where." limit 1");
	return $num;
}

//��֤ģ���Ƿ�����̬ʹ��
function DtTempIsClose($tempid,$type='listtemp'){
	global $public_r;
	if($type=='listtemp')//�б�ģ��
	{
		if($public_r['closelisttemp']&&strstr(','.$public_r['closelisttemp'].',',','.$tempid.','))
		{
			echo'ListTempID='.$tempid.' is close.';
			exit();
		}
	}
}

//����
function ReturnAllInt($val,$num){
	$len=strlen($val);
	$zeronum=$num-$len;
	if($zeronum==1)
	{
		$val='0'.$val;
	}
	elseif($zeronum==2)
	{
		$val='00'.$val;
	}
	elseif($zeronum==3)
	{
		$val='000'.$val;
	}
	elseif($zeronum==4)
	{
		$val='0000'.$val;
	}
	elseif($zeronum==5)
	{
		$val='00000'.$val;
	}
	elseif($zeronum==6)
	{
		$val='000000'.$val;
	}
	elseif($zeronum==7)
	{
		$val='0000000'.$val;
	}
	elseif($zeronum==8)
	{
		$val='00000000'.$val;
	}
	elseif($zeronum==9)
	{
		$val='000000000'.$val;
	}
	elseif($zeronum==10)
	{
		$val='0000000000'.$val;
	}
	return $val;
}

//�����滻�б�
function ReturnReplaceListF($mid){
	global $emod_r;
	$r['mid']=$mid;
	$r['fr']=explode(',',$emod_r[$mid]['listtempf']);
	$r['fcount']=count($r['fr'])-1;
	return $r;
}

//�����滻����
function ReturnReplaceTextF($mid){
	global $emod_r;
	$r['mid']=$mid;
	$r['fr']=explode(',',$emod_r[$mid]['tempf']);
	$r['fcount']=count($r['fr'])-1;
	return $r;
}

//�滻�б�ģ��/��ǩģ��/����ģ��
function ReplaceListVars($no,$listtemp,$subnews,$subtitle,$formatdate,$url,$haveclass=0,$r,$field,$docode=0){
	global $empire,$public_r,$class_r,$class_zr,$fun_r,$dbtbpre,$emod_r,$class_tr,$level_r,$navclassid,$etable_r;
	if($haveclass)
	{
		$add=sys_ReturnBqClassname($r,$haveclass);
	}
	if(empty($r[oldtitle]))
	{
		$r[oldtitle]=$r[title];
	}
	if($docode==1)
	{
		$listtemp=stripSlashes($listtemp);
		eval($listtemp);
	}
	$ylisttemp=$listtemp;
	$mid=$field['mid'];
	$fr=$field['fr'];
	$fcount=$field['fcount'];
	for($i=1;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$value=$r[$f];
		$spf=0;
		if($f=='title')//����
		{
	        if(!empty($subtitle))//��ȡ�ַ�
	        {
				$value=sub($value,0,$subtitle,false);
	        }
			$value=DoTitleFont($r[titlefont],$value);
			$spf=1;
		}
		elseif($f=='newstime')//ʱ��
		{
			//$value=date($formatdate,$value);
			$value=format_datetime($value,$formatdate);
			$spf=1;
		}
		elseif($f=='titlepic')//����ͼƬ
		{
			if(empty($value))
		    {
				$value=$public_r[newsurl].'e/data/images/notimg.gif';
			}
			$spf=1;
		}
		elseif(strstr($emod_r[$mid]['smalltextf'],','.$f.','))//���
		{
			if(!empty($subnews))//��ȡ�ַ�
			{
				$value=sub($value,0,$subnews,false);
			}
		}
		elseif($f=='befrom')//��Ϣ��Դ
		{
			$spf=1;
		}
		elseif($f=='writer')//����
		{
			$spf=1;
		}
		if($spf==0&&!strstr($emod_r[$mid]['editorf'],','.$f.','))
		{
			if(strstr($emod_r[$mid]['tobrf'],','.$f.','))//��br
			{
				$value=nl2br($value);
			}
			if(!strstr($emod_r[$mid]['dohtmlf'],','.$f.','))//ȥ��html
			{
				$value=RepFieldtextNbsp(ehtmlspecialchars($value));
			}
		}
		$listtemp=str_replace('[!--'.$f.'--]',$value,$listtemp);
	}
	$titleurl=sys_ReturnBqTitleLink($r);//����
	$listtemp=str_replace('[!--id--]',$r[id],$listtemp);
	$listtemp=str_replace('[!--classid--]',$r[classid],$listtemp);
	$listtemp=str_replace('[!--class.name--]',$add,$listtemp);
	$listtemp=str_replace('[!--ttid--]',$r[ttid],$listtemp);
	$listtemp=str_replace('[!--tt.name--]',$class_tr[$r[ttid]][tname],$listtemp);
	$listtemp=str_replace('[!--tt.url--]',sys_ReturnBqInfoTypeUrl($r['ttid']),$listtemp);
	$listtemp=str_replace('[!--userfen--]',$r[userfen],$listtemp);
	$listtemp=str_replace('[!--titleurl--]',$titleurl,$listtemp);
	$listtemp=str_replace('[!--no.num--]',$no,$listtemp);
	$listtemp=str_replace('[!--plnum--]',$r[plnum],$listtemp);
	$listtemp=str_replace('[!--userid--]',$r[userid],$listtemp);
	$listtemp=str_replace('[!--username--]',$r[username],$listtemp);
	$listtemp=str_replace('[!--onclick--]',$r[onclick],$listtemp);
	$listtemp=str_replace('[!--oldtitle--]',$r[oldtitle],$listtemp);
	$listtemp=str_replace('[!--totaldown--]',$r[totaldown],$listtemp);
	//��Ŀ����
	if(strstr($ylisttemp,'[!--this.classlink--]'))
	{
		$thisclasslink=sys_ReturnBqClassname($r,9);
		$listtemp=str_replace('[!--this.classlink--]',$thisclasslink,$listtemp);
	}
	$thisclassname=$class_r[$r[classid]][bname]?$class_r[$r[classid]][bname]:$class_r[$r[classid]][classname];
	$listtemp=str_replace('[!--this.classname--]',$thisclassname,$listtemp);
	return $listtemp;
}

//���Ϸ������ַ�
function AddNotCopyRndStr($text){
	global $public_r;
	if($public_r['opencopytext'])
	{
		$rnd=make_password(3).$public_r['sitename'];
		$text=str_replace("<br />","<span style=\"display:none\">".$rnd."</span><br />",$text);
		$text=str_replace("</p>","<span style=\"display:none\">".$rnd."</span></p>",$text);
	}
	return $text;
}

//�滻��Ϣ��Դ
function ReplaceBefrom($befrom){
	global $empire,$dbtbpre;
	if(empty($befrom))
	{return $befrom;}
	$befrom=addslashes($befrom);
	$r=$empire->fetch1("select befromid,sitename,siteurl from {$dbtbpre}enewsbefrom where sitename='$befrom' limit 1");
	if(empty($r[befromid]))
	{return $befrom;}
	$return_befrom="<a href='".$r[siteurl]."' target=_blank>".$r[sitename]."</a>";
	return $return_befrom;
}

//�滻����
function ReplaceWriter($writer){
	global $empire,$dbtbpre;
	if(empty($writer))
	{return $writer;}
	$writer=addslashes($writer);
	$r=$empire->fetch1("select wid,writer,email from {$dbtbpre}enewswriter where writer='$writer' limit 1");
	if(empty($r[wid])||empty($r[email]))
	{
		return $writer;
	}
	$return_writer="<a href='".$r[email]."'>".$r[writer]."</a>";
	return $return_writer;
}

//�������ؼ�¼
function BakDown($classid,$id,$pathid,$userid,$username,$title,$cardfen,$online=0){
	global $empire,$dbtbpre;
	$truetime=time();
	$id=(int)$id;
	$pathid=(int)$pathid;
	$userid=(int)$userid;
	$cardfen=(int)$cardfen;
	$classid=(int)$classid;
	$username=RepPostVar($username);
	$title=RepPostStr($title);
	$online=addslashes(RepPostStr($online));
	$sql=$empire->query("insert into {$dbtbpre}enewsdownrecord(id,pathid,userid,username,title,cardfen,truetime,classid,online) values($id,$pathid,$userid,'$username','".addslashes($title)."',$cardfen,$truetime,$classid,'$online');");
}

//���ݳ�ֵ��¼
function BakBuy($userid,$username,$buyname,$userfen,$money,$userdate,$type=0){
	global $empire,$dbtbpre;
	$buytime=date("y-m-d H:i:s");
	$buyname=addslashes(RepPostStr($buyname));
	$userid=(int)$userid;
	$username=RepPostVar($username);
	$userfen=addslashes(RepPostStr($userfen));
	$money=addslashes(RepPostStr($money));
	$userdate=addslashes(RepPostStr($userdate));
	$type=addslashes(RepPostStr($type));
	$empire->query("insert into {$dbtbpre}enewsbuybak(userid,username,card_no,cardfen,money,buytime,userdate,type) values('$userid','$username','$buyname','$userfen','$money','$buytime','$userdate','$type');");
}

//���Ͷ���Ϣ
function eSendMsg($title,$msgtext,$to_username,$from_userid,$from_username,$isadmin,$issys,$ecms=0){
	global $empire,$dbtbpre;
	$tbname=$ecms==1?$dbtbpre.'enewshmsg':$dbtbpre.'enewsqmsg';
	$to_username=RepPostVar($to_username);
	$from_userid=(int)$from_userid;
	$from_username=RepPostVar($from_username);
	$isadmin=(int)$isadmin;
	$issys=(int)$issys;
	$msgtime=date("Y-m-d H:i:s");
	$empire->query("insert into ".$tbname."(title,msgtext,haveread,msgtime,to_username,from_userid,from_username,isadmin,issys) values('$title','$msgtext',0,'$msgtime','$to_username','$from_userid','$from_username','$isadmin','$issys');");
	//��Ϣ״̬
	$userr=$empire->fetch1("select ".eReturnSelectMemberF('userid,havemsg')." from ".eReturnMemberTable()." where ".egetmf('username')."='$to_username' limit 1");
	if(!$userr['havemsg'])
	{
		$newhavemsg=eReturnSetHavemsg($userr['havemsg'],0);
		$empire->query("update ".eReturnMemberTable()." set ".egetmf('havemsg')."='$newhavemsg' where ".egetmf('userid')."='".$userr['userid']."' limit 1");
	}
}

//����֪ͨ
function eSendNotice($title,$msgtext,$to_username,$from_userid,$from_username,$ecms=0){
	global $empire,$dbtbpre;
	$tbname=$ecms==1?$dbtbpre.'enewshnotice':$dbtbpre.'enewsnotice';
	$to_username=RepPostVar($to_username);
	$from_userid=(int)$from_userid;
	$from_username=RepPostVar($from_username);
	$msgtime=date("Y-m-d H:i:s");
	$empire->query("insert into ".$tbname."(title,msgtext,haveread,msgtime,to_username,from_userid,from_username) values('".$title."','".$msgtext."',0,'$msgtime','$to_username','$from_userid','$from_username');");
}

//��ȡ���
function SubSmalltextVal($value,$len){
	if(empty($len))
	{
		return '';
	}
	$value=str_replace(array("\r\n","<br />","<br>","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","\r\n","\r\n"," ","",""),$value);
	$value=strip_tags($value);
	if($len)
	{
		$value=sub($value,0,$len,false);
	}
	$value=trim($value,"\r\n");
	$value=str_replace('&amp;ldquo;','&ldquo;',$value);
	$value=str_replace('&amp;rdquo;','&rdquo;',$value);
	$value=str_replace('&amp;mdash;','&mdash;',$value);
	return $value;
}

//ȫվ�������
function SubSchallSmalltext($value,$len){
	$value=str_replace(array("\r\n","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","","",""),$value);
	$value=strip_tags($value);
	if($len)
	{
		$value=sub($value,0,$len,false);
	}
	$value=trim($value,"\r\n");
	return $value;
}

//�Ӻ��滻
function DoReplaceFontRed($text,$key){
	return str_replace($key,'<font color="red">'.$key.'</font>',$text);
}

//���ز�����html����Ŀ
function ReturnNreInfoWhere(){
	global $public_r;
	if(empty($public_r['nreinfo'])||$public_r['nreinfo']==',')
	{
		return '';
	}
	$cids=substr($public_r['nreinfo'],1,strlen($public_r['nreinfo'])-2);
	$where=' and classid not in ('.$cids.')';
	return $where;
}

//���ر�ǩ��������Ŀ
function ReturnNottoBqWhere(){
	global $public_r;
	if(empty($public_r['nottobq'])||$public_r['nottobq']==',')
	{
		return '';
	}
	$cids=substr($public_r['nottobq'],1,strlen($public_r['nottobq'])-2);
	$where='classid not in ('.$cids.')';
	return $where;
}

//�����ļ�������չ��
function ReturnCFiletype($file){
	$r=explode('.',$file);
	$count=count($r)-1;
	$re['filetype']=strtolower($r[$count]);
	$re['filename']=substr($file,0,strlen($file)-strlen($re['filetype'])-1);
	return $re;
}

//������ĿĿ¼
function ReturnSaveClassPath($classid,$f=0){
	global $class_r;
	$classpath=$class_r[$classid][classpath];
	if($f==1){
		$classpath.="/index".$class_r[$classid][classtype];
	}
	return $classpath;
}

//����ר��Ŀ¼
function ReturnSaveZtPath($classid,$f=0){
	global $class_zr;
	$classpath=$class_zr[$classid][ztpath];
	if($f==1){
		$classpath.="/index".$class_zr[$classid][zttype];
	}
	return $classpath;
}

//���ر������Ŀ¼
function ReturnSaveInfoTypePath($classid,$f=0){
	global $class_tr;
	$classpath=$class_tr[$classid]['tpath'];
	if($f==1){
		$classpath.='/index'.$class_tr[$classid]['ttype'];
	}
	return $classpath;
}

//������ҳ�ļ�
function ReturnSaveIndexFile(){
	global $public_r;
	$file='index'.$public_r[indextype];
	return $file;
}

//������ҳ��ַ
function ReturnSiteIndexUrl(){
	global $public_r;
	if(empty($public_r['indexaddpage']))
	{
		return $public_r['newsurl'];
	}
	if($public_r['indexpagedt']||Moreport_ReturnMustDt())//moreport
	{
		$public_r['indextype']='.php';
	}
	$file=$public_r['newsurl'].'index'.$public_r['indextype'];
	return $file;
}

//��������ҳ���Ŀ¼
function ReturnSaveInfoPath($classid,$id){
	global $class_r;
	if($class_r[$classid][ipath]==''){
		$path=$class_r[$classid][classpath].'/';
	}
	else{
		$path=$class_r[$classid][ipath]=='/'?'':$class_r[$classid][ipath].'/';
	}
	return $path;
}

//��������ҳ�ļ���
function GetInfoFilename($classid,$id){
	global $empire,$dbtbpre,$public_r,$class_r;
	$infor=$empire->fetch1("select isurl,groupid,classid,newspath,filename,id from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
	if(!$infor['id']||$infor['isurl'])
	{
		return '';
	}
	$filetype=$infor['groupid']?'.php':$class_r[$classid]['filetype'];
	$iclasspath=ReturnSaveInfoPath($classid,$id);
	$doclasspath=eReturnTrueEcmsPath().$iclasspath;//moreport
	$newspath='';
	if($infor['newspath'])
	{
		$newspath=$infor['newspath'].'/';
	}
	$file=$doclasspath.$newspath.$infor['filename'].$filetype;
	return $file;
}

//��ʽ����ϢĿ¼
function FormatPath($classid,$mynewspath,$enews=0){
	global $class_r;
	if($enews)
	{
		$newspath=$mynewspath;
	}
	else
	{
		$newspath=date($class_r[$classid][newspath]);
	}
	if(empty($newspath))
	{
		return "";
	}
	$path=eReturnTrueEcmsPath().ReturnSaveInfoPath($classid,$id);
	if(file_exists($path.$newspath))
	{
		return $newspath;
	}
	$returnpath="";
	$r=explode("/",$newspath);
	$count=count($r);
	for($i=0;$i<$count;$i++){
		if($i>0)
		{
			$returnpath.="/".$r[$i];
		}
		else
		{
			$returnpath.=$r[$i];
		}
		$createpath=$path.$returnpath;
		$mk=DoMkdir($createpath);
		if(empty($mk))
		{
			printerror("CreatePathFail","");
		}
	}
	return $returnpath;
}

//��������ҳĿ¼
function ReturnInfoSPath($filename){
	return str_replace('/index','',$filename);
}

//���ظ�Ŀ¼
function ReturnAbsEcmsPath(){
	$ecmspath=str_replace("\\","/",ECMS_PATH);
	return $ecmspath;
}

//���ص�ǰ��Ŀ¼
function eReturnTrueEcmsPath(){
	if(defined('ECMS_SELFPATH'))
	{
		return ECMS_SELFPATH;
	}
	else
	{
		return ECMS_PATH;
	}
}

//�������˸�Ŀ¼
function eReturnEcmsMainPortPath(){
	global $ecms_config;
	if($ecms_config['sets']['mainportpath'])
	{
		return $ecms_config['sets']['mainportpath'];
	}
	else
	{
		return ECMS_PATH;
	}
}


//------------- ���� -------------

//���ظ����ֱ�
function eReturnFileStb($fstb){
	global $public_r;
	$fstb=(int)$fstb;
	if(!strstr($public_r['filedatatbs'],','.$fstb.','))
	{
		$fstb=$public_r['filedeftb'];
	}
	return $fstb;
}

//���ظ�����
function eReturnFileTable($modtype,$fstb){
	global $dbtbpre;
	if($modtype==0)//��Ϣ
	{
		$fstb=eReturnFileStb($fstb);
		$table=$dbtbpre.'enewsfile_'.$fstb;
	}
	elseif($modtype==5)//����
	{
		$table=$dbtbpre.'enewsfile_public';
	}
	elseif($modtype==6)//��Ա
	{
		$table=$dbtbpre.'enewsfile_member';
	}
	else//����
	{
		$table=$dbtbpre.'enewsfile_other';
	}
	return $table;
}

//��ѯ������
function eSelectFileTable($modtype,$fstb,$selectf,$where){
	global $dbtbpre;
	$query="select {$selectf} from ".eReturnFileTable($modtype,$fstb)." where ".$where;
	return $query;
}

//д�븽����¼
function eInsertFileTable($filename,$filesize,$path,$adduser,$classid,$no,$type,$id,$cjid,$fpath,$pubid,$modtype=0,$fstb=1){
	global $empire,$dbtbpre,$public_r;
	$filetime=time();
	$filesize=(int)$filesize;
	$classid=(int)$classid;
	$id=(int)$id;
	$cjid=(int)$cjid;
	$fpath=(int)$fpath;
	$type=(int)$type;
	$modtype=(int)$modtype;
	$filename=addslashes(RepPostStr($filename));
	$no=addslashes(RepPostStr($no));
	$adduser=RepPostVar($adduser);
	$path=addslashes(RepPostStr($path));
	$pubid=RepPostVar($pubid);
	$fstb=(int)$fstb;
	if($modtype==0)//��Ϣ
	{
		$fstb=eReturnFileStb($fstb);
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_".$fstb."(pubid,filename,filesize,adduser,path,filetime,classid,no,type,id,cjid,onclick,fpath) values('$pubid','$filename','$filesize','$adduser','$path','$filetime','$classid','$no','$type','$id','$cjid',0,'$fpath');");
	}
	elseif($modtype==5)//����
	{
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_public(filename,filesize,adduser,path,filetime,modtype,no,type,id,cjid,onclick,fpath) values('$filename','$filesize','$adduser','$path','$filetime',0,'$no','$type','$id','$cjid',0,'$fpath');");
	}
	elseif($modtype==6)//��Ա
	{
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_member(filename,filesize,adduser,path,filetime,no,type,id,cjid,onclick,fpath) values('$filename','$filesize','$adduser','$path','$filetime','$no','$type','$id','$cjid',0,'$fpath');");
	}
	else//����
	{
		$sql=$empire->query("insert into {$dbtbpre}enewsfile_other(filename,filesize,adduser,path,filetime,modtype,no,type,id,cjid,onclick,fpath) values('$filename','$filesize','$adduser','$path','$filetime','$modtype','$no','$type','$id','$cjid',0,'$fpath');");
	}
	return $sql;
}

//������Ӧ�ĸ���(����Ϣ)
function UpdateTheFileOther($modtype,$id,$checkpass,$tb='other'){
	global $empire,$dbtbpre;
	if(empty($id)||empty($checkpass))
	{
		return "";
	}
	$id=(int)$id;
	$checkpass=(int)$checkpass;
	$where='';
	if($tb=='other')
	{
		$where=" and modtype='$modtype'";
	}
	$sql=$empire->query("update {$dbtbpre}enewsfile_{$tb} set id='$id',cjid=0 where cjid='$checkpass'".$where);
}

//�޸�ʱ���¸���(����Ϣ)
function UpdateTheFileEditOther($modtype,$id,$tb='other'){
	global $empire,$dbtbpre;
	$where='';
	if($tb=='other')
	{
		$where=" and modtype='$modtype'";
	}
	$sql=$empire->query("update {$dbtbpre}enewsfile_{$tb} set cjid=0 where id='$id'".$where);
}

//����filepass
function ReturnTranFilepass(){
	$filepass=time();
	return $filepass;
}

//���ظ���������ַ
function eReturnFileUrl($ecms=0){
	global $public_r;
	if($ecms==1)
	{
		return $public_r['fileurl'];
	}
	$fileurl=$public_r['openfileserver']?$public_r['fs_purl']:$public_r['fileurl'];
	return $fileurl;
}

//���ظ���Ŀ¼
function ReturnFileSavePath($classid,$fpath=''){
	global $public_r,$class_r;
	$fpath=$fpath||strstr(','.$fpath.',',',0,')?$fpath:$public_r['fpath'];
	$efileurl=eReturnFileUrl();
	if($fpath==1)//pĿ¼
	{
		$r['filepath']='d/file/p/';
		$r['fileurl']=$efileurl.'p/';
	}
	elseif($fpath==2)//fileĿ¼
	{
		$r['filepath']='d/file/';
		$r['fileurl']=$efileurl;
	}
	else
	{
		if(empty($classid))
		{
			$r['filepath']='d/file/p/';
			$r['fileurl']=$efileurl.'p/';
		}
		else
		{
			$r['filepath']='d/file/'.$class_r[$classid][classpath].'/';
			$r['fileurl']=$efileurl.$class_r[$classid][classpath].'/';
		}
	}
	return $r;
}

//��ʽ������Ŀ¼
function FormatFilePath($classid,$mynewspath,$enews=0){
	global $public_r;
	if($enews)
	{
		$newspath=$mynewspath;
	}
	else
	{
		$newspath=date($public_r['filepath']);
	}
	if(empty($newspath))
	{
		return "";
	}
	$fspath=ReturnFileSavePath($classid);
	$path=eReturnEcmsMainPortPath().$fspath['filepath'];//moreport
	if(file_exists($path.$newspath))
	{
		return $newspath;
	}
	$returnpath="";
	$r=explode("/",$newspath);
	$count=count($r);
	for($i=0;$i<$count;$i++){
		if($i>0){
			$returnpath.="/".$r[$i];
		}
		else{
			$returnpath.=$r[$i];
		}
		$createpath=$path.$returnpath;
		$mk=DoMkdir($createpath);
		if(empty($mk)){
			printerror("CreatePathFail","");
		}
	}
	return $returnpath;
}

//�����ϴ��ļ���
function ReturnDoTranFilename($file_name,$classid){
	$filename=md5(uniqid(microtime()).EcmsRandInt());
	return $filename;
}

//�ϴ��ļ�
function DoTranFile($file,$file_name,$file_type,$file_size,$classid,$ecms=0){
	global $public_r,$class_r,$doetran,$efileftp_fr;
	$classid=(int)$classid;
	//�ļ�����
	$r[filetype]=GetFiletype($file_name);
	//�ļ���
	$r[insertfile]=ReturnDoTranFilename($file_name,$classid);
	$r[filename]=$r[insertfile].$r[filetype];
	//����Ŀ¼
	$r[filepath]=FormatFilePath($classid,$mynewspath,0);
	$filepath=$r[filepath]?$r[filepath].'/':$r[filepath];
	//���Ŀ¼
	$fspath=ReturnFileSavePath($classid);
	$r[savepath]=eReturnEcmsMainPortPath().$fspath['filepath'].$filepath;//moreport
	//������ַ
	$r[url]=$fspath['fileurl'].$filepath.$r[filename];
	//��ͼ�ļ�
	$r[name]=$r[savepath]."small".$r[insertfile];
	//�����ļ�
	$r[yname]=$r[savepath].$r[filename];
	$r[tran]=1;
	//��֤����
	if(CheckSaveTranFiletype($r[filetype]))
	{
		if($doetran)
		{
			$r[tran]=0;
			return $r;
		}
		else
		{
			printerror('TranFail','',$ecms);
		}
	}
	//�ϴ��ļ�
	$cp=@move_uploaded_file($file,$r[yname]);
	if(empty($cp))
	{
		if($doetran)
		{
			$r[tran]=0;
			return $r;
		}
		else
		{
			printerror('TranFail','',$ecms);
		}
	}
	DoChmodFile($r[yname]);
	$r[filesize]=(int)$file_size;
	//FileServer
	if($public_r['openfileserver'])
	{
		$efileftp_fr[]=$r['yname'];
	}
	return $r;
}

//Զ�̱�����Ե�ַ
function CheckNotSaveUrl($url){
	global $public_r;
	if(empty($public_r['notsaveurl']))
	{
		return 0;
    }
	$r=explode("\r\n",$public_r['notsaveurl']);
	$count=count($r);
	$re=0;
	for($i=0;$i<$count;$i++)
	{
		if(empty($r[$i]))
		{continue;}
		if(stristr($url,$r[$i]))
		{
			$re=1;
			break;
	    }
    }
	return $re;
}

//Զ�̱���
function DoTranUrl($url,$classid){
	global $public_r,$class_r,$ecms_config,$efileftp_fr;
	$classid=(int)$classid;
	//�����ַ
	$url=trim($url);
	$url=str_replace(" ","%20",$url);
    $r[tran]=1;
	//������ַ
	$r[url]=$url;
	//�ļ�����
	$r[filetype]=GetFiletype($url);
	if(CheckSaveTranFiletype($r[filetype]))
	{
		$r[tran]=0;
		return $r;
	}
	//�Ƿ����ϴ����ļ�
	$havetr=CheckNotSaveUrl($url);
	if($havetr)
	{
		$r[tran]=0;
		return $r;
	}
	//�Ƿ��ַ
	if(!strstr($url,'://'))
	{
		$r[tran]=0;
		return $r;
	}
	if(!eToCheckIsUrl2($url))
	{
		$r[tran]=0;
		return $r;
	}
	$string=ReadFiletext($url);
	if(empty($string))//��ȡ����
	{
		$r[tran]=0;
		return $r;
	}
	//�ļ���
	$r[insertfile]=ReturnDoTranFilename($file_name,$classid);
	$r[filename]=$r[insertfile].$r[filetype];
	//����Ŀ¼
	$r[filepath]=FormatFilePath($classid,$mynewspath,0);
	$filepath=$r[filepath]?$r[filepath].'/':$r[filepath];
	//���Ŀ¼
	$fspath=ReturnFileSavePath($classid);
	$r[savepath]=eReturnEcmsMainPortPath().$fspath['filepath'].$filepath;//moreport
	//������ַ
	$r[url]=$fspath['fileurl'].$filepath.$r[filename];
	//��ͼ�ļ�
	$r[name]=$r[savepath]."small".$r[insertfile];
	//�����ļ�
	$r[yname]=$r[savepath].$r[filename];
	WriteFiletext_n($r[yname],$string);
	$r[filesize]=@filesize($r[yname]);
	//��������
	if(strstr($ecms_config['sets']['tranflashtype'],','.$r[filetype].','))
	{
		$r[type]=2;
	}
	elseif(strstr($ecms_config['sets']['tranpicturetype'],','.$r[filetype].','))
	{
		$r[type]=1;
	}
	elseif(strstr($ecms_config['sets']['mediaplayertype'],','.$r[filetype].',')||strstr($ecms_config['sets']['realplayertype'],','.$r[filetype].','))//��ý��
	{
		$r[type]=3;
	}
	else
	{
		$r[type]=0;
	}
	//FileServer
	if($public_r['openfileserver'])
	{
		$efileftp_fr[]=$r['yname'];
	}
	return $r;
}

//ɾ������
function DoDelFile($r){
	global $class_r,$public_r,$efileftp_dr;
	$path=$r['path']?$r['path'].'/':$r['path'];
	$fspath=ReturnFileSavePath($r[classid],$r[fpath]);
	$delfile=eReturnEcmsMainPortPath().$fspath['filepath'].$path.$r['filename'];//moreport
	DelFiletext($delfile);
	//FileServer
	if($public_r['openfileserver'])
	{
		$efileftp_dr[]=$delfile;
	}
}

//�滻��ǰ׺
function RepSqlTbpre($sql){
	global $dbtbpre;
	$sql=str_replace('[!db.pre!]',$dbtbpre,$sql);
	return $sql;
}

//���滻��ǰ׺
function ReRepSqlTbpre($sql){
	global $dbtbpre;
	$sql=str_replace($dbtbpre,'***_',$sql);
	return $sql;
}

//��֤���Ƿ����
function eCheckTbname($tbname){
	global $empire,$dbtbpre;
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
	return $num;
}

//ʱ��ת��
function ToChangeUseTime($time){
	global $fun_r;
	$usetime=time()-$time;
	if($usetime<60)
	{
		$tstr=$usetime.$fun_r['TimeSecond'];
	}
	else
	{
		$usetime=round($usetime/60);
		$tstr=$usetime.$fun_r['TimeMinute'];
	}
	return $tstr;
}

//������Ŀ����
function ReturnClass($sonclass){
	if($sonclass==''||$sonclass=='|'){
		return 'classid=0';
	}
	$where='classid in ('.RepSonclassSql($sonclass).')';
	return $where;
}

//�滻����Ŀ��
function RepSonclassSql($sonclass){
	if($sonclass==''||$sonclass=='|'){
		return 0;
	}
	$sonclass=substr($sonclass,1,strlen($sonclass)-2);
	$sonclass=str_replace('|',',',$sonclass);
	return $sonclass;
}

//���ض���Ŀ
function sys_ReturnMoreClass($sonclass,$son=0){
	global $class_r;
	$r=explode(',',$sonclass);
	$count=count($r);
	$return_r[0]=intval($r[0]);
	$where='';
	$or='';
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=intval($r[$i]);
		if($son==1)
		{
			if($class_r[$r[$i]]['tbname']&&!$class_r[$r[$i]]['islast'])
			{
				$where.=$or."classid in (".RepSonclassSql($class_r[$r[$i]]['sonclass']).")";
			}
			else
			{
				$where.=$or."classid='".$r[$i]."'";
			}
		}
		else
		{
			$where.=$or."classid='".$r[$i]."'";
		}
		$or=' or ';
	}
	$return_r[1]=$where;
	return $return_r;
}

//���ض�ר��
function sys_ReturnMoreZt($zt,$ecms=0){
	$f=$ecms==1?'ztid':'cid';
	$r=explode(',',$zt);
	$count=count($r);
	$return_r[0]=intval($r[0]);
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=intval($r[$i]);
		$ids.=$dh.$r[$i];
		$dh=',';
	}
	$return_r[1]=$f.' in ('.$ids.')';
	return $return_r;
}

//���ض�������
function sys_ReturnMoreTT($tt){
	$r=explode(',',$tt);
	$count=count($r);
	$return_r[0]=intval($r[0]);
	$ids='';
	$dh='';
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=intval($r[$i]);
		$ids.=$dh.$r[$i];
		$dh=',';
	}
	$return_r[1]='ttid in ('.$ids.')';
	return $return_r;
}

//��֤�Ƿ������Ŀ
function CheckHaveInClassid($cr,$checkclass){
	global $class_r;
	if($cr['islast'])
	{
		$chclass='|'.$cr['classid'].'|';
	}
	else
	{
		$chclass=$cr['sonclass'];
	}
	$return=0;
	$r=explode('|',$chclass);
	$count=count($r);
	for($i=1;$i<$count-1;$i++)
	{
		if(strstr($checkclass,'|'.$r[$i].'|'))
		{
			$return=1;
			break;
		}
	}
	return $return;
}

//���ؼ�ǰ׺�����ص�ַ
function ReturnDownQzPath($path,$urlid){
	global $empire,$dbtbpre;
	$urlid=(int)$urlid;
	if(empty($urlid))
	{
		$re['repath']=$path;
		$re['downtype']=0;
    }
	else
	{
		$r=$empire->fetch1("select urlid,url,downtype from {$dbtbpre}enewsdownurlqz where urlid='$urlid'");
		if($r['urlid'])
		{
			$re['repath']=$r['url'].$path;
		}
		else
		{
			$re['repath']=$path;
		}
		$re['downtype']=$r['downtype'];
	}
	return $re;
}

//���ش��������ľ��Ե�ַ
function ReturnDSofturl($downurl,$qz,$path='../../',$isdown=0){
	$urlr=ReturnDownQzPath(stripSlashes($downurl),$qz);
	$url=$urlr['repath'];
	@include_once(ECMS_PATH."e/DownSys/class/enpath.php");//������
	if($isdown)
	{
		$url=DoEnDownpath($url);
	}
	else
	{
		$url=DoEnOnlinepath($url);
	}
	return $url;
}

//��֤�ύ��Դ
function CheckCanPostUrl(){
	global $public_r;
	if($public_r['canposturl'])
	{
		$r=explode("\r\n",$public_r['canposturl']);
		$count=count($r);
		$b=0;
		for($i=0;$i<$count;$i++)
		{
			if(strstr($_SERVER['HTTP_REFERER'],$r[$i]))
			{
				$b=1;
				break;
			}
		}
		if($b==0)
		{
			printerror('NotCanPostUrl','',1);
		}
	}
}

//adminpath
function eGetSelfAdminPath(){
	$selfpath=eReturnSelfPage(0);
	$selfpath=str_replace("\\","/",$selfpath);
	if(strstr($selfpath,'//'))
	{
		exit();
	}
	$pr=explode('/e/',$selfpath);
	$pr2=explode('/',$pr[1]);
	$adminpath=$pr2[0];
	if(empty($adminpath))
	{
		exit();
	}
	return $adminpath;
}

//������Դ��֤
function hCheckSpFromUrl(){
	if(defined('EmpireCMSSpFromUrl'))
	{
		return '';
	}
	$spurl=',AddNews.php,ShowInfo.php,ShowWfInfo.php,EditCjNews.php,infoeditor,';
	$r=explode(',',$spurl);
	$count=count($r);
	$fromurl=$_SERVER['HTTP_REFERER'];
	for($i=1;$i<$count;$i++)
	{
		if(empty($r[$i]))
		{
			continue;
		}
		if(stristr($fromurl,$r[$i]))
		{
			printerror("FailHash","history.go(-1)");
		}
	}
}

//�趨������Դ
function hSetSpFromUrl(){
	define('EmpireCMSSpFromUrl',TRUE);
}

//��֤��Դ
function DoSafeCheckFromurl(){
	global $ecms_config;
	if($ecms_config['esafe']['ckfromurl']==0||defined('EmpireCMSNFPage'))//������
	{
		return '';
	}
	$fromurl=$_SERVER['HTTP_REFERER'];
	if(!$fromurl)
	{
		return '';
	}
	$domain=eReturnDomain();
	if($ecms_config['esafe']['ckfromurl']==1)//ȫ������
	{
		if(!stristr($fromurl,$domain))
		{
			echo"";
			exit();
		}
	}
	elseif($ecms_config['esafe']['ckfromurl']==2)//��̨����
	{
		if(defined('EmpireCMSAdmin')&&!stristr($fromurl,$domain.'/'))
		{
			echo"";
			exit();
		}
	}
	elseif($ecms_config['esafe']['ckfromurl']==3)//ǰ̨����
	{
		if(!defined('EmpireCMSAdmin')&&!stristr($fromurl,$domain))
		{
			echo"";
			exit();
		}
	}
	elseif($ecms_config['esafe']['ckfromurl']==4)//ȫ������(�ϸ�)
	{
		if(!stristr($fromurl,$domain))
		{
			echo"";
			exit();
		}
		if(defined('EmpireCMSAdmin'))
		{
			$adminpath=eGetSelfAdminPath();
			if(!stristr($fromurl,'/e/'.$adminpath.'/'))
			{
				echo"";
				exit();
			}
		}
	}
	elseif($ecms_config['esafe']['ckfromurl']==5)//��̨����(�ϸ�)
	{
		if(defined('EmpireCMSAdmin'))
		{
			if(!stristr($fromurl,$domain.'/'))
			{
				echo"";
				exit();
			}
			$adminpath=eGetSelfAdminPath();
			if(!stristr($fromurl,'/e/'.$adminpath.'/'))
			{
				echo"";
				exit();
			}
		}
	}
	elseif($ecms_config['esafe']['ckfromurl']==6)//ǰ̨����(�ϸ�)
	{
		if(!defined('EmpireCMSAdmin')&&!stristr($fromurl,$domain))
		{
			echo"";
			exit();
		}
	}
}

//��֤agent��Ϣ
function EcmsCheckUserAgent($ckstr){
	if(empty($ckstr))
	{
		return '';
	}
	$userinfo=$_SERVER['HTTP_USER_AGENT'];
	$cr=explode('||',$ckstr);
	$count=count($cr);
	for($i=0;$i<$count;$i++)
	{
		if(empty($cr[$i]))
		{
			continue;
		}
		if(!strstr($userinfo,$cr[$i]))
		{
			//echo'Userinfo Error';
			exit();
		}
	}
}

//��֤IP
function eCheckAccessIp($ecms=0){
	global $public_r;
	$userip=egetip();
	if($ecms)//��̨
	{
		//����IP
		if($public_r['hopenip'])
		{
			$close=1;
			foreach(explode("\n",$public_r['hopenip']) as $ctrlip)
			{
				if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
				{
					$close=0;
					break;
				}
			}
			if($close==1)
			{
				echo"Ip<font color='#cccccc'>(".$userip.")</font> be prohibited.";
				exit();
			}
		}
	}
	else
	{
		//����IP
		if($public_r['openip'])
		{
			$close=1;
			foreach(explode("\n",$public_r['openip']) as $ctrlip)
			{
				if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
				{
					$close=0;
					break;
				}
			}
			if($close==1)
			{
				echo"Ip<font color='#cccccc'>(".$userip.")</font> be prohibited.";
				exit();
			}
		}
		//��ֹIP
		if($public_r['closeip'])
		{
			foreach(explode("\n",$public_r['closeip']) as $ctrlip)
			{
				if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
				{
					echo"Ip<font color='#cccccc'>(".$userip.")</font> be prohibited.";
					exit();
				}
			}
		}
	}
}

//��֤�ύIP
function eCheckAccessDoIp($doing){
	global $public_r,$empire,$dbtbpre;
	$pr=$empire->fetch1("select opendoip,closedoip,doiptype from {$dbtbpre}enewspublic limit 1");
	if(!strstr($pr['doiptype'],','.$doing.','))
	{
		return '';
	}
	$userip=egetip();
	//����IP
	if($pr['opendoip'])
	{
		$close=1;
		foreach(explode("\n",$pr['opendoip']) as $ctrlip)
		{
			if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
			{
				$close=0;
				break;
			}
		}
		if($close==1)
		{
			printerror('NotCanPostIp','history.go(-1)',1);
		}
	}
	//��ֹIP
	if($pr['closedoip'])
	{
		foreach(explode("\n",$pr['closedoip']) as $ctrlip)
		{
			if(preg_match("/^(".preg_quote(($ctrlip=trim($ctrlip)),'/').")/",$userip))
			{
				printerror('NotCanPostIp','history.go(-1)',1);
			}
		}
	}
}

//��֤�Ƿ�ر����ģ��
function eCheckCloseMods($mod){
	global $public_r;
	if(strstr($public_r['closemods'],','.$mod.','))
	{
		echo $mod.' is close';
		exit();
	}
}

//��֤����ʱ��
function eCheckTimeCloseDo($ecms){
	global $public_r;
	if(stristr($public_r['timeclosedo'],','.$ecms.','))
	{
		$h=date('G');
		if(strstr($public_r['timeclose'],','.$h.','))
		{
			printerror('ThisTimeCloseDo','history.go(-1)',1);
		}
	}
}

//��֤�ⲿ��¼�Ƿ���
function eCheckCloseMemberConnect(){
	global $public_r;
	if(!$public_r['memberconnectnum'])
	{
		printerror('NotOpenMemberConnect','history.go(-1)',1);
	}
}

//����
function ClearNewsBadCode($text){
	$text=preg_replace(array('!<script!i','!</script>!i','!<link!i','!<iframe!i','!</iframe>!i','!<meta!i','!<body!i','!<style!i','!</style>!i','! onerror!i','!<marquee!i','!</marquee>!i','/<!--/','! onload!i','! onmouse!i','!<frame!i','!<frameset!i'),array('&lt;script','&lt;/script&gt;','&lt;link','&lt;iframe','&lt;/iframe&gt;','&lt;meta','&lt;body','&lt;style','&lt;/style&gt;',' one rror','&lt;marquee','&lt;/marquee&gt;','<!---ecms ',' onl oad',' onm ouse','&lt;frame','&lt;frameset'),$text);
	return $text;
}

//��֤�����ַ�
function toCheckCloseWord($word,$closestr,$mess){
	if($closestr&&$closestr!='|')
	{
		$checkr=explode('|',$closestr);
		$ckcount=count($checkr);
		for($i=0;$i<$ckcount;$i++)
		{
			if($checkr[$i])
			{
				if(stristr($checkr[$i],'##'))//����
				{
					$morer=explode('##',$checkr[$i]);
					if(stristr($word,$morer[0])&&stristr($word,$morer[1]))
					{
						printerror($mess,"history.go(-1)",1);
					}
				}
				else
				{
					if(stristr($word,$checkr[$i]))
					{
						printerror($mess,"history.go(-1)",1);
					}
				}
			}
		}
	}
}

//�滻���۱���
function RepPltextFace($text){
	global $public_r;
	if(empty($public_r['plface'])||$public_r['plface']=='||')
	{
		return $text;
	}
	$facer=explode('||',$public_r['plface']);
	$count=count($facer);
	for($i=1;$i<$count-1;$i++)
	{
		$r=explode('##',$facer[$i]);
		$text=str_replace($r[0],"<img src='".$public_r['newsurl']."e/data/face/".$r[1]."' border=0>",$text);
	}
	return $text;
}

//�滻�ո�
function RepFieldtextNbsp($text){
	return str_replace(array("\t",'   ','  '),array('&nbsp; &nbsp; &nbsp; &nbsp; ','&nbsp; &nbsp;','&nbsp;&nbsp;'),$text);
}

//������չ����֤
function CheckSaveTranFiletype($filetype){
	$savetranfiletype=',.php,.php3,.php4,.php5,.php6,.asp,.aspx,.jsp,.cgi,.phtml,.asa,.asax,.fcgi,.pl,.ascx,.ashx,.cer,.cdx,.pht,.shtml,.shtm,.stm,';
	if(stristr($savetranfiletype,','.$filetype.','))
	{
		return true;
	}
	return false;
}

//������֤��
function ecmsSetShowKey($varname,$val,$ecms=0,$isadmin=0){
	global $public_r;
	$pubkeyrnd=$isadmin==1?$public_r['hkeyrnd']:$public_r['keyrnd'];
	$time=time();
	$checkpass=md5('d!i#g?o-d-'.md5(md5($varname.'E.C#M!S^e-'.$val).'-E?m!P.i#R-e'.$time).$pubkeyrnd.'P#H!o,m^e-e');
	$key=$time.','.$checkpass.',EmpireCMS';
	esetcookie($varname,$key,0,$ecms);
}

//�����֤��
function ecmsCheckShowKey($varname,$postval,$dopr,$ecms=0,$isadmin=0){
	global $public_r;
	$postval=trim($postval);
	if($isadmin==1)
	{
		$pubkeytime=$public_r['hkeytime'];
		$pubkeyrnd=$public_r['hkeyrnd'];
	}
	else
	{
		$pubkeytime=$public_r['keytime'];
		$pubkeyrnd=$public_r['keyrnd'];
	}
	$r=explode(',',getcvar($varname,$ecms));
	$cktime=(int)$r[0];
	$pass=$r[1];
	$val=$r[2];
	$time=time();
	if($cktime>$time||$time-$cktime>$pubkeytime)
	{
		printerror('OutKeytime','',$dopr);
	}
	if(empty($postval))
	{
		printerror('FailKey','',$dopr);
	}
	$checkpass=md5('d!i#g?o-d-'.md5(md5($varname.'E.C#M!S^e-'.$postval).'-E?m!P.i#R-e'.$cktime).$pubkeyrnd.'P#H!o,m^e-e');
	if('dg'.$checkpass<>'dg'.$pass)
	{
		printerror('FailKey','',$dopr);
	}
}

//�����֤��
function ecmsEmptyShowKey($varname,$ecms=0,$isadmin=0){
	esetcookie($varname,'',0,$ecms);
}

//�����ύ��
function DoSetActionPass($userid,$username,$rnd,$other,$ecms=0){
	global $ecms_config;
	$varname='actionepass';
	$date=date("Y-m-d-H");
	$pass=md5(md5($rnd.'-'.$userid.'-'.$date.'-'.$other).$ecms_config['cks']['ckrnd'].$username);
	esetcookie($varname,$pass,0,$ecms);
}

//����ύ��
function DoEmptyActionPass($ecms=0){
	$varname='actionepass';
	esetcookie($varname,'',0,$ecms);
}

//����ύ��
function DoCheckActionPass($userid,$username,$rnd,$other,$ecms=0){
	global $ecms_config;
	$varname='actionepass';
	$date=date("Y-m-d-H");
	$checkpass=md5(md5($rnd.'-'.$userid.'-'.$date.'-'.$other).$ecms_config['cks']['ckrnd'].$username);
	$pass=getcvar($varname,$ecms);
	if('dg'.$checkpass<>'dg'.$pass)
	{
		exit();
	}
}

//�����ֶα�ʶ
function toReturnFname($tbname,$f){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select fname from {$dbtbpre}enewsf where f='$f' and tbname='$tbname' limit 1");
	return $r[fname];
}

//����ƴ��
function ReturnPinyinFun($hz){
	global $ecms_config;
	include_once(ECMS_PATH.'e/class/epinyin.php');
	//����
	if($ecms_config['sets']['pagechar']!='gb2312')
	{
		include_once(ECMS_PATH.'e/class/doiconv.php');
		$iconv=new Chinese('');
		$char=$ecms_config['sets']['pagechar']=='big5'?'BIG5':'UTF8';
		$targetchar='GB2312';
		$hz=$iconv->Convert($char,$targetchar,$hz);
	}
	return c($hz);
}

//ȡ����ĸ
function GetInfoZm($hz){
	if(!trim($hz))
	{
		return '';
	}
	$py=ReturnPinyinFun($hz);
	$zm=substr($py,0,1);
	return strtoupper($zm);
}

//���ؼ��ܺ��IP
function ToReturnXhIp($ip,$n=1){
	$newip='';
	$ipr=explode(".",$ip);
	$ipnum=count($ipr);
	for($i=0;$i<$ipnum;$i++)
	{
		if($i!=0)
		{$d=".";}
		if($i==$ipnum-1)
		{
			$ipr[$i]="*";
		}
		if($n==2)
		{
			if($i==$ipnum-2)
			{
				$ipr[$i]="*";
			}
		}
		$newip.=$d.$ipr[$i];
	}
	return $newip;
}

//��֤�Ƿ�ʹ��https
function eCheckUseHttps(){
	if($_SERVER['HTTPS']&&strtolower($_SERVER['HTTPS'])!='off')
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

//����http����
function eReturnHttpType(){
	global $public_r;
	if($public_r['httptype'])
	{
		if($public_r['httptype']==1)
		{
			return 'http://';
		}
		elseif($public_r['httptype']==2)
		{
			return 'https://';
		}
		elseif($public_r['httptype']==3)
		{
			if(defined('EmpireCMSAdmin'))
			{
				return 'https://';
			}
			else
			{
				return 'http://';
			}
		}
		elseif($public_r['httptype']==4)
		{
			if(defined('EmpireCMSAdmin'))
			{
				return 'http://';
			}
			else
			{
				return 'https://';
			}
		}
	}
	return eCheckUseHttps()==1?'https://':'http://';
}

//���ص�ǰ����2
function eReturnTrueDomain(){
	$domain=RepPostStr($_SERVER['HTTP_HOST'],1);
	if(empty($domain))
	{
		return '';
	}
	return $domain;
}

//���ص�ǰ����
function eReturnDomain(){
	$domain=RepPostStr($_SERVER['HTTP_HOST'],1);
	if(empty($domain))
	{
		return '';
	}
	return eReturnHttpType().$domain;
}

//����������վ��ַ
function eReturnDomainSiteUrl(){
	global $public_r;
	$PayReturnUrlQz=$public_r['newsurl'];
	if(!stristr($public_r['newsurl'],'://'))
	{
		$PayReturnUrlQz=eReturnDomain().$public_r['newsurl'];
	}
	return $PayReturnUrlQz;
}

//���ص�ǰ��ַ
function eReturnSelfPage($ecms=0){
	if(empty($ecms))
	{
		$page=$_SERVER['PHP_SELF'];
	}
	else
	{
		$page=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	}
	$page=str_replace('&amp;','&',RepPostStr($page,1));
	return $page;
}

//��֤��ǰ��ԱȨ��
function sys_CheckMemberGroup($groupid){
	if(!defined('InEmpireCMSUser'))
	{
		include_once ECMS_PATH.'e/member/class/user.php';
	}
	$r=qCheckLoginAuthstr();
	if(!$r['islogin'])
	{
		return 0;
	}
	if(!strstr(','.$groupid.',',','.$r['groupid'].','))
	{
		return -1;
	}
	return 1;
}

//EMAIL��ַ���
function chemail($email){
	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($email, '@') !== false && strpos($email, '.') !== false)
    {
        if (preg_match($chars, $email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

//ȥ��adds
function ClearAddsData($data){
	if(MAGIC_QUOTES_GPC)
	{
		$data=stripSlashes($data);
	}
	return $data;
}

//����adds
function AddAddsData($data){
	if(!MAGIC_QUOTES_GPC)
	{
		$data=addslashes($data);
	}
	return $data;
}

//ԭ�ַ�adds
function StripAddsData($data){
	$data=addslashes(stripSlashes($data));
	return $data;
}

//������adds
function fAddAddsData($data){
	if(MAGIC_QUOTES_GPC)
	{
		$data=addslashes($data);
	}
	return $data;
}

//------- ���ı� -------

//��ȡ�ı��ֶ�����
function GetTxtFieldText($pagetexturl){
	global $ecms_config;
	if(empty($pagetexturl))
	{
		return '';
	}
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	$text=ReadFiletext($file);
	$text=substr($text,12);//ȥ��exit
	return $text;
}

//ȡ���ı���ַ
function GetTxtFieldTextUrl($pagetexturl){
	global $ecms_config;
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	return $file;
}

//�޸��ı��ֶ�����
function EditTxtFieldText($pagetexturl,$pagetext){
	global $ecms_config;
	$pagetext="<? exit();?>".$pagetext;
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	WriteFiletext_n($file,$pagetext);
}

//ɾ���ı��ֶ�����
function DelTxtFieldText($pagetexturl){
	global $ecms_config;
	if(empty($pagetexturl))
	{
		return '';
	}
	$file=$ecms_config['sets']['txtpath'].$pagetexturl.".php";
	DelFiletext($file);
}

//ȡ�������
function GetFileMd5(){
	$p=md5(uniqid(microtime()).EcmsRandInt());
	return $p;
}

//�������Ŀ¼
function MkDirTxtFile($date,$file){
	global $ecms_config;
	$r=explode("/",$date);
	$path=$ecms_config['sets']['txtpath'].$r[0];
	DoMkdir($path);
	$path=$ecms_config['sets']['txtpath'].$date;
	DoMkdir($path);
	$returnpath=$date."/".$file;
	return $returnpath;
}

//�滻�������
function ReplaceSvars($temp,$url,$classid,$title,$key,$des,$add,$repvar=1){
	global $public_r,$class_r,$class_zr;
	if($repvar==1)//ȫ��ģ�����
	{
		$temp=ReplaceTempvar($temp);
	}
	$temp=str_replace('[!--class.menu--]',$public_r['classnavs'],$temp);//��Ŀ����
	$temp=str_replace('[!--newsnav--]',$url,$temp);//λ�õ���
	$temp=str_replace('[!--pagetitle--]',$title,$temp);
	$temp=str_replace('[!--pagekey--]',$key,$temp);
	$temp=str_replace('[!--pagedes--]',$des,$temp);
	$temp=str_replace('[!--self.classid--]',0,$temp);
	$temp=str_replace('[!--news.url--]',$public_r['newsurl'],$temp);
	return $temp;
}

//������������ַ�
function eReturnRDataStr($r){
	$count=count($r);
	if(!$count)
	{
		return '';
	}
	$str=',';
	for($i=0;$i<$count;$i++)
	{
		$str.=$r[$i].',';
	}
	return $str;
}

//------- firewall -------

//��ʾ
function FWShowMsg($msg){
	//echo $msg;
	exit();
}

//����ǽ
function DoEmpireCMSFireWall(){
	global $ecms_config;
	if(!empty($ecms_config['fw']['adminloginurl']))
	{
		$usehost=FWeReturnDomain();
		if($usehost!=$ecms_config['fw']['adminloginurl'])
		{
			FWShowMsg('Login Url');
		}
	}
	if($ecms_config['fw']['adminhour']!=='')
	{
		$h=date('G');
		if(!strstr(','.$ecms_config['fw']['adminhour'].',',','.$h.','))
		{
			FWShowMsg('Admin Hour');
		}
	}
	if($ecms_config['fw']['adminweek']!=='')
	{
		$w=date('w');
		if(!strstr(','.$ecms_config['fw']['adminweek'].',',','.$w.','))
		{
			FWShowMsg('Admin Week');
		}
	}
	if(!defined('EmpireCMSAPage')&&$ecms_config['fw']['adminckpassvar']&&$ecms_config['fw']['adminckpassval'])
	{
		FWCheckPassword();
	}
}

//���ص�ǰ����
function FWeReturnDomain(){
	$domain=RepPostStr($_SERVER['HTTP_HOST'],1);
	if(empty($domain))
	{
		return '';
	}
	return eReturnHttpType().$domain;
}

//��������ַ�
function FWClearGetText($str){
	global $ecms_config;
	if(empty($ecms_config['fw']['eopen']))
	{
		return '';
	}
	if(empty($ecms_config['fw']['cleargettext']))
	{
		return '';
	}
	$r=explode(',',$ecms_config['fw']['cleargettext']);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		if(stristr($r[$i],'##'))//����
		{
			$morer=explode('##',$r[$i]);
			if(stristr($str,$morer[0])&&stristr($str,$morer[1]))
			{
				FWShowMsg('Post String');
			}
		}
		else
		{
			if(stristr($str,$r[$i]))
			{
				FWShowMsg('Post String');
			}
		}
	}
}

//��̨����ǽ����
function FWSetPassword(){
	global $ecms_config;
	if(!$ecms_config['fw']['eopen']||!$ecms_config['fw']['adminckpassvar']||!$ecms_config['fw']['adminckpassval'])
	{
		return '';
	}
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$ecmsckpass=md5(md5($ecms_config['fw']['adminckpassval'].'-empirecms-'.$ecms_config['fw']['epass']).'-'.$ip.'-'.$ecms_config['fw']['adminckpassval'].'-phome.net-');
	esetcookie($ecms_config['fw']['adminckpassvar'],$ecmsckpass,0,1);
}

function FWCheckPassword(){
	global $ecms_config;
	if(!$ecms_config['fw']['eopen']||!$ecms_config['fw']['adminckpassvar']||!$ecms_config['fw']['adminckpassval'])
	{
		return '';
	}
	$ip=$ecms_config['esafe']['ckhloginip']==0?'127.0.0.1':egetip();
	$ecmsckpass=md5(md5($ecms_config['fw']['adminckpassval'].'-empirecms-'.$ecms_config['fw']['epass']).'-'.$ip.'-'.$ecms_config['fw']['adminckpassval'].'-phome.net-');
	if('dg'.$ecmsckpass<>'dg'.getcvar($ecms_config['fw']['adminckpassvar'],1))
	{
		FWShowMsg('Password');
	}
}

function FWEmptyPassword(){
	global $ecms_config;
	esetcookie($ecms_config['fw']['adminckpassvar'],'',0,1);
}


//--------------- ���� ---------------

//ȡ���һ����Ŀ¼
function Ecms_eReturnShowMkdir($path){
	global $ecms_config;
	if(!$ecms_config['sets']['webdebug'])
	{
		return '';
	}
	if(!stristr($path,'/'))
	{
		return '';
	}
	$path=str_replace(eReturnTrueEcmsPath(),'/',$path);
	$r=explode('/',$path);
	$count=count($r);
	if($count<2)
	{
		return '';
	}
	else
	{
		return '/'.$r[$count-1];
	}
}

//����Ŀ¼(��ͨ)
function Ecms_eMkdir($path){
	if(!file_exists($path))
	{
		$mk=@mkdir($path,0777);
		@chmod($path,0777);
		if(empty($mk))
		{
			echo 'Create path fail: '.Ecms_eReturnShowMkdir($path);
			exit();
		}
	}
	return true;
}

//�ݼ�����Ŀ¼
function Ecms_eMoreMkdir($basepath,$path){
	if(empty($path))
	{
		return '';
	}
	if(file_exists($basepath.$path))
	{
		return $path;
	}
	$returnpath='';
	$r=explode('/',$path);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		if(empty($r[$i]))
		{
			continue;
		}
		if($returnpath)
		{
			$returnpath.='/'.$r[$i];
		}
		else
		{
			$returnpath.=$r[$i];
		}
		$createpath=$basepath.$returnpath;
		$mk=Ecms_eMkdir($createpath);
	}
	return $returnpath;
}

//ȡ���ļ�����(������)
function Ecms_ReadFiletext($filepath,$dolock=0){
	$filepath=trim($filepath);
	$htmlfp=@fopen($filepath,"r");
	if($dolock==1)
	{
		flock($htmlfp,LOCK_SH);
	}
	$string=@fread($htmlfp,@filesize($filepath));
	if($dolock==1)
	{
		flock($htmlfp,LOCK_UN); 
	}
	@fclose($htmlfp);
	return $string;
}

//д�ļ�(������)
function Ecms_WriteFiletext($filepath,$string,$dolock=0,$strip=0){
	global $public_r;
	if($strip==1)
	{
		$string=stripSlashes($string);
	}
	$fp=@fopen($filepath,"w");
	if($dolock==1)
	{
		flock($fp,LOCK_EX);
	}
	@fputs($fp,$string);
	if($dolock==1)
	{
		flock($fp,LOCK_UN);
	}
	@fclose($fp);
	if(empty($public_r['filechmod']))
	{
		@chmod($filepath,0777);
	}
}

//�����ļ��޸�ʱ��
function Ecms_GetFileEditTime($filepath){
	return file_exists($filepath)?intval(filemtime($filepath)):0;
}

//ID���ض�̬����Ŀ¼
function ePagenoGetPageCache($cpage){
	$r=array();
	if($cpage==1)//��ҳ
	{
		$r['esyspath']='empirecms';
		$r['cpath']='cindex';
	}
	elseif($cpage==2)//����
	{
		$r['esyspath']='empirecms';
		$r['cpath']='cpage';
	}
	elseif($cpage==3)//�б�
	{
		$r['esyspath']='empirecms';
		$r['cpath']='clist';
	}
	elseif($cpage==4)//����
	{
		$r['esyspath']='empirecms';
		$r['cpath']='ctext';
	}
	elseif($cpage==5)//�������
	{
		$r['esyspath']='empirecms';
		$r['cpath']='cinfotype';
	}
	elseif($cpage==6)//TAGS
	{
		$r['esyspath']='empirecms';
		$r['cpath']='ctags';
	}
	elseif($cpage==10000)//ALLECMS
	{
		$r['esyspath']='empirecms';
		$r['cpath']='';
	}
	else
	{
		$r['esyspath']='';
		$r['cpath']='no';
	}
	return $r;
}

//���ػ����ļ���
function Ecms_eCacheReturnFile($cachetype,$ids,$datepath,$path='empirecms'){
	global $ecms_config,$public_r;
	$filer['basepath']=$ecms_config['sets']['ecmscachepath'].$path.'/';
	$filer['cpath']=$datepath;
	$filer['cfile']=md5($cachetype.'!-'.$ids.'-,'.$public_r['ctimernd'].'-!'.$path).$ecms_config['sets']['ecmscachefiletype'];
	$filer['ctruefile']=$filer['basepath'].$filer['cpath'].'/'.$filer['cfile'];
	return $filer;
}

//�������
function Ecms_eCacheOut($cr,$usedo=0){
	$cachetime=abs($cr['cachetime'])*60;
	$filer=Ecms_eCacheReturnFile($cr['cachetype'],$cr['cacheids'],$cr['cachedatepath'],$cr['cachepath']);
	$cachefile=$filer['ctruefile'];
	$filetime=Ecms_GetFileEditTime($cachefile);
	if(!$filetime)
	{
		return 0;
	}
	$time=time();
	if($time-$filetime>$cachetime)
	{
		return 0;
	}
	$cr['cachelastedit']=(int)$cr['cachelastedit'];
	if($cr['cachelastedit']&&$cr['cachelastedit']>$filetime)
	{
		return 0;
	}
	if($cr['cachelasttime']>=$filetime)
	{
		return 0;
	}
	echo Ecms_ReadFiletext($cachefile);
	if($usedo==0)
	{
		db_close();
		$empire=null;
		exit();
	}
	elseif($usedo==1)
	{
		exit();
	}
	else
	{}
	return 1;
}

//д�뻺��
function Ecms_eCacheIn($cr,$cachetext){
	$filer=Ecms_eCacheReturnFile($cr['cachetype'],$cr['cacheids'],$cr['cachedatepath'],$cr['cachepath']);
	$cachefile=$filer['ctruefile'];
	Ecms_eMoreMkdir($filer['basepath'],$filer['cpath']);
	Ecms_WriteFiletext($cachefile,$cachetext,1);
	echo $cachetext;
}

//��֤�Ƿ����û���
function Ecms_eCacheCheckOpen($cachetime){
	global $ecms_config,$public_r,$ecms_tofunr;
	if(empty($public_r['ctimeopen']))
	{
		return 0;
	}
	if($cachetime>0)
	{
		$open=1;
	}
	elseif($cachetime<0)
	{
		$open=1;
		$userid=(int)getcvar('mluserid');
		if($userid)
		{
			$open=0;
		}
	}
	else
	{
		$open=0;
	}
	if($public_r['ctimegids'])
	{
		$groupid=(int)getcvar('mlgroupid');
		if($groupid&&strstr(','.$public_r['ctimegids'].',',','.$groupid.','))
		{
			$open=0;
		}
	}
	if($public_r['ctimecids']&&$ecms_tofunr['cacheselfcid'])
	{
		$selfcid=(int)$ecms_tofunr['cacheselfcid'];
		if($selfcid&&strstr(','.$public_r['ctimecids'].',',','.$selfcid.','))
		{
			$open=0;
		}
	}
	return $open;
}

//���ø��»���
function eDoUpCache($id,$tname,$ecms=0,$ck=0){
	global $empire,$dbtbpre,$public_r;
	if(empty($public_r['ctimeopen']))
	{
		return '';
	}
	$time=time();
	$uptime=$time-2;
	$addwhere='';
	$addwhere_index=' where fclastindex<'.$uptime;
	if($ck==1)
	{
		$addwhere=' and fclast<'.$uptime;
		$addwhere_index=' where fclastindex<'.$uptime;
	}
	if($ecms==1)//��Ŀ
	{
		if(!$id)
		{
			return '';
		}
		$empire->query("update {$dbtbpre}enewsclass set fclast='$time' where classid in (".$id.")".$addwhere);
	}
	elseif($ecms==2)//�������
	{
		if(!$id)
		{
			return '';
		}
		$empire->query("update {$dbtbpre}enewsinfotype set fclast='$time' where typeid in (".$id.")".$addwhere);
	}
	elseif($ecms==3)//����ҳ
	{
		if(!$id||!$tname)
		{
			return '';
		}
		$empire->query("update {$dbtbpre}ecms_".$tname." set lastdotime='$time' where id in (".$id.")");
	}
	elseif($ecms==4)//TAGS
	{
		if(!$id&&!$tname)
		{
			return '';
		}
		if($tname)
		{
			$tr=explode(',',$tname);
			$tcount=count($tr);
			$where='';
			$or='';
			for($ti=0;$ti<$tcount;$ti++)
			{
				$tr[$ti]=RepPostVar($tr[$ti]);
				if(!$tr[$ti])
				{
					continue;
				}
				$where.=$or."tagname='".$tr[$ti]."'";
				$or=' or ';
			}
			if(!$where)
			{
				return '';
			}
		}
		else
		{
			$where="tagid in (".$id.")";
		}
		$empire->query("update {$dbtbpre}enewstags set fclast='$time' where ".$where.$addwhere);
	}
	else//��ҳ
	{
		$empire->query("update {$dbtbpre}enewspublic_fc set fclastindex='$time'".$addwhere_index." limit 1");
	}
}

//���ø��»���
function eUpCacheInfo($ecms,$classid,$id,$pid,$ttid,$tagid,$tagname,$oldclassid=0,$oldttid=0,$ck=0){
	global $empire,$dbtbpre,$public_r,$class_r;
	if(empty($public_r['ctimeopen']))
	{
		return '';
	}
	$ctimeaddre=$ecms==1?$public_r['ctimeaddre']:$public_r['ctimeqaddre'];
	if(!$ctimeaddre)
	{
		return '';
	}
	$classid=(int)$classid;
	$id=(int)$id;
	$pid=(int)$pid;
	$ttid=(int)$ttid;
	$oldclassid=(int)$oldclassid;
	$oldttid=(int)$oldttid;
	//��ҳ
	if($ctimeaddre==2||$ctimeaddre==4||$ctimeaddre==6||$ctimeaddre==7||$ctimeaddre==8)
	{
		eDoUpCache(0,'',0,$ck);
	}
	//��Ŀ
	if($ctimeaddre!=2)
	{
		if(!empty($classid))
		{
			$cids='';
			if($ctimeaddre==1)//��ǰ
			{
				$cids=$classid;
				if($oldclassid&&$oldclassid!=$classid)
				{
					$cids.=','.$oldclassid;
				}
			}
			else
			{
				$featherclass=$class_r[$classid]['featherclass'];
				if($ctimeaddre>=5)
				{
					if(empty($featherclass))
					{
						$featherclass='|';
					}
					$featherclass.=$classid.'|';
					if($oldclassid&&$oldclassid!=$classid)
					{
						$featherclass.=$oldclassid.'|';
					}
				}
				$cids=eReturnInFcids($featherclass);
			}
			if(empty($cids))
			{
				return '';
			}
			eDoUpCache($cids,'',1,$ck);
		}
	}
	//�������
	if($ctimeaddre>=7)
	{
		if(!empty($ttid))
		{
			if($oldttid&&$oldttid!=$ttid)
			{
				$ttid.=','.$oldttid;
			}
			eDoUpCache($ttid,'',2,$ck);
		}
	}
	//TAGS
	if($ctimeaddre>=8)
	{
		eDoUpCache('',$tagname,4,$ck);
	}
	//��Ϣ
	if($id||$pid)
	{
		$tbname=$class_r[$classid]['tbname'];
		if(!empty($tbname))
		{
			$ids='';
			$iddh='';
			if($id)
			{
				$ids.=$id;
				$iddh=',';
			}
			if($pid)
			{
				$ids.=$iddh.$pid;
				$iddh=',';
			}
			eDoUpCache($ids,$tbname,3,$ck);
		}
	}
}

?>