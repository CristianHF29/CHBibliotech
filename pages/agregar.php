<?php
$isEdit = isset($_GET['id']);
$book = $isEdit ? Books::find((int)$_GET['id']) : null;
?>
<h2 class="text-2xl font-bold text-slate-900 mb-6"><?= $isEdit ? 'Editar libro' : 'Agregar libro' ?></h2>

<form action="index.php" method="post" class="bg-white rounded-2xl shadow-card ring-1 ring-slate-200 p-6 max-w-2xl">
  <?php if ($isEdit): ?>
    <input type="hidden" name="action" value="update_book">
    <input type="hidden" name="id" value="<?= (int)$book['id'] ?>">
  <?php else: ?>
    <input type="hidden" name="action" value="create_book">
  <?php endif; ?>

  <div class="grid md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Título</label>
      <input class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand"
             name="title" required value="<?= htmlspecialchars($book['title'] ?? '') ?>">
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Autor</label>
      <input class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand"
             name="author" required value="<?= htmlspecialchars($book['author'] ?? '') ?>">
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Categoría</label>
      <input class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand"
             name="category" value="<?= htmlspecialchars($book['category'] ?? '') ?>">
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Año</label>
      <input type="number" min="1500" max="2100"
             class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand"
             name="year" value="<?= htmlspecialchars($book['year'] ?? '') ?>">
    </div>
  </div>

  <div class="mt-4">
    <label class="block text-sm font-medium text-slate-700 mb-1">URL de imagen (portada)</label>
    <input class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand"
           name="image_url" value="<?= htmlspecialchars($book['image_url'] ?? '') ?>">
  </div>

  <div class="mt-4">
    <label class="block text-sm font-medium text-slate-700 mb-1">Descripción</label>
    <textarea class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand"
              name="description" rows="4"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
  </div>

  <div class="mt-6 flex items-center gap-3">
    <button class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-dark text-white font-semibold">
      <?= $isEdit ? 'Guardar cambios' : 'Guardar' ?>
    </button>
    <a href="index.php?p=libros" class="px-5 py-2.5 rounded-xl border border-slate-300 hover:border-brand hover:text-brand font-semibold">Cancelar</a>
  </div>
</form>

