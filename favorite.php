<?php
include 'db.php';

$action = $_GET['action'];

if ($action == 'create') {

    $cosmetic_id = $_POST['id'];

    if ($cosmetic_id > 0) {
        $sql = "INSERT INTO favorites (cosmetic_id) VALUES ('$cosmetic_id')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Recipe added to favorites"]);
        } else {
            echo json_encode(["status" => "fail", "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "fail", "message" => "Invalid recipe ID"]);
    }
}

if ($action == 'read') {
    $sql = "SELECT cosmetics.*, categories.category_name FROM cosmetics LEFT JOIN categories ON cosmetics.category_id = categories.id JOIN favorites ON cosmetics.id = favorites.cosmetic_id";
    $result = $conn->query($sql);
    $favorites = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $favorites[] = $row;
        }
        echo json_encode($favorites);
    } else {
        echo json_encode([]);
    }
}


if ($action == 'delete') {
    $cosmetic_id = $_POST['id'];

    if ($cosmetic_id > 0) {
        $sql = "DELETE FROM favorites WHERE cosmetic_id = '$cosmetic_id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Recipe removed from favorites"]);
        } else {
            echo json_encode(["status" => "fail", "message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "fail", "message" => "Invalid recipe ID"]);
    }
}

$conn->close();
?>
