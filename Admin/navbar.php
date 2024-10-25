<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_management.php">User Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Approval_beasiswa.php">Approval Beasiswa</a>
                </li>
            </ul>
             <!-- Logout Button -->
             <form class="d-flex" method="POST" action="../logout.php">
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>

        </div>
    </div>
</nav>

<style>
    .navbar.sticky-top {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
