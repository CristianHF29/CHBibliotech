<?php
$booksAvail = Books::available();
$loans = Loans::all();
$prefillBook = isset($_GET['book_id']) ? (int)$_GET['book_id'] : null;
?>
<h2 class="text-2xl font-bold text-slate-900 mb-6">Préstamos</h2>

<div class="bg-white rounded-2xl shadow-card ring-1 ring-slate-200 p-6 mb-8">
  <h3 class="font-semibold text-slate-900 mb-4">Nuevo préstamo</h3>
  <form action="index.php" method="post" class="grid md:grid-cols-4 gap-4 items-end">
    <input type="hidden" name="action" value="create_loan">
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-slate-700 mb-1">Libro</label>
      <select name="book_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand">
        <option value="">Selecciona un libro disponible...</option>
        <?php foreach ($booksAvail as $b): ?>
          <option value="<?= (int)$b['id'] ?>" <?= $prefillBook===(int)$b['id']?'selected':'' ?>>
            <?= htmlspecialchars($b['title']) ?> — <?= htmlspecialchars($b['author']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Usuario</label>
      <input name="user" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand" placeholder="Nombre del lector">
    </div>
    <div class="grid grid-cols-2 gap-3 md:col-span-4">
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Fecha salida</label>
        <input type="date" name="out_date" required value="<?= date('Y-m-d') ?>" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand">
      </div>
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Fecha devolución</label>
        <input type="date" name="due_date" required value="<?= date('Y-m-d', strtotime('+14 days')) ?>" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand">
      </div>
    </div>
    <div class="md:col-span-4">
      <button class="px-5 py-2.5 rounded-xl bg-brand hover:bg-brand-dark text-white font-semibold">Registrar préstamo</button>
    </div>
  </form>
</div>

<div class="bg-white rounded-2xl shadow-card ring-1 ring-slate-200 overflow-x-auto">
  <table class="min-w-full text-sm">
    <thead>
      <tr class="bg-slate-100 text-slate-700">
        <th class="text-left px-4 py-3">Libro</th>
        <th class="text-left px-4 py-3">Usuario</th>
        <th class="text-left px-4 py-3">Salida</th>
        <th class="text-left px-4 py-3">Devolución</th>
        <th class="text-left px-4 py-3">Estado</th>
        <th class="px-4 py-3"></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($loans as $r): ?>
        <tr class="border-t border-slate-200">
          <td class="px-4 py-3 font-medium text-slate-900"><?= htmlspecialchars($r['book_title']) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($r['user']) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($r['out_date']) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($r['due_date']) ?></td>
          <td class="px-4 py-3">
            <?php
              $badge = [
                'En curso' => 'bg-orange-100 text-orange-700',
                'Devuelto' => 'bg-emerald-100 text-emerald-700',
              ][$r['status']] ?? 'bg-slate-100 text-slate-700';
            ?>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $badge ?>">
              <?= htmlspecialchars($r['status']) ?>
            </span>
          </td>
          <td class="px-4 py-3 text-right">
            <?php if ($r['status'] === 'En curso'): ?>
              <a href="index.php?action=return_loan&id=<?= (int)$r['id'] ?>" class="px-3 py-1.5 rounded-lg text-white bg-brand hover:bg-brand-dark font-semibold">Marcar devuelto</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($loans)): ?>
        <tr><td colspan="6" class="px-4 py-6 text-slate-600">Sin préstamos registrados.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

