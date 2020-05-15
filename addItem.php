<?php
  require_once('DB_connection/ShopDB.connection.php');
  session_start();
  if (isset($_POST['addItem'])) {
    $itemNameRegex = '/^.{1,40}$/';
    $priceRegex = '/^\d{1,6}(\.\d{1,2})?$/';
    $categoriesRegex = '/^[\"\'А-ЯҐЄІЇA-Z\'а-яґєіїa-z ]{1,18}(, [\"\'А-ЯҐЄІЇA-Z\'а-яґєіїa-z ]{1,18})*$/';
    $discountRegex = '/^\d{1,2}(\.\d{1,2})?$/';
    $itemNameTest = preg_match($itemNameRegex, $_POST['itemName']);
    $priceTest = preg_match($priceTest, $_POST['price']);
    $categoriesTest = preg_match($categoriesRegex, $_POST['categories']);
    $discountTest = preg_match($discountRegex, $_POST['discount']);
    if (!$itemNameTest || !$priceTest ||
      !$categoriesTest || !$discountTest &&
      !empty($_POST['discount']) || empty($_FILES['pic']['name'])) {
        header('Location: err.php?msg=1');
    }
    $discount = empty(!$_POST['discount']) ? $_POST['discount'] : 0;
    $imageName = $_FILES['pic']['name'];
    $imageTemp = $_FILES['pic']['tmp_name'];
    $imagePath = "images_goods/$imageName";
    move_uploaded_file($imageTemp, $imagePath);
    $itemArgs = [
      $_POST['itemName'], 
      $_POST['price'], 
      $_POST['categories'],
      $imagePath, 
      $discount,
      $_SESSION['id']
    ];
    $shop->addItem(...$itemArgs);
    header('Location: main.php');
  }
?>

<!DOCTYPE html>
  
<html>

  <head>
    <title>Додати товар</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-addItem.png">
    <link rel="stylesheet" type="text/css" href="styles/addItem.css" />
    <link rel="stylesheet" type="text/css" href="styles/addItem-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
  </head>

  <body>

    <div id="main-item">

      <h1 id="main-item-name"><a href="main.php">Гамалія</a></h1>

      <form enctype="multipart/form-data" id="main-item-form" action="addItem.php" method="POST">

        <div class="form-input field">
          <p class="form-label">Назва товару:</p>
          <input type="text" name="itemName" id="form-item-name" placeholder="до 40 символів">
        </div>

        <div class="form-input field">
          <p class="form-label">Ціна:</p>
          <input type="text" name="price" id="form-price" placeholder="000000.00">
        </div>

        <div class="form-input field">
          <p class="form-label">Категорії:</p>
          <input type="text" name="categories" id="form-categories" placeholder="до 40 символів (, )">
        </div>

        <div class="form-input field">
          <p class="form-label">*Знижка (у відсотках %):</p>
          <input type="text" name="discount" id="form-discount" placeholder="00.00 (необов'язкове поле)">
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
          <img id="output-image"/>
        </div>

        <input type="submit" name="addItem" value="Виставити товар на продаж" class="form-input-btn">

      </form>
  </div>

  <!-- site bottom -->
  <?php include('templates/footer.php') ?>
  
  <script src="scripts/jquery.js"></script>
  <script src="scripts/addItem.js"></script>

</body>

</html>
