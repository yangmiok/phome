<?php
//�޸Ĳɼ���Ϣ
function EditCjNews($add,$newstext,$userid,$username){
	global $empire,$class_r,$dbtbpre,$public_r;
	$add[classid]=(int)$add[classid];
	$add[id]=(int)$add[id];
	if(empty($add[classid])||empty($add[id])||empty($add[title]))
	{printerror("EmptyCjTitle","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	//ȡ�òɼ��ֶ�
	$record="<!--record-->";
	$field="<!--field--->";
	$cr=$empire->fetch1("select newsclassid,tbname from {$dbtbpre}enewsinfoclass where classid='$add[classid]'");
	$r=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$cr[newsclassid]][modid]."'");
	$cjr=explode($record,$r[cj]);
	$count=count($cjr);
	$update="";
	for($i=0;$i<$count-1;$i++)
	{
		$cjr1=explode($field,$cjr[$i]);
		$dofield=$cjr1[1];
		//ͼƬ��
		if($dofield=="morepic")
		{
			$add[$dofield]=ReturnMorepicpath($add['msmallpic'],$add['mbigpic'],$add['mpicname'],$add['mdelpicid'],$add['mpicid'],$add,$add['mpicurl_qz'],1,0,$public_r['filedeftb']);
		}
		//���ص�ַ
		if($dofield=="downpath")
		{
			$add[$dofield]=ReturnDownpath($add['downname'],$add['downpath'],$add['delpathid'],$add['pathid'],$add['downuser'],$add['fen'],$add['thedownqz'],$add,$add['foruser'],$add['downurl'],0);
		}
		//���ߵ�ַ
		if($dofield=="onlinepath")
		{
			$add[$dofield]=ReturnDownpath($add['odownname'],$add['odownpath'],$add['odelpathid'],$add['opathid'],$add['odownuser'],$add['ofen'],$add['othedownqz'],$add,$add['oforuser'],$add['onlineurl_qz'],1);
		}
		//����ʱ��
		if($dofield=="newstime")
		{continue;}
		$update.=",".$dofield."='".eaddslashes2($add[$dofield])."'";
	}
	$sql=$empire->query("update {$dbtbpre}ecms_infotmp_".$cr[tbname]." set keyboard='".eaddslashes2($add[keyboard])."',newstime='$add[newstime]'".$update." where id='$add[id]'");
	if($sql)
	{
		//������־
		insert_dolog("id=".$add[id]."<br>title=".$add[title]);
		printerror("EditCjNewsSuccess","CheckCj.php?classid=$add[classid]&from=".ehtmlspecialchars($_POST[from]).hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ���ɼ���Ϣ
function DelCjNews($classid,$id,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	$id=(int)$id;
	if(empty($classid)||empty($id))
	{printerror("NotDelCjNewsid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$cr=$empire->fetch1("select newsclassid,tbname from {$dbtbpre}enewsinfoclass where classid='$classid'");
	$r=$empire->fetch1("select title from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where id='$id'");
	$sql=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where id='$id'");
	if($sql)
	{
		//������־
		insert_dolog("id=".$id."<br>title=".$r[title]);
		printerror("DelCjNewsSuccess","CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//����ɾ���ɼ���Ϣ
function DelCjNews_all($classid,$id,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$count=count($id);
	if(!$count)
	{printerror("NotDelCjNewsid","history.go(-1)");}
	$cr=$empire->fetch1("select newsclassid,tbname,classname from {$dbtbpre}enewsinfoclass where classid='$classid'");
	for($i=0;$i<count($id);$i++)
	{
		$add.="id='".$id[$i]."' or ";
    }
	//ȥ�����һ�� or
	$add=substr($add,0,strlen($add)-4);
	$sql=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where ".$add);
	if($sql)
	{
		//������־
	    insert_dolog("classid=".$classid."<br>classname=".$cr[classname]);
		printerror("DelCjNewsAllSuccess",EcmsGetReturnUrl());
    }
	else
	{
		printerror("DbError","history.go(-1)");
    }
}

//�������ַ�
function DoClearSmalltextVal($value){
	$value=str_replace(array("\r\n","<br />","<br>","&nbsp;","[!--empirenews.page--]","[/!--empirenews.page--]"),array("","\r\n","\r\n"," ","",""),$value);
	$value=strip_tags($value);
	$value=trim($value,"\r\n");
	return $value;
}

//�ɼ����
function CjNewsIn($classid,$id,$checked,$uptime,$userid,$username){
	global $class_r,$empire,$public_r,$dbtbpre,$emod_r,$lur;
	$checked=(int)$checked;
	$classid=(int)$classid;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"cj");//����Ȩ��
	$count=count($id);
	if(empty($count))
	{
		printerror("NotCjNewsIn","history.go(-1)");
	}
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//����
	$cra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$cr[tbname]." where classid='$classid'");
	//���������
    $cr=TogTwoArray($cr,$cra);
	//����gd�����ļ�
	if($cr['mark']||$cr['getfirstspic'])
	{
		@include_once("gd.php");
	}
	$userisqf=EcmsReturnDoIsqf($userid,$username,$lur['groupid'],0);
	$mid=$class_r[$cr[newsclassid]][modid];
	$savetxtf=$emod_r[$mid]['savetxtf'];
	$stb=$emod_r[$mid]['deftb'];
	//ȡ�òɼ��ֶ�
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$cr[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$ccount=count($cjr);
	//ȡ���Ż��ֶ�
	for($ci=0;$ci<$ccount-1;$ci++)
	{
		$cir=explode($field,$cjr[$ci]);
		$cifield=$cir[1];
		if($cifield=="title")
		{
			continue;
		}
		$updatefield.=",".$cifield."=''";
	}
	for($i=0;$i<count($id);$i++)
	{
		$a.="id='".$id[$i]."' or ";
	}
	//ȥ�����һ�� or
	$a=substr($a,0,strlen($a)-4);
	$sql=$empire->query("select * from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where ".$a." and checked=0 order by id desc");
	$todaytime=time();
	$filetime=$todaytime;
	while($r=$empire->fetch($sql))
	{
		$ivalue='';
		$ifield='';
		$dataivalue='';
		$dataifield='';
		$titlepicnoval=0;
		for($j=0;$j<$ccount-1;$j++)
		{
			$cjr1=explode($field,$cjr[$j]);
			$dofield=$cjr1[1];
			$var="zz_".$dofield;
			$var1="z_".$dofield;
			$var2="qz_".$dofield;
			$var3="save_".$dofield;
			$value=$r[$dofield];
			//��������
			if($dofield=="empireselfurl")
			{
				$value=$r['oldurl'];
			}
			//����
			if($dofield=="newstext")
			{
				if($cr[copyimg]||$cr[copyflash])
				{
					$GLOBALS['cjnewsurl']=$r[oldurl];
					$value=addslashes(CopyImg(stripSlashes($value),$cr[copyimg],$cr[copyflash],$cr[newsclassid],$cr[imgurl],$username,0,$r['id'],$cr['mark'],$public_r['filedeftb']));
				}
				//�滻�ؼ��ֺ��ַ�
				$value=DoReplaceKeyAndWord($value,1,$cr[newsclassid]);
			}
			//���
			if($dofield=="smalltext")
			{
				if(empty($value))
				{
					$value=SubSmalltextVal($r[newstext],$cr[smalltextlen]);
				}
				else
				{
					$value=DoClearSmalltextVal($value);
				}
			}
			//ͼƬ��
			if($dofield=="morepic")
			{
				if($cr[$var3]==" checked")
				{
					$msavepic=1;
					$r['filepass']=$r['id'];
					$value=LoadInSaveMorepicFile($value,$msavepic,$cr[newsclassid],0,$r,0,$public_r['filedeftb']);
				}
			}
			//��Ϣʱ��
			if($dofield=="newstime")
			{continue;}
			//ͼƬ����
			if($dofield=="titlepic"&&$cr[zz_titlepicl])
			{
				$cr[$var]=$cr[zz_titlepicl];
				$cr[$var1]=$cr[z_titlepicl];
				$cr[$var2]=$cr[qz_titlepicl];
				$cr[$var3]=$cr[save_titlepicl];
			}
			if($dofield=="titlepic"&&empty($value))
			{
				$titlepicnoval=1;
			}
			//�Ƿ�Զ�̱���
			if($value&&!$cr[$var1]&&$cr[$var3]==" checked"&&$dofield!="morepic")
			{
				$tranr=DoTranUrl($value,$cr[newsclassid]);
				if($tranr[tran])
				{
					$tranr[filesize]=(int)$tranr[filesize];
					$tranr[type]=(int)$tranr[type];
					$r[id]=(int)$r[id];
					//��¼���ݿ�
					eInsertFileTable($tranr[filename],$tranr[filesize],$tranr[filepath],$username,$cr[newsclassid],'[URL]'.$tranr[filename],$tranr[type],0,$r[id],$public_r[fpath],0,0,$public_r['filedeftb']);
					$value=$tranr[url];
				}
			}
			//����ı�
			if($savetxtf==$dofield)
			{
				//����Ŀ¼
				$thetxtfile=GetFileMd5();
				$truevalue=MkDirTxtFile(date("Y/md"),$thetxtfile);
				//д���ļ�
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			$value=addslashes($value);
			if(strstr($emod_r[$mid]['tbdataf'],','.$dofield.','))//����
			{
				$dataifield.=",".$dofield;
				$dataivalue.=",'".$value."'";
			}
			else
			{
				$ifield.=",".$dofield;
				$ivalue.=",'".$value."'";
			}
		}
		$r[keyboard]=addslashes($r[keyboard]);
		//ʱ��
		if($uptime)//��ǰʱ��
		{
			$r[newstime]=$todaytime;
			$r[truetime]=$todaytime;
		}
		else
		{
			if($r[newstime]=="0000-00-00 00:00:00")
			{
				$r[newstime]=$todaytime;
			}
			else
			{
				$r[newstime]=to_time($r[newstime]);
			}
		}
		//�鿴Ŀ¼�Ƿ���ڣ�����������
		$newspath=FormatPath($cr[newsclassid],"",0);
		//ǿ��ǩ��
		if($class_r[$cr[newsclassid]][wfid])
		{
			if($userisqf)
			{
				$checked=$checked;
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
			$checked=$checked;
			$isqf=0;
		}
		//��������
		$newstempid=0;
		$ispic=$r[titlepic]?1:0;
		//ȡ�÷��عؼ���
		$keyid=GetKeyid($r[keyboard],$cr[newsclassid],0,$class_r[$cr[newsclassid]][link_num]);
		//������
		$havehtml=0;
		$indexsql=$empire->query("insert into {$dbtbpre}ecms_".$class_r[$cr[newsclassid]][tbname]."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$cr[newsclassid]','$checked','$r[newstime]','$r[truetime]','$r[truetime]','$havehtml');");
		$id=$empire->lastid();
		$infotbr=ReturnInfoTbname($class_r[$cr[newsclassid]][tbname],$checked,$stb);
		//����
		$isurl=$r['titleurl']?1:0;
		$isql=$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard,newstime".$ifield.") values('$id','$cr[newsclassid]',0,0,0,0,'$newspath','$filename','$r[userid]','$r[username]',0,0,'$ispic',0,'$isqf',0,'$isurl','$r[truetime]','$r[truetime]','$havehtml',0,0,'$r[titlefont]','$r[titleurl]','$stb','$public_r[filedeftb]','$public_r[pldeftb]','$r[keyboard]','$r[newstime]'".$ivalue.");");
		//����
		$fisql=$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$dataifield.") values('$id','$cr[newsclassid]','$keyid',1,'$newstempid',0,0,''".$dataivalue.");");
		//������Ŀ��Ϣ��
		AddClassInfos($cr['newsclassid'],'+1','+1',$checked);
		//��������Ϣ��
		DoUpdateAddDataNum('info',$class_r[$cr['newsclassid']]['tid'],1);
		//ǩ��
		if($isqf==1)
		{
			InfoInsertToWorkflow($id,$cr[newsclassid],$class_r[$cr[newsclassid]][wfid],$userid,$username);
		}
		//���¸���
		UpdateTheFile($id,$r['id'],$cr['newsclassid'],$public_r['filedeftb']);
		//ȡ��һ��ͼƬΪ����ͼƬ
		$addtitlepic="";
		if($cr['getfirstpic']&&$titlepicnoval)
		{
			$firsttitlepic=GetFpicToTpic($cr[newsclassid],$id,$cr['getfirstpic'],$cr['getfirstspic'],$cr['getfirstspicw'],$cr['getfirstspich'],$public_r['filedeftb']);
			if($firsttitlepic)
			{
				$addtitlepic=",titlepic='".addslashes($firsttitlepic)."',ispic=1";
			}
		}
		//�ļ�����
		$filename=ReturnInfoFilename($cr[newsclassid],$id,$r[filenameqz]);
		//��Ϣ��ַ
		$updateinfourl='';
		if(!$isurl)
		{
			$infourl=GotoGetTitleUrl($cr['newsclassid'],$id,$newspath,$filename,0,$isurl,'');
			$updateinfourl=",titleurl='$infourl'";
		}
        $usql=$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl.$addtitlepic." where id='$id'");
	}
	//״̬ԭ��¼
	if($cr['delloadinfo'])//ɾ��
	{
		$del=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where ".$a);
	}
	else
	{
		$del=$empire->query("update {$dbtbpre}ecms_infotmp_".$cr[tbname]." set checked=1,keyboard=''".$updatefield." where ".$a);
	}
	//������־
	insert_dolog("classid=".$classid);
	printerror("CjLoadDbSuccess","CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_POST[from]).hReturnEcmsHashStrHref2(0));
}

//ȫ���ɼ����
function CjNewsIn_all($classid,$checked,$uptime,$start,$userid,$username){
	global $class_r,$empire,$public_r,$dbtbpre,$fun_r,$emod_r,$lur;
	$checked=(int)$checked;
	$classid=(int)$classid;
	$start=(int)$start;
	if(empty($classid))
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//����
	$cra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$cr[tbname]." where classid='$classid'");
	//���������
    $cr=TogTwoArray($cr,$cra);
	//����gd�����ļ�
	if($cr['mark']||$cr['getfirstspic'])
	{
		@include_once("gd.php");
	}
	$userisqf=EcmsReturnDoIsqf($userid,$username,$lur['groupid'],0);
	if(empty($cr[insertnum]))
	{$cr[insertnum]=10;}
	$mid=$class_r[$cr[newsclassid]][modid];
	$savetxtf=$emod_r[$mid]['savetxtf'];
	$stb=$emod_r[$mid]['deftb'];
	//ȡ�òɼ��ֶ�
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$cr[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$ccount=count($cjr);
	$sql=$empire->query("select * from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where classid='$classid' and checked=0 and id>$start order by id limit ".$cr[insertnum]);
	$todaytime=time();
	$filetime=$todaytime;
	$b=0;
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r[id];
		$ivalue='';
		$ifield='';
		$dataivalue='';
		$dataifield='';
		$titlepicnoval=0;
		for($j=0;$j<$ccount-1;$j++)
		{
			$cjr1=explode($field,$cjr[$j]);
			$dofield=$cjr1[1];
			$var="zz_".$dofield;
			$var1="z_".$dofield;
			$var2="qz_".$dofield;
			$var3="save_".$dofield;
			$value=$r[$dofield];
			//��������
			if($dofield=="empireselfurl")
			{
				$value=$r['oldurl'];
			}
			//����
			if($dofield=="newstext")
			{
				if($cr[copyimg]||$cr[copyflash])
				{
					$GLOBALS['cjnewsurl']=$r[oldurl];
					$value=addslashes(CopyImg(stripSlashes($value),$cr[copyimg],$cr[copyflash],$cr[newsclassid],$cr[imgurl],$username,0,$r['id'],$cr['mark'],$public_r['filedeftb']));
				}
				//�滻�ؼ��ֺ��ַ�
				$value=DoReplaceKeyAndWord($value,1,$cr[newsclassid]);
			}
			//���
			if($dofield=="smalltext")
			{
				if(empty($value))
				{
					$value=SubSmalltextVal($r[newstext],$cr[smalltextlen]);
				}
				else
				{
					$value=DoClearSmalltextVal($value);
				}
			}
			//ͼƬ��
			if($dofield=="morepic")
			{
				if($cr[$var3]==" checked")
				{
					$msavepic=1;
					$r['filepass']=$r['id'];
					$value=LoadInSaveMorepicFile($value,$msavepic,$cr[newsclassid],0,$r,0,$public_r['filedeftb']);
				}
			}
			//ʱ��
			if($dofield=="newstime")
			{continue;}
			//ͼƬ����
			if($dofield=="titlepic"&&$cr[zz_titlepicl])
			{
				$cr[$var]=$cr[zz_titlepicl];
				$cr[$var1]=$cr[z_titlepicl];
				$cr[$var2]=$cr[qz_titlepicl];
				$cr[$var3]=$cr[save_titlepicl];
			}
			if($dofield=="titlepic"&&empty($value))
			{
				$titlepicnoval=1;
			}
			//�Ƿ�Զ�̱���
			if($value&&!$cr[$var1]&&$cr[$var3]==" checked"&&$dofield!="morepic")
			{
				$tranr=DoTranUrl($value,$cr[newsclassid]);
				if($tranr[tran])
				{
					$tranr[filesize]=(int)$tranr[filesize];
					$tranr[type]=(int)$tranr[type];
					$r[id]=(int)$r[id];
					//��¼���ݿ�
					eInsertFileTable($tranr[filename],$tranr[filesize],$tranr[filepath],$username,$cr[newsclassid],'[URL]'.$tranr[filename],$tranr[type],0,$r[id],$public_r[fpath],0,0,$public_r['filedeftb']);
					$value=$tranr[url];
				}
			}
			//����ı�
			if($savetxtf==$dofield)
			{
				//����Ŀ¼
				$thetxtfile=GetFileMd5();
				$truevalue=MkDirTxtFile(date("Y/md"),$thetxtfile);
				//д���ļ�
				EditTxtFieldText($truevalue,$value);
				$value=$truevalue;
			}
			$value=addslashes($value);
			if(strstr($emod_r[$mid]['tbdataf'],','.$dofield.','))//����
			{
				$dataifield.=",".$dofield;
				$dataivalue.=",'".$value."'";
			}
			else
			{
				$ifield.=",".$dofield;
				$ivalue.=",'".$value."'";
			}
		}
		$r[keyboard]=addslashes($r[keyboard]);
		//ʱ��
		if($uptime)//��ǰʱ��
		{
			$r[newstime]=$todaytime;
			$r[truetime]=$todaytime;
		}
		else
		{
			if($r[newstime]=="0000-00-00 00:00:00")
			{
				$r[newstime]=$todaytime;
			}
			else
			{
				$r[newstime]=to_time($r[newstime]);
			}
		}
		//�鿴Ŀ¼�Ƿ���ڣ�����������
		$newspath=FormatPath($cr[newsclassid],"",0);
		//ǿ��ǩ��
		if($class_r[$cr[newsclassid]][wfid])
		{
			if($userisqf)
			{
				$checked=$checked;
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
			$checked=$checked;
			$isqf=0;
		}
		//��������
		$newstempid=0;
		$ispic=$r[titlepic]?1:0;
		//���عؼ���
		$keyid=GetKeyid($r[keyboard],$cr[newsclassid],0,$class_r[$cr[newsclassid]][link_num]);
		//������
		$havehtml=0;
		$indexsql=$empire->query("insert into {$dbtbpre}ecms_".$class_r[$cr[newsclassid]][tbname]."_index(classid,checked,newstime,truetime,lastdotime,havehtml) values('$cr[newsclassid]','$checked','$r[newstime]','$r[truetime]','$r[truetime]','$havehtml');");
		$id=$empire->lastid();
		$infotbr=ReturnInfoTbname($class_r[$cr[newsclassid]][tbname],$checked,$stb);
		//����
		$isurl=$r['titleurl']?1:0;
		$isql=$empire->query("insert into ".$infotbr['tbname']."(id,classid,ttid,onclick,plnum,totaldown,newspath,filename,userid,username,firsttitle,isgood,ispic,istop,isqf,ismember,isurl,truetime,lastdotime,havehtml,groupid,userfen,titlefont,titleurl,stb,fstb,restb,keyboard,newstime".$ifield.") values('$id','$cr[newsclassid]',0,0,0,0,'$newspath','$filename','$r[userid]','$r[username]',0,0,'$ispic',0,'$isqf',0,'$isurl','$r[truetime]','$r[truetime]','$havehtml',0,0,'$r[titlefont]','$r[titleurl]','$stb','$public_r[filedeftb]','$public_r[pldeftb]','$r[keyboard]','$r[newstime]'".$ivalue.");");
		//����
		$fisql=$empire->query("insert into ".$infotbr['datatbname']."(id,classid,keyid,dokey,newstempid,closepl,haveaddfen,infotags".$dataifield.") values('$id','$cr[newsclassid]','$keyid',1,'$newstempid',0,0,''".$dataivalue.");");
		//������Ŀ��Ϣ��
		AddClassInfos($cr['newsclassid'],'+1','+1',$checked);
		//��������Ϣ��
		DoUpdateAddDataNum('info',$class_r[$cr['newsclassid']]['tid'],1);
		//ǩ��
		if($isqf==1)
		{
			InfoInsertToWorkflow($id,$cr[newsclassid],$class_r[$cr[newsclassid]][wfid],$userid,$username);
		}
		//���¸���
		UpdateTheFile($id,$r['id'],$cr[newsclassid],$public_r['filedeftb']);
		//ȡ��һ��ͼƬΪ����ͼƬ
		$addtitlepic="";
		if($cr['getfirstpic']&&$titlepicnoval)
		{
			$firsttitlepic=GetFpicToTpic($cr[newsclassid],$id,$cr['getfirstpic'],$cr['getfirstspic'],$cr['getfirstspicw'],$cr['getfirstspich'],$public_r['filedeftb']);
			if($firsttitlepic)
			{
				$addtitlepic=",titlepic='".addslashes($firsttitlepic)."',ispic=1";
			}
		}
		//�ļ�����
		$filename=ReturnInfoFilename($cr[newsclassid],$id,$r[filenameqz]);
		//��Ϣ��ַ
		$updateinfourl='';
		if(!$isurl)
		{
			$infourl=GotoGetTitleUrl($cr['newsclassid'],$id,$newspath,$filename,0,$isurl,'');
			$updateinfourl=",titleurl='$infourl'";
		}
        $usql=$empire->query("update ".$infotbr['tbname']." set filename='$filename'".$updateinfourl.$addtitlepic." where id='$id'");
	}
	$fm=ehtmlspecialchars($_GET['fm']);
	//ȫ��������
	if(empty($b))
	{
		//ȡ���ǻ��ֶ�
		for($ci=0;$ci<$ccount-1;$ci++)
	    {
			$cir=explode($field,$cjr[$ci]);
			$cifield=$cir[1];
			if($cifield=="title")
			{
				continue;
			}
			$updatefield.=",".$cifield."=''";
		}
		//״̬ԭ��¼
		if($cr['delloadinfo'])//ɾ��
		{
			$del=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where classid='$classid'");
		}
		else
		{
			$del=$empire->query("update {$dbtbpre}ecms_infotmp_".$cr[tbname]." set checked=1,keyboard=''".$updatefield." where classid='$classid'");
		}
		if($fm)
		{
			echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><body topmargin=0><font color=red>".$cr[classname]."  ".$fun_r['CjLoadInInfosSuccess']."</font>,  <input type=button name=button value='".$fun_r['OnlickLoadInCj']."' onclick=\"window.open('CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref2(0)."');\"></body>";
			exit();
		}
		else
		{
			printerror("CjLoadDbSuccess","CheckCj.php?classid=$classid&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref2(0));
		}
	}
	//echo "<b>$cr[classname]</b>&nbsp;&nbsp;".$fun_r['OneCjLoadDbSuccess']."(ID:<font color=red><b>".$newstart."</b></font>)<script>self.location.href='ecmscj.php?enews=CjNewsIn_all&checked=$checked&uptime=$uptime&classid=$classid&start=$newstart&fm=$fm&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref(0)."';</script>";
	echo"<meta http-equiv=\"refresh\" content=\"".$cr['loadkeeptime'].";url=ecmscj.php?enews=CjNewsIn_all&checked=$checked&uptime=$uptime&classid=$classid&start=$newstart&fm=$fm&from=".ehtmlspecialchars($_GET[from]).hReturnEcmsHashStrHref(0)."\"><b>".$cr['classname']."</b>&nbsp;&nbsp;".$fun_r['OneCjLoadDbSuccess']."(ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

//##############################�ɼ����ܿ�ʼ###############################

//�滻�س�
function ReplaceFc($text){
	$text=str_replace("\n","",$text);
	$text=str_replace("\r","",$text);
	return $text;
}

//�����ַ�����
function GetInfoStr($text,$exp,$enews=0){
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$rep="[!--".$exp."--]";
	$mode="*";
	//ƥ����
	if($enews==1)
	{
		$cr=explode($rep,$text);
		$cer=explode($mode,$cr[0]);
		$num=count($cer)-1;
	}
	//ת���ַ�
	$text=str_replace($rep,$mode,$text);
	$er=explode($mode,$text);
	$newtext="";
	for($i=0;$i<count($er);$i++)
	{
		$j=$i+1;
		//�ӱ�ǩ
		if($enews==1)
		{
			if($i==$num)
			{
				$newtext.=$er[$i].$e1."\\".$j.$e2;
			}
			else
			{
				$newtext.=$er[$i]."\\".$j;
			}
		}
		//���˹��
		elseif($enews==2)
		{
			if($i==$num)
			{
				$newtext.=$er[$i]."";
			}
			else
			{
				$newtext.=$er[$i]."\\".$j;
			}
		}
		else
		{
			$newtext.=$er[$i]."\\".$j;
		}
	}
	//ȥ�����һ��//
	$newtext=substr($newtext,0,strlen($newtext)-2);
	return $newtext;
}

//���˹��
function RepAd($repad,$text){
	if(empty($repad))
	{return $text;}
	$repad=stripSlashes($repad);
	//�滻�س�
	$repad=ReplaceFc($repad);
	$r=explode(",",$repad);
	$exp="ad";
	for($i=0;$i<count($r);$i++)
	{
		$zztext=RepInfoZZ($r[$i],$exp,0);
		//$strtext=GetInfoStr($r[$i],$exp,2);
		$strtext="";
		$text=stripSlashes(preg_replace($zztext,$strtext,$text));
	}
	return $text;
}

//��������ҳ����
function RepPageAd($repad,$text){
	if(empty($repad))
	{return $text;}
	$repad=stripSlashes($repad);
	//�滻�س�
	$repad=ReplaceFc($repad);
	$r=explode(",",$repad);
	$exp="pad";
	for($i=0;$i<count($r);$i++)
	{
		$zztext=RepInfoZZ($r[$i],$exp,0);
		//$strtext=GetInfoStr($r[$i],$exp,2);
		$strtext="";
		$text=stripSlashes(preg_replace($zztext,$strtext,$text));
	}
	return $text;
}

//��ַ
function eCheckCjUrl($url,$ecms=0){
	if(!strstr($url,'://'))
	{
		if($ecms)
		{
			return false;
		}
		else
		{
			printerror('ErrorUrl','history.go(-1)');
		}
	}
	return true;
}

//ȡ�÷���λ��
function CountCJ_site($text,$exp){
	$rep="[!--".$exp."--]";
	$mode="*";
	$cr=explode($rep,$text);
	$cer=explode($mode,$cr[0]);
	$num=count($cer);
	return $num;
}

//ȡ���滻���������ֵ
function ReturnCJ_str($text,$exp,$info){
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$text=stripSlashes(stripSlashes($text));
	//�滻�س�
	$text=ReplaceFc($text);
	$rep="[!--".$exp."--]";
	//�滻
	$num=CountCJ_site($text,$exp);//ȡ�÷���λ��
	$zztext=RepInfoZZ($text,$exp,0);
	$text1=stripSlashes(preg_replace($zztext,$e1."\\".$num.$e2,$info));
	$r=explode($e1,$text1);
	$r1=explode($e2,$r[1]);
	$text1=$r1[0];
	return $text1;
}

//�滻����
function RepCjUrlStr($url){
	$url=strip_tags($url);
	$url=str_replace("\"","",$url);
	$url=str_replace("'","",$url);
	$url=str_replace("&amp;","&",$url);
	return $url;
}

//����ת��
function doCjUtfAndGbk($str,$phome=0){
	//��������
	if($phome==0)
	{
		return $str;
	}
	if($phome==1)//UTF8->GB2312
	{
		$str=DoIconvVal("UTF8","GB2312",$str);
	}
	elseif($phome==2)//UTF8->BIG5
	{
		$str=DoIconvVal("UTF8","BIG5",$str);
	}
	elseif($phome==3)//BIG5->GB2312
	{
		$str=DoIconvVal("BIG5","GB2312",$str);
	}
	elseif($phome==4)//GB2312->BIG5
	{
		$str=DoIconvVal("GB2312","BIG5",$str);
	}
	elseif($phome==5)//UNICODE->GB2312
	{
		$str=DoIconvVal("UNICODE","GB2312",$str);
	}
	elseif($phome==6)//UNICODE->BIG5
	{
		$str=DoIconvVal("UNICODE","BIG5",$str);
	}
	elseif($phome==7)//GB2312->UTF8
	{
		$str=DoIconvVal("GB2312","UTF8",$str);
	}
	elseif($phome==8)//BIG5->UTF8
	{
		$str=DoIconvVal("BIG5","UTF8",$str);
	}
	elseif($phome==9)//UNICODE->UTF8
	{
		$str=DoIconvVal("UNICODE","UTF8",$str);
	}
	else
	{}
	return $str;
}

//�滻�ɼ�ҳ������
function RepCjPagetextStr($text,$r){
	$text=str_replace("\\","/",$text);
	//����ת��
	$text=doCjUtfAndGbk($text,$r['enpagecode']);
	//�滻
	$text=RepInfoWord($text,$r['oldpagerep'],$r['newpagerep']);
	//�滻ҳ���������
	$text=RepPageAd($r['pagerepad'],$text);
	return $text;
}

//ȡ�õ�ַ
function EchoUrl($text,$exp,$exp1,$dr,$url,$classid,$num,$checkrnd){
	global $empire,$fun_r,$dbtbpre;
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$r=explode($e1,$text);
	//ͼƬ����
	if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	{
		$rp=explode($ep1,$text);
	}
	else
	{
		$titlepic=$dr[z_titlepicl];
	}
	for($i=1;$i<count($r)&&$i<=$num;$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		//�Ƿ���http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$url.$dourl;
		}
		//�滻��ַ
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=addslashes($dourl);
		//---------------������ݿ��Ƿ��м�¼
		if(empty($dr[recjtheurl]))//�ظ��ɼ�
		{
			$dbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$dr[tbname]." where oldurl='$dourl' limit 1");
			if($dbnum)
			{continue;}
		}
		//ͼƬ����
		if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	    {
			$rp1=explode($ep2,$rp[$i]);
			$titlepic=trim($rp1[0]);
			//�Ƿ���http
			if(strstr($titlepic,"http://")||strstr($titlepic,"https://"))
			{}
			else
			{$titlepic=$dr[qz_titlepicl].$titlepic;}
			//�滻��ַ
			$titlepic=RepCjUrlStr($titlepic);
			$titlepic=addslashes($titlepic);
	    }
		//����ַд�����ݿ�
		$sql=$empire->query("insert into {$dbtbpre}enewslinktmp(newsurl,checkrnd,titlepic) values('$dourl','$checkrnd','$titlepic');");
		echo $dourl."<br>";
	}
}

//�ɼ�ֱ������ҳ��ַ
function PageEchoUrl($classid,$cr,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	//ȡ������
	if(empty($cr[num]))
	{$cr[num]=10000;}
	//���ɼ��ֵ
	$checkrnd=md5(uniqid(microtime()).EcmsRandInt());

	$url_r=explode("\r\n",$cr[infourl]);
	$count=count($url_r);
	if($count>$cr[num])
	{
		$count=$cr[num];
	}
	for($i=0;$i<$count;$i++)
	{
		$dourl=trim($url_r[$i]);
		if(empty($dourl))
		{
			continue;
		}
		//�Ƿ���http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$cr[httpurl].$dourl;
		}
		//�滻��ַ
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=addslashes($dourl);
		//---------------������ݿ��Ƿ��м�¼
		if(empty($cr[recjtheurl]))//�ظ��ɼ�
		{
			$dbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$cr[tbname]." where oldurl='$dourl' limit 1");
			if($dbnum)
			{continue;}
		}
		//����ַд�����ݿ�
		$sql=$empire->query("insert into {$dbtbpre}enewslinktmp(newsurl,checkrnd,titlepic) values('$dourl','$checkrnd','');");
		echo $dourl."<br>";
	}
	echo $fun_r['GetUrlOver']."<script>self.location.href='ecmscj.php?enews=GetNewsInfo&classid=$classid&start=0&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."';</script>";
	exit();
}

//��ʼ�ɼ�Զ�̵�ַ
function CJUrl($classid,$start,$checkrnd,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{printerror("NotChangeCjid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select endday,num,zz_smallurl,zz_newsurl,httpurl,infourl,newsclassid,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,tbname,recjtheurl,enpagecode,pagerepad,oldpagerep,newpagerep,keeptime,infourlispage from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[newsclassid]))
	{printerror("NotCjid","history.go(-1)");}
	//ֱ������ҳ�����б�
	if($r['infourlispage'])
	{
		PageEchoUrl($classid,$r,$userid,$username);
	}
	//��������ļ�
	if($r['enpagecode'])
	{
		@include_once("doiconv.php");
	}
	//ȡ������
	if(empty($r[num]))
	{$r[num]=10000;}
	if(empty($r[relistnum]))
	{$r[relistnum]=1;}
	if(empty($start))
	{
		$start=0;
		//���ɼ��ֵ
		$checkrnd=md5(uniqid(microtime()).EcmsRandInt());
	}
	$exp="newsurl";
	$exp1="titlepic";
	//�鿴�Ƿ����
	$b=0;
	$p=0;
	$url_r=explode("\r\n",$r[infourl]);
	$j=count($url_r);
	for($i=$start;$i<$j&&$p<$r[relistnum];$i++)
	{
		$p++;
		$b=1;
		$dourl=trim($url_r[$i]);
		if(empty($dourl)||!eCheckCjUrl($dourl,1))
		{continue;}
		//��ȡҳ��
		for($readnum=0;$readnum<3;$readnum++)
		{
			$text1=ReadFiletext($dourl);
			if(!empty($text1))
			{break;}
		}
		if(empty($text1))
		{continue;}
		//�滻�س�
		$text1=ReplaceFc($text1);
		//�滻��ҳ����
		$text1=RepCjPagetextStr($text1,$r);
		//�����
		if($r[zz_smallurl])
		{
			$text1=ReturnCJ_str($r[zz_smallurl],"smallurl",$text1);
			if(empty($text1))
			{
				continue;
			}
		}
		//�滻��������
		$text=stripSlashes(stripSlashes($r[zz_newsurl]));
		//�滻�س�
		$text=ReplaceFc($text);
		$zztext=RepInfoZZ($text,$exp,0);
		$strtext=GetInfoStr($text,$exp,1);
		if($text)
		{
			$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
		}
		//�滻����ͼƬ��ַ
		if($r[zz_titlepicl]&&!$r[z_titlepicl])
		{
			$text=stripSlashes(stripSlashes($r[zz_titlepicl]));
			//�滻�س�
			$text=ReplaceFc($text);
			$zztext=RepInfoZZ($text,$exp1,0);
			$strtext=GetInfoStr($text,$exp1,1);
			if($text)
			{
				$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
			}
		}
		//����д�����ݿ�
		EchoUrl($text1,$exp,$exp1,$r,$r[httpurl],$classid,$r[num],$checkrnd);
	}
	$newstart=$i;
	//�ɼ��������
	if(empty($b))
	{
		echo $fun_r['GetUrlOver']."<script>self.location.href='ecmscj.php?enews=GetNewsInfo&classid=$classid&start=0&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	//echo $fun_r['GetOneListUrl']."<script>self.location.href='ecmscj.php?enews=CjUrl&classid=$classid&start=$newstart&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."';</script>";
	echo"<meta http-equiv=\"refresh\" content=\"".$r['keeptime'].";url=ecmscj.php?enews=CjUrl&classid=$classid&start=$newstart&checkrnd=$checkrnd".hReturnEcmsHashStrHref(0)."\">".$fun_r['GetOneListUrl'];
	exit();
}

//###################�ɼ�ҳ���б�##################
function ViewCjList($classid,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{printerror("NotChangeCjid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select endday,num,zz_smallurl,zz_newsurl,httpurl,infourl,newsclassid,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,infourlispage from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[newsclassid]))
	{printerror("NotCjid","history.go(-1)");}
	//ֱ������ҳ�б�
	if($r[infourlispage])
	{
		PageViewCjList($classid,$r,$userid,$username);
	}
	$url_r=explode("\r\n",$r[infourl]);
	$j=count($url_r);
	$ecmshashhref=hReturnEcmsHashStrHref(0);
	for($i=0;$i<$j;$i++)
	{
		if(empty($url_r[$i]))
		{continue;}
		$dourl=urlencode($url_r[$i]);
		$data.="<tr><td><a href='".$url_r[$i]."' target=_blank>".$url_r[$i]."</a></td><td align=center>[<a href='ecmscj.php?enews=ViewCjUrl&classid=$classid".$ecmshashhref."&listpage=".$dourl."' target=_blank>".$fun_r['view']."</a>]</td></tr>";
    }
	$data="<p align=center><b>".$fun_r['CjListUrl']."</b></p><table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=70% align=center><b>URL</b></td><td align=center><b>VIEW</b></td></tr>".$data."</table>";
	echo $data;
	exit();
}

//###################�ɼ�����ҳ���б�##################
function PageViewCjList($classid,$cr,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	//ȡ������
	if(empty($cr[num]))
	{$cr[num]=10000;}
	$url_r=explode("\r\n",$cr[infourl]);
	$count=count($url_r);
	if($count>$cr[num])
	{
		$count=$cr[num];
	}
	$ecmshashhref=hReturnEcmsHashStrHref(0);
	for($i=0;$i<$count;$i++)
	{
		$dourl=trim($url_r[$i]);
		if(empty($dourl))
		{
			continue;
		}
		//�Ƿ���http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$cr[httpurl].$dourl;
		}
		//�滻��ַ
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=urlencode($dourl);
		$data.="<tr><td><a href='".$url_r[$i]."' target=_blank>".$url_r[$i]."</a></td><td align=center>[<a href='ecmscj.php?enews=ViewGetNewsInfo&classid=$classid".$ecmshashhref."&newspage=".$dourl."' target=_blank>".$fun_r['view']."</a>]</td></tr>";
    }
	$data="<p align=center><b>".$fun_r['CjListUrl']."</b></p><table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=70% align=center><b>URL</b></td><td align=center><b>VIEW</b></td></tr>".$data."</table>";
	echo $data;
	exit();
}

//#################Ԥ���ɼ��б�
function ViewCjUrl($classid,$listpage,$userid,$username){
	global $empire,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid)||empty($listpage))
	{printerror("NotChangeCjid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select endday,num,zz_smallurl,zz_newsurl,httpurl,infourl,newsclassid,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,tbname,recjtheurl,enpagecode,pagerepad,oldpagerep,newpagerep from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[newsclassid]))
	{printerror("NotCjid","history.go(-1)");}
	//��������ļ�
	if($r['enpagecode'])
	{
		@include_once("doiconv.php");
	}
	//ȡ������
	if(empty($r[num]))
	{$r[num]=10000;}
	$exp="newsurl";
	$exp1="titlepic";
	$dourl=$listpage;
	eCheckCjUrl($dourl,0);
	//��ȡҳ��
	for($readnum=0;$readnum<3;$readnum++)
	{
		$text1=ReadFiletext($dourl);
		if(!empty($text1))
		{break;}
	}
	if(empty($text1))
	{
		printerror("FailCjUrl","history.go(-1)");
	}
	//�滻�س�
	$text1=ReplaceFc($text1);
	//�滻��ҳ����
	$text1=RepCjPagetextStr($text1,$r);
	//�����
	if($r[zz_smallurl])
	{
		$text1=ReturnCJ_str($r[zz_smallurl],"smallurl",$text1);
		if(empty($text1))
		{
			printerror("EmptyCjSmallUrl","history.go(-1)");
		}
	 }
	 //�滻��������
	$text=stripSlashes(stripSlashes($r[zz_newsurl]));
	 //�滻�س�
	$text=ReplaceFc($text);
	$zztext=RepInfoZZ($text,$exp,0);
	$strtext=GetInfoStr($text,$exp,1);
	if($text)
	{
		$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
	}
	//�滻����ͼƬ��ַ
	if($r[zz_titlepicl]&&!$r[z_titlepicl])
	{
		$text=stripSlashes(stripSlashes($r[zz_titlepicl]));
		//�滻�س�
		$text=ReplaceFc($text);
		$zztext=RepInfoZZ($text,$exp1,0);
		$strtext=GetInfoStr($text,$exp1,1);
		if($text)
		{
			$text1=stripSlashes(preg_replace($zztext,$strtext,$text1));
		}
	}
	//�����ַ
	echo"<p align=center><b>".$fun_r['CjListPageUrl']."</b></p><table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=70% align=center><b>URL</b></td><td align=center><b>VIEW</b></td></tr>";
	ViewEchoUrl($text1,$exp,$exp1,$r,$r[httpurl],$classid,$r[num],$checkrnd);
	echo"</table>";
	exit();
}

//################����ɼ�ҳ��
function ViewEchoUrl($text,$exp,$exp1,$dr,$url,$classid,$num,$checkrnd){
	global $empire,$fun_r,$dbtbpre;
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$r=explode($e1,$text);
	//ͼƬ����
	if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	{
		$rp=explode($ep1,$text);
	}
	else
	{
		$titlepic=$dr[z_titlepicl];
	}
	$ecmshashhref=hReturnEcmsHashStrHref(0);
	for($i=1;$i<count($r)&&$i<=$num;$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		//�Ƿ���http
		if(strstr($dourl,"http://")||strstr($dourl,"https://"))
		{}
		else
		{
			$dourl=$url.$dourl;
		}
		//�滻��ַ
		$dourl=RepCjUrlStr($dourl);
		if(empty($dourl))
		{continue;}
		$dourl=addslashes($dourl);
		//������ݿ��Ƿ��м�¼
		if(empty($dr[recjtheurl]))
		{
			$dbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$dr[tbname]." where oldurl='$dourl' limit 1");
			if($dbnum)
			{continue;}
		}
		//ͼƬ����
		if(!$dr[z_titlepicl]&&$dr[zz_titlepicl])
	    {
			$rp1=explode($ep2,$rp[$i]);
			$titlepic=trim($rp1[0]);
			//�Ƿ���http
			if(strstr($titlepic,"http://")||strstr($titlepic,"https://"))
			{}
			else
			{$titlepic=$dr[qz_titlepicl].$titlepic;}
			//�滻��ַ
			$titlepic=RepCjUrlStr($titlepic);
			$titlepic=addslashes($titlepic);
	    }
		if($titlepic)
		{$a="<br>(PIC:<a href='".$titlepic."' target=_blank>".$titlepic."</a>)";}
		echo "<tr><td><a href='".$dourl."' target=_blank>".$dourl."</a>".$a."</td><td align=center>[<a href='ecmscj.php?enews=ViewGetNewsInfo&classid=$classid".$ecmshashhref."&newspage=".urlencode($dourl)."' target=_blank>".$fun_r['view']."</a>]</td></tr>";
	}
}


//#################################
//ȡ�����ص�ַ
function GetCjDownpath($text,$text1,$exp,$exp1,$url,$online=0){
	global $empire,$fun_r;
	if($online)
	{
		$fun_r[DownPath]="";
    }
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$r=explode($e1,$text);
	//����
	if($text1)
	{
		$rp=explode($ep1,$text1);
	}
	$p=0;
	for($i=1;$i<count($r);$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		if(empty($dourl))
		{continue;}
		if(!strstr($dourl,"://"))
		{
			$dourl=$url.$dourl;
		}
		if($text1)
		{
			$rp1=explode($ep2,$rp[$i]);
			$doname=trim($rp1[0]);
			if(empty($doname))
			{
				$doname=$fun_r[DownPath].($p+1);
			}
		}
		else
		{
			$doname=$fun_r[DownPath].($p+1);
		}
		$downname[$p]=$doname;
		$downpath[$p]=$dourl;
		$p++;
	}
	$down=ReturnDownpath($downname,$downpath,$delpathid,$pathid,$downuser,$fen,$thedownqz,$add,$foruser,$downurl,0);
	return $down;
}

//ȡ��ͼƬ����ַ
function GetCjMorepicpath($text,$text1,$text2,$exp,$exp1,$exp2,$url){
	global $empire,$public_r;
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$ep1="[phome-".$exp1."]";
	$ep2="[/phome-".$exp1."]";
	$epp1="[phome-".$exp2."]";
	$epp2="[/phome-".$exp2."]";
	$r=explode($e1,$text);
	//��ͼ
	if($text1)
	{
		$rp=explode($ep1,$text1);
	}
	//����
	if($text2)
	{
		$rpp=explode($epp1,$text2);
	}
	$p=0;
	for($i=1;$i<count($r);$i++)
	{
		$r1=explode($e2,$r[$i]);
		$dourl=trim($r1[0]);
		if(empty($dourl))
		{continue;}
		if(!strstr($dourl,"://"))
		{
			$dourl=$url.$dourl;
		}
		//��ͼ
		if($text1)
		{
			$rp1=explode($ep2,$rp[$i]);
			$dobigurl=trim($rp1[0]);
			if(!empty($dobigurl))
			{
				if(!strstr($dobigurl,"://"))
				{
					$dobigurl=$url.$dobigurl;
				}
			}
		}
		else
		{
			$dobigurl="";
		}
		//ͼƬ����
		if($text2)
		{
			$rpp1=explode($epp2,$rpp[$i]);
			$doname=trim($rpp1[0]);
		}
		else
		{
			$doname="";
		}
		$smallpic[$p]=$dourl;
		$bigpic[$p]=$dobigurl;
		$picname[$p]=$doname;
		$p++;
	}
	$down=ReturnMorepicpath($smallpic,$bigpic,$picname,$delpicid,$picid,$add,$downurl,0,0,$public_r['filedeftb']);
	return $down;
}

//����ҳ��ҳ����-��һҳʽ
function GetMoreCjPagetext($self,$newstextzz,$smallpagezz,$pagezz,$pagetype,$firsttext,$the_r){
	if(empty($pagezz)||empty($newstextzz))
	{return "";}
	//�Ƿ�����ҳ
	$addpagetag=empty($the_r['doaddtextpage'])?'[!--empirenews.page--]':'';
	//ȡ�õ�ַǰ׺
	$sr=GetPageurlQz($self);
	$pagetext=$firsttext;
	$allpagetext="";
	for($i=0;$i<100;$i++)
	{
		//��������
		if($smallpagezz)
		{
			$pagetext=ReturnCJ_str($smallpagezz,"smallpagezz",$pagetext);
		}
		$nextlink=ReturnCJ_str($pagezz,"pagezz",$pagetext);
		if(empty($nextlink))
		{
			break;
		}
		if(!strstr($nextlink,"://"))
		{
			//��Ŀ¼��ʼ
			if(strstr($nextlink,"/"))
			{
				$nextlink=$sr[domain].$nextlink;
			}
			else
			{
				$nextlink=$sr[selfqz].$nextlink;
			}
		}
		$nextlink=RepCjUrlStr($nextlink);
		if($nextlink==$self||!eCheckCjUrl($nextlink,1))
		{continue;}
		//ȡ��Զ������
		for($j=0;$j<3;$j++)
		{
			$pagetext=ReadFiletext($nextlink);
			if($pagetext)
			{
				break;
			}
		}
		//ҳ�治����
		if(empty($pagetext))
		{
			break;
		}
		//�滻��ҳ����
	    $pagetext=RepCjPagetextStr($pagetext,$the_r);
		//�滻�س�
		$pagetext=ReplaceFc($pagetext);
		$newstext=ReturnCJ_str($newstextzz,"newstext",$pagetext);
		if($newstext)
		{
			$allpagetext.=$addpagetag.$newstext;
		}
	}
	return $allpagetext;
}

//����ҳ��ҳ����-ȫ���б�ʽ
function GetMoreCjPagetextall($self,$newstextzz,$smallpagezz,$pagezz,$pagetype,$firsttext,$the_r){
	if(empty($pagezz)||empty($newstextzz))
	{return "";}
	//�Ƿ�����ҳ
	$addpagetag=empty($the_r['doaddtextpage'])?'[!--empirenews.page--]':'';
	$exp="pageallzz";
	//ȡ�õ�ַǰ׺
	$sr=GetPageurlQz($self);
	$pagetext=$firsttext;
	$allpagetext="";
	//��������
	if($smallpagezz)
	{
		$pagetext=ReturnCJ_str($smallpagezz,"smallpageallzz",$pagetext);
	}
	//��ҳ
	$text=stripSlashes(stripSlashes($pagezz));
	//�滻�س�
	$text=ReplaceFc($text);
	$zztext=RepInfoZZ($text,$exp,0);
	$strtext=GetInfoStr($text,$exp,1);
	$pagetext=stripSlashes(preg_replace($zztext,$strtext,$pagetext));
	$e1="[phome-".$exp."]";
	$e2="[/phome-".$exp."]";
	$r=explode($e1,$pagetext);
	$count=count($r);
	for($i=1;$i<$count;$i++)
	{
		$r1=explode($e2,$r[$i]);
		$nextlink=trim($r1[0]);
		if(empty($nextlink))
		{continue;}
		if(!strstr($nextlink,"://"))
		{
			//��Ŀ¼��ʼ
			if(strstr($nextlink,"/"))
			{
				$nextlink=$sr[domain].$nextlink;
			}
			else
			{
				$nextlink=$sr[selfqz].$nextlink;
			}
		}
		$nextlink=RepCjUrlStr($nextlink);
		if($nextlink==$self||!eCheckCjUrl($nextlink,1))
		{continue;}
		//ȡ��Զ������
		for($j=0;$j<3;$j++)
		{
			$pagetext=ReadFiletext($nextlink);
			if($pagetext)
			{
				break;
			}
		}
		//ҳ�治����
		if(empty($pagetext))
		{
			continue;
		}
		//�滻��ҳ����
	    $pagetext=RepCjPagetextStr($pagetext,$the_r);
		//�滻�س�
		$pagetext=ReplaceFc($pagetext);
		$newstext=ReturnCJ_str($newstextzz,"newstext",$pagetext);
		if($newstext)
		{
			$allpagetext.=$addpagetag.$newstext;
		}
	}
	return $allpagetext;
}

//�ɼ�ʱ���ʽת��
function CjFormatNewstime($newstime){
	$newstime=str_replace(array('��','��','��','.','ʱ','��','��','/'),array('-','-','','-',':',':','','-'),$newstime);
	return $newstime;
}

//�ɼ���Ϣ�ļ�
function GetNewsInfo($classid,$checkrnd,$start,$userid,$username){
	global $empire,$class_r,$fun_r,$dbtbpre;
	$userid=(int)$userid;
	$classid=(int)$classid;
	$start=(int)$start;
	$checkrnd=RepPostVar($checkrnd);
	if(empty($classid)||empty($checkrnd))
	{printerror("FailCX","ListInfoClass.php".hReturnEcmsHashStrHref2(1));}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	//����
	$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
	//���������
	$r=TogTwoArray($r,$ra);
	//��������ļ�
	if($r['enpagecode'])
	{
		@include_once(ECMS_PATH."e/class/doiconv.php");
	}
	//ȡ��ģ��
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj,tid,tbname from {$dbtbpre}enewsmod where mid='".$class_r[$r[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$count=count($cjr);
	if(empty($start))
	{$start=0;}
	$b=0;
	$sql=$empire->query("select linkid,newsurl,titlepic from {$dbtbpre}enewslinktmp where checkrnd='$checkrnd' and linkid>".$start." order by linkid limit ".$r[renum]);
	//�ɼ�ʱ��
	$newstime=date("Y-m-d H:i:s");
    $truetime=time();
	$tmptime=$newstime;
	while($nr=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$nr[linkid];
		if(!eCheckCjUrl($nr[newsurl],1))
		{
			continue;
		}
		//������ݿ��Ƿ��м�¼
		if(empty($r[recjtheurl]))
		{
			$tmpnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$r[tbname]." where oldurl='$nr[newsurl]' limit 1");
			if($tmpnum)
			{continue;}
		}
		//ȡ��Զ��ҳ�棬����ȡ����ֵ�Ľ���ȡֵ
		for($i=1;$i<=3;$i++)
		{
			$info=ReadFiletext($nr[newsurl]);
			if(!empty($info))
			{
				break;
			}
		}
		if(empty($info))
		{continue;}
		//�滻��ҳ����
	    $info=RepCjPagetextStr($info,$r);
		//�滻�س�
		$info=ReplaceFc($info);
		//-----------------
		$ifield="";
		$ivalue="";
		$next=0;
		for($c=0;$c<$count-1;$c++)
		{
			$zzvalue="";
			$cjr1=explode($field,$cjr[$c]);
			$dofield=$cjr1[1];
			$var="zz_".$dofield;
			$var1="z_".$dofield;
			$var2="qz_".$dofield;
			$var3="save_".$dofield;
			//����ͼƬ
			if($dofield=="titlepic")
			{
				if($nr[titlepic])
				{
					$zzvalue=$nr[titlepic];
					$ifield.=",".$dofield;
			        $ivalue.=",'".addslashes($zzvalue)."'";
					continue;
				}
			}
			//ͼƬ��
			if($dofield=="morepic"&&$r[$var])
			{
				//�滻��������
	            $text=$r[$var];
				//�滻�س�
				$text=ReplaceFc($text);
				$down=explode("[!empirecms!]",$text);
				//Сͼ
	            $zztext=RepInfoZZ($down[0],"ecmsspicurl",0);
	            $strtext=GetInfoStr($down[0],"ecmsspicurl",1);
	            $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
				//��ͼ
				if($down[1])
				{
					$zztext=RepInfoZZ($down[1],"ecmsbpicurl",0);
	                $strtext=GetInfoStr($down[1],"ecmsbpicurl",1);
	                $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				//����
				if($down[2])
				{
					$zztext=RepInfoZZ($down[2],"ecmspicname",0);
	                $strtext=GetInfoStr($down[2],"ecmspicname",1);
	                $text3=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				$zzvalue=GetCjMorepicpath($text1,$text2,$text3,"ecmsspicurl","ecmsbpicurl","ecmspicname",$r[$var2]);
				$ifield.=",".$dofield;
			    $ivalue.=",'".addslashes($zzvalue)."'";
				continue;
			}
			//���ص�ַ
			if($dofield=="downpath"&&$r[$var])
			{
				//�滻��������
	            $text=$r[$var];
				//�滻�س�
				$text=ReplaceFc($text);
				$down=explode("[!empirecms!]",$text);
				//��ַ
	            $zztext=RepInfoZZ($down[0],"ecmsdownpathurl",0);
	            $strtext=GetInfoStr($down[0],"ecmsdownpathurl",1);
	            $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
				//����
				if($down[1])
				{
					$zztext=RepInfoZZ($down[1],"ecmsdownpathname",0);
	                $strtext=GetInfoStr($down[1],"ecmsdownpathname",1);
	                $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				$zzvalue=GetCjDownpath($text1,$text2,"ecmsdownpathurl","ecmsdownpathname",$r[$var2],0);
				$ifield.=",".$dofield;
			    $ivalue.=",'".addslashes($zzvalue)."'";
				continue;
			}
			//���ߵ�ַ
			if($dofield=="onlinepath"&&$r[$var])
			{
				//�滻��������
	            $text=$r[$var];
				//�滻�س�
				$text=ReplaceFc($text);
				$down=explode("[!empirecms!]",$text);
				//��ַ
	            $zztext=RepInfoZZ($down[0],"ecmsonlinepathurl",0);
	            $strtext=GetInfoStr($down[0],"ecmsonlinepathurl",1);
	            $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
				//����
				if($down[1])
				{
					$zztext=RepInfoZZ($down[1],"ecmsonlinepathname",0);
	                $strtext=GetInfoStr($down[1],"ecmsonlinepathname",1);
	                $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
				}
				$zzvalue=GetCjDownpath($text1,$text2,"ecmsonlinepathurl","ecmsonlinepathname",$r[$var2],1);
				$ifield.=",".$dofield;
			    $ivalue.=",'".addslashes($zzvalue)."'";
				continue;
			}
			if(empty($r[$var1]))
			{
				if($r[$var])
				{
					$zzvalue=ReturnCJ_str($r[$var],$dofield,$info);
					if($zzvalue)
					{
						$zzvalue=$r[$var2].$zzvalue;
				    }
				}
			}
			else
			{$zzvalue=$r[$var1];}
			//------------------------------��Ϣʱ��
			if($dofield=="newstime")
			{
				$newstime=$zzvalue;
				if(empty($newstime))
				{
					$newstime=$tmptime;
				}
				else
				{
					$newstime=CjFormatNewstime($newstime);//ʱ��ת��
				}
				continue;
			}
			//------------------------------��Ϣ��Դ
			if($dofield=="befrom"||$dofield=="writer")
			{
				//����ȥ��html����
		        $zzvalue=strip_tags(str_replace("\r\n","",$zzvalue));
			}
			//------------------------------����
			if($dofield=="title")
			{
				//����ȥ��html����
		        $zzvalue=ehtmlspecialchars(strip_tags(str_replace("\r\n","",$zzvalue)));
				if(empty($zzvalue))
				{
					$next=1;
					break;
				}
				$keyboard=sub($zzvalue,0,$r[keynum],false);
				//�����Ƿ�����ؼ���
				if($r[keyboard])
				{
					$t=HaveKeyboard($zzvalue,$r[keyboard]);
					if(empty($t))
					{
						$next=1;
						break;
					}
				}
				if($r[retitlewriter])//������ȫһ��
				{
					//���Ƚ�
					$onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title='".addslashes($zzvalue)."' and classid='$r[newsclassid]' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					/*�ɼ���Ƚ�
					$onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title='".addslashes($zzvalue)."' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					*/
				}
				if($r[titlelen])//��������
				{
					//���Ƚ�
					$c_title=addslashes(sub($zzvalue,0,$r[titlelen],false));
					$onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title like '%$c_title%' and classid='$r[newsclassid]' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					/*�ɼ��Ƚ�
					$onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title like '%$c_title%' limit 1");
					if($onum)
					{
						$next=1;
						break;
					}
					*/
				}
			}
			//�������ݷ�ҳ
			if($dofield=="newstext")
			{
				//�Ƿ��з�ҳ
				if($r[pagezz]||$r[pageallzz])
				{
					//����ҳʽ
					if(empty($r[pagetype]))
					{
						$zzvalue.=GetMoreCjPagetext($nr[newsurl],$r[$var],$r[smallpagezz],$r[pagezz],$r[pagetype],$info,$r);
					}
					//ȫ���б�ʽ
					else
					{
						$zzvalue.=GetMoreCjPagetextall($nr[newsurl],$r[$var],$r[smallpageallzz],$r[pageallzz],$r[pagetype],$info,$r);
					}
				}
			}
			//�滻�ؼ���
			if(stristr($r['repf'],','.$dofield.','))
			{
				$zzvalue=RepInfoWord($zzvalue,$r[oldword],$r[newword]);
			}
			//������
			if(stristr($r['repadf'],','.$dofield.','))
			{
				$zzvalue=RepAd($r[repad],$zzvalue);
			}
			//��������
			if(stristr($r['isnullf'],','.$dofield.','))
			{
				$ckzzvalue=trim($zzvalue);
				if($r['newstextisnull']==1&&empty($ckzzvalue))
				{
					$next=1;
					break;
				}
			}

			$ifield.=",".$dofield;
			$ivalue.=",'".addslashes($zzvalue)."'";
		}
		if($next)
		{continue;}
		//����ʱ��
		$isql=$empire->query("insert into {$dbtbpre}ecms_infotmp_".$r[tbname]."(classid,oldurl,checked,keyboard,newstime,truetime,tmptime,userid,username".$ifield.") values($classid,'$nr[newsurl]',0,'".addslashes($keyboard)."','$newstime',$truetime,'$tmptime',$userid,'".addslashes($username)."'".$ivalue.");");
    }
	//�ɼ�����
	if(empty($b))
	{
		//ɾ����¼
		$del=$empire->query("delete from {$dbtbpre}enewslinktmp where checkrnd='$checkrnd'");
		//�������ʱ��
		$ucjsql=$empire->query("update {$dbtbpre}enewsinfoclass set lasttime='".time()."' where classid='$classid'");
		//�Զ����
		if($r['justloadin'])
		{
			echo $fun_r['cjLoadInInfos']."<script>self.location.href='ecmscj.php?enews=CjNewsIn_all&classid=$classid&checked=$r[justloadcheck]&fm=1".hReturnEcmsHashStrHref(0)."';</script>";
			exit();
		}
		//�����ڵ�
		if(getcvar('recjnum',1)==1)
		{
			echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><font color=red>".$fun_r['CjSuccess']."</font><script>parent.location.href='CheckCj.php?classid=$classid".hReturnEcmsHashStrHref2(0)."';</script>";
		}
		else
		{
			echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><body topmargin=0><font color=red>".$r[classname]."  ".$fun_r['CjSuccess']."</font>,  <input type=button name=button value='".$fun_r['OnlickLoadInCj']."' onclick=\"window.open('CheckCj.php?classid=$classid".hReturnEcmsHashStrHref2(0)."');\">";
			echo"<script>parent.checkrecj.location.href='CheckReCj.php".hReturnEcmsHashStrHref2(1)."';</script></body>";
		}
		exit();
	}
	//echo"(ID:<font color=red><b>".$newstart."</b></font>)<script>self.location.href='ecmscj.php?enews=GetNewsInfo&checkrnd=$checkrnd&classid=$classid&start=$newstart".hReturnEcmsHashStrHref(0)."';</script>";
	echo"<meta http-equiv=\"refresh\" content=\"".$r['keeptime'].";url=ecmscj.php?enews=GetNewsInfo&checkrnd=$checkrnd&classid=$classid&start=$newstart".hReturnEcmsHashStrHref(0)."\">".$r[classname]." (ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

//#################�����ɼ��ļ�Ԥ��################
function ViewGetNewsInfo($classid,$newspage,$userid,$username){
	global $empire,$class_r,$fun_r,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid)||empty($newspage))
	{printerror("FailCX","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(empty($r[classid]))
	{printerror("FailCX","history.go(-1)");}
	//����
	$ra=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
	//���������
	$r=TogTwoArray($r,$ra);
	//��������ļ�
	if($r['enpagecode'])
	{
		@include_once("doiconv.php");
	}
	//ȡ��ģ��
	$record="<!--record-->";
	$field="<!--field--->";
	$mr=$empire->fetch1("select cj from {$dbtbpre}enewsmod where mid='".$class_r[$r[newsclassid]][modid]."'");
	$cjr=explode($record,$mr[cj]);
	$count=count($cjr);
	//�ɼ�ʱ��
	$newstime=date("Y-m-d H:i:s");
	eCheckCjUrl($newspage,0);
	//������ݿ��Ƿ��м�¼
	if(empty($r[recjtheurl]))
	{
		$tmpnum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_infotmp_".$r[tbname]." where oldurl='$newspage' limit 1");
		if($tmpnum)
		{
			echo $fun_r['ReCj'];
			exit();
	    }
	}
	//ȡ��Զ��ҳ�棬����ȡ����ֵ�Ľ���ȡֵ
	for($i=1;$i<=3;$i++)
	{
		$info=ReadFiletext($newspage);
		if(!empty($info))
		{
			break;
	    }
	}
	if(empty($info))
	{
		echo $fun_r['CanNotOpenUrl'];
		exit();
	}
	//�滻��ҳ����
	$info=RepCjPagetextStr($info,$r);
	//�滻�س�
	$info=ReplaceFc($info);
	//-----------------
	$ifield="";
	$ivalue="";
	$next=0;
	for($c=0;$c<$count-1;$c++)
	{
		$zzvalue="";
		$cjr1=explode($field,$cjr[$c]);
		$dofield=$cjr1[1];
		$dofieldname=$cjr1[0];
		$var="zz_".$dofield;
		$var1="z_".$dofield;
		$var2="qz_".$dofield;
		$var3="save_".$dofield;
		//ͼƬ��
		if($dofield=="morepic"&&$r[$var])
		{
			//�滻��������
	        $text=stripSlashes(stripSlashes($r[$var]));
			//�滻�س�
			$text=ReplaceFc($text);
			$down=explode("[!empirecms!]",$text);
			//Сͼ
	        $zztext=RepInfoZZ($down[0],"ecmsspicurl",0);
	        $strtext=GetInfoStr($down[0],"ecmsspicurl",1);
	        $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
			//��ͼ
			if($down[1])
			{
				$zztext=RepInfoZZ($down[1],"ecmsbpicurl",0);
	            $strtext=GetInfoStr($down[1],"ecmsbpicurl",1);
	            $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			//����
			if($down[2])
			{
				$zztext=RepInfoZZ($down[2],"ecmspicname",0);
	            $strtext=GetInfoStr($down[2],"ecmspicname",1);
	            $text3=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			$zzvalue=GetCjMorepicpath($text1,$text2,$text3,"ecmsspicurl","ecmsbpicurl","ecmspicname",$r[$var2]);
			$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
				continue;
		}
		//���ص�ַ
		if($dofield=="downpath"&&$r[$var])
		{
			//�滻��������
	        $text=stripSlashes(stripSlashes($r[$var]));
			//�滻�س�
			$text=ReplaceFc($text);
			$down=explode("[!empirecms!]",$text);
			//��ַ
	        $zztext=RepInfoZZ($down[0],"ecmsdownpathurl",0);
	        $strtext=GetInfoStr($down[0],"ecmsdownpathurl",1);
	        $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
			//����
			if($down[1])
			{
				$zztext=RepInfoZZ($down[1],"ecmsdownpathname",0);
	            $strtext=GetInfoStr($down[1],"ecmsdownpathname",1);
	            $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			$zzvalue=GetCjDownpath($text1,$text2,"ecmsdownpathurl","ecmsdownpathname",$r[$var2],0);
			$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
			continue;
		}
		//���ߵ�ַ
		if($dofield=="onlinepath"&&$r[$var])
		{
			//�滻��������
	        $text=stripSlashes(stripSlashes($r[$var]));
			//�滻�س�
			$text=ReplaceFc($text);
			$down=explode("[!empirecms!]",$text);
			//��ַ
	        $zztext=RepInfoZZ($down[0],"ecmsonlinepathurl",0);
	        $strtext=GetInfoStr($down[0],"ecmsonlinepathurl",1);
	        $text1=stripSlashes(preg_replace($zztext,$strtext,$info));
			//����
			if($down[1])
			{
				$zztext=RepInfoZZ($down[1],"ecmsonlinepathname",0);
	            $strtext=GetInfoStr($down[1],"ecmsonlinepathname",1);
	            $text2=stripSlashes(preg_replace($zztext,$strtext,$info));
			}
			$zzvalue=GetCjDownpath($text1,$text2,"ecmsonlinepathurl","ecmsonlinepathname",$r[$var2],1);
			$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
			continue;
		}

		if(empty($r[$var1]))
		{
			if($r[$var])
			{
				$zzvalue=ReturnCJ_str($r[$var],$dofield,$info);
				if($zzvalue)
				{
					$zzvalue=$r[$var2].$zzvalue;
				}
			}
		}
		else
		{$zzvalue=$r[$var1];}
		//------------------------------��Ϣ��Դ
		if($dofield=="befrom"||$dofield=="writer")
		{
			//����ȥ��html����
		    $zzvalue=strip_tags(str_replace("\r\n","",$zzvalue));
		}
		//------------------------------����
		if($dofield=="title")
		{
			//����ȥ��html����
		    $zzvalue=ehtmlspecialchars(strip_tags(str_replace("\r\n","",$zzvalue)));
			if(empty($zzvalue))
			{
				echo $fun_r['CjEmptyTitle'];
			    exit();
			}
			//�����Ƿ�����ؼ���
			if($r[keyboard])
			{
				$t=HaveKeyboard($zzvalue,$r[keyboard]);
		        if(empty($t))
			    {
					echo $fun_r['CjTitleKey'];
			        exit();
		        }
			}
			if($r[retitlewriter])//������ȫһ��
		    {
			   //���Ƚ�
			   $onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title='".addslashes($zzvalue)."' and classid='$r[newsclassid]' limit 1");
			   if($onum)
			   {
					echo $fun_r['CjReTitleWriter'];
					exit();
			   }
				/*�ɼ���Ƚ�
				$onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title='".addslashes($zzvalue)."' limit 1");
				if($onum)
				{
					echo $fun_r['CjReTitleWriter'];
					exit();
				}
				*/
		    }
		    if($r[titlelen])//��������
		    {
			  //���Ƚ�
			  $c_title=addslashes(sub($zzvalue,0,$r[titlelen],false));
			  $onum=$empire->gettotal("select count(*) as total from {$dbtbpre}ecms_".$class_r[$r[newsclassid]][tbname]." where title like '%$c_title%' and classid='$r[newsclassid]' limit 1");
			  if($onum)
			  {
				echo $fun_r['CjSingTitlelen'].$r[titlelen].$fun_r['CjSingTitlelenL'];
				exit();
			  }
			  /*�ɼ��Ƚ�
			  $onum=$empire->num("select id from {$dbtbpre}ecms_infotmp_".$r[tbname]." where title like '%$c_title%' limit 1");
			  if($onum)
			  {
				echo $fun_r['CjSingTitlelen'].$r[titlelen].$fun_r['CjSingTitlelenL'];
				exit();
			  }
			  */
		    }
		}
		//�������ݷ�ҳ
		if($dofield=="newstext")
		{
			//�Ƿ��з�ҳ
			if($r[pagezz]||$r[pageallzz])
			{
				//����ҳʽ
				if(empty($r[pagetype]))
				{
					$zzvalue.=GetMoreCjPagetext($newspage,$r[$var],$r[smallpagezz],$r[pagezz],$r[pagetype],$info,$r);
				}
				//ȫ���б�ʽ
				else
				{
					$zzvalue.=GetMoreCjPagetextall($newspage,$r[$var],$r[smallpageallzz],$r[pageallzz],$r[pagetype],$info,$r);
				}
			}
		}
		//�滻�ؼ���
		if(stristr($r['repf'],','.$dofield.','))
		{
			$zzvalue=RepInfoWord($zzvalue,$r[oldword],$r[newword]);
		}
		//�滻���
		if(stristr($r['repadf'],','.$dofield.','))
		{
			$zzvalue=RepAd($r[repad],$zzvalue);
		}
		//��������
		if(stristr($r['isnullf'],','.$dofield.','))
		{
			$ckzzvalue=trim($zzvalue);
			if($r['newstextisnull']==1&&empty($ckzzvalue))
			{
				echo $dofield.$fun_r['CjEmptyNewstext'];
			    exit();
			}
		}
		$data.="<tr><td><b>".$dofieldname."<br>(".$dofield.")</b></td><td>".$zzvalue."</td></tr>";
	}
	//�������
	$data="<table width='96%' border=1 align=center cellpadding=3 cellspacing=0>
  <tr><td width=30% align=center><b>VAR</b></td><td align=center><b>GET</b></td></tr><tr><td><b>".$fun_r['ViewCjPage']."</b></td><td><a href='".$newspage."' target=_blank>".$newspage."</a></td></tr>".$data."</table>";
	echo $data;
	exit();
}

//�Ƿ��йؼ���
function HaveKeyboard($title,$keyboard) {
	$r=explode(",",$keyboard);
	$b=0;
	for($i=0;$i<count($r);$i++)
	{
		$cr=explode($r[$i],$title);
		if(count($cr)<>1)
		{
			$b=1;
			break;
		}
	}
	return $b;
}

//�滻�ؼ���
function RepInfoWord($title,$oldword,$newword){
	if(empty($oldword))
	{
		return $title;
	}
	$oldword=stripSlashes($oldword);
	$newword=stripSlashes($newword);
	//�滻�س�
	$oldword=ReplaceFc($oldword);
	$newword=ReplaceFc($newword);
	$repmore=0;
	if(strstr($newword,","))
	{
		$repmore=1;
		$nr=explode(",",$newword);
	}
	$r=explode(",",$oldword);
	for($i=0;$i<count($r);$i++)
	{
		//�滻����
		if($repmore)
		{
			$title=str_replace($r[$i],$nr[$i],$title);
		}
		else
		{
			$title=str_replace($r[$i],$newword,$title);
		}
	}
	return $title;
}

//�����ɼ�����
function LoadOutCj($classid,$userid,$username){
	global $empire,$dbtbpre;
	$lineexp='<!-#-|-line-|-#-!>';
	$recordexp='<!-#-|-record-|-#-!>';
	$fieldexp='<!-#-|-field-|-#-!>';
	$sfieldexp='<!-#-|-smallfield-|-#-!>';
	CheckLevel($userid,$username,$classid,"loadcj");//��֤Ȩ��
	$classid=(int)$classid;
	if(!$classid)
	{
		printerror('LoadOutCjEmptyClassid','');
	}
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(!$cr['classid'])
	{
		printerror('LoadOutCjEmptyClassid','');
	}
	if(!$cr['newsclassid'])//�ǲɼ��ڵ�
	{
		printerror('LoadOutCjMustNewsclassid','');
	}
	//����
	$mainfield=LoadOutCjMainField();
	$mainstr=LoadOutCjMainstr($cr,$mainfield,$fieldexp,$sfieldexp);
	//����
	$infocr=$empire->fetch1("select * from {$dbtbpre}ecms_infoclass_".$cr[tbname]." where classid='$classid'");
	$datafield=LoadOutCjDataField($cr['tid'],$cr['tbname']);
	$datastr=LoadOutCjDatastr($infocr,$datafield,$fieldexp,$sfieldexp);
	@include('../class/EmpireCMS_version.php');
	$cjstr=EmpireCMS_VERSION.$recordexp.$mainstr.$recordexp.$datafield.$recordexp.$datastr;
	$file=$cr['tbname'].time().".cj";
	$filepath=ECMS_PATH."e/data/tmp/cj/".$file;
	WriteFiletext_n($filepath,$cjstr);
	DownLoadFile($file,$filepath,1);
	//������־
	insert_dolog("classid=$classid&classname=$cr[classname]");
	exit();
}

//���������ֶ��б�
function LoadOutCjMainField(){
	$field='classname,infourl,bz,num,copyimg,renum,keyboard,oldword,newword,titlelen,retitlewriter,smalltextlen,zz_smallurl,zz_newsurl,httpurl,repad,imgurl,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,keynum,insertnum,copyflash,pagetype,smallpagezz,pagezz,smallpageallzz,pageallzz,mark,enpagecode,recjtheurl,hiddenload,justloadin,justloadcheck,delloadinfo,pagerepad,getfirstpic,oldpagerep,newpagerep,keeptime,newstextisnull,getfirstspic,getfirstspicw,getfirstspich,doaddtextpage,infourlispage,repf,repadf,loadkeeptime,isnullf';
	return $field;
}

//�����������
function LoadOutCjMainstr($r,$field,$fieldexp,$sfieldexp){
	$mainstr='';
	$addexp='';
	$fr=explode(',',$field);
	$fcount=count($fr);
	for($i=0;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$mainstr.=$addexp.$r[$f];
		$addexp=$fieldexp;
	}
	return $mainstr;
}

//���ظ����ֶ��б�
function LoadOutCjDataField($tid,$tbname){
	global $empire,$dbtbpre;
	$field='';
	$dh='';
	$fsql=$empire->query("select f from {$dbtbpre}enewsf where tid='$tid' and iscj=1");
	while($fr=$empire->fetch($fsql))
	{
		$field.=$dh.$fr['f'];
		$dh=',';
	}
	return $field;
}

//���ظ������
function LoadOutCjDatastr($r,$field,$fieldexp,$sfieldexp){
	if(empty($field))
	{
		return '';
	}
	$datastr='';
	$addexp='';
	$fr=explode(',',$field);
	$fcount=count($fr);
	for($i=0;$i<$fcount;$i++)
	{
		$f=$fr[$i];
		$zzf='zz_'.$f;
		$zf='z_'.$f;
		$qzf='qz_'.$f;
		$savef='save_'.$f;
		$datastr.=$addexp.$r[$zzf].$sfieldexp.$r[$zf].$sfieldexp.$r[$qzf].$sfieldexp.$r[$savef];
		$addexp=$fieldexp;
	}
	return $datastr;
}

//����ɼ�����
function LoadInCj($add,$file,$file_name,$file_type,$file_size,$userid,$username){
	global $empire,$dbtbpre;
	$lineexp='<!-#-|-line-|-#-!>';
	$recordexp='<!-#-|-record-|-#-!>';
	$fieldexp='<!-#-|-field-|-#-!>';
	$sfieldexp='<!-#-|-smallfield-|-#-!>';
	//��֤Ȩ��
    CheckLevel($userid,$username,$classid,"loadcj");
	$classid=(int)$add['classid'];
	if(!$classid)
	{
		printerror("EmptyLoadInCjFile","history.go(-1)");
	}
	$cr=$empire->fetch1("select classid,islast,tid,tbname from {$dbtbpre}enewsclass where classid='$classid' and islast=1");
	if(!$cr['classid'])
	{
		printerror("LoadInCjMustLastClass","history.go(-1)");
	}
	if(!$file_name||!$file_size)
	{
		printerror("EmptyLoadInCjFile","history.go(-1)");
	}
	//��չ��
	$filetype=GetFiletype($file_name);
	if($filetype!=".cj")
	{
		printerror("LoadInCjErrorfiletype","history.go(-1)");
	}
	$path=ECMS_PATH.'e/data/tmp/cj/uploadcj'.time().'.cj';
	//�ϴ��ļ�
	$cp=@move_uploaded_file($file,$path);
	DoChmodFile($path);
	$data=ReadFiletext($path);
	DelFiletext($path);
	$r=explode($recordexp,$data);
	$empirecmsver=$r[0];
	$mainstr=$r[1];
	$datafield=$r[2];
	$datastr=$r[3];
	if(empty($mainstr))
	{
		printerror("EmptyLoadInCjFile","history.go(-1)");
	}
	//����
	$infoclassid=LoadInCjInsertMainstr($classid,$cr['tid'],$cr['tbname'],$mainstr,$fieldexp,$sfieldexp);
	//����
	LoadInCjInsertDatastr($classid,$cr['tid'],$cr['tbname'],$infoclassid,$datafield,$datastr,$fieldexp,$sfieldexp);
	$cjr=$empire->fetch1("select classname from {$dbtbpre}enewsinfoclass where classid='$infoclassid'");
	//������־
	insert_dolog("classid=".$infoclassid."<br>classname=".$cjr[classname]);
	printerror("LoadInCjSuccess","cj/LoadInCj.php?from=".ehtmlspecialchars($_POST[from]).hReturnEcmsHashStrHref2(0));
}

//д���������
function LoadInCjInsertMainstr($classid,$tid,$tbname,$mainstr,$fieldexp,$sfieldexp){
	global $empire,$dbtbpre;
	$mainfield=LoadOutCjMainField();
	$mainfieldr=explode(',',$mainfield);
	$fcount=count($mainfieldr);
	$mainr=explode($fieldexp,$mainstr);
	$mainvalues='';
	$count=count($mainr);
	if($fcount<$count)
	{
		$count=$fcount;
	}
	for($i=0;$i<$count;$i++)
	{
		if($i==0)
		{
			$mainr[$i]=ehtmlspecialchars($mainr[$i],ENT_QUOTES);
		}
		$mainvalues.=",'".addslashes($mainr[$i])."'";
	}
	//�ֶβ�һ��
	if($fcount>$count)
	{
		$addcount=$fcount-$count;
		for($addi=0;$addi<$addcount;$addi++)
		{
			if($addi==0)
			{
				$addval=',title,newstext,';
			}
			elseif($addi==1)
			{
				$addval=',newstext,';
			}
			elseif($addi==2)
			{
				$addval='0';
			}
			elseif($addi==3)
			{
				$addval=',newstext,';
			}
			else
			{
				$addval='';
			}
			$mainvalues.=",'$addval'";
		}
	}
	$empire->query("insert into {$dbtbpre}enewsinfoclass(classid,bclassid,newsclassid,tid,tbname,".$mainfield.") values(NULL,'0','$classid','$tid','$tbname'".$mainvalues.");");
	$lastid=$empire->lastid();
	return $lastid;
}

//д�븱�����
function LoadInCjInsertDatastr($classid,$tid,$tbname,$infoclassid,$dataf,$datastr,$fieldexp,$sfieldexp){
	global $empire,$dbtbpre;
	if(empty($dataf))
	{
		$empire->query("insert into {$dbtbpre}ecms_infoclass_".$tbname."(classid) values('$infoclassid');");
		return '';
	}
	//���ر��ֶ�
	$tbfield=LoadOutCjDataField($tid,$tbname);
	$datafr=explode(',',$dataf);
	$datar=explode($fieldexp,$datastr);
	$datafield='';
	$datavalues='';
	$count=count($datafr);
	for($i=0;$i<$count;$i++)
	{
		$f=$datafr[$i];
		if(!stristr(','.$tbfield.',',','.$f.','))
		{
			continue;
		}
		$zzf='zz_'.$f;
		$zf='z_'.$f;
		$qzf='qz_'.$f;
		$savef='save_'.$f;
		$zzr=explode($sfieldexp,$datar[$i]);
		$datafield.=",$zzf,$zf,$qzf,$savef";
		$datavalues.=",'".addslashes($zzr[0])."','".addslashes($zzr[1])."','".addslashes($zzr[2])."','".addslashes($zzr[3])."'";
	}
	$empire->query("insert into {$dbtbpre}ecms_infoclass_".$tbname."(classid".$datafield.") values('$infoclassid'".$datavalues.");");
}
?>