<?php $s = Books::stats(); require_once __DIR__ . '/../components/BookCard.php'; ?>

<section class="grid md:grid-cols-2 gap-8 items-center">
  <div>
    <span class="inline-flex items-center text-xs font-semibold uppercase tracking-wider text-brand bg-brand-soft px-3 py-1 rounded-full">Sistema de Biblioteca</span>
    <h1 class="mt-4 text-3xl md:text-4xl font-extrabold text-slate-900">Gestión de libros</h1>
    <p class="mt-3 text-slate-700">
      Agrega, edita, busca y presta libros. Todo con un diseño limpio y acento rojo elegante.
    </p>
    <div class="mt-6 flex gap-3">
      <a href="index.php?p=agregar" class="inline-flex px-5 py-3 rounded-xl text-white bg-brand hover:bg-brand-dark font-semibold">Agregar libro</a>
      <a href="index.php?p=libros" class="inline-flex px-5 py-3 rounded-xl border border-slate-300 text-slate-800 hover:border-brand hover:text-brand font-semibold">Ver catálogo</a>
    </div>
  </div>

  <!-- Tarjeta de Resumen -->
  <div class="rounded-2xl bg-white p-6 shadow-card ring-1 ring-slate-200">
    <h3 class="font-semibold text-slate-900 mb-4">Resumen</h3>
    <div class="grid grid-cols-3 gap-4">
      <div class="rounded-xl bg-brand-soft p-4 text-center">
        <div class="text-2xl font-bold text-brand"><?= $s['total'] ?></div>
        <div class="text-xs text-slate-600">Libros</div>
      </div>
      <div class="rounded-xl bg-slate-100 p-4 text-center">
        <div class="text-2xl font-bold text-slate-900"><?= $s['available'] ?></div>
        <div class="text-xs text-slate-600">Disponibles</div>
      </div>
      <div class="rounded-xl bg-slate-100 p-4 text-center">
        <div class="text-2xl font-bold text-slate-900"><?= $s['loans'] ?></div>
        <div class="text-xs text-slate-600">Préstamos activos</div>
      </div>
    </div>
  </div>
</section>

<!-- HERO con efecto “linterna/spotlight” -->
<section class="mt-10 relative">
  <div class="relative rounded-2xl overflow-hidden ring-1 ring-slate-200 shadow-card group" data-spotlight>
    
    <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=1600&auto=format&fit=crop"
         alt="Biblioteca" class="w-full h-80 object-cover">

    <!-- Capa oscura que se “abre” con una máscara radial en el mouse -->
    <div class="absolute inset-0 bg-black/70 transition-opacity duration-300"
         style="--x:50%; --y:50%;
         -webkit-mask-image: radial-gradient(180px circle at var(--x) var(--y), transparent 0, black 65%);
                 mask-image: radial-gradient(180px circle at var(--x) var(--y), transparent 0, black 65%);">
    </div>

    
    <div class="pointer-events-none absolute inset-0 p-8 flex flex-col items-start justify-end">
      <span class="text-white/80 text-sm font-semibold">Explora el catálogo</span>
      <h2 class="text-white text-3xl font-extrabold drop-shadow">Ilumina tu próxima lectura</h2>
      <p class="text-white/80">Pasa el mouse sobre la imagen para “encender” la linterna.</p>
    </div>
  </div>
</section>

<?php
  $todos = Books::all();
  $novedades = array_slice($todos, 0, 6);
?>
<section class="mt-10">
  <div class="mb-4 flex items-center justify-between">
    <h3 class="text-xl font-bold text-slate-900">Novedades</h3>
    <a href="index.php?p=libros" class="text-brand hover:text-brand-dark font-semibold text-sm">Ver todo</a>
  </div>

  <?php if (empty($novedades)): ?>
    <p class="text-slate-600">Aún no has agregado libros. ¡Empieza ahora!</p>
  <?php else: ?>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($novedades as $b) { book_card($b); } ?>
    </div>
  <?php endif; ?>
</section>


