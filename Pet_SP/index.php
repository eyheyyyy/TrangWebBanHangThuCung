<?php   
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'db.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Cửa hàng thú cưng</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background-color: #fff6f6; }
  .btn-pink { background-color: #ffb6c1; color: white; border: none; }
  .btn-pink:hover { background-color: #f68a9e; color: white; }
</style>
</head>
<body>

<div class="container py-4">
  <!-- HEADER -->
  <header class="d-flex justify-content-between align-items-center mb-4">
    <div><img src="logo.png" alt="Logo" height="100"></div>
    <div class="input-group w-50">
      <input type="text" class="form-control" placeholder="Tìm kiếm trong shop...">
      <button class="btn btn-pink">🔍</button>
    </div>
    <div>
      <button class="btn btn-outline-secondary">Giỏ hàng</button>
      <button class="btn btn-outline-secondary">Đăng nhập</button>
    </div>
  </header>

  <!-- DANH MỤC -->
  <div class="text-center mb-4">
    <a href="index.php?category=pate" class="btn btn-outline-danger m-1">Pate</a>
    <a href="index.php?category=thuc-an" class="btn btn-outline-danger m-1">Thức ăn</a>
    <a href="index.php?category=cat-ve-sinh" class="btn btn-outline-danger m-1">Cát vệ sinh</a>
    <a href="index.php?category=do-choi" class="btn btn-outline-danger m-1">Đồ chơi</a>
    <a href="index.php?category=nha" class="btn btn-outline-danger m-1">Nhà</a>
    <a href="index.php" class="btn btn-outline-secondary m-1">Tất cả</a>
  </div>

<?php
// ===================== XỬ LÝ DANH MỤC + GIỚI HẠN HIỂN THỊ =====================
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$show_limit = isset($_GET['show']) ? (int)$_GET['show'] : 12;

$ten_danh_muc = [
  "pate" => "Pate",
  "thuc-an" => "Thức ăn",
  "cat-ve-sinh" => "Cát vệ sinh",
  "do-choi" => "Đồ chơi",
  "nha" => "Nhà cho thú cưng"
];

$ten = "Tất cả sản phẩm";

// ✅ Nếu là “Tất cả”
if ($category === '') {
    $sql_count = "SELECT COUNT(*) AS total FROM products";
    $total = $conn->query($sql_count)->fetch_assoc()['total'];

    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $show_limit);
    $stmt->execute();
    $result = $stmt->get_result();
}

// ✅ Nếu là danh mục “thức ăn”
elseif ($category === 'thuc-an') {
    $sql_count = "SELECT COUNT(*) AS total 
                  FROM products 
                  WHERE category LIKE '%thuc%' OR category LIKE '%thức%' 
                     OR name LIKE '%thuc%' OR name LIKE '%thức%'";
    $total = $conn->query($sql_count)->fetch_assoc()['total'];

    $sql = "SELECT * FROM products 
            WHERE category LIKE '%thuc%' OR category LIKE '%thức%' 
               OR name LIKE '%thuc%' OR name LIKE '%thức%' 
            ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $show_limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $ten = "Thức ăn";
}

// ✅ Nếu là danh mục “cát vệ sinh”
elseif ($category === 'cat-ve-sinh') {
    $sql_count = "SELECT COUNT(*) AS total 
                  FROM products 
                  WHERE category LIKE '%cat%' OR category LIKE '%cát%' 
                     OR name LIKE '%cat%' OR name LIKE '%cát%'";
    $total = $conn->query($sql_count)->fetch_assoc()['total'];

    $sql = "SELECT * FROM products 
            WHERE category LIKE '%cat%' OR category LIKE '%cát%' 
               OR name LIKE '%cat%' OR name LIKE '%cát%' 
            ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $show_limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $ten = "Cát vệ sinh";
}

// ✅ Nếu là danh mục “đồ chơi”
elseif ($category === 'do-choi') {
    $sql_count = "SELECT COUNT(*) AS total 
                  FROM products 
                  WHERE category LIKE '%choi%' OR category LIKE '%chơi%' 
                     OR name LIKE '%choi%' OR name LIKE '%chơi%'";
    $total = $conn->query($sql_count)->fetch_assoc()['total'];

    $sql = "SELECT * FROM products 
            WHERE category LIKE '%choi%' OR category LIKE '%chơi%' 
               OR name LIKE '%choi%' OR name LIKE '%chơi%' 
            ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $show_limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $ten = "Đồ chơi";
}

// ✅ Nếu là danh mục “nhà”
elseif ($category === 'nha') {
    $sql_count = "SELECT COUNT(*) AS total 
                  FROM products 
                  WHERE category LIKE '%nha%' OR category LIKE '%nhà%' 
                     OR name LIKE '%nha%' OR name LIKE '%nhà%'";
    $total = $conn->query($sql_count)->fetch_assoc()['total'];

    $sql = "SELECT * FROM products 
            WHERE category LIKE '%nha%' OR category LIKE '%nhà%' 
               OR name LIKE '%nha%' OR name LIKE '%nhà%' 
            ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $show_limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $ten = "Nhà cho thú cưng";
}

// ✅ Các danh mục khác → lọc CHÍNH XÁC category
else {
    $sql_count = "SELECT COUNT(*) AS total FROM products WHERE category = ?";
    $stmt = $conn->prepare($sql_count);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];

    $sql = "SELECT * FROM products WHERE category = ? ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $category, $show_limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $ten = $ten_danh_muc[$category] ?? ucfirst(str_replace('-', ' ', $category));
}

echo "<h4 class='mb-3 text-danger fw-bold'>Sản phẩm: {$ten}</h4>";
?>

<!-- DANH SÁCH SẢN PHẨM -->
<div id="product-list" class="row">
<?php
if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
?>
  <div class="col-md-3 mb-4">
    <div class="card h-100 text-center shadow-sm">
      <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" 
           class="card-img-top p-3" height="300" style="object-fit: contain;" alt="Ảnh sản phẩm">
      <div class="card-body">
        <h6 class="text-truncate"><?php echo htmlspecialchars($row['name']); ?></h6>
        <p class="text-danger fw-bold mb-2"><?php echo number_format($row['price'],0,',','.'); ?> đ</p>
        <!-- ✅ Nút Mua ngay -->
        <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-pink btn-sm">Mua ngay</a>
      </div>
    </div>
  </div>
<?php
    endwhile;
else:
    echo "<p class='text-center text-muted'>Hiện chưa có sản phẩm nào trong danh mục này.</p>";
endif;
?>
</div>

<!-- NÚT XEM THÊM -->
<div class="text-center">
<?php
if ($show_limit < $total) {
    echo "<button id='load-more' class='btn btn-outline-danger px-4' 
            data-limit='{$show_limit}' data-category='{$category}'>Xem thêm</button>";
}
?>
</div>

</div>

<!-- JAVASCRIPT AJAX LOAD THÊM -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("load-more");
  if (!btn) return;

  btn.addEventListener("click", () => {
    let limit = parseInt(btn.dataset.limit) + 6;
    let category = btn.dataset.category;

    fetch(`load_more.php?show=${limit}&category=${category}`)
      .then(res => res.text())
      .then(html => {
        document.getElementById("product-list").innerHTML = html;
        btn.dataset.limit = limit;
        if (!html.includes("card")) {
          btn.style.display = "none";
        }
      })
      .catch(err => console.error(err));
  });
});
</script>

</body>
</html>
