<?php
  require_once('DB_connection/ShopDB.connection.php');
  session_start();
  if (isset($_GET['rmID'])) {
    $rmItem = $shop->getItem($_GET['rmID']);
    if ($rmItem['owner_id'] != $_SESSION['id']) {
      header('Location: err.php?msg=2');
    } else {
      unlink($rmItem['item_image']);
      $shop->rmItem($_GET['rmID']);
      header('Location: main.php');
    }
  }

  // get all available goods
  $goodsCollection = $shop->getGoods();

  // pop-up menu references in header
  $puMenu = array (
    'cart' => 'reg.php',
    'info' => 'reg.php',
    'addItem' => 'reg.php'
  );
  if (isset($_SESSION['id'])) {
    $puMenu['cart'] = 'cart.php';
    $puMenu['info'] = 'info.php';
    $puMenu['addItem'] = 'addItem.php';
  } else {
    $puMenu['cart'] = $puMenu['info'] = $puMenu['addItem'] = 'reg.php';
  }


?>

<!-- include main.html -->
<!DOCTYPE html>

<html>

  <head>
    <title>Гамалія</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-main.png">
    <link rel="stylesheet" type="text/css" href="styles/main.css" />
    <link rel="stylesheet" type="text/css" href="styles/main-animations.css" />
  </head>

  <body>
    <!-- flex fixed-position menu -->
    <?php include('templates/header.php') ?>
  
    <!-- main area for goods -->
    <div id="main-content">

      <!-- goods grid list -->
      <div id="goods-area">
        <?php foreach ($goodsCollection as $item): ?>
          <form class="goods">
            <div class="goods-ref">
              <a href="<?php echo isset($_SESSION['id']) ? 'item.php?id='.$item['id'] : 'reg.php'; ?>" class="goods-cart"></a>
              <?php if (isset($_SESSION['id'])) if ($item['owner_id'] == $_SESSION['id']): ?>
                <a href="main.php?rmID=<?php echo $item['id']; ?>" class="a-rem"></a>
              <?php endif; ?>
            </div>
            <img src="<?php echo htmlspecialchars($item['item_image']); ?>" class="goods-image">
            <div class="goods-description">
              <b>Назва:</b> <span class="name-searchable"><?php echo htmlspecialchars($item['item_name']); ?></span>. <br>
              <b>Ціна:</b> <?php echo htmlspecialchars($item['price']) ?> грн. <br>
              <b>Категорії:</b> <span class="categories-searchable"><?php echo htmlspecialchars($item['categories']) ?></span>.
            </div>
        </form>
        <?php endforeach; ?>
      </div>
      
    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>
    
    <!-- script for text pop-up in mobile versions -->
    <script src="scripts/jquery.js"></script>
    <script src="scripts/main.js"></script>
  </body>

</html>
