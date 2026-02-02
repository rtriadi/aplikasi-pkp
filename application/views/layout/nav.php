<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Dashboard -->
    <li class="nav-item">
        <a href="<?= site_url('dashboard') ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Beranda</p>
        </a>
    </li>

    <?php if($this->fungsi->user_login()->role == 'admin') { ?>
    <!-- Admin Menu -->
    <li class="nav-header">ADMINISTRATOR</li>
    
    <li class="nav-item <?= $this->uri->segment(2) == 'master' ? 'menu-open' : '' ?>">
        <a href="#" class="nav-link <?= $this->uri->segment(2) == 'master' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-database"></i>
            <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= site_url('admin/master/years') ?>" class="nav-link <?= in_array($this->uri->segment(3), ['years', 'years_add', 'years_edit']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tahun Anggaran</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/master/units') ?>" class="nav-link <?= in_array($this->uri->segment(3), ['units', 'units_add', 'units_edit']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Unit Kerja</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/master/ranks') ?>" class="nav-link <?= in_array($this->uri->segment(3), ['ranks', 'ranks_add', 'ranks_edit']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pangkat/Golongan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('admin/master/positions') ?>" class="nav-link <?= in_array($this->uri->segment(3), ['positions', 'positions_add', 'positions_edit']) ? 'active' : '' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jabatan</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="<?= site_url('admin/users') ?>" class="nav-link <?= in_array($this->uri->segment(2), ['users']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Data Pegawai</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= site_url('admin/backup') ?>" class="nav-link <?= in_array($this->uri->segment(2), ['backup']) ? 'active' : '' ?>">
            <i class="nav-icon fas fa-hdd"></i>
            <p>Backup Database</p>
        </a>
    </li>
    <?php } ?>

    <?php if($this->fungsi->user_login()->role == 'pegawai') { ?>
    <!-- Pegawai Menu -->
    <li class="nav-header">PEGAWAI</li>

    <li class="nav-item">
        <a href="<?= site_url('pegawai/target') ?>" class="nav-link <?= $this->uri->segment(2) == 'target' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-bullseye"></i>
            <p>Target Tahunan</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?= site_url('pegawai/realization') ?>" class="nav-link <?= $this->uri->segment(2) == 'realization' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Realisasi Bulanan</p>
        </a>
    </li>
    <?php } ?>

    <li class="nav-header">PENGATURAN</li>
    <li class="nav-item">
        <a href="<?= site_url('auth/logout') ?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
        </a>
    </li>
</ul>