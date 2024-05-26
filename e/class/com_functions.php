<?php
//�������Է���
function AddGbookClass($add,$do=0,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[bname]))
	{
		printerror("EmptyGbookClass","history.go(-1)");
    }
	if(empty($do))
	{
		$add['checked']=(int)$add['checked'];
		$add['groupid']=(int)$add['groupid'];
		$level="gbook";
		$table="{$dbtbpre}enewsgbookclass";
		$location="GbookClass.php".hReturnEcmsHashStrHref2(1);
		$mychecked=",checked,groupid";
		$mycheckedvalue=",".$add['checked'].",".$add['groupid'];
	}
	else
	{
		$level="feedback";
		$table="{$dbtbpre}enewsfeedbackclass";
		$location="FeedbackClass.php".hReturnEcmsHashStrHref2(1);
		$mychecked="";
		$mycheckedvalue="";
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,$level);
	$add['bname']=hRepPostStr($add['bname'],1);
	$sql=$empire->query("insert into ".$table."(bname".$mychecked.") values('$add[bname]'".$mycheckedvalue.");");
	if($sql)
	{
		$bid=$empire->lastid();
		//������־
		insert_dolog("bid=".$bid."<br>bname=".$add[bname]);
		printerror("AddGbookClassSuccess",$location);
    }
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸����Է���
function EditGbookClass($add,$do=0,$userid,$username){
	global $empire,$dbtbpre;
	$add[bid]=(int)$add[bid];
	if(empty($add[bname])||!$add[bid])
	{
		printerror("EmptyGbookClass","history.go(-1)");
    }
	if(empty($do))
	{
		$add['checked']=(int)$add['checked'];
		$add['groupid']=(int)$add['groupid'];
		$level="gbook";
		$table="{$dbtbpre}enewsgbookclass";
		$location="GbookClass.php".hReturnEcmsHashStrHref2(1);
		$mychecked=",checked=".$add['checked'].",groupid=".$add['groupid'];
	}
	else
	{
		$level="feedback";
		$table="{$dbtbpre}enewsfeedbackclass";
		$location="FeedbackClass.php".hReturnEcmsHashStrHref2(1);
		$mychecked="";
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,$level);
	$add['bname']=hRepPostStr($add['bname'],1);
	$sql=$empire->query("update ".$table." set bname='$add[bname]'".$mychecked." where bid='$add[bid]';");
	if($sql)
	{
		//������־
		insert_dolog("bid=".$add[bid]."<br>bname=".$add[bname]);
		printerror("EditGbookClassSuccess",$location);
    }
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ�����Է���
function DelGbookClass($bid,$do=0,$userid,$username){
	global $empire,$dbtbpre;
	$bid=(int)$bid;
	if(!$bid)
	{
		printerror("NotChangeGbookClassid","history.go(-1)");
    }
	if(empty($do))
	{
		$level="gbook";
		$table="{$dbtbpre}enewsgbookclass";
		$tabledata="{$dbtbpre}enewsgbook";
		$location="GbookClass.php".hReturnEcmsHashStrHref2(1);
	}
	else
	{
		$level="feedback";
		$table="{$dbtbpre}enewsfeedbackclass";
		$tabledata="{$dbtbpre}enewsfeedback";
		$location="FeedbackClass.php".hReturnEcmsHashStrHref2(1);
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,$level);
	$r=$empire->fetch1("select bname from ".$table." where bid='$bid';");
	$sql=$empire->query("delete from ".$table." where bid='$bid';");
	$sql1=$empire->query("delete from ".$tabledata." where bid='$bid';");
	if($sql)
	{
		//������־
		insert_dolog("bid=".$bid."<br>bname=".$r[bname]);
		printerror("DelGbookClassSuccess",$location);
    }
	else
	{printerror("DbError","history.go(-1)");}
}

//---------��������/��������
function ReturnGbookClass($bid,$do=0){
	global $empire,$dbtbpre;
	$bid=(int)$bid;
	if(empty($do))
	{
		$table="{$dbtbpre}enewsgbookclass";
	}
	else
	{
		$table="{$dbtbpre}enewsfeedbackclass";
	}
	$sql=$empire->query("select bid,bname from ".$table." order by bid");
	while($r=$empire->fetch($sql))
	{
		if($bid==$r[bid])
		{$selected=" selected";}
		else
		{$selected="";}
		$select.="<option value=".$r[bid].$selected.">".$r[bname]."</option>";
	}
	return $select;
}

//�ظ����԰�
function ReGbook($lyid,$retext,$bid,$userid,$username){
	global $empire,$dbtbpre;
	$lyid=(int)$lyid;
	$bid=(int)$bid;
	if(!$lyid||!$retext)
	{
		printerror("EmptyReGbooktext","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"gbook");
	$retext=hRepPostStr2($retext);
	$sql=$empire->query("update {$dbtbpre}enewsgbook set retext='$retext' where lyid='$lyid';");
	if($sql)
	{
		//������־
		insert_dolog("lyid=".$lyid);
		echo"<script>opener.parent.main.location.href='gbook.php?bid=$bid".hReturnEcmsHashStrHref2(0)."';window.close();</script>";
		exit();
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ������
function DelGbook($lyid,$bid,$userid,$username){
	global $empire,$dbtbpre;
	$lyid=(int)$lyid;
	$bid=(int)$bid;
	if(!$lyid)
	{
		printerror("NotChangeLyid","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"gbook");
	$sql=$empire->query("delete from {$dbtbpre}enewsgbook where lyid='$lyid';");
	if($sql)
	{
		//������־
		insert_dolog("lyid=".$lyid);
		printerror("DelGbookSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//--------------------------����ɾ������(3.6)
function DelGbook_all($lyid,$bid,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"gbook");
	$bid=(int)$bid;
	$count=count($lyid);
	if(empty($count))
	{printerror("NotChangeLyid","history.go(-1)");}
	for($i=0;$i<$count;$i++)
	{
		$lyid[$i]=(int)$lyid[$i];
		$add.="lyid='$lyid[$i]' or ";
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("delete from {$dbtbpre}enewsgbook where ".$add);
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("DelGbookSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//--------------------------�����������(3.6)
function CheckGbook_all($lyid,$bid,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"gbook");
	$bid=(int)$bid;
	$count=count($lyid);
	if(empty($count))
	{printerror("NotChangeCheckLyid","history.go(-1)");}
	for($i=0;$i<$count;$i++)
	{
		$lyid[$i]=(int)$lyid[$i];
		$add.="lyid='$lyid[$i]' or ";
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update {$dbtbpre}enewsgbook set checked=0 where ".$add);
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("CheckLysuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����������
function DelFeedbackFile($filename,$filepath){
	global $empire,$dbtbpre,$public_r,$efileftp_dr;
	if($filename)
	{
		$fpath=0;
		$getfpath=0;
		$addfilepath=$filepath?$filepath.'/':'';
		$filer=explode(",",$filename);
		$fcount=count($filer);
		for($j=0;$j<$fcount;$j++)
		{
			if(!$getfpath)
			{
				$ftr=$empire->fetch1("select fpath from {$dbtbpre}enewsfile_other where modtype=4 and path='$filepath' and filename='".$filer[$j]."' limit 1");
				$fpath=$ftr[fpath];
				$getfpath=1;
			}
			$fspath=ReturnFileSavePath(0,$fpath);
			$delfile=eReturnEcmsMainPortPath().$fspath['filepath'].$addfilepath.$filer[$j];//moreport
			DelFiletext($delfile);
			$where.=$or."filename='".$filer[$j]."'";
			$or=" or ";
			//FileServer
			if($public_r['openfileserver'])
			{
				$efileftp_dr[]=$delfile;
			}
		}
		$delsql=$empire->query("delete from {$dbtbpre}enewsfile_other where modtype=4 and path='$filepath' and (".$where.")");
	}
}

//ɾ��������Ϣ
function DelFeedback($id,$bid,$userid,$username){
	global $empire,$dbtbpre;
	$id=(int)$id;
	$bid=(int)$bid;
	if(!$id)
	{
		printerror("NotChangeFeedbackid","history.go(-1)");
    }
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedback");
	$r=$empire->fetch1("select id,title,filepath,filename,bid from {$dbtbpre}enewsfeedback where id='$id';");
	if(!$r['id'])
	{
		printerror("NotChangeFeedbackid","history.go(-1)");
    }
	//����Ȩ��
	$bidr=ReturnAdminFeedbackClass($r['bid'],$userid,$username);
	$sql=$empire->query("delete from {$dbtbpre}enewsfeedback where id='$id';");
	//ɾ������
	DelFeedbackFile($r['filename'],$r['filepath']);
	if($sql)
	{
		//������־
		insert_dolog("id=".$id."<br>title=$r[title]");
		printerror("DelFeedbackSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//����ɾ��������Ϣ
function DelFeedback_all($id,$bid,$userid,$username){
	global $empire,$dbtbpre;
	$bid=(int)$bid;
	$count=count($id);
	if(!$count)
	{
		printerror("NotChangeFeedbackid","history.go(-1)");
    }
	//����Ȩ��
	$bidr=ReturnAdminFeedbackClass(0,$userid,$username);
	$dh='';
	$inid='';
	for($i=0;$i<$count;$i++)
	{
		$id[$i]=(int)$id[$i];
		//ɾ������
		$r=$empire->fetch1("select id,filepath,filename,bid from {$dbtbpre}enewsfeedback where id='".$id[$i]."';");
		if(!strstr(','.$bidr['bids'].',',','.$r['bid'].','))
		{
			continue;
		}
		DelFeedbackFile($r['filename'],$r['filepath']);
		$inid.=$dh.$id[$i];
		$dh=",";
	}
	if($inid)
	{
		$sql=$empire->query("delete from {$dbtbpre}enewsfeedback where id in (".$inid.");");
	}
	if($sql)
	{
		//������־
		insert_dolog("");
		printerror("DelFeedbackSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�����ֶ�ֵ
function ReturnFBFvalue($value){
	$value=str_replace("\r\n","|",$value);
	return $value;
}

//���ӷ����ֶ�
function AddFeedbackF($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[f]=RepPostVar($add[f]);
	if(empty($add[f])||empty($add[fname]))
	{printerror("EmptyF","history.go(-1)");}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedbackf");
	//�ֶ��Ƿ��ظ�
	$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}enewsfeedback");
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
	{printerror("ReF","history.go(-1)");}
	$add[fvalue]=ReturnFBFvalue($add[fvalue]);//��ʼ��ֵ
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
	//�����ֶ�
	$asql=$empire->query("alter table {$dbtbpre}enewsfeedback add ".$field);
	//�������
	$add[myorder]=(int)$add[myorder];
	$sql=$empire->query("insert into {$dbtbpre}enewsfeedbackf(f,fname,fform,fzs,myorder,ftype,flen,fformsize,fvalue) values('$add[f]','$add[fname]','$add[fform]','".eaddslashes($add[fzs])."',$add[myorder],'$add[ftype]','$add[flen]','$add[fformsize]','".eaddslashes2($add[fvalue])."');");
	$lastid=$empire->lastid();
	if($asql&&$sql)
	{
		//������־
		insert_dolog("fid=".$lastid."<br>f=".$add[f]);
		printerror("AddFSuccess","AddFeedbackF.php?enews=AddFeedbackF".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸ķ����ֶ�
function EditFeedbackF($add,$userid,$username){
	global $empire,$dbtbpre;
	$fid=(int)$add['fid'];
	$add[f]=RepPostVar($add[f]);
	$add[oldf]=RepPostVar($add[oldf]);
	if(empty($add[f])||empty($add[fname])||!$fid)
	{printerror("EmptyF","history.go(-1)");}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedbackf");
	if($add[f]<>$add[oldf])
	{
		//�ֶ��Ƿ��ظ�
		$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}enewsfeedback");
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
		{printerror("ReF","history.go(-1)");}
	}
	$add[fvalue]=ReturnFBFvalue($add[fvalue]);//��ʼ��ֵ
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
	$usql=$empire->query("alter table {$dbtbpre}enewsfeedback change `".$add[oldf]."` ".$field);
	//�������
	$add[myorder]=(int)$add[myorder];
	$sql=$empire->query("update {$dbtbpre}enewsfeedbackf set f='$add[f]',fname='$add[fname]',fform='$add[fform]',fzs='".eaddslashes($add[fzs])."',myorder=$add[myorder],ftype='$add[ftype]',flen='$add[flen]',fformsize='$add[fformsize]',fvalue='".eaddslashes2($add[fvalue])."' where fid=$fid");
	//�ֶ�������
	if($add[f]<>$add[oldf])
	{
		$record="<!--record-->";
		$field="<!--field--->";
		$like=$field.$add[oldf].$record;
		$newlike=$field.$add[f].$record;
		$slike=",".$add[oldf].",";
		$newslike=",".$add[f].",";
		$csql=$empire->query("select bid,enter,mustenter,filef,checkboxf from {$dbtbpre}enewsfeedbackclass where enter like '%$like%'");
		while($cr=$empire->fetch($csql))
		{
			$setf="";
			if(strstr($cr['mustenter'],$slike))
			{
				$setf.=",mustenter=REPLACE(mustenter,'$slike','$newslike')";
			}
			if(strstr($cr['filef'],$slike))
			{
				$setf.=",filef=REPLACE(filef,'$slike','$newslike')";
			}
			if(strstr($cr['checkboxf'],$slike))
			{
				$setf.=",checkboxf=REPLACE(checkboxf,'$slike','$newslike')";
			}
			$cusql=$empire->query("update {$dbtbpre}enewsfeedbackclass set enter=REPLACE(enter,'$like','$newlike')".$setf." where bid='$cr[bid]'");
		}
	}
	if($usql&&$sql)
	{
		//������־
		insert_dolog("fid=".$fid."<br>f=".$add[f]);
		printerror("EditFSuccess","ListFeedbackF.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ�������ֶ�
function DelFeedbackF($add,$userid,$username){
	global $empire,$dbtbpre;
	$fid=(int)$add['fid'];
	if(empty($fid))
	{printerror("EmptyFid","history.go(-1)");}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedbackf");
	$r=$empire->fetch1("select f from {$dbtbpre}enewsfeedbackf where fid=$fid");
	if(!$r[f])
	{
		printerror("EmptyFid","history.go(-1)");
	}
	if($r[f]=="title")
	{
		printerror("NotIsAdd","history.go(-1)");
	}
	$usql=$empire->query("alter table {$dbtbpre}enewsfeedback drop COLUMN `".$r[f]."`");
	$sql=$empire->query("delete from {$dbtbpre}enewsfeedbackf where fid=$fid");
	//���·����
	$record="<!--record-->";
	$field="<!--field--->";
	$like=$field.$r[f].$record;
	$slike=",".$r[f].",";
	$csql=$empire->query("select bid,enter,mustenter,filef,checkboxf from {$dbtbpre}enewsfeedbackclass where enter like '%$like%'");
	while($cr=$empire->fetch($csql))
	{
		$setf="";
		if(strstr($cr['mustenter'],$slike))
		{
			$setf.=",mustenter=REPLACE(mustenter,'$slike',',')";
		}
		if(strstr($cr['filef'],$slike))
		{
			$setf.=",filef=REPLACE(filef,'$slike',',')";
		}
		if(strstr($cr['checkboxf'],$slike))
		{
			$setf.=",checkboxf=REPLACE(checkboxf,'$slike',',')";
		}
		//¼����
		$enter="";
		$re1=explode($record,$cr[enter]);
		for($i=0;$i<count($re1)-1;$i++)
		{
			if(strstr($re1[$i].$record,$like))
			{continue;}
			$enter.=$re1[$i].$record;
		}
		$cusql=$empire->query("update {$dbtbpre}enewsfeedbackclass set enter='$enter'".$setf." where bid='$cr[bid]'");
	}
	if($usql&&$sql)
	{
		//������־
		insert_dolog("fid=".$fid."<br>f=".$r[f]);
		printerror("DelFSuccess","ListFeedbackF.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸ķ����ֶ�˳��
function EditFeedbackFOrder($fid,$myorder,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedbackf");
	for($i=0;$i<count($myorder);$i++)
	{
		$newmyorder=(int)$myorder[$i];
		$fid[$i]=(int)$fid[$i];
		$usql=$empire->query("update {$dbtbpre}enewsfeedbackf set myorder=$newmyorder where fid='$fid[$i]'");
    }
	printerror("EditFOrderSuccess","ListFeedbackF.php".hReturnEcmsHashStrHref2(1));
}

//������Ȩ�޵ķ�������
function ReturnAdminFeedbackClass($bid,$userid,$username){
	global $empire,$dbtbpre;
	$bids='';
	$dh='';
	$select='';
	$no=0;
	$sql=$empire->query("select bid,bname from {$dbtbpre}enewsfeedbackclass where usernames='' or usernames like '%,".$username.",%'");
	while($r=$empire->fetch($sql))
	{
		$no++;
		$bids.=$dh.$r['bid'];
		$dh=',';
		if($bid==$r['bid'])
		{$selected=' selected';}
		else
		{$selected='';}
		$select.='<option value='.$r['bid'].$selected.'>'.$r['bname'].'</option>';
	}
	if(!$bids)
	{
		printerror('NotLevel','history.go(-1)');
	}
	if($bid&&!strstr(','.$bids.',',','.$bid.','))
	{
		printerror('NotLevel','history.go(-1)');
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsfeedbackclass");
	$ret_r['allbid']=0;
	if($num==$no)
	{
		$ret_r['allbid']=1;
	}
	$ret_r['bids']=$bids;
	$ret_r['selects']=$select;
	return $ret_r;
}

//ȡ��select/radioԪ�ش���
function GetBFFformSelect($type,$f,$fvalue,$fformsize=''){
	$vr=explode("|",$fvalue);
	$count=count($vr);
	$change="";
	$def=':default';
	for($i=0;$i<$count;$i++)
	{
		$val=$vr[$i];
		$isdef="";
		if(strstr($val,$def))
		{
			$dr=explode($def,$val);
			$val=$dr[0];
			$isdef=1;
		}
		if($type=='select')
		{
			$change.="<option value=\"".$val."\"".($isdef==1?' selected':'').">".$val."</option>";
		}
		elseif($type=='checkbox')
		{
			$change.="<input name=\"".$f."[]\" type=\"checkbox\" value=\"".$val."\"".($isdef==1?' checked':'').">".$val;
		}
		else
		{
			$change.="<input name=\"".$f."\" type=\"radio\" value=\"".$val."\"".($isdef==1?' checked':'').">".$val;
		}
	}
	if($type=="select")
	{
		if($fformsize)
		{
			$addsize=' style="width:'.$fformsize.'"';
		}
		$change="<select name=\"".$f."\" id=\"".$f."\"".$addsize.">".$change."</select>";
	}
	return $change;
}

//�Զ����ɷ�����
function ReturnFeedbackBtemp($cname,$center,$mustenter){
	global $empire,$dbtbpre,$fun_r;
	//��Ԫ��
	$temp="<tr><td width='16%' height=25 bgcolor='ffffff'>enews.name</td><td bgcolor='ffffff'>enews.var</td></tr>";
	for($i=0;$i<count($center);$i++)
	{
		$v=$center[$i];
		$fr=$empire->fetch1("select fform,fformsize,fvalue from {$dbtbpre}enewsfeedbackf where f='".RepPostVar($v)."' limit 1");
		if($fr['fform']=="file")
		{
			$fsize=$fr[fformsize]?" size='".$fr[fformsize]."'":"";
			$repform="<input type='file' name='".$v."'".$fsize.">";
		}
		elseif($fr['fform']=="textarea")
		{
			$fsr=explode(',',$fr[fformsize]);
			$cols=$fsr[0]?$fsr[0]:60;
			$rows=$fsr[1]?$fsr[1]:12;
			$repform="<textarea name='".$v."' cols='".$cols."' rows='".$rows."'>".$fr[fvalue]."</textarea>";
		}
		elseif($fr['fform']=="select"||$fr['fform']=="radio"||$fr['fform']=="checkbox")
		{
			$repform=GetBFFformSelect($fr['fform'],$v,$fr[fvalue],$fr[fformsize]);
		}
		else
		{
			$fsize=$fr[fformsize]?" size='".$fr[fformsize]."'":"";
			$repform="<input name='".$v."' type='text' value='".$fr[fvalue]."'".$fsize.">";
		}
		//����
		$star="";
		if(strstr($mustenter,",".$v.","))
		{
			$star="(*)";
		}
		$data.=str_replace("enews.var",$repform.$star,str_replace("enews.name",$cname[$v],$temp));
    }
	return "[!--cp.header--]<table width=100% align=center cellpadding=3 cellspacing=1 bgcolor='#DBEAF5'><form name='feedback' method='post' enctype='multipart/form-data' action='../../enews/index.php'><input name='enews' type='hidden' value='AddFeedback'>".$data."<tr><td bgcolor='ffffff'></td><td bgcolor='ffffff'><input type='submit' name='submit' value='".$fun_r['onsubmit']."'></td></tr></form></table>[!--cp.footer--]";
}

//���ɷ������ļ�
function ReFeedbackClassFile($bid){
	global $empire,$dbtbpre;
	$bid=(int)$bid;
	$r=$empire->fetch1("select btemp from {$dbtbpre}enewsfeedbackclass where bid='$bid'");
	//�滻��������
	$url="<?=\$url?>";
	$pagetitle="<?=\$bname?>";
	$btemp=ReplaceSvars($r['btemp'],$url,0,$pagetitle,$pagetitle,$pagetitle,$add,1);
	$btemp=str_replace("[!--cp.header--]","<? include(\"../../data/template/cp_1.php\");?>",$btemp);
	$btemp=str_replace("[!--cp.footer--]","<? include(\"../../data/template/cp_2.php\");?>",$btemp);
	$btemp=str_replace("[!--member.header--]","<? include(\"../../template/incfile/header.php\");?>",$btemp);
	$btemp=str_replace("[!--member.footer--]","<? include(\"../../template/incfile/footer.php\");?>",$btemp);
	$file=eReturnTrueEcmsPath()."e/tool/feedback/temp/feedback".$bid.".php";
	$btemp="<?
if(!defined('InEmpireCMS'))
{exit();}
?>".$btemp;
	WriteFiletext($file,$btemp);
}

//�������ɷ������ļ�
function ReMoreFeedbackClassFile($start=0,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"changedata");
	$sql=$empire->query("select bid from {$dbtbpre}enewsfeedbackclass order by bid");
	while($r=$empire->fetch($sql))
	{
		ReFeedbackClassFile($r['bid']);
	}
	printerror("ReMFeedbackFileSuccess","");
}

//���Ͷ����
function TogFBqenter($cname,$cqenter){
	$record="<!--record-->";
	$field="<!--field--->";
	$c="";
	for($i=0;$i<count($cqenter);$i++)
	{
		$v=$cqenter[$i];
		$name=str_replace($field,"",$cname[$v]);
		$name=str_replace($record,"",$name);
		$c.=$name.$field.$v.$record;
	}
	return $c;
}

//��ϱ�����
function TogFBMustf($cname,$menter){
	$c="";
	for($i=0;$i<count($menter);$i++)
	{
		$v=$menter[$i];
		$c.=$v.",";
	}
	if($c)
	{
		$c=",".$c;
	}
	return $c;
}

//���ӷ�������
function AddFeedbackClass($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[bname]))
	{printerror("EmptyGbookClass","history.go(-1)");}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedbackf");
	$enter=TogFBqenter($add['cname'],$add['center']);
	$mustenter=TogFBMustf($add['cname'],$add['menter']);
	$filef=ReturnMFileF($enter,$dbtbpre."enewsfeedbackf",0,"file");
	$checkboxf=ReturnMFileF($enter,$dbtbpre."enewsfeedbackf",0,"checkbox");
	//�Զ����ɱ�
	if($add[btype])
	{
		$add[btemp]=ReturnFeedbackBtemp($add['cname'],$add['center'],$mustenter);
	}
	$groupid=(int)$add['groupid'];
	if($add['usernames'])
	{
		$add['usernames']=','.$add['usernames'].',';
	}
	$add['bname']=hRepPostStr($add['bname'],1);
	$enter=eaddslashes($enter);
	$mustenter=eaddslashes($mustenter);
	$filef=eaddslashes($filef);
	$checkboxf=eaddslashes($checkboxf);
	$add['usernames']=eaddslashes($add['usernames']);
	$sql=$empire->query("insert into {$dbtbpre}enewsfeedbackclass(bname,btemp,bzs,enter,mustenter,filef,groupid,checkboxf,usernames) values('$add[bname]','".eaddslashes2($add[btemp])."','".eaddslashes($add[bzs])."','$enter','$mustenter','$filef',$groupid,'$checkboxf','$add[usernames]');");
	$bid=$empire->lastid();
	//���ɱ�ҳ��
	ReFeedbackClassFile($bid);
	if($sql)
	{
		//������־
	    insert_dolog("bid=".$bid."<br>bname=".$add[bname]);
		printerror("AddGbookClassSuccess","AddFeedbackClass.php?enews=AddFeedbackClass".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸ķ�������
function EditFeedbackClass($add,$userid,$username){
	global $empire,$dbtbpre;
	$bid=(int)$add['bid'];
	if(empty($add[bname])||!$bid)
	{printerror("EmptyGbookClass","history.go(-1)");}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedbackf");
	$enter=TogFBqenter($add['cname'],$add['center']);
	$mustenter=TogFBMustf($add['cname'],$add['menter']);
	$filef=ReturnMFileF($enter,$dbtbpre."enewsfeedbackf",0,"file");
	$checkboxf=ReturnMFileF($enter,$dbtbpre."enewsfeedbackf",0,"checkbox");
	//�Զ����ɱ�
	if($add[btype])
	{
		$add[btemp]=ReturnFeedbackBtemp($add['cname'],$add['center'],$mustenter);
	}
	$groupid=(int)$add['groupid'];
	if($add['usernames'])
	{
		$add['usernames']=','.$add['usernames'].',';
	}
	$add['bname']=hRepPostStr($add['bname'],1);
	$enter=eaddslashes($enter);
	$mustenter=eaddslashes($mustenter);
	$filef=eaddslashes($filef);
	$checkboxf=eaddslashes($checkboxf);
	$add['usernames']=eaddslashes($add['usernames']);
	$sql=$empire->query("update {$dbtbpre}enewsfeedbackclass set bname='$add[bname]',btemp='".eaddslashes2($add[btemp])."',bzs='".eaddslashes($add[bzs])."',enter='$enter',mustenter='$mustenter',filef='$filef',groupid=$groupid,checkboxf='$checkboxf',usernames='$add[usernames]' where bid=$bid");
	//���ɱ�ҳ��
	ReFeedbackClassFile($bid);
	if($sql)
	{
		//������־
	    insert_dolog("bid=".$bid."<br>bname=".$add[bname]);
		printerror("EditGbookClassSuccess","FeedbackClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����������
function DelFeedbackClass($add,$userid,$username){
	global $empire,$dbtbpre;
	$bid=(int)$add['bid'];
	if(!$bid)
	{printerror("NotChangeGbookClassid","history.go(-1)");}
	//��֤Ȩ��
	//CheckLevel($userid,$username,$classid,"feedbackf");
	$r=$empire->fetch1("select bid,bname from {$dbtbpre}enewsfeedbackclass where bid=$bid;");
	if(!$r['bid'])
	{printerror("NotChangeGbookClassid","history.go(-1)");}
	$sql=$empire->query("delete from {$dbtbpre}enewsfeedbackclass where bid=$bid;");
	//ɾ������
	$fsql=$empire->query("select id,filepath,filename from {$dbtbpre}enewsfeedback where bid=$bid");
	while($fr=$empire->fetch($fsql))
	{
		DelFeedbackFile($fr['filename'],$fr['filepath']);
	}
	$sql1=$empire->query("delete from {$dbtbpre}enewsfeedback where bid=$bid;");
	//ɾ�����ļ�
	$file="../../tool/feedback/temp/feedback".$bid.".php";
	DelFiletext($file);
	if($sql)
	{
		//������־
	    insert_dolog("bid=".$bid."<br>bname=".$r[bname]);
		printerror("DelGbookClassSuccess","FeedbackClass.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ������Ϣ
function DelMoreMsg($add,$userid,$username){
	global $empire,$dbtbpre;
	$starttime=RepPostVar($add['starttime']);
	$endtime=RepPostVar($add['endtime']);
	if(!$starttime||!$endtime)
	{
		printerror("EmptyDelMoreMsg","history.go(-1)");
	}
	//��������
	$msgtype=(int)$add['msgtype'];
	if($msgtype==1)//��̨
	{
		$a='';
		$tbname="{$dbtbpre}enewshmsg";
	}
	elseif($msgtype==2)//ǰ̨ϵͳ��Ϣ
	{
		$a=' and issys=1';
		$tbname="{$dbtbpre}enewsqmsg";
	}
	elseif($msgtype==3)//��̨ϵͳ��Ϣ
	{
		$a=' and issys=1';
		$tbname="{$dbtbpre}enewshmsg";
	}
	else//ǰ̨
	{
		$a='';
		$tbname="{$dbtbpre}enewsqmsg";
	}
	//������
	$from_username=RepPostVar($add['from_username']);
	if($from_username)
	{
		if($add['fromlike']==1)
		{
			$a.=" and from_username like '%$from_username%'";
		}
		else
		{
			$a.=" and from_username='$from_username'";
		}
	}
	$to_username=RepPostVar($add['to_username']);
	if($to_username)
	{
		if($add['tolike']==1)
		{
			$a.=" and to_username like '%$to_username%'";
		}
		else
		{
			$a.=" and to_username='$to_username'";
		}
	}
	//�ؼ���
	$keyboard=RepPostVar2($add['keyboard']);
	if(trim($keyboard))
	{
		//�����ֶ�
		$keyfield=(int)$add['keyfield'];
		if($keyfield==1)
		{
			$likef="title like '%[!--key--]%'";
		}
		elseif($keyfield==2)
		{
			$likef="msgtext like '%[!--key--]%'";
		}
		else
		{
			$likef="title like '%[!--key--]%' or msgtext like '%[!--key--]%'";
		}
		$r=explode(",",$keyboard);
		$likekey="";
		$count=count($r);
		for($i=0;$i<$count;$i++)
		{
			if($i==0)
			{
				$or="";
			}
			else
			{
				$or=" or ";
			}
			$likekey.=$or.str_replace("[!--key--]",$r[$i],$likef);
		}
		$a.=" and (".$likekey.")";
	}
	$sql=$empire->query("delete from ".$tbname." where msgtime>'$starttime' and msgtime<'$endtime'".$a);
	if($sql)
	{
		//������־
		insert_dolog("starttime=$starttime&endtime=$endtime<br>msgtype=$msgtype");
		printerror("DelMoreMsgSuccess","DelMoreMsg.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//���ػ�Ա��
function ReturnSendMemberGroup($r){
	global $public_r,$ecms_config;
	$user_groupid=eReturnMemberDefGroupid();
	$count=count($r);
	if($count==0)
	{
		printerror("EmptySendMemberGroup","");
	}
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=(int)$r[$i];
		if($i==0)
		{
			$or="";
		}
		else
		{
			$or=" or ";
		}
		$a.=$or.egetmf('groupid')."='".$r[$i]."'";
		if($user_groupid==$r[$i])
		{
			$a.=" or ".egetmf('groupid')."=0";
		}
		$checkbox.="<input type=hidden name='groupid[]' value='".$r[$i]."'>";
	}
	$re[0]="(".$a.")";
	$re[1]=$checkbox;
	return $re;
}

//���ػ�Ա�û���
function ReturnSendMemberUsername($username){
	$r=explode('|',$username);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=RepPostVar($r[$i]);
		if($i==0)
		{
			$or="";
		}
		else
		{
			$or=" or ";
		}
		$a.=$or.egetmf('username')."='".$r[$i]."'";
	}
	$re[0]="(".$a.")";
	$re[1]='<input type=hidden name="username" value="'.ClearAddsData($username).'">';
	return $re;
}

//��������վ����Ϣ
function DoSendMsg($add,$ecms=0,$userid,$username){
	global $empire,$dbtbpre;
	$start=(int)$add['start'];
	$line=(int)$add['line'];
	$title=ClearAddsData($add['title']);
	$msgtext=ClearAddsData($add['msgtext']);
	if(empty($title)||empty($msgtext))
	{printerror("EmptySendMsg","history.go(-1)");}
	if($ecms==1)//�����ʼ�
	{
		$enews="SendEmail";
		$mess="SendEmailSuccess";
		$returnurl="SendEmail.php";
		$pr=$empire->fetch1("select sendmailtype,smtphost,fromemail,loginemail,emailusername,emailpassword,smtpport,emailname from {$dbtbpre}enewspublic limit 1");
		//���ͳ�ʹ��
		$mailer=FirstSendMail($pr,$title,$msgtext);
	}
	else//���Ͷ���Ϣ
	{
		$enews="SendMsg";
		$mess="SendMsgSuccess";
		$returnurl="SendMsg.php";
	}
	if($add['username'])//�û���
	{
		$gr=ReturnSendMemberUsername($add['username']);
	}
	else//��Ա��
	{
		$gr=ReturnSendMemberGroup($add['groupid']);
	}
	$a=" and ".$gr[0];
	$b=0;
	$msgtime=date("Y-m-d H:i:s");
	$sql=$empire->query("select ".eReturnSelectMemberF('userid,username,havemsg,groupid,email')." from ".eReturnMemberTable()." where ".egetmf('userid').">$start".$a." order by ".egetmf('userid')." limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r['userid'];
		$r['email']=RepPostVar($r['email']);
		if($ecms==1)
		{
			$mailer->AddAddress($r['email']);
		}
		else
		{
			$ititle=str_replace("[!--username--]",$r['username'],$title);
			$imsgtext=str_replace("[!--username--]",$r['username'],$msgtext);
			SendSiteMsg($ititle,$imsgtext,$msgtime,$r['userid'],$r['username'],$r['havemsg']);
		}
	}
	if(empty($b))
	{
		//������־
		insert_dolog("title=$title");
		printerror($mess,$returnurl.hReturnEcmsHashStrHref2(1));
	}
	if($ecms==1)
	{
		if(!$mailer->Send())
		{
			echo $mailer->ErrorInfo;
		}
	}
	//�����һ���ύ��
	EchoSendMsgForm($enews,$returnurl,$newstart,$line,$gr[1],$add);
}

//���һ���ύ��
function EchoSendMsgForm($enews,$returnurl,$start,$line,$checkbox,$add){
	global $fun_r;
	?>
	<?=$fun_r['OneSendMsg']?>(<b><font color=red><?=$start?></font></b>)
	<form name="sendform" method="post" action="<?=$returnurl?>">
		<?=hReturnEcmsHashStrForm(0)?>
		<input type=hidden name="enews" value="<?=$enews?>">
		<input type=hidden name="start" value="<?=$start?>">
		<input type=hidden name="line" value="<?=$line?>">
		<?=$checkbox?>
		<input type=hidden name="title" value="<?=ehtmlspecialchars($add[title])?>">
		<input type=hidden name="msgtext" value="<?=ehtmlspecialchars($add[msgtext])?>">
	</form>
	<script>
	document.sendform.submit();
	</script>
	<?
	exit();
}

//����վ�ڶ���Ϣ
function SendSiteMsg($title,$msgtext,$msgtime,$userid,$username,$havemsg){
	global $empire,$dbtbpre;
	$userid=(int)$userid;
	$isql=$empire->query("insert into {$dbtbpre}enewsqmsg(title,msgtext,haveread,msgtime,to_username,from_userid,from_username,isadmin,issys) values('".addslashes($title)."','".addslashes($msgtext)."',0,'".addslashes($msgtime)."','".addslashes($username)."',0,'',1,1);");
	if(!$havemsg)
	{
		$newhavemsg=eReturnSetHavemsg($havemsg,0);
		$newhavemsg=(int)$newhavemsg;
		$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('havemsg')."='$newhavemsg' where ".egetmf('userid')."='".$userid."' limit 1");
	}
}
?>