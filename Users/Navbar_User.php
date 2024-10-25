<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 sticky-top">
    <div class="container-fluid">
        <h1 class="navbar-brand m-0">User Dashboard</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user_dashboard.php">Beasiswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="daftar_beasiswa.php">Daftar Beasiswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="hasil.php">Hasil</a>
                </li>
            </ul>

            <!-- Logout Button -->
            <form class="d-flex" method="POST" action="../logout.php">
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome (if needed for the user icon) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
