<?php
include 'db.php';

$action = $_GET['action'];

if ($action == 'create') {

    $cosmetic_id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $subtotal = $_POST['subtotal'];

    if ($cosmetic_id > 0) {
        $sql = "INSERT INTO orders (cosmetic_id, quantity, subtotal, date) VALUES ('$cosmetic_id','$quantity','$subtotal','$date')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "cosmetic added to orders"]);
        } else {
            echo json_encode(["status" => "fail", "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "fail", "message" => "Invalid recipe ID"]);
    }
}

if ($action == 'read') {
    $sql = "SELECT cosmetics.*, categories.category_name FROM cosmetics LEFT JOIN categories ON cosmetics.category_id = categories.id JOIN orders ON cosmetics.id = orders.cosmetic_id";
    $result = $conn->query($sql);
    $orders = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        echo json_encode($orders);
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>
