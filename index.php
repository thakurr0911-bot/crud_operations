<?php
include 'header.php';
require_once 'database.php';

$categories = ['Category 1', 'Category 2', 'Category 3'];
$product_list=[];
$result=$link->query("SELECT DISTINCT product FROM details ORDER by product ASC");
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $product_list[]=$row['product'];
    }
}
?>
<div class="container mt-5">
    <button class="btn btn-sm btn-danger add_btn"><i class="fa-solid fa-plus"></i> Add Data</button>
</div>

<div class="container mt-2">
    <form id="filterForm" class="d-flex gap-3 mb-3">
        <select name="filter_page" id="filter_page" class="form-control">
            <option value="">Select Pages</option>
            <?php $start=5; $step=5; $max=20;
            for($i=$start; $i<=$max; $i+=$step):?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
         <select name="filter_product" id="filter_product" class="form-control">
            <option value="">All Products</option>
            <?php foreach($product_list as $pro):?>
                <option value="<?= htmlspecialchars($pro) ?>"><?= htmlspecialchars($pro) ?></option>    
            <?php endforeach;
            ?>
         </select>
        <select name="filter_category" class="form-control">
            <option value="">All Categories</option>
            <?php foreach($categories as $cat): ?>
                <option value="<?= $cat ?>"><?= $cat ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="filter_date" placeholder="Select Date Range" class="form-control">
        <input type="text" name="filter_sku" placeholder="Sku" class="form-control">
        <input type="number" name="filter_phone" placeholder="Phone" class="form-control">
        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
        <button type="button" id="clearFilter" class="btn btn-secondary btn-sm">Clear</button>
    </form>
    <div class="table-container">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Created Date</th>
                    <th>Phone</th>
                    <th>SKU</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
            </tbody>
        </table>
      <div class="table-loader" style="display:none;">
        <h1 class="table_loader_text">Loading...</h1>
      </div>
    </div>
    <div id="pagination" class="text-end"></div>
</div>
<div id="viewContainer" style="display:none; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);"></div>
<div id="popupContainer"></div>

<script src="assets/script.js"></script>
<?php include 'footer.php'; ?>
