<?php
//���������������
function ChangeInfoOtherLink($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"changedata");
	$start=(int)$start;
	$tbname=RepPostVar($tbname);
	if(empty($tbname)||!eCheckTbname($tbname))
	{
		printerror("ErrorUrl","history.go(-1)");
    }
	//����Ŀˢ��
	$classid=(int)$classid;
	if($classid)
	{
		if(empty($class_r[$classid][islast]))//����Ŀ
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//�ռ���Ŀ
		{
			$where="classid='$classid'";
		}
		$add1=" and (".$where.")";
    }
	//��IDˢ��
	if($retype)
	{
		$startid=(int)$startid;
		$endid=(int)$endid;
		if($endid)
		{
			$add1.=" and id>=$startid and id<=$endid";
	    }
    }
	else
	{
		$startday=RepPostVar($startday);
		$endday=RepPostVar($endday);
		if($startday&&$endday)
		{
			$add1.=" and truetime>=".to_time($startday." 00:00:00")." and truetime<=".to_time($endday." 23:59:59");
	    }
    }
	$b=0;
	$sql=$empire->query("select id,classid,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[infolinknum]);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r[id];
		//�ֶ��������
		$pubid=ReturnInfoPubid($r['classid'],$r['id']);
		$infopr=$empire->fetch1("select diyotherlink from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
		if($infopr['diyotherlink'])
		{
			continue;
		}
		//���ر�
		$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
		$infor=$empire->fetch1("select stb,keyboard from ".$infotb." where id='$r[id]' limit 1");
		//���ر���Ϣ
		$infodatatb=ReturnInfoDataTbname($tbname,$r['checked'],$infor['stb']);
		$newkeyid=GetKeyid($infor[keyboard],$r[classid],$r[id],$class_r[$r[classid]][link_num]);
		$usql=$empire->query("update ".$infodatatb." set keyid='$newkeyid' where id='$r[id]' limit 1");
	}
	if(empty($b))
	{
	    insert_dolog("");//������־
		printerror("ChangeInfoLinkSuccess",$from);
	}
	echo $fun_r[OneChangeInfoLinkSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmscom.php?enews=ChangeInfoOtherLink&tbname=$tbname&classid=$classid&start=$new_start&from=".urlencode($from)."&retype=$retype&startday=$startday&endday=$endday&startid=$startid&endid=$endid".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//���Ŀ¼�Ѵ���
function CheckPath($classpath){
	global $fun_r;
	if(empty($classpath)){
		echo $fun_r['EmptyPath'];
	}
	else{
		if(file_exists("../../".$classpath)){
			echo $fun_r['RePath'];
		}
		else{
			echo $fun_r['PathNot'];
		}
	}
	exit();
}

//�����Զ���ҳ��
function AddUserpage($add,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"userpage");
	$classid=(int)$add[classid];
	$title=$add['title'];
	$path=$add['path'];
	$pagetext=$add['pagetext'];
	if(empty($title)||empty($path))
	{
		printerror("EmptyUserpagePath","history.go(-1)");
    }
	$title=hRepPostStr($title,1);
	$path=hRepPostStr($path,1);
	$pagetext=RepPhpAspJspcode($pagetext);
	$pagetitle=RepPhpAspJspcode($add[pagetitle]);
	$pagekeywords=RepPhpAspJspcode($add[pagekeywords]);
	$pagedescription=RepPhpAspJspcode($add[pagedescription]);
	$tempid=(int)$add['tempid'];
	$gid=(int)$add['gid'];
	$sql=$empire->query("insert into {$dbtbpre}enewspage(title,path,pagetext,classid,pagetitle,pagekeywords,pagedescription,tempid) values('$title','$path','".eaddslashes2($pagetext)."','$classid','".eaddslashes($pagetitle)."','".eaddslashes($pagekeywords)."','".eaddslashes($pagedescription)."','$tempid');");
	$id=$empire->lastid();
	ReUserpage($id,$pagetext,$path,$title,$pagetitle,$pagekeywords,$pagedescription,$tempid);
	if($sql)
	{
		//������־
	    insert_dolog("id=$id&title=$title");
		printerror("AddUserpageSuccess","template/AddPage.php?enews=AddUserpage&gid=$gid&ChangePagemod=$add[pagemod]".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸��Զ���ҳ��
function EditUserpage($add,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"userpage");
	$id=(int)$add['id'];
	$classid=(int)$add[classid];
	$title=$add['title'];
	$path=$add['path'];
	$pagetext=$add['pagetext'];
	if(!$id||empty($title)||empty($path))
	{
		printerror("EmptyUserpagePath","history.go(-1)");
    }
	//�ı��ַ
	if($add['oldpath']<>$path)
	{
		DelFiletext($add['oldpath']);
	}
	$title=hRepPostStr($title,1);
	$path=hRepPostStr($path,1);
	$pagetext=RepPhpAspJspcode($pagetext);
	$pagetitle=RepPhpAspJspcode($add[pagetitle]);
	$pagekeywords=RepPhpAspJspcode($add[pagekeywords]);
	$pagedescription=RepPhpAspJspcode($add[pagedescription]);
	$tempid=(int)$add['tempid'];
	$gid=(int)$add['gid'];
	$sql=$empire->query("update {$dbtbpre}enewspage set title='$title',path='$path',pagetext='".eaddslashes2($pagetext)."',classid='$classid',pagetitle='".eaddslashes($pagetitle)."',pagekeywords='".eaddslashes($pagekeywords)."',pagedescription='".eaddslashes($pagedescription)."',tempid='$tempid' where id='$id'");
	ReUserpage($id,$pagetext,$path,$title,$pagetitle,$pagekeywords,$pagedescription,$tempid);
	if($sql)
	{
		//������־
	    insert_dolog("id=$id&title=$title");
		printerror("EditUserpageSuccess","template/ListPage.php?classid=$add[cid]&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ���Զ���ҳ��
function DelUserpage($id,$cid,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"userpage");
	$id=(int)$id;
	if(empty($id))
	{
		printerror("EmptyDelUserpageid","history.go(-1)");
    }
	$gid=(int)$_GET['gid'];
	$r=$empire->fetch1("select title,id,path from {$dbtbpre}enewspage where id='$id'");
	if(empty($r['id']))
	{
		printerror("NotDelUserpageid","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewspage where id='$id'");
	DelFiletext($r['path']);
	//moreportdo
	$eautodofile=str_replace('../../','',$r['path']);
	if($eautodofile)
	{
		$eautodofname='delfile|'.$eautodofile.'||';
		eAutodo_AddDo('eDelFileUserpage',0,0,0,0,0,$eautodofname);
	}
	if($sql)
	{
		//������־
	    insert_dolog("id=$id&title=$r[title]");
		printerror("DelUserpageSuccess","template/ListPage.php?classid=$cid&gid=$gid".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ˢ���Զ���ҳ��
function DoReUserpage($add,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"userpage");
	$id=$add['id'];
	$count=count($id);
	if(!$count)
	{
		printerror("EmptyReUserpageid","history.go(-1)");
    }
	for($i=0;$i<$count;$i++)
	{
		$id[$i]=(int)$id[$i];
		if(empty($id[$i]))
		{
			continue;
		}
		$ur=$empire->fetch1("select id,path,pagetext,title,pagetitle,pagekeywords,pagedescription,tempid from {$dbtbpre}enewspage where id='".$id[$i]."'");
		ReUserpage($ur[id],$ur[pagetext],$ur[path],$ur[title],$ur[pagetitle],$ur[pagekeywords],$ur[pagedescription],$ur[tempid]);
	}
	//������־
	insert_dolog("");
	printerror("DoReUserpageSuccess",EcmsGetReturnUrl());
}

//�����滻�ֶ�ֵ
function DoRepNewstext($start,$oldword,$newword,$field,$classid,$tid,$tbname,$over,$dozz,$dotxt,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre,$emod_r;
	$tbname=RepPostVar($tbname);
	$field=RepPostVar($field);
	$tid=(int)$tid;
	$dotype=(int)$_POST['dotype'];
	$classid=(int)$classid;
	if(!$field||empty($tbname)||!$tid)
	{
		printerror("FailCX","history.go(-1)");
	}
	if($dotype==0&&strlen($oldword)==0)
	{
		printerror("FailCX","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"repnewstext");//��֤Ȩ��
	//�����滻
	$postoldword=ClearAddsData($oldword);
	$postnewword=ClearAddsData($newword);
	//�滻����
	if($classid)//����Ŀ�滻
	{
		if(empty($class_r[$classid][islast]))//�м���Ŀ
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//�ռ���Ŀ
		{
			$where="classid='$classid'";
		}
		$add1=" and (".$where.")";
		$add2=" where (".$where.")";
    }
	$fr=$empire->fetch1("select tid,savetxt,tbdataf from {$dbtbpre}enewsf where tbname='$tbname' and f='$field' limit 1");
	//ϵͳ�ֶ�
	$specialdatafield=',keyid,dokey,newstempid,closepl,haveaddfen,infotags,';
	if(!$fr['tid']&&stristr($specialdatafield,','.$field.','))
	{
		$fr['tbdataf']=1;
	}
	//���Ƿ�ʽ
	if($dotype==1)
	{
		$repoldword=addslashes($oldword);
		$repnewword=addslashes($newword);
		if($over==1)//��ȫ�滻
		{
			if(empty($add2))
			{
				$and=" where ";
			}
			else
			{
				$and=" and ";
			}
			$add2.=$and.$field."='".$repoldword."'";
		}
		if($fr['tbdataf'])//����
		{
			//�����
			$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
			if($tbr['datatbs'])
			{
				$dtbr=explode(',',$tbr['datatbs']);
				$count=count($dtbr);
				for($i=1;$i<$count-1;$i++)
				{
					$empire->query("update {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." set ".$field."='$repnewword'".$add2);
				}
			}
			//δ���
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check_data set ".$field."='$repnewword'".$add2);
		}
		else//����
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname." set ".$field."='$repnewword'".$add2);
			//δ���
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check set ".$field."='$repnewword'".$add2);
		}
		//�滻���
		insert_dolog("tbname=".$tbname."&field=".$field."&dotype=1<br>oldword=".$oldword."<br>newword=".$newword);//������־
		printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
	}
	//���ı��滻
	elseif($fr['savetxt'])
	{
		$repoldword=addslashes($postoldword);
		$repnewword=addslashes($postnewword);
		//�ֶ�
		$selectf=$fr['tbdataf']?',stb':','.$field;
		$fieldform="<input type='hidden' name='field' value='".$field."'>";
		if(empty($public_r[dorepnum]))
		{
			$public_r[dorepnum]=600;
		}
		$start=(int)$start;
		$b=0;
		$sql=$empire->query("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[dorepnum]);
		while($r=$empire->fetch($sql))
		{
			$b=1;
			$newstart=$r[id];
			//���ر�
			$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
			//����
			$infor=$empire->fetch1("select isurl".$selectf." from ".$infotb." where id='$r[id]' limit 1");
			if($infor['isurl'])
			{
				continue;
			}
			//����
			if($fr['tbdataf'])
			{
				//���ر���Ϣ
				$infodatatb=ReturnInfoDataTbname($tbname,$r['checked'],$infor['stb']);
				$finfor=$empire->fetch1("select ".$field." from ".$infodatatb." where id='$r[id]' limit 1");
				$infor[$field]=$finfor[$field];
			}
			$value=GetTxtFieldText($infor[$field]);
			if(empty($value))
			{
				continue;
			}
			if($dozz==1)//����
			{
				$newvalue=DoRepNewstextZz($repoldword,$repnewword,$value);//�����滻
			}
			else//��ͨ
			{
				if(!stristr($value,$repoldword))
				{
					continue;
				}
				$newvalue=str_replace($repoldword,$repnewword,$value);
			}
			EditTxtFieldText($infor[$field],$newvalue);
		}
		//�滻���
		if(empty($b))
		{
			insert_dolog("tbname=".$tbname."&field=".$field."<br>oldword=".$oldword."<br>newword=".$newword);//������־
			printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
		}
		EchoRepFieldForm($tid,$tbname,$over,$dozz,$dotxt,$newstart,$fieldform,$classid,$postoldword,$postnewword);
	}
	//�����滻
	elseif($dozz==1)
	{
		//�ֶ�
		$selectf=$fr['tbdataf']?',stb':','.$field;
		$fieldform="<input type='hidden' name='field' value='".$field."'>";
		if(empty($public_r[dorepnum]))
		{
			$public_r[dorepnum]=600;
		}
		$start=(int)$start;
		$b=0;
		$sql=$empire->query("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[dorepnum]);
		while($r=$empire->fetch($sql))
		{
			$b=1;
			$newstart=$r[id];
			//���ر�
			$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
			//����
			$infor=$empire->fetch1("select isurl".$selectf." from ".$infotb." where id='$r[id]' limit 1");
			if($infor['isurl'])
			{
				continue;
			}
			if($fr['tbdataf'])//����
			{
				//���ر���Ϣ
				$infodatatb=ReturnInfoDataTbname($tbname,$r['checked'],$infor['stb']);
				$finfor=$empire->fetch1("select ".$field." from ".$infodatatb." where id='$r[id]' limit 1");
				$newvalue=DoRepNewstextZz($oldword,$newword,stripSlashes($finfor[$field]));//�����滻
				$empire->query("update ".$infodatatb." set ".$field."='".addslashes($newvalue)."' where id='$r[id]'");
			}
			else//����
			{
				$newvalue=DoRepNewstextZz($oldword,$newword,stripSlashes($infor[$field]));//�����滻
				$empire->query("update ".$infotb." set ".$field."='".addslashes($newvalue)."' where id='$r[id]'");
			}
		}
		//�滻���
		if(empty($b))
		{
			insert_dolog("tbname=".$tbname."&field=".$field."<br>oldword=".$oldword."<br>newword=".$newword);//������־
			printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
		}
		EchoRepFieldForm($tid,$tbname,$over,$dozz,$dotxt,$newstart,$fieldform,$classid,$postoldword,$postnewword);
	}
	//��ͨ�滻
	else
	{
		$repoldword=eaddslashes2($oldword);
		$repnewword=eaddslashes2($newword);
		if($over==1)//��ȫ�滻
		{
			if(empty($add2))
			{
				$and=" where ";
			}
			else
			{
				$and=" and ";
			}
			$add2.=$and.$field."='".$repoldword."'";
		}
		if($fr['tbdataf'])//����
		{
			//�����
			$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
			if($tbr['datatbs'])
			{
				$dtbr=explode(',',$tbr['datatbs']);
				$count=count($dtbr);
				for($i=1;$i<$count-1;$i++)
				{
					$empire->query("update {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
				}
			}
			//δ���
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check_data set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
		}
		else//����
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname." set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
			//δ���
			$empire->query("update {$dbtbpre}ecms_".$tbname."_check set ".$field."=REPLACE(".$field.",'$repoldword','$repnewword')".$add2);
		}
		//�滻���
		insert_dolog("tbname=".$tbname."&field=".$field."<br>oldword=".$oldword."<br>newword=".$newword);//������־
		printerror("DoRepNewstextSuccess","db/RepNewstext.php?tid=$tid".hReturnEcmsHashStrHref2(0));
	}
}

//�����滻��Ϣ
function DoRepNewstextZz($oldword,$newword,$text){
	$zztext=RepInfoZZ($oldword,"empire-cms-wm.chief-phome",0);
	$text=preg_replace($zztext,$newword,$text);
	return $text;
}

//��������滻�ֶα�
function EchoRepFieldForm($tid,$tbname,$over,$dozz,$dotxt,$newstart,$fieldform,$classid,$oldword,$newword){
	global $fun_r;
	$dotype=(int)$_POST['dotype'];
	?>
	<?=$fun_r['RepOneNewstextSuccess']?>(ID:<font color=red><b><?=$newstart?></b></font>)
	<form name="RepFieldForm" method="post" action="ecmscom.php">
		<?=hReturnEcmsHashStrForm(0)?>
		<input type=hidden name="enews" value="DoRepNewstext">
		<input type=hidden name="tid" value="<?=$tid?>">
		<input type=hidden name="tbname" value="<?=$tbname?>">
		<input type=hidden name="over" value="<?=$over?>">
		<input type=hidden name="dozz" value="<?=$dozz?>">
		<input type=hidden name="dotxt" value="<?=$dotxt?>">
		<input type=hidden name="dotype" value="<?=$dotype?>">
		<input type=hidden name="start" value="<?=$newstart?>">
		<?=$fieldform?>
		<input type=hidden name="classid" value="<?=$classid?>">
		<input type=hidden name="oldword" value="<?=ehtmlspecialchars($oldword)?>">
		<input type=hidden name="newword" value="<?=ehtmlspecialchars($newword)?>">
	</form>
	<script>
	document.RepFieldForm.submit();
	</script>
	<?
	exit();
}

//���������������Ϣ
function ReturnDoclassVar($ecms){
	global $dbtbpre;
	//��ǩģ�����
	if($ecms=="bqtemp")
	{
		$r['tbname']=$dbtbpre."enewsbqtempclass";
		$r['mess']="Bqtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/BqtempClass.php";
	}
	//�û��Զ���ҳ�����
	elseif($ecms=="page")
	{
		$r['tbname']=$dbtbpre."enewspageclass";
		$r['mess']="Page";
		$r['thelevel']="userpage";
		$r['returnpage']="template/PageClass.php";
	}
	//����ģ���������
	elseif($ecms=="tempvar")
	{
		$r['tbname']=$dbtbpre."enewstempvarclass";
		$r['mess']="Tempvar";
		$r['thelevel']="tempvar";
		$r['returnpage']="template/TempvarClass.php";
	}
	//�б�ģ�����
	elseif($ecms=="listtemp")
	{
		$r['tbname']=$dbtbpre."enewslisttempclass";
		$r['mess']="Listtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/ListtempClass.php";
	}
	//����ģ�����
	elseif($ecms=="newstemp")
	{
		$r['tbname']=$dbtbpre."enewsnewstempclass";
		$r['mess']="Newstemp";
		$r['thelevel']="template";
		$r['returnpage']="template/NewstempClass.php";
	}
	//����ģ�����
	elseif($ecms=="searchtemp")
	{
		$r['tbname']=$dbtbpre."enewssearchtempclass";
		$r['mess']="Searchtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/SearchtempClass.php";
	}
	//��ǩ����
	elseif($ecms=="bq")
	{
		$r['tbname']=$dbtbpre."enewsbqclass";
		$r['mess']="Bq";
		$r['thelevel']="bq";
		$r['returnpage']="template/BqClass.php";
	}
	//JSģ��
	elseif($ecms=="jstemp")
	{
		$r['tbname']=$dbtbpre."enewsjstempclass";
		$r['mess']="Jstemp";
		$r['thelevel']="template";
		$r['returnpage']="template/JsTempClass.php";
	}
	//ר��
	elseif($ecms=="zt")
	{
		$r['tbname']=$dbtbpre."enewsztclass";
		$r['mess']="Ztclass";
		$r['thelevel']="zt";
		$r['returnpage']="special/ListZtClass.php";
	}
	//��������
	elseif($ecms=="link")
	{
		$r['tbname']=$dbtbpre."enewslinkclass";
		$r['mess']="Linkclass";
		$r['thelevel']="link";
		$r['returnpage']="tool/LinkClass.php";
	}
	//��ҳģ��
	elseif($ecms=="classtemp")
	{
		$r['tbname']=$dbtbpre."enewsclasstempclass";
		$r['mess']="Classtemp";
		$r['thelevel']="template";
		$r['returnpage']="template/ClassTempClass.php";
	}
	//���󱨸�
	elseif($ecms=="error")
	{
		$r['tbname']=$dbtbpre."enewserrorclass";
		$r['mess']="Error";
		$r['thelevel']="downerror";
		$r['returnpage']="DownSys/ErrorClass.php";
	}
	//TAGS
	elseif($ecms=="tags")
	{
		$r['tbname']=$dbtbpre."enewstagsclass";
		$r['mess']="Tags";
		$r['thelevel']="tags";
		$r['returnpage']="tags/TagsClass.php";
	}
	//�û��Զ����б�
	elseif($ecms=="userlist")
	{
		$r['tbname']=$dbtbpre."enewsuserlistclass";
		$r['mess']="Userlist";
		$r['thelevel']="userlist";
		$r['returnpage']="other/UserlistClass.php";
	}
	//�û��Զ���JS
	elseif($ecms=="userjs")
	{
		$r['tbname']=$dbtbpre."enewsuserjsclass";
		$r['mess']="Userjs";
		$r['thelevel']="userjs";
		$r['returnpage']="other/UserjsClass.php";
	}
	else
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$r['returnpage'].=hReturnEcmsHashStrHref2(1);
	return $r;
}

//���ӷ���
function AddThisClass($add,$userid,$username){
	global $empire,$dbtbpre;
	//ȡ�÷�����Ϣ
	$thisr=ReturnDoclassVar($add['doing']);
	if(!$add['classname'])
	{
		printerror("Empty".$thisr['mess']."Classname","history.go(-1)");
    }
	//��֤Ȩ��
    CheckLevel($userid,$username,$classid,$thisr['thelevel']);
	$add['classname']=hRepPostStr($add['classname'],1);
	$sql=$empire->query("insert into ".$thisr['tbname']."(classname) values('$add[classname]');");
	if($sql)
	{
		$lastid=$empire->lastid();
		//������־
	    insert_dolog("classid=".$lastid."<br>classname=".$add[classname]);
		printerror("Add".$thisr['mess']."ClassSuccess",$thisr['returnpage']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸ķ���
function EditThisClass($add,$userid,$username){
	global $empire,$dbtbpre;
	//ȡ�÷�����Ϣ
	$thisr=ReturnDoclassVar($add['doing']);
	$classid=(int)$add['classid'];
	if(!$add['classname']||!$classid)
	{
		printerror("Empty".$thisr['mess']."Classname","history.go(-1)");
    }
	//��֤Ȩ��
    CheckLevel($userid,$username,$classid,$thisr['thelevel']);
	$add['classname']=hRepPostStr($add['classname'],1);
	$sql=$empire->query("update ".$thisr['tbname']." set classname='$add[classname]' where classid='$classid'");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$add[classname]);
		printerror("Edit".$thisr['mess']."ClassSuccess",$thisr['returnpage']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ������
function DelThisClass($classid,$doing,$userid,$username){
	global $empire,$dbtbpre;
	//ȡ�÷�����Ϣ
	$thisr=ReturnDoclassVar($doing);
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror("NotChange".$thisr['mess']."Classid","history.go(-1)");
    }
	//��֤Ȩ��
    CheckLevel($userid,$username,$classid,$thisr['thelevel']);
	$r=$empire->fetch1("select classname from ".$thisr['tbname']." where classid=$classid");
	$sql=$empire->query("delete from ".$thisr['tbname']." where classid=$classid");
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("Del".$thisr['mess']."ClassSuccess",$thisr['returnpage']);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�����滻��ַȨ��
function RepDownLevel($add,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"repdownpath");
	$tbname=RepPostVar($add['tbname']);
	if(!$tbname||!($add[downpath]||$add[onlinepath])||!($add[dogroup]||$add[dofen]||$add[doqz]||$add[dopath]||$add[doname]))
	{printerror("EmptyRepDownLevel","history.go(-1)");}
	$start=(int)$add['start'];
	//ת������
	if(empty($add[oldgroupid]))
	{
		$add[oldgroupid]=0;
	}
	if(empty($add[newgroupid]))
	{
		$add[newgroupid]=0;
	}
	if(empty($add[oldfen]))
	{
		$add[oldfen]=0;
	}
	if(empty($add[newfen]))
	{
		$add[newfen]=0;
	}
	if(empty($add[oldqz]))
	{
		$add[oldqz]=0;
	}
	if(empty($add[newqz]))
	{
		$add[newqz]=0;
	}
	//�ֶ�
	$field='';
	$sfield='';
	if($add['downpath'])
	{
		$field.=",downpath";
		$dh=",";
		$checkf='downpath';
	}
	if($add['onlinepath'])
	{
		$field.=",onlinepath";
		$checkf='onlinepath';
	}
	$fr=$empire->fetch1("select tid,savetxt,tbdataf from {$dbtbpre}enewsf where tbname='$tbname' and f='$checkf' limit 1");
	if($fr['tbdataf'])//����
	{
		$sfield=$field;
		$field='';
	}
	$wheresql="";
	//��Ŀ
	$classid=(int)$add['classid'];
	if($classid)
	{
		if(empty($class_r[$classid][islast]))//�м���Ŀ
		{
			$where=ReturnClass($class_r[$classid][sonclass]);
		}
		else//�ռ���Ŀ
		{
			$where="classid='$classid'";
		}
		$wheresql.=" and (".$where.")";
	}
	//����sql���
	$query=$add['query'];
	if($query)
	{
		//ȡ��adds
		$query=ClearAddsData($query);
		$wheresql.=" and (".$query.")";
	}
	$update="";
	$b=0;
	$sql=$empire->query("select id,stb".$field." from {$dbtbpre}ecms_".$tbname." where id>$start".$wheresql." order by id limit ".$public_r['dorepdlevelnum']);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[id];
		//����
		if($fr['tbdataf'])
		{
			$finfor=$empire->fetch1("select id".$sfield." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]'");
			$r['downpath']=$finfor['downpath'];
			$r['onlinepath']=$finfor['onlinepath'];
		}
		$update='';
		//���ص�ַ
		$newdownpath="";
		if($add[downpath])
		{
			$newdownpath=RepDownLevelStrip($r[downpath],$add);
			$update="downpath='".addslashes($newdownpath)."'";
		}
		//���ߵ�ַ
		$newonlinepath="";
		if($add[onlinepath])
		{
			$newonlinepath=RepDownLevelStrip($r[onlinepath],$add);
			$update.=$dh."onlinepath='".addslashes($newonlinepath)."'";
		}
		//����
		if($fr['tbdataf'])
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." set ".$update." where id='$r[id]'");
		}
		else
		{
			$empire->query("update {$dbtbpre}ecms_".$tbname." set ".$update." where id='$r[id]'");
		}
	}
	//�滻���
	if(empty($b))
	{
		//δ���
		$sql=$empire->query("select id,stb".$field." from {$dbtbpre}ecms_".$tbname."_check".($wheresql?' where '.substr($wheresql,5):''));
		while($r=$empire->fetch($sql))
		{
			//����
			if($fr['tbdataf'])
			{
				$finfor=$empire->fetch1("select id".$sfield." from {$dbtbpre}ecms_".$tbname."_check_data where id='$r[id]' limit 1");
				$r['downpath']=$finfor['downpath'];
				$r['onlinepath']=$finfor['onlinepath'];
			}
			$update='';
			//���ص�ַ
			$newdownpath="";
			if($add[downpath])
			{
				$newdownpath=RepDownLevelStrip($r[downpath],$add);
				$update="downpath='".addslashes($newdownpath)."'";
			}
			//���ߵ�ַ
			$newonlinepath="";
			if($add[onlinepath])
			{
				$newonlinepath=RepDownLevelStrip($r[onlinepath],$add);
				$update.=$dh."onlinepath='".addslashes($newonlinepath)."'";
			}
			//����
			if($fr['tbdataf'])
			{
				$empire->query("update {$dbtbpre}ecms_".$tbname."_check_data set ".$update." where id='$r[id]'");
			}
			else
			{
				$empire->query("update {$dbtbpre}ecms_".$tbname."_check set ".$update." where id='$r[id]'");
			}
		}
		//������־
	    insert_dolog("tbname=$tbname<br>downpath=$add[downpath]<br>onlinepath=$add[onlinepath]");
		printerror("RepDownLevelSuccess","DownSys/RepDownLevel.php".hReturnEcmsHashStrHref2(1));
	}
	EchoRepDownLevelForm($add,$newstart);
}

//�滻Ȩ�޴�����
function RepDownLevelStrip($downpath,$add){
	if(empty($downpath))
	{
		return "";
	}
	$add[oldpath]=ClearAddsData($add[oldpath]);
	$add[newpath]=ClearAddsData($add[newpath]);
	$add[oldname]=ClearAddsData($add[oldname]);
	$add[newname]=ClearAddsData($add[newname]);
	$f_exp="::::::";
	$r_exp="\r\n";
	$newdownpath="";
	$downpath=stripSlashes($downpath);
	$down_rr=explode($r_exp,$downpath);
	$count=count($down_rr);
	for($i=0;$i<$count;$i++)
	{
		$down_fr=explode($f_exp,$down_rr[$i]);
		//Ȩ���滻
		$d_groupid=(int)$down_fr[2];
		if($add[dogroup])
		{
			if($add[oldgroupid]=="no")//������
			{
				$d_groupid=$add[newgroupid];
			}
			else//����
			{
				if($d_groupid==$add[oldgroupid])
				{
					$d_groupid=$add[newgroupid];
				}
			}
		}
		//����ת��
		$d_fen=(int)$down_fr[3];
		if($add[dofen])
		{
			if($add[oldfen]=="no")//������
			{
				$d_fen=$add[newfen];
			}
			else//����
			{
				if($d_fen==$add[oldfen])
				{
					$d_fen=$add[newfen];
				}
			}
		}
		//ǰ׺ת��
		$d_qz=(int)$down_fr[4];
		if($add[doqz])
		{
			if($add[oldqz]=="no")//������
			{
				$d_qz=$add['newqz'];
			}
			else//����
			{
				if($d_qz==$add[oldqz])
				{
					$d_qz=$add[newqz];
				}
			}
		}
		//��ַ�滻
		$d_path=$down_fr[1];
		if($add[dopath]&&$add[oldpath])
		{
			$d_path=str_replace($add[oldpath],$add[newpath],$down_fr[1]);
		}
		//�����滻
		$d_name=$down_fr[0];
		if($add[doname]&&$add[oldname])
		{
			$d_name=str_replace($add[oldname],$add[newname],$down_fr[0]);
		}
		//���
		$newdownpath.=$d_name.$f_exp.$d_path.$f_exp.$d_groupid.$f_exp.$d_fen.$f_exp.$d_qz.$r_exp;
	}
	//ȥ�������ַ�
	$newdownpath=substr($newdownpath,0,strlen($newdownpath)-2);
	return $newdownpath;
}

//��������滻����Ȩ�ޱ�
function EchoRepDownLevelForm($add,$newstart){
	global $fun_r;
	?>
	<?=$fun_r['RepOneDLeveSuccess']?>(ID:<font color=red><b><?=$newstart?></b></font>)
	<form name="RepDownLevelForm" method="post" action="ecmscom.php">
		<?=hReturnEcmsHashStrForm(0)?>
		<input type=hidden name="enews" value="RepDownLevel">
		<input type=hidden name="start" value="<?=$newstart?>">
		<input type=hidden name="tbname" value="<?=$add['tbname']?>">
		<input type=hidden name="classid" value="<?=$add['classid']?>">
		<input type=hidden name="downpath" value="<?=$add['downpath']?>">
		<input type=hidden name="onlinepath" value="<?=$add['onlinepath']?>">
		<input type=hidden name="dogroup" value="<?=$add['dogroup']?>">
		<input type=hidden name="oldgroupid" value="<?=$add['oldgroupid']?>">
		<input type=hidden name="newgroupid" value="<?=$add['newgroupid']?>">
		<input type=hidden name="dofen" value="<?=$add['dofen']?>">
		<input type=hidden name="oldfen" value="<?=$add['oldfen']?>">
		<input type=hidden name="newfen" value="<?=$add['newfen']?>">
		<input type=hidden name="doqz" value="<?=$add['doqz']?>">
		<input type=hidden name="oldqz" value="<?=$add['oldqz']?>">
		<input type=hidden name="newqz" value="<?=$add['newqz']?>">
		<input type=hidden name="dopath" value="<?=$add['dopath']?>">
		<input type=hidden name="oldpath" value="<?=ehtmlspecialchars(ClearAddsData($add['oldpath']))?>">
		<input type=hidden name="newpath" value="<?=ehtmlspecialchars(ClearAddsData($add['newpath']))?>">
		<input type=hidden name="doname" value="<?=$add['doname']?>">
		<input type=hidden name="oldname" value="<?=ehtmlspecialchars(ClearAddsData($add['oldname']))?>">
		<input type=hidden name="newname" value="<?=ehtmlspecialchars(ClearAddsData($add['newname']))?>">
		<input type=hidden name="query" value="<?=ehtmlspecialchars(ClearAddsData($add['query']))?>">
	</form>
	<script>
	document.RepDownLevelForm.submit();
	</script>
	<?
	exit();
}

//�����ʱ�������ļ�
function ClearTmpFileData($add,$userid,$username){
	global $empire,$public_r,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"changedata");
	//��ʱ�ļ�Ŀ¼
	$tmppath=eReturnTrueEcmsPath().'e/data/tmp';
	$hand=@opendir($tmppath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.html'||$file=='mod'||$file=='temp'||$file=='titlepic'||$file=='cj')
		{
			continue;
		}
		$filename=$tmppath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//��ʱģ�嵼��Ŀ¼
	$temppath=eReturnTrueEcmsPath().'e/data/tmp/temp';
	$hand=@opendir($temppath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.php')
		{
			continue;
		}
		$filename=$temppath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//��ʱģ�͵���Ŀ¼
	$modpath=eReturnTrueEcmsPath().'e/data/tmp/mod';
	$hand=@opendir($modpath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.php')
		{
			continue;
		}
		$filename=$modpath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//��ʱ�ɼ�����Ŀ¼
	$cjpath=eReturnTrueEcmsPath().'e/data/tmp/cj';
	$hand=@opendir($cjpath);
	while($file=@readdir($hand))
	{
		if($file=='.'||$file=='..'||$file=='test.txt'||$file=='index.html')
		{
			continue;
		}
		$filename=$cjpath.'/'.$file;
		if(!is_dir($filename))
		{
			DelFiletext($filename);
		}
	}
	//�ɼ���ʱ��
	$empire->query("TRUNCATE `{$dbtbpre}enewslinktmp`;");
	//Զ�̷�����ʱ��
	$empire->query("TRUNCATE `{$dbtbpre}enewspostdata`;");
	printerror('ClearTmpFileDataSuccess','');
}

//���������Ϣ
function ClearBreakInfo($add,$userid,$username){
	global $empire,$dbtbpre;
	CheckLevel($userid,$username,$classid,"changedata");//��֤Ȩ��
	$tid=(int)$add['tid'];
	if(!$tid)
	{
		printerror('EmptyDocTb','');
	}
	$tbr=$empire->fetch1("select datatbs,tbname from {$dbtbpre}enewstable where tid='$tid'");
	if(!$tbr['tbname'])
	{
		printerror('EmptyDocTb','');
	}
	$affnum=0;
	if($tbr['datatbs'])
	{
		$dtbr=explode(',',$tbr['datatbs']);
		$count=count($dtbr);
		$dodatatbs='';
		$andunion='';
		for($i=1;$i<$count-1;$i++)
		{
			$dodatatbs.=$andunion."select id from {$dbtbpre}ecms_".$tbr['tbname']."_data_".$dtbr[$i];
			$andunion=' union ';
		}
		if($dodatatbs)
		{
			$empire->query("delete from {$dbtbpre}ecms_".$tbr['tbname']." where id not in (".$dodatatbs.")");
			$affnum=$empire->affectnum();
		}
	}
	$GLOBALS['cbinfoaffnum']=$affnum;
	//������־
	insert_dolog("tid=".$tid."<br>tbname=".$tbr['tbname']);
	printerror("ClearBreakInfoSuccess","");
}

//������Ϣ��������ͳ��
function ResetAddDataNum($type,$from,$userid,$username){
	global $empire,$dbtbpre;
	if($type=='info')
	{
		//CheckLevel($userid,$username,$classid,"info");//��֤Ȩ��
	}
	elseif($type=='pl')
	{
		//CheckLevel($userid,$username,$classid,"pl");//��֤Ȩ��
	}
	else
	{
		printerror("ErrorUrl","");
	}
	CheckLevel($userid,$username,$classid,"changedata");//��֤Ȩ��
	DoResetAddDataNum($type);
	$returnurl=$from?$from:EcmsGetReturnUrl();
	//������־
	insert_dolog("type=".$type);
	printerror("ResetAddDataNumSuccess",$returnurl);
}
?>