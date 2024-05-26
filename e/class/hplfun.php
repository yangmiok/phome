<?php
//************************************ �������ò��� ************************************

function SetPl($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"public");
	$add['pltime']=(int)$add['pltime'];
	$add['plsize']=(int)$add['plsize'];
	$add['plincludesize']=(int)$add['plincludesize'];
	$add['plkey_ok']=(int)$add['plkey_ok'];
	$add['plfacenum']=(int)$add['plfacenum'];
	$add['plgroupid']=(int)$add['plgroupid'];
	$add['pl_num']=(int)$add['pl_num'];
	$add['plmaxfloor']=(int)$add['plmaxfloor'];
	$add['plurl']=hRepPostStr($add['plurl'],1);
	$sql=$empire->query("update {$dbtbpre}enewspl_set set pltime='$add[pltime]',plsize='$add[plsize]',plincludesize='$add[plincludesize]',plkey_ok='$add[plkey_ok]',plfacenum='$add[plfacenum]',plgroupid='$add[plgroupid]',plclosewords='".eaddslashes($add[plclosewords])."',pl_num='$add[pl_num]',plurl='$add[plurl]',plmaxfloor='$add[plmaxfloor]',plquotetemp='".eaddslashes2($add[plquotetemp])."' limit 1");
	GetConfig();//���»���
	if($sql)
	{
		insert_dolog("");//������־
		printerror('SetPlSuccess','pl/SetPl.php'.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror('DbError','history.go(-1)');
	}
}


//************************************ ���� ************************************

//����ɾ������
function DelPl_all($plid,$id,$bclassid,$classid,$userid,$username){
	global $empire,$class_r,$dbtbpre,$public_r;
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"news");
	$restb=(int)$_POST['restb'];
	$count=count($plid);
	if(empty($count)||!$restb)
	{
		printerror("NotDelPlid","history.go(-1)");
	}
	if(!strstr($public_r['pldatatbs'],','.$restb.','))
	{
		printerror("NotDelPlid","history.go(-1)");
	}
	$add='';
	for($i=0;$i<$count;$i++)
	{
		$add.="plid='".intval($plid[$i])."' or ";
	}
	$add=substr($add,0,strlen($add)-4);
	//�������ݱ�
	$fsql=$empire->query("select id,classid,plid,pubid from {$dbtbpre}enewspl_{$restb} where ".$add);
	while($r=$empire->fetch($fsql))
	{
		if($class_r[$r[classid]][tbname]&&$r['pubid']>0)
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$r[classid]][tbname]."_index where id='$r[id]' limit 1");
			//���ر�
			$infotb=ReturnInfoMainTbname($class_r[$r[classid]][tbname],$index_r['checked']);
			$empire->query("update ".$infotb." set plnum=plnum-1 where id='$r[id]'");
		}
    }
	$sql=$empire->query("delete from {$dbtbpre}enewspl_{$restb} where ".$add);
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
		printerror("DelPlSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�����������
function CheckPl_all($plid,$id,$bclassid,$classid,$userid,$username){
	global $empire,$class_r,$dbtbpre,$public_r;
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"news");
	$restb=(int)$_POST['restb'];
	$count=count($plid);
	if(empty($count)||!$restb)
	{
		printerror("NotCheckPlid","history.go(-1)");
	}
	if(!strstr($public_r['pldatatbs'],','.$restb.','))
	{
		printerror("NotCheckPlid","history.go(-1)");
	}
	$add='';
	$docheck=(int)$_POST['docheck'];
	$docheck=$docheck?1:0;
	for($i=0;$i<$count;$i++)
	{
		$add.="plid='".intval($plid[$i])."' or ";
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update {$dbtbpre}enewspl_{$restb} set checked='$docheck' where ".$add);
	if($sql)
	{
		//������־
		insert_dolog("docheck=$docheck<br>classid=".$classid."<br>classname=".$class_r[$classid][classname]);
		printerror("CheckPlSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�����Ƽ�/ȡ������
function DoGoodPl_all($plid,$id,$bclassid,$classid,$isgood,$userid,$username){
	global $empire,$class_r,$dbtbpre,$public_r;
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"news");
	$restb=(int)$_POST['restb'];
	$count=count($plid);
	if(empty($count)||!$restb)
	{
		printerror("NotGoodPlid","history.go(-1)");
	}
	if(!strstr($public_r['pldatatbs'],','.$restb.','))
	{
		printerror("NotGoodPlid","history.go(-1)");
	}
	$add='';
	$isgood=(int)$isgood;
	for($i=0;$i<$count;$i++)
	{
		$add.="plid='".intval($plid[$i])."' or ";
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update {$dbtbpre}enewspl_{$restb} set isgood='$isgood' where ".$add);
	if($sql)
	{
		//������־
		insert_dolog("isgood=$isgood<br>classid=".$classid."<br>classname=".$class_r[$classid][classname]);
		printerror("DoGoodPlSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//����������Ϣ������
function UpdateAllInfoPlnum($add,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"changedata");
	$start=(int)$add['start'];
	$tbname=RepPostVar($add['tbname']);
	$from=$add['from'];
	if(empty($tbname)||!eCheckTbname($tbname))
	{
		printerror("ErrorUrl","history.go(-1)");
    }
	//����Ŀˢ��
	$classid=(int)$add['classid'];
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
	$retype=(int)$add['retype'];
	if($retype)
	{
		$startid=(int)$add['startid'];
		$endid=(int)$add['endid'];
		if($endid)
		{
			$add1.=" and id>=$startid and id<=$endid";
	    }
    }
	else
	{
		$startday=RepPostVar($add['startday']);
		$endday=RepPostVar($add['endday']);
		if($startday&&$endday)
		{
			$add1.=" and truetime>=".to_time($startday." 00:00:00")." and truetime<=".to_time($endday." 23:59:59");
	    }
    }
	//ָ��ID
	$doids=trim($add['doids']);
	$whereid='';
	if($doids)
	{
		$doidr=explode(',',$doids);
		$doidcount=count($doidr);
		$wheredh='';
		for($doi=0;$doi<$doidcount;$doi++)
		{
			$whereid.=$wheredh.intval($doidr[$doi]);
			$wheredh=',';
		}
		$add1.=' and id in ('.$whereid.')';
	}
	$b=0;
	$sql=$empire->query("select id,classid,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start".$add1." order by id limit ".$public_r[infolinknum]);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['id'];
		//����Ϣ������
		UpdateSingleInfoPlnum($r['classid'],$r['id'],$r['checked']);
	}
	if(empty($b))
	{
	    insert_dolog("");//������־
		printerror("UpdateInfoPlnumSuccess",$from);
	}
	echo $fun_r[OneUpdateInfoPlnumSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmspl.php?enews=UpdateAllInfoPlnum&tbname=$tbname&classid=$classid&start=$new_start&from=".urlencode($from)."&retype=$retype&startday=$startday&endday=$endday&startid=$startid&endid=$endid&doids=$whereid".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}


//************************************ �����ֶι��� ************************************

//��֤�ֶ��Ƿ��ظ�
function CheckRePlF($add,$ecms=0){
	global $empire,$dbtbpre;
	//�޸�
	if($ecms==1&&$add[f]==$add[oldf])
	{
		return '';
	}
	//����
	$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}enewspl_1");
	$b=0;
	while($r=$empire->fetch($s))
	{
		if($r[Field]==$add[f])
		{
			$b=1;
			break;
		}
    }
	if($b)
	{
		printerror("ReF","history.go(-1)");
	}
}

//�����ֶ�����
function ReturnPlFtype($add){
	//�ֶ�����
	if($add[ftype]=="TINYINT"||$add[ftype]=="SMALLINT"||$add[ftype]=="INT"||$add[ftype]=="BIGINT"||$add[ftype]=="FLOAT"||$add[ftype]=="DOUBLE")
	{
		$def=" default '0'";
	}
	elseif($add[ftype]=="VARCHAR")
	{
		$def=" default ''";
	}
	else
	{
		$def="";
	}
	$type=$add[ftype];
	//VARCHAR
	if($add[ftype]=='VARCHAR'&&empty($add[flen]))
	{
		$add[flen]='255';
	}
	//�ֶγ���
	if($add[flen])
	{
		if($add[ftype]!="TEXT"&&$add[ftype]!="MEDIUMTEXT"&&$add[ftype]!="LONGTEXT")
		{
			$type.="(".$add[flen].")";
		}
	}
	$field="`".$add[f]."` ".$type." NOT NULL".$def;
	return $field;
}

//���������ֶ�
function AddPlF($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[f]=RepPostVar($add[f]);
	if(empty($add[f])||empty($add[fname]))
	{
		printerror("EmptyF","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"plf");
	$add['fname']=hRepPostStr($add['fname'],1);
	$add['fzs']=hRepPostStr($add['fzs'],1);
	$add['ftype']=hRepPostStr($add['ftype'],1);
	$add['flen']=hRepPostStr($add['flen'],1);
	//��֤�ֶ��ظ�
	CheckRePlF($add,0);
	//�ֶ�����
	$field=ReturnPlFtype($add);
	//�����ֶ�
	$tbr=$empire->fetch1("select pldatatbs from {$dbtbpre}enewspl_set limit 1");
	if($tbr['pldatatbs'])
	{
		$dtbr=explode(',',$tbr['pldatatbs']);
		$count=count($dtbr);
		for($i=1;$i<$count-1;$i++)
		{
			$empire->query("alter table {$dbtbpre}enewspl_".$dtbr[$i]." add ".$field);
		}
	}
	//�������
	$add[ismust]=(int)$add[ismust];
	$sql=$empire->query("insert into {$dbtbpre}enewsplf(f,fname,fzs,ftype,flen,ismust) values('$add[f]','$add[fname]','".addslashes($add[fzs])."','$add[ftype]','$add[flen]','$add[ismust]');");
	$lastid=$empire->lastid();
	UpdatePlF();//�����ֶ�
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("fid=".$lastid."<br>f=".$add[f]);
		printerror("AddFSuccess","pl/AddPlF.php?enews=AddPlF".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸������ֶ�
function EditPlF($add,$userid,$username){
	global $empire,$dbtbpre;
	$fid=(int)$add['fid'];
	$add[f]=RepPostVar($add[f]);
	$add[oldf]=RepPostVar($add[oldf]);
	if(empty($add[f])||empty($add[fname])||!$fid)
	{
		printerror("EmptyF","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"plf");
	$add['fname']=hRepPostStr($add['fname'],1);
	$add['fzs']=hRepPostStr($add['fzs'],1);
	$add['ftype']=hRepPostStr($add['ftype'],1);
	$add['flen']=hRepPostStr($add['flen'],1);
	//��֤�ֶ��ظ�
	CheckRePlF($add,1);
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsplf where fid='$fid'");
	//�ı��ֶ�
	if($cr[f]<>$add[f]||$cr[ftype]<>$add[ftype]||$cr[flen]<>$add[flen])
	{
		$field=ReturnPlFtype($add);//�ֶ�����
		$tbr=$empire->fetch1("select pldatatbs from {$dbtbpre}enewspl_set limit 1");
		if($tbr['pldatatbs'])
		{
			$dtbr=explode(',',$tbr['pldatatbs']);
			$count=count($dtbr);
			for($i=1;$i<$count-1;$i++)
			{
				$empire->query("alter table {$dbtbpre}enewspl_".$dtbr[$i]." change `".$cr[f]."` ".$field);
			}
		}
	}
	//�������
	$add[ismust]=(int)$add[ismust];
	$sql=$empire->query("update {$dbtbpre}enewsplf set f='$add[f]',fname='$add[fname]',fzs='".addslashes($add[fzs])."',ftype='$add[ftype]',flen='$add[flen]',ismust='$add[ismust]' where fid=$fid");
	UpdatePlF();//�����ֶ�
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("fid=".$fid."<br>f=".$add[f]);
		printerror("EditFSuccess","pl/ListPlF.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ�������ֶ�
function DelPlF($add,$userid,$username){
	global $empire,$dbtbpre;
	$fid=(int)$add['fid'];
	if(empty($fid))
	{
		printerror("EmptyFid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"plf");
	$r=$empire->fetch1("select f from {$dbtbpre}enewsplf where fid=$fid");
	if(!$r[f])
	{
		printerror("EmptyFid","history.go(-1)");
	}
	if($r[f]=="saytext")
	{
		printerror("NotIsAdd","history.go(-1)");
	}
	//ɾ���ֶ�
	$tbr=$empire->fetch1("select pldatatbs from {$dbtbpre}enewspl_set limit 1");
	if($tbr['pldatatbs'])
	{
		$dtbr=explode(',',$tbr['pldatatbs']);
		$count=count($dtbr);
		for($i=1;$i<$count-1;$i++)
		{
			$empire->query("alter table {$dbtbpre}enewspl_".$dtbr[$i]." drop COLUMN `".$r[f]."`");
		}
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsplf where fid=$fid");
	UpdatePlF();//�����ֶ�
	GetConfig();//���»���
	if($sql)
	{
		//������־
		insert_dolog("fid=".$fid."<br>f=".$r[f]);
		printerror("DelFSuccess","pl/ListPlF.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//���������ֶ�
function UpdatePlF(){
	global $empire,$dbtbpre;
	$plf=',';
	$plmustf=',';
	$sql=$empire->query("select f,ismust from {$dbtbpre}enewsplf");
	while($r=$empire->fetch($sql))
	{
		$plf.=$r[f].',';
		if($r[ismust])
		{
			$plmustf.=$r[f].',';
		}
	}
	$empire->query("update {$dbtbpre}enewspl_set set plf='$plf',plmustf='$plmustf' limit 1");
}


//************************************ ���۷ֱ���� ************************************

//�������۷ֱ�
function AddPlDataTable($add,$userid,$username){
	echo'This is the Free Version of EmpireCMS.';
	exit();
}

//Ĭ�����۴�ű�
function DefPlDataTable($add,$userid,$username){
	echo'This is the Free Version of EmpireCMS.';
	exit();
}

//ɾ�����۷ֱ�
function DelPlDataTable($add,$userid,$username){
	echo'This is the Free Version of EmpireCMS.';
	exit();
}
?>