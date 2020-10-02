<?php
	//база данных
	$database = array(
		'pages' => array( 					                                           
			array(
				'url_key' => '/index.php', 										
				'title' => 'Главная страница - mydeal', 											
				'tpl' => 'layout.php', 
				'content' => 'main.php',     											
				'h1' => '',                  					
				'text' => ''                 
			),
			array(
				'url_key' => '/error.php', 										
				'title' => 'Ошибка - mydeal', 											
				'tpl' => 'layout.php', 
				'content' => 'error.php',     											
				'h1' => '',                  					
				'text' => ''                 
			),																		
			array(
				'url_key' => '/bytovka.php',
				'title' => '',
				'tpl' => '',
				'content' => '',
				'h1' => '',
				'text' => ''
			),
			array(
				'url_key' => '/catalog.php',
				'title' => '',
				'tpl' => '',
				'content' => '',
				'h1' => '',
				'text' => ''
			),
			array(
				'url_key' => '/contacts.php',
				'title' => '',
				'tpl' => '',
				'content' => '',
				'h1' => '',
				'text' => ''
			),
			array(
				'url_key' => '/add.php',
				'title' => 'Добавление задачи',
				'tpl' => 'layout.php',
				'content' => 'form.php',
				'h1' => '',
				'text' => ''
			)
		),
		'users' => array(
			array(
				'role' => 'admin', 										
				'name' => 'Алексей', 											
				'avatar' => '/img/my_photo.jpg',                  
			),																		
			array(
				'role' => 'guest', 										
				'name' => 'Аноним', 											
				'avatar' => '/img/no_photo.jpg',
			),	
		),

	);

	//категории проектов
	$projects_categories = array(
		'Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто',
	);

?>