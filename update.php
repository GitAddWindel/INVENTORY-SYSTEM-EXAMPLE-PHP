<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Info</title>
</head>
<body>
    <h2>Update Info</h2>

    <?php 
    // display data into update form
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $productId = $_GET["id"];

        include 'conn.php';

 // PDO procedural
$sql = "SELECT name, quantity, description, image_path FROM equipments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$stmt->bind_result($productName, $quantity, $description, $imagePath);
$stmt->fetch();

$stmt->close();
$conn->close(); ?>


    <form action="update_process.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($productId); ?>">
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($productName); ?>" required /> <br><br>
        <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>" required /><br><br>
        <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($description); ?>" required/>
        <input type="submit" name="submit" value="Update">
    </form> 

    <?php } else { echo "Invalid req!"; }?>
</body>
</html>
