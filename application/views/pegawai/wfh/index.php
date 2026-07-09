<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Laporan WFH</h1>
      </div>
      <div class="col-sm-6">
        <div class="float-sm-right">
            <a href="<?=site_url('pegawai/wfh/add')?>" class="btn btn-primary btn-flat">
                <i class="fas fa-plus"></i> Tambah Laporan WFH
            </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card card-outline card-primary">
    <div class="card-body">
      <table class="table table-bordered table-hover" id="table_wfh">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Hari / Tanggal WFH</th>
                <th style="width: 20%">Jumlah Kegiatan</th>
                <th style="width: 30%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            foreach($reports as $data) { 
            ?>
            <tr>
                <td><?=$no++?>.</td>
                <td>
                    <strong><?=hari_indo(date('D', strtotime($data->wfh_date)))?></strong>, 
                    <?=tgl_indo($data->wfh_date)?>
                </td>
                <td><?=$data->total_activities?> Kegiatan</td>
                <td class="text-center">
                    <a href="<?=site_url('pegawai/wfh/print_preview/'.$data->id)?>" target="_blank" class="btn btn-info btn-xs btn-flat">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                    <a href="<?=site_url('pegawai/wfh/export_docx/'.$data->id)?>" class="btn btn-success btn-xs btn-flat">
                        <i class="fas fa-file-word"></i> Word
                    </a>
                    <a href="<?=site_url('pegawai/wfh/edit/'.$data->id)?>" class="btn btn-warning btn-xs btn-flat">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </a>
                    <a href="<?=site_url('pegawai/wfh/delete/'.$data->id)?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Laporan WFH tanggal ini? Semua kegiatan dan screenshot lampiran akan terhapus secara permanen.')" class="btn btn-danger btn-xs btn-flat">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>
            <?php if(empty($reports)) { ?>
            <tr>
                <td colspan="4" class="text-center text-muted">Belum ada Laporan WFH yang dibuat.</td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
