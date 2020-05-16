<?php
  require_once('DB_connection/CustomersDB.connection.php');
  session_start();

  unset($_SESSION['id']);

  if (isset($_POST['sign-up'])) {
    $emailRegex = '/^([a-z_\d\.-]+)@([a-z\d]+)\.([a-z]{2,8})(\.[a-z]{2,8})*$/';
    $passwdRegex = '/^.{5,16}$/';
    $emailTest = preg_match($emailRegex, $_POST['email']);
    $passwdTest = preg_match($passwdRegex, $_POST['passwd']);
    if (!$emailTest || !$passwdTest)
      header('Location: err.php?msg=1');
      
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
    $customerID = $customers->getCustomerID($email, $passwd);
    $_SESSION['id'] = $customerID;
    if ($customerID != -1)
      header('Location: main.php');
    else
      header('Location: err.php?msg=1');
  }

?>

<!DOCTYPE html>
  
<html>

  <head>
    <title>Вхід</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-auth.png">
    <link rel="stylesheet" type="text/css" href="styles/reg.css" />
    <link rel="stylesheet" type="text/css" href="styles/reg-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/auth.css" />
    <link rel="stylesheet" type="text/css" href="styles/auth-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
  </head>

  <body>

    <!-- registration form -->
    <div id="main-reg">

      <h1 id="main-reg-name"><a href="main.php">Гамалія</a></h1>

      <form id="main-reg-form" action="auth.php" method="POST">
          
        <div class="form-input" id="email">
          <p class="form-label">Ваш e-mail:</p>
          <input type="email" name="email" id="form-email" placeholder="до 40 символів (авторизація)">
        </div>

        <div class="form-input" id="passwd">
          <p class="form-label">Пароль:</p>
          <input type="password" name="passwd" id="form-passwd" placeholder="5-16 символів">
        </div>


        <input type="submit" name="sign-up" value="Увійти" id="form-sign-in" class="form-input-btn">
        <a href="reg.php" id="form-sign-up" class="form-input-btn">Зареєструватися</a>

      </form>

    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/reg.js"></script>
  </body>

</html>