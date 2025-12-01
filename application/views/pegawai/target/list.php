<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Target Tahunan (<?=$active_year->year?>)</h1>
      </div>
      <div class="col-sm-6">
        <div class="float-sm-right">
            <a href="<?=site_url('pegawai/target/indicators')?>" class="btn btn-info btn-flat">
                <i class="fas fa-list"></i> Kelola Indikator
            </a>
            <a href="<?=site_url('pegawai/target/add')?>" class="btn btn-primary btn-flat">
                <i class="fas fa-plus"></i> Tambah Target
            </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered table-hover" id="table1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Target Kuantitas</th>
                <th>Target Kualitas</th>
                <th>Satuan</th>
                <th>Angka Kredit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $current_indicator = null;
            foreach($row->result() as $key => $data) { 
                if($data->indicator_id != $current_indicator) {
                    $current_indicator = $data->indicator_id;
                    $indicator_name = $data->indicator_name ? $data->indicator_name : 'Tanpa Indikator';
            ?>
                <tr class="bg-light">
                    <td colspan="7"><strong>Indikator: <?=$indicator_name?></strong></td>
                </tr>
            <?php } ?>
            <tr>
                <td style="width:5%;"><?=$no++?>.</td>
                <td style="padding-left: 30px;"><?=$data->activity_name?></td>
                <td><?=$data->target_qty?></td>
                <td><?=$data->target_quality?></td>
                <td><?=$data->target_unit?></td>
                <td><?=$data->target_credit_score?></td>
                <td class="text-center" width="160px">
                    <a href="<?=site_url('pegawai/target/edit/'.$data->id)?>" class="btn btn-warning btn-xs">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </a>
                    <a href="<?=site_url('pegawai/target/del/'.$data->id)?>" onclick="return confirm('Apakah Anda yakin?')" class="btn btn-danger btn-xs">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
