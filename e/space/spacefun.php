<?php
//����sql���
function espace_ReturnBqQuery($classid,$line,$enews=0,$do=0,$ewhere='',$eorder=''){
	global $empire,$dbtbpre,$public_r,$class_r,$class_zr,$fun_r,$class_tr,$emod_r,$etable_r,$userid,$eyh_r;
	$userid=(int)$userid;
	if($enews==24)//��sql��ѯ
	{
		$query_first=substr($classid,0,7);
		if(!($query_first=='select '||$query_first=='SELECT '))
		{
			return "";
		}
		$classid=RepSqlTbpre($classid);
		$sql=$empire->query1($classid);
		if(!$sql)
		{
			echo"SQL Error: ".ReRepSqlTbpre($classid);
		}
		return $sql;
	}
	if($enews==0||$enews==1||$enews==2||$enews==9||$enews==12||$enews==15)//��Ŀ
	{
		if(strstr($classid,','))//����Ŀ
		{
			$son_r=sys_ReturnMoreClass($classid,1);
			$classid=$son_r[0];
			$where=$son_r[1];
		}
		else
		{
			if($class_r[$classid][islast])
			{
				$where="classid='$classid'";
			}
			else
			{
				$where=ReturnClass($class_r[$classid][sonclass]);
			}
		}
		$tbname=$class_r[$classid][tbname];
		$mid=$class_r[$classid][modid];
		$yhid=$class_r[$classid][yhid];
    }
	elseif($enews==6||$enews==7||$enews==8||$enews==11||$enews==14||$enews==17)//ר��
	{
		echo"Error��Change to use e:indexloop";
		return false;
	}
	elseif($enews==25||$enews==26||$enews==27||$enews==28||$enews==29||$enews==30)//�������
	{
		if(strstr($classid,','))//��������
		{
			$son_r=sys_ReturnMoreTT($classid);
			$classid=$son_r[0];
			$where=$son_r[1];
		}
		else
		{
			$where="ttid='$classid'";
		}
		$mid=$class_tr[$classid][mid];
		$tbname=$emod_r[$mid][tbname];
		$yhid=$class_tr[$classid][yhid];
	}
	$query=" where userid='$userid' and ismember=1";
	if($enews==0)//��Ŀ����
	{
		$query.=' and ('.$where.')';
		$order='newstime';
		$yhvar='bqnew';
    }
	elseif($enews==1)//��Ŀ����
	{
		$query.=' and ('.$where.')';
		$order='onclick';
		$yhvar='bqhot';
    }
	elseif($enews==2)//��Ŀ�Ƽ�
	{
		$query.=' and ('.$where.') and isgood>0';
		$order='newstime';
		$yhvar='bqgood';
    }
	elseif($enews==9)//��Ŀ��������
	{
		$query.=' and ('.$where.')';
		$order='plnum';
		$yhvar='bqpl';
    }
	elseif($enews==12)//��Ŀͷ��
	{
		$query.=' and ('.$where.') and firsttitle>0';
		$order='newstime';
		$yhvar='bqfirst';
    }
	elseif($enews==15)//��Ŀ��������
	{
		$query.=' and ('.$where.')';
		$order='totaldown';
		$yhvar='bqdown';
    }
	elseif($enews==3)//��������
	{
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqnew';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==4)//���е������
	{
		$order='onclick';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqhot';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==5)//�����Ƽ�
	{
		$query.=' and isgood>0';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqgood';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==10)//������������
	{
		$order='plnum';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqpl';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==13)//����ͷ��
	{
		$query.=' and firsttitle>0';
		$order='newstime';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqfirst';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==16)//������������
	{
		$order='totaldown';
		$tbname=$public_r[tbname];
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqdown';
		$yhid=$etable_r[$tbname][yhid];
    }
	elseif($enews==18)//��������
	{
		$order='newstime';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqnew';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==19)//��������
	{
		$order='onclick';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqhot';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==20)//�����Ƽ�
	{
		$query.=' and isgood>0';
		$order='newstime';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqgood';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==21)//������������
	{
		$order='plnum';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqpl';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==22)//����ͷ����Ϣ
	{
		$query.=' and firsttitle>0';
		$order="newstime";
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqfirst';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==23)//������������
	{
		$order='totaldown';
		$tbname=$classid;
		$mid=$etable_r[$tbname][mid];
		$yhvar='bqdown';
		$yhid=$etable_r[$tbname][yhid];
	}
	elseif($enews==25)//�����������
	{
		$query.=' and ('.$where.')';
		$order='newstime';
		$yhvar='bqnew';
    }
	elseif($enews==26)//�������������
	{
		$query.=' and ('.$where.')';
		$order='onclick';
		$yhvar='bqhot';
    }
	elseif($enews==27)//��������Ƽ�
	{
		$query.=' and ('.$where.') and isgood>0';
		$order='newstime';
		$yhvar='bqgood';
    }
	elseif($enews==28)//���������������
	{
		$query.=' and ('.$where.')';
		$order='plnum';
		$yhvar='bqpl';
    }
	elseif($enews==29)//�������ͷ��
	{
		$query.=' and ('.$where.') and firsttitle>0';
		$order='newstime';
		$yhvar='bqfirst';
    }
	elseif($enews==30)//���������������
	{
		$query.=' and ('.$where.')';
		$order='totaldown';
		$yhvar='bqdown';
    }
	//�Ż�
	$yhadd='';
	if(!empty($eyh_r[$yhid]['dosbq']))
	{
		$yhadd=ReturnYhSql($yhid,$yhvar);
		if(!empty($yhadd))
		{
			$query.=' and '.$yhadd;
		}
	}
	//������
	if(!strstr($public_r['nottobq'],','.$classid.','))
	{
		$notbqwhere=ReturnNottoBqWhere();
		if(!empty($notbqwhere))
		{
			$query.=' and '.$notbqwhere;
		}
	}
	//ͼƬ��Ϣ
	if(!empty($do))
	{
		$query.=" and ispic=1";
    }
	//��������
	if(!empty($ewhere))
	{
		$query.=' and ('.$ewhere.')';
	}
	//��ֹ
	if(empty($tbname))
	{
		echo "ClassID=<b>".$classid."</b> Table not exists.(DoType=".$enews.")";
		return false;
	}
	//����
	$addorder=empty($eorder)?$order.' desc':$eorder;
	$query='select '.ReturnSqlListF($mid).' from '.$dbtbpre.'ecms_'.$tbname.$query.' order by '.$addorder.' limit '.$line;
	$sql=$empire->query1($query);
	if(!$sql)
	{
		echo"SQL Error: ".ReRepSqlTbpre($query);
	}
	return $sql;
}

//�鶯��ǩ������SQL���ݺ���
function espace_eloop($classid=0,$line=10,$enews=3,$doing=0,$ewhere='',$eorder=''){
	return espace_ReturnBqQuery($classid,$line,$enews,$doing,$ewhere,$eorder);
}

//�鶯��ǩ�������������ݺ���
function espace_eloop_sp($r){
	global $class_r;
	$sr['titleurl']=sys_ReturnBqTitleLink($r);
	$sr['classname']=$class_r[$r[classid]][bname]?$class_r[$r[classid]][bname]:$class_r[$r[classid]][classname];
	$sr['classurl']=sys_ReturnBqClassname($r,9);
	return $sr;
}
?>