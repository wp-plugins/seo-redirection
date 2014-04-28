<?php
/*
Author: Fakhri Alsadi
Date: 16-7-2010
Contact: www.clogica.com   info@clogica.com    mobile: +972599322252
*/

if(!class_exists('clogica_util')){
class clogica_util{

var $option_group_name='clogica_option_group';
var $plugin_folder='plugin_folder_name'; 


	public function get($key,$escape=0)
{
	if(array_key_exists($key,$_GET))
	{
	   if($escape)
	   {
	      return mysql_real_escape_string($_GET[$key]); 
	   }else
	   {
	     return $_GET[$key];  
	   }
	}
	else
	{
	    return '';
	}
}

//---------------------------------------------------- 

public function post($key,$escape=0)
{
	if(array_key_exists($key,$_POST))
	{
	   if($escape)
	   {
	      return mysql_real_escape_string($_POST[$key]); 
	   }else
	   {
	     return $_POST[$key];  
	   }
	}
	else
	{
	    return '';
	}
}

//----------------------------------------------------
	
function set_option_gruop($option_group_name)
{
	$this->option_group_name=$option_group_name;
}

//---------------------------------------------------- 

function get_option_gruop()
{
	return $this->option_group_name;
}

//----------------------------------------------------

function set_plugin_folder($folder)
{
	$this->plugin_folder=$folder;
}


//----------------------------------------------------

function get_plugin_folder()
{
	return $this->plugin_folder;
}

//---------------------------------------------------- 


function update_my_options($options)
{	
	update_option($this->get_option_gruop(),$options);
}

//---------------------------------------------------- 

function get_my_options()
{	
	$options=get_option($this->get_option_gruop());
	if(!is_array($options))
	{
		add_option($this->get_option_gruop());
		$options= array();
	}
	return $options;
}

//---------------------------------------------------

function get_option_value($key)
{
	$options=$this->get_my_options();
	return $options[$key];	
}
//---------------------------------------------------- 


function update_option($key,$value)
{	
	$options=$this->get_my_options();
	$options[$key]=$value;
	$this->update_my_options($options);
}


//---------------------------------------------------- 


function update_post_option($key)
{	
	$options=$this->get_my_options();
	$options[$key]=intval($_POST[$key]);
	$this->update_my_options($options);				
}


//---------------------------------------------------- 


function delete_my_options()
{	
    delete_option($this->get_option_gruop());
}


//----------------------------------------------------

function get_current_URL()
{
	$prt = $_SERVER['SERVER_PORT'];
	$sname = $_SERVER['SERVER_NAME'];
	
	$sname = "http://" . $sname; 
	
	if($prt !=80)
	{
	$sname = $sname . ":" . $prt;
	} 
	
	$path = $sname . $_SERVER["REQUEST_URI"];
	
	return $path ;

}


//----------------------------------------------------


public function get_current_parameters($remove_parameter="")
{	
	
	if($_SERVER['QUERY_STRING']!='')
	{
		$qry = '?' . $_SERVER['QUERY_STRING']; 
		
		if(is_array($remove_parameter))
		{
			for($i=0;$i<count($remove_parameter);$i++)
			{
			
				if(array_key_exists($remove_parameter[$i],$_GET)){
    				$string_remove = '&' . $remove_parameter[$i] . "=" . $_GET[$remove_parameter[$i]];
    				$qry=str_replace($string_remove,"",$qry);
    				$string_remove = '?' . $remove_parameter[$i] . "=" . $_GET[$remove_parameter[$i]];
    				$qry=str_replace($string_remove,"",$qry);
				}
			}
			
		}else{		
			if($remove_parameter!='')
			{
				if(array_key_exists($remove_parameter,$_GET)){
				    $string_remove = '&' . $remove_parameter . "=" . $_GET[$remove_parameter];
				    $qry=str_replace($string_remove,"",$qry);
				    $string_remove = '?' . $remove_parameter . "=" . $_GET[$remove_parameter];
				    $qry=str_replace($string_remove,"",$qry);
				}
			}
		}
		return $qry;
	}else
	{
		return "";
	}
} 



//---------------------------------------------------------------

	function get_plugin_path($folder='')
	{
		return WP_PLUGIN_DIR . '/' .  $this->get_plugin_folder() . '/' . $folder;
	}
	
//-----------------------------------------------------


function get_plugin_url($url='')
{
	return WP_PLUGIN_URL  . '/' .  $this->get_plugin_folder() . '/' . $url;
}


//----------------------------------------------------

function get_visitor_IP()
{
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	
	return $ipaddress ;
}

//----------------------------------------------------


function get_visitor_OS()
{

$userAgent= $_SERVER['HTTP_USER_AGENT'];
		$oses = array (
		'iPhone' => '(iPhone)',
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', 
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows 8' => '(Windows NT 6.2)|(Windows 8)',
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => 'Windows ME',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'SunOS',
		//'Linux'=>'(Linux)|(X11)', to detect if android or not
		'Safari' => '(Safari)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
		'QNX'=>'QNX',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'SearchBot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);

	foreach($oses as $os=>$pattern){ 

		if(eregi($pattern, $userAgent)) { 
			return $os; 
		}
	}
	
	// more tests
	
	$ua = strtolower($userAgent);
	
	if(stripos($ua,'android') !== false) { 
	    return 'Android';
	}
	
	if(stripos($ua,'iphone') !== false) {
	    return 'iOS';
	}
	

	if(stripos($ua,'ipad') !== false) {
	    return 'iOS';
	}
	
	if(stripos($ua,'ipod') !== false) {
	    return 'iOS';
	}
	
	if(stripos($ua,'windows') !== false) {
	    return 'Windows';
	}
	
	
	if(stripos($ua,'linux') !== false) {
	    return 'Linux';
	}
	
	
	if(stripos($ua,'googlebot') !== false) {
	    return 'Googlebot';
	}
	
	if(stripos($ua,'bot') !== false) {
	    return 'SearchBot';
	}
			
	
	return 'Unknown';
}

//-----------------------------------------------------------------

function get_visitor_Browser()
{

$u_agent= $_SERVER['HTTP_USER_AGENT'];
$bname = 'Unknown';

if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Firefox';
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Chrome';
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Safari';
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
    }
    elseif(preg_match('/googlebot/i',$u_agent))
    {
        $bname = 'GoogleBot';
    }
    elseif(preg_match('/bot/i',$u_agent))
    {
        $bname = 'SearchBot';
    }
    
    
 return $bname;    
    
}

//----------------------------------------------------

function get_visitor_country()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $result  = "Unknown";
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    if($ip_data && $ip_data->geoplugin_countryName != null)
    {
        $result = $ip_data->geoplugin_countryName;
    }

    return $result;
}

//---------------------------------------------------- 

function option_msg($msg)
{	
	echo '<div id="message" class="updated"><p>' . $msg . '</p></div>';		
}

//---------------------------------------------------- 


function info_option_msg($msg)
{	
	echo '<div id="message" class="updated"><p><div class="info_icon"></div> ' . $msg . '</p></div>';		
}

//---------------------------------------------------- 


function warning_option_msg($msg) 
{	
	echo '<div id="message" class="error"><p><div class="warning_icon"></div> ' . $msg . '</p></div>';		
}

//---------------------------------------------------- 

function success_option_msg($msg)
{	
	echo '<div id="message" class="updated"><p><div class="success_icon"></div> ' . $msg . '</p></div>';		
}

//---------------------------------------------------- 

function failure_option_msg($msg)
{	
	echo '<div id="message" class="error"><p><div class="failure_icon"></div> ' . $msg . '</p></div>';		
}


//---------------------------------------------------- 


function there_is_cache()
{	

$plugins=get_option( 'active_plugins' );

		    for($i=0;$i<count($plugins);$i++)
		    {   
		       if (stripos($plugins[$i],'cache')!==false)
		       {
		       	  return $plugins[$i];
		       }
		    }


	return '';				
}
	
//---------------------------------------------------------------
		
function regex_prepare($string)
{

 $from= array('.', '+', '*', '?','[','^',']','$','(',')','{','}','=','!','<','>','|',':','-',')','/', '\\');
 $to= array('\\.', '\\+', '\\*', '\\?','\\[','\\^','\\]','\\$','\\(','\\)','\\{','\\}','\\=','\\!','\\<','\\>','\\|','\\:','\\-','\\)','\\/','\\\\');
 return str_replace($from,$to,$string);
 
}
	
 
}}
     
?>