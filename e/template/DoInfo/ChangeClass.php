<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='������Ϣ';
$url="<a href='../../'>��ҳ</a>&nbsp;>&nbsp;<a href='../member/cp/'>��Ա����</a>&nbsp;>&nbsp;<a href='ListInfo.php?mid=".$mid."'>������Ϣ</a>&nbsp;>&nbsp;������Ϣ&nbsp;(".$mr[qmname].")";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<script>
function CheckChangeClass()
{
	if(document.changeclass.classid.value==0||document.changeclass.classid.value=='')
	{
		alert("��ѡ����Ŀ");
		return false;
	}
	return true;
}
</script>
      <table width="500" border="0" align="center">
        <tr> 
          <td>��ã�<b><?=$musername?></b></td>
        </tr>
      </table>
      <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
        <form action="AddInfo.php" method="get" name="changeclass" id="changeclass" onsubmit="return CheckChangeClass();">
          <tr class="header"> 
            <td height="23"><strong>��ѡ��Ҫ������Ϣ����Ŀ 
                <input name="mid" type="hidden" id="mid" value="<?=$mid?>">
              <input name="enews" type="hidden" id="enews" value="MAddInfo">
              </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="32"> <select name=classid size="22" style="width:300px">
                <script src="<?=$classjs?>"></script>
              </select> </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><input type="submit" name="Submit" value="�����Ϣ"> <font color="#666666">(��ѡ���ռ���Ŀ[��ɫ��])</font></td>
          </tr>
        </form>
      </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>