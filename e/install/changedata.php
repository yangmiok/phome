<?php
error_reporting(E_ALL ^ E_NOTICE);

@set_time_limit(1000);

if(file_exists("install.off"))
{
	echo"���۹���վ����ϵͳ����װ���������������Ҫ���°�װ����ɾ��<b>/e/install/install.off</b>�ļ���";
	exit();
}

require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
$link=db_connect();
$empire=new mysqlquery();

$ecms=$_GET['ecms'];
$defaultdata=$_GET['defaultdata'];

//----------------���ɱ���JS
function InstallGetPlfaceJs(){
	global $empire,$dbtbpre,$public_r;
	$r=$empire->fetch1("select plface,plfacenum from {$dbtbpre}enewspl_set limit 1");
	if(empty($r['plfacenum']))
	{
		return '';
	}
	$filename="../../d/js/js/plface.js";
	$facer=explode('||',$r['plface']);
	$count=count($facer);
	for($i=1;$i<$count-1;$i++)
	{
		if($i%$r['plfacenum']==0)
		{
			$br="<br>";
		}
		else
		{
			$br="&nbsp;";
		}
		$face=explode('##',$facer[$i]);
		$allface.="<a href='#eface' onclick=\\\"eaddplface('".$face[0]."');\\\"><img src='".$public_r[newsurl]."e/data/face/".$face[1]."' border=0></a>".$br;
	}
	$allface="document.write(\"<script src='".$public_r[newsurl]."e/data/js/addplface.js'></script>\");document.write(\"".$allface."\");";
	WriteFiletext_n($filename,$allface);
}

//������������
if($ecms=='ChangeInstallOtherData')
{
	//--- ɾ�������ļ� ---
	DelListEnews();
	//--- ���¶�̬ҳ�� ---
	GetPlTempPage();//�����б�ģ��
	GetPlJsPage();//����JSģ��
	ReCptemp();//�������ģ��
	GetSearch();//��������ģ��
	GetPrintPage();//��ӡģ��
	GetDownloadPage();//���ص�ַҳ��
	ReGbooktemp();//���԰�ģ��
	ReLoginIframe();//��½״̬ģ��
	ReSchAlltemp();//ȫվ����ģ��
	//������ҳ
	$indextemp=GetIndextemp();
	NewsBq(0,$indextemp,1,0);
	//--- ���·����� ---
	$sql=$empire->query("select bid,btemp from {$dbtbpre}enewsfeedbackclass order by bid");
	while($r=$empire->fetch($sql))
	{
		//�滻��������
		$btemp=ReplaceTempvar($r['btemp']);
		$btemp=str_replace("[!--cp.header--]","<? include(\"../../data/template/cp_1.php\");?>",$btemp);
		$btemp=str_replace("[!--cp.footer--]","<? include(\"../../data/template/cp_2.php\");?>",$btemp);
		$btemp=str_replace("[!--member.header--]","<? include(\"../../template/incfile/header.php\");?>",$btemp);
		$btemp=str_replace("[!--member.footer--]","<? include(\"../../template/incfile/footer.php\");?>",$btemp);
		$file="../tool/feedback/temp/feedback".$r[bid].".php";
		$btemp="<?
if(!defined('InEmpireCMS'))
{exit();}
?>".$btemp;
		WriteFiletext($file,$btemp);
	}
	//--- ���۱����ļ� ---
	InstallGetPlfaceJs();
	echo"�����ļ����.<script>self.location.href='index.php?enews=success&f=6&defaultdata=$defaultdata';</script>";
	exit();
}
else//�������ݿ⻺��
{
	GetConfig(1);//���²�������
	GetClass();//������Ŀ
	GetMemberLevel();//���»�Ա��
	GetSearchAllTb();//����ȫվ�������ݱ�
	echo"�������ݿ⻺�����.<script>self.location.href='changedata.php?ecms=ChangeInstallOtherData&defaultdata=$defaultdata';</script>";
	exit();
}
?>