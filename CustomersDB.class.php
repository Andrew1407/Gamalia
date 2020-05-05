<?php
  class CustomersDB {
    private $conn;

    function __construct() {
      $this->conn = mysqli_connect("localhost", "Andrew", "649275", "CustomersDB");
      mysqli_set_charset($this->conn, "utf8");
    }

    public function addCustomer($email, $initials, $phone) {
      $addQuery = "INSERT INTO Customers (email, initials, phone_number) VALUES ('$email', '$initials', '$phone');";
      mysqli_query($this->conn, $addQuery);
      $customerID = mysqli_insert_id($this->conn);
      return $customerID;
    }

    public function rmCustomer($id) {
      $rmQuery = "DELETE FROM Customers WHERE id = $id;";
      mysqli_query($this->conn, $rmQuery);
    }

    public function getCustomerID($val, $field = 'initials') {
      $getQuery = "SELECT id FROM Customers WHERE $field LIKE '%$val%';";
      $res = mysqli_query($this->conn, $getQuery);
      $id = mysqli_fetch_all($res, MYSQLI_ASSOC);
      mysqli_free_result($res);
      return $id ? $id[0]['id'] : -1;
    }

    function __destruct() {
      mysqli_close($this->conn);
    }
  }
?>