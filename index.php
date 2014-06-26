<?php
/**
 * 
 * @authors Jack.Chan (fulicat@qq.com)
 * @date    2014-06-25 12:07:33
 * @version 1.0
 */
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");


class xRouter{

	public $pool = "app/";
	public $var = array();
	private $route = array(
		"uri" => "",
		"upath" => "",
		"params" => "",
		"controller" => "index",
		"model" => "index",
		"view" => "index",
		"pool" => "",
		"app" => "",
		"path" => ""
	);
	function __construct(){
		$this->route["uri"] = $_SERVER["REQUEST_URI"];
		$this->route["upath"] = $this->route["uri"];
		$this->route["pool"] = $this->pool;
		if(strpos($this->route["uri"], "?")!==false){
			$tmpArr = explode("?", $this->route["uri"]);
			$this->route["upath"] = $tmpArr[0];
			$this->route["params"] = $tmpArr[1];
		}
		if(strpos($this->route["upath"], "/")!==false){
			$pathArr = explode("/", $this->route["upath"]);
			$pathArr = array_filter($pathArr);
			$pathSize = count($pathArr);
			if($pathSize > 3){
				$this->route["controller"] = $pathArr[$pathSize-2];
				$this->route["model"] = $pathArr[$pathSize-1];
				$this->route["view"] = $pathArr[$pathSize];
				$this->route["path"] = join("/", array_slice($pathArr, 0, -3));
				$this->route["path"] = (($this->route["path"]) ? $this->route["path"]."/" : $this->route["path"]);
			}else{
				if($pathSize > 0){
					$this->route["controller"] = $pathArr[1];
					if($pathSize>1)$this->route["model"] = $pathArr[2];
					if($pathSize>2)$this->route["view"] = $pathArr[3];
				}
			}
		}
		if(is_numeric($this->route["view"])){
			$this->route["id"] = $this->route["view"];
			$this->route["view"] = $this->route["model"];
		}
		$this->route["_controller"] = $this->route["controller"]."Controller";
		$this->route["_model"] = $this->route["model"]."Action";
		$this->route["_view"] = $this->route["view"];
		$this->route["_controller_file"] = $this->route["pool"].$this->route["path"]."controllers/".$this->route["_controller"].".php";
		$this->route["_view_file"] = $this->route["pool"].$this->route["path"]."views/".$this->route["view"].".tpl";

		if(!file_exists($this->route["_controller_file"])){
			echo "<h2>_controller not found.</h2>";
			$this->route["model"] = $this->route["controller"];
			$this->route["controller"] = "index";
			$this->route["view"] = $this->route["model"];
			$this->route["_controller"] = $this->route["controller"]."Controller";
			$this->route["_model"] = $this->route["model"]."Action";
			$this->route["_view"] = $this->route["view"];
			$this->route["_controller_file"] = $this->route["pool"].$this->route["path"]."controllers/".$this->route["_controller"].".php";
			$this->route["_view_file"] = $this->route["pool"].$this->route["path"]."views/".$this->route["view"].".tpl";
			/*
			$_model = $_controller;
			$_controller = "index";
			$controller = $_controller."Controller";
			$controller_file = $this->path."controllers/".$controller.".php";
			*/
		};
		if(file_exists($this->route["_controller_file"])){
			echo "<h2>_controller found.</h2>";
			//exit;
		}else{
			/*
			require_once($this->route["_controller"]);
			$xController = new $controller();
			if(method_exists($xController, $model)){

			};
			*/
		}
	}

	public function assign($variable, $value=null){ 
		$this->var[$variable] = $value;
	}

	public function display($hash="", $view=""){

	}

	public function run(){

		$files = array(
			"controller" => $this->route["controller"],
			"model" => "index",
			"view" => "index",
		);



		echo "<pre>";
		
		//print_r($pathArr);
		echo "<br>";
		echo "<br>";
		print_r($this->route);
		//print_r($this->urlArr);

		echo "<br>";
		echo "<br>";
		//echo $this->uri;
		echo "</pre>";
		//echo "hello world";
	}
	
}

$x = new xRouter();
$x->run();


