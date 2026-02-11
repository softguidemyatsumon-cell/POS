<?php
$no = 1;

require '../require/common_function.php';
require '../require/common.php';
require '../require/db.php';

/* FIXED ORDER BY (column name required) */
    $res = selectData(
        'payments',
        $conn,
        '',
        '*',
        'ORDER BY id DESC'
    );
    $success = isset($_GET['success'])? $_GET['success'] :'';
    $delete_id = isset($_GET['delete_id']) ? (int)$_GET['delete_id'] : 0;
    if ($delete_id > 0) {
        deleteData('payments', $conn, "id=$delete_id");
        header("Location: payment_list.php?success=Delete Payment Success");
        exit;
    }

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
            <h1>Payment List</h1>
            <a href="<?= $admin_base_url . 'payment_create.php' ?>" class="btn btn-primary">
                Create Payment
            </a>
        </div>

        <div class="row">
            <div class="col-md-4 offset-md-8 col-sm-6 offset-sm-6">
                <?php if($success !==''){?>
                <div class="alert alert-success">
                    <?= $success ?>
                </div>
                <?php }?>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="col-1">No</th>
                                    <th class="col-5">Name</th>
                                    <th class="col-2">Created at</th>
                                    <th class="col-2">Updated at</th>
                                    <th class="col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php while ($row = $res->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= date("Y-m-d g:i:s A", strtotime($row['created_at'])) ?></td>
                                        <td><?= date("Y-m-d g:i:s A", strtotime($row['updated_at'])) ?></td>
                                        <td>
                                            <a href="<?= $admin_base_url ?>payment_edit1.php?id=<?= $row['id'] ?>" 
                                                class="btn btn-primary btn-sm me-3">
                                                    Edit
                                                </a>
                                           <button data-id="<?= $row['id'] ?>" class="btn btn-danger btn-sm delete_btn">Delete</button>                                         

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
<script>
//     Swal.fire({
//   title: 'Success!',
//   text: 'Your data has been saved.',
//   icon: 'success'
// })

$(document).ready(function () 
{
    $('.delete_btn').click(function () {
        console.log('click');
        const id =$(this).data('id');
        Swal.fire({
        title: 'Delete this record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (result.isConfirmed) {
               window.location.href = "payment_list.php?delete_id=" + id;
                // Swal.fire('Deleted!', 'Your record has been deleted.', 'success')
            }
            })
    })

})
</script>
<?php require './layouts/footer.php'; ?>
