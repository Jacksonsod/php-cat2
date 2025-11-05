<?php
include '../includes/db.php';
include '../includes/header.php';

$name = $email = $password = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  if (empty($name)) $errors[] = "Name is required.";
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
  if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";

  if (empty($errors)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed);
    if ($stmt->execute()) {
      echo "<div class='alert alert-success'>Registration successful! </a>.</div>";
      header("location:login.php");
    } else {
      echo "<div class='alert alert-danger'>Email already exists.</div>";
    }
  }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4 shadow-sm">
      <h2 class="text-center mb-4">Register</h2>
      <?php if (!empty($errors)): ?>
        <div class="alert alert-warning">
          <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
              <li><?= $error ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <form method="POST" novalidate>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="Full Name" required class="form-control mb-3">
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email Address" required class="form-control mb-3">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-3">
        <button type="submit" class="btn btn-primary w-100">Create Account</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
