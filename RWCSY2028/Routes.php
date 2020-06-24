<?php
namespace RWCSY2028;
//interface class for use with entry point class
interface Routes {
	//return routes array
	public function getRoutes();

	//create any required layout vars
	public function getLayoutVariables();

	//login validation for each page
	public function checkLogin($route);

	//reroute for unaccessible pages
	public function getReroute();
}