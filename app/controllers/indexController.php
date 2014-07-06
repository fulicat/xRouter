<?php
/**
 * 
 * @authors Jack Chan (fulicat@qq.com)
 * @date    2014-06-26 00:10:46
 * @version $Id$
 */
class indexController extends xRouter{


	function indexAction(){
		$hash["title"] = "首页";
		//echo "<h3>hello world.</h3>";
		$this->display($hash);
	}

	function listAction(){
		$hash["title"] = "列表页";
		echo "<h3>list view</h3>";
	}

}