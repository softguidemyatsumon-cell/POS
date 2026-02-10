<?php
$no = 1;

require '../require/common_function.php';
require '../require/common.php';
require '../require/db.php';

/* FIXED ORDER BY (column name required) */
$res = selectData(
    'categories',
    $conn,
    '',
    'id, name',
    'ORDER BY id DESC'
);

require './layouts/header.php';
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="justify-content-between d-flex mb-3">
            <h1>Category List</h1>
            <a href="<?= $admin_base_url . 'category_create.php' ?>" class="btn btn-primary">
                Create Category
            </a>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php while ($row = $res->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td>
                                            <a href="category_edit.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm me-3">
                                                Edit
                                            </a>
                                            <a href="category_delete.php?id=<?= $row['id']; ?>" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                Delete
                                                </a>

                                           

                                        </td>
                                    </tr>
                                <?php endwhile; ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

<?php require './layouts/footer.php'; ?>
