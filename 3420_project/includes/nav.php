<nav>
    <a href="index.php" class="brandcolor">
        <div class="brand-div">
            <h1>Go2Registry</h1>
        </div>
    </a>

    <ul>
        <li class="nav-item"><a href="viewlist.php">Your List</a> </li>
        <li class="nav-item"><a href="viewlist.php">Friends & Family</a> </li>
        <li class="nav-item" <?= isset($id) ? 'hidden' : ""; ?>><a href="login.php">Login</a> </li>
        <li class="nav-item" <?= isset($id) ? 'hidden' : ""; ?>><a href="register.php">Register</a> </li>
        <li class="nav-item" <?= !isset($id) ? 'hidden' : ""; ?>><a href="logout.php">Logout</a> </li>
        <li class="nav-item" <?= !isset($id) ? 'hidden' : ""; ?>><a href="settings.php">Settings</a> </li>
    </ul>
</nav>