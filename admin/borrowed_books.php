<?php
include '../includes/db.php';
include '../includes/header.php';

$result = $conn->query("SELECT b.title, b.author, u.name, br.borrow_date
  FROM borrowings br
  JOIN books b ON br.book_id = b.id
  JOIN users u ON br.user_id = u.id
  ORDER BY br.borrow_date DESC");
?>

<h2 class="text-center mb-4">Borrowed Books</h2>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>Book Title</th><th>Author</th><th>Borrowed By</th><th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['author']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['borrow_date']) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php include '../includes/footer.php'; ?>