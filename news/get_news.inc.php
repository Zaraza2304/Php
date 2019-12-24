<?php
$rec = $news->getNews();
if($rec === FALSE) {
	echo "Произошла ошибка при загрузке новостей! Попробуте позже.";
} else {
	if (is_array($arr)) {
		$c_arr = count($arr);
	} else {
		$c_arr = $arr;
	}

	echo "<p>Новости на сайте {$c_arr}</p>";
	/*echo "<pre>";
	var_dump($rec);
	echo "</pre>";*/

	foreach ($rec as $news) {
		echo "<p>" .$news['title']. "</p>";
		echo "<p>" .$news['category']. "</p>";
		echo "<p>" .$news['description']. "</p>";
		echo "<p>" .$news['source']. "</p>";
		echo '<p><a href="delete_news.inc.php?id=' .(int)$news["id"]. '">Удалить новость</a></p>';
		echo "<br><hr>";
	}
}