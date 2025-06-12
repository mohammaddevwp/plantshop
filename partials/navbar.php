<?php
session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">گیاهان سبز</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav gap-3 me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" title="خانه"><i class="fa fa-home fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php" title="دسته‌بندی‌ها"><i class="fa fa-th-large fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php" title="محصولات"><i class="fa fa-leaf fa-lg"></i></a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link" href="cart.php" title="سبد خرید">
                        <i class="fa fa-shopping-cart fa-lg"></i>
                        <span id="cart-count" class="cart-badge" style="display:none;">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php" title="درباره ما"><i class="fa fa-info-circle fa-lg"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php" title="تماس با ما"><i class="fa fa-envelope fa-lg"></i></a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn btn-outline-success" title="پنل کاربری"><i class="fa fa-user-circle fa-lg"></i></a>
                    <a href="logout.php" class="btn btn-outline-danger" title="خروج"><i class="fa fa-sign-out-alt fa-lg"></i></a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-success" title="ورود"><i class="fa fa-sign-in-alt fa-lg"></i></a>
                    <a href="register.php" class="btn btn-success" title="ثبت‌نام"><i class="fa fa-user-plus fa-lg"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<div style="height: 70px;"></div>
<script>
// نمایش تعداد سبد خرید از localStorage/sessionStorage
function updateCartCount() {
  let count = 0;
  if (window.localStorage && localStorage.getItem('cart_count')) {
    count = parseInt(localStorage.getItem('cart_count'));
  }
  if (count > 0) {
    document.getElementById('cart-count').textContent = count;
    document.getElementById('cart-count').style.display = 'inline-block';
  } else {
    document.getElementById('cart-count').style.display = 'none';
  }
}
document.addEventListener('DOMContentLoaded', updateCartCount);
</script> 