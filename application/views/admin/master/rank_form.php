<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?=strpos($this->uri->segment(3), 'add') !== false ? 'Tambah' : 'Edit'?> Pangkat</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label>Nama Pangkat *</label>
                <input type="hidden" name="id" value="<?=isset($row) ? $row->id : ''?>">
                <input type="text" name="rank_name" value="<?=isset($row) ? $row->rank_name : ''?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Golongan *</label>
                <input type="text" name="golongan" value="<?=isset($row) ? $row->golongan : ''?>" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-paper-plane"></i> Simpan</button>
                <button type="reset" class="btn btn-secondary btn-flat">Reset</button>
            </div>
        </form>
    </div>
  </div>
</section>
