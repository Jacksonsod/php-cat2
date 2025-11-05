<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $book_id = intval($_POST['book_id']);

  // Check if book exists and is available
  $check = $conn->prepare("SELECT available FROM books WHERE id = ?");
  $check->bind_param("i", $book_id);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $check->bind_result($available);
    $check->fetch();
    if ($available) {
      $stmt = $conn->prepare("INSERT INTO borrowings (user_id, book_id) VALUES (?, ?)");
      $stmt->bind_param("ii", $_SESSION['user_id'], $book_id);
      $stmt->execute();

      $update = $conn->prepare("UPDATE books SET available = 0 WHERE id = ?");
      $update->bind_param("i", $book_id);
      $update->execute();

      $success = "Book borrowed successfully!";
    } else {
      $error = "This book is currently unavailable.";
    }
  } else {
    $error = "Book ID not found.";
  }
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4 shadow-sm">
      <h2 class="text-center mb-4">Borrow a Book</h2>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php elseif ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>
      <form method="POST" novalidate>
        <input type="number" name="book_id" placeholder="Enter Book ID" required class="form-control mb-3">
        <button type="submit" class="btn btn-warning w-100">Borrow Book</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
