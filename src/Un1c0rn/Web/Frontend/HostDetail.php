<?php
namespace Un1c0rn\Web\Frontend;
class HostDetail extends \Un1c0rn\Web\WebModule {
	function get($ip) {
		global $config;
		$this->setData('view','views/details.tpl');
		$_hostDb = new \Un1c0rn\ElasticDb('pwn','hosts',$config['elasticsearch']['ip']);
		$data = $_hostDb->load($ip);
		$this->templateData = array_merge($this->templateData,array(
			'host' => $data
		));
		$this->templateData['page_title'] = 'Leak history for '.$data['ip'];
		$this->render();
	}
}
