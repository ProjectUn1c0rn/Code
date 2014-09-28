<?php
namespace Un1c0rn\Workers\Output;
class ElasticUn1c0rn {
	static function output(\Un1c0rn\BaseExploit $exploit,$data) {
		$db = new \Un1c0rn\ElasticDb('pwn','hosts');
		$host = $db->load($exploit->ip);
		$insert = ($host === false) ? true : false;
		$db->save($exploit->ip,array(
			'ip'=> $exploit->ip,
			'updated' => time()
		));
		$db->addData($exploit->ip,'leaks',array(
			'port' => $exploit->port,
			'date' => time(),
			'data'=>$data,
			'type'=> $exploit->getTag()
		));
		$db->addData($exploit->ip,'tags',$exploit->getTag());
	}
}
