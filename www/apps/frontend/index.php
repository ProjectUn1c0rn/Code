<?php
if($_SERVER['SERVER_NAME'] == 'www.un1c0rn.net') {
	header('Location: http://un1c0rn.net');
	die();
}

require('/srv/un1c0rn/bootstrap.php');
//redirect for old website
if(isset($_GET['module'])) {
	$path='/';
	if($_GET['module'] =='hosts') {
		if($_GET['action'] == 'detail') {
			$path = '/host/'.$_GET['ip'];
		} elseif($_GET['action'] == 'list') {
			$path = '/search?q='.urlencode($_GET['filter']);
		}
	}
	header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$path);
}

try {
	Toro::serve(array(
    "/" => "\\Un1c0rn\\Web\\Frontend\\Home",
		"/search" => "\\Un1c0rn\\Web\\Frontend\\Search",
		"/host/(.*)" => "\\Un1c0rn\\Web\\Frontend\\HostDetail",
		"/stats" => "\\Un1c0rn\\Web\\Frontend\\Stats",
		"/(.*)" => "\\Un1c0rn\\Web\\Frontend\\Page"
	));
} catch (\Exception $e) {
	\Un1c0rn\Web\WebModule::returnError($e);
}
