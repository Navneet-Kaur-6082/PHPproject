<?php
// Include the database connection
include('../database/db.php');
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>You need to log in first.</p>";
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID
$book_id = $_POST['book_id']; // Get the book ID from the form

// Check if the book is already in the cart
$query = "SELECT * FROM cart WHERE user_id = '$user_id' AND book_id = '$book_id'";
$result = mysqli_query($conn, $query);

// If the book is already in the cart, update the quantity
if (mysqli_num_rows($result) > 0) {
    $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$user_id' AND book_id = '$book_id'";
    mysqli_query($conn, $update_query);
} else {
    // If the book is not in the cart, insert it
    $insert_query = "INSERT INTO cart (user_id, book_id, quantity) VALUES ('$user_id', '$book_id', 1)";
    mysqli_query($conn, $insert_query);
}

// Redirect back to the catalog page
header("Location: ../frontend/index.html");
exit();
?>
