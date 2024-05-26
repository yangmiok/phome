<?php
if(!defined('InEmpireCMS'))
{
	exit();
}

//-------- ����ת��
function DoWapIconvVal($str){
	global $ecms_config,$iconv,$pr;
	if($pr['wapchar']==2)
	{
		return $str;
	}
	if($ecms_config['sets']['pagechar']!='utf-8')
	{
		$char=$ecms_config['sets']['pagechar']=='big5'?'BIG5':'GB2312';
		$targetchar=$pr['wapchar']?'UTF8':'UNICODE';
		$str=$iconv->Convert($char,$targetchar,$str);
	}
	return $str;
}

//-------- ��ʾ��Ϣ
function DoWapShowMsg($error,$returnurl='index.php',$ecms=0){
	global $empire,$public_r;
	$gotourl=str_replace('&amp;','&',$returnurl);
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
		@include(ECMS_PATH.'e/wap/message.php');
	}
	db_close();
	$empire=null;
	exit();
}

//-------- ͷ��
function DoWapHeader($title){
	global $ecms_config;
	ob_start();
	header("Content-type: text/vnd.wap.wml; charset=utf-8");
	echo'<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<head>
<meta http-equiv="Cache-Control" content="max-age=180,private" />
</head>
<card id="empirecms_wml" title="<?php echo $title;?>">
<?php
}

//-------- β��
function DoWapFooter(){
?>
<p><br/><small>Powered by EmpireCMS</small></p>
</card></wml>
<?php
	$str=ob_get_contents();
	ob_end_clean();
	echo DoWapIconvVal($str);
}

//-------- ��ҳ
function DoWapListPage($num,$line,$page,$search){
	if(empty($num))
	{
		return '';
	}
	$str='';
	$pagenum=ceil($num/$line);
	$search=RepPostStr($search,1);
	$phpself=eReturnSelfPage(0);
	if($page)//��ҳ
	{
		$str.="<a href=\"".$phpself."?page=0".$search."\">��ҳ</a>&nbsp;";
	}
	if($page)
	{
		$str.="<a href=\"".$phpself."?page=".($page-1).$search."\">��һҳ</a>&nbsp;";
	}
	if($page!=$pagenum-1)
	{
		$str.="<a href=\"".$phpself."?page=".($page+1).$search."\">��һҳ</a>&nbsp;";
	}
	if($page!=$pagenum-1)
	{
		$str.="<a href=\"".$phpself."?page=".($pagenum-1).$search."\">βҳ</a>&nbsp;";
	}
	return $str;
}

//-------- �滻<p> --------
function DoWapRepPtags($text){
	$text=str_replace(array('<p>','<P>','</p>','</P>'),array('','','<br />','<br />'),$text);
	$preg_str="/<(p|P) (.+?)>/is";
	$text=preg_replace($preg_str,"",$text);
	return $text;
}

//-------- �ֶ����� --------
function DoWapRepField($text,$f,$field){
	global $modid,$emod_r;
	$modid=(int)$modid;
	if(strstr($emod_r[$modid]['tobrf'],','.$f.','))//��br
	{
		$text=nl2br($text);
	}
	if(!strstr($emod_r[$modid]['dohtmlf'],','.$f.','))//ȥ��html
	{
		$text=ehtmlspecialchars($text);
	}
	return $text;
}

//-------- ȥ��html���� --------
function DoWapClearHtml($text){
	$text=stripSlashes($text);
	$text=ehtmlspecialchars(strip_tags($text));
	return $text;
}

//-------- �滻�ֶ�����
function DoWapRepF($text,$f,$field){
	$text=stripSlashes($text);
	$text=DoWapRepPtags($text);
	$text=DoWapRepField($text,$f,$field);
	return $text;
}

//-------- �滻���������ֶ�
function DoWapRepNewstext($text){
	$text=stripSlashes($text);
	$text=DoWapRepPtags($text);
	return $text;
}

//-------- �����ַ�ȥ��
function DoWapCode($string){
	$string=str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
	return $string;
}

//-------- ����ʹ��ģ��
function ReturnWapStyle($add,$style){
	global $empire,$dbtbpre,$pr,$class_r;
	if(!$pr['wapchstyle'])
	{
		$style=0;
	}
	$style=(int)$style;
	$styleid=$pr['wapdefstyle'];
	$classid=0;
	if(WapPage=='index')
	{
		$classid=(int)$add['bclassid'];
	}
	elseif(WapPage=='list')
	{
		$classid=(int)$add['classid'];
	}
	elseif(WapPage=='show')
	{
		$classid=(int)$add['classid'];
	}
	if($classid&&$class_r[$classid]['tbname'])
	{
		$cr=$empire->fetch1("select wapstyleid from {$dbtbpre}enewsclass where classid='$classid'");
		if($cr['wapstyleid'])
		{
			$styleid=$cr['wapstyleid'];
		}
	}
	if($style&&$styleid==$pr['wapdefstyle'])
	{
		$styleid=$style;
	}
	$sr=$empire->fetch1("select path from {$dbtbpre}enewswapstyle where styleid='$styleid'");
	$wapstyle=$sr['path'];
	if(empty($wapstyle))
	{
		$wapstyle=1;
	}
	return $wapstyle;
}


//----------------- ģ������� ------------------

//����sql���
function ewap_ReturnBqQuery($classid,$line,$enews=0,$do=0,$ewhere='',$eorder=''){
	global $empire,$public_r,$class_r,$class_zr,$navclassid,$dbtbpre,$fun_r,$class_tr,$emod_r,$etable_r,$eyh_r;
	$navclassid=(int)$navclassid;
	if($enews==24)//��sql��ѯ
	{
		$query_first=substr($classid,0,7);
		if(!($query_first=='select '||$query_first=='SELECT '))
		{
			return "";
		}
		$classid=RepSqlTbpre($classid);
		$sql=$empire->query1($classid);
		if(!$sql)
		{
			echo"SQL Error: ".ReRepSqlTbpre($classid);
		}
		return $sql;
	}
	if($enews==0||$enews==1||$enews==2||$enews==9||$enews==12||$enews==15)//��Ŀ
	{
		if(strstr($classid,','))//����Ŀ
		{
			$son_r=sys_ReturnMoreClass($classid,1);
			$classid=$son_r[0];
			$where=$son_r[1];
		}
		else
		{
			if($classid=='selfinfo')//��ʾ��ǰ��Ŀ��Ϣ
			{
				$classid=$navclassid;
			}
			if($class_r[$classid][islast])
			{
				$where="classid='$classid'";
			}
			else
			{
				$where=ReturnClass($class_r[$classid][sonclass]);
			}
		}
		$tbname=$class_r[$classid][tbname];
		$mid=$class_r[$classid][modid];
		$yhid=$class_r[$classid][yhid];
    }
	elseif($enews==6||$enews==7||$enews==8||$enews==11||$enews==14||$enews==17)//ר��
	{
		echo"Error��Change to use e:indexloop";
		return false;
	}
	elseif($enews==25||$enews==26||$enews==27||$enews==28||$enews==29||$enews==30)//�������
	{
		if(strstr($classid,','))//��������
		{
			$son_r=sys_ReturnMoreTT($classid);
			$classid=$son_r[0];
			$where=$son_r[1];
		}
		else
		{
			if($classid=='selfinfo')//��ʾ��ǰ���������Ϣ
			{
				$classid=$navclassid;
			}
			$where="ttid='$classid'";
		}
		$mid=$class_tr[$classid][mid];
		$tbname=$emod_r[$mid][tbname];
		$yhid=$class_tr[$classid][yhid];
	}
	$query='';
	$qand=' and ';
	if($enews==0)//��Ŀ����
	{
		$query=' where ('.$where.')';
		$order='newstime';
		$yhvar='bqnew';
    }
	elseif($enews==1)//��Ŀ����
	{
		$query=' where ('.$where.')';
		$order='onclick';
		$yhvar='bqhot';
    }
	elseif($enews==2)//��Ŀ�Ƽ�
	{
		$query=' where ('.$where.') and isgood>0';
		$order='newstime';
		$yhvar='bqgood';
    }
	elseif($enews==9)//��Ŀ��������
	{
		$query=' where ('.$where.')';
		$order='plnum';
		$yhvar='bqpl';
    }
	elseif($enews==12)//��Ŀͷ��
	{
		$query=' where ('.$where.') and firsttitle>0';
		$order='newstime';
		$yhvar='bqfirst';
    }
	elseif($enews==15)//��Ŀ��������
	{
		$query=' where ('.$where.')';
		$order='totaldown';
		$yhvar='bqdown';
    }
	elseif($enews==3)//��������
	{
		$qand=' where ';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqnew';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==4)//���е������
	{
		$qand=' where ';
		$order='onclick';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqhot';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==5)//�����Ƽ�
	{
		$query=' where isgood>0';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqgood';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==10)//������������
	{
		$qand=' where ';
		$order='plnum';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqpl';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==13)//����ͷ��
	{
		$query=' where firsttitle>0';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqfirst';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==16)//������������
	{
		$qand=' where ';
		$order='totaldown';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqdown';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==18)//��������
	{
		$qand=' where ';
		$order='newstime';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqnew';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==19)//��������
	{
		$qand=' where ';
		$order='onclick';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqhot';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==20)//�����Ƽ�
	{
		$query=' where isgood>0';
		$order='newstime';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqgood';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==21)//������������
	{
		$qand=' where ';
		$order='plnum';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqpl';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==22)//����ͷ����Ϣ
	{
		$query=' where firsttitle>0';
		$order="newstime";
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqfirst';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==23)//������������
	{
		$qand=' where ';
		$order='totaldown';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqdown';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==25)//�����������
	{
		$query=' where ('.$where.')';
		$order='newstime';
		$yhvar='bqnew';
    }
	elseif($enews==26)//�������������
	{
		$query=' where ('.$where.')';
		$order='onclick';
		$yhvar='bqhot';
    }
	elseif($enews==27)//��������Ƽ�
	{
		$query=' where ('.$where.') and isgood>0';
		$order='newstime';
		$yhvar='bqgood';
    }
	elseif($enews==28)//���������������
	{
		$query=' where ('.$where.')';
		$order='plnum';
		$yhvar='bqpl';
    }
	elseif($enews==29)//�������ͷ��
	{
		$query=' where ('.$where.') and firsttitle>0';
		$order='newstime';
		$yhvar='bqfirst';
    }
	elseif($enews==30)//���������������
	{
		$query=' where ('.$where.')';
		$order='totaldown';
		$yhvar='bqdown';
    }
	//�Ż�
	$yhadd='';
	if(!empty($eyh_r[$yhid]['dobq']))
	{
		$yhadd=ReturnYhSql($yhid,$yhvar);
		if(!empty($yhadd))
		{
			$query.=$qand.$yhadd;
			$qand=' and ';
		}
	}
	//������
	if(!strstr($public_r['nottobq'],','.$classid.','))
	{
		$notbqwhere=ReturnNottoBqWhere();
		if(!empty($notbqwhere))
		{
			$query.=$qand.$notbqwhere;
			$qand=' and ';
		}
	}
	//ͼƬ��Ϣ
	if(!empty($do))
	{
		$query.=$qand.'ispic=1';
		$qand=' and ';
    }
	//��������
	if(!empty($ewhere))
	{
		$query.=$qand.'('.$ewhere.')';
		$qand=' and ';
	}
	//��ֹ
	if(empty($tbname))
	{
		echo "ClassID=<b>".$classid."</b> Table not exists.(DoType=".$enews.")";
		return false;
	}
	//����
	$addorder=empty($eorder)?$order.' desc':$eorder;
	$query='select '.ReturnSqlListF($mid).' from '.$dbtbpre.'ecms_'.$tbname.$query.' order by '.ReturnSetTopSql('bq').$addorder.' limit '.$line;
	$sql=$empire->query1($query);
	if(!$sql)
	{
		echo"SQL Error: ".ReRepSqlTbpre($query);
	}
	return $sql;
}

//�鶯��ǩ������SQL���ݺ���
function ewap_eloop($classid=0,$line=10,$enews=3,$doing=0,$ewhere='',$eorder=''){
	return ewap_ReturnBqQuery($classid,$line,$enews,$doing,$ewhere,$eorder);
}

//�鶯��ǩ�������������ݺ���
function ewap_eloop_sp($r){
	global $class_r;
	$sr['titleurl']=ewap_ReturnTitleUrl($r);
	$sr['classname']=$class_r[$r[classid]][bname]?$class_r[$r[classid]][bname]:$class_r[$r[classid]][classname];
	$sr['classurl']=ewap_ReturnClassUrl($r);
	return $sr;
}

//����wap����ҳ��ַ
function ewap_ReturnTitleUrl($r){
	global $public_r,$class_r,$ecmsvar_mbr,$wapstyle;
	if(empty($r['isurl']))
	{
		$titleurl='show.php?classid='.$r[classid].'&amp;id='.$r[id].'&amp;style='.$wapstyle.'&amp;bclassid='.$class_r[$r[classid]][bclassid].'&amp;cid='.$r[classid].'&amp;cpage=0';
	}
	else
	{
		if($public_r['opentitleurl'])
		{
			$titleurl=$r['titleurl'];
		}
		else
		{
			$titleurl=$public_r['newsurl'].'e/public/jump/?classid='.$r['classid'].'&amp;id='.$r['id'];
		}
	}
	return $titleurl;
}

//������Ŀҳ��ַ
function ewap_ReturnClassUrl($r){
	global $public_r,$class_r,$ecmsvar_mbr,$wapstyle;
	//�ⲿ��Ŀ
	if($class_r[$r[classid]][wburl])
	{
		$classurl=$class_r[$r[classid]][wburl];
	}
	else
	{
		$classurl='list.php?classid='.$r[classid].'&amp;style='.$wapstyle.'&amp;bclassid='.$class_r[$r[classid]][bclassid];
	}
	return $classurl;
}

//���Ӹ��Ӳ���
function ewap_UrlAddCs(){
	global $ecmsvar_mbr;
	$wapstyle=(int)$ecmsvar_mbr['wapstyle'];
	$fbclassid=(int)$ecmsvar_mbr['fbclassid'];
	$fclassid=(int)$ecmsvar_mbr['fclassid'];
	$fcpage=(int)$ecmsvar_mbr['fcpage'];
	$addcs='';
	if($wapstyle)
	{
		$addcs.='&amp;style='.$wapstyle;
	}
	if($fbclassid)
	{
		$addcs.='&amp;bclassid='.$fbclassid;
	}
	if($fclassid)
	{
		$addcs.='&amp;cid='.$fclassid;
	}
	if($fcpage)
	{
		$addcs.='&amp;cpage='.$fcpage;
	}
	return $addcs;
}

//����WAPģ�����
function ewap_UrlCsReturnStyle($ecms=0,$style=0){
	global $pr,$wapstyle;
	if(!$style)
	{
		$style=$wapstyle;
	}
	$style=(int)$style;
	if(!$style||$style==$pr['wapdefstyle'])
	{
		return '';
	}
	$cs=$ecms?'?style='.$style:'&style='.$style;
	return $cs;
}


$pr=$empire->fetch1("select sitekey,siteintro,wapopen,wapdefstyle,wapshowmid,waplistnum,wapsubtitle,wapshowdate,wapchar,wapchstyle from {$dbtbpre}enewspublic limit 1");

//��������ļ�
$iconv='';
if($ecms_config['sets']['pagechar']!='utf-8')
{
	if($pr['wapchar']!=2)
	{
		@include_once("../class/doiconv.php");
		$iconv=new Chinese('');
	}
}

if(empty($pr['wapopen']))
{
	DoWapShowMsg('��վû�п���WAP����','index.php');
}

if(!$pr['wapchstyle'])
{
	$_GET['style']=0;
}
$wapstyle=intval($_GET['style']);
//����ʹ��ģ��
$usewapstyle=ReturnWapStyle($_GET,$wapstyle);
if(!file_exists('template/'.$usewapstyle))
{
	$usewapstyle=1;
}
?>