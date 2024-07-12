<?php
include 'db.php';

$action = $_GET['action'];

if ($action == 'read') {
    $sql = "SELECT orders.*, categories.category_name, cosmetics.image, cosmetics.name 
            FROM orders 
            LEFT JOIN cosmetics ON orders.cosmetic_id = cosmetics.id 
            LEFT JOIN categories ON cosmetics.category_id = categories.id";
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
