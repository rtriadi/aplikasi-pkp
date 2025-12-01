<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Realisasi Bulanan (<?=$active_year->year?>)</h1>
      </div>
    </div>
  </div>
</section>

<section class="content">
    <div class="row">
        <?php 
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        foreach($months as $num => $name) { 
        ?>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?=$name?></h3>
                    <p>Input Realisasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="<?=site_url('pegawai/realization/month/'.$num)?>" class="small-box-footer">
                    Buka <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
