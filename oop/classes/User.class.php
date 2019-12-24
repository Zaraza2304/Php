<?php
Class User extends UserAbstract{
	protected $name;
	protected $login;
	protected $pass;
	static $count_obj_user = 0;
	const role_user = 'user';

	function __construct($name, $login, $pass) {
		$this->name= $name;
		$this->login = $login;
		$this->pass = $pass;
		self::count_obj_user();
	}


	private static function count_obj_user() {
		++self::$count_obj_user;
	}

	public function showInfo() {
		echo "Name: " . $this->name . "<br>";
		echo "Login: " . $this->login . "<br>";
		echo "Password: " . $this->pass . "<br>";
	}
}