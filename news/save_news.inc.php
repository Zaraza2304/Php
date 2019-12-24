<?php
$title = $news->clearStr($_POST['title']);
$category = $news->clearStr($_POST['category']);
$description = $news->clearStr($_POST['description']);
$source = $news->clearStr($_POST['source']);

if (empty($title)) {
	$err_msg = "Заполните поля";
} else {
	if ( $news->saveNews($title, $category, $description, $source) ) {
		$err_msg = "Новость успешно добавлена!";
		header("Location: news.php");
		exit;
	} else {
		$err_msg = "Ошибка при сохранении данных!";
	}
}