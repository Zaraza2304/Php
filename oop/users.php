<?php
function __autoload($name){
	require "classes/$name.class.php"; 
}


$user = new SuperUser("Oleg", "Oleg_12", "qwerty_32", "user");
$user->showInfo();
echo $user::$count_obj_user;
echo "<br>";
echo $user::$count_obj_superuser;


trait TestTrait{
	function showMsg(){
		echo "<br>Helo<br>";
	}
}


trait TestTrait2{
	function showMsg(){
		echo "<br>Goodbay!!!<br>";
	}
}


class ClassTrait{
	use TestTrait, TestTrait2{
		TestTrait::showMsg as one;
		TestTrait2::showMsg insteadof  TestTrait;
	}
}

$testClass = new ClassTrait();
$testClass->one();
$testClass->TestTrait();