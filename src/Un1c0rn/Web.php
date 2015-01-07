<?php
namespace Un1c0rn;
class WebModule {
	function __construct() {
		//Temporary, setting default template :
		$this->setTemplate('un1c0rn');
	}
	function setTemplate($template) {
		$this->template = 'templates/'.$template.'/index.tpl';
	}
}
