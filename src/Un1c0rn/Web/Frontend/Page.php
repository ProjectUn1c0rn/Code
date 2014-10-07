<?php
namespace Un1c0rn\Web\Frontend;
class Page extends \Un1c0rn\Web\WebModule {
	function get($pageId) {
		global $config;
		$this->cache304($page,3600);
		$this->setData('view','views/page.tpl');
		$_e = new \Un1c0rn\ElasticDb('site','pages',$config['elasticsearch']['ip']);
		$page = $_e->load($pageId);
		if(!$page) {
			$this->templateData['title'] = '404 - Page not found';
			$this->templateData['content'] = htmlentities($page).' not found :O';
			header("HTTP/1.0 404 Not Found");

		}
		$this->templateData = array_merge($this->templateData,$page);
		$this->render();
	}
}
