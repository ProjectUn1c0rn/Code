<?php
namespace Un1c0rn;
class Cli {
	var $class = null;
	var $function = null;
	var $options = null;
	const SHORT_OPTS = 'c:f:';
	function __construct($namespace) {
		$opts = getopt(self::SHORT_OPTS);
		$this->class = isset($opts['c']) ? $opts['c'] : null;
		$this->function = isset($opts['f']) ? $opts['f'] : null;
		$this->class = $namespace.'\\'.str_replace('.','\\',$this->class);
		if(!class_exists($this->class)) throw new \Exception($this->class.' not found');
		$required = array_keys(get_class_vars($this->class));
		$longOpts = array();
		foreach($required as $req) {
			$longOpts[] = $req.':';
		}
		$this->options = getopt(self::SHORT_OPTS,$longOpts);
	}

	function run() {
		$module = new $this->class($this->options);
		return call_user_func(array($module,$this->function));
	}
}
