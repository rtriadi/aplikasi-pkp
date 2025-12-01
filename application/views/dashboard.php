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
            <div class="card-header">
                <h3 class="card-title">Capaian Kinerja Tahunan (Tahun <?=$active_year ? $active_year->year : '-'?>)</h3>
            </div>
            <div class="card-body">
                <?php if($active_year) { ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center" style="background-color: #f4f6f9;">
                            <th rowspan="2" style="vertical-align: middle;">NO</th>
                            <th rowspan="2" style="vertical-align: middle;">KEGIATAN TUGAS JABATAN</th>
                            <th rowspan="2" style="vertical-align: middle;">AK</th>
                            <th colspan="4">TARGET TAHUNAN</th>
                            <th colspan="4">REALISASI TAHUNAN</th>
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

                        if($targets && $targets->num_rows() > 0) {
                            foreach($targets->result() as $target) {
                                // Group by Indicator
                                if($target->indicator_name != $current_indicator) {
                                    echo '<tr style="background-color: #e9ecef;"><td colspan="12"><b>'.$target->indicator_name.'</b></td></tr>';
                                    $current_indicator = $target->indicator_name;
                                }

                                // Get Annual Realization
                                $annual_real_qty = $this->pkp_model->get_annual_realization($target->id);
                                $annual_real_qty = $annual_real_qty ? $annual_real_qty : 0;

                                // Calculate Capaian
                                $capaian = 0;
                                if($target->target_qty > 0) {
                                    $capaian = ($annual_real_qty / $target->target_qty) * 100;
                                }
                                $total_capaian += $capaian;
                                $count_activities++;
                                ?>
                                <tr>
                                    <td class="text-center"><?=$no++?></td>
                                    <td><?=$target->activity_name?></td>
                                    <td class="text-center"><?=$target->target_credit_score?></td>
                                    <td class="text-center"><?=$target->target_qty?> <?=$target->target_unit?></td>
                                    <td class="text-center"><?=$target->target_quality?></td>
                                    <td class="text-center">12 Bln</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center"><?=$annual_real_qty?> <?=$target->target_unit?></td>
                                    <td class="text-center"><?=number_format($capaian, 2)?></td>
                                    <td class="text-center">12 Bln</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center"><?=number_format($capaian, 2)?></td>
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
