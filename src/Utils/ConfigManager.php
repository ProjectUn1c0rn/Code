<?php
namespace Utils;
class ConfigManager {

  var $config = array();

  function __construct($file) {
      $this->config = parse_ini_file($file);
  }

  function getConfig($category,$key) {
    return $this->config[$category][$key];
  }

  function setConfig($category,$key,$value) {
    $this->config[$category][$key] = $value;
  }

  function deleteConfig($category,$key=null) {
    if(is_null($key)) return unset($this->config[$category]);
    return unset($this->config[$category][$key]);
  }

  function saveConfig($file) {
    return file_put_contents($file,$this->arr2ini($this->config));
  }
  // http://stackoverflow.com/questions/17316873/php-array-to-a-ini-file
  // thanks rr-
  function arr2ini(array $a, array $parent = array()) {
    $out = '';
    foreach ($a as $k => $v)
    {
      if (is_array($v))
      {
        //subsection case
        //merge all the sections into one array...
        $sec = array_merge((array) $parent, (array) $k);
        //add section information to the output
        $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
        //recursively traverse deeper
        $out .= $this->arr2ini($v, $sec);
      }
      else
      {
        //plain key->value case
        $out .= "$k=$v" . PHP_EOL;
      }
    }
    return $out;
  }
}
