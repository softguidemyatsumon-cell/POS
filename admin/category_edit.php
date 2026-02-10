<?php
require '../require/common_function.php';
require '../require/common.php';
require '../require/db.php';

if (!isset($_GET['id'])) {
    header("Location: category_list.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch the category
$category = selectData('categories', $conn, "WHERE id = $id", '*')->fetch_assoc();

if (!$category) {
    echo "Category not found!";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $updateQuery = "UPDATE categories SET name='$name' WHERE id=$id";

    if ($conn->query($updateQuery)) {
        header("Location: category_list.php");
        exit;
    } else {
        $error = "Failed to update category: " . $conn->error;
    }
}

require './layouts/header.php';
?>

<div class="container mt-4">
    <h2>Edit Category</h2>

    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($category['name']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="category_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require './layouts/footer.php'; ?>
