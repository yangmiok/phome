<?php
//�ϴ��̶�Ŀ¼�ļ�
function TranTruePathFile($level,$path,$file,$file_name,$file_type,$file_size,$add,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	if(!$file_name)
	{
		printerror("EmptyTranFile","history.go(-1)");
	}
	$r['filetype']=GetFiletype($file_name);//ȡ���ļ�����
	//�����.php�ļ�
	if(CheckSaveTranFiletype($r['filetype']))
	{
		printerror("TranPHP","history.go(-1)");
	}
	$type_r=explode("|".$r['filetype']."|",$public_r['filetype']);
	if(count($type_r)<2)
	{
		printerror("TranFiletypeFail","history.go(-1)");
	}
	if($file_size>$public_r['filesize']*1024)
	{
		printerror("TranFilesizeFail","history.go(-1)");
	}
	//�ļ���
	$r['insertfile']=ReturnDoTranFilename($file_name,$classid);
	$r['filename']=$r['insertfile'].$r['filetype'];
	$r['name']=ECMS_PATH.$path.'/'.$r['filename'];
	$r['tran']=1;
	//�ϴ��ļ�
	$cp=@move_uploaded_file($file,$r['name']);
	if(empty($cp))
	{
		$r['tran']=0;
		printerror('TranFail','');
	}
	DoChmodFile($r['name']);
	//������־
	insert_dolog("path=$path<br>filename=".$r['filename']);
	echo'<meta http-equiv="refresh" content="0;url='.EcmsGetReturnUrl().'">';
	db_close();
	$empire=null;
}

//ɾ���̶�Ŀ¼�ļ�
function DelTruePathFile($level,$path,$filename,$userid,$username){
	global $empire,$dbtbpre,$public_r;
	$count=count($filename);
	if(empty($count))
	{
		printerror("NotFileid","history.go(-1)");
	}
	//��Ŀ¼
	$basepath=ECMS_PATH.$path;
	for($i=0;$i<$count;$i++)
	{
		if(!$filename[$i]||!eReturnCkCFile($filename[$i]))
		{
			continue;
	    }
		DelFiletext($basepath."/".$filename[$i]);
    }
	//������־
	insert_dolog("path=$path");
	printerror("DelFileSuccess",EcmsGetReturnUrl());
}
?>