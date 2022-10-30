<?php $currentUrl = $_SERVER['REQUEST_URI']; ?>
<li class="nav-item <?= strpos($currentUrl, 'users') !== false ? 'active' : '' ?>">
    <a class="nav-link" href="../users/index.php" aria-expanded="true">
        <i class="fas fa-fw fa-table"></i>
        <span>Người dùng</span>
    </a>
</li>
<li class="nav-item <?= strpos($currentUrl, 'homeworks') !== false ? 'active' : '' ?>">
    <a class="nav-link" href="../homeworks/index.php" aria-expanded="true">
        <i class="fas fa-fw fa-table"></i>
        <span>Bài tập</span>
    </a>
</li>
<li class="nav-item <?= strpos($currentUrl, 'essays') !== false ? 'active' : '' ?>">
    <a class="nav-link" href="../essays/index.php" aria-expanded="true">
        <i class="fas fa-fw fa-table"></i>
        <span>Giải đố</span>
    </a>
</li>