<?php
namespace Un1c0rn\Web\Frontend;
class HostDetail extends WebModule {
	function get($ip) {
		$this->setData('view','views/details.tpl');
		$_hostDb = new \Un1c0rn\ElasticDb('pwn','hosts');
		$data = $_hostDb->load($ip);
		$this->templateData = array_merge($this->templateData,array(
			'host' => $data
		));
		$this->templateData['page_title'] = 'Leak history for '.$data['ip'];
		$this->render();
	}
}
