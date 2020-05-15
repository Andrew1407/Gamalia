<?php 
  require_once('DB_connection/ShopDB.connection.php');
  session_start();
  // $customerID = $_SESSION['id'];
  // $orders = $shop->getOrders($customerID);
  // $ordersIDs = array_map(function($order) {
  //   return $order['order_id'];
  // }, $orders);
  // $cartInfo = $shop->getCartData($ordersIDs);
  // print_r($cartInfo);
  // print_r($shop->getCartByOrderID($_GET['id']));
  echo $_SESSION['id'];
  
?>