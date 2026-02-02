<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Dashboard</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
    <?php if($this->session->userdata('role') == 'pegawai') { ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    Capaian Kinerja 
                    <?php if(isset($period_type) && $period_type == 'monthly') { 
                        $month_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        echo 'Bulan ' . ($period_value ? $month_names[$period_value] : '') . ' ';
                    } elseif(isset($period_type) && $period_type == 'quarterly') {
                        echo 'Triwulan ' . ($period_value ? $period_value : '') . ' ';
                    } else {
                        echo 'Tahunan ';
                    } ?>
                    (Tahun <?=$active_year ? $active_year->year : '-'?>)
                </h3>
                <div class="card-tools">
                    <form method="GET" action="<?=site_url('dashboard')?>" class="form-inline" id="filterForm">
                        <select name="period_type" id="period_type" class="form-control form-control-sm mr-2" onchange="updatePeriodOptions()">
                            <option value="yearly" <?=isset($period_type) && $period_type == 'yearly' ? 'selected' : ''?>>Tahunan</option>
                            <option value="quarterly" <?=isset($period_type) && $period_type == 'quarterly' ? 'selected' : ''?>>Triwulan</option>
                            <option value="monthly" <?=isset($period_type) && $period_type == 'monthly' ? 'selected' : ''?>>Bulanan</option>
                        </select>
                        <select name="period_value" id="period_value" class="form-control form-control-sm mr-2" <?=isset($period_type) && $period_type == 'yearly' ? 'disabled' : ''?>>
                            <!-- Options will be dynamically populated -->
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <?php if($active_year) { ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center" style="background-color: #f4f6f9;">
                            <th rowspan="2" style="vertical-align: middle;">NO</th>
                            <th rowspan="2" style="vertical-align: middle;">KEGIATAN TUGAS JABATAN</th>
                            <th rowspan="2" style="vertical-align: middle;">AK</th>
                            <th colspan="4">TARGET <?=isset($period_type) && $period_type == 'monthly' ? 'BULANAN' : (isset($period_type) && $period_type == 'quarterly' ? 'TRIWULAN' : 'TAHUNAN')?></th>
                            <th colspan="4">REALISASI <?=isset($period_type) && $period_type == 'monthly' ? 'BULANAN' : (isset($period_type) && $period_type == 'quarterly' ? 'TRIWULAN' : 'TAHUNAN')?></th>
                            <th rowspan="2" style="vertical-align: middle;">NILAI CAPAIAN</th>
                        </tr>
                        <tr class="text-center" style="background-color: #f4f6f9;">
                            <th>KUANT/OUTPUT</th>
                            <th>KUAL/MUTU</th>
                            <th>WAKTU</th>
                            <th>BIAYA</th>
                            <th>KUANT/OUTPUT</th>
                            <th>KUAL/MUTU</th>
                            <th>WAKTU</th>
                            <th>BIAYA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $current_indicator = '';
                        $total_capaian = 0;
                        $count_activities = 0;

                        // Calculate target divisor based on period type
                        $target_divisor = 1;
                        $time_label = '12 Bln';
                        if(isset($period_type)) {
                            if($period_type == 'monthly') {
                                $target_divisor = 12;
                                $time_label = '1 Bln';
                            } elseif($period_type == 'quarterly') {
                                $target_divisor = 4;
                                $time_label = '3 Bln';
                            }
                        }

                        if($targets && $targets->num_rows() > 0) {
                            foreach($targets->result() as $target) {
                                // Group by Indicator
                                if($target->indicator_name != $current_indicator) {
                                    echo '<tr style="background-color: #e9ecef;"><td colspan="12"><b>'.$target->indicator_name.'</b></td></tr>';
                                    $current_indicator = $target->indicator_name;
                                }

                                // Get Realization based on filter
                                $real_qty = $this->pkp_model->get_period_realization($target->id, isset($period_type) ? $period_type : 'yearly', isset($period_value) ? $period_value : null);
                                $real_qty = $real_qty ? $real_qty : 0;

                                // Calculate target for period
                                $period_target = $target->target_qty / $target_divisor;

                                // Calculate Capaian
                                $capaian = 0;
                                if($period_target > 0) {
                                    $capaian = ($real_qty / $period_target) * 100;
                                }
                                
                                // Cap at 100%
                                $capaian_display = $capaian > 100 ? 100 : $capaian;
                                
                                $total_capaian += $capaian_display;
                                $count_activities++;
                                ?>
                                <tr>
                                    <td class="text-center"><?=$no++?></td>
                                    <td><?=$target->activity_name?></td>
                                    <td class="text-center"><?=$target->target_credit_score?></td>
                                    <td class="text-center"><?=number_format($period_target, 2)?> <?=$target->target_unit?></td>
                                    <td class="text-center"><?=$target->target_quality?></td>
                                    <td class="text-center"><?=$time_label?></td>
                                    <td class="text-center">-</td>
                                    <td class="text-center"><?=$real_qty?> <?=$target->target_unit?></td>
                                    <td class="text-center"><?=number_format($capaian_display, 2)?></td>
                                    <td class="text-center"><?=$time_label?></td>
                                    <td class="text-center">-</td>
                                    <td class="text-center"><?=number_format($capaian_display, 2)?></td>
                                </tr>
                                <?php 
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11" class="text-right"><b>Rata-rata Capaian Kinerja</b></td>
                            <td class="text-center"><b><?= $count_activities > 0 ? number_format($total_capaian / $count_activities, 2) : 0 ?></b></td>
                        </tr>
                    </tfoot>
                </table>
                
                <script>
                function updatePeriodOptions() {
                    var periodType = document.getElementById('period_type').value;
                    var periodValue = document.getElementById('period_value');
                    var currentValue = '<?=isset($period_value) ? $period_value : ''?>';
                    
                    periodValue.innerHTML = '';
                    periodValue.disabled = false;
                    
                    if(periodType == 'yearly') {
                        periodValue.disabled = true;
                        periodValue.innerHTML = '<option value="">-</option>';
                    } else if(periodType == 'quarterly') {
                        for(var i = 1; i <= 4; i++) {
                            var selected = (currentValue == i && '<?=isset($period_type) ? $period_type : ''?>' == 'quarterly') ? 'selected' : '';
                            periodValue.innerHTML += '<option value="' + i + '" ' + selected + '>Triwulan ' + i + '</option>';
                        }
                    } else if(periodType == 'monthly') {
                        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        for(var i = 1; i <= 12; i++) {
                            var selected = (currentValue == i && '<?=isset($period_type) ? $period_type : ''?>' == 'monthly') ? 'selected' : '';
                            periodValue.innerHTML += '<option value="' + i + '" ' + selected + '>' + months[i-1] + '</option>';
                        }
                    }
                }
                
                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    updatePeriodOptions();
                });
                </script>
                
                <?php } else { ?>
                    <div class="alert alert-warning">Belum ada Tahun Anggaran aktif.</div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?=$count_users?></h3>
                        <p>Total Pegawai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?=site_url('admin/users')?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?=$count_units?></h3>
                        <p>Unit Kerja</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="<?=site_url('admin/master/units')?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?=$active_year ? $active_year->year : '-'?></h3>
                        <p>Tahun Anggaran Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <a href="<?=site_url('admin/master/years')?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?=$count_submitted?></h3>
                        <p>Laporan Bulan Lalu</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <a href="#" class="small-box-footer">Monitoring <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Selamat Datang</h3>
            </div>
            <div class="card-body">
                Selamat Datang di Aplikasi E-PKP (Elektronik Penilaian Kinerja Pegawai).
            </div>
        </div>
    <?php } ?>
</section>
