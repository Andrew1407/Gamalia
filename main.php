<?php
  require_once('ShopDB.class.php');
  require_once('CustomersDB.class.php');
  $shop = new ShopDB();
  $customers = new CustomersDB();
  
  echo $shop->getGoodsJSON();
  $shop->addOrder(2, "США, Вашингтон", 3, 2626);
  print_r($shop->getOrders(1));
  echo $customers->addCustomer('vikok@gmail.com', 'Віктор Кокнос', '2222666');
  echo $customers->getCustomerID('5555262626', 'phone_number');
?>