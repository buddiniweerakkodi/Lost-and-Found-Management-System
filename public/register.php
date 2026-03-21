<?php
require_once '../classes/User.php';
require_once '../classes/Student.php';
require_once '../classes/Staff.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $type     = $_POST['type'];
    $id       = $_POST['id'];

    $user = new User();
    if ($user->emailExists($email)) {
        $message = "❌ This email is already registered.";
    } else {
        if ($user->register($name, $email, $password, $type)) {
            $lastId = $user->getLastInsertId();
            if ($type === 'student') {
                $student = new Student();
                $student->addStudent($lastId, $id);
            } else {
                $staff = new Staff();
                $staff->addStaff($lastId, $id);
            }
            $message = "✅ Registered successfully!";
            header("Location: login.php?success=1");
        } else {
            $message = "❌ Error occurred during registration.";
        }
    }

}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Your Reports</title>
  <link rel="stylesheet" href="../UI/styles.css">
</head>
<body>

  <div class="page-wrapper">
    
    <?php include '../UI/header.php'; ?>

    <div class="main-content">
        <form method="POST">
    <h2>Register</h2>
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    
    <select name="type" required onchange="toggleID(this.value)">
        <option value="">Select User Type</option>
        <option value="student">Student</option>
        <option value="staff">Staff</option>
    </select><br>

    <input type="text" name="id" id="idField" placeholder="Enrollment No / Staff ID" required><br>

    <button type="submit" class="btn edit-btn btn-dash">Register</button>
    <p><?= $message ?></p>
</form>
    </div>

    <?php include '../UI/footer.php'; ?>

  </div>
</body>
</html>



<script>
function toggleID(type) {
    const field = document.getElementById("idField");
    field.placeholder = type === 'student' ? "Enrollment No" : "Staff ID";
}
</script>
