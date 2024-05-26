<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../data/dbcache/class.php");
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
//��֤Ȩ��
CheckLevel($logininid,$loginin,$classid,"cj");

//���ؽڵ���б�
function ReturnInfoUrl($r){
	if($r[infourl1])
	{
		if(empty($r['urlbs']))
		{
			$r['urlbs']=1;
		}
		for($i=$r[urlstart];$i<=$r[urlend];$i++)
		{
			$page=$i*$r['urlbs'];
			//����
			if($r['urlbl'])
			{
				$page=AddNumZero($page,$r[urlend]);
			}
			$dourl=str_replace("[page]",$page,$r[infourl1]);
			//����
			if($r['urldx'])
			{
				$a="";
				if($i<>$r[urlend])
				{
					$a="\r\n";
				}
				$url=$a.$dourl.$url;
			}
			else
			{
				if($i<>$r[urlstart])
				{
					$a="\r\n";
				}
				$url.=$a.$dourl;
			}
		}
	}
	if($r[infourl])
	{
		if($url)
		{
			$url=$r[infourl]."\r\n".$url;
		}
		else
		{
			$url=$r[infourl];
		}
	}
	if(empty($url))
	{printerror("EmptyInfourl","history.go(-1)");}
	return $url;
}

//���ӽڵ�
function AddInfoClass($bclassid,$newsclassid,$add,$ztid,$userid,$username){
	global $empire,$class_r,$dbtbpre;
	if(!$add[classname])
	{printerror("EmptyInfoTitleSuccess","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	//ѡ����Ŀ
	if($newsclassid)
	{
		if(!$class_r[$newsclassid][islast])
		{
			printerror("CjClassidMustLast","history.go(-1)");
		}
		//���زɼ�ҳ���ַ
		$add[infourl]=ReturnInfoUrl($add);
	    //ȡ�òɼ��ֶ�
		$mr=$empire->fetch1("select cj,tid,tbname from {$dbtbpre}enewsmod where mid='".$class_r[$newsclassid][modid]."'");
	    $ret_r=ReturnAddCj($add,$mr[cj],0);
	}
	$lasttime=time();
	if(empty($add[startday]))
	{$add[startday]=date("Y-m-d");}
	if(empty($add[endday]))
	{$add[endday]="2099-12-31";}
	if(empty($add[relistnum]))
	{$add[relistnum]=1;}
	if(empty($add[renum]))
	{$add[renum]=2;}
	if(empty($add[insertnum]))
	{$add[insertnum]=10;}
	//�������
	$bclassid=(int)$bclassid;
	$newsclassid=(int)$newsclassid;
	$add[num]=(int)$add[num];
	$add[copyimg]=(int)$add[copyimg];
	$add[renum]=(int)$add[renum];
	$add[titlelen]=(int)$add[titlelen];
	$add[retitlewriter]=(int)$add[retitlewriter];
	$add[smalltextlen]=(int)$add[smalltextlen];
	$add[relistnum]=(int)$add[relistnum];
	$add[keynum]=(int)$add[keynum];
	$add[insertnum]=(int)$add[insertnum];
	$add[copyflash]=(int)$add[copyflash];
	$mr[tid]=(int)$mr[tid];
	$add[pagetype]=(int)$add[pagetype];
	$add[mark]=(int)$add[mark];
	$add[enpagecode]=(int)$add[enpagecode];
	$add[recjtheurl]=(int)$add[recjtheurl];
	$add[hiddenload]=(int)$add[hiddenload];
	$add[justloadin]=(int)$add[justloadin];
	$add[justloadcheck]=(int)$add[justloadcheck];
	$add[delloadinfo]=(int)$add[delloadinfo];
	$add[getfirstpic]=(int)$add[getfirstpic];
	$add[getfirstspic]=(int)$add[getfirstspic];
	$add[getfirstspicw]=(int)$add[getfirstspicw];
	$add[getfirstspich]=(int)$add[getfirstspich];
	$add[doaddtextpage]=(int)$add[doaddtextpage];
	$add[infourlispage]=(int)$add[infourlispage];
	$keeptime=(int)$add['keeptime'];
	$newstextisnull=(int)$add['newstextisnull'];
	$loadkeeptime=(int)$add['loadkeeptime'];
	$add['classname']=eDoRepPostComStr($add['classname']);
	$add['startday']=hRepPostStr($add['startday'],1);
	$add['endday']=hRepPostStr($add['endday'],1);
	$add['save_titlepicl']=hRepPostStr2($add['save_titlepicl']);
	$mr['tbname']=hRepPostStr2($mr['tbname']);
	$add['repf']='';
	if($_POST['repf'])
	{
		$add['repf']=$_POST['repf'];
		$add['repf']=','.hRepPostStr($add['repf'],1).',';
	}
	$add['repadf']='';
	if($_POST['repadf'])
	{
		$add['repadf']=$_POST['repadf'];
		$add['repadf']=','.hRepPostStr($add['repadf'],1).',';
	}
	$add['isnullf']='';
	if($_POST['isnullf'])
	{
		$add['isnullf']=$_POST['isnullf'];
		$add['isnullf']=','.hRepPostStr($add['isnullf'],1).',';
	}
	//д������
	$sql=$empire->query("insert into {$dbtbpre}enewsinfoclass(bclassid,classname,infourl,newsclassid,startday,endday,bz,num,copyimg,renum,keyboard,oldword,newword,titlelen,retitlewriter,smalltextlen,zz_smallurl,zz_newsurl,httpurl,repad,imgurl,relistnum,zz_titlepicl,z_titlepicl,qz_titlepicl,save_titlepicl,keynum,insertnum,copyflash,tid,tbname,pagetype,smallpagezz,pagezz,smallpageallzz,pageallzz,mark,enpagecode,recjtheurl,hiddenload,justloadin,justloadcheck,delloadinfo,pagerepad,getfirstpic,oldpagerep,newpagerep,keeptime,lasttime,newstextisnull,getfirstspic,getfirstspicw,getfirstspich,doaddtextpage,infourlispage,repf,repadf,loadkeeptime,isnullf) values($bclassid,'".eaddslashes($add[classname])."','".eaddslashes2($add[infourl])."',$newsclassid,'$add[startday]','$add[endday]','".eaddslashes2($add[bz])."',$add[num],$add[copyimg],$add[renum],'".eaddslashes2($add[keyboard])."','".eaddslashes2($add[oldword])."','".eaddslashes2($add[newword])."',$add[titlelen],$add[retitlewriter],$add[smalltextlen],'".eaddslashes2($add[zz_smallurl])."','".eaddslashes2($add[zz_newsurl])."','".eaddslashes2($add[httpurl])."','".eaddslashes2($add[repad])."','".eaddslashes2($add[imgurl])."',$add[relistnum],'".eaddslashes2($add[zz_titlepicl])."','".eaddslashes2($add[z_titlepicl])."','".eaddslashes2($add[qz_titlepicl])."','$add[save_titlepicl]',$add[keynum],$add[insertnum],$add[copyflash],$mr[tid],'$mr[tbname]',$add[pagetype],'".eaddslashes2($add[smallpagezz])."','".eaddslashes2($add[pagezz])."','".eaddslashes2($add[smallpageallzz])."','".eaddslashes2($add[pageallzz])."',$add[mark],$add[enpagecode],$add[recjtheurl],$add[hiddenload],$add[justloadin],$add[justloadcheck],$add[delloadinfo],'".eaddslashes2($add[pagerepad])."',$add[getfirstpic],'".eaddslashes2($add[oldpagerep])."','".eaddslashes2($add[newpagerep])."',$keeptime,$lasttime,$newstextisnull,$add[getfirstspic],$add[getfirstspicw],$add[getfirstspich],$add[doaddtextpage],$add[infourlispage],'$add[repf]','$add[repadf]','$loadkeeptime','$add[isnullf]');");
	$classid=$empire->lastid();
	if($newsclassid)
	{
		//д�븱��
		$usql=$empire->query("insert into {$dbtbpre}ecms_infoclass_".$mr[tbname]."(classid".$ret_r[0].") values($classid".$ret_r[1].");");
	}
	if($sql)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$add[classname]);
		printerror("AddInfoClassSuccess","AddInfoClass.php?enews=AddInfoClass&newsclassid=$newsclassid&from=".ehtmlspecialchars($_POST[from]).hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ľڵ�
function EditInfoClass($bclassid,$newsclassid,$add,$ztid,$userid,$username){
	global $empire,$class_r,$dbtbpre;
	if(!$add[classid]||!$add[classname])
	{printerror("EmptyInfoTitleSuccess","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	//���ڵ���ԭ�ڵ�һ��
	if($add[classid]==$bclassid)
	{printerror("OldInfoidNotSingle","history.go(-1)");}
	//ѡ����Ŀ
	if($newsclassid)
	{
		if(!$class_r[$newsclassid][islast])
		{
			printerror("CjClassidMustLast","history.go(-1)");
		}
		//���زɼ�ҳ���ַ
		$add[infourl]=ReturnInfoUrl($add);
		//ȡ�òɼ��ֶ�
		$mr=$empire->fetch1("select cj,tid,tbname from {$dbtbpre}enewsmod where mid='".$class_r[$newsclassid][modid]."'");
	}
	if(empty($add[startday]))
	{$add[startday]=date("Y-m-d");}
	if(empty($add[endday]))
	{$add[endday]="2099-12-31";}
	if(empty($add[relistnum]))
	{$add[relistnum]=1;}
	if(empty($add[renum]))
	{$add[renum]=2;}
	if(empty($add[insertnum]))
	{$add[insertnum]=10;}
	//�������
	$add[classid]=(int)$add[classid];
	$bclassid=(int)$bclassid;
	$newsclassid=(int)$newsclassid;
	$add[num]=(int)$add[num];
	$add[copyimg]=(int)$add[copyimg];
	$add[renum]=(int)$add[renum];
	$add[titlelen]=(int)$add[titlelen];
	$add[retitlewriter]=(int)$add[retitlewriter];
	$add[smalltextlen]=(int)$add[smalltextlen];
	$add[relistnum]=(int)$add[relistnum];
	$add[keynum]=(int)$add[keynum];
	$add[insertnum]=(int)$add[insertnum];
	$add[copyflash]=(int)$add[copyflash];
	$mr[tid]=(int)$mr[tid];
	$add[pagetype]=(int)$add[pagetype];
	$add[mark]=(int)$add[mark];
	$add[enpagecode]=(int)$add[enpagecode];
	$add[recjtheurl]=(int)$add[recjtheurl];
	$add[hiddenload]=(int)$add[hiddenload];
	$add[justloadin]=(int)$add[justloadin];
	$add[justloadcheck]=(int)$add[justloadcheck];
	$add[delloadinfo]=(int)$add[delloadinfo];
	$add[getfirstpic]=(int)$add[getfirstpic];
	$add[getfirstspic]=(int)$add[getfirstspic];
	$add[getfirstspicw]=(int)$add[getfirstspicw];
	$add[getfirstspich]=(int)$add[getfirstspich];
	$add[doaddtextpage]=(int)$add[doaddtextpage];
	$add[infourlispage]=(int)$add[infourlispage];
	$keeptime=(int)$add['keeptime'];
	$newstextisnull=(int)$add['newstextisnull'];
	$loadkeeptime=(int)$add['loadkeeptime'];
	$add['classname']=eDoRepPostComStr($add['classname']);
	$add['startday']=hRepPostStr($add['startday'],1);
	$add['endday']=hRepPostStr($add['endday'],1);
	$add['save_titlepicl']=hRepPostStr2($add['save_titlepicl']);
	$mr['tbname']=hRepPostStr2($mr['tbname']);
	$add['repf']='';
	if($_POST['repf'])
	{
		$add['repf']=$_POST['repf'];
		$add['repf']=','.hRepPostStr($add['repf'],1).',';
	}
	$add['repadf']='';
	if($_POST['repadf'])
	{
		$add['repadf']=$_POST['repadf'];
		$add['repadf']=','.hRepPostStr($add['repadf'],1).',';
	}
	$add['isnullf']='';
	if($_POST['isnullf'])
	{
		$add['isnullf']=$_POST['isnullf'];
		$add['isnullf']=','.hRepPostStr($add['isnullf'],1).',';
	}
	//����
	$sql=$empire->query("update {$dbtbpre}enewsinfoclass set bclassid=$bclassid,classname='".eaddslashes($add[classname])."',infourl='".eaddslashes2($add[infourl])."',newsclassid=$newsclassid,startday='$add[startday]',endday='$add[endday]',bz='".eaddslashes2($add[bz])."',num=$add[num],copyimg=$add[copyimg],renum=$add[renum],keyboard='".eaddslashes2($add[keyboard])."',oldword='".eaddslashes2($add[oldword])."',newword='".eaddslashes2($add[newword])."',titlelen=$add[titlelen],retitlewriter=$add[retitlewriter],smalltextlen=$add[smalltextlen],zz_smallurl='".eaddslashes2($add[zz_smallurl])."',zz_newsurl='".eaddslashes2($add[zz_newsurl])."',httpurl='".eaddslashes2($add[httpurl])."',repad='".eaddslashes2($add[repad])."',imgurl='".eaddslashes2($add[imgurl])."',relistnum=$add[relistnum],zz_titlepicl='".eaddslashes2($add[zz_titlepicl])."',z_titlepicl='".eaddslashes2($add[z_titlepicl])."',qz_titlepicl='".eaddslashes2($add[qz_titlepicl])."',save_titlepicl='$add[save_titlepicl]',keynum=$add[keynum],insertnum=$add[insertnum],copyflash=$add[copyflash],tid=$mr[tid],tbname='$mr[tbname]',pagetype=$add[pagetype],smallpagezz='".eaddslashes2($add[smallpagezz])."',pagezz='".eaddslashes2($add[pagezz])."',smallpageallzz='".eaddslashes2($add[smallpageallzz])."',pageallzz='".eaddslashes2($add[pageallzz])."',mark=$add[mark],enpagecode=$add[enpagecode],recjtheurl=$add[recjtheurl],hiddenload=$add[hiddenload],justloadin=$add[justloadin],justloadcheck=$add[justloadcheck],delloadinfo=$add[delloadinfo],pagerepad='".eaddslashes2($add[pagerepad])."',getfirstpic=$add[getfirstpic],oldpagerep='".eaddslashes2($add[oldpagerep])."',newpagerep='".eaddslashes2($add[newpagerep])."',keeptime='$keeptime',newstextisnull=$newstextisnull,getfirstspic=$add[getfirstspic],getfirstspicw=$add[getfirstspicw],getfirstspich=$add[getfirstspich],doaddtextpage=$add[doaddtextpage],infourlispage=$add[infourlispage],repf='$add[repf]',repadf='$add[repadf]',loadkeeptime='$loadkeeptime',isnullf='$add[isnullf]' where classid='$add[classid]'");
	if($newsclassid)
	{
		//�Ƿ����м�¼
		$havenum=$empire->num("select count(*) as total from {$dbtbpre}ecms_infoclass_".$mr[tbname]." where classid='$add[classid]' limit 1");
		//ԭ���Ǹ���Ŀ
		if(empty($add[oldnewsclassid])&&!$havenum)
		{
			$ret_r=ReturnAddCj($add,$mr[cj],0);
			//д�븱��
			$usql=$empire->query("insert into {$dbtbpre}ecms_infoclass_".$mr[tbname]."(classid".$ret_r[0].") values($add[classid]".$ret_r[1].");");
	    }
		else
		{
			$ret_r=ReturnAddCj($add,$mr[cj],1);
			//����
			$usql=$empire->query("update {$dbtbpre}ecms_infoclass_".$mr[tbname]." set classid='$add[classid]'".$ret_r[0]." where classid='$add[classid]'");
		}
	}
	//��Դ
	if($_POST['from'])
	{
		$returnurl="ListPageInfoClass.php";
	}
	else
	{
		$returnurl="ListInfoClass.php";
	}
	if($sql)
	{
		//������־
	    insert_dolog("classid=".$add[classid]."<br>classname=".$add[classname]);
		printerror("EditInfoClassSuccess",$returnurl.hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ���ɼ��ڵ�
function DelInfoClass($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{printerror("NotDelInfoid","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select classname,tid,tbname,newsclassid from {$dbtbpre}enewsinfoclass where classid='$classid'");
	$del=$empire->query("delete from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if($r[newsclassid])
	{
		$del2=$empire->query("delete from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$classid'");
		$del1=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$r[tbname]." where classid='$classid'");
	}
	//ɾ���ӽڵ�
	DelInfoClass1($classid);
	//��Դ
	if($_GET['from'])
	{
		$returnurl="ListPageInfoClass.php";
	}
	else
	{
		$returnurl="ListInfoClass.php";
	}
	if($del)
	{
		//������־
		insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("DelInfoClassSuccess",$returnurl.hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�ݹ�ɾ���ڵ�
function DelInfoClass1($classid){
	global $empire,$dbtbpre;
	if(empty($classid))
	{
		return "";
    }
	$sql=$empire->query("select classid,tid,tbname,newsclassid from {$dbtbpre}enewsinfoclass where bclassid='$classid'");
	while($r=$empire->fetch($sql))
	{
		$del=$empire->query("delete from {$dbtbpre}enewsinfoclass where classid='$r[classid]'");
		if($r[newsclassid])
		{
			$del1=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$r[tbname]." where classid='$r[classid]'");
			$del2=$empire->query("delete from {$dbtbpre}ecms_infoclass_".$r[tbname]." where classid='$r[classid]'");
		}
		DelInfoClass1($r[classid]);
    }
}

//��������
function SetDisplayInfoClass($open){
	$time=time()+365*24*3600;
	$set=esetcookie("displayinfoclass",$open,$time,1);
	echo"<script>self.location.href='ListInfoClass.php".hReturnEcmsHashStrHref2(1)."';</script>";
	exit();
}

//��ʾ���޼��ڵ�[����ڵ�ʱ]
function ShowClass_ListInfoClass($bclassid,$exp){
	global $empire,$class_r,$fun_r,$dbtbpre,$ecms_hashur;
	//��
	if(getcvar('displayinfoclass',1))
	{
		$display=" style=display:none";
    }
	if(empty($bclassid))
	{
		$bclassid=0;
		$exp="";
    }
	else
	{$exp="&nbsp;&nbsp;&nbsp;".$exp;}
	$sql=$empire->query("select * from {$dbtbpre}enewsinfoclass where bclassid='$bclassid' order by classid desc");
	$returnstr="";
	while($r=$empire->fetch($sql))
	{
		//�ɼ�ҳ��
		$pager=explode("\r\n",$r[infourl]);
	    $infourl=eDoRepPostComStr($pager[0],1);
		$divonclick="";
		$start_tbody="";
		$end_tbody="";
		$img="../data/images/dir.gif";
		if(empty($r[bclassid]))
		{
			$bgcolor="#DBEAF5";
			$divonclick=" language=JScript onMouseUp='turnit(classdiv".$r[classid].");' style='CURSOR: hand' title='open'";
			$start_tbody="<tbody id='classdiv".$r[classid]."'".$display.">";
	        $end_tbody="</tbody>";
		}
		else
		{$bgcolor="#ffffff";}
		if($r[newsclassid])
		{
			$lastcjtime=!$r['lasttime']?'��δ�ɼ�':date("Y-m-d H:i:s",$r['lasttime']);
			$cj="<a href='DoCj.php?enews=CjUrl&classid[]=".$r[classid].$ecms_hashur['href']."' title='���ɼ�ʱ�䣺".$lastcjtime."' target=_blank><u>".$fun_r['StartCj']."</u></a>";
			$emptydb="&nbsp;[<a href=ListInfoClass.php?enews=EmptyCj&classid=$r[classid]".$ecms_hashur['href']." onclick=\"return confirm('".$fun_r['CheckEmptyCjRecord']."');\">".$fun_r['EmptyCjRecord']."</a>]";
			$loadoutcj="&nbsp;[<a href=ecmscj.php?enews=LoadOutCj&classid=$r[classid]".$ecms_hashur['href']." onclick=\"return confirm('ȷ��Ҫ����?');\">����</a>]";
			$checkbox="<input type=checkbox name=classid[] value=$r[classid]>";
		}
		else
		{
			$cj=$fun_r['StartCj'];
			$emptydb="";
			$loadoutcj="";
			$checkbox="";
		}
		//��Ŀ����
		$getcurlr['classid']=$r[newsclassid];
		$classurl=sys_ReturnBqClassname($getcurlr,9);
		$returnstr.="<tr bgcolor=".$bgcolor.">
	<td height=25 align='center'>".$checkbox."</td>
    <td height=25".$divonclick.">".$exp."<img src=".$img." width=19 height=15></td>
    <td height=25><div align=center>".$cj."</div></td>
    <td height=25><a href='".$infourl."' target=_blank>".$r[classname]."</a></td>
    <td height=25><div align=center><a href=ecmscj.php?enews=ViewCjList&classid=".$r[classid].$ecms_hashur['href']." target=_blank>".$fun_r['view']."</a></div></td>
    <td height=25><div align=center><a href='".$classurl."' target=_blank>".$class_r[$r[newsclassid]][classname]."</a></div></td>
    <td height=25><div align=center><a href=CheckCj.php?classid=".$r[classid].$ecms_hashur['ehref'].">".$fun_r['CheckCj']."</a></div></td>
    <td height=25><div align=center>[<a href=AddInfoClass.php?enews=AddInfoClass&docopy=1&classid=".$r[classid]."&newsclassid=".$r[newsclassid].$ecms_hashur['ehref'].">".$fun_r['Copy']."</a>]&nbsp;[<a href=AddInfoClass.php?enews=EditInfoClass&classid=".$r[classid].$ecms_hashur['ehref'].">".$fun_r['edit']."</a>]&nbsp;[<a href=ListInfoClass.php?enews=DelInfoClass&classid=".$r[classid].$ecms_hashur['href']." onclick=\"return confirm('".$fun_r['CheckDelCj']."');\">".$fun_r['del']."</a>]".$emptydb.$loadoutcj."</div></td>
  </tr>";
		//ȡ���ӽڵ�
		$returnstr.=$start_tbody.ShowClass_ListInfoClass($r[classid],$exp).$end_tbody;
	}
	return $returnstr;
}

//��ղɼ���¼
function EmptyCj($classid,$userid,$username){
	global $empire,$dbtbpre;
	$classid=(int)$classid;
	if(empty($classid))
	{printerror("NotEmptyCjClassid","history.go(-1)");}
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"cj");
	$r=$empire->fetch1("select classid,classname,tbname from {$dbtbpre}enewsinfoclass where classid='$classid'");
	if(!$r[classid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}ecms_infotmp_".$r[tbname]." where classid='$classid' and checked=1");
	//��Դ
	if($_GET['from'])
	{
		$returnurl="ListPageInfoClass.php";
	}
	else
	{
		$returnurl="ListInfoClass.php";
	}
	if($sql)
	{
		//������־
	    insert_dolog("classid=".$classid."<br>classname=".$r[classname]);
		printerror("EmptyCjSuccess",$returnurl.hReturnEcmsHashStrHref2(1));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

$enews=$_POST['enews'];
if(empty($enews))
{$enews=$_GET['enews'];}
if($enews)
{
	hCheckEcmsRHash();
}
//���ӽڵ�
if($enews=="AddInfoClass")
{
	$bclassid=$_POST[bclassid];
	$newsclassid=$_POST[newsclassid];
	$add=$_POST[add];
	$ztid=$_POST['ztid'];
	$add['pagerepad']=$_POST['pagerepad'];
	$add['repad']=$_POST['repad'];
	AddInfoClass($bclassid,$newsclassid,$add,$ztid,$logininid,$loginin);
}
//�޸Ľڵ�
elseif($enews=="EditInfoClass")
{
	$bclassid=$_POST[bclassid];
	$newsclassid=$_POST[newsclassid];
	$add=$_POST[add];
	$ztid=$_POST['ztid'];
	$add['pagerepad']=$_POST['pagerepad'];
	$add['repad']=$_POST['repad'];
	EditInfoClass($bclassid,$newsclassid,$add,$ztid,$logininid,$loginin);
}
//ɾ���ڵ�
elseif($enews=="DelInfoClass")
{
	$classid=$_GET[classid];
	DelInfoClass($classid,$logininid,$loginin);
}
//��ղɼ���¼
elseif($enews=="EmptyCj")
{
	$classid=$_GET['classid'];
	EmptyCj($classid,$logininid,$loginin);
}

//չ��
if($_GET['doopen'])
{
	$open=(int)$_GET['open'];
	SetDisplayInfoClass($open);
}
//ͼ��
if(getcvar('displayinfoclass',1))
{
	$img="<a href='ListInfoClass.php?doopen=1&open=0".$ecms_hashur['ehref']."' title='չ��'><img src='../data/images/displaynoadd.gif' width='15' height='15' border='0'></a>";
}
else
{
	$img="<a href='ListInfoClass.php?doopen=1&open=1".$ecms_hashur['ehref']."' title='����'><img src='../data/images/displayadd.gif' width='15' height='15' border='0'></a>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����ڵ�</title>
<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
 function turnit(ss)
{
 if (ss.style.display=="") 
  ss.style.display="none";
 else
  ss.style.display=""; 
}
var newWindow = null
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr> 
    <td width="50%">λ�ã��ɼ� &gt; <a href="ListInfoClass.php<?=$ecms_hashur['whehref']?>">����ڵ�</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="���ӽڵ�" onclick="self.location.href='AddInfoC.php<?=$ecms_hashur['whehref']?>';">
		&nbsp;&nbsp;
        <input type="button" name="Submit52" value="����ɼ�����" onclick="self.location.href='cj/LoadInCj.php<?=$ecms_hashur['whehref']?>';">
		&nbsp;&nbsp;
		<input type="button" name="Submit6" value="���ݸ�������" onclick="window.open('ReHtml/ChangeData.php<?=$ecms_hashur['whehref']?>#ReIfInfoHtml');">
      </div></td>
  </tr>
</table>
<form name=form1 method=get action="DoCj.php" onsubmit="return confirm('ȷ��Ҫ�ɼ�?');" target=_blank>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
<?=$ecms_hashur['form']?>
<input type=hidden name=enews value=DoCj>
  <tr class="header">
    <td width="3%"><div align="center"></div></td>
    <td width="8%" height="25"><div align="center"><?=$img?></div></td>
    <td width="8%" height="25"> <div align="center">�ɼ�</div></td>
    <td width="27%" height="25"> <div align="center">�ڵ�(������ʲɼ�ҳ)</div></td>
    <td width="6%" height="25"> <div align="center">Ԥ��</div></td>
    <td width="16%" height="25"> <div align="center">����Ŀ</div></td>
    <td width="9%" height="25"> <div align="center">��˲ɼ�</div></td>
    <td width="24%" height="25"> 
      <div align="center">����</div></td>
  </tr>
  <?
echo ShowClass_ListInfoClass(0,'');
?>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td><input type=checkbox name=chkall value=on onClick=CheckAll(this.form)>
        ѡ��ȫ�� 
        &nbsp;&nbsp;<input type="submit" name="Submit" value="�����ɼ��ڵ�"></td>
  </tr>
</table>
</form>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><font color="#666666">��ע�������ɼ����ڣ��밴ס&quot;Shift&quot;+�������ʼ�ɼ�&quot;</font></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$empire=null;
?>
