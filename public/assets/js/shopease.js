(() => {
  const rp = n => 'Rp' + n.toLocaleString('id-ID');
  const qtys = [...document.querySelectorAll('[data-qty]')];
  const total = document.getElementById('total');
  const btn = document.getElementById('checkout');
  const msg = document.getElementById('cartMsg');

  function hitung() {
    if (!total) return;
    const sum = qtys.reduce((s, q) => s + (+q.textContent) * (+q.dataset.harga), 0);
    total.textContent = rp(sum);
    btn.disabled = sum === 0;
    msg.textContent = '';
  }

  document.querySelectorAll('.cart__list li').forEach(li => {
    const q = li.querySelector('[data-qty]');
    li.querySelector('[data-inc]').addEventListener('click', () => { q.textContent = +q.textContent + 1; hitung(); });
    li.querySelector('[data-dec]').addEventListener('click', () => { q.textContent = Math.max(0, +q.textContent - 1); hitung(); });
  });

  if (btn) btn.addEventListener('click', () => {
    msg.textContent = 'Ini hanya contoh. Checkout asli tersedia setelah Anda masuk sebagai pelanggan.';
  });

  document.querySelectorAll('[data-add]').forEach(b => b.addEventListener('click', () => {
    const awal = b.textContent;
    b.textContent = 'Ditambahkan';
    setTimeout(() => (b.textContent = awal), 1200);
  }));
})();
