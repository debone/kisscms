<?php
namespace jstest;

function main(){
	global $r;

	$output['js'] = "console.log('Jstest')";

	$output['html'] = $r['recursion'];

	return $output;
}