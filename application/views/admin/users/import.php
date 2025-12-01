<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Import Pegawai</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>File (CSV) *</label>
                <input type="file" name="file" class="form-control" required accept=".csv">
                <small class="text-muted">Format: NIP, Nama Lengkap, Password</small>
            </div>
            <div class="form-group">
                <button type="submit" name="import" class="btn btn-success btn-flat"><i class="fas fa-upload"></i> Import</button>
                <a href="<?=site_url('admin/users')?>" class="btn btn-secondary btn-flat">Batal</a>
            </div>
        </form>
    </div>
  </div>
</section>
