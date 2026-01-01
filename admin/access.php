<?php
function getUserIP() {
    $ip = '';

    # the vulnerability is here:
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] !== '') {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] !== '') {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $_SERVER['REMOTE_ADDR'];
}

// Example usage:
if (
    !preg_match("/172\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", getUserIP())
    and getUserIP() != '127.0.0.1'
    and getUserIP() != '::1'
) {
    echo 'Access Denied';
    die;
}
?>
