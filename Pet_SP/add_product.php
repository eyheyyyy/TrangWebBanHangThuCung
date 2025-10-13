<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý sản phẩm</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4" style="background-color:#fff6f6;">

<h3 class="text-danger mb-4 text-center">🐾 Quản lý sản phẩm</h3>

<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab">➕ Thêm sản phẩm</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="manage-tab" data-bs-toggle="tab" data-bs-target="#manage" type="button" role="tab">⚙️ Sửa / Xóa sản phẩm</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab">📜 Lịch sử</button>
  </li>
</ul>

<div class="tab-content" id="myTabContent">

  <!-- TAB 1: THÊM SẢN PHẨM -->
  <div class="tab-pane fade show active" id="add" role="tabpanel">
    <form method="post" enctype="multipart/form-data" class="w-50">
      <div class="mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Giá</label>
        <input type="number" name="price" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Danh mục</label>
        <input type="text" name="category" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Ảnh sản phẩm</label>
        <input type="file" name="image" class="form-control" required>
      </div>

      <button type="submit" name="save" class="btn btn-danger">💾 Lưu</button>
      <a href="index.php" class="btn btn-secondary">🏠 Trang chủ</a>
    </form>

    <?php
    if (isset($_POST['save'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $price = $conn->real_escape_string($_POST['price']);
        $cat = $conn->real_escape_string($_POST['category']);

        $img_name = $_FILES['image']['name'];
        $img_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $img_name);
        $img_name = time() . "_" . $img_name;

        $upload_dir = __DIR__ . "/uploads";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $target = $upload_dir . "/" . $img_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "INSERT INTO products(name, price, category, image)
                    VALUES ('$name', '$price', '$cat', '$img_name')";
            if ($conn->query($sql)) {
                echo "<div class='alert alert-success mt-3'>✅ Đã thêm sản phẩm thành công!</div>";

                // ==== GHI LỊCH SỬ THÊM SẢN PHẨM ====
                $pid = $conn->insert_id;
                $new_arr = ['name'=>$name, 'price'=>$price, 'category'=>$cat, 'image'=>$img_name];
                $new_json = $conn->real_escape_string(json_encode($new_arr));
                $conn->query("INSERT INTO product_log (product_id, action, new_value, user_name)
                              VALUES ($pid, 'Thêm', '$new_json', 'Admin')");
            } else {
                echo "<div class='alert alert-danger mt-3'>❌ Lỗi SQL: {$conn->error}</div>";
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>❌ Lỗi tải ảnh lên!</div>";
        }
    }
    ?>
  </div>

  <!-- TAB 2: QUẢN LÝ (SỬA / XÓA) -->
  <div class="tab-pane fade" id="manage" role="tabpanel">
    <table class="table table-bordered table-hover text-center align-middle">
      <thead class="table-danger">
        <tr>
          <th>ID</th>
          <th>Ảnh</th>
          <th>Tên</th>
          <th>Giá</th>
          <th>Danh mục</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
        while($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><img src="uploads/<?= $row['image'] ?>" width="80" height="80"></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= number_format($row['price'], 0, ',', '.') ?> đ</td>
          <td><?= htmlspecialchars($row['category']) ?></td>
          <td>
            <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm này?')">🗑️ Xóa</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- TAB 3: LỊCH SỬ -->
  <div class="tab-pane fade" id="log" role="tabpanel">
    <table class="table table-bordered table-hover text-center align-middle">
      <thead class="table-danger">
        <tr>
          <th>Thời gian</th>
          <th>ID sản phẩm</th>
          <th>Hành động</th>
          <th>Giá trị cũ</th>
          <th>Giá trị mới</th>
          <th>Người thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $logs = $conn->query("SELECT * FROM product_log ORDER BY action_time DESC");
        while ($log = $logs->fetch_assoc()):
        ?>
        <tr>
          <td><?= $log['action_time'] ?></td>
          <td><?= $log['product_id'] ?></td>
          <td><?= $log['action'] ?></td>
          <td><pre><?= htmlspecialchars($log['old_value']) ?></pre></td>
          <td><pre><?= htmlspecialchars($log['new_value']) ?></pre></td>
          <td><?= $log['user_name'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $res_old = $conn->query("SELECT name, price, category, image FROM products WHERE id=$id");
    $old_row = $res_old->fetch_assoc();
    $old_json = $conn->real_escape_string(json_encode($old_row));

    $conn->query("INSERT INTO product_log(product_id, action, old_value, user_name)
                  VALUES ($id, 'Xóa', '$old_json', 'Admin')");
    $conn->query("DELETE FROM products WHERE id=$id");

    echo "<script>alert('Đã xóa sản phẩm!'); window.location='add_product.php#manage';</script>";
}

// Xử lý hiển thị form sửa
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $p = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();
    ?>
    <div class="mt-5 p-4 border rounded bg-light w-50">
      <h5 class="text-danger mb-3">✏️ Sửa sản phẩm #<?= $id ?></h5>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="mb-3">
          <label class="form-label">Tên</label>
          <input type="text" name="name_edit" value="<?= htmlspecialchars($p['name']) ?>" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Giá</label>
          <input type="number" name="price_edit" value="<?= $p['price'] ?>" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Danh mục</label>
          <input type="text" name="cat_edit" value="<?= htmlspecialchars($p['category']) ?>" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Ảnh hiện tại</label><br>
          <img src="uploads/<?= $p['image'] ?>" width="100"><br><br>
          <input type="file" name="image_edit" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-danger">💾 Cập nhật</button>
        <a href="add_product.php#manage" class="btn btn-secondary">⬅️ Quay lại</a>
      </form>
    </div>
    <?php
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $name = $conn->real_escape_string($_POST['name_edit']);
    $price = $conn->real_escape_string($_POST['price_edit']);
    $cat = $conn->real_escape_string($_POST['cat_edit']);

    $res_old = $conn->query("SELECT * FROM products WHERE id=$id");
    $old_row = $res_old->fetch_assoc();
    $old_json = $conn->real_escape_string(json_encode($old_row));

    $new_img = $old_row['image'];
    if (!empty($_FILES['image_edit']['name'])) {
        $new_img = time() . "_" . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $_FILES['image_edit']['name']);
        move_uploaded_file($_FILES['image_edit']['tmp_name'], "uploads/$new_img");
    }

    $conn->query("UPDATE products SET name='$name', price='$price', category='$cat', image='$new_img' WHERE id=$id");

    $new_arr = ['name'=>$name, 'price'=>$price, 'category'=>$cat, 'image'=>$new_img];
    $new_json = $conn->real_escape_string(json_encode($new_arr));
    $conn->query("INSERT INTO product_log(product_id, action, old_value, new_value, user_name)
                  VALUES ($id, 'Cập nhật', '$old_json', '$new_json', 'Admin')");

    echo "<script>alert('Cập nhật thành công!'); window.location='add_product.php#manage';</script>";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
