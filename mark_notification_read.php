<?php
require_once 'admin/config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['notification_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

try {
    $notification_id = $_POST['notification_id'];
    
    $query = "UPDATE notifications SET is_read = 1 
              WHERE id = ? AND id_user = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        throw new Exception("Error preparing statement: " . mysqli_error($conn));
    }
    
    if (!mysqli_stmt_bind_param($stmt, "is", $notification_id, $_SESSION['user_id'])) {
        throw new Exception("Error binding parameters: " . mysqli_stmt_error($stmt));
    }
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Failed to update notification");
    }
    
    mysqli_stmt_close($stmt);
    
} catch(Exception $e) {
    error_log("Error in mark_notification_read.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?> 