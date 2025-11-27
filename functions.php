<?php
function validateAndInsert($data, $link) {
    $errors = [];

    $fullname = trim($data['fullname'] ?? '');
    $email = trim($data['email'] ?? '');
    $phone = trim($data['phone'] ?? '');

    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors['phone'] = "Phone must be a 10-digit number.";
    }

    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }
if($id){
       $stmt = $link->prepare("UPDATE  details SET fullname=?, email=?, phone=? WHERE id=?");
    $stmt->bind_param("sss", $fullname, $email, $phone,$id);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'data' => [
                'fullname' => htmlspecialchars($fullname),
                'email' => htmlspecialchars($email),
                'phone' => htmlspecialchars($phone),
                'id' => $id
            ]
        ];
    } else {
        return ['success' => false, 'errors' => ['database' => "Database error: " . $stmt->error]];
    }
}
    else{
    $stmt = $link->prepare("INSERT INTO details (fullname, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $phone);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'data' => [
                'fullname' => htmlspecialchars($fullname),
                'email' => htmlspecialchars($email),
                'phone' => htmlspecialchars($phone),
                'id' => $stmt->insert_id
            ]
        ];
    } else {
        return ['success' => false, 'errors' => ['database' => "Database error: " . $stmt->error]];
    }
    }
}
echo json_encode(validateAndInsert($_POST,$link));
