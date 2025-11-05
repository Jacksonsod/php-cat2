<?php
include '../includes/db.php';
include '../includes/header.php';

$result = $conn->query("SELECT * FROM books WHERE available = 1");
?>

<h2 class="text-center mb-4">Available Books</h2>

<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['author']) ?></td>
          <td><?= htmlspecialchars($row['price']) ?></td>
          <td><?= htmlspecialchars($row['category']) ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
