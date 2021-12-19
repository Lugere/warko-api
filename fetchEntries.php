<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$tableName = $_GET['tableName'];

if ($tableName && in_array($tableName, $allowedTableNames)) {
  switch ($tableName) {
    case "products":
      $query = "SELECT * FROM $tableName ORDER BY prodId DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      // $result = ["gothere" => "first"];
      break;

    case "orders":
      $query = "SELECT * FROM $tableName ORDER BY orderId DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    default:
      $result = ["msg" => "table_not_found"];
      break;
  }
} else {
  $result = ["msg" => "table_not_allowed_list"];
}

echo json_encode($result, JSON_PRETTY_PRINT);
