<?php
	/*
		Сайт уже обновился, поэтому такая версия работать не будет
	*/

	include_once('lib/SQL.php');
	include_once('lib/curl_query.php');
	include_once('lib/simple_html_dom.php');

	//$sql = SQL::Instance();
	
	$html = curl_get('http://ntschool.ru/courses');
	$dom = str_get_html($html);
	
	$courses = $dom->find('.one_title');
	
	
	foreach($courses as $course){
		$tobd = array('id_school' => 1);
		
		$a = $course->find('a', 0);	
		$tobd['name'] = $a->plaintext;
		
		$one = curl_get('http://ntschool.ru' . $a->href);		
		$one_dom = str_get_html($one);
		
		$cost = $one_dom->find('.cost', 0);
		$tobd['cost'] = (int)$cost->plaintext;
		$sql->Insert('courses', $tobd);
	}
	
