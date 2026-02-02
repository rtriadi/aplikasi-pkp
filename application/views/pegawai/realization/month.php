<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Realisasi: <?=bulanIndo($month)?> <?=$active_year->year?></h1>
      </div>
      <div class="col-sm-6">
        <div class="float-sm-right">
            <a href="<?=site_url('pegawai/report/print_preview/'.$month)?>" target="_blank" class="btn btn-default btn-flat">
                <i class="fas fa-print"></i> Cetak Pratinjau
            </a>
            <a href="<?=site_url('pegawai/report/rekap_preview/'.$month)?>" target="_blank" class="btn btn-warning btn-flat">
                <i class="fas fa-file-alt"></i> Cetak Rekapitulasi
            </a>
            <a href="<?=site_url('pegawai/realization')?>" class="btn btn-secondary btn-flat">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="content">
    <!-- Appraiser Form -->
    <div class="card collapsed-card">
        <div class="card-header">
            <h3 class="card-title">Data Pejabat Penilai</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form action="<?=site_url('pegawai/realization/save_signature')?>" method="post">
                <input type="hidden" name="month" value="<?=$month?>">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Pejabat Penilai</h5>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="appraiser_name" value="<?=isset($signature) ? $signature->appraiser_name : ''?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="appraiser_nip" value="<?=isset($signature) ? $signature->appraiser_nip : ''?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="appraiser_position" value="<?=isset($signature) ? $signature->appraiser_position : ''?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Atasan Pejabat Penilai (Opsional)</h5>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="atasan_appraiser_name" value="<?=isset($signature) ? $signature->atasan_appraiser_name : ''?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="atasan_appraiser_nip" value="<?=isset($signature) ? $signature->atasan_appraiser_nip : ''?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="atasan_appraiser_position" value="<?=isset($signature) ? $signature->atasan_appraiser_position : ''?>" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Simpan Tanda Tangan</button>
            </form>
        </div>
    </div>

    <!-- Realization Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kegiatan</th>
                        <th>Target Kuantitas</th>
                        <th>Realisasi Kuantitas</th>
                        <th>Realisasi Kualitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $current_indicator = null;
                    foreach($targets->result() as $target) { 
                        // Get existing realization
                        $realization = $this->pkp_model->get_monthly_realization($target->id, $month)->row();

                        if($target->indicator_id != $current_indicator) {
                            $current_indicator = $target->indicator_id;
                            $indicator_name = $target->indicator_name ? $target->indicator_name : 'Tanpa Indikator';
                    ?>
                        <tr class="bg-light">
                            <td colspan="5"><strong>Indikator: <?=$indicator_name?></strong></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <?php
                        // Calculate Monthly Target based on Period
                        $monthly_target = 0;
                        if($target->target_period == 'Bulanan') {
                            $monthly_target = $target->target_qty / 12;
                        } elseif($target->target_period == 'Triwulan') {
                            $monthly_target = $target->target_qty / 4;
                        } elseif($target->target_period == 'Tahunan') {
                            $monthly_target = $target->target_qty / 1;
                        } else {
                            // Default fallback if period not set (legacy data)
                            $monthly_target = $target->target_qty / 12; 
                        }
                        
                        // Round to 2 decimals if needed, or keep precise? 
                        // User didn't specify rounding, but usually qty is integer. 
                        // If 10 / 12 = 0.83, let's keep decimals.
                        $monthly_target = round($monthly_target, 2);
                        ?>
                        <td style="padding-left: 30px;">
                            <?=$target->activity_name?> <br>
                            <small class="text-muted">(Periode: <?=$target->target_period ? $target->target_period : 'Bulanan'?>)</small>
                        </td>
                        <td><?=$monthly_target?> <?=$target->target_unit?></td>
                        <td>
                            <input type="number" step="0.01" class="form-control form-control-sm real-qty" data-id="<?=$target->id?>" data-target-qty="<?=$monthly_target?>" data-target-quality="<?=$target->target_quality?>" value="<?=isset($realization) ? $realization->real_qty : 0?>">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm real-quality" data-id="<?=$target->id?>" value="<?=isset($realization) ? $realization->real_quality : 0?>" readonly>
                        </td>
                        <td>
                            <button class="btn btn-success btn-xs btn-save" data-id="<?=$target->id?>"><i class="fas fa-save"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery to be available
    function initRealization() {
        if (typeof $ === 'undefined' || typeof jQuery === 'undefined') {
            setTimeout(initRealization, 50);
            return;
        }
        
        // Auto calculate quality
        $('.real-qty').on('input', function() {
            var id = $(this).data('id');
            var targetQty = $(this).data('target-qty');
            var targetQuality = $(this).data('target-quality');
            var realQty = $(this).val();

            if(targetQty > 0) {
                var calculatedQuality = (realQty / targetQty) * targetQuality;
                $('.real-quality[data-id="'+id+'"]').val(Math.round(calculatedQuality));
            }
        });

        $('.btn-save').click(function() {
            var id = $(this).data('id');
            var qty = $('.real-qty[data-id="'+id+'"]').val();
            var quality = $('.real-quality[data-id="'+id+'"]').val();
            var month = '<?=$month?>';

            $.ajax({
                url: '<?=site_url('pegawai/realization/save_realization')?>',
                type: 'POST',
                data: {
                    target_id: id,
                    month: month,
                    real_qty: qty,
                    real_quality: quality
                },
                success: function(response) {
                    toastr.success('Data berhasil disimpan');
                }
            });
        });
    }
    
    initRealization();
});
</script>

