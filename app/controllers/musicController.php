<?php
/**
 * 
 * @authors Jack Chan (fulicat@qq.com)
 * @date    2014-06-26 00:10:46
 * @version $Id$
 */
class musicController extends xRouter{

	function __construct(){

	}

	function indexAction(){
		$hash["title"] = "音乐首页";
		//$this->display($hash);
		echo "<h3>hello music.</h3>";
	}

	function listAction(){
		$hash["title"] = "列表页";
		echo "<h3>list view</h3>";
	}

	function detaiAction(){
		$hash["title"] = "详情页";
		echo "<h3>detail view</h3>";
	}

}