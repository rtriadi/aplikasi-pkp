<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Kerja Harian ASN (WFH)</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.5; color: #000; margin: 20px; }
        .title { text-align: center; font-weight: bold; margin-bottom: 5px; font-size: 14px; }
        .subtitle { text-align: center; font-weight: bold; margin-bottom: 25px; font-size: 12px; }
        
        .section-title { font-weight: bold; margin-top: 15px; margin-bottom: 10px; font-size: 12px; text-transform: uppercase; }
        
        .profile-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .profile-table td { border: none; padding: 4px 8px; vertical-align: top; }
        .profile-table td.label-col { width: 120px; }
        .profile-table td.colon-col { width: 15px; text-align: center; }
        
        .activities-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .activities-table th, .activities-table td { border: 1px solid #000; padding: 8px 10px; vertical-align: top; }
        .activities-table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        
        .attachments-section { margin-top: 30px; page-break-before: auto; }
        .attachments-title { font-weight: bold; font-size: 13px; margin-bottom: 15px; border-bottom: 1px solid #000; padding-bottom: 5px; }
        .attachment-item { text-align: center; margin-bottom: 30px; page-break-inside: avoid; }
        .attachment-item img { max-width: 100%; max-height: 600px; height: auto; border: 1px solid #ccc; padding: 5px; background: #fff; }
        
        @media print {
            body { margin: 10mm; }
            .no-print { display: none; }
            .attachment-item { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="title">LAPORAN KERJA HARIAN ASN (WFH)</div>
<div class="subtitle">PENGADILAN AGAMA GORONTALO</div>

<div class="section-title">DATA PEGAWAI</div>
<table class="profile-table">
    <tr>
        <td class="label-col">Nama</td>
        <td class="colon-col">:</td>
        <td><strong><?=$user->full_name?></strong></td>
    </tr>
    <tr>
        <td class="label-col">NIP</td>
        <td class="colon-col">:</td>
        <td><?=$user->nip?></td>
    </tr>
    <tr>
        <td class="label-col">Jabatan</td>
        <td class="colon-col">:</td>
        <td><?=$user->position_name?></td>
    </tr>
    <tr>
        <td class="label-col">Unit Kerja</td>
        <td class="colon-col">:</td>
        <td><?=$user->unit_name?></td>
    </tr>
    <tr>
        <td class="label-col">Hari/Tanggal</td>
        <td class="colon-col">:</td>
        <td>
            <?=hari_indo(date('D', strtotime($report->wfh_date)))?>, 
            <?=tgl_indo($report->wfh_date)?>
        </td>
    </tr>
</table>

<table class="activities-table">
    <thead>
        <tr>
            <th style="width: 5%">No</th>
            <th style="width: 15%">Jam Kerja</th>
            <th>Deskripsi Kegiatan</th>
            <th style="width: 25%">Output / Hasil</th>
            <th style="width: 20%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        foreach ($activities as $act) { 
        ?>
        <tr>
            <td class="text-center"><?=$no++?></td>
            <td class="text-center"><?=$act->work_time?></td>
            <td><?=nl2br(html_escape($act->activity_description))?></td>
            <td><?=html_escape($act->output_result)?></td>
            <td><?=$act->note ? html_escape($act->note) : '-'?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php if (!empty($attachments)): ?>
<div class="attachments-section">
    <div class="attachments-title">Lampiran</div>
    <?php foreach ($attachments as $att): ?>
        <div class="attachment-item">
            <img src="<?=base_url('assets/uploads/wfh/'.$att->file_name)?>" alt="Bukti Kegiatan WFH">
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<script>
    window.print();
</script>

</body>
</html>
