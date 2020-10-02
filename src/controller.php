<?php
	
	//валидация формы создания задачи
	if(isset($_POST)){
		
		//проверка отправки формы
		if(isset($_POST['addtask'])){ 
			extract($_POST);

			//массив с ошибками
			$err_form = [];
			//путь к файлу по умолчанию
			$file_path = '';
			//массив с введенными значениями
			foreach($_POST as $k => $v){
				$val_form[$k] = $v;
			}

			//проверка имени
			if(!$name || $name == ''){
				$err_form['name'] = 'Имя не заполнено';
			}
			
			//проверка проекта
			if(!$project || $project == ''){
				$err_form['project'] = 'Проект не выбран';
			} else if(!$arr_projects[$project]){
				$err_form['project'] = 'Проект задан некорректно';
			}
			
			//проверка даты
			if(!is_date_valid($date)){
				$err_form['date'] = 'Дата задана некорректно';
			}

			//проверяем наполненность массива с ошибками, если все корректно, сохраняем задачу в базе
			if(count($err_form) == 0){
			
				//перемещаем файл	
				if(mb_strlen($_FILES['file']['name']) > 0){
					$uploaddir = PATH_ROOT.'/uploads/';
					$uploadfile = $uploaddir . basename($_FILES['file']['name']);

					//die(var_dump($uploadfile));
					$file_path = '/uploads/'.basename($_FILES['file']['name']);

					if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
						$err_form['file'] = "Произошла ошибка при загрузке файла";
					}
				}

				//функция для создания задачи в базе
				if(create_task($name, 0, $date, $file_path, 1, $project)){
					header("HTTP/1.1 301 Moved Permanently"); 
					header("Location: /"); 
					exit();
				} else {
					$val_form['status'] = "Ошибка при создании задачи";
				}
				
			} else {
				$err_form['text'] = "В форме есть ошибки";
			}
		}
		// проверка доступов к папке
		// $fileperms = substr ( decoct ( fileperms ( $uploaddir ) ), 2, 6 );
		// if ( strlen ( $fileperms ) == '3' ){ $fileperms = '0' . $fileperms; }
		// print "Права доступа к каталогу <b>".$uploaddir."</b>: " . $fileperms . "<br>\n";
	}
	

	$uri = $_SERVER['SCRIPT_NAME'];
	
	//инициализация
	if($database){																		
		foreach ($database['pages'] as $value) {										
			if($value['url_key'] == $uri){
				//проверка на несуществующий гет show
				if($project_show && !isset($arr_projects[$project_show])){
					header("HTTP/1.0 404 Not Found");
					include_templates('/error.php', $database, $projects_categories, $tasks, $arr_projects, $arr_tasks, $var_compact, $project_show, $err_form, $val_form);
					exit;
				}	
				include_templates($value['url_key'], $database, $projects_categories, $tasks, $arr_projects, $arr_tasks, $var_compact, $project_show, $err_form, $val_form);								
			}
		}												
	} else {																			
		die('Невозможно подключиться к базе данных');									
	}

	//функция для вывода шаблона текущей страницы
	function include_templates($url_key, &$database, $projects_categories, $tasks, $arr_projects, $arr_tasks, $var_compact, $project_show, $err_form, $val_form){	
		$data = searchData($database, $url_key);
		if(!empty($data) && file_exists(PATH_TPL.$data['tpl'])){
			
			ob_start();
			
			if($data['title'] && $data['title'] != ''){
				$title = $data['title'];
			}
			if($data['h1'] && $data['h1'] != ''){
				$h1 = $data['h1'];
			}
			if($data['content'] && $data['content'] != ''){
				$page_content = $data['content'];
			}
			if($data['text'] && $data['text'] != ''){
				$seo_text = $data['text'];
			}

			$var_extract = extract($var_compact);

			require(PATH_TPL.$data['tpl']);
			
			$result = ob_get_clean();
			
			echo $result;
			
		} else {
			die('Для такой страницы нет данных');
		}
	}

	//считаем задачи в проекте
	function countProjects($tasks = array(),$projects_categories){
		$i=0;
		foreach ($tasks as $key => $value) {
			if($value['category'] == $projects_categories){
				echo $projects_categories;
				$i++; 
			}
		}
		return $i;
	}

	//валидация формата даты
	function is_date_valid(string $date) : bool {
		$format_to_check = 'Y-m-d';
		$dateTimeObj = date_create_from_format($format_to_check, $date);
		return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
	}

	
?>