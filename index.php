<?php
define('APP_ROOT', __DIR__);
require APP_ROOT . '/lib/app.php';

$page = $_GET['p'] ?? 'home';
$allowed = ['home','libros','agregar','prestamos'];
if (!in_array($page, $allowed)) $page = 'home';

$action = $_POST['action'] ?? $_GET['action'] ?? null;

try {
  switch ($action) {
    case 'create_book':
      Books::create($_POST);
      header('Location: index.php?p=libros'); exit;
    case 'update_book':
      Books::update((int)$_POST['id'], $_POST);
      header('Location: index.php?p=libros'); exit;
    case 'delete_book':
      Books::delete((int)$_GET['id']);
      header('Location: index.php?p=libros'); exit;
    case 'create_loan':
      Loans::create((int)$_POST['book_id'], trim($_POST['user']), $_POST['out_date'], $_POST['due_date']);
      header('Location: index.php?p=prestamos'); exit;
    case 'return_loan':
      Loans::markReturned((int)$_GET['id']);
      header('Location: index.php?p=prestamos'); exit;
  }
} catch (Throwable $e) {
  $flash_error = $e->getMessage();
}

require APP_ROOT . '/partials/header.php';
require APP_ROOT . "/pages/{$page}.php";
require APP_ROOT . '/partials/footer.php';
