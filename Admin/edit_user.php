<?php
include '../config.php';

// Ambil ID user dari URL
$id = $_GET['id'];

// Query untuk mendapatkan data user berdasarkan ID
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Proses update data user
if (isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $semester = $_POST['semester'];
    $ipk = $_POST['ipk'];

    $query = "UPDATE users SET username = '$username', semester = '$semester', ipk = '$ipk' 
              WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: user_management.php');
        exit();
    } else {
        echo "Gagal mengupdate user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>

    <!-- Form Edit User -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit User</h2>
        <form method="POST" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <input type="text" class="form-control" id="semester" name="semester" value="<?= $user['semester']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ipk" class="form-label">IPK</label>
                <input type="number" class="form-control" id="ipk" name="ipk" step="0.01" value="<?= $user['ipk']; ?>" required>
            </div>
            <div class="d-flex justify-content-start gap-2">
                <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                <a href="user_management.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
