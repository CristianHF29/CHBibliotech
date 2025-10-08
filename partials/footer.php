  </main>
  <footer class="border-t border-slate-200 py-6">
    <div class="max-w-6xl mx-auto px-4 flex items-center justify-between text-sm text-slate-600">
      <p>© <?= date('Y') ?> Bibliotech by Cristian Hernandez</p>
      <p>Hecho con PHP + Tailwind CSS</p>
    </div>
  </footer>

  <script>
  // Efecto “linterna”: actualiza la máscara radial según el mouse
  document.querySelectorAll('[data-spotlight]').forEach(el => {
    const layer = el.children[1]; // la capa oscura con la máscara
    function setPos(e) {
      const r = el.getBoundingClientRect();
      const x = e.clientX - r.left;
      const y = e.clientY - r.top;
      layer.style.setProperty('--x', x + 'px');
      layer.style.setProperty('--y', y + 'px');
    }
    el.addEventListener('mousemove', setPos);
    el.addEventListener('mouseenter', e => setPos(e));
    el.addEventListener('mouseleave', () => {
      // centra y baja un poco la intensidad al salir
      layer.style.setProperty('--x', '50%');
      layer.style.setProperty('--y', '50%');
    });
  });
</script>

</body>
</html>

