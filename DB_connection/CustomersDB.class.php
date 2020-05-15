<?php
  class CustomersDB {
    private $conn;

    function __construct() {
      $this->conn = mysqli_connect("localhost", "Andrew", "649275", "CustomersDB");
      mysqli_set_charset($this->conn, "utf8");
    }

    public function addCustomer($email, $initials, $phone, $passwd) {
      $addQuery = "INSERT INTO Customers (email, initials, phone_number, passwd) VALUES ('$email', '$initials', '$phone', '$passwd');";
      mysqli_query($this->conn, $addQuery);
      $customerID = mysqli_insert_id($this->conn);
      return $customerID;
    }

    public function rmCustomer($id) {
      $rmQuery = "DELETE FROM Customers WHERE id = $id;";
      mysqli_query($this->conn, $rmQuery);
    }

    public function updateCustomer($id, $changed) {
      $changedKeys = array_keys($changed);
      $querySet = [];
      foreach ($changedKeys as $key) {
        $value = $changed[$key];
        $querySet[] = "$key = '$value'";
      }
      $querySetStr = implode(', ', $querySet);
      $updateQuery = "UPDATE Customers SET $querySetStr WHERE id = $id;";
      return mysqli_query($this->conn, $updateQuery);
    }

    public function getCustomerID($email, $passwd) {
      $getQuery = "SELECT id FROM Customers WHERE email = '$email' AND passwd = '$passwd';";
      $res = mysqli_query($this->conn, $getQuery);
      $id = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $id ? $id[0]['id'] : -1;
    }

    public function getCustomerByID($id) {
      $getQuery = "SELECT * FROM Customers WHERE id = $id;";
      $res = mysqli_query($this->conn, $getQuery);
      [ $customer ] = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $customer;
    }

    function __destruct() {
      mysqli_close($this->conn);
    }
  }
?>