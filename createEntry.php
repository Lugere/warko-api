<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$body      = file_get_contents("php://input");
$object    = json_decode($body, true);
$tableName = $object['tableName'];
$entry     = $object['entry'];

if ($tableName && $entry) {
  if (in_array($tableName, $allowedTableNames)) {
    switch ($tableName) {
      case "orders":
        $query = "INSERT INTO $tableName (name, email, city, plz, street, number, phone, cart) values (:session_token, :name, :email, :city, :plz, :street, :number, :phone, :created_at, :cart)";
        $statement = $mysql->prepare($query);
        $statement->execute($entry);
        $result = $mysql->lastInsertId();
        break;

      case "products":
        $query = "INSERT INTO $tableName (description, price, image_name) values (:description, :price, :image_name)";
        $statement = $mysql->prepare($query);
        $statement->execute($entry);
        $result = $mysql->lastInsertId();
        break;

      default:
        $result = ["msg" => "table_not_found"];
        break;
    }
  } else {
    $result = ["msg" => "table_not_on_allowed_list"];
  }
} else {
  $result = ["msg" => "table_name_or_entry_undefined"];
}

echo json_encode($result, JSON_PRETTY_PRINT);
