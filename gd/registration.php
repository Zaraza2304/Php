<?php
session_start();
$output = "";
if ( $_SERVER["REQUEST_METHOD"] == "POST" and !empty($_POST["answer"]) ) {
  if (!isset($_SESSION["word"])) {
    $output = "Включите подрежку изображений";
  } else {
    $answer = strtolower(htmlentities(strip_tags($_POST["answer"])));
    if ($_SESSION["word"] == $answer) {
      $output = "Succsessfully!";
    } else {
      $output = "Неверный ответ";
    }
  }
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8" />
  <title>Регистрация</title>
</head>

<body>
  <h1>Регистрация</h1>
  <form action="" method="post">
    <div>
      <img src="noise-picture.php">
    </div>
    <div>
      <label>Введите строку</label>
      <input type="text" name="answer" size="6">
    </div>
    <input type="submit" value="Подтвердить">
  </form>
  <?php
    echo $output;
  ?>
</body>

</html>