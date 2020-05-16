<?php
  class ShopDB {
    private $conn;

    function __construct() {
      $this->conn = mysqli_connect('localhost', 'Andrew', '649275', 'ShopDB');
      mysqli_set_charset($this->conn, "utf8");
    }

    public function getGoods() {
      $query = 'SELECT * FROM Goods;';
      $goodsRes = mysqli_query($this->conn, $query);
      $goodsArr = mysqli_fetch_all($goodsRes, MYSQLI_ASSOC);
      mysqli_free_result($goodsRes);
      return $goodsArr;
    }

    public function getGoodsJSON() {
      $goodsArr = $this->getGoods();
      $goodsJSON = json_encode($goodsArr,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
      return $goodsJSON;
    }

    public function getItem($id) {
      $query = "SELECT * FROM Goods WHERE id = $id;";
      $res = mysqli_query($this->conn, $query);
      [ $item ] = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $item;
    }

    public function getItemsByOwnerID($ownerID) {
      $query = "SELECT * FROM Goods WHERE owner_id = $ownerID;";
      $res = mysqli_query($this->conn, $query);
      $items = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $items;
    }

    public function isOwnedItem($itemID, $ownerID) {
      $query = "SELECT id FROM Goods WHERE owner_id = $ownerID AND id = $itemID;";
      $res = mysqli_query($this->conn, $query);
      $orders = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return !empty($orders);
    }

    public function isOrdered($orderID, $ownerID) {
      $query = "SELECT id FROM Orders WHERE person_id = $ownerID AND id = $orderID;";
      $res = mysqli_query($this->conn, $query);
      $cart = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return !empty($cart);
    }

    public function addItem($name, $price, $categories, $imgPath, $discount, $owner_id) {
      $name = mysqli_real_escape_string($this->conn, $name);
      $categories = mysqli_real_escape_string($this->conn, $categories);
      $imgPath = mysqli_real_escape_string($this->conn, $imgPath);
      $addQuery = "INSERT INTO Goods (item_name, price, categories, item_image, discount, owner_id) VALUES ('$name', $price, '$categories', '$imgPath', $discount, $owner_id);";
      mysqli_query($this->conn, $addQuery);
      $itemID = mysqli_insert_id($this->conn);
      return $itemID;
    }

    public function rmItem($itemID) {
      $rmQuery = "DELETE FROM Goods WHERE id = $itemID;";
      return mysqli_query($this->conn, $rmQuery);
    }

    public function updateItem($itemID, $changed) {
      $changedKeys = array_keys($changed);
      $querySet = [];
      foreach ($changedKeys as $key) {
        $value = $changed[$key];
        $querySet[] = "$key = '$value'";
      }
      $querySetStr = implode(', ', $querySet);
      $updateQuery = "UPDATE Goods SET $querySetStr WHERE id = $itemID;";
      return mysqli_query($this->conn, $updateQuery);
    }


    private function insertOrder($dest, $personID) {
      $dest = mysqli_real_escape_string($this->conn, $dest);
      $addOrder = "INSERT INTO Orders (dest, person_id) VALUES ('$dest', $personID);";
      mysqli_query($this->conn, $addOrder);
      $orderID = mysqli_insert_id($this->conn);
      return $orderID;
    }

    private function insertCustomersCart($orderID, $itemID, $quantity) {
      $addCart = "INSERT INTO CustomersCart (order_id, item_id, quantity) VALUES ($orderID, $itemID, $quantity);";
      return mysqli_query($this->conn, $addCart);
    }

    public function addOrder($personID, $dest, $itemID, $quantity) {
      $orderID = $this->insertOrder($dest, $personID);
      $this->insertCustomersCart($orderID, $itemID, $quantity);
      return $orderID;
    }

    public function rmOrder($orderID) {
      $rmQuery = "DELETE FROM Orders WHERE id = $orderID;";
      return mysqli_query($this->conn, $rmQuery);
    }

    public function getOrders($personID) {
      $ordersQuery = "SELECT id as order_id, dest, order_date FROM Orders WHERE person_id = $personID;";
      $res = mysqli_query($this->conn, $ordersQuery);
      $orders = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $orders;
    }

    public function insertCartTemp($personID, $itemID, $dest, $quantity) {
      $dest = mysqli_real_escape_string($this->conn, $dest);
      $query = "INSERT INTO CartTemp (person_id, item_id, dest, quantity) VALUES ($personID, $itemID, '$dest', $quantity);";
      return mysqli_query($this->conn, $query);
    }

    public function getCartTemp($personID) {
      $query = "SELECT a.id AS cart_id, item_id, dest, quantity, item_name, categories, price, item_image, discount FROM CartTemp a LEFT JOIN Goods b ON a.item_id = b.id WHERE person_id = $personID;";
      $res = mysqli_query($this->conn, $query);
      $cartInfo = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $cartInfo;
    }
    
    public function rmCartTempByID($cartID) {
      $rmQuery = "DELETE FROM CartTemp WHERE id = $cartID;";
      return mysqli_query($this->conn, $rmQuery);
    }

    public function rmCartTempByPersonID($personID) {
      $rmQuery = "DELETE FROM CartTemp WHERE person_id = $personID;";
      return mysqli_query($this->conn, $rmQuery);
    }

    public function getCartByOrderID($id) {
      $query = "SELECT * FROM CustomersCart c LEFT JOIN Orders o ON c.order_id = o.id LEFT JOIN Goods g ON c.item_id = g.id WHERE o.id = $id;";
      $res = mysqli_query($this->conn, $query);
      [ $order ] = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $order;
    }

    public function isInCartTemp($cartID) {
      $query = "SELECT id FROM CartTemp WHERE id = $cartID;";
      $res = mysqli_query($this->conn, $query);
      $cart = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return !empty($cart);
    }

    public function isOrderPresentInCart($orderID) {
      $query = "SELECT order_id FROM CustomersCart WHERE order_id = $orderID;";
      $res = mysqli_query($this->conn, $query);
      $order = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return !empty($order);
    }

    function __destruct() {
      mysqli_close($this->conn);
    }
  }
?>