<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']=$word;
$url="<a href=../../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../../cp/>��Ա����</a>&nbsp;>&nbsp;<a href=../../friend/?cid=".$fcid.">�����б�</a>&nbsp;>&nbsp;".$word;
require(ECMS_PATH.'e/template/incfile/header.php');
?> 
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <form name="form1" method="post" action="../../doaction.php">
            <tr class="header"> 
              <td height="25" colspan="2"><?=$word?></td>
            </tr>
            <tr> 
              <td width="17%" height="25" bgcolor="#FFFFFF">�û���: </td>
              <td width="83%" bgcolor="#FFFFFF"><input name="fname" type="text" id="fname" value="<?=$fname?>">
                (*)</td>
            </tr>
            <tr> 
              <td height="25" bgcolor="#FFFFFF">�������ࣺ</td>
              <td bgcolor="#FFFFFF"><select name="cid">
                  <option value="0">������</option>
                  <?=$select?>
                </select>
                [<a href="../FriendClass/" target="_blank">�������</a>]</td>
            </tr>
            <tr> 
              <td height="25" bgcolor="#FFFFFF">��ע��</td>
              <td bgcolor="#FFFFFF"><input name="fsay" type="text" id="fname3" value="<?=stripSlashes($r[fsay])?>" size="38"></td>
            </tr>
            <tr> 
              <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="�ύ">
                <input type="reset" name="Submit2" value="����">
                <input name="enews" type="hidden" id="enews" value="<?=$enews?>">
                <input name="fid" type="hidden" id="fid" value="<?=$fid?>">
                <input name="fcid" type="hidden" id="fcid" value="<?=$fcid?>">
                <input name="oldfname" type="hidden" id="oldfname" value="<?=$r[fname]?>"></td>
            </tr>
          </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>