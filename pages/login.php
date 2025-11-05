<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

$email = $password = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Please enter a valid email.";
  } elseif (empty($password)) {
    $error = "Password is required.";
  } else {
    $stmt = $conn->prepare("SELECT id , password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $stmt->bind_result($id, $hashed);
      $stmt->fetch();
      if (password_verify($password, $hashed)) {
        $_SESSION['user_id'] = $id;
        header("Location: ../admin/dashboard.php");
        exit;
      } else {
        $error = "Incorrect password.";
      }
    } else {
      $error = "User not found.";
    }
  }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4 shadow-sm">
      <h2 class="text-center mb-4">Login</h2>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>
      <form method="POST" novalidate>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email Address" required class="form-control mb-3">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-3">
        <button type="submit" class="btn btn-success w-100">Login</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
