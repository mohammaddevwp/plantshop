<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
$cart = $_SESSION['cart'];
// حذف محصول از سبد
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit();
}
// ویرایش تعداد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_qty'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] = max(1, intval($qty));
        }
    }
    header('Location: cart.php');
    exit();
}
$cart = $_SESSION['cart'];
$total = 0;
foreach ($cart as $item) $total += $item['price'] * $item['qty'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید | فروشگاه گیاهان سبز</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
<div id="global-loader"><div class="spinner"></div></div>
<?php include 'partials/navbar.php'; ?>
<div class="container py-5">
    <h2 class="mb-4 text-center" data-aos="fade-down"><i class="fa fa-shopping-cart text-success me-2"></i>سبد خرید شما</h2>
    <?php if (empty($cart)): ?>
        <div class="alert alert-info text-center" data-aos="fade-up">سبد خرید شما خالی است.</div>
    <?php else: ?>
    <form method="POST" action="" data-aos="fade-up">
        <div class="table-responsive mb-4">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>محصول</th>
                        <th>قیمت</th>
                        <th>تعداد</th>
                        <th>جمع</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                    <tr>
                        <td><i class="fa fa-leaf text-success"></i> <?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price']); ?> تومان</td>
                        <td style="max-width:90px;">
                            <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['qty']; ?>" min="1" class="form-control form-control-sm text-center">
                        </td>
                        <td><?php echo number_format($item['price'] * $item['qty']); ?> تومان</td>
                        <td><a href="cart.php?remove=<?php echo $id; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button type="submit" name="update_qty" class="btn btn-outline-success"><i class="fa fa-sync-alt me-1"></i>بروزرسانی سبد</button>
            <div class="fw-bold fs-5">جمع کل: <?php echo number_format($total); ?> تومان</div>
        </div>
    </form>
    <div class="text-end" data-aos="fade-up">
        <a href="checkout.php" class="btn btn-success btn-lg"><i class="fa fa-credit-card me-2"></i>تسویه حساب</a>
    </div>
    <?php endif; ?>
</div>
<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>AOS.init();</script>
<script>
window.addEventListener('load', function() {
  document.getElementById('global-loader').style.display = 'none';
});
</script>
</body>
</html> 