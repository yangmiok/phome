<?php
if(!defined('InEmpireCMS'))
{
        exit();
}
define('InEmpireCMSTfun',TRUE);
require_once(ECMS_PATH."e/class/userfun.php");

//�б�ģ���ҳ����
function sys_ShowListPage($num,$pagenum,$dolink,$dotype,$page,$lencord,$ok,$search="",$add){
	global $fun_r;
	//�ļ���
	if(empty($add['dofile']))
	{
		$add['dofile']='index';
	}
	//��̬ҳ��
	$repagenum=$add['repagenum'];
	//��ҳ
	if($pagenum<>1)
	{
		$pagetop="<a href='".$dolink.$add['dofile'].$dotype."'>".$fun_r['startpage']."</a>&nbsp;&nbsp;";
	}
	else
	{
		$pagetop=$fun_r['startpage']."&nbsp;&nbsp;";
	}
	//��һҳ
	if($pagenum<>1)
	{
		$pagepr=$pagenum-1;
		if($pagepr==1)
		{
			$prido=$add['dofile'].$dotype;
		}
		else
		{
			$prido=$add['dofile'].'_'.$pagepr.$dotype;
		}
		$pagepri="<a href='".$dolink.$prido."'>".$fun_r['pripage']."</a>&nbsp;&nbsp;";
	}
	else
	{
		$pagepri=$fun_r['pripage']."&nbsp;&nbsp;";
	}
	//��һҳ
	if($pagenum<>$page)
	{
		$pagenex=$pagenum+1;
		$nextpagelink=$repagenum&&$repagenum<$pagenex?eReturnRewritePageLink2($add,$pagenex):$dolink.$add['dofile'].'_'.$pagenex.$dotype;
		$pagenext="<a href='".$nextpagelink."'>".$fun_r['nextpage']."</a>&nbsp;&nbsp;";
	}
	else
	{
		$pagenext=$fun_r['nextpage']."&nbsp;&nbsp;";
	}
	//βҳ
	if($pagenum==$page)
	{
		$pageeof=$fun_r['lastpage'];
	}
	else
	{
		$lastpagelink=$repagenum&&$repagenum<$page?eReturnRewritePageLink2($add,$page):$dolink.$add['dofile'].'_'.$page.$dotype;
		$pageeof="<a href='".$lastpagelink."'>".$fun_r['lastpage']."</a>";
	}
	$options="";
	//ȡ������ҳ��
	if(empty($search))
	{
		for($go=1;$go<=$page;$go++)
		{
			if($go==1)
			{$file=$add['dofile'].$dotype;}
			else
			{$file=$add['dofile'].'_'.$go.$dotype;}
			$thispagelink=$repagenum&&$repagenum<$go?eReturnRewritePageLink2($add,$go):$dolink.$file;
			if($ok==$go)
			{$select=" selected";}
			else
			{$select="";}
			$myoptions.="<option value='".$thispagelink."'>".$fun_r['gotos'].$go.$fun_r['gotol']."</option>";
			$options.="<option value='".$thispagelink."'".$select.">".$fun_r['gotos'].$go.$fun_r['gotol']."</option>";
		}
	}
	else
	{
		$myoptions=$search;
		$options=str_replace("value='".$dolink.$add['dofile'].'_'.$ok.$dotype."'>","value='".$dolink.$add['dofile']."_".$ok.$dotype."' selected>",$search);
	}
	$options="<select name=select onchange=\"self.location.href=this.options[this.selectedIndex].value\">".$options."</select>";
	//��ҳ
	$pagelink=$pagetop.$pagepri.$pagenext.$pageeof;
	//�滻ģ�����
	$pager['showpage']=ReturnListpageStr($pagenum,$page,$lencord,$num,$pagelink,$options);
	$pager['option']=$myoptions;
	return $pager;
}

//�б�ģ��֮�б�ʽ��ҳ
function sys_ShowListMorePage($num,$page,$dolink,$type,$totalpage,$line,$ok,$search="",$add){
	global $fun_r,$public_r;
	if($num<=$line)
	{
		$pager['showpage']='';
		return $pager;
	}
	//�ļ���
	if(empty($add['dofile']))
	{
		$add['dofile']='index';
	}
	//��̬ҳ��
	$repagenum=$add['repagenum'];
	$page_line=$public_r['listpagelistnum'];
	$snum=2;
	//$totalpage=ceil($num/$line);//ȡ����ҳ��
	$firststr='<a title="Total record">&nbsp;<b>'.$num.'</b> </a>&nbsp;&nbsp;';
	//��һҳ
	if($page<>1)
	{
		$toppage='<a href="'.$dolink.$add['dofile'].$type.'">'.$fun_r['startpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		if($pagepr==1)
		{
			$prido=$add['dofile'].$type;
		}
		else
		{
			$prido=$add['dofile'].'_'.$pagepr.$type;
		}
		$prepage='<a href="'.$dolink.$prido.'">'.$fun_r['pripage'].'</a>';
	}
	//��һҳ
	if($page!=$totalpage)
	{
		$pagenex=$page+1;
		$nextpagelink=$repagenum&&$repagenum<$pagenex?eReturnRewritePageLink2($add,$pagenex):$dolink.$add['dofile'].'_'.$pagenex.$type;
		$lastpagelink=$repagenum&&$repagenum<$totalpage?eReturnRewritePageLink2($add,$totalpage):$dolink.$add['dofile'].'_'.$totalpage.$type;
		$nextpage='&nbsp;<a href="'.$nextpagelink.'">'.$fun_r['nextpage'].'</a>';
		$lastpage='&nbsp;<a href="'.$lastpagelink.'">'.$fun_r['lastpage'].'</a>';
	}
	$starti=$page-$snum<1?1:$page-$snum;
	$no=0;
	for($i=$starti;$i<=$totalpage&&$no<$page_line;$i++)
	{
		$no++;
		if($page==$i)
		{
			$is_1="<b>";
			$is_2="</b>";
		}
		elseif($i==1)
		{
			$is_1='<a href="'.$dolink.$add['dofile'].$type.'">';
			$is_2="</a>";
		}
		else
		{
			$thispagelink=$repagenum&&$repagenum<$i?eReturnRewritePageLink2($add,$i):$dolink.$add['dofile'].'_'.$i.$type;
			$is_1='<a href="'.$thispagelink.'">';
			$is_2="</a>";
		}
		$returnstr.='&nbsp;'.$is_1.$i.$is_2;
	}
	$returnstr=$firststr.$toppage.$prepage.$returnstr.$nextpage.$lastpage;
	$pager['showpage']=$returnstr;
	return $pager;
}

//�������ݷ�ҳ
function sys_ShowTextPage($totalpage,$page,$dolink,$add,$type,$search=""){
	global $fun_r,$public_r;
	if($totalpage==1)
	{
		return '';
	}
	$page_line=$public_r['textpagelistnum'];
	$snum=2;
	//$totalpage=ceil($num/$line);//ȡ����ҳ��
	$firststr='<a title="Page">&nbsp;<b>'.$page.'</b>/<b>'.$totalpage.'</b> </a>&nbsp;&nbsp;';
	//��һҳ
	if($page<>1)
	{
		$toppage='<a href="'.$dolink.$add[filename].$type.'">'.$fun_r['startpage'].'</a>&nbsp;';
		$pagepr=$page-1;
		if($pagepr==1)
		{
			$prido=$add[filename].$type;
		}
		else
		{
			$prido=$add[filename].'_'.$pagepr.$type;
		}
		$prepage='<a href="'.$dolink.$prido.'">'.$fun_r['pripage'].'</a>';
	}
	//��һҳ
	if($page!=$totalpage)
	{
		$pagenex=$page+1;
		$nextpage='&nbsp;<a href="'.$dolink.$add[filename].'_'.$pagenex.$type.'">'.$fun_r['nextpage'].'</a>';
		$lastpage='&nbsp;<a href="'.$dolink.$add[filename].'_'.$totalpage.$type.'">'.$fun_r['lastpage'].'</a>';
	}
	$starti=$page-$snum<1?1:$page-$snum;
	$no=0;
	for($i=$starti;$i<=$totalpage&&$no<$page_line;$i++)
	{
		$no++;
		if($page==$i)
		{
			$is_1="<b>";
			$is_2="</b>";
		}
		elseif($i==1)
		{
			$is_1='<a href="'.$dolink.$add[filename].$type.'">';
			$is_2="</a>";
		}
		else
		{
			$is_1='<a href="'.$dolink.$add[filename].'_'.$i.$type.'">';
			$is_2="</a>";
		}
		$returnstr.='&nbsp;'.$is_1.$i.$is_2;
	}
	$returnstr=$firststr.$toppage.$prepage.$returnstr.$nextpage.$lastpage;
	return $returnstr;
}

//��������ʽ���ݷ�ҳ����
function sys_ShowTextPageSelect($thispagenum,$dolink,$add,$filetype,$n_r){
	if($thispagenum==1)
	{
		return '';
	}
	$titleselect='';
	for($j=1;$j<=$thispagenum;$j++)
	{
	    if($j==1)
		{
			$title=$add[title];
			$plink=$add[filename].$filetype;
		}
		else
		{
			$k=$j-1;
			$ti_r=explode('[/!--empirenews.page--]',$n_r[$k]);
		    if(count($ti_r)>=2&&$ti_r[0])
			{
				$title=$ti_r[0];
			}
		    else
			{
				$title=$add[title].'('.$j.')';
			}
			$plink=$add[filename].'_'.$j.$filetype;
		}
		$titleselect.='<option value="'.$dolink.$plink.'?'.$j.'">'.$title.'</option>';
	}
	$titleselect='<select name="titleselect" onchange="self.location.href=this.options[this.selectedIndex].value">'.$titleselect.'</select>';
	return $titleselect;
}

//����sql���
function sys_ReturnBqQuery($classid,$line,$enews=0,$do=0,$ewhere='',$eorder=''){
	global $empire,$public_r,$class_r,$class_zr,$navclassid,$dbtbpre,$fun_r,$class_tr,$emod_r,$etable_r,$eyh_r;
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
		echo $fun_r['BqErrorCid']."=<b>".$classid."</b>".$fun_r['BqErrorNtb']."(".$fun_r['BqErrorDo']."=".$enews.")";
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

//���ر�ǩģ��
function sys_ReturnBqTemp($tempid){
	global $empire,$dbtbpre,$fun_r;
	$r=$empire->fetch1("select tempid,modid,temptext,showdate,listvar,subnews,rownum,docode from ".GetTemptb("enewsbqtemp")." where tempid='$tempid'");
	if(empty($r[tempid]))
	{
		echo $fun_r['BqErrorNbqtemp']."(ID=".$tempid.")";
	}
	return $r;
}

//�滻��Ŀ��
function ReplaceEcmsinfoClassname($temp,$enews,$classid){
	global $class_r,$class_zr;
	if(strstr($classid,","))
	{
		return $temp;
    }
	$thecdo=',0,1,2,9,12,15,';
	$thezdo=',6,7,8,11,14,17,';
	//��Ŀ
	if(strstr($thecdo,",".$enews.","))
	{
		$classname=$class_r[$classid][classname];
		$r[classid]=$classid;
		$classurl=sys_ReturnBqClassname($r,9);
    }
	//ר��
	elseif(strstr($thezdo,",".$enews.","))
	{
		$r[ztid]=$classid;
		$classname=$class_zr[$classid][ztname];
		$classurl=sys_ReturnBqZtname($r);
    }
	else
	{}
	if($classname)
	{
		$temp=str_replace("[!--the.classname--]",$classname,$temp);
		$temp=str_replace("[!--the.classurl--]",$classurl,$temp);
		$temp=str_replace("[!--the.classid--]",$classid,$temp);
	}
	return $temp;
}

//��ģ��ı�ǩ
function sys_GetEcmsInfo($classid,$line,$strlen,$have_class=0,$enews=0,$tempid,$doing=0,$ewhere='',$eorder=''){
	global $empire,$public_r;
	$sql=sys_ReturnBqQuery($classid,$line,$enews,$doing,$ewhere,$eorder);
	if(!$sql)
	{return "";}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	$docode=$tr[docode];
	//�滻����
	$listtemp=ReplaceEcmsinfoClassname($listtemp,$enews,$classid);
	if(empty($rownum))
	{$rownum=1;}
	//�ֶ�
	$ret_r=ReturnReplaceListF($tr[modid]);
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	while($r=$empire->fetch($sql))
	{
		$r[oldtitle]=$r[title];
		//�滻�б����
		$repvar=ReplaceListVars($no,$listvar,$subnews,$strlen,$formatdate,$url,$have_class,$r,$ret_r,$docode);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
    }
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//�鶯��ǩ������SQL���ݺ���
function sys_ReturnEcmsLoopBq($classid=0,$line=10,$enews=3,$doing=0,$ewhere='',$eorder=''){
	return sys_ReturnBqQuery($classid,$line,$enews,$doing,$ewhere,$eorder);
}

//�鶯��ǩ�������������ݺ���
function sys_ReturnEcmsLoopStext($r){
	global $class_r;
	$sr['titleurl']=sys_ReturnBqTitleLink($r);
	$sr['classname']=$class_r[$r[classid]][bname]?$class_r[$r[classid]][bname]:$class_r[$r[classid]][classname];
	$sr['classurl']=sys_ReturnBqClassname($r,9);
	return $sr;
}

//����������Ӳ�������
function sys_OtherLinkQuery($classid,$line,$enews,$doing){
	global $empire,$public_r,$class_r,$class_zr,$navinfor,$dbtbpre,$eyh_r,$etable_r,$class_tr;
	if($enews==1)//����
	{
		$tbname=$classid;
	}
	elseif($enews==2)//����Ŀ
	{
		if($classid=='selfinfo')//��ǰ��Ŀ
		{
			$classid=$navinfor['classid'];
		}
		$tbname=$class_r[$classid]['tbname'];
		if($class_r[$classid][islast])
		{
			$and="classid='$classid'";
		}
		else
		{
			$and=ReturnClass($class_r[$classid][sonclass]);
		}
	}
	elseif($enews==3)//���������
	{
		$tbname=$class_tr[$classid]['tbname'];
		$and="ttid='$classid'";
	}
	else//Ĭ��
	{
		$tbname=$class_r[$navinfor[classid]]['tbname'];
	}
	//�ؼ���
	$keys='';
	if(!empty($enews))
	{
		$repadd='';
		$keyr=explode(',',$navinfor['keyboard']);
		$count=count($keyr);
		for($i=0;$i<$count;$i++)
		{
			if($i==0)
			{
				$or='';
			}
			else
			{
				$or=' or ';
			}
			$repadd.=$or."[!--f--!] like '%".$keyr[$i]."%'";
		}
		//������Χ
		if($public_r['newslink']==1)
		{
			$keys='('.str_replace('[!--f--!]','keyboard',$repadd).')';
		}
		elseif($public_r['newslink']==2)
		{
			$keys='('.str_replace('[!--f--!]','keyboard',$repadd).' or '.str_replace('[!--f--!]','title',$repadd).')';
		}
		else
		{
			$keys='('.str_replace('[!--f--!]','title',$repadd).')';
		}
	}
	else
	{
		$keys='id in ('.$navinfor['keyid'].')';
	}
	//��ǰ��Ϣ
	if($tbname==$class_r[$navinfor[classid]][tbname])
	{
		$and.=empty($and)?"id<>'$navinfor[id]'":" and id<>'$navinfor[id]'";
	}
	//ͼƬ��Ϣ
	if($doing)
	{
		$and.=empty($and)?"ispic=1":" and ispic=1";
    }
	if($and)
	{
		$and.=' and ';
	}
	if(empty($line))
	{
		$line=$class_r[$navinfor[classid]]['link_num'];
	}
	//�Ż�
	$yhvar='otherlink';
	$yhid=$etable_r[$tbname][yhid];
	$yhadd='';
	if($yhid)
	{
		$yhadd=ReturnYhSql($yhid,$yhvar,1);
	}
	$query="select * from {$dbtbpre}ecms_".$tbname." where ".$yhadd.$and.$keys." order by newstime desc limit $line";
	$sql=$empire->query1($query);
	if(!$sql)
	{
		echo"SQL Error: ".ReRepSqlTbpre($query);
	}
	return $sql;
}

//������ӱ�ǩ
function sys_GetOtherLinkInfo($tempid,$classid='',$line=0,$strlen=60,$have_class=0,$enews=0,$doing=0){
	global $empire,$navinfor,$public_r;
	if(empty($navinfor['keyboard'])||(empty($enews)&&!$navinfor['keyid']))
	{
		return '';
	}
	$sql=sys_OtherLinkQuery($classid,$line,$enews,$doing);
	if(!$sql)
	{return "";}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	$docode=$tr[docode];
	//�滻����
	$listtemp=ReplaceEcmsinfoClassname($listtemp,$enews,$classid);
	if(empty($rownum))
	{$rownum=1;}
	//�ֶ�
	$ret_r=ReturnReplaceListF($tr[modid]);
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	while($r=$empire->fetch($sql))
	{
		$r[oldtitle]=$r[title];
		//�滻�б����
		$repvar=ReplaceListVars($no,$listvar,$subnews,$strlen,$formatdate,$url,$have_class,$r,$ret_r,$docode);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
    }
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//���ֱ�ǩ����
function sys_GetClassNews($classid,$line,$strlen,$showdate=true,$enews=0,$have_class=0,$formatdate='(m-d)',$ewhere='',$eorder=''){
	global $empire;
	$sql=sys_ReturnBqQuery($classid,$line,$enews,0,$ewhere,$eorder);
	if(!$sql)
	{return "";}
	$record=0;
	while($r=$empire->fetch($sql))
	{
		$record=1;
		$oldtitle=$r[title];
		$title=sub($r[title],0,$strlen,false);
		//��������
		$title=DoTitleFont($r[titlefont],$title);
		//��ʾ��Ŀ
		$myadd=sys_ReturnBqClassname($r,$have_class);
		//��ʾʱ��
        if($showdate)
		{
			$newstime=date($formatdate,$r[newstime]);
            $newstime="&nbsp;".$newstime;
        }
		//��������
		$titleurl=sys_ReturnBqTitleLink($r);
        $title="��".$myadd."<a href='".$titleurl."' target=_blank title='".$oldtitle."'>".$title."</a>".$newstime;
        $allnews.="<tr><td height=20>".$title."</td></tr>";
    }
	if($record)
	{
		echo"<table border=0 cellpadding=0 cellspacing=0>$allnews</table>";
	}
}

//ͼ����Ϣ����
function sys_GetClassNewsPic($classid,$line,$num,$width,$height,$showtitle=true,$strlen,$enews=0,$ewhere='',$eorder=''){
	global $empire;
	$sql=sys_ReturnBqQuery($classid,$num,$enews,1,$ewhere,$eorder);
	if(!$sql)
	{return "";}
	//���
	$i=0;
	while($r=$empire->fetch($sql))
	{
		$i++;
		if(($i-1)%$line==0||$i==1)
		{$class_text.="<tr>";}
		//��������
		$titleurl=sys_ReturnBqTitleLink($r);
		//------�Ƿ���ʾ����
		if($showtitle)
		{
			$oldtitle=$r[title];
			$title=sub($r[title],0,$strlen,false);
			//��������
			$title=DoTitleFont($r[titlefont],$title);
			$title="<br><span style='line-height:15pt'>".$title."</span>";
		}
        $class_text.="<td align=center><a href='".$titleurl."' target=_blank><img src='".$r[titlepic]."' width='".$width."' height='".$height."' border=0 alt='".$oldtitle."'>".$title."</a></td>";
        //�ָ�
        if($i%$line==0)
		{$class_text.="</tr>";}
    }
    if($i<>0)
	{
		$table="<table width=100% border=0 cellpadding=3 cellspacing=0>";$table1="</table>";
        $ys=$line-$i%$line;
		$p=0;
        for($j=0;$j<$ys&&$ys!=$line;$j++)
		{
			$p=1;
			$class_text.="<td></td>";
        }
		if($p==1)
		{
			$class_text.="</tr>";
		}
	}
    $text=$table.$class_text.$table1;
    echo"$text";
}

//����ǩ
function sys_GetAd($adid){
	global $empire,$public_r,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsad where adid='$adid'");
	//����
	if($r['endtime']<>'0000-00-00'&&time()>to_time($r['endtime']))
	{
		echo addslashes($r[reptext]);
		return '';
	}
	if($r['ylink'])
	{
		$ad_url=$r['url'];
	}
	else
	{
		$ad_url=$public_r[newsurl]."e/public/ClickAd?adid=".$adid;//�������
	}
	//----------------------���ֹ��
	if($r[t]==1)
	{
		$r[titlefont]=$r[titlecolor].','.$r[titlefont];
		$picurl=DoTitleFont($r[titlefont],$r[picurl]);//��������
		$h="<a href='".$ad_url."' target=".$r[target]." title='".$r[alt]."'>".addslashes($picurl)."</a>";
		//��ͨ��ʾ
		if($r[adtype]==1)
		{
			$html=$h;
	    }
		//���ƶ�͸���Ի���
		else
		{
			$html="<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_dialog.js></script> 
<div style='position:absolute;left:300px;top:150px;width:".$r[pic_width]."; height:".$r[pic_height].";z-index:1;solid;filter:alpha(opacity=90)' id=DGbanner5 onmousedown='down1(this)' onmousemove='move()' onmouseup='down=false'><table cellpadding=0 border=0 cellspacing=1 width=".$r[pic_width]." height=".$r[pic_height]." bgcolor=#000000><tr><td height=18 bgcolor=#5A8ACE align=right style='cursor:move;'><a href=# style='font-size: 9pt; color: #eeeeee; text-decoration: none' onClick=clase('DGbanner5') >�ر�>>><img border='0' src='".$public_r[newsurl]."d/js/acmsd/close_o.gif'></a>&nbsp;</td></tr><tr><td bgcolor=f4f4f4 >&nbsp;".$h."</td></tr></table></div>";
	    }
    }
	//------------------html���
	elseif($r[t]==2)
	{
		$h=addslashes($r[htmlcode]);
		//��ͨ��ʾ
		if($r[adtype]==1)
		{
			$html=$h;
		}
		//���ƶ�͸���Ի���
		else
		{
			$html="<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_dialog.js></script>
<div style='position:absolute;left:300px;top:150px;width:".$r[pic_width]."; height:".$r[pic_height].";z-index:1;solid;filter:alpha(opacity=90)' id=DGbanner5 onmousedown='down1(this)' onmousemove='move()' onmouseup='down=false'><table cellpadding=0 border=0 cellspacing=1 width=".$r[pic_width]." height=".$r[pic_height]." bgcolor=#000000><tr><td height=18 bgcolor=#5A8ACE align=right style='cursor:move;'><a href=# style='font-size: 9pt; color: #eeeeee; text-decoration: none' onClick=clase('DGbanner5') >�ر�>>><img border='0' src='".$public_r[newsurl]."d/js/acmsd/close_o.gif'></a>&nbsp;</td></tr><tr><td bgcolor=f4f4f4 >&nbsp;".$h."</td></tr></table></div>";
		}
    }
	//------------------�������
	elseif($r[t]==3)
	{
		//���´���
		if($r[adtype]==8)
		{
			$html="<script>window.open('".$r[url]."');</script>";
		}
		//��������
	    elseif($r[adtype]==9)
		{
			$html="<script>window.open('".$r[url]."','','width=".$r[pic_width].",height=".$r[pic_height].",scrollbars=yes');</script>";
		}
		//������ҳ����
		else
		{
			$html="<script>window.showModalDialog('".$r[url]."','','dialogWidth:".$r[pic_width]."px;dialogHeight:".$r[pic_height]."px;scroll:no;status:no;help:no');</script>";
		}
    }
	//---------------------ͼƬ��flash���
	else
	{
		$filetype=GetFiletype($r[picurl]);
		//flash
		if($filetype==".swf")
		{
			$h="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' name='movie' width='".$r[pic_width]."' height='".$r[pic_height]."' id='movie'><param name='movie' value='".$r[picurl]."'><param name='quality' value='high'><param name='menu' value='false'><embed src='".$r[picurl]."' width='".$r[pic_width]."' height='".$r[pic_height]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' id='movie' name='movie' menu='false'></embed><PARAM NAME='wmode' VALUE='Opaque'></object>";
		}
		else
		{
			$h="<a href='".$ad_url."' target=".$r[target]."><img src='".$r[picurl]."' border=0 width='".$r[pic_width]."' height='".$r[pic_height]."' alt='".$r[alt]."'></a>";
		}
		//��ͨ��ʾ
		if($r[adtype]==1)
		{
			$html=$h;
		}
		//����������ʾ
		elseif($r[adtype]==4)
		{
			$html="<script>ns4=(document.layers)?true:false;
ie4=(document.all)?true:false;
if(ns4){document.write(\"<layer id=DGbanner2 width=".$r[pic_width]." height=".$r[pic_height]." onmouseover=stopme('DGbanner2') onmouseout=movechip('DGbanner2')>".$h."</layer>\");}
else{document.write(\"<div id=DGbanner2 style='position:absolute; width:".$r[pic_width]."px; height:".$r[pic_height]."px; z-index:9; filter: Alpha(Opacity=90)' onmouseover=stopme('DGbanner2') onmouseout=movechip('DGbanner2')>".$h."</div>\");}</script>
<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_float_fullscreen.js></script>";
		}
		//���¸�����ʾ - ��
		elseif($r[adtype]==5)
		{
			$html="<script>if (navigator.appName == 'Netscape')
{document.write(\"<layer id=DGbanner3 top=150 width=".$r[pic_width]." height=".$r[pic_height].">".$h."</layer>\");}
else{document.write(\"<div id=DGbanner3 style='position: absolute;width:".$r[pic_height].";top:150;visibility: visible;z-index: 1'>".$h."</div>\");}</script>
<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_float_upanddown.js></script>";
		}
		//���¸�����ʾ - ��
		elseif($r[adtype]==6)
		{
			$html="<script>if(navigator.appName == 'Netscape')
{document.write(\"<layer id=DGbanner10 top=150 width=".$r[pic_width]." height=".$r[pic_height].">".$h."</layer>\");}
else{document.write(\"<div id=DGbanner10 style='position: absolute;width:".$r[pic_width].";top:150;visibility: visible;z-index: 1'>".$h."</div>\");}</script>
<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_float_upanddown_L.js></script>";
		}
		//ȫ��Ļ������ʧ
		elseif($r[adtype]==7)
		{
			$html="<script>ns4=(document.layers)?true:false;
if(ns4){document.write(\"<layer id=DGbanner4Cont onLoad='moveToAbsolute(layer1.pageX-160,layer1.pageY);clip.height=".$r[pic_height].";clip.width=".$r[pic_width]."; visibility=show;'><layer id=DGbanner4News position:absolute; top:0; left:0>".$h."</layer></layer>\");}
else{document.write(\"<div id=DGbanner4 style='position:absolute;top:0; left:0;'><div id=DGbanner4Cont style='position:absolute;width:".$r[pic_width].";height:".$r[pic_height].";clip:rect(0,".$r[pic_width].",".$r[pic_height].",0)'><div id=DGbanner4News style='position:absolute;top:0;left:0;right:820'>".$h."</div></div></div>\");}</script> 
<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_fullscreen.js></script>";
		}
		//���ƶ�͸���Ի���
		elseif($r[adtype]==3)
		{
			$html="<script language=javascript src=".$public_r[newsurl]."d/js/acmsd/ecms_dialog.js></script> 
<div style='position:absolute;left:300px;top:150px;width:".$r[pic_width]."; height:".$r[pic_height].";z-index:1;solid;filter:alpha(opacity=90)' id=DGbanner5 onmousedown='down1(this)' onmousemove='move()' onmouseup='down=false'><table cellpadding=0 border=0 cellspacing=1 width=".$r[pic_width]." height=".$r[pic_height]." bgcolor=#000000><tr><td height=18 bgcolor=#5A8ACE align=right style='cursor:move;'><a href=# style='font-size: 9pt; color: #eeeeee; text-decoration: none' onClick=clase('DGbanner5') >�ر�>>><img border='0' src='".$public_r[newsurl]."d/js/acmsd/close_o.gif'></a>&nbsp;</td></tr><tr><td bgcolor=f4f4f4 >&nbsp;".$h."</td></tr></table></div>";
		}
		else
		{
			$html="<script>function closeAd(){huashuolayer2.style.visibility='hidden';huashuolayer3.style.visibility='hidden';}function winload(){huashuolayer2.style.top=109;huashuolayer2.style.left=5;huashuolayer3.style.top=109;huashuolayer3.style.right=5;}//if(document.body.offsetWidth>800){
				{document.write(\"<div id=huashuolayer2 style='position: absolute;visibility:visible;z-index:1'><table width=0  border=0 cellspacing=0 cellpadding=0><tr><td height=10 align=right bgcolor=666666><a href=javascript:closeAd()><img src=".$public_r[newsurl]."d/js/acmsd/close.gif width=12 height=10 border=0></a></td></tr><tr><td>".$h."</td></tr></table></div>\"+\"<div id=huashuolayer3 style='position: absolute;visibility:visible;z-index:1'><table width=0  border=0 cellspacing=0 cellpadding=0><tr><td height=10 align=right bgcolor=666666><a href=javascript:closeAd()><img src=".$public_r[newsurl]."d/js/acmsd/close.gif width=12 height=10 border=0></a></td></tr><tr><td>".$h."</td></tr></table></div>\");}winload()//}</script>";
		}
	}
	echo $html;
}

//ͶƱ��ǩ
function sys_GetVote($voteid){
	global $empire,$public_r,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsvote where voteid='$voteid'");
	if(empty($r[votetext]))
	{
		return '';
	}
	//ģ��
	$votetemp=ReturnVoteTemp($r[tempid],0);
	$votetemp=RepVoteTempAllvar($votetemp,$r);
	$listexp="[!--empirenews.listtemp--]";
	$listtemp_r=explode($listexp,$votetemp);
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
	$votetext=$listtemp_r[0].$votetext.$listtemp_r[2];
	echo"$votetext";
}

//��ϢͶƱ��ǩ
function sys_GetInfoVote($classid,$id){
	global $empire,$public_r,$dbtbpre;
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfovote where id='$id' and classid='$classid' limit 1");
	if(empty($r[votetext]))
	{
		return '';
	}
	//ģ��
	$votetemp=ReturnVoteTemp($r[tempid],0);
	$votetemp=RepVoteTempAllvar($votetemp,$r);
	$listexp="[!--empirenews.listtemp--]";
	$listtemp_r=explode($listexp,$votetemp);
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
	$votetext=$listtemp_r[0].$votetext.$listtemp_r[2];
	return $votetext;
}

//��������
function sys_GetSitelink($line,$num,$enews=0,$classid=0,$stats=0){
	global $empire,$public_r,$dbtbpre;
	//ͼƬ
	if($enews==1)
	{$a=" and lpic<>''";}
	//����
	elseif($enews==2)
	{$a=" and lpic=''";}
	else
	{$a="";}
	//������Ӧ����Ŀ����
	if(!empty($classid))
	{
		$whereclass=" and classid='$classid'";
	}
	$sql=$empire->query("select * from {$dbtbpre}enewslink where checked=1".$a.$whereclass." order by myorder,lid limit ".$num);
	//���
	$i=0;
	while($r=$empire->fetch($sql))
	{
		//����
		if(empty($stats))
		{
			$linkurl=$public_r[newsurl]."e/public/GotoSite/?lid=".$r[lid]."&url=".urlencode($r[lurl]);
		}
		else
		{
			$linkurl=$r[lurl];
		}
		$i++;
		if(($i-1)%$line==0||$i==1)
		{$class_text.="<tr>";}
		//����
		if(empty($r[lpic]))
		{
			$logo="<a href='".$linkurl."' title='".$r[lname]."' target=".$r[target].">".$r[lname]."</a>";
		}
		//ͼƬ
		else
		{
			$logo="<a href='".$linkurl."' target=".$r[target]."><img src='".$r[lpic]."' alt='".$r[lname]."' border=0 width='".$r[width]."' height='".$r[height]."'></a>";
		}
		$class_text.="<td align=center>".$logo."</td>";
		//�ָ�
		if($i%$line==0)
		{$class_text.="</tr>";}
	}
	if($i<>0)
	{
		$table="<table width=100% border=0 cellpadding=3 cellspacing=0>";$table1="</table>";
        $ys=$line-$i%$line;
		$p=0;
        for($j=0;$j<$ys&&$ys!=$line;$j++)
		{
			$p=1;
			$class_text.="<td></td>";
        }
		if($p==1)
		{
			$class_text.="</tr>";
		}
	}
	$text=$table.$class_text.$table1;
    echo"$text";
}

//�����ļ�
function sys_IncludeFile($file){
	@include($file);
}

//��ȡԶ���ļ�
function sys_ReadFile($http){
	echo ReadFiletext($http);
}

//��Ϣͳ��
function sys_TotalData($classid,$enews=0,$day=0,$totaltype=0){
	global $empire,$class_r,$class_zr,$dbtbpre,$fun_r,$class_tr;
	if(empty($classid))
	{
		return "";
    }
	//ͳ������
	if($totaltype==1)//������
	{
		$totalfield='sum(plnum) as total';
	}
	elseif($totaltype==2)//�����
	{
		$totalfield='sum(onclick) as total';
	}
	elseif($totaltype==3)//������
	{
		$totalfield='sum(totaldown) as total';
	}
	else//��Ϣ��
	{
		$totalfield='count(*) as total';
	}
	if($day)
	{
		if($day==1)//������Ϣ
		{
			$date=date("Y-m-d");
			$starttime=$date." 00:00:01";
			$endtime=$date." 23:59:59";
		}
		elseif($day==2)//������Ϣ
		{
			$date=date("Y-m");
			$starttime=$date."-01 00:00:01";
			$endtime=$date."-".date("t")." 23:59:59";
		}
		elseif($day==3)//������Ϣ
		{
			$date=date("Y");
			$starttime=$date."-01-01 00:00:01";
			$endtime=($date+1)."-01-01 00:00:01";
		}
		$and=" and newstime>=".to_time($starttime)." and newstime<=".to_time($endtime);
	}
	if($enews==1)//ͳ�Ʊ������
	{
		if(empty($class_tr[$classid][tbname]))
		{
			echo $fun_r['BqErrorTtid']."=<b>".$classid."</b>".$fun_r['BqErrorNtb'];
			return "";
		}
		$query="select ".$totalfield." from {$dbtbpre}ecms_".$class_tr[$classid][tbname]." where ttid='$classid'".$and;
    }
	elseif($enews==2)//ͳ�����ݱ�
	{
		$query="select ".$totalfield." from {$dbtbpre}ecms_".$classid.(empty($and)?'':' where '.substr($and,5));
    }
	else//ͳ����Ŀ����
	{
		if(empty($class_r[$classid][tbname]))
		{
			echo $fun_r['BqErrorCid']."=<b>".$classid."</b>".$fun_r['BqErrorNtb'];
			return "";
		}
		if($class_r[$classid][islast])//�ռ���Ŀ
		{
			$where="classid='$classid'";
		}
		else//����Ŀ
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		$query="select ".$totalfield." from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where ".$where.$and;
    }
	$num=$empire->gettotal($query);
	echo $num;
}

//flash�õ�ͼƬ��Ϣ����
function sys_FlashPixpic($classid,$line,$width,$height,$showtitle=true,$strlen,$enews=0,$sec=5,$ewhere='',$eorder=''){
	global $empire,$public_r,$class_r,$class_zr;
	$sql=sys_ReturnBqQuery($classid,$line,$enews,1,$ewhere,$eorder);
	if(!$sql)
	{return "";}
	$i=0;
	while($r=$empire->fetch($sql))
	{
		//��������
		$titleurl=sys_ReturnBqTitleLink($r);
		//------�Ƿ���ʾ����
		if($showtitle)
		{
			$title=sub($r[title],0,$strlen,false);
			//��������
			$title=addslashes(DoTitleFont($r[titlefont],ehtmlspecialchars($title)));
		}
		$fh="|";
		if($i==0)
		{
			$fh="";
		}
		$url.=$fh.$titleurl;
		$pic.=$fh.$r[titlepic];
		$subject.=$fh.$title;
		$i=1;
	}
	//��ʾ����
	if($showtitle)
	{
		$text_height=22;
	}
	else
	{
		$text_height=0;
	}
?>
<script type="text/javascript">
<!--
 var interval_time=<?=$sec?>;
 var focus_width=<?=$width?>;
 var focus_height=<?=$height?>;
 var text_height=<?=$text_height?>;
 var text_align="center";
 var swf_height = focus_height+text_height;
 var swfpath="<?=$public_r[newsurl]?>e/data/images/pixviewer.swf";
 var swfpatha="<?=$public_r[newsurl]?>e/data/images/pixviewer.swf";
 
 var pics="<?=urlencode($pic)?>";
 var links="<?=urlencode($url)?>";
 var texts="<?=ehtmlspecialchars($subject)?>";
 
 document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'+ focus_width +'" height="'+ swf_height +'">');
 document.write('<param name="movie" value="'+swfpath+'"><param name="quality" value="high"><param name="bgcolor" value="#ffffff">');
 document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
 document.write('<param name="FlashVars" value="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'&text_align='+text_align+'&interval_time='+interval_time+'">');
 document.write('<embed src="'+swfpath+'" wmode="opaque" FlashVars="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'&text_align='+text_align+'&interval_time='+interval_time+'" menu="false" bgcolor="#ffffff" quality="high" width="'+ focus_width +'" height="'+ swf_height +'" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
 document.write('</object>');
//-->
</script>
<?
}

//�����ؼ���
function sys_ShowSearchKey($line,$num,$classid=0,$enews=0){
	global $empire,$public_r,$dbtbpre;
	if($enews)
	{
		$order="searchid";
	}
	else
	{
		$order="onclick";
	}
	if($classid)
	{
		$add=" and classid='$classid'";
	}
	$sql=$empire->query("select searchid,keyboard from {$dbtbpre}enewssearch where iskey=0".$add." order by ".$order." desc limit ".$num);
	$i=0;
	$returnkey="";
	while($r=$empire->fetch($sql))
	{
		$i++;
		$keyurl=$public_r[newsurl]."e/search/result/?searchid=$r[searchid]";
		$br="";
		if($i%$line==0)
		{
			$br="<br>";
		}
		$jg="&nbsp;";
		if($br)
		{
			$jg="";
		}
		$returnkey.="<a href='".$keyurl."' target=_blank>".$r[keyboard]."</a>".$jg.$br;
	}
	echo $returnkey;
}

//��ģ��ı�ǩ��ʾ-ѭ��
function sys_GetEcmsInfoMore($classid,$line,$strlen,$have_class=0,$ecms=0,$tr,$doing=0,$field,$cr,$dofirstinfo=0,$fsubtitle=0,$fsubnews=0,$fdoing=0,$ewhere='',$eorder=''){
	global $empire,$public_r;
	//��������
	if($ecms==0)//��Ŀ����
	{
		$enews=0;
	}
	elseif($ecms==1)//��Ŀ����
	{
		$enews=1;
	}
	elseif($ecms==2)//��Ŀ�Ƽ�
	{
		$enews=2;
	}
	elseif($ecms==3)//��Ŀ��������
	{
		$enews=9;
	}
	elseif($ecms==4)//��Ŀͷ��
	{
		$enews=12;
	}
	elseif($ecms==5)//��Ŀ��������
	{
		$enews=15;
	}
	elseif($ecms==6)//��Ŀ����
	{
		$enews=25;
	}
	elseif($ecms==7)//��ĿͶƱ
	{
		$enews=26;
	}
	else
	{
		$enews=0;
	}
	$sql=sys_ReturnBqQuery($classid,$line,$enews,$doing,$ewhere,$eorder);
	if(!$sql)
	{return "";}
	//ȡ��ģ��
	$listtemp=$tr[temptext];
	$subnews=$tr[subnews];
	$listvar=$tr[listvar];
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	$docode=$tr[docode];
	//�滻����
	$listtemp=ReplaceEcmsinfoClassname($listtemp,$enews,$classid);
	$listtemp=sys_ForSonclassDataFirstInfo($listtemp,$cr,$dofirstinfo,$fsubtitle,$fsubnews,$fdoing);
	if(empty($rownum))
	{$rownum=1;}
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	while($r=$empire->fetch($sql))
	{
		$r[oldtitle]=$r[title];
		//�滻�б����
		$repvar=ReplaceListVars($no,$listvar,$subnews,$strlen,$formatdate,$url,$have_class,$r,$field,$docode);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
    }
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//ѭ������Ŀ��ʾͷ����Ϣ
function sys_ForSonclassDataFirstInfo($temptext,$cr,$ecms=0,$subtitle=0,$subnews=0,$fdoing=0){
	global $empire,$class_r,$public_r,$dbtbpre;
	if($ecms==2||$ecms==3||$ecms==4)
	{
		$where=$class_r[$cr[classid]][islast]?"classid='$cr[classid]'":ReturnClass($class_r[$cr[classid]][sonclass]);
	}
	if($fdoing)
	{
		$add=" and ispic=1";
	}
	if($ecms==1)//��Ŀ��ͼ
	{
		$id=$cr['classid'];
		$title=$cr['classname'];
		$titleurl=sys_ReturnBqClassname($cr,9);
		$titlepic=$cr['classimg'];
		$smalltext=$cr['intro'];
	}
	elseif($ecms==2)//�Ƽ���Ϣ
	{
		$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$cr[classid]][tbname]." where isgood>0 and (".$where.")".$add." order by newstime desc limit 1");
	}
	elseif($ecms==3)//ͷ����Ϣ
	{
		$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$cr[classid]][tbname]." where firsttitle>0 and (".$where.")".$add." order by newstime desc limit 1");
	}
	elseif($ecms==4)//������Ϣ
	{
		$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$cr[classid]][tbname]." where (".$where.")".$add." order by newstime desc limit 1");
	}
	else
	{
		return $temptext;
	}
	if($ecms!=1)
	{
		$id=$r['id'];
		$title=$r['title'];
		$titleurl=sys_ReturnBqTitleLink($r);
		$titlepic=$r['titlepic'];
		//���
		if($r['smalltext'])
		{$smalltext=$r['smalltext'];}
		elseif($r['flashsay'])
		{$smalltext=$r['flashsay'];}
		elseif($r['softsay'])
		{$smalltext=$r['softsay'];}
		elseif($r['moviesay'])
		{$smalltext=$r['moviesay'];}
		elseif($r['picsay'])
		{$smalltext=$r['picsay'];}
	}
	$oldtitle=$title;
	if($subtitle)
	{$title=sub($title,0,$subtitle,false);}
	if(empty($titlepic))
	{$titlepic=$public_r[newsurl]."e/data/images/notimg.gif";}
	if(!empty($subnews))
	{$smalltext=sub($smalltext,0,$subnews,false);}
	$temptext=str_replace('[!--sonclass.id--]',$id,$temptext);
	$temptext=str_replace('[!--sonclass.title--]',$title,$temptext);
	$temptext=str_replace('[!--sonclass.oldtitle--]',$oldtitle,$temptext);
	$temptext=str_replace('[!--sonclass.titlepic--]',$titlepic,$temptext);
	$temptext=str_replace('[!--sonclass.titleurl--]',$titleurl,$temptext);
	$temptext=str_replace('[!--sonclass.text--]',$smalltext,$temptext);
	return $temptext;
}

//ѭ������Ŀ����
function sys_ForSonclassData($classid,$line,$strlen,$have_class=0,$enews=0,$tempid,$doing=0,$cline=0,$dofirstinfo=0,$fsubtitle=0,$fsubnews=0,$fdoing=0,$ewhere='',$eorder=''){
	global $empire,$public_r,$class_r,$class_zr,$navclassid,$dbtbpre;
	//����Ŀ
	if(strstr($classid,","))
	{
		$son_r=sys_ReturnMoreClass($classid);
		$classid=$son_r[0];
		$where=$son_r[1];
	}
	else
	{
		//��ǰ��Ŀ
		if('dg'.$classid=='dgselfinfo')
		{
			$classid=$navclassid;
		}
		$where="bclassid='$classid'";
	}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$tr[temptext]=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$tr[listvar]=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	//��������
	if($cline)
	{
		$limit=" limit ".$cline;
	}
	//�ֶ�
	$ret_r=ReturnReplaceListF($tr[modid]);
	//��Ŀ�ֶ�
	if($dofirstinfo==1)
	{
		$addclassfield=',classname,classimg,intro';
	}
	$csql=$empire->query("select classid".$addclassfield." from {$dbtbpre}enewsclass where ".$where." and wburl='' order by myorder,classid".$limit);
	while($cr=$empire->fetch($csql))
	{
		sys_GetEcmsInfoMore($cr[classid],$line,$strlen,$have_class,$enews,$tr,$doing,$ret_r,$cr,$dofirstinfo,$fsubtitle,$fsubnews,$fdoing,$ewhere,$eorder);
	}
}

//��ģ�����Ŀ������ǩ
function sys_ShowClassByTemp($classid,$tempid,$show=0,$cline=0){
	global $navclassid,$empire,$class_r,$public_r,$dbtbpre;
	//��ǰ��Ŀ
	if('dg'.$classid=='dgselfinfo')
	{
		if(empty($navclassid))
		{$classid=0;}
		else
		{
			$classid=$navclassid;
			//�ռ��������ʾͬ�����
			if($class_r[$classid][islast]&&$class_r[$classid][bclassid])
			{
				$classid=$class_r[$classid][bclassid];
			}
			if($class_r[$classid][islast]&&empty($class_r[$classid][bclassid]))
			{$classid=0;}
		}
	}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	if(empty($rownum))
	{$rownum=1;}
	//��������
	if($cline)
	{
		$limit=" limit ".$cline;
	}
	//�滻����
	$bclassname=$class_r[$classid][classname];
	$br[classid]=$classid;
	$bclassurl=sys_ReturnBqClassname($br,9);
	$listtemp=str_replace("[!--bclassname--]",$bclassname,$listtemp);
	$listtemp=str_replace("[!--bclassurl--]",$bclassurl,$listtemp);
	$listtemp=str_replace("[!--bclassid--]",$classid,$listtemp);
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	$sql=$empire->query("select classid,classname,islast,sonclass,tbname,intro,classimg,infos from {$dbtbpre}enewsclass where bclassid='$classid' and showclass=0 order by myorder,classid".$limit);
	while($r=$empire->fetch($sql))
	{
		//��ʾ���������
		if($show)
		{
			$num=ReturnClassInfoNum($r);
		}
		//�滻�б����
		$repvar=ReplaceShowClassVars($no,$listvar,$r,$num,0,$subnews);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
	}
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//ѭ������Ŀ������ǩ
function sys_ForShowSonClass($classid,$tempid,$show=0,$cline=0){
	global $navclassid,$empire,$class_r,$public_r,$dbtbpre;
	//����Ŀ
	if(strstr($classid,","))
	{
		$where='classid in ('.$classid.')';
	}
	else
	{
		if('dg'.$classid=='dgselfinfo')//��ǰ��Ŀ
		{
			$classid=intval($navclassid);
		}
		$where="bclassid='$classid'";
	}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$tr[temptext]=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$tr[listvar]=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	//��������
	if($cline)
	{
		$limit=" limit ".$cline;
	}
	$no=1;
	$sql=$empire->query("select classid,classname,islast,sonclass,tbname,intro,classimg,infos from {$dbtbpre}enewsclass where ".$where." and showclass=0 order by myorder,classid".$limit);
	while($r=$empire->fetch($sql))
	{
		//��ʾ��Ŀ������
		if($show)
		{
			$num=ReturnClassInfoNum($r);
		}
		sys_GetShowClassMore($r[classid],$r,$tr,$no,$num,$show);
		$no++;
	}
}

//��Ŀ������ǩ��ѭ��
function sys_GetShowClassMore($bclassid,$bcr,$tr,$bno,$bnum,$show=0){
	global $empire,$class_r,$public_r,$dbtbpre;
	//ȡ��ģ��
	$listtemp=$tr[temptext];
	$subnews=$tr[subnews];
	$listvar=$tr[listvar];
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	if(empty($rownum))
	{$rownum=1;}
	//�滻����
	$listtemp=str_replace("[!--bclassname--]",$bcr[classname],$listtemp);
	$bclassurl=sys_ReturnBqClassname($bcr,9);//��Ŀ����
	$listtemp=str_replace("[!--bclassurl--]",$bclassurl,$listtemp);
	$listtemp=str_replace("[!--bclassid--]",$bclassid,$listtemp);
	$bclassimg=$bcr[classimg]?$bcr[classimg]:$public_r[newsurl]."e/data/images/notimg.gif";//��ĿͼƬ
	$listtemp=str_replace("[!--bclassimg--]",$bclassimg,$listtemp);
	$listtemp=str_replace("[!--bintro--]",nl2br($bcr[intro]),$listtemp);//��Ŀ���
	$listtemp=str_replace("[!--bno--]",$bno,$listtemp);
	$listtemp=str_replace("[!--bnum--]",$bnum,$listtemp);
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	$sql=$empire->query("select classid,classname,islast,sonclass,tbname,intro,classimg,infos from {$dbtbpre}enewsclass where bclassid='$bclassid' and showclass=0 order by myorder,classid");
	while($r=$empire->fetch($sql))
	{
		//��ʾ��Ŀ������
		if($show)
		{
			$num=ReturnClassInfoNum($r);
		}
		//�滻�б����
		$repvar=ReplaceShowClassVars($no,$listvar,$r,$num,0,$subnews);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
	}
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//�滻��Ŀ������ǩ
function ReplaceShowClassVars($no,$listtemp,$r,$num,$ecms=0,$subnews=0){
	global $public_r,$class_r;
	//��Ŀ����
	if($ecms==1)
	{
		$classurl=sys_ReturnBqZtname($r);
		$r['classname']=$r['ztname'];
		$r['classid']=$r['ztid'];
		$r['classimg']=$r['ztimg'];
	}
	else
	{
		$classurl=sys_ReturnBqClassname($r,9);
	}
	if($subnews)
	{
		$r[intro]=sub($r[intro],0,$subnews,false);
	}
	$listtemp=str_replace("[!--classurl--]",$classurl,$listtemp);
	//��Ŀ����
	$listtemp=str_replace("[!--classname--]",$r[classname],$listtemp);
	//��Ŀid
	$listtemp=str_replace("[!--classid--]",$r[classid],$listtemp);
	//��ĿͼƬ
	if(empty($r[classimg]))
	{
		$r[classimg]=$public_r[newsurl]."e/data/images/notimg.gif";
	}
	$listtemp=str_replace("[!--classimg--]",$r[classimg],$listtemp);
	//��Ŀ���
	$listtemp=str_replace("[!--intro--]",nl2br($r[intro]),$listtemp);
	//��¼��
	$listtemp=str_replace("[!--num--]",$num,$listtemp);
	//���
	$listtemp=str_replace("[!--no--]",$no,$listtemp);
	return $listtemp;
}

//���Ե���
function sys_ShowLyInfo($line,$tempid,$bid=0){
	global $empire,$dbtbpre,$public_r;
	$a="";
	if($bid)
	{
		$a=" and bid='$bid'";
	}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	if(empty($rownum))
	{$rownum=1;}
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	$sql=$empire->query("select lyid,name,email,lytime,lytext,retext from {$dbtbpre}enewsgbook where checked=0".$a." order by lyid desc limit ".$line);
	while($r=$empire->fetch($sql))
	{
		//�滻�б����
		$repvar=ReplaceShowLyVars($no,$listvar,$r,$formatdate,$subnews);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
	}
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//�滻���Ա�ǩ
function ReplaceShowLyVars($no,$listtemp,$r,$formatdate,$subnews=0){
	global $public_r;
	$r['lytext']=stripSlashes($r['lytext']);
	if($subnews)
	{
		$r['lytext']=sub($r['lytext'],0,$subnews,false);
	}
	$listtemp=str_replace("[!--lyid--]",$r['lyid'],$listtemp);//id
	$listtemp=str_replace("[!--lytext--]",nl2br($r['lytext']),$listtemp);//��������
	$listtemp=str_replace("[!--retext--]",nl2br(stripSlashes($r['retext'])),$listtemp);//�ظ�
	$listtemp=str_replace("[!--lytime--]",format_datetime($r['lytime'],$formatdate),$listtemp);
	$listtemp=str_replace("[!--name--]",stripSlashes($r['name']),$listtemp);
	$listtemp=str_replace("[!--email--]",stripSlashes($r['email']),$listtemp);
	//���
	$listtemp=str_replace("[!--no--]",$no,$listtemp);
	return $listtemp;
}

//ר�����
function sys_ShowZtData($tempid,$zcid=0,$cline=0,$classid=0){
	global $empire,$dbtbpre,$public_r;
	$a='';
	if($zcid)
	{
		$a.=' and zcid in ('.$zcid.')';
	}
	if($classid)
	{
		$a.=' and classid in ('.$classid.')';
	}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	if(empty($rownum))
	{$rownum=1;}
	//��������
	if($cline)
	{
		$limit=" limit ".$cline;
	}
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	$sql=$empire->query("select ztid,ztname,intro,ztimg from {$dbtbpre}enewszt where showzt=0".$a." order by myorder,ztid desc".$limit);
	while($r=$empire->fetch($sql))
	{
		//�滻�б����
		$repvar=ReplaceShowClassVars($no,$listvar,$r,$num,1,$subnews);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
	}
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//ͼ��ģ�ͷ�ҳ��ǩ
function sys_PhotoMorepage($tempid,$spicwidth=0,$spicheight=0){
	global $navinfor;
	$morepic=$navinfor['morepic'];
	if(empty($morepic))
	{
		return "";
	}
	//ȡ�ñ�ǩ
	$tempr=sys_ReturnBqTemp($tempid);
	if(empty($tempr['tempid']))
	{return "";}
	$rexp="\r\n";
	$fexp="::::::";
	$gs="";
	if($spicwidth)
	{$gs=" width='".$spicwidth."'";}
	if($spicheight)
	{$gs.=" height='".$spicheight."'";}
	$rstr="";
	$sdh="";
	$firstpic="";
	$optionstr="";
	$titleoption="";
	$listpage="";
	$nbsp="";
	$rr=explode($rexp,$morepic);
	$count=count($rr);
	for($i=0;$i<$count;$i++)
	{
		$j=$i+1;
		$fr=explode($fexp,$rr[$i]);
		$smallpic=$fr[0];	//Сͼ
		$bigpic=$fr[1];	//��ͼ
		if(empty($bigpic))
		{
			$bigpic=$smallpic;
		}
		$picname=ehtmlspecialchars($fr[2]);	//����
		$showpic=ReplaceMorePagelistvar($tempr['listvar'],$picname,$bigpic);
		$sdh.=$nbsp."<a href='#ecms' onclick='GotoPhPage(".$j.");' title='".$picname."'><img src='".$smallpic."' alt='".$picname."' border=0".$gs."></a>";
		if($i==0)
		{
			$firstpic=$showpic;
		}
		$rstr.="photosr[".$j."]=\"".addslashes($showpic)."\";
		";
		$optionstr.="<option value=".$j.">�� ".$j." ҳ</option>";
		$titleoption.="<option value=".$j.">".$j."��".$picname."</option>";
		$listpage.=$nbsp."<a href='#ecms' onclick='GotoPhPage(".$j.");' title='".$picname."'>".$j."</a>";
		$nbsp="&nbsp;";
	}
	echo ReplaceMorePagetemp($tempr['temptext'],$rstr,$sdh,$optionstr,$titleoption,$firstpic,$listpage);
}

//�滻ͼƬ����ҳģ��
function ReplaceMorePagetemp($temp,$rstr,$sdh,$select,$titleselect,$showpic,$listpage){
	$temp=str_replace("[!--photor--]",$rstr,$temp);
	$temp=str_replace("[!--smalldh--]",$sdh,$temp);
	$temp=str_replace("[!--select--]",$select,$temp);
	$temp=str_replace("[!--titleselect--]",$titleselect,$temp);
	$temp=str_replace("[!--listpage--]",$listpage,$temp);
	$temp=str_replace("<!--list.var1-->",$showpic,$temp);
	return $temp;
}

//�滻ͼƬ��listvarģ��
function ReplaceMorePagelistvar($temp,$picname,$picurl){
	$temp=str_replace("[!--picname--]",$picname,$temp);
	$temp=str_replace("[!--picurl--]",$picurl,$temp);
	return $temp;
}

//�����ѡ���ֶ�����
function sys_EchoCheckboxFValue($f,$exp='<br>'){
	global $navinfor;
	$r=explode('|',$navinfor[$f]);
	$count=count($r);
	for($i=1;$i<$count-1;$i++)
	{
		if($i==1)
		{
			$str.=$r[$i];
		}
		else
		{
			$str.=$exp.$r[$i];
		}
	}
	echo $str;
}

//���۵���
function sys_ShowPlInfo($line,$tempid,$classid=0,$id=0,$isgood=0,$enews=0){
	global $empire,$dbtbpre,$class_r,$public_r;
	$a="";
	if($isgood)
	{
		$a.=" and isgood='$isgood'";
	}
	if($classid)
	{
		if($class_r[$classid][islast])
		{
			$where="classid='$classid'";
		}
		else
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		$a.=" and ".$where;
	}
	if($id)
	{
		$a.=" and id='$id'";
	}
	//����
	if($enews==1)//֧��
	{
		$order='zcnum desc,plid desc';
	}
	elseif($enews==2)//����
	{
		$order='fdnum desc,plid desc';
	}
	else//����ʱ��
	{
		$order='plid desc';
	}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	if(empty($rownum))
	{$rownum=1;}
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	$sql=$empire->query("select plid,userid,username,saytime,id,classid,zcnum,fdnum,saytext from {$dbtbpre}enewspl_".$public_r['pldeftb']." where checked=0".$a." order by ".$order." limit ".$line);
	while($r=$empire->fetch($sql))
	{
		//�滻�б����
		$repvar=ReplaceShowPlVars($no,$listvar,$r,$formatdate,$subnews);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
	}
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//�滻���۱�ǩ
function ReplaceShowPlVars($no,$listtemp,$r,$formatdate,$subnews=0){
	global $public_r,$empire,$dbtbpre,$class_r;
	//����
	$infor=$empire->fetch1("select isurl,titleurl,classid,id,title,titlepic from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]." where id='$r[id]' limit 1");
	$r['saytext']=stripSlashes($r['saytext']);
	if($subnews)
	{
		$r['saytext']=sub($r['saytext'],0,$subnews,false);
	}
	if($r['userid'])
	{
		$r['username']="<a href='".$public_r[newsurl]."e/space/?userid=$r[userid]' target='_blank'>$r[username]</a>";
	}
	if(empty($r['username']))
	{
		$r['username']='����';
	}
	$titleurl=sys_ReturnBqTitleLink($infor);
	$titlepic=$infor['titlepic']?$infor['titlepic']:$public_r['newsurl'].'e/data/images/notimg.gif';
	$listtemp=str_replace("[!--titleurl--]",$titleurl,$listtemp);
	$listtemp=str_replace("[!--title--]",$infor['title'],$listtemp);
	$listtemp=str_replace("[!--titlepic--]",$titlepic,$listtemp);
	$listtemp=str_replace("[!--plid--]",$r['plid'],$listtemp);
	$listtemp=str_replace("[!--pltext--]",RepPltextFace($r['saytext']),$listtemp);
	$listtemp=str_replace("[!--id--]",$r['id'],$listtemp);
	$listtemp=str_replace("[!--classid--]",$r['classid'],$listtemp);
	$listtemp=str_replace("[!--pltime--]",date($formatdate,$r['saytime']),$listtemp);
	$listtemp=str_replace("[!--username--]",$r['username'],$listtemp);
	$listtemp=str_replace("[!--zcnum--]",$r['zcnum'],$listtemp);
	$listtemp=str_replace("[!--fdnum--]",$r['fdnum'],$listtemp);
	//���
	$listtemp=str_replace("[!--no--]",$no,$listtemp);
	return $listtemp;
}

//��ʾ������Ա��Ϣ
function sys_ShowMemberInfo($userid=0,$fields=''){
	global $empire,$dbtbpre,$public_r,$navinfor,$level_r;
	if(empty($userid)&&$navinfor[ismember]==0)
	{
		return '';
	}
	if(!defined('InEmpireCMSUser'))
	{
		include_once ECMS_PATH.'e/member/class/user.php';
	}
	$uid=$userid?$userid:$navinfor[userid];
	$uid=(int)$uid;
	if(empty($fields))
	{
		$fields='u.*,ui.*';
	}
	$r=$empire->fetch1("select ".$fields." from ".eReturnMemberTable()." u LEFT JOIN {$dbtbpre}enewsmemberadd ui ON u.".egetmf('userid')."=ui.userid where u.".egetmf('userid')."='$uid' limit 1");
	$field_groupid=egetmf('groupid');
	$r['groupname']=$level_r[$r[$field_groupid]][groupname];//��Ա��
	return $r;
}

//���û�Ա�б�
function sys_ListMemberInfo($line=10,$ecms=0,$groupid=0,$userids=0,$fields=''){
	global $empire,$dbtbpre,$public_r,$navinfor,$level_r;
	if(!defined('InEmpireCMSUser'))
	{
		include_once ECMS_PATH.'e/member/class/user.php';
	}
	//��������
	if($ecms==1)//��������
	{
		$order='u.'.egetmf('userfen').' desc';
	}
	elseif($ecms==2)//�ʽ�����
	{
		$order='u.'.egetmf('money').' desc';
	}
	elseif($ecms==3)//�ռ���������
	{
		$order='ui.viewstats desc';
	}
	else//�û�ID����
	{
		$order='u.'.egetmf('userid').' desc';
	}
	$where='';
	if($groupid)
	{
		$where.=' and u.'.egetmf('groupid').' in ('.$groupid.')';
	}
	if($userids)
	{
		$where.=' and u.'.egetmf('userid').' in ('.$userids.')';
	}
	if(empty($fields))
	{
		$fields='u.*,ui.*';
	}
	$sql=$empire->query("select ".$fields." from ".eReturnMemberTable()." u LEFT JOIN {$dbtbpre}enewsmemberadd ui ON u.".egetmf('userid')."=ui.userid where u.".egetmf('checked')."=1".$where." order by ".$order." limit ".$line);
	return $sql;
}

//��ʾTAGS
function sys_eShowTags($cid,$num=0,$line=0,$order='',$isgood='',$isgoodshow='',$showjg='',$shownum=0,$cs='',$vartype=''){
	global $empire,$dbtbpre,$public_r,$navinfor;
	$str='';
	if(empty($showjg))
	{
		$showjg=' &nbsp; ';
	}
	$ln=0;
	if($cid=='selfinfo')
	{
		if(empty($navinfor['infotags']))
		{
			return '';
		}
		$jg='';
		$r=explode(',',$navinfor['infotags']);
		$count=count($r);
		for($i=0;$i<$count;$i++)
		{
			$ln++;
			$br='';
			if($line)
			{
				if($ln%$line==0)
				{
					$br='<br>';
				}
			}
			//TAGSID
			if($vartype=='tagid')
			{
				$tagr=$empire->fetch1("select tagid from {$dbtbpre}enewstags where tagname='".RepPostVar($r[$i])."' limit 1");
			}
			if(empty($cs)&&!empty($public_r['rewritetags']))
			{
				if($vartype=='tagid')
				{
					$rewriter=eReturnRewriteTagsUrl($tagr['tagid'],'etagid'.$tagr['tagid'],1);
					$tagsurl=$rewriter['pageurl'];
				}
				else
				{
					$rewriter=eReturnRewriteTagsUrl(0,$r[$i],1);
					$tagsurl=$rewriter['pageurl'];
				}
			}
			else
			{
				$tagsurl=$public_r[newsurl].'e/tags/?'.($vartype=='tagid'?'tagid='.$tagr['tagid']:'tagname='.urlencode($r[$i])).$cs;
			}
			$str.=$jg.'<a href="'.$tagsurl.'" target="_blank">'.$r[$i].'</a>'.$br;
			$jg=$br?'':$showjg;
		}
	}
	else
	{
		$and='';
		$where='';
		if($cid)
		{
			$where=strstr($cid,',')?"cid in ($cid)":"cid='$cid'";
			$and=' and ';
		}
		if($isgood)
		{
			$where.=$and.'isgood=1';
		}
		if($where)
		{
			$where=' where '.$where;
		}
		$order=$order?' '.$order:' tagid desc';
		$limit='';
		if($num)
		{
			$limit=' limit '.$num;
		}
		//�Ƽ����
		$gfont1='';
		$gfont2='';
		if($isgoodshow)
		{
			if(strstr($isgoodshow,'r'))
			{
				$gfont1='<font color="red">';
				$gfont2='</font>';
			}
			if(strstr($isgoodshow,'s'))
			{
				$gfont1=$gfont1.'<b>';
				$gfont2='</b>'.$gfont2;
			}
		}
		$jg='';
		$snum='';
		$sql=$empire->query("select tagid,tagname,num,isgood from {$dbtbpre}enewstags".$where." order by".$order.$limit);
		while($r=$empire->fetch($sql))
		{
			if($shownum)
			{
				$snum='('.$r[num].')';
			}
			$font1='';
			$font2='';
			if($isgoodshow&&$r[isgood])
			{
				$font1=$gfont1;
				$font2=$gfont2;
			}
			$ln++;
			$br='';
			if($line)
			{
				if($ln%$line==0)
				{
					$br='<br>';
				}
			}
			if(empty($cs)&&!empty($public_r['rewritetags']))
			{
				$rewriter=eReturnRewriteTagsUrl($r['tagid'],$vartype=='tagid'?'etagid'.$r['tagid']:$r['tagname'],1);
				$tagsurl=$rewriter['pageurl'];
			}
			else
			{
				$tagsurl=$public_r[newsurl].'e/tags/?'.($vartype=='tagid'?'tagid='.$r[tagid]:'tagname='.urlencode($r[tagname])).$cs;
			}
			$str.=$jg.'<a href="'.$tagsurl.'" target="_blank">'.$font1.$r[tagname].$snum.$font2.'</a>'.$br;
			$jg=$br?'':$showjg;
		}
	}
	echo $str;
}

//�����鶯��ǩ������SQL���ݺ���
function sys_ReturnEcmsIndexLoopBq($id=0,$line=10,$enews=3,$classid='',$mid='',$ewhere=''){
	global $navclassid;
	if($enews==1)//ר������
	{
		$type='zt';
		$eorder='newstime desc';
		$selectf=',ztid,cid,isgood';
	}
	elseif($enews==2)//ר������
	{
		$type='zt';
		$eorder='newstime asc';
		$selectf=',ztid,cid,isgood';
	}
	elseif($enews==3)//ר���Ƽ�
	{
		$type='zt';
		$eorder='newstime desc';
		$selectf=',ztid,cid,isgood';
		$where='isgood>0';
	}
	elseif($enews==4)//ר����������
	{
		$type='ztc';
		$eorder='newstime desc';
		$selectf=',ztid,cid,isgood';
	}
	elseif($enews==5)//ר����������
	{
		$type='ztc';
		$eorder='newstime asc';
		$selectf=',ztid,cid,isgood';
	}
	elseif($enews==6)//ר�������Ƽ�
	{
		$type='ztc';
		$eorder='newstime desc';
		$selectf=',ztid,cid,isgood';
		$where='isgood>0';
	}
	elseif($enews==7)//��Ƭ����
	{
		$type='sp';
		$eorder='newstime desc';
		$selectf='';
	}
	elseif($enews==8)//��Ƭ����
	{
		$type='sp';
		$eorder='newstime asc';
		$selectf='';
	}
	elseif($enews==9)//TAGS����
	{
		$type='tags';
		$eorder='newstime desc';
		$selectf='';
	}
	elseif($enews==10)//TAGS����
	{
		$type='tags';
		$eorder='newstime asc';
		$selectf='';
	}
	elseif($enews==11)//SQL����
	{
		$type='sql';
		$eorder='newstime asc';
		$selectf='';
	}
	if($id=='selfinfo')//��ʾ��ǰID��Ϣ
	{
		$id=$navclassid;
	}
	if(!empty($where))
	{
		$ewhere=$ewhere?$where.' and ('.$ewhere.')':$where;
	}
	return sys_ReturnTogQuery($type,$id,$line,$classid,$mid,$ewhere,$eorder,$selectf);
}

//������ϲ�ѯ
function sys_ReturnTogQuery($type,$id,$line,$classid='',$mid='',$ewhere='',$eorder='',$selectf=''){
	global $empire,$public_r,$class_r,$class_zr,$navclassid,$dbtbpre,$class_tr,$emod_r;
	if($type=='tags')//TAGS
	{
		$idf='tagid';
		$orderf='newstime desc';
		$table=$dbtbpre.'enewstagsdata';
	}
	elseif($type=='zt')//ר��
	{
		$idf='ztid';
		$orderf='newstime desc';
		$table=$dbtbpre.'enewsztinfo';
	}
	elseif($type=='ztc')//ר������
	{
		$idf='cid';
		$orderf='newstime desc';
		$table=$dbtbpre.'enewsztinfo';
	}
	elseif($type=='sql')//SQL��ѯ
	{
		$query_first=substr($id,0,7);
		if(!($query_first=='select '||$query_first=='SELECT '))
		{
			return '';
		}
		$id=RepSqlTbpre($id);
		$sql=$empire->query1($id);
		if(!$sql)
		{
			echo'SQL Error: '.ReRepSqlTbpre($id);
		}
		return $sql;
	}
	else//��Ƭ
	{
		$idf='spid';
		$orderf='newstime desc';
		$table=$dbtbpre.'enewssp_2';
	}
	$where=strstr($id,',')?"$idf in ($id)":"$idf='$id'";
	//��Ŀ
	if($classid)
	{
		if(strstr($classid,','))//����Ŀ
		{
			$son_r=sys_ReturnMoreClass($classid,1);
			$classid=$son_r[0];
			$add=$son_r[1];
		}
		else
		{
			if($classid=='selfinfo')//��ʾ��ǰ��Ŀ��Ϣ
			{
				$classid=$navclassid;
			}
			if($class_r[$classid][islast])
			{
				$add="classid='$classid'";
			}
			else
			{
				$add=ReturnClass($class_r[$classid][sonclass]);
			}
		}
		$where.=' and ('.$add.')';
	}
	//ģ��
	if($mid)
	{
		$where.=strstr($mid,',')?" and mid in ($mid)":" and mid='$mid'";
	}
	//����sql����
	if(!empty($ewhere))
	{
		$where.=' and ('.$ewhere.')';
	}
	//����
	if(!empty($eorder))
	{
		$orderf=$eorder;
	}
	$query='select classid,id'.$selectf.' from '.$table.' where '.$where.' order by '.$orderf.' limit '.$line;
	$sql=$empire->query1($query);
	if(!$sql)
	{
		echo'SQL Error: '.ReRepSqlTbpre($query);
	}
	return $sql;
}

//����TAGS��Ϣ
function sys_eShowTagsInfo($tagid,$line,$strlen,$tempid,$classid='',$mid=''){
	global $empire,$dbtbpre,$public_r,$class_r,$emod_r;
	if(empty($tagid))
	{
		return '';
	}
	$sql=sys_ReturnTogQuery('tags',$tagid,$line,$classid,$mid);
	if(!$sql)
	{return "";}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($tempid);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	$docode=$tr[docode];
	if(empty($rownum))
	{$rownum=1;}
	//�ֶ�
	$ret_r=ReturnReplaceListF($tr[modid]);
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	while($r=$empire->fetch($sql))
	{
		if(empty($class_r[$r[classid]][tbname]))
		{
			continue;
		}
		$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]." where id='$r[id]' limit 1");
		if(empty($infor['id']))
		{
			continue;
		}
		$infor[oldtitle]=$infor[title];
		//�滻�б����
		$repvar=ReplaceListVars($no,$listvar,$subnews,$strlen,$formatdate,$url,$have_class,$infor,$ret_r,$docode);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
    }
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//-------------------------- ��Ƭ --------------------------
//��ʾ��Ƭ
function sys_eShowSpInfo($spvar,$line=10,$strlen=0){
	global $empire,$dbtbpre,$public_r;
	if(empty($spvar))
	{
		return '';
	}
	$spr=$empire->fetch1("select spid,spname,sppic,spsay,tempid,sptype from {$dbtbpre}enewssp where varname='$spvar' limit 1");
	if($spr['sptype']==1)//��̬��Ϣ��Ƭ
	{
		sys_eShowSp1($spr['spid'],$spr,$line,$strlen);
	}
	elseif($spr['sptype']==2)
	{
		sys_eShowSp2($spr['spid'],$spr,$line,$strlen);
	}
	elseif($spr['sptype']==3)
	{
		sys_eShowSp3($spr['spid']);
	}
}

//�滻��Ƭ��
function ReplaceSpClassname($temp,$spid,$spr){
	$temp=str_replace("[!--the.spname--]",$spr[spname],$temp);
	$temp=str_replace("[!--the.spid--]",$spid,$temp);
	$temp=str_replace("[!--the.sppic--]",$spr[sppic],$temp);
	$temp=str_replace("[!--the.spsay--]",$spr[spsay],$temp);
	return $temp;
}

//��̬��Ϣ��Ƭ
function sys_eShowSp1($spid,$spr,$line,$strlen){
	global $empire,$dbtbpre,$public_r;
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($spr['tempid']);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	//�滻ģ�����
	$listtemp=ReplaceSpClassname($listtemp,$spid,$spr);
	if(empty($rownum))
	{$rownum=1;}
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	$sql=$empire->query("select sid,title,titlepic,bigpic,titleurl,smalltext,titlefont,newstime,titlepre,titlenext from {$dbtbpre}enewssp_1 where spid='$spid' order by newstime desc limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$r[oldtitle]=$r[title];
		//�滻�б����
		$repvar=ReplaceShowSponeVars($no,$listvar,$subnews,$strlen,$formatdate,$r);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
    }
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//�滻��̬��Ƭ��ǩ
function ReplaceShowSponeVars($no,$listtemp,$subnews,$subtitle,$formatdate,$r){
	global $public_r;
	//����
	if(!empty($subtitle))//��ȡ�ַ�
	{
		$r[title]=sub($r[title],0,$subtitle,false);
	}
	$r[title]=DoTitleFont($r[titlefont],$r[title]);
	$listtemp=str_replace('[!--title--]',$r['title'],$listtemp);
	$listtemp=str_replace('[!--oldtitle--]',$r['oldtitle'],$listtemp);
	//ʱ��
	$listtemp=str_replace('[!--newstime--]',date($formatdate,$r['newstime']),$listtemp);
	//��������
	$listtemp=str_replace('[!--id--]',$r['sid'],$listtemp);
	$listtemp=str_replace('[!--titleurl--]',$r['titleurl'],$listtemp);
	$listtemp=str_replace('[!--titlepic--]',$r['titlepic'],$listtemp);
	$listtemp=str_replace('[!--bigpic--]',$r['bigpic'],$listtemp);
	$listtemp=str_replace('[!--titlepre--]',$r['titlepre'],$listtemp);
	$listtemp=str_replace('[!--titlenext--]',$r['titlenext'],$listtemp);
	//���
	if(!empty($subnews))//��ȡ�ַ�
	{
		$r[smalltext]=sub($r[smalltext],0,$subnews,false);
	}
	$listtemp=str_replace('[!--smalltext--]',nl2br($r['smalltext']),$listtemp);
	//���
	$listtemp=str_replace('[!--no.num--]',$no,$listtemp);
	return $listtemp;
}

//��̬��Ϣ��Ƭ
function sys_eShowSp2($spid,$spr,$line,$strlen){
	global $empire,$dbtbpre,$public_r,$class_r,$emod_r;
	$sql=sys_ReturnTogQuery('sp',$spid,$line,'','');
	if(!$sql)
	{return "";}
	//ȡ��ģ��
	$tr=sys_ReturnBqTemp($spr['tempid']);
	if(empty($tr['tempid']))
	{return "";}
	$listtemp=str_replace('[!--news.url--]',$public_r[newsurl],$tr[temptext]);
	$subnews=$tr[subnews];
	$listvar=str_replace('[!--news.url--]',$public_r[newsurl],$tr[listvar]);
	$rownum=$tr[rownum];
	$formatdate=$tr[showdate];
	$docode=$tr[docode];
	//�滻ģ�����
	$listtemp=ReplaceSpClassname($listtemp,$spid,$spr);
	if(empty($rownum))
	{$rownum=1;}
	//�ֶ�
	$ret_r=ReturnReplaceListF($tr[modid]);
	//�б�
	$list_exp="[!--empirenews.listtemp--]";
	$list_r=explode($list_exp,$listtemp);
	$listtext=$list_r[1];
	$no=1;
	$changerow=1;
	while($r=$empire->fetch($sql))
	{
		if(empty($class_r[$r[classid]][tbname]))
		{
			continue;
		}
		$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]." where id='$r[id]' limit 1");
		if(empty($infor['id']))
		{
			continue;
		}
		$infor[oldtitle]=$infor[title];
		//�滻�б����
		$repvar=ReplaceListVars($no,$listvar,$subnews,$strlen,$formatdate,$url,$have_class,$infor,$ret_r,$docode);
		$listtext=str_replace("<!--list.var".$changerow."-->",$repvar,$listtext);
		$changerow+=1;
		//��������
		if($changerow>$rownum)
		{
			$changerow=1;
			$string.=$listtext;
			$listtext=$list_r[1];
		}
		$no++;
    }
	//��������
    if($changerow<=$rownum&&$listtext<>$list_r[1])
	{
		$string.=$listtext;
    }
    $string=$list_r[0].$string.$list_r[2];
	echo $string;
}

//������Ƭ
function sys_eShowSp3($spid){
	global $empire,$dbtbpre;
	$r=$empire->fetch1("select sptext from {$dbtbpre}enewssp_3 where spid='$spid' limit 1");
	echo $r['sptext'];
}

//����������ͼ
function sys_ResizeImg($file,$width,$height,$docut=0,$target_filename='',$target_path='e/data/tmp/titlepic/'){
	global $public_r,$ecms_config;
	if(!$file||!$width||!$height)
	{
		return $file;
	}
	//��չ��
	$filetype=GetFiletype($file);
	if(!strstr($ecms_config['sets']['tranpicturetype'],','.$filetype.','))
	{
		return $file;
	}
	$efileurl=eReturnFileUrl();
	if(strstr($file,$efileurl))
	{
		$file=str_replace($efileurl,'/d/file/',$file);
	}
	if(strstr($file,'://'))
	{
		return $file;
	}
	$filename=eReturnEcmsMainPortPath().substr($file,1);//moreport
	if(!file_exists($filename))
	{
		return $file;
	}
	if($target_filename)
	{
		$newfilename=$target_filename;
	}
	else
	{
		$newfilename=md5($file.'-'.$width.'-'.$height.'-'.$docut);
	}
	$newpath=ECMS_PATH.$target_path;
	$newurl=$public_r['newsurl'].$target_path;
	$newname=$newpath.$newfilename;
	if(empty($target_filename)&&file_exists($newname.$filetype))
	{
		return $newurl.$newfilename.$filetype;
	}
	if(!defined('InEmpireCMSGd'))
	{
		include_once ECMS_PATH.'e/class/gd.php';
	}
	$filer=ResizeImage($filename,$newname,$width,$height,$docut);
	$fileurl=$newurl.$newfilename.$filer['filetype'];
	return $fileurl;
}

//��ʾͼ������
function sys_ModShowMorepic($epicswidth=120,$epicsheight=80,$temptext=''){
	global $navinfor,$public_r;
	$morepic=$navinfor['morepic'];
	if(empty($morepic))
	{
		return "";
	}
	//ģ��
	if(empty($temptext))
	{
		$temptext='<table><tr>[!--empirenews.listtemp--]<td bgcolor="#cccccc" align="center" id="espicid\'+i+\'"\'+cname+\'><a href="#empirecms" onclick="ecmsShowPic(\'+i+\');"><img src="\'+ecmspicr[i][0]+\'" width="\'+epicswidth+\'" height="\'+epicsheight+\'" border="0"></a><br>\'+(i+1)+\'/\'+ecmspicnum+\'</td>[!--empirenews.listtemp--]</tr></table>';
	}
	else
	{
		$temptext=str_replace("\r\n","",$temptext);
		$temptext=str_replace("'","\"",$temptext);
		$temptext=str_replace("[!--page--]","'+i+'",$temptext);
		$temptext=str_replace("[!--thiscss--]","'+cname+'",$temptext);
		$temptext=str_replace("[!--spicurl--]","'+ecmspicr[i][0]+'",$temptext);
		$temptext=str_replace("[!--spicwidth--]","'+epicswidth+'",$temptext);
		$temptext=str_replace("[!--spicheight--]","'+epicsheight+'",$temptext);
		$temptext=str_replace("[!--spicno--]","'+(i+1)+'/'+ecmspicnum+'",$temptext);
	}
	$tempr=explode('[!--empirenews.listtemp--]',$temptext);
	//ͼƬ��ַ
	$rexp="\r\n";
	$fexp="::::::";
	$rr=explode($rexp,$morepic);
	$count=count($rr);
?>

<script>

var ecmspicr=new Array();

var epicswidth=<?=$epicswidth?>;	//Сͼ���
var epicsheight=<?=$epicsheight?>;	//Сͼ�߶�

var eopenlistpage=1;	//��ʾ�б��ҳ����
var eopenselectpage=1;	//��ʾ������ҳ����
var eopensmallpics=1;	//��ʾСͼ����

var ecmspicnum=0;

//ͼƬ�б�
<?php
for($i=0;$i<$count;$i++)
{
	$fr=explode($fexp,$rr[$i]);
	$smallpic=$fr[0];	//Сͼ
	$bigpic=$fr[1];	//��ͼ
	if(empty($bigpic))
	{
		$bigpic=$smallpic;
	}
	$picname=ehtmlspecialchars($fr[2]);	//����
?>
ecmspicr[<?=$i?>]=new Array("<?=$smallpic?>","<?=$bigpic?>","<?=$picname?>");
<?php
}
?>

ecmspicnum=ecmspicr.length;

if(document.getElementById("ecmssmallpicsid")==null)
{
	eopensmallpics=0;
}
if(document.getElementById("ecmsselectpagesid")==null)
{
	eopenselectpage=0;
}
if(document.getElementById("ecmslistpagesid")==null)
{
	eopenlistpage=0;
}


//showsmallpics
function ecmsShowSmallPics(){
	var str='';
	var selectpages='';
	var listpages='';
	var i;
	var cname='';
	var lname='';
	var sname='';
	for(i=0;i<ecmspicnum;i++)
	{
		cname='';
		lname='';
		sname='';
		if(i==0)
		{
			cname=' class="espiccss"';
			lname=' class="epiclpcss"';
			sname=' selected';
		}
		str+='<?=$tempr[1]?>';

		selectpages+='<option value="'+i+'"'+sname+'>�� '+(i+1)+' ҳ</option>';

		listpages+='<a href="#empirecms" id="epiclpid'+i+'" onclick="ecmsShowPic('+i+');"'+lname+'>'+(i+1)+'</a> ';
	}
	if(eopensmallpics==1)
	{
		document.getElementById("ecmssmallpicsid").innerHTML='<?=$tempr[0]?>'+str+'<?=$tempr[2]?>';
	}
	if(eopenselectpage==1)
	{
		document.getElementById("ecmsselectpagesid").innerHTML='<select name="tothepicpage" id="tothepicpage" onchange="ecmsShowPic(this.options[this.selectedIndex].value);">'+selectpages+'</select>';
	}
	if(eopenlistpage==1)
	{
		document.getElementById("ecmslistpagesid").innerHTML=listpages;
	}
	document.getElementById("ethispage").value=0;
}

</script>

<script type="text/javascript" src="<?=$public_r['newsurl']?>e/data/modadd/morepic/empirecmsmorepic.js"></script>
<script>ecmsShowSmallPics();ecmsShowPic(0);</script>

<?php
}
?>