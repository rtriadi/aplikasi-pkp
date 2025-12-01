<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?=strpos($this->uri->segment(3), 'add') !== false ? 'Tambah' : 'Edit'?> Tahun Anggaran</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label>Tahun *</label>
                <input type="hidden" name="id" value="<?=isset($row) ? $row->id : ''?>">
                <input type="number" name="year" value="<?=isset($row) ? $row->year : ''?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" <?=isset($row) && $row->is_active == 1 ? 'checked' : ''?>>
                    <label class="form-check-label">Aktif</label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-paper-plane"></i> Simpan</button>
                <button type="reset" class="btn btn-secondary btn-flat">Reset</button>
            </div>
        </form>
    </div>
  </div>
</section>
