<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?=strpos($this->uri->segment(3), 'add') !== false ? 'Tambah' : 'Edit'?> Unit Kerja</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label>Nama Unit *</label>
                <input type="hidden" name="id" value="<?=isset($row) ? $row->id : ''?>">
                <input type="text" name="name" value="<?=isset($row) ? $row->name : ''?>" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-paper-plane"></i> Simpan</button>
                <button type="reset" class="btn btn-secondary btn-flat">Reset</button>
            </div>
        </form>
    </div>
  </div>
</section>
