<?php
  require_once('DB_connection/CustomersDB.connection.php');
  require_once('DB_connection/ShopDB.connection.php');
  session_start();
  $userID = $_SESSION['id'];
  if (isset($_POST['acceptChanges'])) {
    $userChanged = json_decode($_POST['infoChanged'], true);
    if (!empty($userChanged))
      $customers->updateCustomer($userID, $userChanged);
  }

  $itemsOwned = $shop->getItemsByOwnerID($userID);
  $orders = $shop->getOrders($userID);
  $user = $customers->getCustomerByID($userID);
?>

<!DOCTYPE html>
  
<html>

  <head>
    <title>Персональні дані</title>
    <meta charset="utf-8" />
    <link rel="icon" href="styles/images/logos/logo-info.png">
    <link rel="stylesheet" type="text/css" href="styles/info.css" />
    <link rel="stylesheet" type="text/css" href="styles/info-animations.css" />
    <link rel="stylesheet" type="text/css" href="styles/footer.css" />
  </head>

  <body>

    <!-- registration form -->
    <div id="main-info">

      <h1 id="main-info-name"><a href="main.php">Гамалія</a></h1>

      <div class="main-info-form">
          
        <div class="form-header">
          <p class="personal-header-name">Персональні дані:</p>
        </div>

        <div class="user-info">

          <div class="info-item-wrap">
            <u>email:</u>
            <span class="user-info-output editable info-item" id="info-email">
              <?php echo htmlspecialchars($user['email']);?>
            </span>
            <input type="text" class="info-edit" id="email">
          </div>

          <div class="info-item-wrap">
            <u>Ім'я, прізвище: </u>
            <span class="user-info-output editable info-item" id="info-initials">
              <?php echo htmlspecialchars($user['initials']);?>
            </span>
            <input type="text" class="info-edit" id="initials">
          </div>

          <div class="info-item-wrap">
            <u>Нормер телефона: </u>
            <span class="user-info-output editable info-item" id="info-number">
              <?php echo htmlspecialchars($user['phone_number']);?>
            </span>
            <input type="text" class="info-edit" id="phone_number">
          </div>

          <div class="info-item-wrap">
            <u>Дата реєстрації: </u>
            <span class="user-info-output info-item">
              <?php echo htmlspecialchars($user['reg_date']);?>
            </span>
          </div>

          <div class="info-item-wrap">
            <span class="user-info-output editable" id="info-passwd">
              *Змінити пароль
            </span>
            <input type="password" class="info-edit" id="passwd">
          </div>

          <form action="info.php", method="POST">
            <input type="submit" name="acceptChanges" value="Підтвердити зміни" id="info-btn">
            <input type="hidden" name="infoChanged" value="{}" id="infoChanged">
          </form>

        </div>

      </div>

        <?php if (!empty($orders)): ?>
          <div class="main-info-form">
          
            <div class="form-header">
              <p class="personal-header-name">Замовлення:</p>
            </div>
  
            <div class="user-info">
  
              <div>
                <ul class="info-ordered">
                  <?php foreach ($orders as $order): ?>
                    <li class="info-item">
                      <span id="user-info-output">
                        <a class="info-ref" href="itemView.php?id=<?php echo $order['order_id']; ?>">
                          <?php echo htmlspecialchars(explode(' ', $order['order_date'])[0]) . " (" . htmlspecialchars($order['dest']) . ")";?>
                        </a>
                      </span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>

            </div>
  
          </div>  
        <?php endif; ?>

        <?php if (!empty($itemsOwned)): ?>
          <div class="main-info-form">
          
            <div class="form-header">
              <p class="personal-header-name">Товари, виставлені на продаж:</p>
            </div>
  
            <div class="user-info">
  
              <div>
                <ul class="info-owned">
                  <?php foreach ($itemsOwned as $item): ?>
                    <li class="info-item">
                      <span id="user-info-output">
                        <a class="info-ref owned" href="itemEdit.php?id=<?php echo $item['id']; ?>">
                          <?php echo htmlspecialchars($item['item_name']);?>
                        </a>
                      </span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>

            </div>

          </div>  
        <? endif; ?>

    </div>

    <!-- site bottom -->
    <?php include('templates/footer.php') ?>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/info.js"></script>
    
  </body>

</html>