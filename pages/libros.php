<?php
require_once APP_ROOT . '/components/bookcard.php';
$q = isset($_GET['q']) ? trim($_GET['q']) : null;
$libros = Books::all($q);
?>
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <h2 class="text-2xl font-bold text-slate-900">Catálogo de libros</h2>
  <form action="index.php" method="get" class="flex gap-2">
    <input type="hidden" name="p" value="libros">
    <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Buscar título, autor o categoría..."
           class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand">
    <button class="px-4 py-2 rounded-lg bg-brand hover:bg-brand-dark text-white text-sm font-semibold">Buscar</button>
  </form>
</div>

<?php if (empty($libros)): ?>
  <p class="text-slate-600">No hay libros que coincidan.</p>
<?php else: ?>
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($libros as $b) { book_card($b); } ?>
  </div>
<?php endif; ?>

