<!-- flex fixed-position menu -->
<header id="main-header">

      <h1 id="main-header-name"><a href="main.php">Гамалія</a></h1>
      <!-- input search field -->
      <div id="main-header-goods">
        <label for="main-header-goods-search" id="main-header-goods-search-label">Пошук товарів:</label>
        <input type="text" id="main-header-goods-search" placeholder="Введіть назву товару" autofocus>
      </div>

      <!-- right-side menu -->
      <div id="main-header-menu">

        <input type="checkbox" id="main-header-menu-checkbox">
        <label for="main-header-menu-checkbox" id="main-header-menu-label">Меню</label>

        <div id="main-header-menu-dropdown">

          <ul>
            <li><a href="<?php echo htmlspecialchars($puMenu['cart']) ?>" class="menu-dropdown-links">Кошик</a></li>
            <li><a href="<?php echo htmlspecialchars($puMenu['info']) ?>" class="menu-dropdown-links">Особисті дані</a></li>
            <li><a href="<?php echo htmlspecialchars($puMenu['addItem']) ?>" class="menu-dropdown-links">Додати товар</a></li>
            <li><a href="auth.php" class="menu-dropdown-links">Вхід/вихід</a></li>
          </ul>

        </div>

      </div>

    </header>