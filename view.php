<?php 
require_once 'database.php';

$data = []; 

if (isset($_POST['id']) && $_POST['id'] > 0) {
    $id = (int)$_POST['id'];
    $stmt = $link->prepare("SELECT * FROM details WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows) {
        $data = $result->fetch_assoc();
    }
}
?>
<div class="view_container" style="position:relative;">
    <?php if (!empty($data['image'])): ?>
        <div>
            <button class="btn btn-secondary btn-cancel-view btn-sm" style="position:absolute; top:-1%; right:9%;">&times;</button>
        <div>
            <img src="uploads/<?php echo htmlspecialchars($data['image']); ?>" alt="" style="width:90%; height:60%;"></div>
        </div>
    <?php else: ?>
        <p>No image found.</p>
        <button class="btn btn-secondary btn-cancel-view btn-sm">Back</button>
    <?php endif; ?>
</div>
