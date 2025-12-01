<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?=ucfirst($this->uri->segment(3) == 'indicators_add' ? 'Tambah' : 'Edit')?> Indikator Kinerja</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label>Nama Indikator *</label>
                <input type="hidden" name="id" value="<?=isset($row) ? $row->id : ''?>">
                <textarea name="indicator_name" class="form-control" rows="3" required><?=isset($row) ? $row->indicator_name : ''?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-paper-plane"></i> Simpan</button>
                <button type="reset" class="btn btn-secondary btn-flat">Reset</button>
                <a href="<?=site_url('pegawai/target/indicators')?>" class="btn btn-warning btn-flat">Batal</a>
            </div>
        </form>
    </div>
  </div>
</section>
