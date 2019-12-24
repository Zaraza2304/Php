<?php
require_once "INewsDB.class.php";

Class NewsDB implements INewsDB{
	protected const DB_NAME = "news.db";
	protected const RSS_NAME = "rss.xml";
	protected const RSS_TITLE = "Last news";
	protected const RSS_LINK = "day3/news/rss.xml";
	protected $_db = null;

	public function __construct(){

		$this->create_db();
	}

	private function create_db(){
		$db = new SQLite3(self::DB_NAME);
		$this->_db = $db;

		if ( filesize(self::DB_NAME) == 0) {
			$sql = 'CREATE TABLE msgs(
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					title TEXT,
					category INTEGER,
					description TEXT,
					source TEXT,
					datetime INTEGER)';

			$sql1 = 'CREATE TABLE category(
						id INTEGER,
						name TEXT
					)';

			$sql2 = "INSERT INTO category(id, name)
					SELECT 1 as id, 'Политика' as name
					UNION SELECT 2 as id, 'Культура' as name
					UNION SELECT 3 as id, 'Спорт' as name ";
			$this->_db->exec($sql) or die($this->_db->lastErrorMsg());
			$this->_db->exec($sql1) or die($this->_db->lastErrorMsg());
			$this->_db->exec($sql2) or die($this->_db->lastErrorMsg());
		}
	}

	public function __get($name){
		if ($name === "_db") {
			return $this->_db;
		} else {
			throw new Exception("Unknown property!");
		}
	}

	public function saveNews($title, $category, $description, $source) {
		$dt = time();

		$sql = "INSERT INTO msgs(title, category, description, source, datetime)
				VALUES('$title', $category, '$description', '$source', $dt)";

		if(!$this->_db->exec($sql)){
			return false;
		}

		$this->createRSS();
		return true;
	}

	public function getNews() {
		$sql = "SELECT msgs.id as id, title, category.name as category, description, source, datetime
				FROM msgs, category
				WHERE category.id = msgs.category
				ORDER BY msgs.id DESC";

		$answer = $this->_db->query($sql);
		$res = array();

		while ($row = $answer->fetchArray(SQLITE3_ASSOC)) {
			$res[] = $row;
		}

		return $res;
	}

	public function deleteNews($id) {
		$sql = "DELETE FROM msgs
				WHERE id = " . $id ."";

		return $this->_db->exec($sql);
	}

	public function clearStr($data) {

		return $this->_db->escapeString(htmlentities($data));
	}

	public function clearInt($data) {

		return abs((int)$data);
	}

	private function createRSS() {
		$dom = new DomDocument("1.0", "utf-8");
		$dom->formatOutput = true;
		$dom->preserveWhiteSpace = false;

		$rss = $dom->createElement("rss");
		$version = $dom->createAttribute("version");
		$version->value = "2.0";
		$rss->appendChild($version);

		$channel = $dom->createElement("channel");
		$main_title = $dom->createElement("title", self::RSS_TITLE);
		$main_link = $dom->createElement("link", self::RSS_LINK);

		$channel->appendChild($main_title);
		$channel->appendChild($main_link);

		$arr = $this->getNews();

		foreach ($arr as $news) {
			$item = $dom->createElement("item");

			$title = $dom->createElement("title", $news["title"]);

			$l = "day3/news/" .$news["category"]. "/" .$news["title"];

			$link = $dom->createElement("link", $l);

			$description = $dom->createElement("description");
			$cdata_desc = $dom->createCDATASection($news["description"]);
			$description->appendChild($cdata_desc);

			$pubDate = $dom->createElement("pubDate", $news["datetime"]);
			$category = $dom->createElement("category", $news["category"]);

			$item->appendChild($title);
			$item->appendChild($link);
			$item->appendChild($description);
			$item->appendChild($pubDate);
			$item->appendChild($category);

			$channel->appendChild($item);
		}

		$rss->appendChild($channel);
		$dom->appendChild($rss);
		$dom->save(self::RSS_NAME);
	}

	protected function db2Arr($data) {
		$arr = [];
		while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
			$arr[] = $row;
		}

		return $arr;
	}

	public function __destruct(){

		unset($this->_db);
	}
}