<?php
include '../includes/db.php';
include '../includes/header.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = trim($_POST['title']);
  $author = trim($_POST['author']);
  $price = floatval($_POST['price']);
  $category = trim($_POST['category']);

  if ($title && $author && $price && $category) {
    $stmt = $conn->prepare("INSERT INTO books (title, author, price, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $title, $author, $price, $category);
    $stmt->execute();
    $success = "Book added successfully!";
  } else {
    $error = "All fields are required.";
  }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4 shadow-sm">
      <h2 class="text-center mb-4">Add Book</h2>
      <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
      <form method="POST" novalidate>
        <input type="text" name="title" placeholder="Title" required class="form-control mb-3">
        <input type="text" name="author" placeholder="Author" required class="form-control mb-3">
        <input type="number" step="0.01" name="price" placeholder="Price" required class="form-control mb-3">
        <input type="text" name="category" placeholder="Category" required class="form-control mb-3">
        <button type="submit" class="btn btn-primary w-100">Add Book</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
