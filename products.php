<?php
require_once 'config/database.php';
$category = isset($_GET['cat']) ? $_GET['cat'] : '';
$cat_map = [
    'apartment' => 'گیاهان آپارتمانی',
    'medical' => 'گیاهان دارویی',
    'ornamental' => 'گیاهان زینتی',
    'cactus' => 'کاکتوس‌ها',
    'flowering' => 'گیاهان گلدار',
    'hardy' => 'گیاهان مقاوم',
    'hanging' => 'گیاهان آویزی',
    'airplant' => 'گیاهان هوازی'
];
$where = '';
if ($category && isset($cat_map[$category])) {
    $where = "WHERE category = '" . $cat_map[$category] . "'";
}
$products = $conn->query("SELECT * FROM products $where ORDER BY id DESC LIMIT 20");
$sample_products = [
    [
        'name' => 'فیکوس الاستیکا',
        'price' => 350000,
        'image_url' => 'https://images.unsplash.com/photo-1512428813834-c702c7702b78',
        'description' => 'گیاه آپارتمانی مقاوم با برگ‌های براق و زیبا',
    ],
    [
        'name' => 'آلوئه ورا',
        'price' => 180000,
        'image_url' => 'https://images.unsplash.com/photo-1508610048659-a06b669e3321',
        'description' => 'گیاه دارویی با خواص درمانی فراوان',
    ],
    [
        'name' => 'کاکتوس اچینو',
        'price' => 120000,
        'image_url' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6',
        'description' => 'کاکتوس گرد و مقاوم مناسب دکوراسیون',
    ],
    [
        'name' => 'سانسوریا ابلق',
        'price' => 220000,
        'image_url' => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe',
        'description' => 'گیاه مقاوم و مناسب برای افراد پرمشغله',
    ],
    [
        'name' => 'پتوس آویزی',
        'price' => 160000,
        'image_url' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca',
        'description' => 'گیاه آویزی زیبا و مناسب فضاهای کوچک',
    ],
    [
        'name' => 'ارکیده صورتی',
        'price' => 400000,
        'image_url' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b',
        'description' => 'گیاه گلدار با گل‌های صورتی و جذاب',
    ],
    [
        'name' => 'هویا کارنوزا',
        'price' => 250000,
        'image_url' => 'https://images.unsplash.com/photo-1465101178521-c1a9136a3c5c',
        'description' => 'گیاه هوازی با نگهداری آسان',
    ],
    [
        'name' => 'زامیفولیا',
        'price' => 330000,
        'image_url' => 'https://images.unsplash.com/photo-1463154545680-d59320fd685d',
        'description' => 'گیاه مقاوم و مناسب نور کم',
    ],
    [
        'name' => 'دراسنا کامپکت',
        'price' => 210000,
        'image_url' => 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308',
        'description' => 'گیاه آپارتمانی با برگ‌های سبز تیره',
    ],
    [
        'name' => 'بنفشه آفریقایی',
        'price' => 145000,
        'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb',
        'description' => 'گیاه گلدار کوچک و مناسب میز کار',
    ],
];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محصولات | فروشگاه گیاهان سبز</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include 'partials/navbar.php'; ?>
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-down">محصولات <?php echo $category && isset($cat_map[$category]) ? $cat_map[$category] : 'فروشگاه'; ?></h2>
        <div class="row">
            <?php if($products && $products->num_rows > 0): while($product = $products->fetch_assoc()): ?>
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="card product-card h-100 shadow">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price"><?php echo number_format($product['price']); ?> تومان</span>
                            <button class="btn btn-success add-to-cart"
                                    data-id="<?php echo $product['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($product['name']); ?>"
                                    data-price="<?php echo $product['price']; ?>"
                                    data-image="<?php echo htmlspecialchars($product['image_url']); ?>">
                                <i class="fas fa-shopping-cart"></i> افزودن به سبد
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; else: foreach($sample_products as $product): ?>
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="card product-card h-100 shadow">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price"><?php echo number_format($product['price']); ?> تومان</span>
                            <button class="btn btn-success add-to-cart"
                                    data-id="0"
                                    data-name="نام محصول"
                                    data-price="0"
                                    data-image="https://via.placeholder.com/150">
                                <i class="fas fa-shopping-cart"></i> افزودن به سبد
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="assets/js/main.js"></script>
<script>AOS.init();</script>
</body>
</html> 