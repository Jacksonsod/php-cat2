<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Optional: restrict access to admin only
// if ($_SESSION['role'] !== 'admin') {
//   header("Location: ../pages/dashboard.php");
//   exit;
// }

// Fetch books
$books = $conn->query("SELECT * FROM books ORDER BY id DESC");

// Fetch borrowed books
$borrowed = $conn->query("
  SELECT b.title, b.author, u.name AS borrower, br.borrow_date
  FROM borrowings br
  JOIN books b ON br.book_id = b.id
  JOIN users u ON br.user_id = u.id
  ORDER BY br.borrow_date DESC
");
?>

<h2 class="text-center mb-4">Admin Dashboard</h2>

<div class="row">
  <div class="col-md-6">
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Registered Books</h5>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-sm">
          <thead class="table-light">
            <tr>
              <th>Title</th><th>Author</th><th>Price</th><th>Category</th><th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($book = $books->fetch_assoc()) { ?>
              <tr>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['price']) ?></td>
                <td><?= htmlspecialchars($book['category']) ?></td>
                <td><?= $book['available'] ? 'Available' : 'Borrowed' ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <a href="manage_books.php" class="btn btn-outline-primary btn-sm mt-2">Manage Books</a>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Borrowed Books</h5>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-sm">
          <thead class="table-light">
            <tr>
              <th>Title</th><th>Author</th><th>Borrower</th><th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $borrowed->fetch_assoc()) { ?>
              <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= htmlspecialchars($row['borrower']) ?></td>
                <td><?= htmlspecialchars($row['borrow_date']) ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <a href="borrowed_books.php" class="btn btn-outline-warning btn-sm mt-2">View Full Borrow</a>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
