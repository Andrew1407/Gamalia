<?php
  require_once('DB_connection/CustomersDB.connection.php');
  session_start();
  $customerID = -1;
  
  if (isset($_POST['sign-up'])) {
    $emailRegex = '/^([a-z_\d\.-]+)@([a-z\d]+)\.([a-z]{2,8})(\.[a-z]{2,8})*$/';
    $initialsRegex = '/^[А-ЯҐЄІЇA-Z][\'а-яґєіїa-z]{1,19}(-[А-ЯҐЄІЇA-Z][\'а-яґєіїa-z]{1,19})* [А-ЯҐЄІЇA-Z][\'а-яґєіїa-z]{1,19}(-[А-ЯҐЄІЇA-Z][\'а-яґєіїa-z]{1,19})*$/';
    $phoneRegex = '/^\+?[\d]{6,12}$/';
    $passwdRegex = '/^.{5,16}$/';
    $emailTest = preg_match($emailRegex, $_POST['email']);
    $initialsTest = preg_match($initialsRegex, $_POST['initials']);
    $phoneTest = preg_match($phoneRegex, $_POST['phone']);
    $passwdTest = preg_match($passwdRegex, $_POST['passwd']);
    if (!$emailTest || !$passwdTest ||
      !$initialsTest || !$phoneTest) {
        header('Location: err.php?msg=1');
    } else {
      $email = $_POST['email'];
      $initials = $_POST['initials'];
      $phone = $_POST['phone'];
      $passwd = $_POST['passwd'];
      $customerID = $customers->addCustomer($email, $initials, $phone, $passwd);
    }
  }

  if ($customerID != -1) {
    $_SESSION['id'] = $customerID;
    header('Location: main.php');
  }
?>

<!DOCTYPE html>
  
<html>

  <head>
    <title>Реєстрація</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-reg.png">
    <link rel="stylesheet" type="text/css" href="styles/reg.css" />
    <link rel="stylesheet" type="text/css" href="styles/reg-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
  </head>

  <body>

    <!-- registration form -->
    <div id="main-reg">

      <h1 id="main-reg-name"><a href="main.php">Гамалія</a></h1>

      <form id="main-reg-form" action="reg.php" method="POST">
          
        <div class="form-input" id="email">
          <p class="form-label">Ваш e-mail:</p>
          <input type="email" name="email" id="form-email" placeholder="до 40 символів (авторизація)">
        </div>

        <div class="form-input" id="initials">
          <p class="form-label">Ім'я, прізвище:</p>
          <input type="text" name="initials" id="form-initials" placeholder="до 40 символів">
        </div>

        <div class="form-input" id="phone">
          <p class="form-label">Нормер телефона:</p>
          <input type="text" name="phone" id="form-number" placeholder="до 12 символів">
        </div>

        <div class="form-input" id="passwd">
          <p class="form-label">Пароль:</p>
          <input type="password" name="passwd" id="form-passwd" placeholder="5-16 символів">
        </div>


        <input type="submit" name="sign-up" value="Зареєструватися" id="form-sign-in" class="form-input-btn">
        <a href="auth.php" Увійти id="form-sign-up" class="form-input-btn">Увійти (зареєстрованим)</a>

      </form>

    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/reg.js"></script>

  </body>

</html>