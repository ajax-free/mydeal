<?php
    
    //подключаемся к базе данных
    $link = mysqli_connect(HOST, USER, PASS, DBNAME);
    mysqli_set_charset($link, "utf8");
    
    if ($link == false){
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
    else {
        $arr_projects = [];//массив проектов
        $arr_tasks = [];//массив задач
        
        //проверяем наличие get параметров
        $project_show = '';
        if(isset($_GET['show']) && $_GET['show'] != ''){
            $project_show = $_GET['show'];
        }

        //запрос на выборку проектов
        $sql_project = 'select * from projects where author=1';
        $res_project = mysqli_query($link, $sql_project);
        while ($row = mysqli_fetch_array($res_project)) {
            $arr_projects[$row['id']] = $row['title'];
        }

        //выборка задач для конкретного проекта
        if($project_show){
            $sql_task = 'select * from tasks where author=1 AND project='.$project_show;
        } else {
            $sql_task = 'select * from tasks where author=1';
        }
        $res_task = mysqli_query($link, $sql_task);
        while ($row = mysqli_fetch_array($res_task)) {
            $arr_tasks[$row['id']] = array('title' => $row['title'],'status' => $row['task_status'],'date_start' => $row['date_create'],'date_complete' => $row['date_ready'], 'attachment'=> $row['attachment'], 'filename'=> $row['attachment']);
        }
    }
    mysqli_close($link);
        
	//получаем информацию для конкретной страницы из текстовой базы
	function searchData(&$database, $url_key){
		foreach ($database['pages'] as $key => $value) {
			if($value['url_key'] == $url_key){
                return $value;
			}
		}
		return false;
    }

    //запрос на создание задачи
    function create_task($title, $task_status, $date_ready, $attachment = '', $author = 1, $project){
        $link = mysqli_connect(HOST, USER, PASS, DBNAME);
        mysqli_set_charset($link, "utf8");
    
        $sql_query_insert = "insert into tasks (title,task_status,date_ready,attachment,author,project) values ('$title','$task_status','$date_ready','$attachment','$author','$project')";
        $res = mysqli_query($link, $sql_query_insert);
        
        mysqli_close($link);
        return $res;
    }

    //считаем количесво задач в проекте
    function count_tasks($author = 1, $project){
        $arr_tasks = [];
        $link = mysqli_connect(HOST, USER, PASS, DBNAME);
        mysqli_set_charset($link, "utf8");

        $sql_task = "select * from tasks where author = $author AND project = $project";
        $res_task = mysqli_query($link, $sql_task);
        while ($row = mysqli_fetch_array($res_task)) {
            $arr_tasks[] = $row['id'];
        }

        mysqli_close($link);
        //die(var_dump($arr_tasks));
        return count($arr_tasks);
    }
    
?>