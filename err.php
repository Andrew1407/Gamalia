<?php
  $errMessages = [
    'Даного товару просто нема в наявності або він був видалений з магазину користувачем',
    'Дані введені некоректно',
    'Не намагайтесь видаляти чужі товари',
    'Ви не володієте даним товаром',
    'Ви таке не замовляли',
    'Замовлений Вами товар був видалений його власником (це замовлення самознищиться з Ваших персональних даних)',
    'Не видаляйте товар, якого нема у Вашому "Кошику"',
    'Спочатку зареєструйтесь, а потім вже шастайте',
    'Ви скоїли жахливу помилку - Вас тут не чекали! Ми знаємо достатньо, щоб Вас знайти! Ваша репутація на буде зніжена'
  ];
  $errMessagesLen = count($errMessages) - 1;
  $msg = $errMessagesLen;
  if (isset($_GET['msg']))
    $msg = $_GET['msg'] < $errMessagesLen ?
      $_GET['msg'] : $errMessagesLen;

  $err = $errMessages[$msg] . '!';
?>

<!DOCTYPE html>
  
<html>

  <head>
    <title>Помилочка...</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-err.png">
    <link rel="stylesheet" type="text/css" href="styles/info.css" />
    <link rel="stylesheet" type="text/css" href="styles/info-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
    <link rel="stylesheet" type="text/css" href="styles/err.css" />
  </head>

  <body>

    <!-- registration form -->
    <div id="main-info">

      <h1 id="main-info-name"><a href="main.php">Гамалія</a></h1>

      <div class="main-info-form">
          
        <div class="form-header">
          <p class="personal-header-name">Помилочка...</p>
        </div>

        <div class="user-info">
          <span>
            <?php echo htmlspecialchars($err); ?>
          </span>
          <img class="user-info-img" src="styles/images/err2.png">
        </div>

        <div class="user-info">
          <span>
            З повагою, Інтернет-магазин "Гамалія".
          </span>
        </div>


      </div>

    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/info.js"></script>
    
  </body>

</html>