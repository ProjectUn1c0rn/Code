<?php
namespace Un1c0rn\Web;

class WebModule {
	var $filepath = null;
	var $template = null;
	var $config = null;
	var $templateData = array();
	var $templateGlobals = array();
	function __construct() {
		global $config;
		$this->config = $config;
		$this->setTemplate($config['web']['template']);
	}	
	function setData($key,$data) {
		$this->templateData[$key] = $data;
	}
	function setTemplate($template) {
		$this->filepath = 'templates'.DIRECTORY_SEPARATOR.$template.DIRECTORY_SEPARATOR.'index.tpl';
		$this->template = $template;
		if(!file_exists($this->filepath)) throw new \Exception('Template '.$template.' not found',500);
	}

	function render() {
		$template = new TemplateEngine($this->filepath);
		$template->set($this->templateData);
		$template->setGlobals($this->templateGlobals);
		$template->display();
		if(isset($_GET['DEBUG'])) {
			echo '<pre>';
			var_dump($this->templateData);
			echo '</pre>';
		}
	}
	static function returnError($e) {
		$template = new \Blitz();
		$template->load(<<<BODY
<html>
	<head>
		<title>Error {{ \$ErrorNum }}</title>
	</head>
	<body>
		<h3>{{ \$ErrorTitle }}</h3>
		<pre>{{ \$ErrorMessage }}</pre>
	</body>
</html>
BODY
);
		$template->display(array(
			'ErrorNum' => $e->getCode(),
			'ErrorTitle' => $e->getLine().' : '.$e->getFile(),
			'ErrorMessage' => $e->getMessage().PHP_EOL.$e->getTraceAsString()
		));
	}
	function cache304($tag=null,$time=60) {
		$timeOffset = ((floor(time()/$time))*$time);
		$tag = is_null($tag) ? substr(sha1($tag),0,6).'-'.$timeOffset : $tag.'-'.$timeOffset;
		//get the HTTP_IF_MODIFIED_SINCE header if set
		$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : false);
		//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
		$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
		header('Etag: '.$tag);
		header('Cache-Control: public');
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $timeOffset)." GMT");
		header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', $timeOffset + $time));
		if($etagHeader == $tag||$ifModifiedSince == $timeOffset) {
			header("HTTP/1.1 304 Not Modified");
      			die();
		}
		return false;
	}
}
