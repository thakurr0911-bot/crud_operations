<?php
require_once 'database.php';
$categories = ['Category 1', 'Category 2', 'Category 3'];
$data = ['id' => '','product' => '','category' => '','phone' => '','image' => '','created_at' => ''];
$id = $_GET['id'] ?? '';
if ($id) {
    $stmt = $link->prepare("SELECT * FROM details WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();
    }
}
?>
<div class="overlay">
    <div class="container_form bg-white p-0">
        <form id="ajaxForm" method="POST" enctype="multipart/form-data" class="p-4 rounded">
            <button class="btn btn-danger btn_form_close  py-1 px-2 rounded">&times;</button>
        <h4 class="mb-3 text-center"><?= $id ? 'Edit Product' : 'Add Product' ?></h4>
            <div class="mb-3">
                <label class="form-label">Product</label>
                <input type="text" name="product" id="product" class="form-control" 
                       value="<?= htmlspecialchars($data['product']) ?>">
                <span class="text-danger error-product"></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" 
                            <?= ($data['category'] == $cat) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="text-danger error-category"></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" 
                       value="<?= htmlspecialchars($data['phone']) ?>">
                <span class="text-danger error-phone"></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                <?php if (!empty($data['image'])): ?>
                    <div class="mt-2">
                        <img src="uploads/<?= htmlspecialchars($data['image']) ?>" 
                             alt="Image" style="width:80px;height:80px;object-fit:cover;border:1px solid #ccc;">
                    </div>
                <?php endif; ?>
                <span class="text-danger error-image"></span>
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-success"><?= $id ? 'Update' : 'Submit' ?></button>
            </div>
        </form>
    </div>
</div>
