<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");
require("../../data/dbcache/class.php");
require("../../data/dbcache/MemberLevel.php");
require("../class/DownSysFun.php");
eCheckCloseMods('down');//�ر�ģ��
$link=db_connect();
$empire=new mysqlquery();
$editor=1;
$ecmsreurl=2;
//��֤IP
eCheckAccessDoIp('downinfo');
$id=(int)$_GET['id'];
$pathid=(int)$_GET['pathid'];
$classid=(int)$_GET['classid'];
if(!$classid||empty($class_r[$classid][tbname])||!$id)
{
	echo"<script>alert('����Ϣ������');window.close();</script>";
	exit();
}
$mid=$class_r[$classid][modid];
$tbname=$class_r[$classid][tbname];
$query="select * from {$dbtbpre}ecms_".$tbname." where id='$id' limit 1";
$r=$empire->fetch1($query);
if(!$r['id']||$r['classid']!=$classid)
{
	echo"<script>alert('����Ϣ������');window.close();</script>";
	exit();
}
//����
$finfor=$empire->fetch1("select ".ReturnSqlFtextF($mid)." from {$dbtbpre}ecms_".$tbname."_data_".$r[stb]." where id='$r[id]' limit 1");
$r=array_merge($r,$finfor);
//�������ص�ַ
$path_r=explode("\r\n",$r[downpath]);
if(!$path_r[$pathid])
{
	echo"<script>alert('����Ϣ������');window.close();</script>";
	exit();
}
$showdown_r=explode("::::::",$path_r[$pathid]);
//����Ȩ��
$nockpass='';
$user=array();
$downgroup=$showdown_r[2];
if($downgroup)
{
	$user=islogin();
	//ȡ�û�Ա����
	$u=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('userid')."='$user[userid]' and ".egetmf('rnd')."='$user[rnd]' limit 1");
	if(empty($u['userid']))
	{
		echo"<script>alert('ͬһ�ʺţ�ֻ��һ������');window.close();</script>";
        exit();
    }
	$nockpass=qReturnLoginPassNoCK($user['userid'],$user['username'],$user['rnd'],0);
	//���ش�������
	if($level_r[$u['groupid']]['daydown'])
	{
		$setuserday=DoCheckMDownNum($user['userid'],$u['groupid'],2);
		if($setuserday=='error')
		{
			echo"<script>alert('����������ۿ������ѳ���ϵͳ����(".$level_r[$u['groupid']]['daydown']." ��)!');window.close();</script>";
			exit();
		}
	}
	if($downgroup>0)//��Ա��
	{
		if($level_r[$downgroup][level]>$level_r[$u['groupid']][level])
		{
			echo"<script>alert('���Ļ�Ա������(".$level_r[$downgroup][groupname].")��û������Ȩ��!');window.close();</script>";
			exit();
		}
	}
	else//������
	{
		$vgroupid=0-$downgroup;
		$ckvgresult=eMember_ReturnCheckViewGroup($u,$vgroupid);
		if($ckvgresult<>'empire.cms')
		{
			echo"<script>alert('���Ļ�Ա�����㣬û������Ȩ��!');window.close();</script>";
			exit();
		}
	}
	//�����Ƿ��㹻
	if($showdown_r[3])
	{
		//---------�Ƿ�����ʷ��¼
		$bakr=$empire->fetch1("select id,truetime from {$dbtbpre}enewsdownrecord where id='$id' and classid='$classid' and userid='$user[userid]' and pathid='$pathid' and online=0 order by truetime desc limit 1");
		if($bakr[id]&&(time()-$bakr[truetime]<=$public_r[redodown]*3600))
		{}
		else
		{
			//���¿�
			if($u['userdate']-time()>0)
			{}
			//����
			else
			{
				if($showdown_r[3]>$u['userfen'])
			    {
					echo"<script>alert('���ĵ������� $showdown_r[3] �㣬�޷�����');window.close();</script>";
					exit();
			    }
			}
		}
	}
}
//����
$thisdownname=$showdown_r[0];	//��ǰ���ص�ַ����
$classname=$class_r[$r[classid]]['classname'];	//��Ŀ��
$bclassid=$class_r[$r[classid]]['bclassid'];	//����ĿID
$bclassname=$class_r[$bclassid]['classname'];	//����Ŀ��
$titleurl=sys_ReturnBqTitleLink($r);	//��Ϣ����
$newstime=date('Y-m-d H:i:s',$r['newstime']);
$titlepic=$r['titlepic']?$r['titlepic']:$public_r[newsurl]."e/data/images/notimg.gif";
$ip=egetip();
$pass=md5(md5($classid."-!ecms!".$id."-!ecms!".$pathid).ReturnDownSysCheckIp()."wm_chief".$public_r[downpass].$user[userid]);	//��֤��
$url="../doaction.php?enews=DownSoft&classid=$classid&id=$id&pathid=$pathid&pass=".$pass."&p=".$user[userid].":::".$user[rnd].":::".$nockpass;	//���ص�ַ
$trueurl=ReturnDSofturl($showdown_r[1],$showdown_r[4],'../../',1);	//��ʵ�ļ���ַ
$fen=$showdown_r[3];	//���ص���
$downuser=$downgroup?$level_r[$downgroup][groupname]:'�ο�';	//���صȼ�
@include('../../data/template/downpagetemp.php');
db_close();
$empire=null;
?>