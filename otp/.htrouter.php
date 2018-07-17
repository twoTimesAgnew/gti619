<?php
if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    $_GET['_url'] = $_SERVER['REQUEST_URI'];
    include_once(__DIR__ . '/public/index.php');
} else {
    return false;
}