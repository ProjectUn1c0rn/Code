<?php
namespace Un1c0rn\Web\Frontend;
class Home extends \Un1c0rn\Web\WebModule {
	function get() {
		$this->cache304('home',3600);
		$this->setData('view','views/home.tpl');
		$this->render();
	}
}
