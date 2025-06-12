<?php
session_start();
require_once 'config/database.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}
// دریافت اطلاعات کاربر
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$cart = $_SESSION['cart'];
$total = 0;
foreach ($cart as $item) $total += $item['price'] * $item['qty'];
// ثبت سفارش
$success = false;
$order_id = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $conn->begin_transaction();
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("id", $_SESSION['user_id'], $total);
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        $ok = true;
        foreach ($cart as $item) {
            $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("iiid", $order_id, $item['id'], $item['qty'], $item['price']);
            if (!$stmt2->execute()) $ok = false;
        }
        if ($ok) {
            $conn->commit();
            $_SESSION['cart'] = [];
            $success = true;
        } else {
            $conn->rollback();
        }
    } else {
        $conn->rollback();
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسویه حساب | فروشگاه گیاهان سبز</title>
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
    <h2 class="mb-4 text-center" data-aos="fade-down"><i class="fa fa-credit-card text-success me-2"></i>تسویه حساب و فاکتور</h2>
    <?php if ($success): ?>
        <div class="alert alert-success text-center" data-aos="fade-up">
            سفارش شما با موفقیت ثبت شد.<br>
            شماره سفارش: <b>#<?php echo $order_id; ?></b>
        </div>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-outline-success"><i class="fa fa-home me-1"></i>بازگشت به پنل کاربری</a>
        </div>
    <?php else: ?>
    <form method="POST" action="" data-aos="fade-up">
        <div class="invoice-box mb-4">
            <h4 class="mb-3"><i class="fa fa-user me-2"></i>اطلاعات خریدار</h4>
            <div class="row mb-3">
                <div class="col-md-4"><b>نام:</b> <?php echo htmlspecialchars($user['name']); ?></div>
                <div class="col-md-4"><b>ایمیل:</b> <?php echo htmlspecialchars($user['email']); ?></div>
                <div class="col-md-4"><b>شماره موبایل:</b> <?php echo htmlspecialchars($user['phone']); ?></div>
            </div>
            <h4 class="mb-3"><i class="fa fa-shopping-basket me-2"></i>محصولات سفارش</h4>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>محصول</th>
                            <th>قیمت</th>
                            <th>تعداد</th>
                            <th>جمع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo number_format($item['price']); ?> تومان</td>
                            <td><?php echo $item['qty']; ?></td>
                            <td><?php echo number_format($item['price'] * $item['qty']); ?> تومان</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-end fw-bold fs-5 mt-3">جمع کل: <?php echo number_format($total); ?> تومان</div>
        </div>
        <div class="text-end">
            <button type="submit" name="checkout" class="btn btn-success btn-lg" id="checkout-btn">
                <span>ثبت سفارش</span> <i class="fa fa-check-circle me-1"></i>
            </button>
        </div>
    </form>
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
document.getElementById('checkout-btn')?.addEventListener('click', function() {
    this.classList.add('btn-loading');
    this.innerHTML = '<span>در حال ثبت سفارش...</span> <span class="spinner-border spinner-border-sm"></span>';
});
</script>
</body>
</html> 