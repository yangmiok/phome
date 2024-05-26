<?php
//�����̳ǲ���
function ShopSys_ReturnSet(){
	global $empire,$dbtbpre;
	$shoppr=$empire->fetch1("select * from {$dbtbpre}enewsshop_set limit 1");
	return $shoppr;
}

//��֤�Ƿ��̳Ǳ�
function ShopSys_CheckShopTb($tbname,$shoppr){
	if(!strstr($shoppr['shoptbs'],','.$tbname.','))
	{
		printerror("ErrorShopTbname","history.go(-1)",1);
	}
}

//�������ﳵ
function SetBuycar($buycar){
	$set=esetcookie("mybuycar",$buycar,0);
	return $set;
}

//��չ��ﳵ
function ClearBuycar(){
	SetBuycar("");
	Header("Refresh:0; URL=buycar/");
}

//��������
function ReturnBuycarProductNum($num){
	$num=(int)$num;
	if($num<1)
	{
		$num=1;
	}
	return $num;
}

//�滻����
function ShopSys_BuycarRepvar($var){
	$var=str_replace('!','',$var);
	$var=str_replace('|','',$var);
	$var=str_replace(',','',$var);
	return $var;
}

//�滻����
function ShopSys_BuycarRepvar2($var){
	$var=str_replace('!','',$var);
	$var=str_replace('|','',$var);
	return $var;
}

//�����
function Shopsys_CheckMaxnum($num,$maxnum,$shoppr){
	if($num>$maxnum)
	{
		printerror("ShopOutMaxnum","history.go(-1)",1);
	}
	if($shoppr['singlenum']&&$num>$shoppr['singlenum'])
	{
		printerror("ShopOutSinglenum","history.go(-1)",1);
	}
}

//���ٿ��
function Shopsys_CutMaxnum($ddid,$buycar,$havecut,$shoppr,$ecms=0){
	global $class_r,$empire,$dbtbpre,$public_r;
	$ddid=(int)$ddid;
	if(empty($buycar))
	{
		return '';
	}
	if($ecms==0&&$havecut)
	{
		return '';
	}
	if($ecms==1&&!$havecut)
	{
		return '';
	}
	if($ecms==0)
	{
		$fh='-';
		$salefh='+';
	}
	else
	{
		$fh='+';
		$salefh='-';
	}
	$record="!";
	$field="|";
	$buycarr=explode($record,$buycar);
	$bcount=count($buycarr);
	for($i=0;$i<$bcount-1;$i++)
	{
		$pr=explode($field,$buycarr[$i]);
		$productid=$pr[1];
		$fr=explode(",",$pr[1]);
		//ID
		$classid=(int)$fr[0];
		$id=(int)$fr[1];
		//����
		$pnum=(int)$pr[3];
		if($pnum<1)
		{
			$pnum=1;
		}
		if(empty($class_r[$classid][tbname]))
		{
			continue;
		}
		$empire->query("update {$dbtbpre}ecms_".$class_r[$classid][tbname]." set pmaxnum=pmaxnum".$fh.$pnum.",psalenum=psalenum".$salefh.$pnum." where id='$id'");
	}
	$newhavecut=$ecms==0?1:0;
	$empire->query("update {$dbtbpre}enewsshopdd set havecutnum='$newhavecut' where ddid='$ddid'");
}

//���빺�ﳵ
function AddBuycar($classid,$id,$pn=1,$add){
	global $class_r,$empire,$dbtbpre,$public_r;
	$shoppr=ShopSys_ReturnSet();
	$classid=(int)$classid;
	$id=(int)$id;
	$pn=(int)$pn;
	if(empty($classid)||empty($id)||empty($class_r[$classid][tbname]))
	{
		printerror("NotChangeProduct","history.go(-1)",1);
    }
	//��֤�̳Ǳ�
	ShopSys_CheckShopTb($class_r[$classid]['tbname'],$shoppr);
	//��֤��Ʒ�Ƿ����
	$infor=$empire->fetch1("select id,classid,pmaxnum,price,buyfen from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
	if(!$infor['id']||$infor['classid']!=$classid)
	{
		printerror("NotChangeProduct","history.go(-1)",1);
	}
	//�޻�
	if($infor['pmaxnum']<1)
	{
		printerror("ShopNotProductNum","history.go(-1)",1);
	}
	$pn=ReturnBuycarProductNum($pn);
	if($shoppr['haveatt'])
	{
		$addatt=ShopSys_BuycarInfoAdd($add['addatt']);
	}
	else
	{
		$addatt='';
	}
	$record="!";
	$field="|";
	$productid=$classid.",".$id;
	$addattstr='|'.$addatt;
	$buycar=getcvar('mybuycar');
	//�ظ�
	if(strstr($buycar,"|".$productid.$addattstr."|"))
	{
		$pr=explode("|".$productid.$addattstr."|",$buycar);
		$pr1=explode("!",$pr[1]);
		$oldbuycar="|".$productid.$addattstr."|".$pr1[0]."!";
		//����
		$pr1[0]=ReturnBuycarProductNum($pr1[0]);
		if(empty($pr1[0]))
		{
			$pr1[0]=1;
		}
		$newnum=$pr1[0]+$pn;
		//���
		Shopsys_CheckMaxnum($newnum,$infor['pmaxnum'],$shoppr);
		$newbuycar="|".$productid.$addattstr."|".$newnum."!";
		$buycar=str_replace($oldbuycar,$newbuycar,$buycar);
	}
	else
	{
		if($shoppr['buycarnum']>1)
		{
			$bcr=explode($record,$buycar);
			$count=count($bcr);
			if($count>$shoppr['buycarnum'])
			{
				printerror("ShopBuycarMaxnum","history.go(-1)",1);
			}
		}
		//ֻ���һ��
		if($shoppr['buycarnum']==1)
		{
			$buycar='';
		}
		//���
		Shopsys_CheckMaxnum($pn,$infor['pmaxnum'],$shoppr);
		$buycar.="|".$productid.$addattstr."|".$pn."!";
	}
	SetBuycar($buycar);
	if($shoppr['buystep']==2)
	{
		$tourl='order/';
	}
	else
	{
		$tourl='buycar/';
	}
	Header("Refresh:0; URL=$tourl");
}

//�޸Ĺ��ﳵ
function EditBuycar($add){
	global $class_r,$empire,$dbtbpre,$public_r;
	$shoppr=ShopSys_ReturnSet();
	$record="!";
	$field="|";
	$productid=$add['productid'];
	$addatt=$add['addatt'];
	$num=$add['num'];
	$del=$add['del'];
	$delatt=$add['delatt'];
	$count=count($productid);
	$buycar="";
	for($i=0;$i<$count;$i++)
	{
		$productid[$i]=RepPostVar($productid[$i]);
		//��֤��Ʒ�Ƿ����
		$pr=explode(',',$productid[$i]);
		$classid=(int)$pr[0];
		$id=(int)$pr[1];
		$productid[$i]=$classid.','.$id;
		//��֤�̳Ǳ�
		ShopSys_CheckShopTb($class_r[$classid]['tbname'],$shoppr);
		//��֤��Ʒ�Ƿ����
		$infor=$empire->fetch1("select id,classid,pmaxnum,price,buyfen from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
		if(!$infor['id']||$infor['classid']!=$classid)
		{
			printerror("NotChangeProduct","history.go(-1)",1);
		}
		//�޻�
		if($infor['pmaxnum']<1)
		{
			printerror("ShopNotProductNum","history.go(-1)",1);
		}
		if($shoppr['haveatt'])
		{
			$addatt[$i]=ShopSys_BuycarRepvar2(RepPostStr($addatt[$i]));
		}
		else
		{
			$addatt[$i]='';
		}
		$num[$i]=intval($num[$i]);
		//��֤�Ƿ�ɾ����
		if(empty($num[$i]))
		{
			continue;
	    }
		$isdel=0;
		for($j=0;$j<count($del);$j++)
		{
			if($del[$j]==$productid[$i].'|'.$addatt[$i])
			{
				$isdel=1;
				break;
			}
		}
		if($isdel==1)
		{
			continue;
		}
		$num[$i]=ReturnBuycarProductNum($num[$i]);
		//���
		Shopsys_CheckMaxnum($num[$i],$infor['pmaxnum'],$shoppr);
		$buycar.="|".$productid[$i]."|".$addatt[$i]."|".$num[$i]."!";
    }
	SetBuycar($buycar);
	if($shoppr['buystep']==2)
	{
		$tourl='order/';
	}
	else
	{
		$tourl='buycar/';
	}
	Header("Refresh:0; URL=$tourl");
}

//���ظ�������
function ShopSys_BuycarInfoAdd($addatt){
	$count=count($addatt);
	if(!$count)
	{
		return '';
	}
	$attexp='';
	$attstr='';
	for($i=0;$i<$count;$i++)
	{
		$att=ShopSys_BuycarRepvar(RepPostStr($addatt[$i]));
		if(!trim($att))
		{
			continue;
		}
		$attstr.=$attexp.$att;
		$attexp=',';
	}
	return $attstr;
}

//��֤�ύȨ��
function ShopCheckAddDdGroup($shoppr){
	global $public_r;
	//�����µ���Ա
	if($shoppr['shopddgroupid'])
	{
		if(!getcvar('mluserid'))
		{
			$phpmyself=urlencode(eReturnSelfPage(1));
			$gotourl=$public_r['newsurl']."e/member/login/login.php?prt=1&from=".$phpmyself;
			$petype=1;
			printerror("NotLogin",$gotourl,$petype);
		}
	}
}

//��֤����������
function ShopSys_CheckDdMust($add,$shoppr){
	$ddmustr=explode(',',$shoppr['ddmust']);
	$mcount=count($ddmustr)-1;
	for($i=1;$i<$mcount;$i++)
	{
		$mf=$ddmustr[$i];
		if(empty($mf))
		{
			continue;
		}
		if(!trim($add[$mf]))
		{
			printerror("MustEnterSelect","history.go(-1)",1);
		}
	}
	if($shoppr['shoppsmust']&&!$add['psid'])
	{
		printerror("NotPsid","history.go(-1)",1);
    }
	if($shoppr['shoppayfsmust']&&!$add['payfsid'])
	{
		printerror("NotPayfsid","history.go(-1)",1);
    }
}

//�����Ż�����Ϣ
function ShopSys_GetPre($precode,$totalmoney,$user,$classids){
	global $empire,$dbtbpre;
	$premoney=0;
	$precode=RepPostVar(trim($precode));
	if(!$precode)
	{
		printerror("EmptyPreCode","history.go(-1)",1);
	}
	$prer=$empire->fetch1("select id,prename,precode,premoney,pretype,reuse,endtime,groupid,classid,musttotal,usenum,haveusenum from {$dbtbpre}enewsshop_precode where precode='$precode' limit 1");
	if(!$prer['id'])
	{
		printerror("EmptyPreCode","history.go(-1)",1);
	}
	//�Ƿ����
	$time=time();
	if($prer['endtime']&&$prer['endtime']<$time)
	{
		printerror("PreCodeOuttime","history.go(-1)",1);
	}
	//��Ա��
	if($prer['groupid']&&!strstr($prer['groupid'],','.$user[groupid].','))
	{
		printerror("PreCodeNotLevel","history.go(-1)",1);
	}
	//��Ŀ
	if($prer['classid'])
	{
		$cr=explode(',',$classids);
		$ccount=count($cr);
		for($i=0;$i<$ccount;$i++)
		{
			$cr[$i]=(int)$cr[$i];
			if(!strstr($prer['classid'],','.$cr[$i].','))
			{
				printerror("PreCodeErrorClass","history.go(-1)",1);
			}
		}
	}
	//�����
	if($totalmoney<$prer['musttotal'])
	{
		$GLOBALS['precodemusttotal']=$prer['musttotal'];
		printerror("PreCodeMusttotal","history.go(-1)",1);
	}
	return $prer;
}

//�����Żݽ��
function ShopSys_PreMoney($prer,$money){
	$premoney=0;
	if($prer['pretype']==1)
	{
		$premoney=intval(($prer['premoney']/100)*$money);
	}
	else
	{
		$premoney=$prer['premoney'];
	}
	return $premoney;
}

//�������ͷ�ʽ���
function ShopSys_PrePsTotal($psid,$psprice,$alltotal,$shoppr){
	if($shoppr['freepstotal']<1)
	{
		return $psprice;
	}
	if($alltotal>=$shoppr['freepstotal'])
	{
		$psprice=0;
	}
	return $psprice;
}

//���ض�����
function ShopSys_ReturnDdNo(){
	$ddno=time().rand(10000,99999);
	return $ddno;
}

//���Ӷ���
function AddDd($add){
	global $empire,$public_r,$dbtbpre;
	$shoppr=ShopSys_ReturnSet();
	//��֤Ȩ��
	ShopCheckAddDdGroup($shoppr);
	//���ﳵ������
	if(!getcvar('mybuycar'))
	{
		printerror("EmptyBuycar","history.go(-1)",1);
    }
	$add[ddno]=RepPostVar($add[ddno]);
	$add[truename]=dgdb_tosave($add[truename]);
	$add[oicq]=dgdb_tosave($add[oicq]);
	$add[msn]=dgdb_tosave($add[msn]);
	$add[mycall]=dgdb_tosave($add[mycall]);
	$add[phone]=dgdb_tosave($add[phone]);
	$add[email]=dgdb_tosave($add[email]);
	$add[address]=dgdb_tosave($add[address]);
	$add[zip]=dgdb_tosave($add[zip]);
	$add[signbuild]=dgdb_tosave($add[signbuild]);
	$add[besttime]=dgdb_tosave($add[besttime]);
	$add[bz]=dgdb_tosave($add[bz]);
	$add[fptt]=dgdb_tosave($add[fptt]);
	$add[fpname]=dgdb_tosave($add[fpname]);
	$add[fp]=(int)$add[fp];
	$add[psid]=(int)$add[psid];
	$add[payfsid]=(int)$add[payfsid];
	$add['precode']=RepPostVar($add['precode']);
	//��������
	if(!$add['ddno'])
	{
		printerror("EmptyBuycar","history.go(-1)",1);
	}
	//������
	ShopSys_CheckDdMust($add,$shoppr);
	$mess="AddDdSuccess";
	$haveprice=0;
	$payby=0;
	//���ع��ﳵ��Ÿ�ʽ
	$buyr=ReturnBuycardd($shoppr);
	$alltotal=$buyr[2];
	$alltotalfen=$buyr[1];
	$buycar=$buyr[3];
	$classids=$buyr['classids'];
	//���ͷ�ʽ
	$pr=array();
	if($shoppr['shoppsmust'])
	{
		$pr=$empire->fetch1("select pid,pname,price from {$dbtbpre}enewsshopps where pid='$add[psid]' and isclose=0");
		if(empty($pr['pid']))
		{
			printerror("NotPsid","history.go(-1)",1);
		}
	}
	//֧����ʽ
	$payr=array();
	if($shoppr['shoppayfsmust'])
	{
		$payr=$empire->fetch1("select payid,payname,payurl,userpay,userfen from {$dbtbpre}enewsshoppayfs where payid='$add[payfsid]' and isclose=0");
		if(empty($payr['payid']))
		{
			printerror("NotPayfsid","history.go(-1)",1);
		}
	}
	//ȡ���û���Ϣ
	$user=array();
	$userid=(int)getcvar('mluserid');
	$username=RepPostVar(getcvar('mlusername'));
	if($userid)
	{
		islogin();
		$rnd=RepPostVar(getcvar('mlrnd'));
		$user=$empire->fetch1("select ".eReturnSelectMemberF('userid,money,userfen,groupid')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$userid' and ".egetmf('rnd')."='$rnd' limit 1");
		if(!$user['userid'])
		{
			printerror("MustSingleUser","history.go(-1)",1);
		}
	}
	//�Ż�
	$prer=array();
	$pretotal=0;
	if($add['precode'])
	{
		$prer=ShopSys_GetPre($add['precode'],$alltotal,$user,$classids);
		$pretotal=ShopSys_PreMoney($prer,$alltotal);
	}
	//�˷�
	$truetotalmoney=$alltotal-$pretotal;
	if($pr['pid'])
	{
		$pr['price']=ShopSys_PrePsTotal($pr['pid'],$pr['price'],$truetotalmoney,$shoppr);
	}
	//��Ʊ
	$fptotal=0;
	if($add[fp])
	{
		$fptotal=($alltotal-$pretotal)*($shoppr['fpnum']/100);
	}
	//֧�����
	$buyallfen=$alltotalfen+$pr['price'];
	$buyallmoney=$alltotal+$pr['price']+$fptotal-$pretotal;
	if($buyallmoney<0)
	{
		$buyallmoney=0;
	}
	$location="buycar/";
	if($payr[userfen])	//ֱ�ӿ۵�
	{
		if($buyr[0])
		{
			printerror("NotProductForBuyfen","history.go(-1)",1);
		}
		else
		{
			if($userid)
			{
				$buyallfen=$alltotalfen+$pr[price];
				if($buyallfen>$user['userfen'])
				{
					printerror("NotEnoughFenBuy","history.go(-1)",1);
				}
				//�۳�����
				$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('userfen')."=".egetmf('userfen')."-".$buyallfen." where ".egetmf('userid')."='$userid'");
				if($usql)
				{
					$mess="AddDdSuccessa";
					$payby=1;
					$haveprice=1;
				}
			}
			else
			{
				printerror("NotLoginTobuy","history.go(-1)",1);
			}
		}
	}
	elseif($payr[userpay])	//�ʺ����۳�
	{
		    if($userid)
			{
				$buyallmoney=$alltotal+$pr[price]+$fptotal-$pretotal;
				if($buyallmoney<0)
				{
					$buyallmoney=0;
				}
				if($buyallmoney>$user['money'])
				{
					printerror("NotEnoughMoneyBuy","history.go(-1)",1);
				}
				//�۳����
				$usql=$empire->query("update ".eReturnMemberTable()." set ".egetmf('money')."=".egetmf('money')."-".$buyallmoney." where ".egetmf('userid')."='$userid'");
				if($usql)
				{
					$mess="AddDdSuccessa";
					$payby=2;
					$haveprice=1;
				}
			}
			else
			{
				printerror("NotLoginTobuy","history.go(-1)",1);
			}
	}
	elseif($payr[payurl])	//����֧��
	{
		$mess="AddDdAndToPaySuccess";
		$location=$payr[payurl];
	}
	else
	{}
	$ddtime=date("Y-m-d H:i:s");
	$ddtruetime=time();
	$ip=egetip();
	$pr[price]=(float)$pr[price];
	$alltotal=(float)$alltotal;
	$alltotalfen=(float)$alltotalfen;
	$fptotal=(float)$fptotal;
	$pretotal=(float)$pretotal;
	$sql=$empire->query("insert into {$dbtbpre}enewsshopdd(ddno,ddtime,userid,username,outproduct,haveprice,checked,truename,oicq,msn,email,`mycall`,phone,address,zip,psid,psname,pstotal,alltotal,payfsid,payfsname,payby,alltotalfen,fp,fptt,fptotal,fpname,userip,signbuild,besttime,pretotal,ddtruetime) values('$add[ddno]','$ddtime',$userid,'$username',0,'$haveprice',0,'$add[truename]','$add[oicq]','$add[msn]','$add[email]','$add[mycall]','$add[phone]','$add[address]','$add[zip]','$add[psid]','$pr[pname]',$pr[price],$alltotal,'$add[payfsid]','$payr[payname]','$payby',$alltotalfen,$add[fp],'$add[fptt]',$fptotal,'$add[fpname]','$ip','$add[signbuild]','$add[besttime]','$pretotal','$ddtruetime');");
	$ddid=$empire->lastid();
	$sqladd=$empire->query("insert into {$dbtbpre}enewsshopdd_add(ddid,buycar,bz,retext) values('$ddid','".addslashes($buycar)."','$add[bz]','');");
	//�����
	if($shoppr['cutnumtype']==0)
	{
		Shopsys_CutMaxnum($ddid,$buycar,0,$shoppr,0);
	}
	else
	{
		if($haveprice==1)
		{
			Shopsys_CutMaxnum($ddid,$buycar,0,$shoppr,0);
		}
	}
	//�Ż���
	if($prer['id'])
	{
		$prer['id']=(int)$prer['id'];
		if($prer['reuse']==0)
		{
			$empire->query("delete from {$dbtbpre}enewsshop_precode where id='".$prer['id']."'");
		}
		elseif($prer['reuse']&&$prer['usenum'])
		{
			if($prer['usenum']<=$prer['haveusenum']+1)
			{
				$empire->query("delete from {$dbtbpre}enewsshop_precode where id='".$prer['id']."'");
			}
			else
			{
				$empire->query("update {$dbtbpre}enewsshop_precode set haveusenum=haveusenum+1 where id='".$prer['id']."'");
			}
		}
	}
	if($sql)
	{
		$set=esetcookie("paymoneyddid",$ddid,0);
		SetBuycar("");
		printerror($mess,$location,1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//���ع��ﳵ����
function ReturnBuycardd($shoppr){
	global $empire,$class_r,$dbtbpre;
	$buycar=getcvar('mybuycar');
	$record="!";
	$field="|";
	$r=explode($record,$buycar);
	$alltotal=0;
	$return[0]=0;//�Ƿ�ȫ������
	$return[1]=0;//�����ܻ���
	$return[2]=0;//�����ܽ��
	$return[3]="";//��Ÿ�ʽ
	$return['classids']="";//��Ŀ����
	$cdh='';
	$newbuycar="";
	for($i=0;$i<count($r)-1;$i++)
	{
		$pr=explode($field,$r[$i]);
		$productid=$pr[1];
		$fr=explode(",",$pr[1]);
		//ID
		$classid=(int)$fr[0];
		$id=(int)$fr[1];
		if(empty($class_r[$classid][tbname]))
		{
			continue;
		}
		//��֤�̳Ǳ�
		ShopSys_CheckShopTb($class_r[$classid]['tbname'],$shoppr);
		//��������
		if($shoppr['haveatt'])
		{
			$addattstr=dgdb_tosave(ShopSys_BuycarRepvar2(RepPostStr($pr[2])));
		}
		else
		{
			$addattstr='';
		}
		//����
		$num=ReturnBuycarProductNum($pr[3]);
		if(empty($num))
		{
			$num=1;
		}
		//ȡ�ò�Ʒ��Ϣ
		$productr=$empire->fetch1("select title,tprice,price,isurl,titleurl,classid,id,titlepic,buyfen,pmaxnum from {$dbtbpre}ecms_".$class_r[$classid][tbname]." where id='$id' limit 1");
		if(!$productr['id']||$productr['classid']!=$classid)
		{
			continue;
		}
		//�޻�
		if($productr['pmaxnum']<1)
		{
			printerror("ShopNotProductNum","history.go(-1)",1);
		}
		//���
		Shopsys_CheckMaxnum($num,$productr['pmaxnum'],$shoppr);
		//�Ƿ�ȫ������
		if(!$productr[buyfen])
		{
			$return[0]=1;
		}
		$return[1]+=$productr[buyfen]*$num;
		$thistotal=$productr[price]*$num;
		$alltotal+=$thistotal;
		//��Ŀ����
		$return['classids'].=$cdh.$productr['classid'];
		$cdh=',';
		//��ɴ�ŵĸ�ʽ
		$title=str_replace("!","",$productr[title]);
		$title=str_replace("|","",$title);
		$title=str_replace(",","",$title);
		$title=dgdb_tosave($title);
		$productr[price]=dgdb_tosave($productr[price]);
		$productr[buyfen]=dgdb_tosave($productr[buyfen]);
		$newbuycar.="|".$classid.",".$id."|".$addattstr."|".$num."|".$productr[price]."|".$productr[buyfen]."|".$title."!";
    }
	$return[2]=$alltotal;
	$return[3]=$newbuycar;
	return $return;
}

//δ����ļ���֧��
function ShopDdToPay($ddid){
	global $empire,$dbtbpre;
	$ddid=(int)$ddid;
	if(!$ddid)
	{
		printerror("NotShopDdId","history.go(-1)",1);
	}
	//�Ƿ��½
	$user_r=islogin();
	$r=$empire->fetch1("select ddid,payfsid,haveprice,checked,ddtime from {$dbtbpre}enewsshopdd where ddid='$ddid' and userid='$user_r[userid]' limit 1");
	if(!$r['ddid'])
	{
		printerror("NotShopDdId","history.go(-1)",1);
	}
	if($r['checked']==2)
	{
		printerror("ShopDdCancel","history.go(-1)",1);
	}
	if($r['haveprice'])
	{
		printerror("ShopDdIdHavePrice","history.go(-1)",1);
	}
	if(empty($r['payfsid']))
	{
		printerror("NotPayfsid","history.go(-1)",1);
	}
	//֧����ʽ
	$payr=$empire->fetch1("select payid,payurl from {$dbtbpre}enewsshoppayfs where payid='$r[payfsid]' and isclose=0");
	if(!$payr['payid']||!$payr['payurl'])
	{
		printerror("NotPayfsid","history.go(-1)",1);
	}
	$location=$payr['payurl'];
	esetcookie("paymoneyddid",$ddid,0);
	Header("Refresh:0; URL=$location");
}

//ɾ������
function ShopSys_qDelDd($add){
	global $empire,$dbtbpre,$public_r;
	$shoppr=ShopSys_ReturnSet();
	//�Ƿ��½
	$user_r=islogin();
	$ddid=(int)$add['ddid'];
	if(!$ddid)
	{
		printerror("NotChangeShopDdid","history.go(-1)",1);
	}
	$r=$empire->fetch1("select ddid,outproduct,haveprice,checked,ddtime,havecutnum from {$dbtbpre}enewsshopdd where ddid='$ddid' and userid='$user_r[userid]' limit 1");
	if(!$r['ddid'])
	{
		printerror("NotChangeShopDdid","history.go(-1)",1);
	}
	//��������ɾ��
	if($r['checked']||$r['outproduct']||$r['haveprice'])
	{
		printerror("NotDelShopDd","history.go(-1)",1);
	}
	//����ʱ�䲻��ɾ��
	$dddeltime=$shoppr['dddeltime']*60;
	if(time()-$dddeltime>to_time($r['ddtime']))
	{
		printerror("OuttimeNotDelShopDd","history.go(-1)",1);
	}
	//��ԭ���
	if($shoppr['cutnumtype']==0)
	{
		$buycarr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$ddid'");
		Shopsys_CutMaxnum($ddid,$buycarr['buycar'],$r['havecutnum'],$shoppr,1);
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsshopdd where ddid='$ddid' and userid='$user_r[userid]'");
	$sqladd=$empire->query("delete from {$dbtbpre}enewsshopdd_add where ddid='$ddid'");
	if($sql)
	{
		printerror('DelShopDdSuccess','ListDd/',1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//����ȡ����������ԭ���
function ShopSys_TimeCutMaxnum($userid,$shoppr){
	global $empire,$dbtbpre,$class_r;
	if($shoppr['cutnumtype']==1||$shoppr['cutnumtime']==0)
	{
		return '';
	}
	$userid=(int)$userid;
	$where=$userid?"userid='$userid' and ":"";
	$time=time()-($shoppr['cutnumtime']*60);
	$ddsql=$empire->query("select ddid,havecutnum from {$dbtbpre}enewsshopdd where ".$where."haveprice=0 and checked=0 and havecutnum=1 and ddtruetime<$time");
	while($ddr=$empire->fetch($ddsql))
	{
		$ddaddr=$empire->fetch1("select buycar from {$dbtbpre}enewsshopdd_add where ddid='$ddr[ddid]'");
		Shopsys_CutMaxnum($ddr['ddid'],$ddaddr['buycar'],$ddr['havecutnum'],$shoppr,1);
	}
	$empire->query("update {$dbtbpre}enewsshopdd set checked=2 where ".$where."haveprice=0 and checked=0 and havecutnum=1 and ddtruetime<$time");
}

//������ַ
function ShopSys_AddAddress($add){
	global $empire,$dbtbpre,$public_r;
	//�Ƿ��½
	$user_r=islogin();
	$add['addressname']=dgdb_tosave($add['addressname']);
	$add['truename']=dgdb_tosave($add['truename']);
	$add['oicq']=dgdb_tosave($add['oicq']);
	$add['msn']=dgdb_tosave($add['msn']);
	$add['email']=dgdb_tosave($add['email']);
	$add['address']=dgdb_tosave($add['address']);
	$add['zip']=dgdb_tosave($add['zip']);
	$add['mycall']=dgdb_tosave($add['mycall']);
	$add['phone']=dgdb_tosave($add['phone']);
	$add['signbuild']=dgdb_tosave($add['signbuild']);
	$add['besttime']=dgdb_tosave($add['besttime']);
	if(!trim($add['addressname']))
	{
		printerror("EmptyAddress","history.go(-1)",1);
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsshop_address where userid='$user_r[userid]'");
	$isdefault=$num?0:1;
	$sql=$empire->query("insert into {$dbtbpre}enewsshop_address(addressname,userid,truename,oicq,msn,email,address,zip,mycall,phone,signbuild,besttime,isdefault) values('$add[addressname]','$user_r[userid]','$add[truename]','$add[oicq]','$add[msn]','$add[email]','$add[address]','$add[zip]','$add[mycall]','$add[phone]','$add[signbuild]','$add[besttime]','$isdefault');");
	if($sql)
	{
		printerror('AddAddressSuccess','address/AddAddress.php?enews=AddAddress',1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//�޸ĵ�ַ
function ShopSys_EditAddress($add){
	global $empire,$dbtbpre,$public_r;
	//�Ƿ��½
	$user_r=islogin();
	$addressid=(int)$add['addressid'];
	$add['addressname']=dgdb_tosave($add['addressname']);
	$add['truename']=dgdb_tosave($add['truename']);
	$add['oicq']=dgdb_tosave($add['oicq']);
	$add['msn']=dgdb_tosave($add['msn']);
	$add['email']=dgdb_tosave($add['email']);
	$add['address']=dgdb_tosave($add['address']);
	$add['zip']=dgdb_tosave($add['zip']);
	$add['mycall']=dgdb_tosave($add['mycall']);
	$add['phone']=dgdb_tosave($add['phone']);
	$add['signbuild']=dgdb_tosave($add['signbuild']);
	$add['besttime']=dgdb_tosave($add['besttime']);
	if(!$addressid||!trim($add['addressname']))
	{
		printerror("EmptyAddress","history.go(-1)",1);
	}
	$sql=$empire->query("update {$dbtbpre}enewsshop_address set addressname='$add[addressname]',truename='$add[truename]',oicq='$add[oicq]',msn='$add[msn]',email='$add[email]',address='$add[address]',zip='$add[zip]',mycall='$add[mycall]',phone='$add[phone]',signbuild='$add[signbuild]',besttime='$add[besttime]' where addressid='$addressid' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror('EditAddressSuccess','address/ListAddress.php',1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//ɾ����ַ
function ShopSys_DelAddress($add){
	global $empire,$dbtbpre,$public_r;
	//�Ƿ��½
	$user_r=islogin();
	$addressid=(int)$add['addressid'];
	if(!$addressid)
	{
		printerror("NotAddressid","history.go(-1)",1);
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsshop_address where addressid='$addressid' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror('DelAddressSuccess','address/ListAddress.php',1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//Ĭ�ϵ�ַ
function ShopSys_DefAddress($add){
	global $empire,$dbtbpre,$public_r;
	//�Ƿ��½
	$user_r=islogin();
	$addressid=(int)$add['addressid'];
	if(!$addressid)
	{
		printerror("NotAddressid","history.go(-1)",1);
	}
	$sql1=$empire->query("update {$dbtbpre}enewsshop_address set isdefault=0 where userid='$user_r[userid]'");
	$sql=$empire->query("update {$dbtbpre}enewsshop_address set isdefault=1 where addressid='$addressid' and userid='$user_r[userid]'");
	if($sql)
	{
		printerror('DefAddressSuccess','address/ListAddress.php',1);
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//��ȡ��ַ
function ShopSys_GetAddress($addressid){
	global $empire,$dbtbpre,$public_r;
	//�Ƿ��½
	$user_r=islogin();
	$addressid=(int)$addressid;
	if($addressid)
	{
		$where="addressid='$addressid'";
	}
	else
	{
		$where="isdefault=1";
	}
	$address_r=$empire->fetch1("select * from {$dbtbpre}enewsshop_address where userid='$user_r[userid]' and ".$where." limit 1");
	return $address_r;
}
?>