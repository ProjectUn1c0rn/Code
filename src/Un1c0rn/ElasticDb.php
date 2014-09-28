<?php
namespace Un1c0rn;
class ElasticDb {
	var $index = null;
	var $type = null;
	var $baseUrl = null;
	var $resultsCount = 5;
	function __construct($index,$type,$host='127.0.0.1',$port=9200) {
		$this->index = $index;
		$this->type = $type;
		$this->baseUrl = 'http://'.$host.':'.$port.'/'.$this->index.'/'.$this->type;
	}

	function save($id,$data) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/'.$id.'/_update' );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		$toSend =  array('doc'=> $data,'doc_as_upsert'=>true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($toSend));
		$content = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($content,true);
		return $data;
	}
	function addData($id,$field,$data) {
		$object = $this->load($id);
		if(!$object) return false;
		if(!isset($object[$field])) $object[$field] = array();
		if(in_array($data,$object[$field])) return false;
		$object[$field][] = $data;
		return $this->save($id,$object);
	}

	function delete($id) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/'.$id );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		$content = curl_exec($ch);
		curl_close($ch);
		return json_decode($content);
	}
	function getFacets($field) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/_search');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode(
			array('query'=>array('match_all'=>array()),'facets'=>array('facets'=>array('terms'=>array('field'=>$field,'size'=>10))))
	  ));
	$content = curl_exec($ch);
	curl_close($ch);
	return json_decode($content,true)['facets']['facets']['terms'];
  }
	function load($id) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/'.$id );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($ch);
		curl_close($ch);
		$data = (array) json_decode($content,true);
		if(!isset($data['_source'])) return false;
		return $data['_source'];
	}
	function search($query,$page=1,$field='data') {
		$ch = curl_init();

		if(empty($query)) $query ='*';
		$from = $this->resultsCount * ($page-1);
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/_search?q='.urlencode($query)."&size=".$this->resultsCount."&from=".$from);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode(
			array('sort' => array('updated' => 'desc'), 'highlight' =>
				array('encoder'=>'html','fields'=>
					array(
						$field =>
							array(
								"fragment_size" => 200, "number_of_fragments" => 3,
								"pre_tags"=>array('<span class="highlight">'), 'post_tags'=>array('</span>')
							),
							'hostname' =>
							array(
								"fragment_size" => 200, "number_of_fragments" => 3,
								"pre_tags"=>array('<span class="highlight">'), 'post_tags'=>array('</span>')
							)
					)
				)
			)
		));
		$content = curl_exec($ch);
		curl_close($ch);
		$data = (array) json_decode($content,true);
		if(!isset($data['hits']['hits'])) return false;
		return $data;
		}
	}
