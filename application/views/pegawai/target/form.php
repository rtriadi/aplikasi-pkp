<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?=ucfirst($this->uri->segment(3) == 'add' ? 'Tambah' : 'Edit')?> Target</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label>Indikator Kinerja *</label>
                <select name="indicator_id" class="form-control" required>
                    <option value="">- Pilih Indikator -</option>
                    <?php foreach($indicators->result() as $ind) { ?>
                        <option value="<?=$ind->id?>" <?=isset($row) && $row->indicator_id == $ind->id ? 'selected' : ''?>><?=$ind->indicator_name?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Kegiatan *</label>
                <input type="hidden" name="id" value="<?=isset($row) ? $row->id : ''?>">
                <textarea name="activity_name" class="form-control" rows="3" required><?=isset($row) ? $row->activity_name : ''?></textarea>
            </div>
            <div class="form-group">
                <label>Periode Target *</label>
                <select name="target_period" class="form-control" required>
                    <option value="Bulanan" <?=isset($row) && $row->target_period == 'Bulanan' ? 'selected' : ''?>>Bulanan</option>
                    <option value="Triwulan" <?=isset($row) && $row->target_period == 'Triwulan' ? 'selected' : ''?>>Triwulan</option>
                    <option value="Tahunan" <?=isset($row) && $row->target_period == 'Tahunan' ? 'selected' : ''?>>Tahunan</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Target Kuantitas *</label>
                        <input type="number" name="target_qty" value="<?=isset($row) ? $row->target_qty : ''?>" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Target Kualitas (%) *</label>
                        <input type="number" name="target_quality" value="<?=isset($row) ? $row->target_quality : '100'?>" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Satuan (misal: Dokumen) *</label>
                        <input type="text" name="target_unit" value="<?=isset($row) ? $row->target_unit : ''?>" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Angka Kredit</label>
                        <input type="number" step="0.001" name="target_credit_score" value="<?=isset($row) ? $row->target_credit_score : '0'?>" class="form-control">
                    </div>
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
