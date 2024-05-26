<?php
require("../class/connect.php");
require("../class/db_sql.php");
require("../data/dbcache/class.php");
require("../class/q_functions.php");
eCheckCloseMods('search');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();

//����ؼ���
function SearchDoKeyboardVar($keyboard){
	$keyboard=str_replace('  ','',$keyboard);
	$keyboard=RepPostVar2(trim($keyboard));
	return $keyboard;
}

//����SQL
function SearchDoKeyboard($f,$hh,$keyboard){
	$where='';
	$keyboard=SearchDoKeyboardVar($keyboard);
	if(empty($keyboard))
	{
		return "";
	}
	if(!empty($hh))
	{
		if($hh=='LT')//С��
		{
			$where=$f."<'".$keyboard."'";
		}
		elseif($hh=='GT')//����
		{
			$where=$f.">'".$keyboard."'";
		}
		elseif($hh=='EQ')//����
		{
			$where=$f."='".$keyboard."'";
		}
		elseif($hh=='LE')//С�ڵ���
		{
			$where=$f."<='".$keyboard."'";
		}
		elseif($hh=='GE')//���ڵ���
		{
			$where=$f.">='".$keyboard."'";
		}
		elseif($hh=='NE')//������
		{
			$where=$f."<>'".$keyboard."'";
		}
		elseif($hh=='IN')//����
		{
			$kr=explode(' ',$keyboard);
			$kcount=count($kr);
			$kbs='';
			$dh='';
			for($i=0;$i<$kcount;$i++)
			{
				$kr[$i]=(float)$kr[$i];
				if(empty($kr[$i]))
				{
					continue;
				}
				if($kbs)
				{
					$dh=',';
				}
				$kbs.=$dh."'".$kr[$i]."'";
			}
			if($kbs)
			{
				$where=$f." IN (".$kbs.")";
			}
			else
			{
				return '';
			}
		}
		elseif($hh=='BT')//��Χ
		{
			$keyboard=ltrim($keyboard);
			if(!strstr($keyboard,' '))
			{
				return '';
			}
			$kr=explode(' ',$keyboard);
			$kr[0]=(float)$kr[0];
			$kr[1]=(float)$kr[1];
			if(!trim($kr[0])||!trim($kr[1]))
			{
				return '';
			}
			$where=$f." BETWEEN '".$kr[0]."' and '".$kr[1]."'";
		}
		else//����
		{
			$where=$f." LIKE '%".$keyboard."%'";
		}
	}
	else
	{
		$where=$f." LIKE '%".$keyboard."%'";
	}
	return $where;
}

//����
if($_GET['searchget']==1)
{
	$_POST=$_GET;
}

$ip=egetip();
$searchtime=time();
$getvar=$_POST['getvar'];
if(empty($getvar))
{
	$getfrom="history.go(-1)";
	$dogetvar='';
}
else
{
	$getfrom="../../search/";
	$dogetvar="&getvar=1";
}
//����
$getfrom=DoingReturnUrl($getfrom,$_POST['ecmsfrom']);
//�����û���
if($public_r['searchgroupid'])
{
	$psearchgroupid=$public_r['searchgroupid'];
	@include("../data/dbcache/MemberLevel.php");
	$searchgroupid=(int)getcvar('mlgroupid');
	if($level_r[$searchgroupid][level]<$level_r[$psearchgroupid][level])
	{
		printerror("NotLevelToSearch",$getfrom,1);
	}
}
//�������
$lastsearchtime=getcvar('lastsearchtime');
if($lastsearchtime)
{
	if($searchtime-$lastsearchtime<$public_r[searchtime])
	{
		printerror("SearchOutTime",$getfrom,1);
	}
}
//�����ֶ�
$searchclass=$_POST['show'];
if(empty($searchclass)||@strstr($searchclass," "))
{
	printerror("SearchNotRecord",$getfrom,1);
}
//ʱ�䷶Χ
$add='';
$addtime='';
$starttime=RepPostVar($_POST['starttime']);
if(empty($starttime))
{
	$starttime="0000-00-00";
}
$endtime=RepPostVar($_POST['endtime']);
if(empty($endtime))
{
	$endtime="0000-00-00";
}
if($endtime!="0000-00-00")
{
	$addtime=" and (newstime BETWEEN '".to_time($starttime." 00:00:00")."' and '".to_time($endtime." 23:59:59")."')";
}
//�۸�
$addprice='';
$startprice=(int)$_POST['startprice'];
$endprice=(int)$_POST['endprice'];
if($endprice)
{
	$addprice=" and (price BETWEEN ".$startprice." and ".$endprice.")";
}
//������Ŀ����
$classid=RepPostVar($_POST['classid']);
$s_tbname=RepPostVar($_POST['tbname']);
$s_tempid=(int)$_POST['tempid'];
$trueclassid=0;
if($classid)//����Ŀ
{
	if(strstr($classid,","))//����Ŀ
	{
		$son_r=sys_ReturnMoreClass($classid,1);
		$trueclassid=$son_r[0];
		$add.=' and ('.$son_r[1].')';
	}
	else
	{
		$trueclassid=intval($classid);
		$add.=$class_r[$trueclassid][islast]?" and classid='$trueclassid'":" and ".ReturnClass($class_r[$trueclassid][sonclass]);
	}
	$tbname=$class_r[$trueclassid][tbname];
	$modid=$class_r[$trueclassid][modid];
}
elseif($s_tbname)//�����ݱ�
{
	$tbnamenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstable where tbname='$s_tbname' limit 1");
	if(!$tbnamenum)
	{
		printerror("SearchNotRecord",$getfrom,1);
	}
	$tbname=$s_tbname;
	//ģ��id
	$thestemp_r=$empire->fetch1("select modid from ".GetTemptb("enewssearchtemp")." where tempid='$s_tempid'");
	if(empty($thestemp_r['modid']))
	{
		printerror("SearchNotRecord",$getfrom,1);
	}
	$modid=$thestemp_r['modid'];
}
else
{
	$tbname=$public_r['tbname'];
	$modid=0;
}
//������
if(empty($tbname)||InfoIsInTable($tbname))
{
	printerror("SearchNotRecord",$getfrom,1);
}
//�������
$ttid=RepPostVar($_POST['ttid']);
$truettid=0;
if($ttid)
{
	if(strstr($ttid,","))//��������
	{
		$son_r=sys_ReturnMoreTT($ttid);
		$truettid=$son_r[0];
		$add.=' and ('.$son_r[1].')';
	}
	else
	{
		$truettid=intval($ttid);
		$add.=" and ttid='$truettid'";
	}
}
//��Ա
$member=$_POST['member'];
if($member==1)
{
	$add.=' and ismember=1';
}
elseif($member==2)
{
	$add.=' and ismember=0';
}
//ģ��
$tempr=array();
if(empty($class_r[$trueclassid][searchtempid]))
{
	if(empty($modid))
	{
		$tempr=$empire->fetch1("select modid from ".GetTemptb("enewssearchtemp")." where isdefault=1 limit 1");
	}
	else
	{
		$tempr[modid]=$modid;
	}
}
else
{
	$tempr[modid]=$modid;
}

//�ؼ���
$keyboard=$_POST['keyboard'];
$keyboardone=0;
if(is_array($keyboard))
{}
elseif(strstr($keyboard,','))
{
	$keyboard=explode(',',$keyboard);
}
else
{
	$keyboard=trim($keyboard);
	$len=strlen($keyboard);
	if($len<$public_r[min_keyboard]||$len>$public_r[max_keyboard])
	{
		printerror("MinKeyboard",$getfrom,1);
	}
	$keyboardone=1;
}

//����
$hh=$_POST['hh'];
$hhone=0;
if(is_array($hh))
{}
elseif(strstr($hh,','))
{
	$hh=explode(',',$hh);
}
else
{
	$hhone=1;
}

//�ֶ�
if(!is_array($searchclass))
{
	$searchclass=explode(',',$searchclass);
}

$andor=$_POST['andor'];
$andor=$andor=='and'?'and':'or';

$mr=$empire->fetch1("select searchvar,tbname from {$dbtbpre}enewsmod where mid='$tempr[modid]'");
if(!strstr($mr[searchvar],",price,"))//�Ƿ�����۸�
{
	$addprice="";
	$startprice=0;
	$endprice=0;
}
//���������ֶ�
$mr[searchvar].='id,keyboard,userid,username,';
$where='';
$newsearchclass='';
$count=count($searchclass);
for($i=0;$i<$count;$i++)
{
	if(empty($searchclass[$i]))
	{
		continue;
	}
	$searchclass[$i]=str_replace(',','',$searchclass[$i]);
	if(!strstr($mr[searchvar],",".$searchclass[$i].","))
	{
		continue;
	}
	$searchclass[$i]=RepPostVar($searchclass[$i]);
	if(stristr(','.$newsearchclass.',',','.$searchclass[$i].','))
	{
		continue;
	}
	$dh=empty($newsearchclass)?'':',';
	$newsearchclass.=$dh.$searchclass[$i];
	$dohh=$hhone==1?$hh:$hh[$i];
	$dokeyboard=$keyboardone==1?$keyboard:$keyboard[$i];
	if(strlen($dokeyboard)>$public_r['max_keyboard'])
	{
		printerror("MinKeyboard",$getfrom,1);
	}
	$onewhere=SearchDoKeyboard($searchclass[$i],$dohh,$dokeyboard);
	if($onewhere)
	{
		$or=empty($where)?'':' '.$andor.' ';
		$where.=$or.'('.$onewhere.')';
	}
}
//������
if(empty($newsearchclass))
{
	printerror("SearchNotRecord",$getfrom,1);
}
if($where)
{
	$add.=' and ('.$where.')';
}
$allwhere=$add.$addtime.$addprice;
$keyboard=$keyboardone==1?SearchDoKeyboardVar($keyboard):'';
$andsql=addslashes($allwhere);
if(strlen($newsearchclass)>250||strlen($classid)>200||strlen($andsql)>3000||strlen($keyboard)>100||strlen($ttid)>200)
{
	printerror("SearchNotRecord",$getfrom,1);
}
//��֤��
$checkpass=md5($allwhere.$tbname);
$query="select count(*) as total from {$dbtbpre}ecms_".$tbname.($allwhere?' where '.substr($allwhere,5):'');
$search_r=$empire->fetch1("select searchid from {$dbtbpre}enewssearch where checkpass='$checkpass' limit 1");
$searchid=$search_r[searchid];
//����
$orderby=RepPostVar($_POST['orderby']);
$myorder=(int)$_POST['myorder'];
if($orderby)
{
	$orderr=ReturnDoOrderF($tempr[modid],$orderby,$myorder);
	$orderby=$orderr['returnf'];
}
else
{
	$orderby='newstime';
}
//�Ƿ�����ʷ��¼
if($searchid)
{
    $search_num=$empire->gettotal($query);
	$sql=$empire->query("update {$dbtbpre}enewssearch set searchtime='$searchtime',result_num='$search_num',onclick=onclick+1,orderby='$orderby',myorder='$myorder',tempid='$s_tempid' where searchid='$searchid'");
	if(empty($search_num))
	{
		$searchid=0;
	}
}
else
{
	$search_num=$empire->gettotal($query);
	if(empty($search_num))
	{
		$searchid=0;
	}
	else
	{
		$iskey=$keyboardone==1?0:1;
		$sql=$empire->query("insert into {$dbtbpre}enewssearch(searchtime,keyboard,searchclass,result_num,searchip,classid,onclick,orderby,myorder,checkpass,tbname,tempid,iskey,andsql,trueclassid) values('$searchtime','$keyboard','$newsearchclass','$search_num','$ip','$classid',1,'$orderby','$myorder','$checkpass','$tbname','$s_tempid','$iskey','$andsql','$trueclassid')");
		$searchid=$empire->lastid();
	}
}
//�����������ʱ��
$set1=esetcookie("lastsearchtime",$searchtime,$searchtime+3600*24);
if(!$searchid)
{
	printerror("SearchNotRecord",$getfrom,1);
}
else
{
	Header("Location:result/?searchid=$searchid".$dogetvar);
}
db_close();
$empire=null;
?>