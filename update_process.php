<?php

    var_dump($_POST);
// update data

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $productId = $_POST["id"];
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];

     include 'conn.php';

     // update equipments

     $sql = "UPDATE equipments SET name = ?, quantity = ?, description = ? WHERE id = ?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("sisi", $name, $quantity, $description, $productId);

     if ($stmt->execute()) {
        echo "Equipment updated successful!";
        header("Location: home.php");
        exit;

     } else {
        echo "Error: " . $stmt->error;
     }

     $stmt->close();
     $conn->close();
} else {
    echo "Invalid req!";
}

?>
