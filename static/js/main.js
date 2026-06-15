/* ── FEEDS KENYA — Main JS ── */
document.addEventListener('DOMContentLoaded', function () {
  if (window.lucide) lucide.createIcons();

  /* ── Mobile Nav ── */
  const mobileToggle = document.getElementById('mobileToggle');
  const mobileNav    = document.getElementById('mobileNav');
  if (mobileToggle && mobileNav) {
    mobileToggle.addEventListener('click', () => mobileNav.classList.toggle('open'));
    document.addEventListener('click', e => {
      if (!mobileToggle.contains(e.target) && !mobileNav.contains(e.target))
        mobileNav.classList.remove('open');
    });
  }

  /* ── User Dropdown ── */
  const userMenu = document.querySelector('.user-menu');
  if (userMenu) {
    userMenu.querySelector('.user-avatar-btn')?.addEventListener('click', e => {
      e.stopPropagation();
      userMenu.classList.toggle('open');
    });
    document.addEventListener('click', () => userMenu.classList.remove('open'));
  }

  /* ── Flash Dismiss ── */
  document.querySelectorAll('.flash-close').forEach(b =>
    b.addEventListener('click', () => b.closest('.flash').remove())
  );
  setTimeout(() => {
    document.querySelectorAll('.flash').forEach(f => {
      f.style.transition = 'opacity 0.4s, transform 0.4s';
      f.style.opacity = '0';
      f.style.transform = 'translateX(20px)';
      setTimeout(() => f.remove(), 400);
    });
  }, 5000);

  /* ── Quantity Buttons ── */
  document.querySelectorAll('.qty-input').forEach(wrap => {
    const minus = wrap.querySelector('[data-action="minus"]');
    const plus  = wrap.querySelector('[data-action="plus"]');
    const num   = wrap.querySelector('.qty-num');
    if (!minus || !plus || !num) return;
    minus.addEventListener('click', () => {
      const v = parseInt(num.value) || 1;
      if (v > 1) num.value = v - 1;
    });
    plus.addEventListener('click', () => {
      const v   = parseInt(num.value) || 1;
      const max = parseInt(num.getAttribute('max')) || 9999;
      if (v < max) num.value = v + 1;
    });
  });

  /* ── Modal ── */
  document.querySelectorAll('[data-modal-open]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.modalOpen;
      document.getElementById(id)?.classList.add('open');
    });
  });
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', e => {
      if (e.target === overlay) overlay.classList.remove('open');
    });
  });
  document.querySelectorAll('.modal-close').forEach(btn =>
    btn.addEventListener('click', () => btn.closest('.modal-overlay').classList.remove('open'))
  );

  /* ── Admin Sidebar Toggle ── */
  const sidebarToggle = document.getElementById('sidebarToggle');
  const adminSidebar  = document.getElementById('adminSidebar');
  if (sidebarToggle && adminSidebar) {
    sidebarToggle.addEventListener('click', e => {
      e.stopPropagation();
      adminSidebar.classList.toggle('open');
    });
    document.addEventListener('click', e => {
      if (window.innerWidth < 769 && adminSidebar &&
          !adminSidebar.contains(e.target) && !sidebarToggle.contains(e.target))
        adminSidebar.classList.remove('open');
    });
  }

  /* ── Print ── */
  document.getElementById('printBtn')?.addEventListener('click', () => window.print());

  /* ── Image preview on file input ── */
  document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
    input.addEventListener('change', function () {
      const preview = document.getElementById(this.dataset.preview);
      if (!preview || !this.files[0]) return;
      const reader = new FileReader();
      reader.onload = e => preview.src = e.target.result;
      reader.readAsDataURL(this.files[0]);
    });
  });

  /* ── Confirm delete ── */
  document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', e => {
      if (!confirm(btn.dataset.confirm)) e.preventDefault();
    });
  });
});
