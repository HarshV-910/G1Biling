<?php
session_start();
if (isset($_GET['owner_id'])) {
    $_SESSION['active_owner_id'] = intval($_GET['owner_id']);
}
header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
exit;
?>
