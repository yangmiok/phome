<?php
//��λ��
function SearchReturnQwm($t){
	return sprintf("%02d%02d",ord($t[0])-160,ord($t[1])-160);
}

//ת���ַ���
function SearchReturnSaveStr($str){
	//���к��ֺ����ASCII��0�ַ�,�˷���Ϊ���ų��������Ĳ�ִ��������
	$str=preg_replace("/[\x80-\xff]{2}/","\\0".chr(0x00),$str);
	//��ֵķָ��
	$search = array(",", "/", "\\", ".", ";", ":", "\"", "!", "~", "`", "^", "(", ")", "?", "-", "\t", "\n", "'", "<", ">", "\r", "\r\n", "$", "&", "%", "#", "@", "+", "=", "{", "}", "[", "]", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��",);
	//�滻���еķָ��Ϊ�ո�
	$str = str_replace($search,' ',$str);
	//������ƥ���ǵ����ַ�����ȫ�ǵ����ַ�,��������$ar
	preg_match_all("/[\x80-\xff]?./",$str,$ar);$ar=$ar[0];
	//ȥ��$ar��ASCIIΪ0�ַ�����Ŀ
	for($i=0;$i<count($ar);$i++)
	{
		if($ar[$i]!=chr(0x00))
		{
			$ar_new[]=$ar[$i];
		}
	}
	$ar=$ar_new;
	unset($ar_new);
	$oldsw=0;
	//�������İ�Ǵ��һ�������±�,����ȫ�ǵ�ÿ2���ַ����һ��������±�
	for($ar_str='',$i=0;$i<count($ar);$i++)
	{
		$sw=strlen($ar[$i]);
		if($i>0 and $sw!=$oldsw)
		{
			$ar_str.=" ";
		}
		if($sw==1)
		{
			$ar_str.=$ar[$i];
		}
		else
		{
			if(strlen($ar[$i+1])==2)
			{
				$ar_str.=SearchReturnQwm($ar[$i]).SearchReturnQwm($ar[$i+1]).' ';
			}
			elseif($oldsw==1 or $oldsw==0)
			{
				$ar_str.=SearchReturnQwm($ar[$i]);
			}
		}
		$oldsw=$sw;
	}
	//ȥ�������Ŀո�
	$ar_str=trim(preg_replace("# {1,}#i"," ",$ar_str));
	//���ز�ֺ�Ľ��
	return $ar_str;
}

//ȫվ����ȥ��html
function ClearSearchAllHtml($value){
	$value=str_replace(array("\r\n","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","","",""),$value);
	$value=strip_tags($value);
	$value=trim($value,"\r\n");
	$value=SearchAllChangeChar($value);//ת����
	return $value;
}

//ת������
function SearchAllChangeChar($value){
	global $ecms_config,$char,$targetchar,$iconv;
	if($ecms_config['sets']['pagechar']!='gb2312')
	{
		$value=$iconv->Convert($char,$targetchar,$value);
	}
	return $value;
}

//��������
function LoadSearchAll($lid,$start,$userid,$username){
	global $empire,$dbtbpre,$class_r,$fun_r,$public_r,$emod_r;
	$lid=(int)$lid;
	if(empty($lid))
	{
		printerror('ErrorUrl','');
	}
	$lr=$empire->fetch1("select tbname,titlefield,infotextfield,loadnum,lastid from {$dbtbpre}enewssearchall_load where lid='$lid'");
	if(empty($lr['tbname']))
	{
		printerror('ErrorUrl','');
	}
	//��������Ŀ
	$pr=$empire->fetch1("select schallnotcid from {$dbtbpre}enewspublic limit 1");
	$line=$lr['loadnum'];
	if(empty($line))
	{
		$line=300;
	}
	$start=(int)$start;
	if($start<$lr['lastid'])
	{
		$start=$lr['lastid'];
	}
	//�ֶ�
	$selectdtf='';
	$selectf='';
	$savetxtf='';
	$fsql=$empire->query("select tid,f,savetxt,tbdataf from {$dbtbpre}enewsf where (f='$lr[titlefield]' or f='$lr[infotextfield]') and tbname='$lr[tbname]' limit 2");
	while($fr=$empire->fetch($fsql))
	{
		if($fr['tbdataf'])
		{
			$selectdtf.=','.$fr[f];
		}
		else
		{
			$selectf.=','.$fr[f];
		}
		if($fr['savetxt'])
		{
			$savetxtf=$fr[f];
		}
	}
	$b=0;
	$sql=$empire->query("select id,stb,classid,isurl,newstime".$selectf." from {$dbtbpre}ecms_".$lr['tbname']." where id>$start order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r['id'];
		if($r['isurl'])
		{
			continue;
		}
		if(empty($class_r[$r[classid]]['tbname']))
		{
			continue;
		}
		if(strstr($pr['schallnotcid'],','.$r[classid].','))
		{
			continue;
		}
		//�ظ�
		$havenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewssearchall where id='$r[id]' and classid='$r[classid]' limit 1");
		if($havenum)
		{
			continue;
		}
		//����
		if($selectdtf)
		{
			$finfor=$empire->fetch1("select id".$selectdtf." from {$dbtbpre}ecms_".$lr['tbname']."_data_".$r[stb]." where id='$r[id]'");
			$r=array_merge($r,$finfor);
		}
		//���ı�
		if($savetxtf)
		{
			$r[$savetxtf]=GetTxtFieldText($r[$savetxtf]);
		}
		$infotext=$r[$lr[infotextfield]];
		$title=$r[$lr[titlefield]];
		$infotime=$r[newstime];
		$title=SearchReturnSaveStr(ClearSearchAllHtml(stripSlashes($title)));
		$infotext=SearchReturnSaveStr(ClearSearchAllHtml(stripSlashes($infotext)));
		$empire->query("insert into {$dbtbpre}enewssearchall(sid,id,classid,title,infotime,infotext) values(NULL,'$r[id]','$r[classid]','".addslashes($title)."','$infotime','".addslashes($infotext)."');");
	}
	if(empty($b))
	{
		$lasttime=time();
		if(empty($newstart))
		{
			$newstart=$start;
		}
		$empire->query("update {$dbtbpre}enewssearchall_load set lasttime='$lasttime',lastid='$newstart' where lid='$lid'");
		echo "<link rel=\"stylesheet\" href=\"../../data/images/css.css\" type=\"text/css\"><center><b>".$lr['tbname'].$fun_r[LoadSearchAllIsOK]."</b></center>";
		db_close();
		$empire=null;
		exit();
	}
	echo"<link rel=\"stylesheet\" href=\"../../data/images/css.css\" type=\"text/css\"><meta http-equiv=\"refresh\" content=\"0;url=LoadSearchAll.php?enews=LoadSearchAll&lid=$lid&start=$newstart".hReturnEcmsHashStrHref(0)."\">".$fun_r[OneLoadSearchAllSuccess]."(ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

//��������SQL
function ReturnSearchAllSql($add){
	global $public_r,$class_r;
	//�ر�
	if(empty($public_r['openschall']))
	{
		printerror("SchallClose",'',1);
	}
	//�ؼ���
	$keyboard=RepPostVar2($add['keyboard']);
	if(!trim($keyboard))
	{
		printerror('EmptySchallKeyboard','',1);
	}
	$strlen=strlen($keyboard);
	if($strlen<$public_r['schallminlen']||$strlen>$public_r['schallmaxlen'])
	{
		printerror('SchallMinKeyboard','',1);
	}
	$returnr['keyboard']=ehtmlspecialchars($keyboard);
	$returnr['search']="&keyboard=".$keyboard;
	//�ֶ�
	$field=(int)$add['field'];
	if($field)
	{
		$returnr['search'].="&field=".$field;
	}
	if($field==1)//�����ȫ��
	{
		if($public_r['schallfield']!=1)
		{
			printerror('SchallNotOpenTitleText','',1);
		}
		$sf="title,infotext";
	}
	elseif($field==2)//����
	{
		if($public_r['schallfield']==3)
		{
			printerror('SchallNotOpenTitle','',1);
		}
		$sf="title";
	}
	elseif($field==3)//ȫ��
	{
		if($public_r['schallfield']==2)
		{
			printerror('SchallNotOpenText','',1);
		}
		$sf="infotext";
	}
	else
	{
		$sf=ReturnSearchAllField(0);
	}
	$where='';
	//��Ŀ
	$classid=RepPostVar($add['classid']);
	if($classid)
	{
		$returnr['search'].="&classid=".$classid;
		if(strstr($classid,","))//����Ŀ
		{
			$son_r=sys_ReturnMoreClass($classid,1);
			$where.='('.$son_r[1].') and ';
		}
		else
		{
			$classid=(int)$classid;
			$where.=$class_r[$classid][islast]?"classid='$classid' and ":ReturnClass($class_r[$classid][sonclass]).' and ';
		}
	}
	//�ؼ���
	if(strstr($keyboard,' '))
	{
		$andkey='';
		$keyr=explode(' ',$keyboard);
		$kcount=count($keyr);
		for($i=0;$i<$kcount;$i++)
		{
			if(strlen($keyr[$i])<$public_r['schallminlen'])
			{
				continue;
			}
			$kb=SearchAllChangeChar($keyr[$i]);//ת��
			$kb=SearchReturnSaveStr($kb);
			$kb=RepPostVar2($kb);
			if(!trim($kb))
			{
				continue;
			}
			$where.=$andkey."MATCH(".$sf.") AGAINST('".$kb."' IN BOOLEAN MODE)";
			$andkey=' and ';
		}
		if(empty($where))
		{
			printerror('SchallMinKeyboard','',1);
		}
	}
	else
	{
		$keyboard=SearchAllChangeChar($keyboard);//ת��
		$keyboard=SearchReturnSaveStr($keyboard);
		$keyboard=RepPostVar2($keyboard);
		if(!trim($keyboard))
		{
			printerror('EmptySchallKeyboard','',1);
		}
		$where.="MATCH(".$sf.") AGAINST('".$keyboard."' IN BOOLEAN MODE)";
	}
	$returnr['where']=$where;
	return $returnr;
}

//���������ֶ�
function ReturnSearchAllField($field){
	global $public_r;
	if($public_r['schallfield']==1)
	{
		$sf="title,infotext";
	}
	elseif($public_r['schallfield']==3)
	{
		$sf="infotext";
	}
	else
	{
		$sf="title";
	}
	return $sf;
}
?>