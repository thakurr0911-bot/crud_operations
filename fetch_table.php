<?php
require_once 'database.php';

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

$perPage = isset($_POST['filter_page']) && $_POST['filter_page'] != '' ? (int)$_POST['filter_page'] : 5; 
$offset = ($page - 1) * $perPage;

$where = "WHERE 1=1";
$params = [];
if(!empty($_POST['filter_product'])){
    $where .= " AND product LIKE ?";
    $params[] = "%" . $_POST['filter_product'] . "%";
}
if(!empty($_POST['filter_category'])){
    $where .= " AND category = ?";
    $params[] = $_POST['filter_category'];
}
if(!empty($_POST['filter_sku'])){
    $where .= " AND sku LIKE ?";
    $params[] = "%" . $_POST['filter_sku'] . "%";
}
if(!empty($_POST['filter_phone'])){
    $where .= " AND phone LIKE ?";
    $params[] = "%" . $_POST['filter_phone'] . "%";
}
if(!empty($_POST['filter_date'])){
    list($start,$end)=explode('|',$_POST['filter_date']);
    $where .= " AND created_at BETWEEN ? AND ?";
    $params[] =$start;
    $params[]=$end;
}

$sqlCount = "SELECT COUNT(*) as total FROM details $where";
$stmt = $link->prepare($sqlCount);
if($params){
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];

$sql = "SELECT * FROM details $where ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $link->prepare($sql);

$types = ($params ? str_repeat('s', count($params)) : '') . "ii";
$bindParams = $params;
$bindParams[] = $perPage;
$bindParams[] = $offset;

$stmt->bind_param($types, ...$bindParams);
$stmt->execute();
$result = $stmt->get_result();

$table = '';
$i = $offset + 1;
while($row = $result->fetch_assoc()){
    $img = $row['image'] 
        ? "<img src='uploads/{$row['image']}' style='width:60px;height:60px;object-fit:cover;'>" 
        : 'No Image';

    $table .= "<tr data-id='{$row['id']}'>
        <td>{$i}</td>
        <td>{$row['product']}</td>
        <td>{$row['category']}</td>
        <td>{$row['created_at']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['sku']}</td>
        <td class='image_hover'><a href='#' class='view_image' data-id='{$row['id']}'><i class='fa-solid fa-eye' style='display:none;'></i>{$img}</a></td>
        <td>
            <button class='btn btn-primary btn-sm edit_form' data-id='{$row['id']}'><i class='fa-solid fa-pen-to-square'></i></button>
            <button class='btn btn-danger btn-sm delete_form' data-id='{$row['id']}'><i class='fa-solid fa-trash'></i></button>
        </td>
    </tr>";
    $i++;
}
$totalPages = ceil($total / $perPage);
$pagination = '';

if($totalPages > 1){
    $pagination .= "<nav><ul class='pagination justify-content-end'>";
    $prevPage = max(1, $page - 1);
    $pagination .= "<li class='page-item ".($page==1?'disabled':'')."'>
        <a href='#' class='page-link' data-page='$prevPage'>Prev</a></li>";
    if($totalPages <= 3){
        for($i=1; $i<=$totalPages; $i++){
            $active = ($i==$page)?'active':'';
            $pagination .= "<li class='page-item $active'><a href='#' class='page-link' data-page='$i'>$i</a></li>";
        }
    } else {
        if($page <= 2){
            for($i=1; $i<=3; $i++){
                $active = ($i==$page)?'active':'';
                $pagination .= "<li class='page-item $active'><a href='#' class='page-link' data-page='$i'>$i</a></li>";
            }
            $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        } elseif($page >= $totalPages-1){
            $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
            for($i=$totalPages-2; $i<=$totalPages; $i++){
                $active = ($i==$page)?'active':'';
                $pagination .= "<li class='page-item $active'><a href='#' class='page-link' data-page='$i'>$i</a></li>";
            }
        } else {
            $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
            for($i=$page-1; $i<=$page+1; $i++){
                $active = ($i==$page)?'active':'';
                $pagination .= "<li class='page-item $active'><a href='#' class='page-link' data-page='$i'>$i</a></li>";
            }
            $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        }
    }
    $nextPage = min($totalPages, $page + 1);
    $pagination .= "<li class='page-item ".($page==$totalPages?'disabled':'')."'>
        <a href='#' class='page-link' data-page='$nextPage'>Next</a></li>";
    $pagination .= "</ul></nav>";
}
echo json_encode([
    'table' => $table,
    'pagination' => $pagination
]);
