<?php
$titles = ['home'=>'Inicio','libros'=>'Libros','agregar'=>'Agregar Libro','prestamos'=>'Préstamos'];
$current = $_GET['p'] ?? 'home';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bibliotech · <?= htmlspecialchars($titles[$current] ?? 'Inicio') ?></title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { brand: { DEFAULT:'#dc2626', dark:'#b91c1c', soft:'#fee2e2', ring:'#fecaca' } },
          boxShadow: { card:'0 6px 24px 0 rgba(16,24,40,.08)' }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style> body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial} </style>
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-100 text-slate-800">
  <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap">
    <a href="index.php" class="flex items-center gap-2">
      <div class="h-9 w-9 grid place-items-center rounded-xl bg-brand text-white font-bold">B</div>
      <span class="font-bold text-lg">Bibliotech</span>
    </a>

    <?php
    function nav_link($slug, $label) {
      $is = (($_GET['p'] ?? 'home') === $slug);
      $base='px-2 py-2 rounded-lg text-sm font-semibold transition';
      $active='text-white bg-brand hover:bg-brand-dark';
      $idle='text-slate-700 hover:text-brand hover:bg-brand-soft';
      echo '<a class="'.$base.' '.($is?$active:$idle).'" href="index.php?p='.$slug.'">'.$label.'</a>';
    } ?>

    <nav class="flex gap-2 w-full sm:w-auto mt-3 sm:mt-0">
      <?php nav_link('home','Inicio'); ?>
      <?php nav_link('libros','Libros'); ?>
      <?php nav_link('agregar','Agregar'); ?>
      <?php nav_link('prestamos','Préstamos'); ?>
    </nav>
  </div>
</header>

  <main class="flex-1 max-w-6xl mx-auto px-4 py-8">
    <?php if (!empty($flash_error)): ?>
      <div class="mb-6 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

