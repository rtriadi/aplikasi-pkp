<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Unit Kerja</h1>
      </div>
      <div class="col-sm-6">
        <div class="float-sm-right">
            <a href="<?=site_url('admin/master/units_add')?>" class="btn btn-primary btn-flat">
                <i class="fas fa-plus"></i> Tambah Baru
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
                <th>Nama Unit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($row->result() as $key => $data) { ?>
            <tr>
                <td style="width:5%;"><?=$no++?>.</td>
                <td><?=$data->name?></td>
                <td class="text-center" width="160px">
                    <a href="<?=site_url('admin/master/units_edit/'.$data->id)?>" class="btn btn-warning btn-xs">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </a>
                    <a href="<?=site_url('admin/master/units_del/'.$data->id)?>" onclick="return confirm('Apakah Anda yakin?')" class="btn btn-danger btn-xs">
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
