<?php
require '../require/db.php';
require '../require/common.php';

$error = false;
$name_error = $email_error = $phone_error = $password_error = $confirm_password_error = '';
$name = $email = $phone = $gender = $password = $confirm_password = '';

if (isset($_POST['form_sub']) && $_POST['form_sub'] === "1") {

    // Trim inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Name validation
    if ($name === '') {
        $error = true;
        $name_error = "Name is required.";
    }

    // Email validation
    if ($email === '') {
        $error = true;
        $email_error = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Invalid email format.";
    }

    // Phone validation
    if ($phone === '') {
        $error = true;
        $phone_error = "Phone is required.";
    }

    // Password validation
    if ($password === '') {
        $error = true;
        $password_error = "Password is required.";
    } elseif (strlen($password) < 8) {
        $error = true;
        $password_error = "Password must be at least 8 characters.";
    }

    // Confirm password validation
    if ($password !== $confirm_password) {
        $error = true;
        $confirm_password_error = "Password and confirm password do not match.";
    }

    if (!$error) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = true;
            $email_error = "Email is already registered.";
        } else {
            // Hash password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $stmt_insert = $conn->prepare(
                "INSERT INTO users (name, email, password, role, phone, gender) VALUES (?, ?, ?, 'user', ?, ?)"
            );
            $stmt_insert->bind_param("sssss", $name, $email, $hashed_password, $phone, $gender);
            $result = $stmt_insert->execute();

            if ($result) {
                $url = $admin_base_url . 'login.php?success=Register Success';
                header("Location: $url");
                exit;
            } else {
                $error = true;
                $email_error = "Something went wrong. Please try again.";
            }
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
    <title>Register Form</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="h-100">
<div class="login-form-bg h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-xl-6">
                <div class="form-input-content">
                    <div class="card login-form mb-0">
                        <div class="card-body pt-5">
                            <a class="text-center" href="index.html"><h1>Register Form</h1></a>
                            <form class="mt-5 mb-5 login-input" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                                    <span class="text-danger"><?php echo $name_error; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                    <span class="text-danger"><?php echo $email_error; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                                    <span class="text-danger"><?php echo $phone_error; ?></span>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php if($gender==='male') echo 'checked'; ?>>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php if($gender==='female') echo 'checked'; ?>>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                    <span class="text-danger"><?php echo $password_error; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                                    <span class="text-danger"><?php echo $confirm_password_error; ?></span>
                                </div>
                                <button class="btn login-form__btn submit w-100">Sign Up</button>
                                <input type="hidden" name="form_sub" value="1">
                            </form>
                            <p class="mt-5 login-form__footer">Already have an account? <a href="<?php echo $admin_base_url ?>login.php" class="text-primary">Sign In</a></p>
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
