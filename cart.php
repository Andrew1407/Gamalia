<?php
  require_once('DB_connection/ShopDB.connection.php');
  session_start();

  if(!isset($_SESSION['id']))
    header('Location: err.php?msg=7');

  if (isset($_GET['rmID'])) {
    if ($shop->isInCartTemp($_GET['rmID'])) {
      $shop->rmCartTempByID($_GET['rmID']);
      header('Location: cart.php');
    } else {
      header('Location: err.php?msg=6');
    }
  } elseif (isset($_POST['acceptOrder'])) {
    $items = $shop->getCartTemp($_SESSION['id']);
    foreach ($items as $item)
      $shop->addOrder($_SESSION['id'], $item['dest'], $item['item_id'], $item['quantity']);
    $shop->rmCartTempByPersonID($_SESSION['id']);
    header('Location: cart.php');
  }

  $goodsCollection = $shop->getCartTemp($_SESSION['id']);
  $puMenu = array (
    'cart' => 'cart.php',
    'info' => 'info.php',
    'addItem' => 'addItem.php'
  );
?>

<!DOCTYPE html>

<html>

  <head>
    <title>Персональний кошик</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-cart.png">
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" href="styles/cart.css" />
    <link rel="stylesheet" type="text/css" href="styles/main-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/cart-animations.css" />
  </head>

  <body>
    <!-- flex fixed-position menu -->
    <?php include('templates/header.php') ?>

    <!-- order area -->
    <div id="cart-order-area">
      <div id="goods-area">
        <?php if(isset($goodsCollection)) foreach ($goodsCollection as $item): ?>
          <form class="goods">
            <a href="cart.php?rmID=<?php echo $item['cart_id']; ?>" class="goods-remove"></a>
            <img src="<?php echo htmlspecialchars($item['item_image']); ?>" class="goods-image">
            <div class="goods-description description-main">
              <b>Назва:</b> <span class="name-searchable"><?php echo htmlspecialchars($item['item_name']); ?></span>.<br>
              <b>Ціна:</b> <?php echo htmlspecialchars($item['price']); ?> грн. <br>
              <b>Категорії: </b><span class="categories-searchable"> <?php echo htmlspecialchars($item['categories']); ?></span>.
            </div>
            <div class="goods-description info-more">
              <b>Адреса доставки:</b> <?php echo htmlspecialchars($item['dest']); ?>.<br>
              <b>Кількість:</b> <?php echo htmlspecialchars($item['quantity']); ?>.<br>
              <b>Знижка:</b> <?php echo htmlspecialchars($item['discount']); ?>.
            </div>
        </form>
        <?php endforeach; ?>
      </div> 
    </div>

    <form id="submit-order" action="cart.php" method="POST">

      <div id="submit-form">          
        <div class="form-info">
          <p>Підтвердження замовлення (після підтвердження Ваш персональний "Кошик" очиститься).</p>
        </div>        
        <input type="submit" value="Підтвердити" id="form-ok" name="acceptOrder">
        <a href="" id="form-cancel">Відміна</a>                 
      </div>
      
      <a href="#submit-form" id="submit-order-button">Зробити замовлення</a>
      
    </form>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <!-- <script src="scripts/goods-mobiles.js"></script> -->
    <script src="scripts/jquery.js"></script>
    <script src="scripts/main.js"></script>
  </body>

</html>