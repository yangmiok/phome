<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
//�۵�
ViewOnlineKFen($showdown_r,$u,$u['userid'],$classid,$id,$pathid,$r);

$width=550;
$height=450;
$openwidth=$width+30;
$openheight=$height+60;
?>
<HTML>
<HEAD>
<TITLE><?=$r[title]?> --- ý�岥����</TITLE>
<META HTTP-EQUIV="Expires" CONTENT="0">
<link rel="stylesheet" href="js/player.css">
<script language="javascript">
window.resizeTo(<?=$openwidth?>,<?=$openheight?>);
window.moveTo(100,100);
window.focus()
</script>
<SCRIPT language=javascript>
function click() {
if (event.button==2) {
alert('�Բ���������ʲô��')
}
}
document.onmousedown=click
</SCRIPT>
<BODY id=thisbody  bgcolor="#000000" topMargin=0 leftMargin=0 rightMargin=0 bottomMargin=0 style="scroll:no; overflow: hidden;" ondragstart="self.event.returnValue=false" onselectstart="self.event.returnValue=false">
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tr> 
    <td><div align="center"> 
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?=$width?>" height="<?=$height?>">
          <param name="movie" value="<?=$trueurl?>">
          <param name="quality" value="high">
          <embed src="<?=$trueurl?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?=$width?>" height="<?=$height?>"></embed></object>
      </div></td>
  </tr>
  <tr> 
    <td><div align="center"><font color="#ffffff">[<a href="<?=$trueurl?>" target=_blank><font color="#ffffff">ȫ������</font></a>]</font></div></td>
  </tr>
</table>
</body>
</html>