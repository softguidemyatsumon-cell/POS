<?php 
require '../require/common.php';
require '../require/db.php';

$name_error = $error_message ="";
$name ="";
$error = false;

if(isset($_POST['form_sub']) && $_POST['form_sub']=='1'){
    $name = $conn->real_escape_string($_POST['name']);
    if($name === ''){
        $error =true;
        $name_error ="Please fill category name.";
    }else if(strlen($name) < 3){
        $error = true;
        $name_error ="Category name must be fill at least 3";
    }else if(strlen($name) > 100){
        $error =true;
        $name_error ="Category name must be fill less than 100";
    }
    if(!$error){
       try{
        $sql = "INSERT INTO categories
        (`name`)
        VALUES
        ('$name')";
        $res = $conn->query($sql);
        if($res){
            $url =$admin_base_url .'category_list.php?success=Category Create Success';
            header("Location: $url");
            exit;
        }else{
            $error = true;
            $error_message ="Category Create Fail";
        }
       }
       catch(Exception $e){
       // var_dump($error_message);
       }
    }  
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
            <!-- row -->

            <div class="container-fluid">
                <div class="justify-content-between d-flex">
                    <h1>Category List</h1>
                    <div class=" ">
                        <a href="<?= $admin_base_url . 'category_list.php'?>" class="btn btn-dark">Back</a>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-md-6 col-sm-10 col-12">
                        <?php if($error && $error_message){?>
                        <div class="alert alert-danger">
                            Error
                        </div>
                        <?php }?>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="col-md-6 col-sm-10 col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= $admin_base_url . 'category_create.php' ?>" method="POST">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name">
                                        <span class="text-danger"><?php echo $name_error?></span>
                                    </div>
                                    <input type="hidden" name="form_sub" value="1">
                                    <button type="submit" class="btn btn-primary w-100">create</button>
                                </form>
                               
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
<?php
require './layouts/footer.php'; 
?>

       