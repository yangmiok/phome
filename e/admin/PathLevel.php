<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
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
db_close();
$empire=null;
//����Ŀ¼Ȩ�޽��
function ReturnPathLevelResult($path){
	$testfile=$path."/test.test";
	$fp=@fopen($testfile,"wb");
	if($fp)
	{
		@fclose($fp);
		@unlink($testfile);
		return 1;
	}
	else
	{
		return 0;
	}
}
//�����ļ�Ȩ�޽��
function ReturnFileLevelResult($filename){
	return is_writable($filename);
}
//���Ŀ¼Ȩ��
function CheckFileMod($filename,$smallfile=""){
	$succ="��";
	$error="<font color=red>��</font>";
	if(!file_exists($filename)||($smallfile&&!file_exists($smallfile)))
	{
		return $error;
	}
	if(is_dir($filename))//Ŀ¼
	{
		if(!ReturnPathLevelResult($filename))
		{
			return $error;
		}
		//��Ŀ¼
		if($smallfile)
		{
			if(is_dir($smallfile))
			{
				if(!ReturnPathLevelResult($smallfile))
				{
					return $error;
				}
			}
			else//�ļ�
			{
				if(!ReturnFileLevelResult($smallfile))
				{
					return $error;
				}
			}
		}
	}
	else//�ļ�
	{
		if(!ReturnFileLevelResult($filename))
		{
			return $error;
		}
		if($smallfile)
		{
			if(!ReturnFileLevelResult($smallfile))
			{
				return $error;
			}
		}
	}
	return $succ;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�۹���վ����ϵͳ</title>

<link href="adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="">
    <tr class="header"> 
      <td height="25"> <div align="center">Ŀ¼Ȩ�޼��</div></td>
    </tr>
    <tr> 
      <td height="100" bgcolor="#FFFFFF"> <div align="center"> 
          <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
            <tr> 
              <td height="23"><strong>��ʾ��Ϣ</strong></td>
            </tr>
            <tr> 
              <td height="25" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1">
                  <tr> 
                    <td height="25"> <li>������Ŀ¼Ȩ����Ϊ0777, ���˺�ɫĿ¼�⣬��Ŀ¼ȫ��Ҫ��Ȩ��Ӧ������Ŀ¼���ļ���<br>
                      </li></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          <br>
          <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="D6E0EF">
            <tr> 
              <td width="34%" height="23"> <div align="center"><strong>Ŀ¼�ļ�����</strong></div></td>
              <td width="42%"> <div align="center"><strong>˵��</strong></div></td>
              <td width="24%"> <div align="center"><strong>Ȩ�޼��</strong></div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left"><font color="#FF0000"><strong>/</strong></font></div></td>
              <td> <div align="center"><font color="#FF0000">ϵͳ��Ŀ¼(��ҪӦ������Ŀ¼)</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/d</div></td>
              <td> <div align="center"><font color="#666666">����Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../d","../../d/txt");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/s</div></td>
              <td> <div align="center"><font color="#666666">ר����Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../s");?>
                </div></td>
            </tr>
			<tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/t</div></td>
              <td> <div align="center"><font color="#666666">���������Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../t");?>
                </div></td>
            </tr>
			<tr bgcolor="#FFFFFF">
			  <td height="25">/ecachefiles</td>
			  <td><div align="center"><font color="#666666">��̬ҳ�滺��Ŀ¼</font></div></td>
			  <td><div align="center"><?=CheckFileMod("../../ecachefiles","../../ecachefiles/empirecms");?></div></td>
		    </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/search</div></td>
              <td> <div align="center"><font color="#666666">������</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../search","../../search/test.txt");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/index.html</div></td>
              <td> <div align="center"><font color="#666666">��վ��ҳ</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../index.html");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/html</div></td>
              <td> <div align="center"><font color="#666666">Ĭ�Ͽ�ѡ��HTML���Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../../html");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/admin/ebak/bdata</td>
              <td> <div align="center"><font color="#666666">�������ݴ��Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("ebak/bdata");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/admin/ebak/zip</td>
              <td> <div align="center"><font color="#666666">��������ѹ�����Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("ebak/zip");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/e/config/config.php</div></td>
              <td> <div align="center"><font color="#666666">���ݿ�Ȳ��������ļ�</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../config/config.php");?>
                </div></td>
            </tr>
            
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="left">/e/data</div></td>
              <td> <div align="center"><font color="#666666">���������ļ����Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../data","../data/tmp");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/install</td>
              <td> <div align="center"><font color="#666666">��װĿ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../install");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/member/iframe/index.php</td>
              <td><div align="center"><font color="#666666">��½״̬��ʾ</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../member/iframe/index.php");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/member/login/loginjs.php</td>
              <td><div align="center"><font color="#666666">JS��½״̬��ʾ</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../member/login/loginjs.php");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/pl/more/index.php</td>
              <td> <div align="center"><font color="#666666">����JS�����ļ�</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../pl/more/index.php");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/sch/index.php</td>
              <td><div align="center"><font color="#666666">ȫվ�����ļ�</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../sch/index.php");?>
                </div></td>
            </tr>
			<tr bgcolor="#FFFFFF"> 
              <td height="25">/e/template</td>
              <td> <div align="center"><font color="#666666">��̬ҳ���ģ��Ŀ¼</font></div></td>
              <td> <div align="center"> 
                  <?=CheckFileMod("../template");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/tool/feedback/temp</td>
              <td><div align="center"><font color="#666666">��Ϣ����</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../tool/feedback/temp","../tool/feedback/temp/test.txt");?>
                </div></td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="25">/e/tool/gbook/index.php</td>
              <td><div align="center"><font color="#666666">���԰�</font></div></td>
              <td><div align="center"> 
                  <?=CheckFileMod("../tool/gbook/index.php");?>
                </div></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr class="header"> 
      <td><div align="center"> 
          &nbsp;&nbsp; &nbsp;&nbsp; </div></td>
    </tr>
  </form>
</table>
</body>
</html>