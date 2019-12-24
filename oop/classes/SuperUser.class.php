<?php
Class SuperUser extends User implements ISuperUser{
	private $role;
	static $count_obj_superuser = 0;

	public function __construct($name, $login, $pass, $role){
		parent::__construct($name, $login, $pass);
		$this->role = $role;
		self::count_obj();
	}

	private static function count_obj() {
		++self::$count_obj_superuser;
	}
	public function showInfo() {
		parent::showInfo();
		echo "Role: " . $this->role . "<br>";
	}

	public function getInfo(){
		$arr['name'] = $this->name;
		$arr['login'] = $this->login;
		$arr['pass'] = $this->pass;
		$arr['role'] = $this->role;

		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

	public function __set($tmp, $val){

		$this->arr[$tmp] = $val;
	}

	public function __get($tmp){

		return $this->arr[$tmp];
	}
}