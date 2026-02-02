<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Backup Database</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Beranda</a></li>
                    <li class="breadcrumb-item active">Backup Database</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-database mr-2"></i>
                            Kelola Backup Database
                        </h3>
                        <div class="card-tools">
                            <a href="<?= site_url('admin/backup/create') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Buat Backup Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($backups)) { ?>
                            <div class="alert alert-info">
                                <i class="icon fas fa-info-circle mr-2"></i>
                                Belum ada file backup. Klik tombol "Buat Backup Baru" untuk membuat backup database.
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th>Nama File</th>
                                            <th style="width: 150px;">Ukuran</th>
                                            <th style="width: 180px;">Tanggal Backup</th>
                                            <th style="width: 150px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($backups as $backup) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <i class="fas fa-file-code text-info mr-2"></i>
                                                    <?= $backup['filename'] ?>
                                                </td>
                                                <td><?= $backup['size'] ?></td>
                                                <td><?= date('d-m-Y H:i', strtotime($backup['date'])) ?></td>
                                                <td>
                                                    <a href="<?= site_url('admin/backup/download?file=' . urlencode($backup['filename'])) ?>" 
                                                       class="btn btn-success btn-sm" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <form method="POST" action="<?= site_url('admin/backup/delete') ?>" style="display:inline;">
                                                        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                                                        <?= form_hidden('filename', $backup['filename']) ?>
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus file backup ini?')"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informasi Backup
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-database mr-2"></i>Informasi Database</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <td width="150">Nama Database</td>
                                        <td>: <strong><?= $this->db->database ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Server</td>
                                        <td>: <?= $this->db->hostname ?></td>
                                    </tr>
                                    <tr>
                                        <td>Driver</td>
                                        <td>: <?= $this->db->dbdriver ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-folder mr-2"></i>Informasi Penyimpanan</h5>
                                <table class="table table-sm">
                                    <tr>
                                        <td width="150">Folder Backup</td>
                                        <td>: <code><?= FCPATH ?>backups/</code></td>
                                    </tr>
                                    <tr>
                                        <td>Total File</td>
                                        <td>: <?= count($backups) ?> file</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Penting!</h5>
                            <ul class="mb-0">
                                <li>Backup database secara teratur untuk mencegah kehilangan data.</li>
                                <li>File backup disimpan di folder <code>backups/</code> di server.</li>
                                <li>Unduh dan simpan file backup di lokasi yang aman.</li>
                                <li>Backup menggunakan format SQL yang dapat diimport kembali ke database.</li>
                                <li>Minimal 1 menit antara setiap backup untuk mencegah spam.</li>
                                <li>Hanya file dengan format nama yang valid yang dapat diakses.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
