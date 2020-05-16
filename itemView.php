<?php
  require_once('DB_connection/ShopDB.connection.php');
  session_start();

  if(!isset($_SESSION['id']))
    header('Location: err.php?msg=7');

  if (isset($_GET['id'])) {
    if ($shop->isOrdered($_GET['id'], $_SESSION['id']))
      if($shop->isOrderPresentInCart($_GET['id'])) {
        $item = $shop->getCartByOrderID($_GET['id']);
      } else {
        $shop->rmOrder($_GET['id']);
        header('Location: err.php?msg=5');
      }
    else
      header('Location: err.php?msg=4');
  } else {
    header('Location: err.php?msg=8');
  }
?>

<!DOCTYPE html>

<html>

  <head>
    <title>Замовлення</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-itemView.png">
    <link rel="stylesheet" type="text/css" href="styles/item.css" />
    <link rel="stylesheet" type="text/css" href="styles/item-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/itemView.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
  </head>

  <body>

    <!-- registration form -->
    <div id="main-item">

      <h1 id="main-item-name"><a href="main.php">Гамалія</a></h1>

      <div id="main-item-form" action="item.php?id=<?php echo $item['id']; ?>" method="POST">
        <img src="<?php echo htmlspecialchars($item['item_image']); ?>" id="item-image">
        <div id="item-description">
            <b class="item-description-type">Назва:</b> <?php echo htmlspecialchars($item['item_name']); ?><br>
            <b class="item-description-type">Ціна:</b> <?php echo htmlspecialchars($item['price']) ?> грн.<br>
            <b class="item-description-type">Знижка:</b> <?php echo htmlspecialchars($item['discount']) ?> грн.<br>
            <b class="item-description-type">Категорії:</b> <?php echo htmlspecialchars($item['categories']) ?>.<br>
            <b class="item-description-type">Кількість:</b> <?php echo htmlspecialchars($item['quantity']) ?><br>
            <b class="item-description-type">Місце доставки:</b> <?php echo htmlspecialchars($item['dest']) ?><br>
            <b class="item-description-type">Дата оформлення замовлення:</b> <?php echo htmlspecialchars($item['order_date']) ?>
        </div>

        <a href="info.php" id="form-cancel" class="form-input-btn">До персональних даних</a>
      </div>

    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/item.js"></script>

  </body>

</html>
