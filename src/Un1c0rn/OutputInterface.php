<?php
namespace Un1c0rn;
interface OutputInterface {

	/* return unique tagname */
	public function output(\Un1c0rn\BaseExploit $exploit,$data);
}
