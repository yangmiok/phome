<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>�ϴ�ͼƬ</title>
	<link type="text/css" href="images/editorpage.css" rel=stylesheet>
	<script>
	function EcmsEditorReturnDoAction1(str){
		window.parent.EHEcmsEditorDoTranImg(str);
		self.location.href=self.location.href;
	}
	</script>

		<script type="text/javascript">
		function DoCheckTranFile(obj){
			var ctypes,actypes,cfiletype,sfile,sfocus;
			ctypes="<?=$ecms_config['sets']['tranpicturetype']?>";
			if(obj.file.value=='')
			{
				alert('��ѡ��Ҫ�ϴ���ͼƬ');
				obj.file.focus();
				return false;
			}
			sfile=obj.file.value;
			sfocus=0;
			cfiletype=','+ToGetFiletype(sfile)+',';
			if(ctypes.indexOf(cfiletype)==-1)
			{
				alert('�ļ���չ������');
				obj.file.focus();
				return false;
			}
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
			str=obj.file.value;
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
<body scroll="no" style="overflow: hidden" topmargin="0">
	
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" id="tranpictb">
  <form id="TranImgFormT" name="TranImgFormT" method="post" target="eeditoruploadimg<?=$ecms_topager['InstanceId']?>" enctype="multipart/form-data" action="../../../DoInfo/ecms.php" onsubmit="return DoCheckTranFile(document.TranImgFormT);">
	<input type=hidden name=classid value="<?=$ecms_topager['classid']?>">
	<input type=hidden name=filepass value="<?=$ecms_topager['filepass']?>">
	<input type=hidden name=infoid value="<?=$ecms_topager['infoid']?>">
    <input type=hidden name=enews value="MEditorTranFile">
    <input type=hidden name=type value="1">
    <input type=hidden name=doing value="0">
	<input type=hidden name=tranfrom value="1">
	<input type=hidden name=InstanceName value="<?=$ecms_topager['InstanceName']?>">
	<input type=hidden name=InstanceId value="<?=$ecms_topager['InstanceId']?>">
	<input type=hidden name=doecmspage id=doecmspage value="<?=$doecmspage?>">
    
    <tr> 
        <td><strong>�����ϴ�</strong><br>
          <input type="file" name="file" id="txtUploadFile" style="width: 100%">      </td>
    </tr>
	
    <tr> 
        <td height="30">
<input type="submit" name="Submit2" value="�� ��">        </td>
    </tr>
	</form>
  </table>
  <iframe name="eeditoruploadimg<?=$ecms_topager['InstanceId']?>" id="eeditoruploadimg<?=$ecms_topager['InstanceId']?>" style="display:none" src="images/blank.html"></iframe>
	
</body>
</html>
