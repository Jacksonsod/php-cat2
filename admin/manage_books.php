<?php
include '../includes/db.php';
include '../includes/header.php';

$search = $_GET['search'] ?? '';
$stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ?");
$like = "%$search%";
$stmt->bind_param("s", $like);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2 class="text-center mb-4">Manage Books</h2>

<form method="GET" class="mb-3">
  <input type="text" name="search" placeholder="Search by title" value="<?= htmlspecialchars($search) ?>" class="form-control mb-2">
  <button type="submit" class="btn btn-outline-primary">Search</button>
</form>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Title</th><th>Author</th><th>Price</th><th>Category</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['author']) ?></td>
        <td><?= htmlspecialchars($row['price']) ?></td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td>
          <a href="edit_book.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Edit</a>
          <a href="delete_book.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>
