<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='�ղؼ�';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>&nbsp;>&nbsp;�ղؼ�";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
      <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <form name="form1" method="post" action="">
            <tr> 
              <td width="50%" height="30" bgcolor="#FFFFFF">ѡ�����: 
                <select name="cid" id="select" onchange=window.location='../fava/?cid='+this.options[this.selectedIndex].value>
                  <option value="0">��ʾȫ��</option>
                  <?=$select?>
                </select></td>
              <td width="50%" bgcolor="#FFFFFF"><div align="right">[<a href="FavaClass/">�������</a>]&nbsp;&nbsp;</div></td>
            </tr>
          </form>
</table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tableborder">
          <form name=favaform method=post action="../doaction.php" onsubmit="return confirm('ȷ��Ҫ����?');">
            <input type=hidden value=DelFava_All name=enews>
            <tr class="header"> 
              <td width="4%" height="25"><div align="center"></div></td>
              <td width="57%"><div align="center">����</div></td>
              <td width="12%"><div align="center">���</div></td>
              <td width="20%"><div align="center">�ղ�ʱ��</div></td>
              <td width="7%"><div align="center">ѡ��</div></td>
            </tr>
            <?php
			while($fr=$empire->fetch($sql))
			{
				if(empty($class_r[$fr[classid]][tbname]))
				{continue;}
				$r=$empire->fetch1("select title,isurl,titleurl,onclick,classid,id from {$dbtbpre}ecms_".$class_r[$fr[classid]][tbname]." where id='$fr[id]' limit 1");
				//��������
				$titlelink=sys_ReturnBqTitleLink($r);
				if(!$r['id'])
				{
					$r['title']="����Ϣ��ɾ��";
					$titlelink="#EmpireCMS";
				}
			?>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="center"><img src="../../data/images/dir.gif" border=0></div></td>
              <td> <div align="left"><a href="<?=$titlelink?>" target=_blank> 
                  <?=stripSlashes($r[title])?>
                  </a></div></td>
              <td> <div align="center"> 
                  <?=$r[onclick]?>
                </div></td>
              <td> <div align="center"> 
                  <?=$fr[favatime]?>
                </div></td>
              <td> <div align="center"> 
                  <input name="favaid[]" type="checkbox" id="favaid[]2" value="<?=$fr[favaid]?>">
                </div></td>
            </tr>
            <?php
			}
			?>
            <tr bgcolor="#FFFFFF"> 
              <td height="25" colspan="5"> &nbsp;&nbsp;&nbsp; 
                <?=$returnpage?>
                &nbsp;&nbsp; <select name="cid">
                  <option value="0">��ѡ��Ҫת�Ƶ�Ŀ�����</option>
                  <?=$select?>
                </select> <input type="submit" name="Submit" value="ת��ѡ��" onclick="document.favaform.enews.value='MoveFava_All'"> 
              &nbsp;&nbsp; <input type="submit" name="Submit" value="ɾ��ѡ��" onclick="document.favaform.enews.value='DelFava_All'"></td>
            </tr>
          </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>