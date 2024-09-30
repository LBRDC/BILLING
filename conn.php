<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lbrdc-billing";
$conn = null;

try {
    $conn = new PDO("mysql:host={$host};dbname={$db};charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userId = 1;

    $stmt = $conn->prepare("SELECT * FROM admin_user WHERE admin_id = :id");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        //echo "User found: " . $user['id'];
    } else {
        echo "User not found.";
    }

    //echo "Connected successfully"; 
} catch(PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    echo "Connection failed: " . $e->getMessage();
}
