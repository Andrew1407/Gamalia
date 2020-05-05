<?php
  class ShopDB {
    private $conn;

    function __construct() {
      $this->conn = mysqli_connect("localhost", "Andrew", "649275", "ShopDB");
      mysqli_set_charset($this->conn, "utf8");
    }

    public function getGoodsJSON() {
      $query = 'SELECT * FROM Goods;';
      $goodsRes = mysqli_query($this->conn, $query);
      $goodsArr = mysqli_fetch_all($goodsRes, MYSQLI_ASSOC);
      mysqli_free_result($goodsRes);
      $goodsJSON = json_encode($goodsArr,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      return $goodsJSON;
    }

    private function insertOrder($dest, $personID) {
      $addOrder = "INSERT INTO Orders (dest, person_id) VALUES ('$dest', $personID);";
      mysqli_query($this->conn, $addOrder);
      $orderID = mysqli_insert_id($this->conn);
      return $orderID;
    }

    private function insertCustomersCart($orderID, $itemID, $quantity) {
      $addCart = "INSERT INTO CustomersCart (order_id, item_id, quantity) VALUES ($orderID, $itemID, $quantity);";
      mysqli_query($this->conn, $addCart);
    }

    public function addOrder($personID, $dest, $itemID, $quantity = 1) {
      $orderID = $this->insertOrder($dest, $personID);
      $this->insertCustomersCart($orderID, $itemID, $quantity);
    }

    public function getOrders($personID) {
      $ordersQuery = "SELECT id as order_id, dest, order_date FROM Orders WHERE person_id = $personID;";
      $res = mysqli_query($this->conn, $ordersQuery);
      $orders = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $orders;
    }

    function __destruct() {
      mysqli_close($this->conn);
    }
  }
?>