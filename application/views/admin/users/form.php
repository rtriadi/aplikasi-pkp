<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?=ucfirst($this->uri->segment(3) == 'add' ? 'Tambah' : 'Edit')?> Pegawai</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label>NIP *</label>
                <input type="hidden" name="id" value="<?=isset($row) ? $row->id : ''?>">
                <input type="text" name="nip" value="<?=isset($row) ? $row->nip : ''?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password <?=isset($row) ? '(Kosongkan jika tidak diganti)' : '*' ?></label>
                <input type="password" name="password" class="form-control" <?=isset($row) ? '' : 'required'?>>
            </div>
            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="full_name" value="<?=isset($row) ? $row->full_name : ''?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Unit Kerja</label>
                <select name="unit_id" class="form-control">
                    <option value="">- Pilih -</option>
                    <?php foreach($units->result() as $unit) { ?>
                        <option value="<?=$unit->id?>" <?=isset($row) && $row->unit_id == $unit->id ? 'selected' : ''?>><?=$unit->name?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Pangkat/Golongan</label>
                <select name="rank_id" class="form-control">
                    <option value="">- Pilih -</option>
                    <?php foreach($ranks->result() as $rank) { ?>
                        <option value="<?=$rank->id?>" <?=isset($row) && $row->rank_id == $rank->id ? 'selected' : ''?>><?=$rank->rank_name?> - <?=$rank->golongan?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jabatan</label>
                <select name="position_id" class="form-control">
                    <option value="">- Pilih -</option>
                    <?php foreach($positions->result() as $position) { ?>
                        <option value="<?=$position->id?>" <?=isset($row) && $row->position_id == $position->id ? 'selected' : ''?>><?=$position->position_name?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-flat"><i class="fas fa-paper-plane"></i> Simpan</button>
                <button type="reset" class="btn btn-secondary btn-flat">Reset</button>
            </div>
        </form>
    </div>
  </div>
</section>
