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

	var $vars;
	public $debug = false;
	public $pool = "app/";
	public $route = array(
		"pool" => "",
		"app" => "",
		"path" => "",
		"uri" => "",
		"upath" => "",
		"params" => "",
		"controller" => "index",
		"model" => "index",
		"view" => "index"
		
	);
	function __construct(){
		$this->debug = (isset($_GET["debug"]) && !empty($_GET["debug"])) ? trim($_GET["debug"]) : false;
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
			if($pathSize > 0){
				$tmp = "";
				$i = 0;
				foreach($pathArr as $item){
					$tmp = ($tmp)? $tmp."/".$item : $item;
					if(is_dir($this->route["pool"].$tmp)){
						$this->route["path"] = $tmp;
						$i++;
					}
				}
				$this->route["path"] = $this->route["path"] ? $this->route["path"]."/" : "";
				$pathArr = array_slice($pathArr, $i);
				if(count($pathArr))$this->route["controller"] = array_shift($pathArr);
				if(count($pathArr))$this->route["model"] = array_shift($pathArr);
			}

		}
		//$this->route["view_file"] = $this->route["model"];
		$this->route["controller_file"] = $this->route["pool"].$this->route["path"]."controllers/".$this->route["controller"]."Controller.php";
	}

	public function assign($variable, $value=null){ 
		$this->vars[$variable] = $value;
	}
	private function hasAction($action){
		return (array_search($action, get_class_methods($this)) > -1);
	}
	public function display($hash, $view=""){
		if($view=="")$view = $this->route["view"];
		if($this->hasAction($view."Action")){
			$this->route["view"] = ($view == "index") ? (($this->route["controller"] == $view) ? $view : $this->route["controller"]) : $this->route["controller"].".".$view;
			$view = $this->route["pool"].$this->route["path"]."views/".$this->route["view"].".html";
		};
		if(file_exists($view)){
			//@extract([$this]);
			include_once($view);
		}else{
			echo $view;
			echo "<p>tpl not found.</p>";
		}
	}
	public function test(){
		return "hi";
	}
	public function run(){
		if($this->debug){
			echo "<pre>";
			print_r($this->route);
			echo "</pre>";
		}
		//echo "hello world";
		if(file_exists($this->route["controller_file"])){
			//echo "<h2>Controller found.</h2>";
			require_once($this->route["controller_file"]);
			$tmpController = $this->route["controller"]."Controller";
			$tmpController = new $tmpController();
			if(method_exists($tmpController, $this->route["model"]."Action")){
				$tmpController->{$this->route["model"]."Action"}();
				//echo("Model found.");
			}else{
				die("Model not found.");
			}
		}else{
			die("Controller not found.");
		}


	}
	
}

$x = new xRouter();
$x->run();


