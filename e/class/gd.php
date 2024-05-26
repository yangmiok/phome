<?php
define('InEmpireCMSGd',TRUE);

//ԭ�ļ�,���ļ�,���,�߶�,ά�ֱ���
function ResizeImage($big_image_name, $new_name, $max_width = 400, $max_height = 400, $resize = 1){
	$returnr['file']='';
	$returnr['filetype']='';
    if($temp_img_type = @getimagesize($big_image_name)) {preg_match('/\/([a-z]+)$/i', $temp_img_type[mime], $tpn); $img_type = $tpn[1];}
    else {preg_match('/\.([a-z]+)$/i', $big_image_name, $tpn); $img_type = $tpn[1];}
    $all_type = array(
        "jpg"   => array("create"=>"ImageCreateFromjpeg", "output"=>"imagejpeg"  , "exn"=>".jpg"),
        "gif"   => array("create"=>"ImageCreateFromGIF" , "output"=>"imagegif"   , "exn"=>".gif"),
        "jpeg"  => array("create"=>"ImageCreateFromjpeg", "output"=>"imagejpeg"  , "exn"=>".jpg"),
        "png"   => array("create"=>"imagecreatefrompng" , "output"=>"imagepng"   , "exn"=>".png"),
        "wbmp"  => array("create"=>"imagecreatefromwbmp", "output"=>"image2wbmp" , "exn"=>".wbmp")
    );

    $func_create = $all_type[$img_type]['create'];
    if(empty($func_create) or !function_exists($func_create)) 
	{
		return $returnr;
	}
	//���
    $func_output = $all_type[$img_type]['output'];
    $func_exname = $all_type[$img_type]['exn'];
	if(($func_exname=='.gif'||$func_exname=='.png'||$func_exname=='.wbmp')&&!function_exists($func_output))
	{
		$func_output='imagejpeg';
		$func_exname='.jpg';
	}
    $big_image   = $func_create($big_image_name);
    $big_width   = imagesx($big_image);
    $big_height  = imagesy($big_image);
    if($big_width <= $max_width and $big_height <= $max_height) 
	{ 
		$func_output($big_image, $new_name.$func_exname);
		$returnr['file']=$new_name.$func_exname;
		$returnr['filetype']=$func_exname;
		return $returnr; 
	}
    $ratiow      = $max_width  / $big_width;
    $ratioh      = $max_height / $big_height;
    if($resize == 1) {
        if($big_width >= $max_width and $big_height >= $max_height)
        {
            if($big_width > $big_height)
            {
            $tempx  = $max_width / $ratioh;
            $tempy  = $big_height;
            $srcX   = ($big_width - $tempx) / 2;
            $srcY   = 0;
            } else {
            $tempy  = $max_height / $ratiow;
            $tempx  = $big_width;
            $srcY   = ($big_height - $tempy) / 2;
            $srcX   = 0;
            }
        } else {
            if($big_width > $big_height)
            {
            $tempx  = $max_width;
            $tempy  = $big_height;
            $srcX   = ($big_width - $tempx) / 2;
            $srcY   = 0;
            } else {
            $tempy  = $max_height;
            $tempx  = $big_width;
            $srcY   = ($big_height - $tempy) / 2;
            $srcX   = 0;
            }
        }
    } else {
        $srcX      = 0;
        $srcY      = 0;
        $tempx     = $big_width;
        $tempy     = $big_height;
    }

    $new_width  = ($ratiow  > 1) ? $big_width  : $max_width;
    $new_height = ($ratioh  > 1) ? $big_height : $max_height;
    if(function_exists("imagecopyresampled"))
    {
        $temp_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($temp_image, $big_image, 0, 0, $srcX, $srcY, $new_width, $new_height, $tempx, $tempy);
    } else {
        $temp_image = imagecreate($new_width, $new_height);
        imagecopyresized($temp_image, $big_image, 0, 0, $srcX, $srcY, $new_width, $new_height, $tempx, $tempy);
    }
        $func_output($temp_image, $new_name.$func_exname);
        ImageDestroy($big_image);
        ImageDestroy($temp_image);
		$returnr['file']=$new_name.$func_exname;
		$returnr['filetype']=$func_exname;
    return $returnr;
}

/* 
* ���ܣ�ͼƬ��ˮӡ (ˮӡ֧��ͼƬ������) 
* ������ 
*      $groundImage    ����ͼƬ������Ҫ��ˮӡ��ͼƬ����ֻ֧��GIF,JPG,PNG��ʽ�� 
*      $waterPos        ˮӡλ�ã���10��״̬��0Ϊ���λ�ã� 
*                        1Ϊ���˾���2Ϊ���˾��У�3Ϊ���˾��ң� 
*                        4Ϊ�в�����5Ϊ�в����У�6Ϊ�в����ң� 
*                        7Ϊ�׶˾���8Ϊ�׶˾��У�9Ϊ�׶˾��ң� 
*      $waterImage        ͼƬˮӡ������Ϊˮӡ��ͼƬ����ֻ֧��GIF,JPG,PNG��ʽ�� 
*      $waterText        ����ˮӡ������������ΪΪˮӡ��֧��ASCII�룬��֧�����ģ� 
*      $textFont        ���ִ�С��ֵΪ1��2��3��4��5��Ĭ��Ϊ5�� 
*      $textColor        ������ɫ��ֵΪʮ��������ɫֵ��Ĭ��Ϊ#FF0000(��ɫ)�� 
* 
* ע�⣺Support GD 2.0��Support FreeType��GIF Read��GIF Create��JPG ��PNG 
*      $waterImage �� $waterText ��ò�Ҫͬʱʹ�ã�ѡ����֮һ���ɣ�����ʹ�� $waterImage�� 
*      ��$waterImage��Чʱ������$waterString��$stringFont��$stringColor������Ч�� 
*      ��ˮӡ���ͼƬ���ļ����� $groundImage һ���� 
*/ 
function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000",$myfontpath="../data/mask/cour.ttf",$w_pct,$w_quality){
	global $fun_r,$editor;
	if($editor==1){$a='../';}
	elseif($editor==2){$a='../../';}
	elseif($editor==3){$a='../../../';}
	else{$a='';}
	$waterImage=$waterImage?$a.$waterImage:'';
	$myfontpath=$myfontpath?$a.$myfontpath:'';
    $isWaterImage = FALSE; 
    $formatMsg = $fun_r['synotdotype']; 

    //��ȡˮӡ�ļ� 
    if(!empty($waterImage) && file_exists($waterImage)) 
    { 
        $isWaterImage = TRUE; 
        $water_info = getimagesize($waterImage); 
        $water_w    = $water_info[0];//ȡ��ˮӡͼƬ�Ŀ� 
        $water_h    = $water_info[1];//ȡ��ˮӡͼƬ�ĸ� 

        switch($water_info[2])//ȡ��ˮӡͼƬ�ĸ�ʽ 
        { 
            case 1:$water_im = imagecreatefromgif($waterImage);break; 
            case 2:$water_im = imagecreatefromjpeg($waterImage);break; 
            case 3:$water_im = imagecreatefrompng($waterImage);break; 
            default:echo $formatMsg;return ""; 
        } 
    } 

    //��ȡ����ͼƬ 
    if(!empty($groundImage) && file_exists($groundImage)) 
    { 
        $ground_info = getimagesize($groundImage); 
        $ground_w    = $ground_info[0];//ȡ�ñ���ͼƬ�Ŀ� 
        $ground_h    = $ground_info[1];//ȡ�ñ���ͼƬ�ĸ� 

        switch($ground_info[2])//ȡ�ñ���ͼƬ�ĸ�ʽ 
        { 
            case 1:$ground_im = imagecreatefromgif($groundImage);break; 
            case 2:$ground_im = imagecreatefromjpeg($groundImage);break; 
            case 3:$ground_im = imagecreatefrompng($groundImage);break; 
            default:echo $formatMsg;return ""; 
        } 
    } 
    else 
    { 
        echo $fun_r['synotdoimg'];
		return "";
    } 

    //ˮӡλ�� 
    if($isWaterImage)//ͼƬˮӡ 
    { 
        $w = $water_w; 
        $h = $water_h; 
        $label = "ͼƬ��"; 
    } 
    else//����ˮӡ 
    { 
        $temp = imagettfbbox(ceil($textFont*2.5),0,$myfontpath,$waterText);//ȡ��ʹ�� TrueType ������ı��ķ�Χ 
        $w = $temp[2] - $temp[6]; 
        $h = $temp[3] - $temp[7]; 
        unset($temp); 
        $label = "��������"; 
    } 
    if( ($ground_w<$w) || ($ground_h<$h) ) 
    { 
        echo $fun_r['sytoosmall']; 
        return ''; 
    } 
    switch($waterPos) 
    { 
        case 0://��� 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break; 
        case 1://1Ϊ���˾��� 
            $posX = 0; 
            $posY = 0; 
            break; 
        case 2://2Ϊ���˾��� 
            $posX = ($ground_w - $w) / 2; 
            $posY = 0; 
            break; 
        case 3://3Ϊ���˾��� 
            $posX = $ground_w - $w; 
            $posY = 0; 
            break; 
        case 4://4Ϊ�в����� 
            $posX = 0; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 5://5Ϊ�в����� 
            $posX = ($ground_w - $w) / 2; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 6://6Ϊ�в����� 
            $posX = $ground_w - $w; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 7://7Ϊ�׶˾��� 
            $posX = 0; 
            $posY = $ground_h - $h; 
            break; 
        case 8://8Ϊ�׶˾��� 
            $posX = ($ground_w - $w) / 2; 
            $posY = $ground_h - $h; 
            break; 
        case 9://9Ϊ�׶˾��� 
            $posX = $ground_w - $w; 
            $posY = $ground_h - $h; 
            break; 
        default://��� 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break;     
    } 

    //�趨ͼ��Ļ�ɫģʽ 
    imagealphablending($ground_im, true); 

    if($isWaterImage)//ͼƬˮӡ 
    {
		if($water_info[2]==3)
		{
			imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//����ˮӡ��Ŀ���ļ�
		}
		else
		{
			imagecopymerge($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h,$w_pct);//����ˮӡ��Ŀ���ļ�
		}
    } 
    else//����ˮӡ 
    { 
        if( !empty($textColor) && (strlen($textColor)==7) ) 
        { 
            $R = hexdec(substr($textColor,1,2)); 
            $G = hexdec(substr($textColor,3,2)); 
            $B = hexdec(substr($textColor,5)); 
        } 
        else 
        { 
            echo $fun_r['synotfontcolor'];
			return "";
        } 
        imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));         
    } 

    //����ˮӡ���ͼƬ 
    @unlink($groundImage); 
    switch($ground_info[2])//ȡ�ñ���ͼƬ�ĸ�ʽ 
    { 
        case 1:imagegif($ground_im,$groundImage);break; 
        case 2:imagejpeg($ground_im,$groundImage,$w_quality);break; 
        case 3:imagepng($ground_im,$groundImage);break; 
        default:echo $formatMsg;return ""; 
    } 

    //�ͷ��ڴ� 
    if(isset($water_info)) unset($water_info); 
    if(isset($water_im)) imagedestroy($water_im); 
    unset($ground_info); 
    imagedestroy($ground_im); 
}
?>