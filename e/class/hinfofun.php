<?php
//*************************** ��Ϣ ***************************

//����ͶƱ
function AddInfoVote($classid,$id,$add){
	global $empire,$dbtbpre,$class_r;
	$pubid=ReturnInfoPubid($classid,$id);
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	$votename=$add['vote_name'];
	$votenum=$add['vote_num'];
	//ͳ����Ʊ��
	for($i=0;$i<count($votename);$i++)
	{
		$t_votenum+=$votenum[$i];
	}
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$add['vote_class'];
	$width=(int)$add['vote_width'];
	$height=(int)$add['vote_height'];
	$doip=(int)$add['dovote_ip'];
	$tempid=(int)$add['vote_tempid'];
	$add['vote_title']=hRepPostStr($add['vote_title'],1);
	$add['vote_dotime']=hRepPostStr($add['vote_dotime'],1);
	//�����ֶ�
	$diyotherlink=(int)$add['info_diyotherlink'];
	$infouptime=0;
	if($add['info_infouptime'])
	{
		$infouptime=to_time($add['info_infouptime']);
	}
	$infodowntime=0;
	if($add['info_infodowntime'])
	{
		$infodowntime=to_time($add['info_infodowntime']);
	}
	if($num)	//�޸�
	{
		$votetext=ReturnVote($add['vote_name'],$add['vote_num'],$add['delvote_id'],$add['vote_id'],1);	//�������
		$votetext=hRepPostStr($votetext,1);
		$sql=$empire->query("update {$dbtbpre}enewsinfovote set title='$add[vote_title]',votenum='$t_votenum',votetext='$votetext',voteclass='$voteclass',doip='$doip',dotime='$add[vote_dotime]',tempid='$tempid',width='$width',height='$height',diyotherlink='$diyotherlink',infouptime='$infouptime',infodowntime='$infodowntime' where pubid='$pubid' limit 1");
	}
	else	//����
	{
		$votetext=ReturnVote($add['vote_name'],$add['vote_num'],$add['delvote_id'],$add['vote_id'],0);	//�������
		if(!($votetext||$diyotherlink||$infouptime||$infodowntime))
		{
			return '';
		}
		$votetext=hRepPostStr($votetext,1);
		$sql=$empire->query("insert into {$dbtbpre}enewsinfovote(pubid,id,classid,title,votenum,voteip,votetext,voteclass,doip,dotime,tempid,width,height,diyotherlink,infouptime,infodowntime,copyids) values('$pubid','$id','$classid','$add[vote_title]','$t_votenum','','$votetext','$voteclass','$doip','$add[vote_dotime]','$tempid','$width','$height','$diyotherlink','$infouptime','$infodowntime','');");
	}
}

//����ͬʱ����
function UpdateInfoCopyids($classid,$id,$copyids){
	global $empire,$dbtbpre,$class_r;
	$pubid=ReturnInfoPubid($classid,$id);
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	if($num)	//�޸�
	{
		$empire->query("update {$dbtbpre}enewsinfovote set copyids='$copyids' where pubid='$pubid' limit 1");
	}
	else	//����
	{
		$empire->query("insert into {$dbtbpre}enewsinfovote(pubid,id,classid,copyids) values('$pubid','$id','$classid','$copyids');");
	}
}

//���ر����Ƿ��ظ�
function ReturnCheckRetitle($add){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$add['classid'];
	$id=(int)$add['id'];
	$title=AddAddsData($add['title']);
	$where='';
	if($id)
	{
		$where=' and id<>'.$id;
	}
	//�����
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where title='".addslashes($title)."'".$where." limit 1");
	//δ���
	if(empty($num))
	{
		$num=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where title='".addslashes($title)."'".$where." limit 1");
	}
	return $num;
}

//AJAX��֤�����Ƿ��ظ�
function CheckReTitleAjax($add){
	if(ReturnCheckRetitle($add))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

//������Ϣ�������
function DoPostInfoVar($add){
	global $class_r,$public_r;
	$add['classid']=(int)$add['classid'];
	//��ϱ�������
	$add[titlecolor]=eDoRepPostComStr(RepPhpAspJspcodeText($add[titlecolor]));
	$add['my_titlefont']=eDoRepPostComStr(TitleFont($add[titlefont],$add[titlecolor]));
	//ר��
	$add['ztids']=RepPostVar($add['ztids']);
	$add['zcids']=RepPostVar($add['zcids']);
	$add['oldztids']=RepPostVar($add['oldztids']);
	$add['oldzcids']=RepPostVar($add['oldzcids']);
	//��������
	$add['title']=eDoInfoTbfToQj($class_r[$add['classid']]['tbname'],'title',$add['title'],$public_r['toqjf']);
	$add[title]=eDoRepPostComStr($add[title],1);
	$add[keyboard]=eDoRepPostComStr(RepPhpAspJspcodeText(DoReplaceQjDh($add[keyboard])),1);
	$add[titleurl]=eDoRepPostComStr(RepPhpAspJspcodeText($add[titleurl]),1);
	$add[checked]=(int)$add[checked];
	$add[istop]=(int)$add[istop];
	$add[dokey]=(int)$add[dokey];
	$add[isgood]=(int)$add[isgood];
	$add[groupid]=(int)$add[groupid];
	$add[newstempid]=(int)$add[newstempid];
	$add[firsttitle]=(int)$add[firsttitle];
	$add[userfen]=(int)$add[userfen];
	$add[closepl]=(int)$add[closepl];
	$add[ttid]=(int)$add[ttid];
	$add[oldttid]=(int)$add[oldttid];
	$add[onclick]=(int)$add[onclick];
	$add[totaldown]=(int)$add[totaldown];
	$add[infotags]=eDoRepPostComStr(RepPhpAspJspcodeText(DoReplaceQjDh($add[infotags])),1);
	$add[titlepic]=eDoRepPostComStr($add[titlepic],1);
	$add[ispic]=$add[titlepic]?1:0;
	$add[filename]=RepFilenameQz($add[filename],1);
	$add[newspath]=RepFilenameQz($add[newspath],1);
	$add['newspath']=hRepPostStr($add['newspath'],1);
	$add['filename']=hRepPostStr($add['filename'],1);
	$add['keyboard']=hRepPostStr($add['keyboard'],0);
	$add['infotags']=hRepPostStr($add['infotags'],1);
	$add['isurl']=$add['titleurl']?1:0;
	return $add;
}

//�������ID����
function DoPostDiyOtherlinkID($keyid){
	if(!$keyid||$keyid==',')
	{
		return '';
	}
	$new_keyid='';
	$dh='';
	$r=explode(',',$keyid);
	$count=count($r);
	for($i=0;$i<$count;$i++)
	{
		$r[$i]=(int)$r[$i];
		if(!$r[$i])
		{
			continue;
		}
		$new_keyid.=$dh.$r[$i];
		$dh=',';
	}
	return $new_keyid;
}

//������Ϣ
function AddNews($add,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r,$lur;
	$add[classid]=(int)$add[classid];
	$userid=(int)$userid;
	if(!$add[title]||!$add[classid])
	{
		printerror("EmptyTitle","history.go(-1)");
	}
	//����Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$add[classid],"news");
	if(!$doselfinfo['doaddinfo'])//����Ȩ��
	{
		printerror("NotAddInfoLevel","history.go(-1)");
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,sametitle,addreinfo,wburl,repreinfo from {$dbtbpre}enewsclass where classid='$add[classid]' and islast=1 limit 1");
	if(!$ccr['classid']||$ccr['wburl'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if($ccr['sametitle'])//��֤�����ظ�
	{
		if(ReturnCheckRetitle($add))
		{
			printerror("ReInfoTitle","history.go(-1)");
	    }
    }
	//�޸��ļ���Ȩ��
	if(!$doselfinfo['doinfofile'])
	{
		$add['newspath']=date($class_r[$add['classid']]['newspath']);
		$add['filename']='';
	}
	$add=DoPostInfoVar($add);//���ر���
	$ret_r=ReturnAddF($add,$class_r[$add[classid]][modid],$userid,$username,0,0,1);//�����Զ����ֶ�
	$newspath=FormatPath($add[classid],$add[newspath],1);//�鿴Ŀ¼�Ƿ���ڣ�����������
	//���Ȩ��
	if(!$doselfinfo['docheckinfo'])
	{
		$add['checked']=$class_r[$add[classid]][checked];
	}
	//�������
	if($doselfinfo['domustcheck'])
	{
		$add['checked']=0;
	}
	//�Ƽ�Ȩ��
	if(!$doselfinfo['dogoodinfo'])
	{
		$add['isgood']=0;
		$add['firsttitle']=0;
		$add['istop']=0;
	}
	else
	{
		if(!eFirstTitleCheckLevel($add['isgood'],0))//�Ƽ�
		{
			$add['isgood']=0;
		}
		if(!eFirstTitleCheckLevel($add['firsttitle'],1))//ͷ��
		{
			$add['firsttitle']=0;
		}
	}
	//ǩ��
	$isqf=0;
	if($class_r[$add[classid]][wfid])
	{
		$userisqf=EcmsReturnDoIsqf($userid,$username,$lur['groupid'],0);
		if(!$userisqf)
		{
			$add[checked]=0;
			$isqf=1;
		}
	}
	$newstime=empty($add['newstime'])?time():to_time($add['newstime']);
	$truetime=time();
	$lastdotime=$truetime;
	//�Ƿ�����
	$havehtml=0;
	if($add['checked']==1&&$ccr['addreinfo'])
	{
		$havehtml=1;
	}
	//���عؼ������
	if($add['info_diyotherlink'])
	{
		$keyid=DoPostDiyOtherlinkID($add['info_keyid']);
	}
	else
	{
		$keyid=GetKeyid($add[keyboard],$add[classid],0,$class_r[$add[classid]][link_num]);
	}
	//�������Ӳ���
	$addecmscheck=empty($add['checked'])?'&ecmscheck=1':'';
	//������
	$sql=$empire->query("insert into {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$add[classid]','$add[checked]','$newstime','$truetime','$lastdotime','$havehtml');");
	$id=$empire->lastid();
	$pubid=ReturnInfoPubid($add['classid'],$id);
	$infotbr=ReturnInfoTbname($class_r[$add[classid]][tbname],$add['checked'],$ret_r['tb']);
	//����
	$infosql=$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r['fields'].") values('$id','$add[classid]','$add[ttid]','$add[onclick]',0,'$add[totaldown]','$newspath','$filename','$userid','".addslashes($username)."','$add[firsttitle]','$add[isgood]','$add[ispic]','$add[istop]','$isqf',0,'$add[isurl]','$truetime','$lastdotime','$havehtml','$add[groupid]','$add[userfen]','".addslashes($add[my_titlefont])."','".addslashes($add[titleurl])."','$ret_r[tb]','$public_r[filedeftb]','$public_r[pldeftb]','".addslashes($add[keyboard])."'".$ret_r['values'].");");
	//����
	$finfosql=$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r['datafields'].") values('$id','$add[classid]','$keyid','$add[dokey]','$add[newstempid]','$add[closepl]',0,'".addslashes($add[infotags])."'".$ret_r['datavalues'].");");
	//������Ŀ��Ϣ��
	AddClassInfos($add['classid'],'+1','+1',$add['checked']);
	//��������Ϣ��
	DoUpdateAddDataNum('info',$class_r[$add['classid']]['tid'],1);
	//ǩ��
	if($isqf==1)
	{
		InfoInsertToWorkflow($id,$add[classid],$class_r[$add[classid]][wfid],$userid,$username);
	}
	//���¸�����
	UpdateTheFile($id,$add['filepass'],$add['classid'],$public_r['filedeftb']);
	//ȡ��һ��ͼ��Ϊ����ͼƬ
	if($add['getfirsttitlepic']&&empty($add['titlepic']))
	{
		$firsttitlepic=GetFpicToTpic($add['classid'],$id,$add['getfirsttitlepic'],$add['getfirsttitlespic'],$add['getfirsttitlespicw'],$add['getfirsttitlespich'],$public_r['filedeftb']);
		if($firsttitlepic)
		{
			$addtitlepic=",titlepic='".addslashes($firsttitlepic)."',ispic=1";
		}
	}
	//�ļ�����
	if($add['filename'])
	{
		$filename=$add['filename'];
	}
	else
	{
		$filename=ReturnInfoFilename($add[classid],$id,'');
	}
	//��Ϣ��ַ
	$updateinfourl='';
	if(!$add['isurl'])
	{
		$infourl=GotoGetTitleUrl($add['classid'],$id,$newspath,$filename,$add['groupid'],$add['isurl'],$add['titleurl']);
		$updateinfourl=",titleurl='$infourl'";
	}
	$usql=$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl.$addtitlepic." where id='$id'");
	//�滻ͼƬ��һҳ
	if($add['repimgnexturl'])
	{
		UpdateImgNexturl($add[classid],$id,$add['checked']);
	}
	//ͶƱ
	AddInfoVote($add['classid'],$id,$add);
	//����ר��
	InsertZtInfo($add['ztids'],$add['zcids'],$add['oldztids'],$add['oldzcids'],$add['classid'],$id,$newstime);
	//TAGS
	if($add[infotags]&&$add[infotags]<>$add[oldinfotags])
	{
		eInsertTags($add[infotags],$add['classid'],$id,$newstime);
	}
	//������
	DoMFun($class_r[$add['classid']]['modid'],$add['classid'],$id,1,0);
	//������Ϣ�Ƿ������ļ�
	if($ccr['addreinfo']&&$add['checked'])
	{
		GetHtml($add['classid'],$id,'',0);
	}
	//������һƪ
	$epreid=0;
	if($ccr['repreinfo']&&$add['checked'])
	{
		$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id<$id and classid='$add[classid]' order by id desc limit 1");
		$epreid=$prer['id'];
		GetHtml($add['classid'],$prer['id'],$prer,1);
	}
	//������Ŀ
	if($ccr['haddlist']&&$add['checked'])
	{
		hAddListHtml($add['classid'],$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//������Ϣ�б�
		if($add['ttid'])//���ɱ�������б�
		{
			ListHtml($add['ttid'],'',5);
		}
	}
	//ͬʱ����
	$copyclassid=$add[copyclassid];
	$cpcount=count($copyclassid);
	if($cpcount)
	{
		$copyids=AddInfoToCopyInfo($add[classid],$id,$copyclassid,$userid,$username,$doselfinfo);
		if($copyids)
		{
			UpdateInfoCopyids($add['classid'],$id,$copyids);
		}
	}
	//���¶�̬����
	if($public_r['ctimeopen']&&$add['checked'])
	{
		eUpCacheInfo(1,$add['classid'],0,$epreid,$add['ttid'],'',$add['infotags'],0,0);
	}
	if($sql)
	{
		//���ص�ַ
		if($add['ecmsfrom']&&(stristr($add['ecmsfrom'],'ListNews.php')||stristr($add['ecmsfrom'],'ListAllInfo.php')))
		{
			$ecmsfrom=$add['ecmsfrom'];
		}
		else
		{
			$ecmsfrom=$add['ecmsnfrom']==1?"ListNews.php?bclassid=$add[bclassid]&classid=$add[classid]":"ListAllInfo.php?tbname=".$class_r[$add[classid]][tbname];
			$ecmsfrom.=hReturnEcmsHashStrHref2(0);
		}
		$GLOBALS['ecmsadderrorurl']=$ecmsfrom.$addecmscheck;
		insert_dolog("classid=$add[classid]<br>id=".$id."<br>title=".$add[title],$pubid);//������־
		printerror("AddNewsSuccess","AddNews.php?enews=AddNews&ecmsnfrom=$add[ecmsnfrom]&bclassid=$add[bclassid]&classid=$add[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","");
	}
}

//�޸���Ϣ
function EditNews($add,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r;
	$add[classid]=(int)$add[classid];
	$userid=(int)$userid;
	$add[id]=(int)$add[id];
	if(!$add[id]||!$add[title]||!$add[classid]||!$add[filename])
	{
		printerror("EmptyTitle","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$add[classid],"news");//����Ȩ��
	if(!$doselfinfo['doeditinfo'])//�༭Ȩ��
	{
		printerror("NotEditInfoLevel","history.go(-1)");
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,sametitle,addreinfo,wburl,repreinfo from {$dbtbpre}enewsclass where classid='$add[classid]' and islast=1 limit 1");
	if(!$ccr['classid']||$ccr['wburl'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//������
	$index_checkr=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index where id='$add[id]' limit 1");
	if(!$index_checkr['id']||$index_checkr['classid']!=$add['classid'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//����
	$infotb=ReturnInfoMainTbname($class_r[$add[classid]][tbname],$index_checkr['checked']);
	$checkr=$empire->fetch1("select id,classid,userid,username,ismember,stb,newspath,filename,isqf,fstb,isgood,firsttitle,istop,ttid,eckuid from ".$infotb." where id='$add[id]' limit 1");
	if($doselfinfo['doselfinfo']&&($checkr['userid']<>$userid||$checkr['ismember']))//ֻ�ܱ༭�Լ�����Ϣ
	{
		printerror("NotDoSelfinfo","history.go(-1)");
    }
	//�������Ϣ�����޸�
	if($doselfinfo['docheckedit']&&$index_checkr['checked'])
	{
		printerror("NotEditCheckInfoLevel","history.go(-1)");
	}
	//ǩ����Ϣ
	if($checkr['isqf'])
	{
		$qfr=$empire->fetch1("select wfid,checktno from {$dbtbpre}enewswfinfo where id='$add[id]' and classid='$add[classid]' limit 1");
		if($qfr['checktno']<100)
		{
			$qfwfr=$empire->fetch1("select wfid,canedit from {$dbtbpre}enewsworkflow where wfid='$qfr[wfid]' limit 1");
			if($qfwfr['wfid']&&!$qfwfr['canedit'])
			{
				printerror("WorkflowCanNotEditInfo","history.go(-1)");
			}
		}
	}
	//���Ȩ��
	if(!$doselfinfo['docheckinfo'])
	{
		$add['checked']=$index_checkr['checked'];
	}
	//�������
	if($doselfinfo['domustcheck']&&!$index_checkr['checked'])
	{
		$add['checked']=0;
	}
	//�Ƽ�Ȩ��
	if(!$doselfinfo['dogoodinfo'])
	{
		$add['isgood']=$checkr['isgood'];
		$add['firsttitle']=$checkr['firsttitle'];
		$add['istop']=$checkr['istop'];
	}
	else
	{
		if(!eFirstTitleCheckLevel($add['isgood'],0))//�Ƽ�
		{
			$add['isgood']=$checkr['isgood'];
		}
		if(!eFirstTitleCheckLevel($add['firsttitle'],1))//ͷ��
		{
			$add['firsttitle']=$checkr['firsttitle'];
		}
	}
	if($ccr['sametitle'])//��֤�����ظ�
	{
		if(ReturnCheckRetitle($add))
		{
			printerror("ReInfoTitle","history.go(-1)");
	    }
    }
	//�޸��ļ���Ȩ��
	if(!$doselfinfo['doinfofile'])
	{
		$add['newspath']=$checkr['newspath'];
		$add['filename']=$checkr['filename'];
	}
	//������
	$pubid=ReturnInfoPubid($add['classid'],$add['id']);
	$pubcheckr=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	$mid=$class_r[$add[classid]][modid];
	$pf=$emod_r[$mid]['pagef'];
	$add=DoPostInfoVar($add);//���ر���
	$add['fstb']=$checkr['fstb'];
	$ret_r=ReturnAddF($add,$class_r[$add[classid]][modid],$userid,$username,1,0,1);//�����Զ����ֶ�
	$deloldfile=0;
	if($add[groupid]<>$add[oldgroupid]||($index_checkr['checked']&&!$add[checked]))//�ı��ļ�Ȩ��
	{
        DelNewsFile($checkr[filename],$checkr[newspath],$add[classid],$add[$pf],$add[oldgroupid]);//ɾ���ɵ��ļ�
		$deloldfile=1;
	}
	//ǩ��
	$newchecked=$index_checkr['checked'];
	$a='';
	if($class_r[$add[classid]][wfid]&&$checkr['isqf'])
	{
		$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$add[id]' and classid='$add[classid]' limit 1");
		if($qfr['checktno']=='100')//��ͨ��
		{
			$aqf=",checked='$add[checked]'";
			$newchecked=$add[checked];
		}
		else
		{
			if($add[reworkflow])
			{
				InfoUpdateToWorkflow($add[id],$add[classid],$class_r[$add[classid]][wfid],$userid,$username);
			}
			$aqf='';
		}
	}
	else
	{
		$aqf=",checked='$add[checked]'";
		$newchecked=$add[checked];
	}
	//����Ŀ¼
	$updatefile='';
	$urlnewspath=$checkr['newspath'];
	if($add['newspath']!=$checkr[newspath])
	{
		$add[newspath]=FormatPath($add[classid],$add[newspath],1);//�鿴Ŀ¼�Ƿ���ڣ�����������
		$updatefile.=",newspath='$add[newspath]'";
		if($deloldfile==0)
		{
			DelNewsFile($checkr[filename],$checkr[newspath],$add[classid],$add[$pf],$add[oldgroupid]);//ɾ�����ļ�
			$deloldfile=1;
		}
		$urlnewspath=$add['newspath'];
	}
	//�ļ���
	$urlfilename=$checkr['filename'];
	if($add['filename']&&$add['filename']!=$checkr[filename])
	{
		$newfilename=$add['filename'];
		$updatefile.=",filename='$newfilename'";
		if($deloldfile==0)
		{
			DelNewsFile($checkr[filename],$checkr[newspath],$add[classid],$add[$pf],$add[oldgroupid]);//ɾ�����ļ�
			$deloldfile=1;
		}
		$urlfilename=$newfilename;
	}
	//�����
	if(!$index_checkr['checked']&&$index_checkr['checked']!=$newchecked)
	{
		if(!$checkr['eckuid']&&($checkr['ismember']||$checkr['userid']!=$userid))
		{
			$updatefile.=",eckuid='$userid'";
		}
	}
	$newstime=empty($add['newstime'])?time():to_time($add['newstime']);
	$lastdotime=time();
	//���عؼ������
	if($add['info_diyotherlink'])
	{
		$keyid=DoPostDiyOtherlinkID($add['info_keyid']);
	}
	else
	{
		$keyid=GetKeyid($add[keyboard],$add[classid],$add[id],$class_r[$add[classid]][link_num]);
	}
	//�������Ӳ���
	$addecmscheck=empty($newchecked)?'&ecmscheck=1':'';
	//��Ϣ��ַ
	$infourl=GotoGetTitleUrl($add['classid'],$add['id'],$urlnewspath,$urlfilename,$add['groupid'],$add['isurl'],$add['titleurl']);
	//���ر���Ϣ
	$infotbr=ReturnInfoTbname($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb']);
	//������
	$indexsql=$empire->query("update {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index set newstime='$newstime',lastdotime='$lastdotime'".$aqf." where id='$add[id]' limit 1");
	//����
	$sql=$empire->query("update ".$infotbr['tbname']." set classid='$add[classid]',ttid='$add[ttid]',onclick='$add[onclick]',totaldown='$add[totaldown]',firsttitle=$add[firsttitle],isgood=$add[isgood],ispic='$add[ispic]',istop=$add[istop],isurl='$add[isurl]',lastdotime=$lastdotime,groupid=$add[groupid],userfen=$add[userfen],titlefont='".addslashes($add[my_titlefont])."',titleurl='".addslashes($infourl)."',keyboard='".addslashes($add[keyboard])."'".$updatefile.$ret_r[values]." where id='$add[id]' limit 1");
	//����
	$stb=$checkr['stb'];
	$fsql=$empire->query("update ".$infotbr['datatbname']." set classid='$add[classid]',keyid='$keyid',dokey=$add[dokey],newstempid=$add[newstempid],closepl=$add[closepl],infotags='".addslashes($add[infotags])."'".$ret_r[datavalues]." where id='$add[id]' limit 1");
	//ȡ��һ��ͼ��Ϊ����ͼƬ
	if($add['getfirsttitlepic']&&empty($add['titlepic']))
	{
		$firsttitlepic=GetFpicToTpic($add['classid'],$add['id'],$add['getfirsttitlepic'],$add['getfirsttitlespic'],$add['getfirsttitlespicw'],$add['getfirsttitlespich'],$checkr['fstb']);
		if($firsttitlepic)
		{
			$usql=$empire->query("update ".$infotbr['tbname']." set titlepic='".addslashes($firsttitlepic)."',ispic=1 where id='$add[id]'");
		}
	}
	//���¸���
	UpdateTheFileEdit($add['classid'],$add['id'],$checkr['fstb']);
	//�滻ͼƬ��һҳ
	if($add['repimgnexturl'])
	{
		UpdateImgNexturl($add['classid'],$add['id'],$index_checkr['checked']);
	}
	//ͶƱ
	AddInfoVote($add['classid'],$add['id'],$add);
	//д��ר��
	InsertZtInfo($add['ztids'],$add['zcids'],$add['oldztids'],$add['oldzcids'],$add['classid'],$add['id'],$newstime);
	//TAGS
	if($add[infotags]&&$add[infotags]<>$add[oldinfotags])
	{
		eInsertTags($add[infotags],$add['classid'],$add['id'],$newstime);
	}
	//�Ƿ�ı����״̬
	if($index_checkr['checked']!=$newchecked)
	{
		MoveCheckInfoData($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb'],"id='$add[id]'");
		//������Ŀ��Ϣ��
		if($newchecked)
		{
			AddClassInfos($add['classid'],'','+1');
		}
		else
		{
			AddClassInfos($add['classid'],'','-1');
		}
	}
	//������
	DoMFun($class_r[$add['classid']]['modid'],$add['classid'],$add['id'],0,0);
	//�����ļ�
	if($ccr['addreinfo']&&$newchecked)
	{
		GetHtml($add['classid'],$add['id'],'',0);
	}
	//������һƪ
	$epreid=0;
	if($ccr['repreinfo']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id<$add[id] and classid='$add[classid]' order by id desc limit 1");
		$epreid=$prer['id'];
		GetHtml($prer['classid'],$prer['id'],$prer,1);
	}
	//������Ŀ
	if($ccr['haddlist']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		hAddListHtml($add[classid],$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//������Ϣ�б�
		if($add['ttid'])//���ɱ�������б�
		{
			ListHtml($add['ttid'],'',5);
		}
		//�ı�������
		if($add['oldttid']&&$add['ttid']<>$add['oldttid'])
		{
			ListHtml($add['oldttid'],'',5);
		}
	}
	//ͬʱ����
	if($pubcheckr['copyids']&&$pubcheckr['copyids']<>'1')
	{
		EditInfoToCopyInfo($add[classid],$add[id],$userid,$username,$doselfinfo);
	}
	else
	{
		$copyclassid=$add[copyclassid];
		$cpcount=count($copyclassid);
		if($cpcount)
		{
			$copyids=AddInfoToCopyInfo($add[classid],$add[id],$copyclassid,$userid,$username,$doselfinfo);
			if($copyids)
			{
				UpdateInfoCopyids($add['classid'],$add['id'],$copyids);
			}
		}
	}
	//���¶�̬����
	if($public_r['ctimeopen']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		eUpCacheInfo(1,$add['classid'],0,$epreid,$add['ttid'],'',$add['infotags'],0,$checkr['ttid']);
	}
	if($sql)
	{
		//���ص�ַ
		if($add['ecmsfrom']&&(stristr($add['ecmsfrom'],'ListNews.php')||stristr($add['ecmsfrom'],'ListAllInfo.php')))
		{
			$ecmsfrom=$add['ecmsfrom'];
		}
		else
		{
			$ecmsfrom="ListNews.php?bclassid=$add[bclassid]&classid=$add[classid]".hReturnEcmsHashStrHref2(0);
		}
		insert_dolog("classid=$add[classid]<br>id=".$add[id]."<br>title=".$add[title],$pubid);//������־
		printerror("EditNewsSuccess",$ecmsfrom.$addecmscheck);
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸���Ϣ(����)
function EditInfoSimple($add,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r;
	$add[classid]=(int)$add[classid];
	$userid=(int)$userid;
	$add[id]=(int)$add[id];
	$closeurl='info/EditInfoSimple.php?isclose=1&reload=1'.hReturnEcmsHashStrHref2(0);
	if(!$add[id]||!$add[title]||!$add[classid])
	{
		printerror("EmptyTitle","history.go(-1)",8);
	}
	$doselfinfo=CheckLevel($userid,$username,$add[classid],"news");//����Ȩ��
	if(!$doselfinfo['doeditinfo'])//�༭Ȩ��
	{
		printerror("NotEditInfoLevel","history.go(-1)",8);
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,sametitle,addreinfo,wburl,repreinfo from {$dbtbpre}enewsclass where classid='$add[classid]' and islast=1 limit 1");
	if(!$ccr['classid']||$ccr['wburl'])
	{
		printerror("ErrorUrl","history.go(-1)",8);
	}
	//������
	$index_checkr=$empire->fetch1("select id,classid,checked from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index where id='$add[id]' limit 1");
	if(!$index_checkr['id']||$index_checkr['classid']!=$add['classid'])
	{
		printerror("ErrorUrl","history.go(-1)",8);
	}
	//����
	$infotb=ReturnInfoMainTbname($class_r[$add[classid]][tbname],$index_checkr['checked']);
	$checkr=$empire->fetch1("select id,classid,userid,username,ismember,stb,newspath,filename,isqf,fstb,isgood,firsttitle,istop,groupid,ttid from ".$infotb." where id='$add[id]' limit 1");
	if($doselfinfo['doselfinfo']&&($checkr['userid']<>$userid||$checkr['ismember']))//ֻ�ܱ༭�Լ�����Ϣ
	{
		printerror("NotDoSelfinfo","history.go(-1)",8);
    }
	//�������Ϣ�����޸�
	if($doselfinfo['docheckedit']&&$index_checkr['checked'])
	{
		printerror("NotEditCheckInfoLevel","history.go(-1)");
	}
	//ǩ����Ϣ
	if($checkr['isqf'])
	{
		$qfr=$empire->fetch1("select wfid,checktno from {$dbtbpre}enewswfinfo where id='$add[id]' and classid='$add[classid]' limit 1");
		if($qfr['checktno']<100)
		{
			$qfwfr=$empire->fetch1("select wfid,canedit from {$dbtbpre}enewsworkflow where wfid='$qfr[wfid]' limit 1");
			if($qfwfr['wfid']&&!$qfwfr['canedit'])
			{
				printerror("WorkflowCanNotEditInfo","history.go(-1)");
			}
		}
	}
	//���Ȩ��
	if(!$doselfinfo['docheckinfo'])
	{
		$add['checked']=$index_checkr['checked'];
	}
	//�������
	if($doselfinfo['domustcheck']&&!$index_checkr['checked'])
	{
		$add['checked']=0;
	}
	//�Ƽ�Ȩ��
	if(!$doselfinfo['dogoodinfo'])
	{
		$add['isgood']=$checkr['isgood'];
		$add['firsttitle']=$checkr['firsttitle'];
		$add['istop']=$checkr['istop'];
	}
	else
	{
		if(!eFirstTitleCheckLevel($add['isgood'],0))//�Ƽ�
		{
			$add['isgood']=$checkr['isgood'];
		}
		if(!eFirstTitleCheckLevel($add['firsttitle'],1))//ͷ��
		{
			$add['firsttitle']=$checkr['firsttitle'];
		}
	}
	if($ccr['sametitle'])//��֤�����ظ�
	{
		if(ReturnCheckRetitle($add))
		{
			printerror("ReInfoTitle","history.go(-1)",8);
	    }
    }
	//������
	$pubid=ReturnInfoPubid($add['classid'],$add['id']);
	$pubcheckr=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	$mid=$class_r[$add[classid]][modid];
	$pf=$emod_r[$mid]['pagef'];
	$add=DoPostInfoVar($add);//���ر���
	//ǩ��
	$newchecked=$index_checkr['checked'];
	$a="";
	if($class_r[$add[classid]][wfid]&&$checkr['isqf'])
	{
		$qfr=$empire->fetch1("select checktno from {$dbtbpre}enewswfinfo where id='$add[id]' and classid='$add[classid]' limit 1");
		if($qfr['checktno']=='100')//��ͨ��
		{
			$aqf=",checked='$add[checked]'";
			$newchecked=$add[checked];
		}
		else
		{
			if($add[reworkflow])
			{
				InfoUpdateToWorkflow($add[id],$add[classid],$class_r[$add[classid]][wfid],$userid,$username);
			}
			$aqf='';
		}
	}
	else
	{
		$aqf=",checked='$add[checked]'";
		$newchecked=$add[checked];
	}
	$lastdotime=time();
	//����ʱ��
	$newstime=empty($add['newstime'])?time():to_time($add['newstime']);
	//�������Ӳ���
	$addecmscheck=empty($newchecked)?'&ecmscheck=1':'';
	//��Ϣ��ַ
	$infourl=GotoGetTitleUrl($add['classid'],$add['id'],$checkr['newspath'],$checkr['filename'],$checkr['groupid'],$add['isurl'],$add['titleurl']);
	//���ر���Ϣ
	$infotbr=ReturnInfoTbname($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb']);
	//������
	$indexsql=$empire->query("update {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]."_index set newstime='$newstime',lastdotime='$lastdotime'".$aqf." where id='$add[id]' limit 1");
	//����
	$sql=$empire->query("update ".$infotbr['tbname']." set classid='$add[classid]',ttid='$add[ttid]',onclick='$add[onclick]',totaldown='$add[totaldown]',firsttitle='$add[firsttitle]',isgood='$add[isgood]',ispic='$add[ispic]',istop='$add[istop]',isurl='$add[isurl]',lastdotime='$lastdotime',titlefont='".addslashes($add[my_titlefont])."',titleurl='".addslashes($infourl)."',title='".addslashes($add[title])."',titlepic='".addslashes($add[titlepic])."',newstime='$newstime' where id='$add[id]' limit 1");
	//����
	$fsql=$empire->query("update ".$infotbr['datatbname']." set classid='$add[classid]',closepl='$add[closepl]'".$ret_r[datavalues]." where id='$add[id]' limit 1");
	//���¸���
	UpdateTheFileEdit($add['classid'],$add['id'],$checkr['fstb']);
	//�Ƿ�ı����״̬
	if($index_checkr['checked']!=$newchecked)
	{
		MoveCheckInfoData($class_r[$add[classid]][tbname],$index_checkr['checked'],$checkr['stb'],"id='$add[id]'");
		//������Ŀ��Ϣ��
		if($newchecked)
		{
			AddClassInfos($add['classid'],'','+1');
		}
		else
		{
			AddClassInfos($add['classid'],'','-1');
		}
	}
	//������
	DoMFun($class_r[$add['classid']]['modid'],$add['classid'],$add['id'],0,0);
	//�����ļ�
	if($ccr['addreinfo']&&$newchecked)
	{
		GetHtml($add['classid'],$add['id'],'',0);
	}
	//������һƪ
	$epreid=0;
	if($ccr['repreinfo']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$add[classid]][tbname]." where id<$add[id] and classid='$add[classid]' order by id desc limit 1");
		$epreid=$prer['id'];
		GetHtml($prer['classid'],$prer['id'],$prer,1);
	}
	//������Ŀ
	if($ccr['haddlist']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		hAddListHtml($add[classid],$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//������Ϣ�б�
	}
	//ͬʱ����
	if($pubcheckr['copyids']&&$pubcheckr['copyids']<>'1')
	{
		EditInfoToCopyInfo($add[classid],$add[id],$userid,$username,$doselfinfo);
	}
	//���¶�̬����
	if($public_r['ctimeopen']&&($newchecked||$newchecked<>$add[oldchecked]))
	{
		eUpCacheInfo(1,$add['classid'],0,$epreid,$add['ttid'],'','',0,$checkr['ttid']);
	}
	if($sql)
	{
		//���ص�ַ
		if($add['ecmsfrom']&&(stristr($add['ecmsfrom'],'ListNews.php')||stristr($add['ecmsfrom'],'ListAllInfo.php')))
		{
			$ecmsfrom=$add['ecmsfrom'];
		}
		else
		{
			$ecmsfrom="ListNews.php?bclassid=$add[bclassid]&classid=$add[classid]".hReturnEcmsHashStrHref2(0);
		}
		$ecmsfrom=$ecmsfrom.$addecmscheck;
		insert_dolog("classid=$add[classid]<br>id=".$add[id]."<br>title=".$add[title],$pubid);//������־
		printerror("EditNewsSuccess",$closeurl,8);
	}
	else
	{
		printerror("DbError","history.go(-1)",8);
	}
}

//ɾ����Ϣ
function DelNews($id,$classid,$userid,$username){
	global $empire,$class_r,$class_zr,$bclassid,$public_r,$dbtbpre,$emod_r,$adddatar;
	$id=(int)$id;
	$classid=(int)$classid;
	if(!$id||!$classid)
	{
		printerror("NotDelNewsid","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");//����Ȩ��
	if(!$doselfinfo['dodelinfo'])//ɾ��Ȩ��
	{
		printerror("NotDelInfoLevel","history.go(-1)");
	}
	$ccr=$empire->fetch1("select classid,modid,listdt,haddlist,repreinfo from {$dbtbpre}enewsclass where classid='$classid' limit 1");
	if(!$ccr['classid'])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//������
	$index_r=$empire->fetch1("select classid,checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index  where id='$id' limit 1");
	if(!$index_r[classid]||$index_r[classid]!=$classid)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//���ر�
	$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
	$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
	if($doselfinfo['doselfinfo']&&($r[userid]<>$userid||$r[ismember]))//ֻ�ܱ༭�Լ�����Ϣ
	{
		printerror("NotDoSelfinfo","history.go(-1)");
    }
	$pubid=ReturnInfoPubid($classid,$id);
	$pubcheckr=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid' limit 1");
	//�������Ӳ���
	$addecmscheck=empty($index_r['checked'])?'&ecmscheck=1':'';
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$pf=$emod_r[$mid]['pagef'];
	$stf=$emod_r[$mid]['savetxtf'];
	//���ر���Ϣ
	$infotbr=ReturnInfoTbname($class_r[$classid][tbname],$index_r['checked'],$r['stb']);
	//��ҳ�ֶ�
	if($pf)
	{
		if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
		{
			$finfor=$empire->fetch1("select ".$pf." from ".$infotbr['datatbname']." where id='$id' limit 1");
			$r[$pf]=$finfor[$pf];
		}
	}
	//���ı�
	if($stf)
	{
		$newstextfile=$r[$stf];
		$r[$stf]=GetTxtFieldText($r[$stf]);
		DelTxtFieldText($newstextfile);//ɾ���ļ�
	}
	DelNewsFile($r[filename],$r[newspath],$classid,$r[$pf],$r[groupid]);//ɾ����Ϣ�ļ�
	$sql=$empire->query("delete from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id'");
	$sql=$empire->query("delete from ".$infotbr['tbname']." where id='$id'");
	$fsql=$empire->query("delete from ".$infotbr['datatbname']." where id='$id'");
	//������Ŀ��Ϣ��
	AddClassInfos($classid,'-1','-1',$index_r['checked']);
	//ɾ���������¼�͸���
	DelSingleInfoOtherData($r['classid'],$id,$r,0,0);
	$epreid=0;
	$epreid2=0;
	if($index_r['checked'])
	{
		//������һƪ
		if($ccr['repreinfo'])
		{
			$prer=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id<$id and classid='$classid' order by id desc limit 1");
			$epreid=$prer['id'];
			GetHtml($prer['classid'],$prer['id'],$prer,1);
			//��һƪ
			$nextr=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id>$id and classid='$classid' order by id limit 1");
			if($nextr['id'])
			{
				$epreid2=$nextr['id'];
				GetHtml($nextr['classid'],$nextr['id'],$nextr,1);
			}
		}
		hAddListHtml($classid,$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//������Ϣ�б�
		if($r['ttid'])//����Ǳ������
		{
			ListHtml($r['ttid'],'',5);
		}
	}
	//ͬ��ɾ��
	if($pubcheckr['copyids']&&$pubcheckr['copyids']<>'1')
	{
		DelInfoToCopyInfo($classid,$id,$r,$userid,$username,$doselfinfo,$pubcheckr['copyids']);
	}
	//���¶�̬����
	if($public_r['ctimeopen']&&$index_r['checked'])
	{
		eUpCacheInfo(1,$classid,$epreid2,$epreid,$r['ttid'],'','',0,0);
	}
	if($sql)
	{
		$returl=EcmsGetReturnUrl();
		//����֪ͨ
		if($adddatar['causetext'])
		{
			DoInfoSendNotice($userid,$username,$r['userid'],$r['username'],$adddatar['causetext'],$r,1);
			if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
			{
				$returl=$adddatar['ecmsfrom'];
			}
			else
			{
				$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
			}
		}
		else
		{
			if($_POST['enews']=='DoInfoAndSendNotice')
			{
				$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
			}
		}
		insert_dolog("classid=$classid<br>id=".$id."<br>title=".$r[title],$pubid);//������־
		printerror("DelNewsSuccess",$returl);
	}
	else
	{
		printerror("ErrorUrl","history.go(-1)");
	}
}

//����ɾ����Ϣ
function DelNews_all($id,$classid,$userid,$username,$ecms=0){
	global $empire,$class_r,$class_zr,$public_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$count=count($id);
	if(!$count)
	{
		printerror("NotDelNewsid","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");//����Ȩ��
	if(!$doselfinfo['dodelinfo'])//ɾ��Ȩ��
	{
		printerror("NotDelInfoLevel","history.go(-1)");
	}
	$dopubid=0;
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$pf=$emod_r[$mid]['pagef'];
	$stf=$emod_r[$mid]['savetxtf'];
	if($ecms==1)
	{
		$doctb="_doc";
	}
	elseif($ecms==2)
	{
		$doctb="_check";
	}
	for($i=0;$i<$count;$i++)
	{
		$add.="id='".intval($id[$i])."' or ";
    }
	$donum=0;
	$dolog='';
	$add=substr($add,0,strlen($add)-4);
	for($i=0;$i<$count;$i++)//ɾ����Ϣ�ļ�
	{
		$id[$i]=intval($id[$i]);
		$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname.$doctb." where id='$id[$i]'");
		if($doselfinfo['doselfinfo']&&($r[userid]<>$userid||$r[ismember]))//ֻ�ܱ༭�Լ�����Ϣ
		{
			$add=str_replace("id='".$id[$i]."'","id='0'",$add);
			continue;
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$id[$i]);
			$dolog="classid=".$r['classid']."<br>id=".$r['id']."&ecms=$ecms<br>title=".$r['title'];
		}
		//��ҳ�ֶ�
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				if($ecms==1)
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_doc_data where id='$id[$i]'");
				}
				elseif($ecms==2)
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_check_data where id='$id[$i]'");
				}
				else
				{
					$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$id[$i]'");
				}
				$r[$pf]=$finfor[$pf];
			}
		}
		//���ı�
		if($stf)
		{
			$newstextfile=$r[$stf];
			$r[$stf]=GetTxtFieldText($r[$stf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		DelNewsFile($r[filename],$r[newspath],$r[classid],$r[$pf],$r[groupid]);
		//ɾ������
		if($ecms==0)
		{
			$empire->query("delete from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$id[$i]'");
		}
		//ɾ���������¼�͸���
		DelSingleInfoOtherData($r['classid'],$id[$i],$r,0,0);
		//���¶�̬����
		if($public_r['ctimeopen']&&$ecms==0)
		{
			eUpCacheInfo(1,$r['classid'],0,0,$r['ttid'],'','',0,0,1);
		}
		//������Ŀ��Ϣ��
		if($ecms==0||$ecms==2)
		{
			AddClassInfos($r['classid'],'-1','-1',$ecms==2?0:1);
		}
    }
	//ɾ����Ϣ
	$sql=$empire->query("delete from {$dbtbpre}ecms_".$tbname.$doctb." where ".$add);
	if($ecms==0)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where ".$add);
		$ccr=$empire->fetch1("select classid,modid,listdt,haddlist from {$dbtbpre}enewsclass where classid='$classid'");
		hAddListHtml($classid,$ccr['modid'],$ccr['haddlist'],$ccr['listdt']);//������Ϣ�б�
	}
	elseif($ecms==1)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_doc_index where ".$add);
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_doc_data where ".$add);
	}
	elseif($ecms==2)
	{
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where ".$add);
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_check_data where ".$add);
	}
	if($sql)
	{
		//������־
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."&ecms=$ecms");
		}
		printerror("DelNewsAllSuccess",EcmsGetReturnUrl());
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�����޸ķ���ʱ��
function EditMoreInfoTime($add,$userid,$username){
	global $empire,$dbtbpre,$class_r,$public_r;
	$classid=(int)$add['classid'];
	$infoid=$add['infoid'];
	$newstime=$add['newstime'];
	$count=count($infoid);
	$tbname=$class_r[$classid]['tbname'];
	if(!$classid||!$tbname||!$count)
	{
		printerror('EmptyMoreInfoTime','');
	}
	//����Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	if(!$doselfinfo['doeditinfo'])//�༭Ȩ��
	{
		printerror('NotEditInfoLevel','history.go(-1)');
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//����
	$infotb='';
	for($i=0;$i<$count;$i++)
	{
		$doinfoid=(int)$infoid[$i];
		if(empty($infotb))
		{
			//������
			$index_r=$empire->fetch1("select classid,checked from {$dbtbpre}ecms_".$tbname."_index where id='$doinfoid' limit 1");
			if(!$index_r['classid'])
			{
				continue;
			}
			//���ر�
			$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($classid,$doinfoid);
			$dolog="classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>id=".$doinfoid;
		}
		$donewstime=$newstime[$i]?to_time($newstime[$i]):time();
		$empire->query("update {$dbtbpre}ecms_".$tbname."_index set newstime='$donewstime' where id='$doinfoid'");
		$empire->query("update ".$infotb." set newstime='$donewstime' where id='$doinfoid'");
	}
	//���¶�̬����
	if($public_r['ctimeopen']&&$index_r['checked'])
	{
		eUpCacheInfo(1,$classid,0,0,0,'','',0,0);
	}
	//������־
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=$classid<br>classname=".$class_r[$classid][classname]);
	}
	printerror('EditMoreInfoTimeSuccess',EcmsGetReturnUrl());
}

//ˢ��ҳ��
function AddInfoToReHtml($classid,$dore){
	global $class_r;
	$classid=(int)$classid;
	$dore=RepPostVar($dore);
	hAddListHtml($classid,$class_r[$classid]['modid'],$dore,$class_r[$classid]['listdt']);//������Ϣ�б�
	insert_dolog("classid=".$classid."<br>do=".$dore);//������־
	printerror('AddInfoToReHtmlSuccess','history.go(-1)');
}

//������Ϣ����ҳ��
function hAddListHtml($classid,$mid,$qaddlist,$listdt){
	global $class_r;
	if($qaddlist==0)//������
	{
		return "";
	}
	elseif($qaddlist==1)//���ɵ�ǰ��Ŀ
	{
		if(!$listdt)
		{
			$sonclass="|".$classid."|";
			hReClassHtml($sonclass);
		}
	}
	elseif($qaddlist==2)//������ҳ
	{
		hReIndex();
	}
	elseif($qaddlist==3)//���ɸ���Ŀ
	{
		$featherclass=$class_r[$classid]['featherclass'];
		if($featherclass&&$featherclass!="|")
		{
			hReClassHtml($featherclass);
		}
	}
	elseif($qaddlist==4)//���ɵ�ǰ��Ŀ�븸��Ŀ
	{
		$featherclass=$class_r[$classid]['featherclass'];
		if(empty($featherclass))
		{
			$featherclass="|";
		}
		if(!$listdt)
		{
			$featherclass.=$classid."|";
		}
		hReClassHtml($featherclass);
	}
	elseif($qaddlist==5)//���ɸ���Ŀ����ҳ
	{
		hReIndex();
		$featherclass=$class_r[$classid]['featherclass'];
		if($featherclass&&$featherclass!="|")
		{
			hReClassHtml($featherclass);
		}
	}
	elseif($qaddlist==6)//���ɵ�ǰ��Ŀ������Ŀ����ҳ
	{
		hReIndex();
		$featherclass=$class_r[$classid]['featherclass'];
		if(empty($featherclass))
		{
			$featherclass="|";
		}
		if(!$listdt)
		{
			$featherclass.=$classid."|";
		}
		hReClassHtml($featherclass);
	}
}

//������Ϣ������Ŀ
function hReClassHtml($sonclass){
	global $empire,$dbtbpre,$class_r;
	$r=explode("|",$sonclass);
	$count=count($r);
	for($i=1;$i<$count-1;$i++)
	{
		//�ռ���Ŀ
		if($class_r[$r[$i]]['islast'])
		{
			if(!$class_r[$r[$i]]['listdt'])
			{
				ListHtml($r[$i],'',0,$userlistr);
			}
		}
		elseif($class_r[$r[$i]]['islist']==1)//�б�ʽ����Ŀ
		{
			if(!$class_r[$r[$i]]['listdt'])
			{
				ListHtml($r[$i],'',3);
			}
		}
		elseif($class_r[$r[$i]]['islist']==3)//��Ŀ����Ϣ
		{
			ReClassBdInfo($r[$i]);
		}
		else//����Ŀ
		{
			$cr=$empire->fetch1("select classtempid from {$dbtbpre}enewsclass where classid='$r[$i]'");
			$classtemp=$class_r[$r[$i]]['islist']==2?GetClassText($r[$i]):GetClassTemp($cr['classtempid']);
			NewsBq($r[$i],$classtemp,0,0);
		}
	}
}

//������Ϣ������ҳ
function hReIndex(){
	$indextemp=GetIndextemp();
	NewsBq($classid,$indextemp,1,0);
}

//����ͬʱ����
function AddInfoToCopyInfo($classid,$id,$to_classid,$userid,$username,$usergroupr){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r,$lur;
	$classid=(int)$classid;
	$id=(int)$id;
	$cr=$to_classid;
	$count=count($cr);
	if(empty($classid)||empty($id)||empty($count))
	{
		return '';
	}
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//������
	$index_r=$empire->fetch1("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id='$id' limit 1");
	if(empty($index_r['id']))
	{
		return '';
	}
	//���ر�
	$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
	//����
	$r=$empire->fetch1("select * from ".$infotb." where id='$id'");
	//���ر���Ϣ
	$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
	//����
	$fr=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$infotbr['datatbname']." where id='$id' limit 1");
	$r=array_merge($r,$fr);
	if($stf)//����ı�
	{
		$r[newstext_url]=$r[$stf];
		$r[$stf]=GetTxtFieldText($r[$stf]);
	}
	//������Ϣ��ַ
	$copyinfourl=0;
	if($_POST['copyinfotitleurl']&&!$r['isurl'])
	{
		$r['titleurl']=sys_ReturnBqTitleLink($r);
		$r['isurl']=1;
		$copyinfourl=1;
	}
	$userisqf=EcmsReturnDoIsqf($userid,$username,$lur['groupid'],0);
	$ids=',';
	for($i=0;$i<$count;$i++)
	{
		$newclassid=(int)$cr[$i];
		//����Ȩ��
		if(empty($usergroupr['doall'])&&!strstr($usergroupr['add_adminclass'],'|'.$newclassid.'|'))
		{
			continue;
		}
		if(!$newclassid||!$class_r[$newclassid][islast]||$mid<>$class_r[$newclassid][modid]||$newclassid==$classid)
		{
			continue;
		}
		//�鿴Ŀ¼�Ƿ���ڣ�����������
		$newspath=FormatPath($newclassid,"",0);
		$newstempid=0;
		$copyids='1';
		//�����Զ����ֶ�
		$ret_r=ReturnAddF($r,$mid,$userid,$username,9,1,0);
		if($class_r[$newclassid][wfid])
		{
			if($userisqf)
			{
				$checked=$class_r[$newclassid][checked];
				$isqf=0;
			}
			else
			{
				$checked=0;
				$isqf=1;
			}
	    }
		else
		{
			$checked=$class_r[$newclassid][checked];
			$isqf=0;
	    }
		//�������
		if($usergroupr['domustcheck'])
		{
			$checked=0;
		}
		$checked=(int)$checked;
		//������
		$empire->query("insert into {$dbtbpre}ecms_".$tbname."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$newclassid','$checked','$r[newstime]','$r[truetime]','$r[truetime]','$r[havehtml]');");
		$l_id=$empire->lastid();
		$infotbr=ReturnInfoTbname($tbname,$checked,$ret_r['tb']);
		//����
		$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r[fields].") values('$l_id','$newclassid','$r[ttid]',0,0,0,'$newspath','$filename','$r[userid]','".StripAddsData($r[username])."',0,0,'$r[ispic]',0,'$isqf',0,'$r[isurl]','$r[truetime]',$r[truetime],$r[havehtml],$r[groupid],$r[userfen],'".StripAddsData($r[titlefont])."','".StripAddsData($r[titleurl])."','$ret_r[tb]','$public_r[filedeftb]','$public_r[pldeftb]','".StripAddsData($r[keyboard])."'".$ret_r[values].");");
		//����
		$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r[datafields].") values('$l_id','$newclassid','$r[keyid]',$r[dokey],'".$newstempid."',$r[closepl],0,''".$ret_r[datavalues].");");
		//������
		UpdateInfoCopyids($newclassid,$l_id,$copyids);
		//������Ŀ��Ϣ��
		AddClassInfos($newclassid,'+1','+1',$checked);
		//��������Ϣ��
		DoUpdateAddDataNum('info',$class_r[$newclassid]['tid'],1);
		//ǩ��
		if($isqf==1)
		{
			InfoInsertToWorkflow($l_id,$newclassid,$class_r[$newclassid][wfid],$userid,$username);
		}
		//�ļ�����
		$filename=ReturnInfoFilename($newclassid,$l_id,$r[filenameqz]);
		//��Ϣ��ַ
		$updateinfourl='';
		if(!$copyinfourl)
		{
			$infourl=GotoGetTitleUrl($newclassid,$l_id,$newspath,$filename,$r['groupid'],$r['isurl'],$r['titleurl']);
			$updateinfourl=",titleurl='$infourl'";
		}
		$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl." where id='$l_id' limit 1");
		//������
		DoMFun($class_r[$newclassid]['modid'],$newclassid,$l_id,1,0);
		//������Ϣ�ļ�
		if($checked)
		{
			$addr=$empire->fetch1("select * from ".$infotbr['tbname']." where id='$l_id' limit 1");
			GetHtml($addr['classid'],$addr['id'],$addr,1);
		}
		$ids.=$l_id.',';
		//���¶�̬����
		if($public_r['ctimeopen']&&$checked)
		{
			eUpCacheInfo(1,$newclassid,0,0,0,'','',0,0,1);
		}
    }
	if($ids==',')
	{
		$ids='';
	}
	return $ids;
}

//����ͬ���޸�
function EditInfoToCopyInfo($classid,$id,$userid,$username,$usergroupr){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($classid)||empty($id))
	{
		return '';
	}
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//������
	$pubid=ReturnInfoPubid($classid,$id);
	$pub_r=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid'");
	$cr=explode(',',$pub_r['copyids']);
	$count=count($cr);
	if($count<3)
	{
		return '';
	}
	//������
	$index_r=$empire->fetch1("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id='$id' limit 1");
	//���ر�
	$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
	//����
	$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
	//���ر���Ϣ
	$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
	//����
	$fr=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$infotbr['datatbname']."  where id='$id' limit 1");
	$r=array_merge($r,$fr);
	if($stf)//����ı�
	{
		$r[newstext_url]=$r[$stf];
		$r[$stf]=GetTxtFieldText($r[$stf]);
	}
	//��Ϣ���ӵ�ַ
	$titleurl=sys_ReturnBqTitleLink($r);
	for($i=1;$i<$count-1;$i++)
	{
		$infoid=(int)$cr[$i];
		if(empty($infoid))
		{
			continue;
		}
		//������
		$index_infor=$empire->fetch1("select classid,checked from {$dbtbpre}ecms_".$tbname."_index where id='$infoid' limit 1");
		//���ر�
		$update_infotb=ReturnInfoMainTbname($tbname,$index_infor['checked']);
		if($stf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$stf.','))
			{
				$infor=$empire->fetch1("select stb,isurl,newspath,filename from ".$update_infotb." where id='$infoid' limit 1");
				if(!$infor[stb])
				{
					continue;
				}
				//���ر���Ϣ
				$update_infotbr=ReturnInfoTbname($tbname,$index_infor['checked'],$infor['stb']);
				$infodr=$empire->fetch1("select ".$stf." from ".$update_infotbr['datatbname']." where id='$infoid' limit 1");
				$r[newstext_url]=$infodr[$stf];
			}
			else
			{
				$infor=$empire->fetch1("select ".$stf.",stb,isurl,newspath,filename from ".$update_infotb." where id='$infoid' limit 1");
				if(!$infor[stb])
				{
					continue;
				}
				$r[newstext_url]=$infor[$stf];
			}
		}
		else
		{
			$infor=$empire->fetch1("select stb,isurl,newspath,filename from ".$update_infotb." where id='$infoid' limit 1");
			if(!$infor[stb])
			{
				continue;
			}
		}
		if($infor['isurl'])
		{
			$r['titleurl']=$titleurl;
			$r['isurl']=1;
		}
		else
		{
			//��Ϣ��ַ
			$infourl=GotoGetTitleUrl($index_infor['classid'],$infoid,$infor['newspath'],$infor['filename'],$r['groupid'],$infor['isurl'],$r['titleurl']);
			$r['titleurl']=$infourl;
		}
		//�����Զ����ֶ�
		$ret_r=ReturnAddF($r,$mid,$userid,$username,8,1,0);
		//���ر���Ϣ
		$update_infotbr=ReturnInfoTbname($tbname,$index_infor['checked'],$infor['stb']);
		//������
		$empire->query("update {$dbtbpre}ecms_".$tbname."_index set checked='$index_r[checked]',newstime='$r[newstime]',lastdotime='$r[lastdotime]' where id='$infoid'");
		//����
		$empire->query("update ".$update_infotb." set ttid='$r[ttid]',ispic='$r[ispic]',isurl='$r[isurl]',lastdotime=$r[lastdotime],groupid=$r[groupid],userfen=$r[userfen],titlefont='".StripAddsData($r[titlefont])."',titleurl='".StripAddsData($r[titleurl])."',keyboard='".StripAddsData($r[keyboard])."'".$ret_r[values]." where id='$infoid'");
		//����
		$empire->query("update ".$update_infotbr['datatbname']." set keyid='$r[keyid]',dokey=$r[dokey],closepl=$r[closepl]".$ret_r[datavalues]." where id='$infoid'");
		//�Ƿ�ı����״̬
		if($index_infor['checked']!=$index_r['checked'])
		{
			MoveCheckInfoData($tbname,$index_infor['checked'],$infor['stb'],"id='$infoid'");
			//������Ŀ��Ϣ��
			if($index_r['checked'])
			{
				AddClassInfos($index_infor['classid'],'','+1');
			}
			else
			{
				AddClassInfos($index_infor['classid'],'','-1');
			}
		}
		//������
		DoMFun($class_r[$index_infor['classid']]['modid'],$index_infor['classid'],$infoid,0,0);
		if($index_r['checked'])
		{
			//������Ϣ�ļ�
			$addr=$empire->fetch1("select * from {$dbtbpre}ecms_".$tbname." where id='$infoid' limit 1");
			GetHtml($addr['classid'],$addr['id'],$addr,1);
		}
		//���¶�̬����
		if($public_r['ctimeopen']&&$index_r['checked'])
		{
			eUpCacheInfo(1,$index_infor['classid'],0,0,0,'','',0,0,1);
		}
	}
}

//����ͬ��ɾ��
function DelInfoToCopyInfo($classid,$id,$r,$userid,$username,$usergroupr,$pubcopyids){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($classid)||empty($id))
	{
		return '';
	}
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//������
	$pubid=ReturnInfoPubid($classid,$id);
	//$pub_r=$empire->fetch1("select copyids from {$dbtbpre}enewsinfovote where pubid='$pubid'");
	$cr=explode(',',$pubcopyids);
	$count=count($cr);
	if(empty($r['id'])||$count<3)
	{
		return '';
	}
	$selectdataf='';
	$dh='';
	if($stf&&strstr($emod_r[$mid]['tbdataf'],','.$stf.','))
	{
		$selectdataf.=$stf;
		$dh=',';
	}
	$pf=$emod_r[$mid]['pagef'];
	if($pf&&strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
	{
		$selectdataf.=$dh.$pf;
	}
	for($i=1;$i<$count-1;$i++)
	{
		$infoid=(int)$cr[$i];
		if(empty($infoid))
		{
			continue;
		}
		//������
		$index_infor=$empire->fetch1("select checked from {$dbtbpre}ecms_".$tbname."_index where id='$infoid' limit 1");
		//���ر�
		$update_infotb=ReturnInfoMainTbname($tbname,$index_infor['checked']);
		//����
		$infor=$empire->fetch1("select * from ".$update_infotb." where id='$infoid' limit 1");
		if(!$infor[stb])
		{
			continue;
		}
		//���ر���Ϣ
		$update_infotbr=ReturnInfoTbname($tbname,$index_infor['checked'],$infor['stb']);
		if($selectdataf)
		{
			$infodr=$empire->fetch1("select ".$selectdataf." from ".$update_infotbr['datatbname']." where id='$infoid' limit 1");
			$infor=array_merge($infor,$infodr);
		}
		//���ı�
		if($stf)
		{
			$newstextfile=$infor[$stf];
			$infor[$stf]=GetTxtFieldText($infor[$stf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		DelNewsFile($infor[filename],$infor[newspath],$infor[classid],$infor[$pf],$infor[groupid]);//ɾ����Ϣ�ļ�
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where id='$infoid'");
		$empire->query("delete from ".$update_infotbr['tbname']." where id='$infoid'");
		$empire->query("delete from ".$update_infotbr['datatbname']." where id='$infoid'");
		//������Ŀ��Ϣ��
		AddClassInfos($infor['classid'],'-1','-1',$index_infor['checked']);
		//ɾ���������¼�븽��
		DelSingleInfoOtherData($infor['classid'],$infoid,$infor,0,0);
		//���¶�̬����
		if($public_r['ctimeopen']&&$index_infor['checked'])
		{
			eUpCacheInfo(1,$infor['classid'],0,0,0,'','',0,0,1);
		}
	}
}

//��Ϣ�ö�
function TopNews_all($classid,$id,$istop,$userid,$username){
	global $empire,$bclassid,$class_r,$dbtbpre,$public_r;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");//��֤Ȩ��
	if(!$doselfinfo['dogoodinfo'])//Ȩ��
	{
		printerror("NotGoodInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotTopNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	$infotb='';
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		$add.="id='".$infoid."' or ";
		if($infoid&&empty($infotb))
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$infoid' limit 1");
			//���ر�
			$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($classid,$infoid);
			$dolog="classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>id=".$infoid;
		}
	}
	if(empty($infotb))
	{
		printerror("NotTopNewsid","history.go(-1)");
	}
	$istop=(int)$istop;
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update ".$infotb." set istop=$istop where ".$add);
	if($index_r['checked'])
	{
		//ˢ���б�
		ReListHtml($classid,1);
	}
	//���¶�̬����
	if($public_r['ctimeopen']&&$index_r['checked'])
	{
		eUpCacheInfo(1,$classid,0,0,0,'','',0,0);
	}
	if($sql)
	{
		//������־
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
		}
		printerror("TopNewsSuccess",EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�����Ϣ
function CheckNews_all($classid,$id,$userid,$username){
	global $empire,$class_r,$dbtbpre,$emod_r,$adddatar,$public_r;
	$classid=(int)$classid;
	$userid=(int)$userid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//��֤Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//Ȩ��
	if(!$doselfinfo['docheckinfo'])
	{
		printerror("NotCheckInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotCheckNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//�������Ӳ���
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$add='';
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		if(empty($infoid))
		{
			continue;
		}
		$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$infoid' limit 1");
		if(!$infor['id']||$infor['isqf']==1)
		{
			continue;
		}
		$sql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$infoid'");
		//Ͷ�����ӻ���
		if($infor['ismember']&&$infor['userid'])
		{
			$cr=$empire->fetch1("select classid,addinfofen from {$dbtbpre}enewsclass where classid='$infor[classid]'");
			if($cr['addinfofen'])
			{
				$finfor=$empire->fetch1("select haveaddfen from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check_data where id='$infoid' limit 1");
				if(!$finfor['haveaddfen'])
				{
					AddInfoFen($cr[addinfofen],$infor[userid]);
					if($cr['addinfofen']<0)
					{
						BakDown($infor[classid],$infor[id],0,$infor[userid],$infor[username],$infor[title],abs($cr[addinfofen]),3);
					}
				}
			}
			$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check_data set haveaddfen=1 where id='$infoid'");
		}
		//δ��˱�ת��
		MoveCheckInfoData($class_r[$classid][tbname],0,$infor['stb'],"id='$infoid'");
		//�����
		if(!$infor['eckuid']&&($infor['ismember']||$infor['userid']!=$userid))
		{
			$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]." set eckuid='$userid' where id='$infoid'");
		}
		//������Ŀ��Ϣ��
		AddClassInfos($infor['classid'],'','+1');
		//ˢ����Ϣ
		GetHtml($infor['classid'],$infor['id'],$infor,1);
		//���¶�̬����
		if($public_r['ctimeopen'])
		{
			eUpCacheInfo(1,$infor['classid'],0,0,$infor['ttid'],'',$infor['infotags'],0,0,1);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($infor['classid'],$infor['id']);
			$dolog="classid=".$infor['classid']."<br>id=".$infor['id']."<br>title=".$infor['title'];
		}
    }
	//ˢ���б�
	//ReListHtml($classid,1);
	$returl=EcmsGetReturnUrl();
	//����֪ͨ
	if($adddatar['causetext']&&$infoid)
	{
		if(!$infor['id'])
		{
			$infor=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$infoid' limit 1");
		}
		DoInfoSendNotice($userid,$username,$infor['userid'],$infor['username'],$adddatar['causetext'],$infor,2);
		if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
		{
			$returl=$adddatar['ecmsfrom'];
		}
		else
		{
			$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
		}
	}
	//������־
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
	}
	printerror("CheckNewsSuccess",$returl);
}

//ȡ�������Ϣ
function NoCheckNews_all($classid,$id,$userid,$username){
	global $empire,$class_r,$public_r,$dbtbpre,$emod_r,$adddatar;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//��֤Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//Ȩ��
	if(!$doselfinfo['docheckinfo'])
	{
		printerror("NotCheckInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotNoCheckNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//�������Ӳ���
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$pf=$emod_r[$mid]['pagef'];
	$stf=$emod_r[$mid]['savetxtf'];
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		//����
		$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$infoid' limit 1");
		if(!$r['id']||$r['isqf']==1)
		{
			continue;
		}
		$sql=$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=0 where id='$infoid'");
		//δ��˻�ת
		MoveCheckInfoData($class_r[$classid][tbname],1,$r['stb'],"id='$infoid'");
		//������Ŀ��Ϣ��
		AddClassInfos($r['classid'],'','-1');
		//��ҳ�ֶ�
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$infoid'");
				$r[$pf]=$finfor[$pf];
			}
			if($stf&&$stf==$pf)//����ı�
			{
				$r[$pf]=GetTxtFieldText($r[$pf]);
			}
		}
		DelNewsFile($r[filename],$r[newspath],$r[classid],$r[$pf],$r[groupid]);
		//���¶�̬����
		if($public_r['ctimeopen'])
		{
			eUpCacheInfo(1,$r['classid'],0,0,$r['ttid'],'',$r['infotags'],0,0,1);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$r['id']);
			$dolog="classid=".$r['classid']."<br>id=".$r['id']."<br>title=".$r['title'];
		}
	}
	//ˢ���б�
	ReListHtml($classid,1);
	$returl=EcmsGetReturnUrl();
	//����֪ͨ
	if($adddatar['causetext']&&$infoid)
	{
		if(!$r['id'])
		{
			$r=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$infoid' limit 1");
		}
		DoInfoSendNotice($userid,$username,$r['userid'],$r['username'],$adddatar['causetext'],$r,3);
		if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
		{
			$returl=$adddatar['ecmsfrom'];
		}
		else
		{
			$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
		}
	}
	//������־
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
	}
	printerror("NoCheckNewsSuccess",$returl);
}

//�ƶ���Ϣ
function MoveNews_all($classid,$id,$to_classid,$userid,$username){
	global $empire,$class_r,$dbtbpre,$emod_r,$adddatar,$public_r;
	$classid=(int)$classid;
	$to_classid=(int)$to_classid;
	if(empty($classid)||empty($to_classid))
	{
		printerror("EmptyMoveClassid","history.go(-1)");
	}
	if(empty($class_r[$classid][islast])||empty($class_r[$to_classid][islast]))
	{
		printerror("EmptyMoveClassid","history.go(-1)");
	}
	if($class_r[$classid][modid]<>$class_r[$to_classid][modid])
	{
		printerror("DefModid","history.go(-1)");
    }
	//��֤Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//Ȩ��
	if(!$doselfinfo['domoveinfo'])
	{
		printerror("NotMoveInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotMoveNewsid","history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	//�������Ӳ���
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$infotb='';
	$tbname=$class_r[$classid][tbname];
	for($i=0;$i<$count;$i++)
	{
		$id[$i]=(int)$id[$i];
		$add.="id='".$id[$i]."' or ";
		if(empty($infotb))
		{
			//������
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$tbname."_index where id='".$id[$i]."' limit 1");
			//���ر�
			$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
		}
		//����
		$r=$empire->fetch1("select stb,classid,fstb,restb,id,isurl,filename,groupid,newspath,titleurl,title,ismember,userid,username,newstime,truetime,ttid from ".$infotb." where id='".$id[$i]."' limit 1");
		$pubid=ReturnInfoPubid($r['classid'],$id[$i]);
		//��Ϣ��ַ
		$infourl=GotoGetTitleUrl($to_classid,$id[$i],$r['newspath'],$r['filename'],$r['groupid'],$r['isurl'],$r['titleurl']);
		//���ر���Ϣ
		$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
		//����
		$empire->query("update ".$infotb." set classid='$to_classid',titleurl='$infourl' where id='".$id[$i]."'");
		//����
		$empire->query("update ".$infotbr['datatbname']." set classid='$to_classid' where id='".$id[$i]."'");
		//������Ŀ��Ϣ��
		AddClassInfos($r['classid'],'-1','-1',$index_r['checked']);
		AddClassInfos($to_classid,'+1','+1',$index_r['checked']);
		//������Ϣ���ӱ�
		UpdateSingleInfoOtherData($r['classid'],$id[$i],$to_classid,$r,0,0);
		//���¶�̬����
		if($public_r['ctimeopen']&&$index_r['checked'])
		{
			eUpCacheInfo(1,$r['classid'],0,0,$r['ttid'],'','',$to_classid,0,1);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$id[$i]);
			$dolog="classid=".$r['classid']."<br>classname=".$class_r[$r['classid']][classname]."<br>id=".$id[$i]."<br>to_classid=".$to_classid;
		}
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update {$dbtbpre}ecms_".$tbname."_index set classid='$to_classid' where ".$add);
	//ˢ���б�
	ReListHtml($classid,1);
	ReListHtml($to_classid,1);
	$returl=EcmsGetReturnUrl();
	//����֪ͨ
	if($donum==1&&$r['id'])
	{
		DoInfoSendNotice($userid,$username,$r['userid'],$r['username'],$adddatar['causetext'],$r,4);
		if($adddatar['causetext'])
		{
			if($adddatar['ecmsfrom']&&(stristr($adddatar['ecmsfrom'],'ListNews.php')||stristr($adddatar['ecmsfrom'],'ListAllInfo.php')))
			{
				$returl=$adddatar['ecmsfrom'];
			}
			else
			{
				$returl="ListNews.php?bclassid=$adddatar[bclassid]&classid=$adddatar[classid]".$addecmscheck.hReturnEcmsHashStrHref2(0);
			}
		}
	}
	if($sql)
	{
		//������־
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>to_classid=".$to_classid);
		}
		printerror("MoveNewsSuccess",$returl);
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//������Ϣ
function CopyNews_all($classid,$id,$to_classid,$userid,$username){
	global $empire,$public_r,$class_r,$dbtbpre,$emod_r,$lur;
	$classid=(int)$classid;
	$to_classid=(int)$to_classid;
	if(empty($classid)||empty($to_classid))
	{
		printerror("EmptyCopyClassid","history.go(-1)");
	}
	if(empty($class_r[$classid][islast])||empty($class_r[$to_classid][islast]))
	{
		printerror("EmptyCopyClassid","history.go(-1)");
	}
	if($class_r[$classid][modid]<>$class_r[$to_classid][modid])
	{
		printerror("DefModid","history.go(-1)");
    }
	$userid=(int)$userid;
	//��֤Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//Ȩ��
	if(!$doselfinfo['domoveinfo'])
	{
		printerror("NotMoveInfoLevel","history.go(-1)");
	}
	$count=count($id);
	if(empty($count))
	{
		printerror("NotCopyNewsid","history.go(-1)");
	}
	$userisqf=EcmsReturnDoIsqf($userid,$username,$lur['groupid'],0);
	$dopubid=0;
	$donum=0;
	$dolog='';
	//�������Ӳ���
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	for($i=0;$i<$count;$i++)
	{
		$add.="id='".intval($id[$i])."' or ";
    }
	$add=substr($add,0,strlen($add)-4);
	$mid=$class_r[$classid][modid];
	$tbname=$class_r[$classid][tbname];
	$stf=$emod_r[$mid]['savetxtf'];
	//�鿴Ŀ¼�Ƿ���ڣ�����������
	$newspath=FormatPath($to_classid,"",0);
    $newstime=time();
    $truetime=$newstime;
	$newstempid=0;
	$dosql=$empire->query("select id,classid,checked from {$dbtbpre}ecms_".$tbname."_index where ".$add);
	while($index_r=$empire->fetch($dosql))
	{
		//���ر�
		$infotb=ReturnInfoMainTbname($tbname,$index_r['checked']);
		//����
		$r=$empire->fetch1("select * from ".$infotb." where id='$index_r[id]' limit 1");
		//���ر���Ϣ
		$infotbr=ReturnInfoTbname($tbname,$index_r['checked'],$r['stb']);
		//����
		$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$infotbr['datatbname']." where id='$r[id]' limit 1");
		$r=array_merge($r,$finfor);
		if($stf)//����ı�
		{
			$r[$stf]=GetTxtFieldText($r[$stf]);
		}
		//�����Զ����ֶ�
		$ret_r=ReturnAddF($r,$class_r[$to_classid][modid],$userid,$username,9,1,0);
		if($class_r[$to_classid][wfid])
		{
			if($userisqf)
			{
				$checked=$class_r[$to_classid][checked];
				$isqf=0;
			}
			else
			{
				$checked=0;
				$isqf=1;
			}
	    }
		else
		{
			$checked=$class_r[$to_classid][checked];
			$isqf=0;
	    }
		$checked=(int)$checked;
		//������
		$empire->query("insert into {$dbtbpre}ecms_".$tbname."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$to_classid','$checked','$r[newstime]','$truetime','$truetime','$r[havehtml]');");
		$l_id=$empire->lastid();
		$update_infotbr=ReturnInfoTbname($tbname,$checked,$ret_r['tb']);
		//����
		$sql=$empire->query("insert into ".$update_infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r[fields].") values('$l_id','$to_classid','$r[ttid]',0,0,0,'$newspath','$filename',$userid,'$username',0,0,'$r[ispic]',0,'$isqf',0,'$r[isurl]',$truetime,$truetime,$r[havehtml],$r[groupid],$r[userfen],'$r[titlefont]','$r[titleurl]','$ret_r[tb]','$public_r[filedeftb]','$public_r[pldeftb]','$r[keyboard]'".$ret_r[values].");");		
		//����
		$empire->query("insert into ".$update_infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r[datafields].") values('$l_id','$to_classid','$r[keyid]',$r[dokey],'".$newstempid."',$r[closepl],0,'$r[infotags]'".$ret_r[datavalues].");");
		//ǩ��
		if($isqf==1)
		{
			InfoInsertToWorkflow($l_id,$to_classid,$class_r[$to_classid][wfid],$userid,$username);
		}
		//�ļ�����
		$filename=ReturnInfoFilename($to_classid,$l_id,$r[filenameqz]);
		//��Ϣ��ַ
		$updateinfourl='';
		if(!$r['isurl'])
		{
			$infourl=GotoGetTitleUrl($to_classid,$l_id,$newspath,$filename,$r['groupid'],$r['isurl'],$r['titleurl']);
			$updateinfourl=",titleurl='$infourl'";
		}
		$usql=$empire->query("update ".$update_infotbr['tbname']." set filename='$filename'".$updateinfourl." where id='$l_id'");
		//������Ŀ��Ϣ��
		AddClassInfos($to_classid,'+1','+1',$checked);
		//������Ϣ�ļ�
		if($checked)
		{
			$addr=$empire->fetch1("select * from ".$update_infotbr['tbname']." where id='$l_id'");
			GetHtml($addr['classid'],$addr['id'],$addr,1);
		}
		//���¶�̬����
		if($public_r['ctimeopen']&&$checked)
		{
			eUpCacheInfo(1,$to_classid,0,0,$r['ttid'],'',$r[infotags],0,0,1);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($r['classid'],$r['id']);
			$dolog="classid=".$r['classid']."<br>id=".$r['id']."<br>title=".$r['title']."<br>to_classid=".$to_classid;
		}
	}
	//ˢ���б�
	ReListHtml($to_classid,1);
	//������־
	if($donum==1)
	{
		insert_dolog($dolog,$dopubid);
	}
	else
	{
		insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>to_classid=".$to_classid);
	}
	printerror("CopyNewsSuccess",EcmsGetReturnUrl());
}

//����ת����Ϣ
function MoveClassNews($add,$userid,$username){
	global $empire,$class_r,$dbtbpre,$emod_r,$public_r;
	$add[classid]=(int)$add[classid];
	$add[toclassid]=(int)$add[toclassid];
	if(empty($add[classid])||empty($add[toclassid]))
	{
		printerror("EmptyMovetoClassid","history.go(-1)");
	}
	if($class_r[$add[classid]][modid]<>$class_r[$add[toclassid]][modid])
	{
		printerror("DefModid","history.go(-1)");
    }
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"movenews");
	//�ռ���Ŀ
	if(!$class_r[$add[classid]][islast]||!$class_r[$add[toclassid]][islast])
	{
		printerror("MovetoClassidMustLastid","history.go(-1)");
	}
	if($add[classid]==$add[toclassid])
	{
		printerror("MoveClassidsame","history.go(-1)");
	}
	$mid=$class_r[$add[classid]][modid];
	$tbname=$class_r[$add[classid]][tbname];
	//����
	$indexsql=$empire->query("update {$dbtbpre}ecms_".$tbname."_index set classid=$add[toclassid] where classid='$add[classid]'");
	$sql=$empire->query("update {$dbtbpre}ecms_".$tbname." set classid=$add[toclassid] where classid='$add[classid]'");
	$empire->query("update {$dbtbpre}ecms_".$tbname."_check set classid=$add[toclassid] where classid='$add[classid]'");
	$empire->query("update {$dbtbpre}ecms_".$tbname."_doc set classid=$add[toclassid] where classid='$add[classid]'");
	//����
	UpdateAllDataTbField($tbname,"classid='$add[toclassid]'"," where classid='$add[classid]'",1,1);
	//������Ŀ��Ϣ��
	$cr=$empire->fetch1("select classid,allinfos,infos from {$dbtbpre}enewsclass where classid='$add[classid]'");
	AddClassInfos($add[classid],'-'.$cr[allinfos],'-'.$cr[infos]);
	$tocr=$empire->fetch1("select classid,allinfos,infos from {$dbtbpre}enewsclass where classid='$add[toclassid]'");
	AddClassInfos($add[toclassid],'+'.$cr[allinfos],'+'.$cr[infos]);
	//������Ϣ���ӱ��븽����
	UpdateMoreInfoOtherData($add[classid],$add[toclassid],0,0);
	//������Ϣ�б�
	ListHtml($add[toclassid],$ret_r,0);
	//���¶�̬����
	if($public_r['ctimeopen'])
	{
		eUpCacheInfo(1,$add['classid'],0,0,0,'','',$add['toclassid'],0);
	}
	//�ƶ�����
	$opath=ECMS_PATH.$class_r[$add[classid]][classpath];
    DelPath($opath);//ɾ���ɵ���ĿĿ¼
	$mk=DoMkdir($opath);
	if($sql)
	{
		//������־
		insert_dolog("classid=".$add[classid]."&nbsp;(".$class_r[$add[classid]][classname].")<br>toclassid=".$add[toclassid]."(".$class_r[$add[toclassid]][classname].")");
		printerror("MoveClassNewsSuccess","MoveClassNews.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�����Ƽ�/ͷ����Ϣ
function GoodInfo_all($classid,$id,$isgood,$doing=0,$userid,$username){
	global $empire,$class_r,$dbtbpre,$public_r;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//��֤Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//Ȩ��
	if(!$doselfinfo['dogoodinfo'])
	{
		printerror("NotGoodInfoLevel","history.go(-1)");
	}
	//�������Ӳ���
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$isgood=(int)$isgood;
	$doing=(int)$doing;
	if($doing==0)//�Ƽ�
	{
		if(!eFirstTitleCheckLevel($isgood,0))
		{
			printerror("NotGoodInfoLevel","history.go(-1)");
		}
		$mess="EmptyGoodInfoId";
		$domess="GoodInfoSuccess";
		$setf="isgood=$isgood";
	}
	else//ͷ��
	{
		if(!eFirstTitleCheckLevel($isgood,1))
		{
			printerror("NotGoodInfoLevel","history.go(-1)");
		}
		$mess="EmptyFirsttitleInfoId";
		$domess="FirsttitleInfoSuccess";
		$setf="firsttitle=$isgood";
	}
	$count=count($id);
	if(empty($count))
	{
		printerror($mess,"history.go(-1)");
	}
	$dopubid=0;
	$donum=0;
	$dolog='';
	$infotb='';
	for($i=0;$i<$count;$i++)
	{
		$infoid=(int)$id[$i];
		$add.="id='".$infoid."' or ";
		if($infoid&&empty($infotb))
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$infoid' limit 1");
			//���ر�
			$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
		}
		$donum++;
		if($donum==1)
		{
			$dopubid=ReturnInfoPubid($classid,$infoid);
			$dolog="classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>id=".$infoid."&doing=$doing";
		}
    }
	if(empty($infotb))
	{
		printerror($mess,"history.go(-1)");
	}
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("update ".$infotb." set ".$setf." where ".$add);
	if($sql)
	{
		//������־
		if($donum==1)
		{
			insert_dolog($dolog,$dopubid);
		}
		else
		{
			insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]."<br>doing=".$doing);
		}
		printerror($domess,EcmsGetReturnUrl());
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//����Ŀ��Ϣȫ�����
function SetAllCheckInfo($bclassid,$classid,$userid,$username){
	global $empire,$dbtbpre,$class_r,$public_r;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//��֤Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//Ȩ��
	if(!$doselfinfo['docheckinfo'])
	{
		printerror("NotCheckInfoLevel","history.go(-1)");
	}
	//�������Ӳ���
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$sql=$empire->query("select id,classid,userid,ismember,isqf,stb from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where classid='$classid'");
	$n=0;
	while($r=$empire->fetch($sql))
	{
		//ֻ�ܲ����Լ�����Ϣ
		if($doselfinfo['doselfinfo']&&($userid!=$r['userid']||$r['ismember']==1))
		{
			continue;
		}
		if($r['isqf']==1)
		{
			continue;
		}
		$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$r[id]'");
		//��˱�ת��
		MoveCheckInfoData($class_r[$classid][tbname],0,$r['stb'],"id='$r[id]'");
		$n++;
	}
	//���¶�̬����
	if($public_r['ctimeopen']&&$n)
	{
		eUpCacheInfo(1,$classid,0,0,0,'','',0,0);
	}
	//������Ŀ��Ϣ��
	AddClassInfos($classid,'','+'.$n);
	//������־
	insert_dolog("classid=".$classid."<br>classname=".$class_r[$classid][classname]);
	printerror("CheckNewsSuccess",EcmsGetReturnUrl());
}

//ǩ����Ϣ
function DoWfInfo($add,$userid,$username){
	global $empire,$dbtbpre,$class_r,$emod_r,$lur,$public_r;
	$id=(int)$add[id];
	$classid=(int)$add[classid];
	$doing=(int)$add['doing'];
	if(!$id||!$classid||!$doing)
	{
		printerror('EmptyDoWfInfo','');
	}
	$wfinfor=$empire->fetch1("select id,checknum,wfid,tid,groupid,userclass,username,checktno from {$dbtbpre}enewswfinfo where id='$id' and classid='$classid' limit 1");
	if(!$wfinfor[id])
	{
		printerror('ErrorUrl','');
	}
	if($wfinfor[checktno]=='100'||$wfinfor[checktno]=='101'||$wfinfor[checktno]=='102')
	{
		printerror('DoWfInfoOver','');
	}
	$wfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where tid='$wfinfor[tid]'");
	if(!(strstr(','.$wfitemr[groupid].',',','.$lur[groupid].',')||strstr(','.$wfitemr[userclass].',',','.$lur[classid].',')||strstr(','.$wfitemr[username].',',','.$lur[username].',')))
	{
		printerror("NotDoCheckUserLevel","history.go(-1)");
	}
	if(!(strstr(','.$wfinfor[groupid].',',','.$lur[groupid].',')||strstr(','.$wfinfor[userclass].',',','.$lur[classid].',')||strstr(','.$wfinfor[username].',',','.$lur[username].',')))
	{
		printerror("HaveDoWfInfo","history.go(-1)");
	}
	$pubid=ReturnInfoPubid($classid,$id);
	//�������Ӳ���
	$addecmscheck=empty($_POST['ecmscheck'])?'&ecmscheck=1':'';
	$checktext=hRepPostStr($add[checktext],1);
	if($doing==1)//ͨ��
	{
		if($wfitemr[lztype]==0)//��ǩ
		{
			if($wfitemr['tno']=='100')//ȫ��ͨ��
			{
				$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$id'");
				$ar=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$id'");
				//δ��˱�ת��
				MoveCheckInfoData($class_r[$classid][tbname],0,$ar['stb'],"id='$id'");
				//������Ŀ��Ϣ��
				AddClassInfos($classid,'','+1');
				$empire->query("update {$dbtbpre}enewswfinfo set tstatus='',checktno='100' where id='$id' and classid='$classid' limit 1");
				//��־
				InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
				//����
				GetHtml($ar['classid'],$ar['id'],$ar,1);
				ListHtml($classid,$fr,0);
				//���¶�̬����
				if($public_r['ctimeopen'])
				{
					eUpCacheInfo(1,$ar['classid'],0,0,$ar['ttid'],'','',0,0);
				}
			}
			else//��ת
			{
				$newwfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfitemr[wfid]' and tno>$wfitemr[tno] order by tno limit 1");
				$empire->query("update {$dbtbpre}enewswfinfo set tid='$newwfitemr[tid]',groupid='$newwfitemr[groupid]',userclass='$newwfitemr[userclass]',username='$newwfitemr[username]',tstatus='$newwfitemr[tstatus]',checktno='0' where id='$id' and classid='$classid' limit 1");
				//��־
				InsertWfLog($classid,$id,$newwfitemr[wfid],$newwfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
			}
		}
		else//��ǩ
		{
			$newgroupid=str_replace(','.$lur[groupid].',',',',$wfinfor[groupid]);
			$newuserclass=str_replace(','.$lur[classid].',',',',$wfinfor[userclass]);
			$newusername=str_replace(','.$lur[username].',',',',$wfinfor[username]);
			//��һ���ڵ�
			if(($newgroupid==''||$newgroupid==',')&&($newuserclass==''||$newuserclass==',')&&($newusername==''||$newusername==','))
			{
				if($wfitemr['tno']=='100')//ȫ��ͨ��
				{
					$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index set checked=1 where id='$id'");
					$ar=$empire->fetch1("select * from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_check where id='$id'");
					//δ��˱�ת��
					MoveCheckInfoData($class_r[$classid][tbname],0,$ar['stb'],"id='$id'");
					//������Ŀ��Ϣ��
					AddClassInfos($classid,'','+1');
					$empire->query("update {$dbtbpre}enewswfinfo set tstatus='',checktno='100' where id='$id' and classid='$classid' limit 1");
					//��־
					InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
					//����
					GetHtml($ar['classid'],$ar['id'],$ar,1);
					ListHtml($classid,$fr,0);
					//���¶�̬����
					if($public_r['ctimeopen'])
					{
						eUpCacheInfo(1,$ar['classid'],0,0,$ar['ttid'],'','',0,0);
					}
				}
				else//��ת
				{
					$newwfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfitemr[wfid]' and tno>$wfitemr[tno] order by tno limit 1");
					$empire->query("update {$dbtbpre}enewswfinfo set tid='$newwfitemr[tid]',groupid='$newwfitemr[groupid]',userclass='$newwfitemr[userclass]',username='$newwfitemr[username]',tstatus='$newwfitemr[tstatus]',checktno='0' where id='$id' and classid='$classid' limit 1");
					//��־
					InsertWfLog($classid,$id,$newwfitemr[wfid],$newwfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
				}
			}
			else//���ڵ����
			{
				$empire->query("update {$dbtbpre}enewswfinfo set groupid='$newgroupid',userclass='$newuserclass',username='$newusername' where id='$id' and classid='$classid' limit 1");
				//��־
				InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],1);
			}
		}
		$mess='DoWfInfoCkSuccess';
	}
	elseif($doing==2)//����
	{
		if(empty($checktext))
		{
			printerror('EmptyChecktext','history.go(-1)');
		}
		if($wfitemr[tbdo]==0)//��������
		{
			$empire->query("update {$dbtbpre}enewswfinfo set tid=0,tstatus='',checktno='101' where id='$id' and classid='$classid' limit 1");
		}
		else//�����ڵ�
		{
			$newwfitemr=$empire->fetch1("select tid,wfid,tno,groupid,userclass,username,lztype,tbdo,tddo,tstatus from {$dbtbpre}enewsworkflowitem where wfid='$wfitemr[wfid]' and tid='$wfitemr[tbdo]' limit 1");
			$empire->query("update {$dbtbpre}enewswfinfo set tid='$newwfitemr[tid]',groupid='$newwfitemr[groupid]',userclass='$newwfitemr[userclass]',username='$newwfitemr[username]',tstatus='$newwfitemr[tstatus]',checktno='101' where id='$id' and classid='$classid' limit 1");
		}
		//��־
		InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],2);
		$mess='DoWfInfoTbSuccess';
	}
	else//���
	{
		if(empty($checktext))
		{
			printerror('EmptyChecktext','history.go(-1)');
		}
		$empire->query("update {$dbtbpre}enewswfinfo set tid=0,tstatus='',checktno='102' where id='$id' and classid='$classid' limit 1");
		//��־
		InsertWfLog($classid,$id,$wfitemr[wfid],$wfitemr[tid],$username,$checktext,$wfinfor[checknum],3);
		if($wfitemr[tddo])//ɾ����Ϣ
		{
			$index_r=$empire->fetch1("select checked from {$dbtbpre}ecms_".$class_r[$classid][tbname]."_index where id='$id' limit 1");
			//���ر�
			$infotb=ReturnInfoMainTbname($class_r[$classid][tbname],$index_r['checked']);
			$r=$empire->fetch1("select * from ".$infotb." where id='$id' limit 1");
			$mid=$class_r[$classid][modid];
			$tbname=$class_r[$classid][tbname];
			$pf=$emod_r[$mid]['pagef'];
			$stf=$emod_r[$mid]['savetxtf'];
			//���ر���Ϣ
			$infotbr=ReturnInfoTbname($class_r[$classid][tbname],$index_r['checked'],$r['stb']);
			//��ҳ�ֶ�
			if($pf)
			{
				if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
				{
					$finfor=$empire->fetch1("select ".$pf." from ".$infotbr['datatbname']." where id='$id' limit 1");
					$r[$pf]=$finfor[$pf];
				}
			}
			//���ı�
			if($stf)
			{
				$newstextfile=$r[$stf];
				$r[$stf]=GetTxtFieldText($r[$stf]);
				DelTxtFieldText($newstextfile);//ɾ���ļ�
			}
			DelNewsFile($r[filename],$r[newspath],$classid,$r[$pf],$r[groupid]);//ɾ����Ϣ�ļ�
			$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where id='$id'");
			$sql=$empire->query("delete from ".$infotbr['tbname']." where id='$id'");
			$fsql=$empire->query("delete from ".$infotbr['datatbname']." where id='$id'");
			//������Ŀ��Ϣ��
			AddClassInfos($r[classid],'-1','-1',$index_r['checked']);
			//ɾ���������¼�븽��
			DelSingleInfoOtherData($r['classid'],$id,$r,0,0);
		}
		$mess='DoWfInfoTdSuccess';
		$isclose=1;
	}
	//������־
	insert_dolog("classid=$classid&id=$id",$pubid);
	printerror($mess,"workflow/DoWfInfo.php?classid=$classid&id=$id&isclose=$isclose".hReturnEcmsHashStrHref2(0));
}

//����ɾ����Ϣ
function DelInfoData($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$add,$userid,$username){
	global $empire,$public_r,$class_r,$fun_r,$dbtbpre,$emod_r;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"delinfodata");
	$search='';
	$start=(int)$start;
	$tbname=RepPostVar($tbname);
	if(empty($tbname))
	{
		printerror("ErrorUrl","history.go(-1)");
    }
	$search.="&tbname=$tbname";
	//��ѯ��
	$infotb="{$dbtbpre}ecms_".$tbname;
	//����Ŀ
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
		$search.="&classid=$classid";
    }
	//��IDˢ��
	$search.="&retype=$retype";
	if($retype)
	{
		$startid=(int)$startid;
		$endid=(int)$endid;
		if($endid)
		{
			$add1.=" and id>=$startid and id<=$endid";
	    }
		$search.="&startid=$startid&endid=$endid";
    }
	else
	{
		$startday=RepPostVar($startday);
		$endday=RepPostVar($endday);
		if($startday&&$endday)
		{
			$add1.=" and truetime>=".to_time($startday." 00:00:00")." and truetime<=".to_time($endday." 23:59:59");
	    }
		$search.="&startday=$startday&endday=$endday";
    }
	//��Ϣ����
	$delckinfo=0;
	$infost=(int)$add['infost'];
	if($infost)
	{
		if($infost==1)//�����
		{
			$delckinfo=1;
		}
		else//δ���
		{
			$infotb="{$dbtbpre}ecms_".$tbname."_check";
			$delckinfo=2;
		}
		$search.="&infost=$infost";
	}
	else
	{
		$dodelcheck=(int)$add['dodelcheck'];
		if($dodelcheck)
		{
			$infotb="{$dbtbpre}ecms_".$tbname."_check";
			$delckinfo=2;
			$search.="&dodelcheck=1";
		}
	}
	//�û�����
	$ismember=(int)$add['ismember'];
	if($ismember)
	{
		if($ismember==1)//�ο�
		{
			$add1.=" and userid=0";
		}
		elseif($ismember==2)//��Ա+�û�
		{
			$add1.=" and userid>0";
		}
		elseif($ismember==3)//��Ա
		{
			$add1.=" and userid>0 and ismember=1";
		}
		elseif($ismember==4)//�û�
		{
			$add1.=" and userid>0 and ismember=0";
		}
		$search.="&ismember=$ismember";
	}
	//�Ƿ��ⲿ����
	$isurl=(int)$add['isurl'];
	if($isurl)
	{
		if($isurl==1)//�ⲿ����
		{
			$add1.=" and isurl=1";
		}
		else//�ڲ���Ϣ
		{
			$add1.=" and isurl=0";
		}
		$search.="&isurl=$isurl";
	}
	//������
	$plnum=(int)$add['plnum'];
	if($plnum)
	{
		$add1.=" and plnum<".$plnum;
		$search.="&plnum=$plnum";
	}
	//�����
	$onclick=(int)$add['onclick'];
	if($onclick)
	{
		$add1.=" and onclick<".$onclick;
		$search.="&onclick=$onclick";
	}
	//������
	$totaldown=(int)$add['totaldown'];
	if($totaldown)
	{
		$add1.=" and totaldown<".$totaldown;
		$search.="&totaldown=$totaldown";
	}
	//�û�ID
	$userids=RepPostVar($add['userids']);
	$usertype=(int)$add['usertype'];
	if($userids)
	{
		$uidsr=explode(',',$userids);
		$uidscount=count($uidsr);
		$uids='';
		$udh='';
		for($ui=0;$ui<$uidscount;$ui++)
		{
			$uids.=$udh.intval($uidsr[$ui]);
			$udh=',';
		}
		if($usertype==1)//�û�
		{
			$add1.=" and userid in (".$uids.") and ismember=0";
		}
		else//��Ա
		{
			$add1.=" and userid in (".$uids.") and ismember=1";
		}
		$search.="&userids=$userids&usertype=$usertype";
	}
	//����
	$title=RepPostStr($add['title']);
	if($title)
	{
		$titler=explode('|',$title);
		$titlecount=count($titler);
		$titlewhere='';
		$titleor='';
		for($ti=0;$ti<$titlecount;$ti++)
		{
			$titlewhere.=$titleor."title like '%".$titler[$ti]."%'";
			$titleor=' or ';
		}
		$add1.=" and (".$titlewhere.")";
		$search.="&title=$title";
	}
	$b=0;
	$sql=$empire->query("select * from ".$infotb." where id>$start".$add1." order by id limit ".$public_r[delnewsnum]);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r[id];
		$mid=$class_r[$r[classid]]['modid'];
		$pf=$emod_r[$mid]['pagef'];
		$stf=$emod_r[$mid]['savetxtf'];
		//δ��˱�
		if($delckinfo==2)
		{
			$infodatatb="{$dbtbpre}ecms_".$tbname."_check_data";
		}
		else
		{
			$infodatatb="{$dbtbpre}ecms_".$tbname."_data_".$r['stb'];
		}
		//��ҳ�ֶ�
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				$finfor=$empire->fetch1("select ".$pf." from ".$infodatatb." where id='$r[id]' limit 1");
				$r[$pf]=$finfor[$pf];
			}
		}
		//���ı�
		if($stf)
		{
			$newstextfile=$r[$stf];
			$r[$stf]=GetTxtFieldText($r[$stf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		//ɾ����Ϣ�ļ�
		if($add['delhtml']!=1&&$delckinfo!=2)
		{
			DelNewsFile($r[filename],$r[newspath],$r[classid],$r[$pf],$r[groupid]);
		}
		//ɾ������Ϣ
		$empire->query("delete from {$dbtbpre}ecms_".$tbname."_index where id='$r[id]'");
		$empire->query("delete from ".$infotb." where id='$r[id]'");
		$empire->query("delete from ".$infodatatb." where id='$r[id]'");
		//������Ŀ��Ϣ��
		AddClassInfos($r['classid'],'-1','-1',($delckinfo==2?0:1));
		//ɾ���������¼�͸���
		DelSingleInfoOtherData($r['classid'],$r['id'],$r,0,0);
	}
	if(empty($b))
	{
		if($delckinfo==0&&!$dodelcheck)
		{
			echo $fun_r[DelDataSuccess]."<script>self.location.href='ecmsinfo.php?enews=DelInfoData&start=0&from=".urlencode($from)."&delhtml=$add[delhtml]&dodelcheck=1".$search.hReturnEcmsHashStrHref(0)."';</script>";
			exit();
		}
	    //������־
	    insert_dolog("");
		printerror("DelNewsAllSuccess","db/DelData.php".hReturnEcmsHashStrHref2(1));
	}
	echo $fun_r[OneDelDataSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmsinfo.php?enews=DelInfoData&start=$new_start&from=".urlencode($from)."&delhtml=$add[delhtml]".$search.hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//�鵵��Ϣ(��Ŀ)
function InfoToDoc_class($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$class_r;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"class");
	$classid=(int)$add['classid'];
	if(!$classid)
	{
		printerror("EmptyDocClass","");
	}
	$start=(int)$add['start'];
	$cr=$empire->fetch1("select tbname,doctime from {$dbtbpre}enewsclass where classid='$classid' and islast=1");
	if(!$cr['tbname']||!$cr['doctime'])
	{
		printerror("EmptyDocTimeClass","");
	}
	$line=$public_r['docnewsnum'];
	$b=0;
	$doctime=time()-$cr['doctime']*24*3600;
	$sql=$empire->query("select * from {$dbtbpre}ecms_".$cr[tbname]." where id>$start and classid='$classid' and truetime<$doctime order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['id'];
		DoDocInfo($cr[tbname],$r,0);
	}
	if(empty($b))
	{
		//δ�����Ϣ
		DoDocCkInfo($cr['tbname'],"classid='$classid' and truetime<$doctime",0);
		$add['docfrom']=urldecode($add['docfrom']);
		//������־
		insert_dolog("tbname=".$cr['tbname']."&classid=$classid&do=1");
		printerror("InfoToDocSuccess",$add['docfrom']);
	}
	echo $fun_r[OneInfoToDocSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmsinfo.php?enews=InfoToDoc&ecmsdoc=1&classid=$classid&start=$new_start&docfrom=".urlencode($add[docfrom]).hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//�鵵��Ϣ(����������)
function InfoToDoc($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$class_r;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"infodoc");
	$tbname=RepPostVar($add['tbname']);
	if(empty($tbname))
	{
		printerror("EmptyDocTb","");
	}
	$selecttbname=$tbname;
	if($add['doing']==1)
	{
		$selecttbname=$tbname.'_doc';
	}
	$search="&retype=$add[retype]";
	if($add['retype']==0)//�������鵵
	{
		if($add['doing']==1)//��ԭ
		{
			$doctime=(int)$add['doctime1'];
			$dx=">";
		}
		else//�鵵
		{
			$doctime=(int)$add['doctime'];
			$dx="<";
		}
		if(!$doctime)
		{
			printerror("EmptyDoctime","");
		}
		$chtime=time()-$doctime*24*3600;
		$where='truetime'.$dx.$chtime;
		$log="doctime=$doctime";
		$search.="&doctime=$add[doctime]&doctime1=$add[doctime1]";
	}
	elseif($add['retype']==1)//��ʱ��鵵
	{
		$startday=RepPostVar($add['startday']);
		$endday=RepPostVar($add['endday']);
		if(!$endday)
		{
			printerror("EmptyDocDay","");
		}
		if($startday)
		{
			$where="truetime>=".to_time($startday." 00:00:00")." and ";
		}
		$where.="truetime<=".to_time($endday." 23:59:59");
		$log="startday=$startday&endday=$endday";
		$search.="&startday=$add[startday]&endday=$add[endday]";
	}
	else//��ID�鵵
	{
		$startid=(int)$add['startid'];
		$endid=(int)$add['endid'];
		if(!$endid)
		{
			printerror("EmptyDocId","");
		}
		if($startid)
		{
			$where="id>=".$startid." and ";
		}
		$where.="id<=".$endid;
		$log="startid=$startid&endid=$endid";
		$search.="&startid=$add[startid]&endid=$add[endid]";
	}
	//��Ŀ
	$classid=$add['classid'];
	$count=count($classid);
	if($count)
	{
		for($i=0;$i<$count;$i++)
		{
			$dh=",";
			if($i==0)
			{
				$dh="";
			}
			$ids.=$dh.intval($classid[$i]);
			$search.='&classid[]='.$classid[$i];
		}
		$where.=" and classid in (".$ids.")";
	}
	$log.="<br>doing=$add[doing]";
	$start=(int)$add['start'];
	$line=$public_r['docnewsnum'];
	$b=0;
	$sql=$empire->query("select * from {$dbtbpre}ecms_".$selecttbname." where id>$start and ".$where." order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['id'];
		DoDocInfo($tbname,$r,$add['doing']);
	}
	if(empty($b))
	{
		//δ�����Ϣ�鵵
		DoDocCkInfo($tbname,$where,$add['doing']);
		$add['docfrom']=urldecode($add['docfrom']);
		//������־
		insert_dolog("tbname=".$tbname.$log."&doing=$add[doing]&do=2");
		printerror("InfoToDocSuccess",$add['docfrom']);
	}
	echo $fun_r[OneInfoToDocSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)<script>self.location.href='ecmsinfo.php?enews=InfoToDoc&ecmsdoc=2&doing=$add[doing]&tbname=$tbname&start=$new_start&docfrom=".urlencode($add[docfrom]).$search.hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//�鵵��Ϣ(ѡ����Ϣ)
function InfoToDoc_info($add,$userid,$username){
	global $empire,$dbtbpre,$class_r;
	$classid=(int)$add['classid'];
	//����Ȩ��
	$doselfinfo=CheckLevel($userid,$username,$classid,"news");
	//Ȩ��
	if(!$doselfinfo['dodocinfo'])
	{
		printerror("NotDocInfoLevel","history.go(-1)");
	}
	$id=$add['id'];
	$count=count($id);
	if($count==0)
	{
		printerror("EmptyDocInfo","");
	}
	$tbname=$class_r[$classid]['tbname'];
	if(empty($tbname))
	{
		printerror("EmptyDocInfo","");
	}
	$selecttbname=$tbname;
	if($add['doing']==1)
	{
		$selecttbname=$tbname.'_doc';
	}
	for($i=0;$i<$count;$i++)
	{
		$dh=",";
		if($i==0)
		{
			$dh="";
		}
		$ids.=$dh.intval($id[$i]);
	}
	$where="id in (".$ids.")";
	$sql=$empire->query("select * from {$dbtbpre}ecms_".$selecttbname." where ".$where);
	while($r=$empire->fetch($sql))
	{
		DoDocInfo($tbname,$r,$add['doing']);
	}
	//δ�����Ϣ�鵵
	DoDocCkInfo($tbname,$where,$add['doing']);
	$add['docfrom']=urldecode($add['docfrom']);
	//������־
	insert_dolog("tbname=".$tbname."&doing=$add[doing]&do=0");
	printerror("InfoToDocSuccess",$add['docfrom']);
}

//����鵵
function DoDocInfo($tb,$r,$ecms=0){
	global $empire,$dbtbpre,$class_r,$emod_r;
	if($ecms==1)//��ԭ
	{
		$table=$dbtbpre.'ecms_'.$tb.'_doc_index';	//������
		$table1=$dbtbpre.'ecms_'.$tb.'_doc';	//����
		$table2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//����
		$ytable=$dbtbpre.'ecms_'.$tb.'_index';	//Ŀ��������
		$ytable1=$dbtbpre.'ecms_'.$tb;	//Ŀ������
		$ytable2=$dbtbpre.'ecms_'.$tb.'_data_'.$r[stb];	//Ŀ�긱��
	}
	else//�鵵
	{
		$table=$dbtbpre.'ecms_'.$tb.'_index';	//������
		$table1=$dbtbpre.'ecms_'.$tb;	//����
		$table2=$dbtbpre.'ecms_'.$tb.'_data_'.$r[stb];	//����
		$ytable=$dbtbpre.'ecms_'.$tb.'_doc_index';	//Ŀ��������
		$ytable1=$dbtbpre.'ecms_'.$tb.'_doc';	//Ŀ������
		$ytable2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//Ŀ�긱��
	}
	$mid=$class_r[$r[classid]][modid];
	//������
	$index_r=$empire->fetch1("select * from ".$table." where id='$r[id]' limit 1");
	if($index_r['checked']==0)
	{
		return '';
	}
	//����
	$fr=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from ".$table2." where id='$r[id]' limit 1");
	$r=array_merge($r,$fr);
	$ret_r=ReturnAddF($r,$mid,$userid,$username,10,0,0);//�����Զ����ֶ�
	//������
	$empire->query("insert into ".$ytable."(id,classid,checked,newstime,truetime,lastdotime,havehtml) values('$index_r[id]','$index_r[classid]','$index_r[checked]','$index_r[newstime]','$index_r[truetime]','$index_r[lastdotime]','$index_r[havehtml]');");
	//����
	$empire->query("replace into ".$ytable1."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard".$ret_r[fields].") values('$r[id]','$r[classid]','$r[ttid]','$r[onclick]','$r[plnum]','$r[totaldown]','".StripAddsData($r[newspath])."','".StripAddsData($r[filename])."','$r[userid]','".StripAddsData($r[username])."','$r[firsttitle]','$r[isgood]','$r[ispic]','$r[istop]','$r[isqf]','$r[ismember]','$r[isurl]','$r[truetime]','$r[lastdotime]','$r[havehtml]','$r[groupid]','$r[userfen]','".StripAddsData($r[titlefont])."','".StripAddsData($r[titleurl])."','$r[stb]','$r[fstb]','$r[restb]','".StripAddsData($r[keyboard])."'".$ret_r[values].");");
	//����
	$empire->query("replace into ".$ytable2."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$ret_r[datafields].") values('$r[id]','$r[classid]','$r[keyid]','$r[dokey]','$r[newstempid]','$r[closepl]','$r[haveaddfen]','".StripAddsData($r[infotags])."'".$ret_r[datavalues].");");
	//ɾ��
	$empire->query("delete from ".$table." where id='$r[id]'");
	$empire->query("delete from ".$table1." where id='$r[id]'");
	$empire->query("delete from ".$table2." where id='$r[id]'");
	//������Ŀ��Ϣ��
	if($ecms==1)//��ԭ
	{
		AddClassInfos($r['classid'],'+1','+1');
	}
	else//�鵵
	{
		AddClassInfos($r['classid'],'-1','-1');
	}
}

//����鵵(δ�����Ϣ)
function DoDocCkInfo($tb,$where,$ecms=0){
	global $empire,$dbtbpre,$class_r,$emod_r;
	if($ecms==1)//��ԭ
	{
		$table=$dbtbpre.'ecms_'.$tb.'_doc_index';	//����
		$table1=$dbtbpre.'ecms_'.$tb.'_doc';	//����
		$table2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//����
		$ytable=$dbtbpre.'ecms_'.$tb.'_index';	//Ŀ������
		$ytable1=$dbtbpre.'ecms_'.$tb.'_check';	//Ŀ������
		$ytable2=$dbtbpre.'ecms_'.$tb.'_check_data';	//Ŀ�긱��
	}
	else//�鵵
	{
		$table=$dbtbpre.'ecms_'.$tb.'_index';	//����
		$table1=$dbtbpre.'ecms_'.$tb.'_check';	//����
		$table2=$dbtbpre.'ecms_'.$tb.'_check_data';	//����
		$ytable=$dbtbpre.'ecms_'.$tb.'_doc_index';	//Ŀ������
		$ytable1=$dbtbpre.'ecms_'.$tb.'_doc';	//Ŀ������
		$ytable2=$dbtbpre.'ecms_'.$tb.'_doc_data';	//Ŀ�긱��
	}
	//ת������
	$fids='';
	$dh='';
	$sql=$empire->query("select id,classid from ".$table1." where ".$where);
	while($r=$empire->fetch($sql))
	{
		$fids.=$dh.$r['id'];
		$dh=',';
		//������Ŀ��Ϣ��
		if($ecms==1)//��ԭ
		{
			AddClassInfos($r['classid'],'+1','',0);
		}
		else//�鵵
		{
			AddClassInfos($r['classid'],'-1','',0);
		}
	}
	if(empty($fids))
	{
		return '';
	}
	$empire->query("replace into ".$ytable." select * from ".$table." where ".$where);
	$empire->query("replace into ".$ytable1." select * from ".$table1." where ".$where);
	$empire->query("replace into ".$ytable2." select * from ".$table2." where id in (".$fids.")");
	//ɾ��
	$empire->query("delete from ".$table." where ".$where);
	$empire->query("delete from ".$table1." where ".$where);
	$empire->query("delete from ".$table2." where id in (".$fids.")");
}

//������Ϣ����֪ͨ
function DoInfoSendNotice($userid,$username,$to_userid,$to_username,$causetext,$infor,$ecms=0){
	global $empire,$dbtbpre,$class_r;
	if(!$infor['ismember'])
	{
		return '';
	}
	//������
	$user_r=$empire->fetch1("select wname from {$dbtbpre}enewsuser where userid='$userid'");
	$dousername=$user_r['wname']?$user_r['wname']:'����Ա';
	//��������
	if($ecms==1)
	{
		$doing='ɾ��';
		$title='������Ϣ��ɾ��';
	}
	elseif($ecms==2)
	{
		$doing='���ͨ��';
		$title='������Ϣ�����ͨ��';
	}
	elseif($ecms==3)
	{
		$doing='ȡ�����';
		$title='������Ϣ��ȡ�����';
	}
	elseif($ecms==4)
	{
		$doing='ת��';
		$title='������Ϣ��ת��';
	}
	//������Ϣ
	$title=RepPostStr($title);
	$causetext=RepPostStr($causetext);
	$dotime=date("Y-m-d H:i:s");
	//��Ϣ����
	$titleurl=sys_ReturnBqTitleLink($infor);
	$infotitle=$infor['title'];
	$infotime=date("Y-m-d H:i:s",$infor[truetime]);
	$classname=$class_r[$infor[classid]]['classname'];
	$classurl=sys_ReturnBqClassname($infor,9);
	$isadmin=$infor['ismember']==1?0:1;
	$dousername=RepPostVar($dousername);
	$to_username=RepPostVar($to_username);

	$msgtext="����������Ϣ�� <strong>$dousername</strong> ִ�� <strong>$doing</strong> ����<br>
<br>
<strong>��Ϣ���⣺</strong><a href='".$titleurl."'>".$infotitle."</a><br>
<strong>����ʱ�䣺</strong>".$infotime."<br>
<strong>������Ŀ��</strong><a href='".$classurl."'>".$classname."</a><br>
<strong>����ʱ�䣺</strong>$dotime<br>
<strong>�������ɣ�</strong>".$causetext."<br>";
	
	eSendMsg(addslashes($title),addslashes($msgtext),$to_username,0,'',1,1,$isadmin);
}
?>