<?php
include 'db.php';

$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$show_limit = isset($_GET['show']) ? (int)$_GET['show'] : 12;

if ($category === '') {
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $show_limit);
} else {
    $sql = "SELECT * FROM products WHERE category = ? ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $category, $show_limit);
}

$stmt->execute();
$result = $stmt->get_result();

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
        <a href="#" class="btn btn-pink btn-sm">Mua ngay</a>
      </div>
    </div>
  </div>
<?php
    endwhile;
endif;
?>
