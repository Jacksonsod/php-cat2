<?php
include '../includes/db.php';
include '../includes/header.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $author = $_POST['author'];
  $price = $_POST['price'];
  $category = $_POST['category'];

  $update = $conn->prepare("UPDATE books SET title=?, author=?, price=?, category=? WHERE id=?");
  $update->bind_param("ssdsi", $title, $author, $price, $category, $id);
  $update->execute();
  echo "<div class='alert alert-success'>Book updated successfully!</div>";
}
?>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card p-4 shadow-sm">
      <h2 class="text-center mb-4">Edit Book</h2>
      <form method="POST">
        <input type="text" name="title" value="<?= $book['title'] ?>" required class="form-control mb-3">
        <input type="text" name="author" value="<?= $book['author'] ?>" required class="form-control mb-3">
        <input type="number" step="0.01" name="price" value="<?= $book['price'] ?>" required class="form-control mb-3">
        <input type="text" name="category" value="<?= $book['category'] ?>" required class="form-control mb-3">
        <button type="submit" class="btn btn-success w-100">Update Book</button>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
