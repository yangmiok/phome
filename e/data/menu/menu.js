// JavaScript Document
function chengstate(menuid,save)
{											//�л��ڵ�Ŀ���/�ر�
	menuobj	= eval("item"+menuid);
	obj		= eval("pr"+menuid);
	
	if(menuobj.style.display == '')
	{
		menuobj.style.display	= 'none';
	}else{
		menuobj.style.display	= '';
	}//end if
	switch (obj.className)
	{
		case "menu1":
			obj.className	= "menu2";
			break;
		case "menu2":
			obj.className	= "menu1";
			break;
		case "menu3":
			obj.className	= "menu4";
			break;
		case "menu4":
			obj.className	= "menu3";
			break;
	}//end switch
	if(save!=false)
	{
		setupcookie(menuid);			//����״̬
	}//end if
}//end funciton chengstaut

function setupcookie(menuid)
{										//����cookie  ����ڵ�״̬
	var menu	= new Array();
	var menustr	= new String();
	menuOpen	= false;
	if(checkCookieExist("menu"))
	{									//�ж��Ƿ����Ƿ��Ѿ������cookie
		menustr		= getCookie("menu");
		//alert(menustr);
		if(menustr.length>0)
		{								//�ж�menu�Ƿ�Ϊ�գ���������ֽ�Ϊ����
			menu	= menustr.split(",");
			for(i=0;i<menu.length;i++)
			{
				if(menu[i]==menuid)
				{						//����Ǵ�״̬������ɾ����¼
					menu[i]='';
					menuOpen	= true;
				}//end if
			}//end for
			if(menuOpen==false)menu[i] = menuid;
		}else{
			menu[0]	= menuid;
		}//end if
	}else{
		menu[0]	= menuid;
	}//end if
	menustr	= menu.join(",");
	menustr	= menustr.replace(",,",",");
	if(menustr.substr(menustr.length-1,1)==',')menustr = menustr.substr(0,menustr.length-1);		//ȥ������ ","
	if(menustr.substr(0,1)==',')menustr = menustr.substr(1,menustr.length-1);		//ȥ����ʼ�� ","
	saveCookie("menu",menustr,1000);
	//alert(menustr);
	//deleteCookie("menu");
}//end function setupcookie

function initialize()
{											//ȡ��cookie  ���ýڵ������,,��ʼ���˵�״̬
	var menu	= new Array();
	var menustr	= new String();
	
	if(checkCookieExist("menu"))
	{									//�ж��Ƿ����Ƿ��Ѿ������cookie
		menustr		= getCookie("menu");
		if(menustr.length>0)
		{								//�жϳ����Ƿ�Ϸ�
			menu	= menustr.split(",");
			for(i=0;i<menu.length;i++)
			{
				if(objExists(menu[i]))			
				{						//��֤�����Ƿ����
					chengstate(menu[i],false);
				}//end if
			}//end for
			objExists(99);
		}//end if
	}//end if
}//end funciton setupstate

function objExists(objid)
{											//��֤�����Ƿ����
	try
	{
		obj = eval("item"+objid);
	}//end try
	catch(obj)
	{
		return false;
	}//end catch
	
	if(typeof(obj)=="object")
	{
		return true;
	}//end if
	return false;
}//end function objExists
//--------------------------------------------------������������������������  ִ��Cookie ����
function saveCookie(name, value, expires, path, domain, secure)
{											// ����Cookie
  var strCookie = name + "=" + value;
  if (expires)
  {											// ����Cookie������, ����Ϊ����
     var curTime = new Date();
     curTime.setTime(curTime.getTime() + expires*24*60*60*1000);
     strCookie += "; expires=" + curTime.toGMTString();
  }//end if
  // Cookie��·��
  strCookie +=  (path) ? "; path=" + path : ""; 
  // Cookie��Domain
  strCookie +=  (domain) ? "; domain=" + domain : "";
  // �Ƿ���Ҫ���ܴ���,Ϊһ������ֵ
  strCookie +=  (secure) ? "; secure" : "";
  document.cookie = strCookie;
}//end funciton saveCookie

function getCookie(name)
{											// ʹ�����Ʋ���ȡ��Cookieֵ, null��ʾCookie������
  var strCookies = document.cookie;
  var cookieName = name + "=";  // Cookie����
  var valueBegin, valueEnd, value;
  // Ѱ���Ƿ��д�Cookie����
  valueBegin = strCookies.indexOf(cookieName);
  if (valueBegin == -1) return null;  // û�д�Cookie
  // ȡ��ֵ�Ľ�βλ��
  valueEnd = strCookies.indexOf(";", valueBegin);
  if (valueEnd == -1)
      valueEnd = strCookies.length;  // ����һ��Cookie
  // ȡ��Cookieֵ
  value = strCookies.substring(valueBegin+cookieName.length,valueEnd);
  return value;
}//end function getCookie

function checkCookieExist(name)
{											// ���Cookie�Ƿ����
  if (getCookie(name))
      return true;
  else
      return false;
}//end function checkCookieExist

function deleteCookie(name, path, domain)
{											// ɾ��Cookie
  var strCookie;
  // ���Cookie�Ƿ����
  if (checkCookieExist(name))
  {										    // ����Cookie������Ϊ������
    strCookie = name + "="; 
    strCookie += (path) ? "; path=" + path : "";
    strCookie += (domain) ? "; domain=" + domain : "";
    strCookie += "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    document.cookie = strCookie;
  }//end if
}//end function deleteCookie