<?php

//�������ݿ⻺��
function Moreport_ChangeCacheAll($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$ecms_config,$fun_r;
	$addcs=Moreport_ChangeAddCs($add);
	if(!$add['docache'])
	{
		echo"<script>self.location.href='ListMoreport.php?enews=MoreportUpdateClassfileAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	$start=(int)$add['start'];
	$num=1;
	$b=0;
	$sql=$empire->query("select * from {$dbtbpre}enewsmoreport where pid>$start order by pid limit ".$num);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['pid'];
		if($r['pid']==1)
		{
			continue;
		}
		if(!$r['ppath']||!file_exists($r['ppath'].'e/config/config.php'))
		{
			continue;
		}
		define('ECMS_SELFPATH',$r['ppath']);
		Moreport_ChangeData($r,0);
	}
	if(empty($b))
	{
		echo $fun_r[MoreportChangeCacheSuccess]."<script>self.location.href='ListMoreport.php?enews=MoreportUpdateClassfileAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	echo"<meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ListMoreport.php?enews=MoreportChangeCacheAll&start=$new_start".$addcs.hReturnEcmsHashStrHref(0)."\">".$fun_r[OneMoreportChangeCacheSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)";
	exit();
}

//������Ŀ�����ļ�
function Moreport_UpdateClassfileAll($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$ecms_config,$fun_r;
	$addcs=Moreport_ChangeAddCs($add);
	if(!$add['doclassfile'])
	{
		echo"<script>self.location.href='ListMoreport.php?enews=MoreportReDtPageAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	$start=(int)$add['start'];
	$num=1;
	$b=0;
	$sql=$empire->query("select * from {$dbtbpre}enewsmoreport where pid>$start order by pid limit ".$num);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['pid'];
		if($r['pid']==1)
		{
			continue;
		}
		if(!$r['ppath']||!file_exists($r['ppath'].'e/config/config.php'))
		{
			continue;
		}
		define('ECMS_SELFPATH',$r['ppath']);
		Moreport_ChangeData($r,3);
	}
	if(empty($b))
	{
		echo $fun_r[MoreportUpdateClassfileSuccess]."<script>self.location.href='ListMoreport.php?enews=MoreportReDtPageAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	echo"<meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ListMoreport.php?enews=MoreportUpdateClassfileAll&start=$new_start".$addcs.hReturnEcmsHashStrHref(0)."\">".$fun_r[OneMoreportUpdateClassfileSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)";
	exit();
}

//���¶�̬ҳ��
function Moreport_ReDtPageAll($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$ecms_config,$fun_r;
	$addcs=Moreport_ChangeAddCs($add);
	if(!$add['dodtpage'])
	{
		echo"<script>self.location.href='ListMoreport.php?enews=MoreportClearTmpfileAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	$start=(int)$add['start'];
	$num=1;
	$b=0;
	$sql=$empire->query("select * from {$dbtbpre}enewsmoreport where pid>$start order by pid limit ".$num);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['pid'];
		if($r['pid']==1)
		{
			continue;
		}
		if(!$r['ppath']||!file_exists($r['ppath'].'e/config/config.php'))
		{
			continue;
		}
		define('ECMS_SELFPATH',$r['ppath']);
		Moreport_ChangeData($r,1);
	}
	if(empty($b))
	{
		echo $fun_r[MoreportReDtPageSuccess]."<script>self.location.href='ListMoreport.php?enews=MoreportClearTmpfileAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	echo"<meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ListMoreport.php?enews=MoreportReDtPageAll&start=$new_start".$addcs.hReturnEcmsHashStrHref(0)."\">".$fun_r[OneMoreportReDtPageSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)";
	exit();
}

//������ʱ�ļ�
function Moreport_ClearTmpfileAll($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$ecms_config,$fun_r;
	$addcs=Moreport_ChangeAddCs($add);
	if(!$add['dotmpfile'])
	{
		echo "<script>self.location.href='ListMoreport.php?enews=MoreportReIndexfileAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	$start=(int)$add['start'];
	$num=1;
	$b=0;
	$sql=$empire->query("select * from {$dbtbpre}enewsmoreport where pid>$start order by pid limit ".$num);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['pid'];
		if($r['pid']==1)
		{
			continue;
		}
		if(!$r['ppath']||!file_exists($r['ppath'].'e/config/config.php'))
		{
			continue;
		}
		define('ECMS_SELFPATH',$r['ppath']);
		Moreport_ChangeData($r,2);
	}
	if(empty($b))
	{
		echo $fun_r[MoreportClearTmpfileSuccess]."<script>self.location.href='ListMoreport.php?enews=MoreportReIndexfileAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	echo"<meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ListMoreport.php?enews=MoreportClearTmpfileAll&start=$new_start".$addcs.hReturnEcmsHashStrHref(0)."\">".$fun_r[OneMoreportClearTmpfileSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)";
	exit();
}

//������ҳ�ļ�
function Moreport_ReIndexfileAll($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$ecms_config,$fun_r;
	$addcs=Moreport_ChangeAddCs($add);
	if(!$add['doreindex'])
	{
		insert_dolog("");//������־
		printerror("MoreportChangeAllDataSuccess","ListMoreport.php".hReturnEcmsHashStrHref2(1));
	}
	$start=(int)$add['start'];
	$num=1;
	$b=0;
	$sql=$empire->query("select * from {$dbtbpre}enewsmoreport where pid>$start order by pid limit ".$num);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$new_start=$r['pid'];
		if($r['pid']==1)
		{
			continue;
		}
		if(!$r['ppath']||!file_exists($r['ppath'].'e/config/config.php'))
		{
			continue;
		}
		define('ECMS_SELFPATH',$r['ppath']);
		Moreport_ChangeData($r,4);
	}
	if(empty($b))
	{
		insert_dolog("");//������־
		printerror("MoreportChangeAllDataSuccess","ListMoreport.php".hReturnEcmsHashStrHref2(1));
		//echo $fun_r[MoreportReIndexfileSuccess]."<script>self.location.href='ListMoreport.php?enews=MoreportReIndexfileAll&start=0".$addcs.hReturnEcmsHashStrHref(0)."';</script>";
		exit();
	}
	echo"<meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ListMoreport.php?enews=MoreportReIndexfileAll&start=$new_start".$addcs.hReturnEcmsHashStrHref(0)."\">".$fun_r[OneMoreportReIndexfileSuccess]."(ID:<font color=red><b>".$new_start."</b></font>)";
	exit();
}

//���Ӳ���
function Moreport_ChangeAddCs($add){
	$docache=(int)$add['docache'];
	$doclassfile=(int)$add['doclassfile'];
	$dodtpage=(int)$add['dodtpage'];
	$dotmpfile=(int)$add['dotmpfile'];
	$doreindex=(int)$add['doreindex'];
	$cs='';
	if($docache)
	{
		$cs.="&docache=".$docache;
	}
	if($doclassfile)
	{
		$cs.="&doclassfile=".$doclassfile;
	}
	if($dodtpage)
	{
		$cs.="&dodtpage=".$dodtpage;
	}
	if($dotmpfile)
	{
		$cs.="&dotmpfile=".$dotmpfile;
	}
	if($doreindex)
	{
		$cs.="&doreindex=".$doreindex;
	}
	return $cs;
}

//��������
function Moreport_ChangeData($portr,$ecms=0){
	global $empire,$dbtbpre,$public_r,$ecms_config;
	$ecms_config['sets']['deftempid']=$portr['tempgid'];
	if($ecms==1)//���¶�̬ҳ��
	{
		GetPlTempPage();//�����б�ģ��
		GetPlJsPage();//����JSģ��
		ReCptemp();//�������ģ��
		GetSearch();//��������ģ��
		GetPrintPage();//��ӡģ��
		GetDownloadPage();//���ص�ַҳ��
		ReGbooktemp();//���԰�ģ��
		ReLoginIframe();//��½״̬ģ��
		ReSchAlltemp();//ȫվ����ģ��
		//���ɼ�����
		$yfile=ECMS_PATH.'e/data/dbcache/notcj.php';
		$nfile=ECMS_SELFPATH.'e/data/dbcache/notcj.php';
		@copy($yfile,$nfile);
	}
	elseif($ecms==2)//������ʱ�ļ�
	{
		//��ʱ�ļ�Ŀ¼
		$tmppath=ECMS_SELFPATH.'e/data/tmp';
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
	}
	elseif($ecms==3)//������Ŀ�����ļ�
	{
		$ypath=ECMS_PATH.'d/js';
		$npath=ECMS_SELFPATH.'d/js';
		CopyPath($ypath,$npath);
		$ypath=ECMS_PATH.'e/data/fc';
		$npath=ECMS_SELFPATH.'e/data/fc';
		CopyPath($ypath,$npath);
		$ypath=ECMS_PATH.'e/data/html';
		$npath=ECMS_SELFPATH.'e/data/html';
		CopyPath($ypath,$npath);
		$ypath=ECMS_PATH.'e/data/template';
		$npath=ECMS_SELFPATH.'e/data/template';
		CopyPath($ypath,$npath);
	}
	elseif($ecms==4)//���¶�̬��ҳ
	{
		if($portr['mustdt']||$public_r['indexpagedt'])
		{
			DelFiletext(ECMS_SELFPATH.'index'.$public_r['indextype']);
			@copy(ECMS_SELFPATH.'e/data/template/dtindexpage.txt',ECMS_SELFPATH.'index.php');
		}
	}
	else//�������ݿ⻺��
	{
		//���²�������
		GetConfig(1);
		//�������
		GetClass();
		//���»�Ա��
		GetMemberLevel();
		//����ȫվ�������ݱ�
		GetSearchAllTb();
	}
}

?>