<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?>
<?php
$public_diyr['pagetitle']='��Ϣ�б�';
$url="<a href=../../../>��ҳ</a>&nbsp;>&nbsp;<a href=../cp/>��Ա����</a>&nbsp;>&nbsp;��Ϣ�б�&nbsp;&nbsp;(<a href='AddMsg/?enews=AddMsg'>������Ϣ</a>)";
require(ECMS_PATH.'e/template/incfile/header.php');
?>
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script> 
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
            <tr>
              <td width="50%" height="30" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="50%" bgcolor="#FFFFFF"><div align="right">[<a href="AddMsg/?enews=AddMsg">������Ϣ</a>]&nbsp;&nbsp;</div></td>
            </tr>
        </table>
        <br>
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
          <form name="listmsg" method="post" action="../doaction.php" onsubmit="return confirm('ȷ��Ҫɾ��?');">
            <tr class="header"> 
              <td width="4%" height="23"> <div align="center"></div></td>
              <td width="45%"><div align="center">����</div></td>
              <td width="18%"><div align="center">������</div></td>
              <td width="23%"><div align="center">����ʱ��</div></td>
              <td width="10%"><div align="center">����</div></td>
            </tr>
            <?php
			while($r=$empire->fetch($sql))
			{
				$img="haveread";
				if(!$r[haveread])
				{$img="nohaveread";}
				//��̨����Ա
				if($r['isadmin'])
				{
					$from_username="<a title='��̨����Ա'><b>".$r[from_username]."</b></a>";
				}
				else
				{
					$from_username="<a href='../ShowInfo/?userid=".$r[from_userid]."' target='_blank'>".$r[from_username]."</a>";
				}
				//ϵͳ��Ϣ
				if($r['issys'])
				{
					$from_username="<b>ϵͳ��Ϣ</b>";
					$r[title]="<b>".$r[title]."</b>";
				}
			?>
            <tr bgcolor="#FFFFFF"> 
              <td height="25"> <div align="center"> 
                  <input name="mid[]" type="checkbox" id="mid[]2" value="<?=$r[mid]?>">
                </div></td>
              <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="9%"><div align="center"><img src="../../data/images/<?=$img?>.gif" border=0></div></td>
                    <td width="91%"><a href="ViewMsg/?mid=<?=$r[mid]?>"> 
                      <?=stripSlashes($r[title])?>
                      </a></td>
                  </tr>
                </table></td>
              <td><div align="center"> 
                  <?=$from_username?>
                </div></td>
              <td><div align="center"> 
                  <?=$r[msgtime]?>
                </div></td>
              <td> <div align="center">&nbsp;[<a href="../doaction.php?enews=DelMsg&mid=<?=$r[mid]?>" onclick="return confirm('ȷ��Ҫɾ��?');">ɾ��</a>]</div></td>
            </tr>
            <?php
			}
			?>
            <tr bgcolor="#FFFFFF"> 
              <td><div align="center"> 
                  <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
                </div></td>
              <td colspan="4"><input type="submit" name="Submit2" value="ɾ��ѡ��"> 
                <input name="enews" type="hidden" value="DelMsg_all">              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td><div align="center"></div></td>
              <td colspan="4"> 
                <?=$returnpage?>              </td>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <td height="23" colspan="5"><div align="center">˵����<img src="../../data/images/nohaveread.gif" width="14" height="11"> 
                  ����δ�Ķ���Ϣ��<img src="../../data/images/haveread.gif" width="15" height="12"> 
                  �������Ķ���Ϣ.</div></td>
            </tr>
          </form>
        </table>
<?php
require(ECMS_PATH.'e/template/incfile/footer.php');
?>