<!DOCTYPE html>
<html>
<head>
    <title>Cetak Rekapitulasi Kinerja</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 5px; }
        .text-center { text-align: center; }
        .no-border { border: none; }
        .title { text-align: center; font-weight: bold; margin-bottom: 20px; font-size: 14px; }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

<div class="title">
    FORMULIR REKAPITULASI PENILAIAN CAPAIAN KINERJA PEGAWAI<br>
    PEGAWAI NEGERI SIPIL*
</div>

<!-- Header Info -->
<table>
    <tr>
        <td width="30">1</td>
        <td width="150">Bulan</td>
        <td><?=bulanIndo($month)?> <?=$active_year->year?></td>
    </tr>
    <tr>
        <td>2</td>
        <td>Unit Kerja</td>
        <td><?=$user->unit_name?></td>
    </tr>
</table>

<!-- Main Table -->
<table>
    <thead>
        <tr>
            <th width="30">NO</th>
            <th>NAMA / NIP</th>
            <th width="50">AK</th>
            <th>JABATAN</th>
            <th width="100">CAPAIAN KINERJA</th>
            <th width="100">KETERANGAN</th>
        </tr>
        <tr style="background-color: #f0f0f0;">
            <td class="text-center">(1)</td>
            <td class="text-center">(2)</td>
            <td class="text-center">(3)</td>
            <td class="text-center">(4)</td>
            <td class="text-center">(5)</td>
            <td class="text-center">(6)</td>
        </tr>
    </thead>
    <tbody>
        <?php
        // Calculate Final Score Logic (Same as print_preview)
        $indicators = [];
        $targets_data = $targets->result();
        $total_score_sum = 0;
        $indicator_count = 0;

        foreach($targets_data as $target) {
            // Get realization
            $realization = $this->pkp_model->get_monthly_realization($target->id, $month)->row();
            $real_qty = isset($realization) ? $realization->real_qty : 0;
            
            // Filter: Skip if realization is 0
            if ($real_qty <= 0) continue;

            $ind_id = $target->indicator_id ? $target->indicator_id : 0;
            
            if(!isset($indicators[$ind_id])) {
                $indicators[$ind_id] = [
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
                $monthly_target = $target->target_qty / 12; 
            }

            if($monthly_target > 0) {
                $capaian = ($real_qty / $monthly_target) * 100;
            } else {
                $capaian = 0;
            }
            
            $indicators[$ind_id]['total_score'] += $capaian;
            $indicators[$ind_id]['count']++;
        }

        // Calculate Average per Indicator then Average of Indicators
        $total_avg_indicators = 0;
        $count_valid_indicators = 0;
        
        foreach($indicators as $ind) {
            if($ind['count'] > 0) {
                $avg = $ind['total_score'] / $ind['count'];
                $total_avg_indicators += $avg;
                $count_valid_indicators++;
            }
        }

        $final_score = $count_valid_indicators > 0 ? $total_avg_indicators / $count_valid_indicators : 0;

        // Predikat
        if ($final_score >= 90) $predikat = "Sangat Baik";
        elseif ($final_score >= 76) $predikat = "Baik";
        elseif ($final_score >= 61) $predikat = "Cukup";
        elseif ($final_score >= 51) $predikat = "Kurang";
        else $predikat = "Buruk";
        ?>

        <!-- Row 1: The Employee -->
        <tr>
            <td class="text-center">1</td>
            <td>
                <?=$user->full_name?><br>
                NIP. <?=$user->nip?>
            </td>
            <td></td> <!-- AK Empty as per image -->
            <td><?=$user->position_name?></td> <!-- Or rank? Image says "Ahli Pertama - Pranata Komputer" which is Jabatan -->
            <td class="text-center"><?=number_format($final_score, 2)?></td>
            <td class="text-center">(<?=$predikat?>)</td>
        </tr>
        
        <!-- Empty Rows for filler -->
        <?php for($i=2; $i<=4; $i++) { ?>
        <tr>
            <td class="text-center"><?=$i?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Signatures -->
<br>
<table class="no-border">
    <tr>
        <td class="no-border" width="60%"></td>
        <td class="no-border">
            Gorontalo, <?=date('d F Y')?> <br> <!-- Should use indo date helper -->
            <?=isset($signature) ? $signature->appraiser_position : 'Pejabat Penilai'?><br>
            <br><br><br><br>
            <?=isset($signature) ? $signature->appraiser_name : '.........................'?><br>
            NIP. <?=isset($signature) ? $signature->appraiser_nip : '.........................'?>
        </td>
    </tr>
</table>

<script>
    window.print();
</script>

</body>
</html>
