<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Pegawai</h1>
      </div>
      <div class="col-sm-6">
        <div class="float-sm-right">
            <a href="<?=site_url('admin/users/add')?>" class="btn btn-primary btn-flat">
                <i class="fas fa-plus"></i> Tambah Baru
            </a>
            <a href="<?=site_url('admin/users/import')?>" class="btn btn-success btn-flat">
                <i class="fas fa-file-excel"></i> Import
            </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered table-striped" id="table1">
        <thead>
            <tr>
                <th>#</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Unit Kerja</th>
                <th>Pangkat</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($row->result() as $key => $data) { ?>
            <tr>
                <td style="width:5%;"><?=$no++?>.</td>
                <td><?=$data->nip?></td>
                <td><?=$data->full_name?></td>
                <td><?=$data->unit_name?></td>
                <td><?=$data->rank_name?> (<?=$data->golongan?>)</td>
                <td><?=$data->position_name?></td>
                <td class="text-center" width="160px">
                    <a href="<?=site_url('admin/users/edit/'.$data->id)?>" class="btn btn-warning btn-xs">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </a>
                    <a href="<?=site_url('admin/users/del/'.$data->id)?>" onclick="return confirm('Apakah Anda yakin?')" class="btn btn-danger btn-xs">
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

<script>
  $(function () {
    $("#table1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');
  });
</script>
