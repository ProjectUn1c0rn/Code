<?php
namespace Un1c0rn\Web\Frontend;
class Search extends \Un1c0rn\Web\WebModule {
	function get() {
		global $config;
		$cacheKey = substr(sha1($_GET['q']),0,9);
		$this->cache304($cacheKey,3600);
		$this->setData('view','views/results.tpl');
		$_e = new \Un1c0rn\ElasticDb('pwn','hosts',$config['elasticsearch']['ip']);
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		if($page > 1 && $_SERVER['SERVER_NAME'] =='un1c0rn.net'){
			    $this->setData('view','views/results-fo.tpl');
					http_response_code(402);
					return $this->render();

		}
		$data = $_e->search($_GET['q'],$page);
		$data['total'] = $data['hits']['total'];
		$viewResults = array();
		$results = $data['hits']['hits'];
		foreach($results as $result) {
			if(!empty($result['highlight'])) {
				$result['_source']['highlight'] = isset($result['highlight']['data']) ? $result['highlight']['data'] : array();
				$result['_source']['hostname'] = isset($result['highlight']['hostname']) ? implode('...',$result['highlight']['hostname']) : $result['_source']['hostname'] ;
			}
			$viewResults[] = $result['_source'];
		}
		$data['Results'] = $viewResults;
		$data['term'] = htmlentities($_GET['q']);
		$data['page'] = $_GET['page'];
		$data['resultsPerPage'] = 5;
		$data['currentSearchUrl'] = '/search?q='.urlencode($_GET['q']);
		$data['page_title'] = 'Leaks matching "'.htmlentities($_GET['q']).'"';
		$this->templateData = array_merge($this->templateData,$data);
		$this->render();
	}
}
