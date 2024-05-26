<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/delpath.php");
require("../class/copypath.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
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

@set_time_limit(0);

//����
$incftp=0;
if($public_r['phpmode'])
{
	include("../class/ftp.php");
	$incftp=1;
}
//���ɼ�
if($public_r['opennotcj'])
{
	@include("../data/dbcache/notcj.php");
}

//��ʱˢ������
function DoTimeRepage($time){
	global $empire,$dbtbpre;
	if(empty($time))
	{$time=120;}
	echo"<meta http-equiv=\"refresh\" content=\"".$time.";url=DoTimeRepage.php".hReturnEcmsHashStrHref(1)."\">";
	DoAutoUpAndDownInfo();//�Զ���/����
	$todaytime=time();
	$b=0;
	$sql=$empire->query("select doing,classid,doid from {$dbtbpre}enewsdo where isopen=1 and lasttime+dotime*60<$todaytime");
	while($r=$empire->fetch($sql))
	{
		$b=1;
		if($r[doing]==1)//������Ŀ
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				ReListHtml($cr[$i],1);
			}
	    }
		elseif($r[doing]==2)//����ר��
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				ListHtmlIndex($cr[$i],$ret_r[0],0);
			}
	    }
		elseif($r[doing]==3)//�����Զ����б�
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				$ur=$empire->fetch1("select listid,pagetitle,filepath,filetype,totalsql,listsql,maxnum,lencord,listtempid,pagekeywords,pagedescription from {$dbtbpre}enewsuserlist where listid='".$cr[$i]."'");
				ReUserlist($ur,"");
			}
	    }
		elseif($r[doing]==4)//�����Զ���ҳ��
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				$ur=$empire->fetch1("select id,path,pagetext,title,pagetitle,pagekeywords,pagedescription,tempid from {$dbtbpre}enewspage where id='".$cr[$i]."'");
				ReUserpage($ur[id],$ur[pagetext],$ur[path],$ur[title],$ur[pagetitle],$ur[pagekeywords],$ur[pagedescription],$ur[tempid]);
			}
	    }
		elseif($r[doing]==5)//�����Զ���JS
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				$ur=$empire->fetch1("select jsid,jsname,jssql,jstempid,jsfilename from {$dbtbpre}enewsuserjs where jsid='".$cr[$i]."'");
				ReUserjs($ur,'');
			}
	    }
		elseif($r[doing]==6)//���ɱ������ҳ��
		{
			$cr=explode(',',$r[classid]);
			$count=count($cr)-1;
			for($i=1;$i<$count;$i++)
			{
				if(empty($cr[$i]))
				{
					continue;
				}
				$cr[$i]=(int)$cr[$i];
				ListHtml($cr[$i],$ret_r,5);
			}
	    }
		else//������ҳ
		{
			$indextemp=GetIndextemp();
			NewsBq($classid,$indextemp,1,0);
	    }
		$empire->query("update {$dbtbpre}enewsdo set lasttime=$todaytime where doid='$r[doid]'");
    }
	if($b)
	{
		echo "���ִ��ʱ�䣺".date("Y-m-d H:i:s",$todaytime)."<br><br>";
	}
}

//��ʱ����/����
function DoAutoUpAndDownInfo(){
	global $empire,$dbtbpre,$class_r,$emod_r,$public_r;
	$todaytime=time();
	$sql=$empire->query("select id,classid,infouptime,infodowntime from {$dbtbpre}enewsinfovote where infouptime>0 or infodowntime>0");
	while($r=$empire->fetch($sql))
	{
		if(!$class_r[$r[classid]]['tbname'])
		{
			continue;
		}
		//����
		if($r['infouptime']&&$r['infouptime']<=$todaytime)
		{
			$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_check where id='$r[id]' limit 1");
			if(!$infor['id'])
			{
				continue;
			}
			//ǩ��
			if($infor['isqf'])
			{
				$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$r[id]' and classid='$r[classid]' limit 1");
				if($qfr['checktno']!='100')
				{
					continue;
				}
			}
			$empire->query("update {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_index set checked=1 where id='$r[id]' limit 1");
			$pubid=ReturnInfoPubid($r['classid'],$r['id']);
			$empire->query("update {$dbtbpre}enewsinfovote set infouptime=0 where pubid='$pubid' limit 1");
			//��ת
			MoveCheckInfoData($class_r[$r[classid]][tbname],0,$infor['stb'],"id='$r[id]'");
			AddClassInfos($r['classid'],'','+1');
			//ˢ����Ϣ
			GetHtml($infor['classid'],$infor['id'],$infor,1);
			//ˢ���б�
			ReListHtml($r[classid],1);
		}
		//����
		if($r['infodowntime']&&$r['infodowntime']<=$todaytime)
		{
			$mid=$class_r[$r[classid]][modid];
			$tbname=$class_r[$r[classid]][tbname];
			$pf=$emod_r[$mid]['pagef'];
			$stf=$emod_r[$mid]['savetxtf'];
			//����
			$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]." where id='".$r[id]."' limit 1");
			if(!$infor['id'])
			{
				continue;
			}
			//ǩ��
			if($infor['isqf'])
			{
				$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$r[id]' and classid='$r[classid]' limit 1");
				if($qfr['checktno']!='100')
				{
					continue;
				}
			}
			//��ҳ�ֶ�
			if($pf)
			{
				if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_data_".$infor[stb]." where id='$r[id]' limit 1");
					$infor[$pf]=$finfor[$pf];
				}
				if($stf&&$stf==$pf)//����ı�
				{
					$infor[$pf]=GetTxtFieldText($infor[$pf]);
				}
			}
			DelNewsFile($infor[filename],$infor[newspath],$infor[classid],$infor[$pf],$infor[groupid]);
			$empire->query("update {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_index set checked=0,havehtml=0 where id='$r[id]' limit 1");
			$pubid=ReturnInfoPubid($r['classid'],$r['id']);
			$empire->query("update {$dbtbpre}enewsinfovote set infodowntime=0 where pubid='$pubid' limit 1");
			//��ת
			MoveCheckInfoData($class_r[$r[classid]][tbname],1,$infor['stb'],"id='$r[id]'");
			AddClassInfos($r['classid'],'','-1');
			//ˢ���б�
			ReListHtml($r[classid],1);
		}
	}
}

DoTimeRepage(120);//�Զ�ˢ��ҳ��
db_close();
$empire=null;
?>
<b>˵������ҳ��Ϊ��ʱˢ������ִ�д���.</b>