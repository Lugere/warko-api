<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$body       = file_get_contents("php://input");
$object     = json_decode($body, true);
$tableName  = $object['tableName'];
$columnName = $object['columnName'];
$id         = $object['id'];

if ($tableName) {
  if (in_array($tableName, $allowedTableNames) && $id && $columnName) {
    switch ($columnName) {
      case "order_id":
        $query = "DELETE FROM $tableName WHERE order_id=:id";
        $statement = $mysql->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();
        break;

      case "product_id":
        $query = "DELETE FROM $tableName WHERE product_id=:id";
        $statement = $mysql->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();
        break;

      default:
        $result = ["msg" => "table_does_no_exist_or_cannot_be_changed"];
    }
  } else $result = ["msg" => "table_not_allowed_list"];
} else $result = ["msg" => "table_name_undefined"];

echo json_encode($result, JSON_PRETTY_PRINT);
