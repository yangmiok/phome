<?php
//**********************************  ��Ա�ֶ�  **********************************

//�����ֶ�ֵ
function ReturnMFvalue($value)
{
	$value=str_replace("\r\n","|",$value);
	return $value;
}

//ȡ�û�Ա��Ԫ��html����
function GetMemberFform($type,$f,$fvalue,$fformsize=''){
	if($type=="select"||$type=="radio"||$type=="checkbox")
	{
		return GetMFformSelect($type,$f,$fvalue,$fformsize);
	}
	$file="../data/html/memberfhtml.txt";
	$data=ReadFiletext($file);
	$exp="[!--".$type."--]";
	$r=explode($exp,$data);
	$string=str_replace("[!--enews.var--]",$f,$r[1]);
	$string=str_replace("[!--enews.def.val--]",$fvalue,$string);
	$string=RepMFformSize($f,$string,$type,$fformsize);
	return fAddAddsData($string);
}

//ȡ��select/radioԪ�ش���
function GetMFformSelect($type,$f,$fvalue,$fformsize=''){
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
			$isdef="||\$ecmsfirstpost==1";
		}
		if($type=='select')
		{
			$change.="<option value=\"".$val."\"<?=\$r[".$f."]==\"".$val."\"".$isdef."?' selected':''?>>".$val."</option>";
		}
		elseif($type=='checkbox')
		{
			$change.="<input name=\"".$f."[]\" type=\"checkbox\" value=\"".$val."\"<?=strstr(\$r[".$f."],\"|".$val."|\")".$isdef."?' checked':''?>>".$val;
		}
		else
		{
			$change.="<input name=\"".$f."\" type=\"radio\" value=\"".$val."\"<?=\$r[".$f."]==\"".$val."\"".$isdef."?' checked':''?>>".$val;
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

//�滻��Ԫ�س���
function RepMFformSize($f,$string,$type,$fformsize=''){
	$fformsize=ReturnDefMFformSize($f,$type,$fformsize);
	if($type=='textarea')
	{
		$r=explode(',',$fformsize);
		$string=str_replace('[!--fsize.w--]',$r[0],$string);
		$string=str_replace('[!--fsize.h--]',$r[1],$string);
	}
	else
	{
		$string=str_replace('[!--fsize.w--]',$fformsize,$string);
	}
	return $string;
}

//����Ĭ�ϳ���
function ReturnDefMFformSize($f,$type,$fformsize){
	if(empty($fformsize))
	{
		if($type=='textarea')
		{
			$fformsize='60,10';
		}
		elseif($type=='img')
		{
			$fformsize='45';
		}
		elseif($type=='file')
		{
			$fformsize='45';
		}
		elseif($type=='flash')
		{
			$fformsize='45';
		}
		elseif($type=='date')
		{
			$fformsize='12';
		}
		elseif($type=='color')
		{
			$fformsize='10';
		}
		elseif($type=='linkfield')
		{
			$fformsize='45';
		}
		elseif($type=='downpath')
		{
			$fformsize='45';
		}
		elseif($type=='onlinepath')
		{
			$fformsize='45';
		}
	}
	return $fformsize;
}

//���ӻ�Ա�ֶ�
function AddMemberF($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"memberf");
	$add[f]=RepPostVar($add[f]);
	if(empty($add[f])||empty($add[fname]))
	{
		printerror("EmptyF","");
	}
	//�ֶ��Ƿ��ظ�
	$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}enewsmemberadd");
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
		printerror("ReF","");
	}
	$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}enewsmember");
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
		printerror("ReF","");
	}
	$add[fvalue]=ReturnMFvalue($add[fvalue]);//��ʼ��ֵ
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
	if($add[flen]){
		if($add[ftype]!="TEXT"&&$add[ftype]!="MEDIUMTEXT"&&$add[ftype]!="LONGTEXT"){
			$type.="(".$add[flen].")";
		}
	}
	$field="`".$add[f]."` ".$type." NOT NULL".$def;
	//�����ֶ�
	$asql=$empire->query("alter table {$dbtbpre}enewsmemberadd add ".$field);
	//�滻����
	$fhtml=GetMemberFform($add[fform],$add[f],$add[fvalue],$add[fformsize]);
	if($add[fform]=='select'||$add[fform]=='radio'||$add[fform]=='checkbox')
	{
		$fhtml=str_replace("\$r[","\$addr[",$fhtml);
	}
	//�������
	$add[myorder]=(int)$add[myorder];
	$sql=$empire->query("insert into {$dbtbpre}enewsmemberf(f,fname,fform,fhtml,fzs,myorder,ftype,flen,fvalue,fformsize) values('$add[f]','$add[fname]','$add[fform]','".eaddslashes2($fhtml)."','".eaddslashes($add[fzs])."',$add[myorder],'$add[ftype]','$add[flen]','".eaddslashes2($add[fvalue])."','$add[fformsize]');");
	$lastid=$empire->lastid();
	if($asql&&$sql)
	{
		//������־
		insert_dolog("fid=".$lastid."<br>f=".$add[f]);
		printerror("AddFSuccess","member/AddMemberF.php?enews=AddMemberF".hReturnEcmsHashStrHref2(0));
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸Ļ�Ա�ֶ�
function EditMemberF($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"memberf");
	$fid=(int)$add['fid'];
	$add[f]=RepPostVar($add[f]);
	$add[oldf]=RepPostVar($add[oldf]);
	if(empty($add[f])||empty($add[fname])||!$fid){
		printerror("EmptyF","history.go(-1)");
	}
	if($add[f]<>$add[oldf]){
		//�ֶ��Ƿ��ظ�
		$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}enewsmemberadd");
		$b=0;
		while($r=$empire->fetch($s)){
			if($r[Field]==$add[f]){
				$b=1;
				break;
			}
		}
		if($b){
			printerror("ReF","history.go(-1)");
		}
		$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}enewsmember");
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
			printerror("ReF","");
		}
	}
	$add[fvalue]=ReturnMFvalue($add[fvalue]);//��ʼ��ֵ
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
	if($add[flen]){
		if($add[ftype]!="TEXT"&&$add[ftype]!="MEDIUMTEXT"&&$add[ftype]!="LONGTEXT"){
			$type.="(".$add[flen].")";
		}
	}
	$field="`".$add[f]."` ".$type." NOT NULL".$def;
	$usql=$empire->query("alter table {$dbtbpre}enewsmemberadd change `".$add[oldf]."` ".$field);
	//�滻����
	if($add[f]<>$add[oldf]||$add[fform]<>$add[oldfform]||$add[fvalue]<>$add[oldfvalue]||$add[fformsize]<>$add[oldfformsize]){
		$fhtml=GetMemberFform($add[fform],$add[f],$add[fvalue],$add[fformsize]);
		if($add[fform]=='select'||$add[fform]=='radio'||$add[fform]=='checkbox')
		{
			$fhtml=str_replace("\$r[","\$addr[",$fhtml);
		}
	}
	else{
		$fhtml=$add[fhtml];
	}
	//�������
	$add[myorder]=(int)$add[myorder];
	$sql=$empire->query("update {$dbtbpre}enewsmemberf set f='$add[f]',fname='$add[fname]',fform='$add[fform]',fhtml='".eaddslashes2($fhtml)."',fzs='".eaddslashes($add[fzs])."',myorder=$add[myorder],ftype='$add[ftype]',flen='$add[flen]',fvalue='".eaddslashes2($add[fvalue])."',fformsize='$add[fformsize]' where fid=$fid");
	//���±�
	$record="<!--record-->";
	$field="<!--field--->";
	$like=$field.$add[oldf].$record;
	$newlike=$field.$add[f].$record;
	$slike=",".$add[oldf].",";
	$newslike=",".$add[f].",";
	$csql=$empire->query("select fid,ftemp,enter,mustenter,filef,imgf,tobrf,viewenter,searchvar,canaddf,caneditf,checkboxf from {$dbtbpre}enewsmemberform where enter like '%$like%'");
	while($cr=$empire->fetch($csql))
	{
		$setf="";
		$newftemp=str_replace('[!--'.$add[oldf].'--]','[!--'.$add[f].'--]',stripSlashes($cr['ftemp']));
		$setf.=",ftemp='".addslashes($newftemp)."'";
		if(strstr($cr['mustenter'],$slike)){
			$setf.=",mustenter=REPLACE(mustenter,'$slike','$newslike')";
		}
		if(strstr($cr['filef'],$slike)){
			$setf.=",filef=REPLACE(filef,'$slike','$newslike')";
		}
		if(strstr($cr['imgf'],$slike)){
			$setf.=",imgf=REPLACE(imgf,'$slike','$newslike')";
		}
		if(strstr($cr['tobrf'],$slike)){
			$setf.=",tobrf=REPLACE(tobrf,'$slike','$newslike')";
		}
		if(strstr($cr[viewenter],$like)){
			$setf.=",viewenter=REPLACE(viewenter,'$like','$newlike')";
		}
		if(strstr($cr['searchvar'],$slike)){
			$setf.=",searchvar=REPLACE(searchvar,'$slike','$newslike')";
		}
		if(strstr($cr['canaddf'],$slike)){
			$setf.=",canaddf=REPLACE(canaddf,'$slike','$newslike')";
		}
		if(strstr($cr['caneditf'],$slike)){
			$setf.=",caneditf=REPLACE(caneditf,'$slike','$newslike')";
		}
		if(strstr($cr['checkboxf'],$slike))
		{
			$setf.=",checkboxf=REPLACE(checkboxf,'$slike','$newslike')";
		}
		$cusql=$empire->query("update {$dbtbpre}enewsmemberform set enter=REPLACE(enter,'$like','$newlike')".$setf." where fid='$cr[fid]'");
		//���ɱ�ҳ��
		ChangeMemberForm($cr[fid],$newftemp);
	}
	if($usql&&$sql)
	{
		insert_dolog("fid=".$fid."<br>f=".$add[f]);//������־
		printerror("EditFSuccess","member/ListMemberF.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����Ա�ֶ�
function DelMemberF($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"memberf");
	$fid=(int)$add['fid'];
	if(empty($fid)){
		printerror("EmptyFid","history.go(-1)");
	}
	$r=$empire->fetch1("select f from {$dbtbpre}enewsmemberf where fid=$fid");
	if(!$r[f]){
		printerror("EmptyFid","history.go(-1)");
	}
	$usql=$empire->query("alter table {$dbtbpre}enewsmemberadd drop COLUMN `".$r[f]."`");
	$sql=$empire->query("delete from {$dbtbpre}enewsmemberf where fid=$fid");
	//���±���
	$record="<!--record-->";
	$field="<!--field--->";
	$like=$field.$r[f].$record;
	$slike=",".$r[f].",";
	$csql=$empire->query("select fid,ftemp,enter,mustenter,filef,imgf,tobrf,viewenter,searchvar,canaddf,caneditf,checkboxf from {$dbtbpre}enewsmemberform where enter like '%$like%'");
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
		if(strstr($cr['imgf'],$slike))
		{
			$setf.=",imgf=REPLACE(imgf,'$slike',',')";
		}
		if(strstr($cr['tobrf'],$slike))
		{
			$setf.=",tobrf=REPLACE(tobrf,'$slike',',')";
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
		//ǰ̨��ʾ
		if(strstr($cr[viewenter],$like)){
			$viewenter='';
			$re2=explode($record,$cr[viewenter]);
			for($i=0;$i<count($re2)-1;$i++){
				if(strstr($re2[$i].$record,$like)){
					continue;
				}
				$viewenter.=$re2[$i].$record;
			}
			$setf.=",viewenter='".$viewenter."'";
		}
		//������
		if(strstr($cr['searchvar'],$slike))
		{
			$setf.=",searchvar=REPLACE(searchvar,'$slike',',')";
		}
		//������
		if(strstr($cr['canaddf'],$slike))
		{
			$setf.=",canaddf=REPLACE(canaddf,'$slike',',')";
		}
		//�޸���
		if(strstr($cr['caneditf'],$slike))
		{
			$setf.=",caneditf=REPLACE(caneditf,'$slike',',')";
		}
		//��ѡ��
		if(strstr($cr['checkboxf'],$slike))
		{
			$setf.=",checkboxf=REPLACE(checkboxf,'$slike',',')";
		}
		$cusql=$empire->query("update {$dbtbpre}enewsmemberform set enter='$enter'".$setf." where fid='$cr[fid]'");
	}
	if($usql&&$sql)
	{
		insert_dolog("fid=".$fid."<br>f=".$r[f]);//������־
		printerror("DelFSuccess","member/ListMemberF.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ļ�Ա�ֶ�˳��
function EditMemberFOrder($fid,$myorder,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"memberf");
	for($i=0;$i<count($myorder);$i++)
	{
		$fid[$i]=(int)$fid[$i];
		$newmyorder=(int)$myorder[$i];
		$usql=$empire->query("update {$dbtbpre}enewsmemberf set myorder=$newmyorder where fid='$fid[$i]'");
    }
	printerror("EditFOrderSuccess","member/ListMemberF.php".hReturnEcmsHashStrHref2(1));
}


//**********************************  ��Ա��  **********************************

//�����Զ����ɻ�Ա��ģ��
function ReturnMemberFtemp($cname,$center){
	$temp="<tr><td width='16%' height=25 bgcolor='ffffff'>enews.name</td><td bgcolor='ffffff'>[!--enews.var--]</td></tr>";
	for($i=0;$i<count($center);$i++){
		$v=$center[$i];
		$data.=str_replace("enews.var",$v,str_replace("enews.name",$cname[$v],$temp));
    }
	return "<table width='100%' align='center' cellpadding=3 cellspacing=1 bgcolor='#DBEAF5'>".$data."</table>";
}

//���»�Ա���ļ�
function ChangeMemberForm($fid,$mtemp){
	global $empire,$dbtbpre;
	$file="../data/html/memberform".$fid.".php";
	$sql=$empire->query("select f,fhtml from {$dbtbpre}enewsmemberf");
	while($r=$empire->fetch($sql)){
		$mtemp=str_replace("[!--".$r[f]."--]",$r[fhtml],$mtemp);
    }
	$mtemp="<?php
if(!defined('InEmpireCMS'))
{exit();}
?>".$mtemp;
	WriteFiletext($file,$mtemp);
}

//���Ͷ����
function TogMemberqenter($cname,$cqenter){
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
function TogMemberMustf($cname,$menter){
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

//���ӻ�Ա��
function AddMemberForm($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[fname]))
	{
		printerror("EmptyMemberForm","");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"memberf");
	$enter=TogMemberqenter($add['cname'],$add['center']);//¼����
	$viewenter=TogMemberqenter($add['cname'],$add['venter']);//��ʾ��
	$mustenter=TogMemberMustf($add['cname'],$add['menter']);//������
	$canaddf=TogMemberMustf($add['cname'],$add['canadd']);//������
	$caneditf=TogMemberMustf($add['cname'],$add['canedit']);//�޸���
	$searchvar=TogMemberMustf($add['cname'],$add['schange']);//������
	$filef=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"file");
	$imgf=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"img");
	$tobrf=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"textarea");
	$checkboxf=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"checkbox");
	//�Զ����ɱ�
	if($add[ftype])
	{
		$add[ftemp]=ReturnMemberFtemp($add['cname'],$add['center']);
	}
	$sql=$empire->query("insert into {$dbtbpre}enewsmemberform(fname,ftemp,fzs,enter,mustenter,filef,imgf,tobrf,viewenter,searchvar,canaddf,caneditf,checkboxf) values('$add[fname]','".eaddslashes2($add[ftemp])."','".addslashes($add[fzs])."','$enter','$mustenter','$filef','$imgf','$tobrf','$viewenter','$searchvar','$canaddf','$caneditf','$checkboxf');");
	$fid=$empire->lastid();
	//���ɱ�ҳ��
	ChangeMemberForm($fid,$add[ftemp]);
	if($sql)
	{
	    insert_dolog("fid=".$fid."<br>fname=".$add[fname]);//������־
		printerror("AddMemberFormSuccess","member/AddMemberForm.php?enews=AddMemberForm".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ļ�Ա��
function EditMemberForm($add,$userid,$username){
	global $empire,$dbtbpre;
	$fid=(int)$add['fid'];
	if(empty($add[fname])||!$fid)
	{
		printerror("EmptyMemberForm","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"memberf");
	$enter=TogMemberqenter($add['cname'],$add['center']);//¼����
	$viewenter=TogMemberqenter($add['cname'],$add['venter']);//��ʾ��
	$mustenter=TogMemberMustf($add['cname'],$add['menter']);//������
	$canaddf=TogMemberMustf($add['cname'],$add['canadd']);//������
	$caneditf=TogMemberMustf($add['cname'],$add['canedit']);//�޸���
	$searchvar=TogMemberMustf($add['cname'],$add['schange']);//������
	$filef=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"file");
	$imgf=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"img");
	$tobrf=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"textarea");
	$checkboxf=ReturnMFileF($enter,$dbtbpre."enewsmemberf",0,"checkbox");
	//�Զ����ɱ�
	if($add[ftype])
	{
		$add[ftemp]=ReturnMemberFtemp($add['cname'],$add['center']);
	}
	$sql=$empire->query("update {$dbtbpre}enewsmemberform set fname='$add[fname]',ftemp='".eaddslashes2($add[ftemp])."',fzs='".addslashes($add[fzs])."',enter='$enter',mustenter='$mustenter',filef='$filef',imgf='$imgf',tobrf='$tobrf',viewenter='$viewenter',searchvar='$searchvar',canaddf='$canaddf',caneditf='$caneditf',checkboxf='$checkboxf' where fid=$fid");
	//���ɱ�ҳ��
	ChangeMemberForm($fid,$add[ftemp]);
	if($sql)
	{
	    insert_dolog("fid=".$fid."<br>fname=".$add[fname]);//������־
		printerror("EditMemberFormSuccess","member/ListMemberForm.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����Ա��
function DelMemberForm($add,$userid,$username){
	global $empire,$dbtbpre;
	$fid=(int)$add['fid'];
	if(!$fid)
	{
		printerror("EmptyMemberFormId","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"memberf");
	$r=$empire->fetch1("select fid,fname from {$dbtbpre}enewsmemberform where fid=$fid;");
	if(!$r['fid'])
	{
		printerror("EmptyMemberFormId","history.go(-1)");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsmemberform where fid=$fid;");
	//ɾ�����ļ�
	$file="../data/html/memberform".$fid.".php";
	DelFiletext($file);
	if($sql)
	{
	    insert_dolog("fid=".$fid."<br>fname=".$r[fname]);//������־
		printerror("DelMemberFormSuccess","member/ListMemberForm.php".hReturnEcmsHashStrHref2(1));
	}
	else
	{printerror("DbError","history.go(-1)");}
}


//**********************************  ��Ա��  **********************************

//���ӻ�Ա��
function AddMemberGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	if(empty($add[groupname])||empty($add[level]))
	{printerror("EmptyMemberGroupname","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"membergroup");
	//�����ļ�
	$add[level]=(int)$add[level];
	$add[checked]=(int)$add[checked];
	$add[favanum]=(int)$add[favanum];
	$add[daydown]=(int)$add[daydown];
	$msgnum=(int)$add['msgnum'];
	$msglen=(int)$add['msglen'];
	$canreg=(int)$add['canreg'];
	$formid=(int)$add['formid'];
	$regchecked=(int)$add['regchecked'];
	$spacestyleid=(int)$add['spacestyleid'];
	$add[dayaddinfo]=(int)$add[dayaddinfo];
	$add[infochecked]=(int)$add[infochecked];
	$add[plchecked]=(int)$add[plchecked];
	$sql=$empire->query("insert into {$dbtbpre}enewsmembergroup(groupname,level,checked,favanum,daydown,msglen,msgnum,canreg,formid,regchecked,spacestyleid,dayaddinfo,infochecked,plchecked) values('$add[groupname]',$add[level],$add[checked],$add[favanum],$add[daydown],$msglen,$msgnum,$canreg,$formid,$regchecked,$spacestyleid,'$add[dayaddinfo]','$add[infochecked]','$add[plchecked]');");
	$groupid=$empire->lastid();
	//���»���
	GetMemberLevel();
	if($sql)
	{
		//������־
		insert_dolog("groupid=".$groupid."<br>groupname=".$add[groupname]);
		printerror("AddMemberGroupSuccess","member/AddMemberGroup.php?enews=AddMemberGroup".hReturnEcmsHashStrHref2(0));
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸Ļ�Ա��
function EditMemberGroup($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[groupid]=(int)$add[groupid];
	if(empty($add[groupid])||empty($add[groupname])||empty($add[level]))
	{printerror("EmptyMemberGroupname","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"membergroup");
	//�����ļ�
	$add[level]=(int)$add[level];
	$add[checked]=(int)$add[checked];
	$add[favanum]=(int)$add[favanum];
	$add[daydown]=(int)$add[daydown];
	$msgnum=(int)$add['msgnum'];
	$msglen=(int)$add['msglen'];
	$canreg=(int)$add['canreg'];
	$formid=(int)$add['formid'];
	$regchecked=(int)$add['regchecked'];
	$spacestyleid=(int)$add['spacestyleid'];
	$add[dayaddinfo]=(int)$add[dayaddinfo];
	$add[infochecked]=(int)$add[infochecked];
	$add[plchecked]=(int)$add[plchecked];
	$sql=$empire->query("update {$dbtbpre}enewsmembergroup set groupname='$add[groupname]',level=$add[level],checked=$add[checked],favanum=$add[favanum],daydown=$add[daydown],msglen=$msglen,msgnum=$msgnum,canreg=$canreg,formid=$formid,regchecked=$regchecked,spacestyleid=$spacestyleid,dayaddinfo='$add[dayaddinfo]',infochecked='$add[infochecked]',plchecked='$add[plchecked]' where groupid='$add[groupid]'");
	//���»���
	GetMemberLevel();
	if($sql)
	{
		//������־
		insert_dolog("groupid=".$add[groupid]."<br>groupname=".$add[groupname]);
		printerror("EditMemberGroupSuccess","member/ListMemberGroup.php".hReturnEcmsHashStrHref2(1));
    }
	else
	{printerror("DbError","history.go(-1)");}
}

//ɾ����Ա��
function DelMemberGroup($groupid,$userid,$username){
	global $empire,$dbtbpre;
	$groupid=(int)$groupid;
	if(empty($groupid))
	{printerror("NotDelMemberGroupid","history.go(-1)");}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"membergroup");
	$r=$empire->fetch1("select groupname from {$dbtbpre}enewsmembergroup where groupid='$groupid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsmembergroup where groupid='$groupid'");
	//���»���
	GetMemberLevel();
	if($sql)
	{
		//������־
		insert_dolog("groupid=".$groupid."<br>groupname=".$r[groupname]);
		printerror("DelMemberGroupSuccess","member/ListMemberGroup.php".hReturnEcmsHashStrHref2(1));
    }
	else
	{printerror("DbError","history.go(-1)");}
}
?>