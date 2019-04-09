<?php

// Роутер
function route($method, $urlData, $router) {

	// подключаемся к серверу
	$link = OpenCon();
    
	// Получение информации о news
    // GET /news/{newsId}
    if ($method === 'GET' && count($urlData) === 1) {
		
		$array = array();
        // Получаем id товара
        $newsId = $urlData[0];
		
        // Вытаскиваем новости из базы...
		// выполняем операции с базой данных К Первой Записи
		$query = "SELECT * FROM ${router} WHERE id='${newsId}'";

		$result = mysqli_query($link, $query) or die("Ошибка 2 " . mysqli_error($link));

		if($result){
			$rows = mysqli_num_rows($result); // количество полученных строк
			for ($i = 0 ; $i < $rows ; ++$i){
				$row = mysqli_fetch_assoc($result);
				
				array_push($array, $row);
			}
			// очищаем результат
			mysqli_free_result($result);
		}

        // Выводим ответ клиенту
		echo json_encode($array);

		// отключаемся от сервера
		CloseCon($link);
 
        return;
    }
	
	if($method === 'GET' && count($urlData) === 0){
		$array = array();
		// выполняем операции с базой данных К Первой Записи
		$query = "SELECT * FROM ${router}";

		$result = mysqli_query($link, $query) or die("Ошибка 2 " . mysqli_error($link));

		if($result){
			$rows = mysqli_num_rows($result); // количество полученных строк
			for ($i = 0 ; $i < $rows ; ++$i){
				$row = mysqli_fetch_assoc($result);
				
				array_push($array, $row);
				
			}
			// очищаем результат
			mysqli_free_result($result);
		}
		
		// Выводим ответ клиенту
		echo json_encode($array);

		// отключаемся от сервера
		CloseCon($link);

		return;
	}
 
    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));
}
