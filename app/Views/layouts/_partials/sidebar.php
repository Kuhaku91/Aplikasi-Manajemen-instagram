    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
      <div class="sidebar-brand d-none d-md-flex logo">
        <strong>Digital Marketing PFI</strong>
      </div>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="<?= base_url('/'); ?>">
          <i class="fas fa-home nav-icon"></i> Home</a>
        </li>
        <?php if(session('hak_akses_pengguna') == 'Admin') :?>
        <li class="nav-title">Master</li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('akun') ?>">
            <i class="fas fa-dollar-sign nav-icon"></i>Akun
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('produk') ?>">
            <i class="fas fa-box nav-icon"></i>Produk
          </a>
        </li> 
        <li class="nav-title">Transaksi</li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('transaksi-tunai') ?>">
            <i class="fas fa-money-bill nav-icon"></i>Transaksi Tunai
          </a>
        </li> 
        <li class="nav-divider"></li>
        <?php endif; ?>
        <li class="nav-title">Laporan</li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('laporan-penjualan') ?>">
            <i class="fas fa-receipt nav-icon"></i>Laporan Penjualan
          </a>
        </li> 
        <?php if(session('hak_akses_pengguna') == 'Pemilik') : ?>   
        <li class="nav-divider"></li>
        <li class="nav-title">Support</li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('pengguna'); ?>">
            <i class="fas fa-user nav-icon"></i>
            Pengguna
          </a>
        </li>
        <?php endif; ?>
      </ul>
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>