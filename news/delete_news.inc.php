<?php
if ( $_SERVER["REQUEST_METHOD"] == "GET" and !empty($_GET["id"])) {
	require "NewsDB.class.php";
	$news_ = new NewsDB();

	$id = $news_->clearInt($_GET["id"]);


	if(!$news_->deleteNews($id)) {
		$err_msg = "Не удалось удалить новость";
	}
	header("Location: news.php");
}

