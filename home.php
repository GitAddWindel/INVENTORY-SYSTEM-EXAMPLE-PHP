<?php  
// db connetion to xampp localhost
$servername = "localhost"; $usrname = "root"; $pass = ""; $dbname = "WaterDistrict";

// connection

$conn = new mysqli($servername, $usrname, $pass, $dbname);

// checking conn
if ($conn->connect_error) { die ("Connecting failed to process: " . $conn->connect_error); }

// conditions
// superglobal variable is equals to POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];

    // file handling for uploading images
    $targetDirectory = "equipmentFolder/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

    // checking if success
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        echo "The file ". htmlspecialchars(basename($_FILES["image"]["name"]))." has been uploaded.<br>";
        echo "Equipment Name ". htmlspecialchars($name) . "<br>";
        echo "Quantity ". htmlspecialchars($quantity) . "<br>";
        echo "Description ". htmlspecialchars($description) . "<br>"; 
    } else {
        echo "Uploading Error. Try Again bro!";
    }

    // insert into db data
    $stmt = $conn->prepare("INSERT INTO equipments (name, quantity, description, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $name, $quantity, $description, $targetFile);

    //execute
    if ($stmt->execute()) {
        echo "New equipment successfully added!";
    } else {
        echo "Failed " . $stmt->error;
    }
    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Info</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image"><br><br>
        <input type="text" name="name" placeholder="Equipment Name"><br><br>
        <input type="number" name="quantity" placeholder="Quantity"><br><br>
        <input type="text" name="description" placeholder="Equipment Description"><br><br>
        <input type="submit" name="submit" value="Add Equipment">
    </form>

    <!--- display data from db--> 


<h2>Equipment Data</h2>

<table border="1">
    <tr>
        <th>Equipment Name</th>
        <th>Quantity</th>
        <th>Description</th>
        <th>Equipment Image</th>
        <th>Actions</th>
    </tr>
    <?php 
    // db connetion to xampp localhost
$servername = "localhost"; $usrname = "root"; $pass = ""; $dbname = "WaterDistrict";

// connection

$conn = new mysqli($servername, $usrname, $pass, $dbname);

// checking conn
if ($conn->connect_error) { die ("Connecting failed to process: " . $conn->connect_error); }
    
// SQL query
$sql = "SELECT id, name, quantity, description, image_path FROM equipments";
$result = $conn->query($sql);

// if number of rows is greater than 0 retrieve the data
if ($result->num_rows > 0) {

    //data each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>"; // table row
        echo "<td>" . htmlspecialchars($row["name"]). "</td>"; // table dimension
        echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["description"]). "</td>";
        echo "<td><img src='" . htmlspecialchars($row["image_path"]) . "' alt='equipment img' style='width: 100px; height: 100px;'></td>";
        echo "<td class='action-buttons'>";
        echo "<a href='update.php?id=" . htmlspecialchars($row["id"]) . "'>Update</a>";
        echo "<a href='delete.php?id=" . htmlspecialchars($row["id"]) . "'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'> No equipment found or available</td></tr>";
}
$conn->close();
?>
</table>

</body>
</html>
