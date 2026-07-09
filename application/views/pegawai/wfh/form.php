<?php
$is_edit = isset($report);
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?=$is_edit ? 'Edit' : 'Tambah'?> Laporan WFH</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card card-outline card-primary">
    <form action="<?=site_url('pegawai/wfh/save')?>" method="post" enctype="multipart/form-data">
      <?php if ($is_edit): ?>
        <input type="hidden" name="id" value="<?=$report->id?>">
      <?php endif; ?>
      
      <div class="card-body">
        
        <!-- Report Header Section -->
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="wfh_date">Pilih Tanggal WFH <span class="text-danger">*</span></label>
              <input type="date" name="wfh_date" id="wfh_date" class="form-control" 
                     value="<?=$is_edit ? $report->wfh_date : date('Y-m-d')?>" required>
            </div>
          </div>
        </div>

        <hr>

        <!-- Activities Section -->
        <h5><strong>Kegiatan Tugas Jabatan (WFH)</strong></h5>
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="table_activities">
            <thead>
              <tr class="bg-light">
                <th style="width: 15%">Jam Kerja <span class="text-danger">*</span></th>
                <th style="width: 45%">Deskripsi Kegiatan <span class="text-danger">*</span></th>
                <th style="width: 20%">Output / Hasil <span class="text-danger">*</span></th>
                <th style="width: 15%">Keterangan</th>
                <th style="width: 5%" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($is_edit && !empty($activities)): ?>
                <?php foreach ($activities as $idx => $act): ?>
                  <tr>
                    <td>
                      <input type="text" name="work_time[]" class="form-control" placeholder="08.00 - 10.00" value="<?=$act->work_time?>" required>
                    </td>
                    <td>
                      <textarea name="activity_description[]" class="form-control" rows="2" placeholder="Detail kegiatan..." required><?=$act->activity_description?></textarea>
                    </td>
                    <td>
                      <input type="text" name="output_result[]" class="form-control" placeholder="Screenshoot Aplikasi" value="<?=$act->output_result?>" required>
                    </td>
                    <td>
                      <input type="text" name="note[]" class="form-control" placeholder="VPN / -" value="<?=$act->note?>">
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-danger btn-sm btn-flat remove-row">
                        <i class="fas fa-times"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <!-- Default first row for new entry -->
                <tr>
                  <td>
                    <input type="text" name="work_time[]" class="form-control" placeholder="08.00 - 10.00" required>
                  </td>
                  <td>
                    <textarea name="activity_description[]" class="form-control" rows="2" placeholder="Detail kegiatan..." required></textarea>
                  </td>
                  <td>
                    <input type="text" name="output_result[]" class="form-control" placeholder="Screenshoot Aplikasi" required>
                  </td>
                  <td>
                    <input type="text" name="note[]" class="form-control" placeholder="VPN / -">
                  </td>
                  <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-flat remove-row">
                      <i class="fas fa-times"></i>
                    </button>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="mb-4">
          <button type="button" class="btn btn-success btn-sm btn-flat" id="add_row">
            <i class="fas fa-plus"></i> Tambah Baris Kegiatan
          </button>
        </div>

        <hr>

        <!-- Screenshot Uploads Section -->
        <h5><strong>Screenshots / Lampiran Bukti Dukung</strong></h5>
        <div class="form-group">
          <label for="files">Upload Foto / Gambar Laporan (Bisa memilih beberapa gambar sekaligus) <span class="text-muted">(JPG/PNG/GIF)</span></label>
          <input type="file" name="files[]" id="files" class="form-control-file" multiple accept="image/*">
        </div>

        <!-- Pre-existing Attachments for Edit View -->
        <?php if ($is_edit && !empty($attachments)): ?>
          <div class="row mt-3">
            <div class="col-12">
              <label>Lampiran Tersimpan Saat Ini:</label>
            </div>
            <?php foreach ($attachments as $att): ?>
              <div class="col-md-3 col-sm-6 text-center mb-3 attachment-box" id="attachment-<?=$att->id?>">
                <div class="card p-2 border">
                  <img src="<?=base_url('assets/uploads/wfh/'.$att->file_name)?>" class="img-fluid rounded mb-2" style="max-height: 150px; object-fit: contain;">
                  <button type="button" class="btn btn-danger btn-xs btn-flat btn-block delete-attachment" data-id="<?=$att->id?>">
                    <i class="fas fa-trash"></i> Hapus Gambar
                  </button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-flat">
          <i class="fas fa-save"></i> Simpan Laporan
        </button>
        <a href="<?=site_url('pegawai/wfh')?>" class="btn btn-default btn-flat">Batal</a>
      </div>
    </form>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic table row addition
    const addRowBtn = document.getElementById('add_row');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', function() {
            const tbody = document.querySelector('#table_activities tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = 
                '<td><input type="text" name="work_time[]" class="form-control" placeholder="08.00 - 10.00" required></td>' +
                '<td><textarea name="activity_description[]" class="form-control" rows="2" placeholder="Detail kegiatan..." required></textarea></td>' +
                '<td><input type="text" name="output_result[]" class="form-control" placeholder="Screenshoot Aplikasi" required></td>' +
                '<td><input type="text" name="note[]" class="form-control" placeholder="VPN / -"></td>' +
                '<td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-flat remove-row"><i class="fas fa-times"></i></button></td>';
            tbody.appendChild(newRow);
        });
    }

    // Remove row using event delegation
    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('remove-row') || e.target.closest('.remove-row'))) {
            const btn = e.target.classList.contains('remove-row') ? e.target : e.target.closest('.remove-row');
            const rows = document.querySelectorAll('#table_activities tbody tr');
            if (rows.length > 1) {
                btn.closest('tr').remove();
            } else {
                alert('Laporan minimal harus memiliki 1 kegiatan.');
            }
        }
    });

    // Delete existing attachment via AJAX
    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('delete-attachment') || e.target.closest('.delete-attachment'))) {
            const btn = e.target.classList.contains('delete-attachment') ? e.target : e.target.closest('.delete-attachment');
            const attId = btn.getAttribute('data-id');
            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                fetch('<?=site_url("pegawai/wfh/delete_attachment/")?>' + attId, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status === 'success') {
                        const box = document.getElementById('attachment-' + attId);
                        if (box) {
                            box.style.transition = 'opacity 0.4s';
                            box.style.opacity = '0';
                            setTimeout(() => box.remove(), 400);
                        }
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Gambar berhasil dihapus.');
                        } else {
                            alert('Gambar berhasil dihapus.');
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Gagal menghapus gambar: ' + response.message);
                        } else {
                            alert('Gagal menghapus gambar: ' + response.message);
                        }
                    }
                })
                .catch(() => {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Terjadi kesalahan jaringan.');
                    } else {
                        alert('Terjadi kesalahan jaringan.');
                    }
                });
            }
        }
    });
});
</script>
