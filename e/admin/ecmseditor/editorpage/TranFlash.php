<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<title>�ϴ�Flash</title>
		<link type="text/css" href="images/editorpage.css" rel=stylesheet>
		<script>
		function EcmsEditorReturnDoAction2(str){
			window.parent.EHEcmsEditorDoTranFlash(str);
			self.location.href=self.location.href;
		}
		</script>

		<script type="text/javascript">
		function DoCheckTranFile(obj){
			var ctypes,actypes,cfiletype,sfile,sfocus;
			ctypes="<?=$ecms_config['sets']['tranflashtype']?>";
			actypes="<?=$public_r['filetype']?>";
			if(obj.tranurl.value==''&&obj.file.value=='')
			{
				alert('��ѡ��Ҫ�ϴ���FLASH');
				obj.file.focus();
				return false;
			}
			if(obj.file.value!='')
			{
				sfile=obj.file.value;
				sfocus=0;
			}
			else
			{
				sfile=obj.tranurl.value;
				sfocus=1;
			}
			cfiletype=','+ToGetFiletype(sfile)+',';
			if(ctypes.indexOf(cfiletype)==-1)
			{
				alert('�ļ���չ������');
				if(sfocus==1)
				{
					obj.tranurl.focus();
				}
				else
				{
					obj.file.focus();
				}
				return false;
			}
			cfiletype='|'+ToGetFiletype(sfile)+'|';
			if(actypes.indexOf(cfiletype)==-1)
			{
				alert('�ļ���չ����������ķ�Χ��');
				if(sfocus==1)
				{
					obj.tranurl.focus();
				}
				else
				{
					obj.file.focus();
				}
				return false;
			}
			ReturnFileNo(obj);
			return true;
		}
		function ToGetFiletype(sfile){
			var filetype,s;
			s=sfile.lastIndexOf(".");
			filetype=sfile.substring(s+1).toLowerCase();
			return '.'+filetype;
		}
		//���ر��
		function ExpStr(str,exp){
			var pos,len,ext;
			pos=str.lastIndexOf(exp)+1;
			len=str.length;
			ext=str.substring(pos,len);
			return ext;
		}
		function ReturnFileNo(obj){
			var filename,str,exp;
			if(obj.no.value!='')
			{
				return '';
			}
			if(obj.file.value!='')
			{
				str=obj.file.value;
			}
			else
			{
				str=obj.tranurl.value;
			}
			if(str.indexOf("\\")>=0)
			{
				exp="\\";
			}
			else
			{
				exp="/";
			}
			filename=ExpStr(str,exp);
			obj.no.value=filename;
		}
		</script>
	</head>
	<body scroll="no" style="OVERFLOW: hidden" topmargin="0">
		 
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" id="tranpictb">
    <form id="TranFlashFormT" name="TranFlashFormT" method="post" target="eeditoruploadflash<?=$ecms_topager['InstanceId']?>" enctype="multipart/form-data" action="../ecmseditor.php" onsubmit="return DoCheckTranFile(TranFlashFormT);">
	<?=$ecms_hashur['form']?>
      <input type=hidden name=classid value="<?=$ecms_topager['classid']?>">
      <input type=hidden name=filepass value="<?=$ecms_topager['filepass']?>">
	  <input type=hidden name=infoid value="<?=$ecms_topager['infoid']?>">
      <input type=hidden name=modtype value="<?=$ecms_topager['modtype']?>">
      <input type=hidden name=sinfo value="<?=$ecms_topager['sinfo']?>">
      <input type=hidden name=enews value="TranFile">
      <input type=hidden name=type value="2">
      <input type=hidden name=doing value="0">
      <input type=hidden name=tranfrom value="1">
      <input type=hidden name=InstanceName value="<?=$ecms_topager['InstanceName']?>">
	  <input type=hidden name=InstanceId value="<?=$ecms_topager['InstanceId']?>">
	  <input type=hidden name=doecmspage id=doecmspage value="<?=$doecmspage?>">
      <tr> 
        <td><strong>Զ�̱���</strong><br> 
        <input name="tranurl" type="text" id="tranurl" size="32" style="width: 100%"></td>
      </tr>
      <tr> 
        <td><strong>�����ϴ�</strong><br> 
          <input type="file" name="file" id="file" style="width: 100%"> 
        </td>
      </tr>
      <tr> 
        <td><strong>�ļ�����</strong><br> 
          <input name="no" type="text" id="no" value="<?=$ecms_topager['fileno']?>" style="width: 100%"> 
        </td>
      </tr>
      <tr> 
        <td height="30"> <input type="submit" name="Submit2" value="���͵���������"> 
        </td>
      </tr>
    </form>
  </table>
  <iframe name="eeditoruploadflash<?=$ecms_topager['InstanceId']?>" id="eeditoruploadflash<?=$ecms_topager['InstanceId']?>" style="display:none" src="images/blank.html"></iframe>
  
	</body>
</html>
