<!DOCTYPE html>
<html>
<head>
    <title>Cetak Capaian Kinerja</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 5px; }
        .header-green { background-color: #00b050; color: white; font-weight: bold; }
        .header-yellow { background-color: #ffff00; font-weight: bold; }
        .text-center { text-align: center; }
        .no-border { border: none; }
        .title { text-align: center; font-weight: bold; margin-bottom: 20px; font-size: 14px; }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .header-green { background-color: #00b050 !important; color: white !important; }
            .header-yellow { background-color: #ffff00 !important; }
        }
    </style>
</head>
<body>

<div class="title">
    FORMULIR PENILAIAN CAPAIAN KINERJA BULANAN<br>
    PEGAWAI NEGERI SIPIL*
</div>

<div style="margin-bottom: 10px;">
    Bulan : <?=bulanIndo($month)?> <?=$active_year->year?>
</div>

<!-- Employee Info -->
<table>
    <tr>
        <td width="30">1</td>
        <td width="150">Nama</td>
        <td><?=$user->full_name?></td>
    </tr>
    <tr>
        <td>2</td>
        <td>NIP</td>
        <td><?=$user->nip?></td>
    </tr>
    <tr>
        <td>3</td>
        <td>Pangkat/Gol.Ruang</td>
        <td><?=$user->rank_name?> / <?=$user->golongan?></td>
    </tr>
    <tr>
        <td>4</td>
        <td>Jabatan</td>
        <td><?=$user->position_name?></td>
    </tr>
    <tr>
        <td>5</td>
        <td>Unit Kerja</td>
        <td><?=$user->unit_name?></td>
    </tr>
</table>

<?php
// Group targets by indicator
$indicators = [];
$targets_data = $targets->result();

foreach($targets_data as $target) {
    $ind_id = $target->indicator_id ? $target->indicator_id : 0;
    $ind_name = $target->indicator_name ? $target->indicator_name : 'KEGIATAN TAMBAHAN / LAINNYA';
    
    // Get realization
    $realization = $this->pkp_model->get_monthly_realization($target->id, $month)->row();
    $real_qty = isset($realization) ? $realization->real_qty : 0;
    $real_quality = isset($realization) ? $realization->real_quality : 0;

    // Filter: Skip if realization is 0 UNLESS show_empty is true
    if ($real_qty <= 0 && (!isset($show_empty) || !$show_empty)) {
        continue;
    }

    if(!isset($indicators[$ind_id])) {
        $indicators[$ind_id] = [
            'name' => $ind_name,
            'activities' => [],
            'total_score' => 0,
            'count' => 0
        ];
    }
    
    // Calculate Monthly Target based on Period
    $monthly_target = 0;
    if($target->target_period == 'Bulanan') {
        $monthly_target = $target->target_qty / 12;
    } elseif($target->target_period == 'Triwulan') {
        $monthly_target = $target->target_qty / 4;
    } elseif($target->target_period == 'Tahunan') {
        $monthly_target = $target->target_qty / 1;
    } else {
        // Default fallback
        $monthly_target = $target->target_qty / 12; 
    }
    
    // Round for display/calculation consistency?
    $monthly_target = round($monthly_target, 2);

    // Calculate Score (Capaian)
    if($monthly_target > 0) {
        $capaian = ($real_qty / $monthly_target) * 100;
    } else {
        $capaian = 0;
    }
    
    // Cap at 100%
    $capaian_display = $capaian > 100 ? 100 : $capaian;
    
    $indicators[$ind_id]['activities'][] = [
        'name' => $target->activity_name,
        'target_qty' => $monthly_target, // Use calculated monthly target
        'target_unit' => $target->target_unit,
        'target_quality' => $target->target_quality,
        'real_qty' => $real_qty,
        'real_unit' => $target->target_unit,
        'real_quality' => $real_quality,
        'capaian' => $capaian_display
    ];
    
    // Only include in calculation if realization is not 0 (or if it's considered valid)
    // Requirement: "tetap tampil kegiatan yang tidak ada realisasi / 0 namun tidak menjadi pembagi di REKAPITULASI"
    // So if real_qty > 0, we count it. If real_qty <= 0, we show it but don't count it for score.
    
    if ($real_qty > 0) {
        $indicators[$ind_id]['total_score'] += $capaian_display;
        $indicators[$ind_id]['count']++;
    }
}
?>

<!-- Indicators Tables -->
<?php foreach($indicators as $ind_id => $ind_data) { 
    $avg_score = $ind_data['count'] > 0 ? $ind_data['total_score'] / $ind_data['count'] : 0;
    $indicators[$ind_id]['avg_score'] = $avg_score; // Store for rekap
?>
    <div class="header-green" style="padding: 5px; border: 1px solid black; border-bottom: none;">
        INDIKATOR KINERJA : <?=strtoupper($ind_data['name'])?>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" width="30">NO</th>
                <th rowspan="2">KEGIATAN TUGAS JABATAN</th>
                <th rowspan="2" width="50">AK</th>
                <th colspan="3">TARGET</th>
                <th rowspan="2" width="50">AK</th>
                <th colspan="3">REALISASI</th>
                <th rowspan="2" width="80">NILAI CAPAIAN KINERJA</th>
            </tr>
            <tr>
                <th>KUANT/OUTPUT</th>
                <th>SATUAN</th>
                <th>KUAL/MUTU</th>
                <th>KUANT/ OUTPUT</th>
                <th>SATUAN</th>
                <th>KUAL/MUTU</th>
            </tr>
            <tr style="background-color: #f0f0f0;">
                <td class="text-center">(1)</td>
                <td class="text-center">(2)</td>
                <td class="text-center">(3)</td>
                <td class="text-center">(4)</td>
                <td class="text-center">(5)</td>
                <td class="text-center">(6)</td>
                <td class="text-center">(7)</td>
                <td class="text-center">(8)</td>
                <td class="text-center">(9)</td>
                <td class="text-center">(10)</td>
                <td class="text-center">(11)</td>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($ind_data['activities'] as $act) { ?>
            <tr>
                <td class="text-center"><?=$no++?></td>
                <td><?=$act['name']?></td>
                <td class="text-center">0,00</td>
                <td class="text-center"><?=$act['target_qty']?></td>
                <td class="text-center"><?=$act['target_unit']?></td>
                <td class="text-center"><?=$act['target_quality']?></td>
                <td class="text-center">0,00</td>
                <td class="text-center"><?=$act['real_qty']?></td>
                <td class="text-center"><?=$act['real_unit']?></td>
                <td class="text-center"><?=$act['real_quality']?></td>
                <td class="text-center"><?=number_format($act['capaian'], 2)?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="10" class="text-center" style="background-color: #f0f0f0;">NILAI CAPAIAN KINERJA</td>
                <td class="text-center" style="font-weight: bold;"><?=number_format($avg_score, 2)?></td>
            </tr>
        </tbody>
    </table>
<?php } ?>

<!-- Rekapitulasi -->
<div class="header-yellow" style="padding: 5px; border: 1px solid black; border-bottom: none;">
    REKAPITULASI PENILAIAN CAPAIAN KINERJA BULAN <?=strtoupper(bulanIndo($month))?> <?=$active_year->year?>
</div>
<table>
    <thead>
        <tr>
            <th width="30">NO</th>
            <th>KEGIATAN TUGAS JABATAN</th> <!-- Should be INDICATOR NAME based on image context -->
            <th width="150">NILAI CAPAIAN KINERJA<br><small>(PENGHITUNGAN DIBAGI JUMLAH KEGIATAN)</small></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; 
        $total_final_score = 0;
        $count_indicators = 0;
        foreach($indicators as $ind_data) { 
            // Only count towards final score divisor if it has valid activities
            if ($ind_data['count'] > 0) {
                $total_final_score += $ind_data['avg_score'];
                $count_indicators++;
            }
        ?>
        <tr>
            <td class="text-center"><?=$no++?></td>
            <td><?=strtoupper($ind_data['name'])?></td>
            <td class="text-center"><?=number_format($ind_data['avg_score'], 2)?></td>
        </tr>
        <?php } ?>
        
        <?php 
        $final_score = $count_indicators > 0 ? $total_final_score / $count_indicators : 0;
        
        // Predikat
        if ($final_score >= 90) $predikat = "Sangat Baik";
        elseif ($final_score >= 76) $predikat = "Baik";
        elseif ($final_score >= 61) $predikat = "Cukup";
        elseif ($final_score >= 51) $predikat = "Kurang";
        else $predikat = "Buruk";
        ?>
        
        <tr>
            <td colspan="2" class="text-center" style="background-color: #f0f0f0;">HASIL CAPAIAN KINERJA BULAN <?=strtoupper(bulanIndo($month))?></td>
            <td class="text-center" style="font-weight: bold;">
                <?=number_format($final_score, 2)?><br>
                (<?=$predikat?>)
            </td>
        </tr>
    </tbody>
</table>

<!-- Signatures -->
<br>
<table class="no-border">
    <tr>
        <td class="no-border" width="50%"></td>
        <td class="no-border text-center">
            Pejabat Penilai,<br><br><br><br><br>
            <u><?=isset($signature) ? $signature->appraiser_name : '.........................'?></u><br>
            NIP. <?=isset($signature) ? $signature->appraiser_nip : '.........................'?>
        </td>
    </tr>
    <tr>
        <td class="no-border text-center">
            <!-- Pegawai Yang Dinilai removed as requested -->
        </td>
        <td class="no-border"></td>
    </tr>
</table>

<script>
    window.print();
</script>

</body>
</html>
