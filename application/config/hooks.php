<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// $hook['display_override'][] = array(
// 	'class' => '',
// 	'function' => 'compress',
// 	'filename' => 'compress.php',
// 	'filepath' => 'hooks'
// );

//hook for enable/disable profiling
// $hook['post_controller_constructor'][] = array(
// 	'class'    => 'ProfilerEnabler',
// 	'function' => 'enableProfiler',
// 	'filename' => 'hooks.profiler.php',
// 	'filepath' => 'hooks',
// 	'params'   => array()
// );

// $hook['post_controller'][] = array(
// 	'class' 	=> '',
// 	'function' 	=> 'is_logged_in',
// 	'filename'	=> 'security.php',
// 	'filepath' 	=> 'hooks'
// );

$hook['post_controller_constructor'][] = array(
    "class"    => "Check_session",// any name of class that you want
    "function" => "validate",// a method of class
    "filename" => "Check_session.php",// where the class declared
    "filepath" => "hooks"// this is location inside application folder
);