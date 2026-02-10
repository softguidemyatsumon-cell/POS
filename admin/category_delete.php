<?php
require '../require/common_function.php';
require '../require/common.php';
require '../require/db.php';

if (!isset($_GET['id'])) {
    header("Location: category_list.php");
    exit;
}

$id = intval($_GET['id']);

// Delete the category
$deleteQuery = "DELETE FROM categories WHERE id=$id";
if ($conn->query($deleteQuery)) {
    header("Location: category_list.php");
    exit;
} else {
    echo "Failed to delete category: " . $conn->error;
}
