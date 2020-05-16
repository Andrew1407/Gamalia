<?php
  require_once('DB_connection/ShopDB.connection.php');
  session_start();

  if(!isset($_SESSION['id']))
    header('Location: err.php?msg=7');

  if (isset($_POST['itemUpdate'])) {
    $itemNameRegex = '/^.{1,40}$/';
    $priceRegex = '/^\d{1,11}(\.\d{1,2})?$/';
    $categoriesRegex = '/^[#\"\'А-ЯҐЄІЇA-Z\'а-яґєіїa-z\d ]{1,18}(, [#\"\'А-ЯҐЄІЇA-Z\'а-яґєіїa-z\d ]{1,18})*$/u';
    $discountRegex = '/^\d{1,2}(\.\d{1,2})?$/';
    $itemNameTest = preg_match($itemNameRegex, $_POST['itemName']);
    $priceTest = preg_match($priceRegex, $_POST['price']);
    $categoriesTest = preg_match($categoriesRegex, $_POST['categories']);
    $discountTest = preg_match($discountRegex, $_POST['discount']);
    if (!$itemNameTest || !$priceTest ||
      !$categoriesTest || !$discountTest &&
      !empty($_POST['discount'])) {
        header('Location: err.php?msg=1');
    } else {
      $item = $shop->getItem($_GET['uptID']);
      $changed = [];

      if (!empty($_POST['itemName']) && $_POST['itemName'] !== $item['item_name'])
        $changed['item_name'] = $_POST['itemName'];
      if (!empty($_POST['price']) && $_POST['price'] !== $item['price'])
        $changed['price'] = $_POST['price'];
      if (!empty($_POST['categories']) && $_POST['categories'] !== $item['categories'])
        $changed['categories'] = $_POST['categories'];
      if (!empty($_POST['discount']) && $_POST['discount'] !== $item['discount'])
        $changed['discount'] = $_POST['discount'];
      if (!empty($_FILES['pic']['name']) && ('images_goods/' . $_FILES['pic']['name']) !== $item['item_image']) {
        $changed['item_image'] = 'images_goods/' . $_FILES['pic']['name'];
        unlink($item['item_image']);
        $imageTemp = $_FILES['pic']['tmp_name'];
        move_uploaded_file($imageTemp, $changed['item_image']);
      }
    }

    $shop->updateItem($_GET['uptID'], $changed);
    header('Location: info.php');
  } elseif (isset($_GET['id'])) {
    if($shop->isOwnedItem($_GET['id'], $_SESSION['id']))
      $item = $shop->getItem($_GET['id']);
    else
      header('Location: err.php?msg=3');
  } else {
    header('Location: err.php?msg=8');
  }

?>

<!DOCTYPE html>
  
<html>

  <head>
    <title>Редагувати товар</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-itemEdit.png">
    <link rel="stylesheet" type="text/css" href="styles/addItem.css" />
    <link rel="stylesheet" type="text/css" href="styles/addItem-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/itemEdit.css" />
    <link rel="stylesheet" type="text/css" href="styles/itemEdit-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
  </head>

  <body>

  <div id="main-item">

      <h1 id="main-item-name"><a href="main.php">Гамалія</a></h1>

      <form enctype="multipart/form-data" id="main-item-form" action="itemEdit.php?uptID=<?php echo $item['id']; ?>" method="POST">

        <div class="form-input field">
          <p class="form-label">Назва товару:</p>
          <input type="text" name="itemName" value="<?php echo htmlspecialchars($item['item_name']); ?>" id="form-item-name" placeholder="до 40 символів">
        </div>

        <div class="form-input field">
          <p class="form-label">Ціна:</p>
          <input type="text" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" id="form-price" placeholder="000000.00">
        </div>

        <div class="form-input field">
          <p class="form-label">Категорії:</p>
          <input type="text" name="categories" value="<?php echo htmlspecialchars($item['categories']); ?>" id="form-categories" placeholder="до 40 символів (, )">
        </div>

        <div class="form-input field">
          <p class="form-label">*Знижка (у відсотках %):</p>
          <input type="text" name="discount" value="<?php echo htmlspecialchars($item['discount']); ?>" id="form-discount" placeholder="00.00 (необов'язкове поле)">
        </div>

        <div class="form-input" id="image">
          <script type='text/javascript'>
            function preview_image(event) {
             const reader = new FileReader();
             reader.onload = () => {
              const output = document.getElementById('output-image');
              output.src = reader.result;
             }
             reader.readAsDataURL(event.target.files[0]);
            }
          </script>
           <p class="form-label">Зображення товару:</p>
          <input type="file" accept="image/*" onchange="preview_image(event)" id="input-image" name="pic">
          <img src="<?php echo $item['item_image'];?>" id="output-image"/>
        </div>

        <input type="submit" name="itemUpdate" value="Внести зміни" class="form-input-btn">
        <a href="info.php" id="form-cancel" class="form-input-btn">До персональних даних</a>

      </form>
    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/addItem.js"></script>

</body>

</html>
