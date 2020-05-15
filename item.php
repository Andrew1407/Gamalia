<?php
  require_once('DB_connection/ShopDB.connection.php');
  session_start();
  $item = $shop->getItem($_GET['id']);

  if (empty($item))
    header('Location: err.php?msg=0');

  if (isset($_POST['acceptOrder'])) {
    $testQuantity = preg_match('/^[\d]{1,10}$/', $_POST['quantity']);
    $testDest = preg_match('/^.{1,80}$/', $_POST['dest']);
    if (!$testQuantity || !$testDest)
      header('Location: err.php?msg=0');
      
    $queryArgs = [
      $_SESSION['id'],
      $_GET['id'],
      $_POST['destination'],
      $_POST['quantity']
    ];
    $shop->insertCartTemp(...$queryArgs);
    // header('Location: cart.php');
  }
?>

<!DOCTYPE html>

<html>

  <head>
    <title><?php echo $item['item_name']; ?></title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-item.png">
    <link rel="stylesheet" type="text/css" href="styles/item.css" />
    <link rel="stylesheet" type="text/css" href="styles/item-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
    
  </head>

  <body>

    <!-- registration form -->
    <div id="main-item">

      <h1 id="main-item-name"><a href="main.php">Гамалія</a></h1>

      <form id="main-item-form" action="item.php?id=<?php echo $item['id']; ?>" method="POST">
        <img src="<?php echo htmlspecialchars($item['item_image']); ?>" id="item-image">
        <div id="item-description">
            <b>Назва:</b> <?php echo htmlspecialchars($item['item_name']); ?>. <br>
            <b>Ціна:</b> <?php echo htmlspecialchars($item['price']); ?> грн. <br>
            <b>Категорії:</b> <?php echo htmlspecialchars($item['categories']); ?>.
        </div>
        <input type="text" name="quantity" placeholder="к-сть одиниць товару" class="form-input" id="quantity">
        <input type="text" name="destination" placeholder="адреса доставки" class="form-input" id="dest">
        <input type="submit" name="acceptOrder" value="Зробити замовлення" id="form-accept" class="form-input-btn">
        <a href="main.php" id="form-cancel" class="form-input-btn">До всіх товарів</a>
      </form>

    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/item.js"></script>
    
  </body>

</html>
