<?php
session_start();
require '../require/db.php';
require '../require/common.php';

$error = false;
$email_error = $password_error = '';
$email = '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] == '1') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if ($email === '') {
        $error = true;
        $email_error = "Email is required";
    }

    if ($password === '') {
        $error = true;
        $password_error = "Password is required";
    }

    if (!$error) {
        // Check email in database
        $stmt = $conn->prepare("SELECT name, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();

            if (password_verify($password, $data['password'])) {
                // Login success
                session_regenerate_id(true);
                $_SESSION['name'] = $data['name'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['role'] = $data['role'];

                header("Location: {$admin_base_url}index.php?success=Login Success");
                exit;
            } else {
                $password_error = "Password is incorrect.";
            }
        } else {
            $email_error = "Email is not registered.";
        }
    }
}
?>
<!DOCTYPE html>
<html class="h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>POS Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="h-100">

<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content">
                    <?php if ($success !== '') { ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php } ?>
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5">
                            <a class="text-center" href="index.html"><h1>Login Form</h1></a>
                            <form method="POST" class="mt-5 mb-5 login-input">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                    <span class="text-danger"><?php echo $email_error; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                    <span class="text-danger"><?php echo $password_error; ?></span>
                                </div>
                                <input type="hidden" name="form_sub" value="1">
                                <button class="btn login-form__btn submit w-100">Sign In</button>
                            </form>
                            <p class="mt-5 login-form__footer">
                                Don't have an account? <a href="<?php echo $admin_base_url ?>register.php" class="text-primary">Sign Up</a> now
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="plugins/common/common.min.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/settings.js"></script>
<script src="js/gleek.js"></script>
<script src="js/styleSwitcher.js"></script>
</body>
</html>
