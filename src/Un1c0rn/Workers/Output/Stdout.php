<?php
namespace Un1c0rn\Workers\Output;
class Stdout {
	static function output(\Un1c0rn\BaseExploit $exploit,$data) {
		echo $exploit->ip.' exploited :'.PHP_EOL;
		echo $data.PHP_EOL;
	}
}
