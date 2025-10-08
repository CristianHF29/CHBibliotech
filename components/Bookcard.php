<?php
function book_card(array $b) {
  $fallback = 'data:image/svg+xml;utf8,' . rawurlencode(
    '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="630">
      <defs>
        <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0" stop-color="#fee2e2"/>
          <stop offset="1" stop-color="#fecaca"/>
        </linearGradient>
      </defs>
      <rect width="100%" height="100%" fill="url(#g)"/>
      <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
            font-family="Inter, Arial" font-size="42" fill="#b91c1c">Portada</text>
    </svg>'
  );
?>
  <article
    class="group relative rounded-2xl bg-white shadow-card overflow-hidden ring-1 ring-slate-200
           transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-brand/30"
  >
    <div class="absolute inset-x-0 top-0 h-0.5 bg-brand/70"></div>

    <div class="relative bg-slate-50 h-56 flex items-center justify-center">
      <img
        src="<?= htmlspecialchars($b['image_url'] ?: '') ?>"
        alt="Portada"
        class="w-full h-full object-contain"
        loading="lazy"
        referrerpolicy="no-referrer"
        onerror="this.onerror=null; this.src='<?= $fallback ?>'; this.classList.add('opacity-80');"
      >
      <span
        class="absolute top-2 right-2 inline-grid place-items-center rounded-full
               w-7 h-7 text-[11px] font-bold
               <?= (int)($b['copies_available'] ?? 0) > 0 ? 'bg-brand-soft text-brand' : 'bg-slate-200 text-slate-700' ?>
               border border-white/60 shadow-sm"
        title="Copias disponibles"
      >
        <?= (int)($b['copies_available'] ?? 0) ?>
      </span>
    </div>

    <div class="p-5 bg-gradient-to-b from-white to-slate-50">
      <div class="flex items-start justify-between gap-3">
        <div>
          <h3 class="text-base md:text-lg font-semibold text-slate-900 leading-tight">
            <?= htmlspecialchars($b['title']) ?>
          </h3>
          <p class="text-sm text-slate-600 mt-1">de
            <span class="font-medium"><?= htmlspecialchars($b['author']) ?></span>
          </p>
        </div>
        <span class="inline-flex items-center gap-1 rounded-full
                     <?= $b['available'] ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' ?>
                     text-[11px] font-semibold px-3 py-1 whitespace-nowrap">
          <?= $b['available'] ? 'Disponible' : 'Prestado' ?>
        </span>
      </div>

      <?php if (!empty($b['category'])): ?>
        <p class="mt-2 inline-flex items-center text-[11px] font-semibold text-brand bg-brand-soft px-2 py-0.5 rounded-full">
          <?= htmlspecialchars($b['category']) ?>
        </p>
      <?php endif; ?>

      <?php if (!empty($b['description'])): ?>
        <p class="text-sm text-slate-700 mt-3 line-clamp-3">
          <?= htmlspecialchars($b['description']) ?>
        </p>
      <?php endif; ?>

      <div class="mt-5 flex flex-wrap items-center gap-2">
        <a href="index.php?p=agregar&id=<?= (int)$b['id'] ?>"
           class="inline-flex px-3 py-2 rounded-lg border border-slate-300
                  text-slate-700 hover:border-brand hover:text-brand text-sm font-semibold">
          Editar
        </a>
        <a href="index.php?action=delete_book&id=<?= (int)$b['id'] ?>"
           onclick="return confirm('¿Eliminar libro?');"
           class="inline-flex px-3 py-2 rounded-lg border border-slate-300
                  text-slate-700 hover:border-brand hover:text-brand text-sm font-semibold">
          Eliminar
        </a>
        <?php if ($b['available']): ?>
          <a href="index.php?p=prestamos&book_id=<?= (int)$b['id'] ?>"
             class="inline-flex px-3 py-2 rounded-lg text-white bg-brand hover:bg-brand-dark text-sm font-semibold">
            Prestar
          </a>
        <?php endif; ?>
      </div>
    </div>
  </article>
<?php } ?>

