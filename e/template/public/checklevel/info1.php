<?php

//��Ϣ�鿴Ȩ����ʾ����
function eCheckLevelInfo_ViewInfoMsg($ckuser,$r,$ecms){
	global $empire,$dbtbpre,$public_r,$check_path,$level_r,$class_r,$public_diyr;
	$ViewLevel=eCheckLevelInfo_ReturnViewLevelSay($r);
	$msg=eCheckLevelInfo_ReturnMsgStr($ckuser,$ecms);
	$r['title']=stripSlashes($r['title']);
	$showsmalltext=eCheckLevelInfo_ReturnIntroField($r);
	$public_diyr['pagetitle']=$r['title'];
	$url="<a href='".$public_r['newsurl']."'>��ҳ</a>&nbsp;>&nbsp;<a href='".$public_r['newsurl']."e/member/cp/'>��Ա����</a>&nbsp;>&nbsp;�鿴��Ϣ��".$r['title'];
	@include(ECMS_PATH."e/data/template/cp_1.php");
	?>
	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="25">��ʾ��Ϣ</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25"><?=$msg?></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td height="25" colspan="2">���⣺
      <?=$r['title']?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">�鿴Ȩ�ޣ�</td>
    <td height="25">
      <?=$ViewLevel?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="17%" height="25">����ʱ�䣺</td>
    <td width="83%" height="25"> 
      <?=date("Y-m-d H:i:s",$r['newstime'])?>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td height="25">��Ϣ��飺</td>
    <td height="25"> 
      <?=$showsmalltext?>
    </td>
  </tr>
	</table>
	<?php
	@include(ECMS_PATH."e/data/template/cp_2.php");
	exit();
}

//������ʾ��Ϣ����
function eCheckLevelInfo_ReturnMsgStr($ckuser,$ecms){
	global $check_path,$level_r,$empire,$gotourl,$toreturnurl,$public_r,$dbtbpre,$class_r,$checkinfor;
	$msgstr='';
	if($ecms=='NotLogin')//δ��¼
	{
		$msgstr="����δ��½��<a href='$gotourl'><u>�������</u></a>���е�½������ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	elseif($ecms=='SingleLogin')//ֻ��һ������
	{
		$msgstr="ͬһ�ʺ�ֻ��һ�����ߣ�<a href='$gotourl'><u>�������</u></a>���µ�½��ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	elseif($ecms=='NotCheckUser')//δ���
	{
		$msgstr="�����ʺŻ�δ���ͨ����<a href='$gotourl'><u>�������</u></a>���µ�½��ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	elseif($ecms=='NotLevelClass')//Ȩ�޲���(��Ŀ����)
	{
		$msgstr="��û���㹻Ȩ�޲鿴����Ϣ! <a href='$gotourl'><u>�������</u></a>���µ�½��ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	elseif($ecms=='NotLevelGroup')//Ȩ�޲���(��Ա��)
	{
		$msgstr="���Ļ�Ա������(���ĵ�ǰ����".$level_r[$ckuser['groupid']]['groupname'].")��û�в鿴����Ϣ��Ȩ��! <a href='$gotourl'><u>�������</u></a>���µ�½��ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	elseif($ecms=='NotLevelViewGroup')//Ȩ�޲���(������)
	{
		$msgstr="���Ļ�Ա�����㣬û�в鿴����Ϣ��Ȩ��! <a href='$gotourl'><u>�������</u></a>���µ�½��ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	elseif($ecms=='NotUserfen')//��������
	{
		$msgstr="���ĵ�������(����ǰӵ�еĵ��� ".$ckuser['userfen']." ��)��û�в鿴����Ϣ��Ȩ��! <a href='$gotourl'><u>�������</u></a>���µ�½��ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	else
	{
		$msgstr="����δ��½��<a href='$gotourl'><u>�������</u></a>���е�½������ע����<a href='".$public_r['newsurl']."e/member/register/'><u>�������</u></a>��";
	}
	return $msgstr;
}

//������Ҫ�Ĳ鿴Ȩ����ʾ
function eCheckLevelInfo_ReturnViewLevelSay($infor){
	global $check_path,$level_r,$empire,$gotourl,$toreturnurl,$public_r,$dbtbpre,$class_r,$checkinfor;
	if(empty($infor['userfen']))//����Ҫ�۵�
	{
		if($class_r[$infor['classid']]['cgtoinfo'])//��Ŀ����
		{
			$ViewLevel="��Ҫ [".eCheckLevelInfo_ViewInfoLevels($infor['eclass_cgroupid'])."] ������ܲ鿴��";
		}
		else
		{
			if($infor['groupid']>0)
			{
				$ViewLevel="��Ҫ [".$level_r[$infor['groupid']]['groupname']."] �������ϲ��ܲ鿴��";
			}
			else
			{
				$ViewLevel="��Ҫ [�ض�������] ������ܲ鿴��";
			}
		}
	}
	else//��Ҫ�۵�
	{
		if($class_r[$infor['classid']]['cgtoinfo'])//��Ŀ����
		{
			$ViewLevel="��Ҫ [".eCheckLevelInfo_ViewInfoLevels($infor['eclass_cgroupid'])."] ������۳� ".$infor['userfen']." ����ܲ鿴��";
		}
		else
		{
			if($infor['groupid']>0)
			{
				$ViewLevel="��Ҫ [".$level_r[$infor['groupid']]['groupname']."] ����������۳� ".$infor['userfen']." ����ܲ鿴��";
			}
			else
			{
				$ViewLevel="��Ҫ [�ض�������] ������۳� ".$infor['userfen']." ����ܲ鿴��";
			}
		}
	}
	return $ViewLevel;
}

//����Ȩ���б�
function eCheckLevelInfo_ViewInfoLevels($groupid){
	global $level_r;
	if(empty($groupid))
	{
		return '���ٻ�Ա';
	}
	$r=explode(',',$groupid);
	$count=count($r)-1;
	$groups='';
	$dh='';
	for($i=1;$i<$count;$i++)
	{
		$groups.=$dh.$level_r[$r[$i]][groupname];
		$dh=',';
	}
	return $groups;
}

//���ؼ���ֶ�
function eCheckLevelInfo_ReturnIntroField($r){
	global $public_r,$class_r,$emod_r,$check_tbname;
	$sublen=120;//��ȡ120����
	$mid=$class_r[$r[classid]]['modid'];
	$smalltextf=$emod_r[$mid]['smalltextf'];
	$stf=$emod_r[$mid]['savetxtf'];
	//���
	$value='';
	$showf='';
	if($smalltextf&&$smalltextf<>',')
	{
		$smr=explode(',',$smalltextf);
		$smcount=count($smr)-1;
		for($i=1;$i<$smcount;$i++)
		{
			$smf=$smr[$i];
			if($r[$smf])
			{
				$value=$r[$smf];
				$showf=$smf;
				break;
			}
		}
	}
	if(empty($showf))
	{
		$value=strip_tags($r['newstext']);
		$value=esub($value,$sublen);
		$showf='newstext';
	}
	//���ı�
	if($stf==$showf)
	{
		$value='';
	}
	return stripSlashes($value);
}

?>