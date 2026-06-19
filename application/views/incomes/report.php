<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Penghasilan Bruto - <?= $selected_year ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2, .header h3 {
            margin: 5px 0;
        }
        .identity {
            margin-bottom: 20px;
        }
        .identity table {
            width: 100%;
            max-width: 500px;
        }
        .identity td {
            padding: 3px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 13px;
        }
        table.data-table th {
            background-color: #f0f0f0;
            text-align: center;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .footer-sign {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 250px;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2196F3; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Cetak Laporan / Simpan PDF</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #888; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Tutup</button>
    </div>

    <div class="header">
        <h2>REKAPITULASI PENGHASILAN BRUTO DAN PPh DIPOTONG PIHAK LAIN</h2>
        <h3>TAHUN PAJAK <?= $selected_year ?></h3>
    </div>

    <div class="identity">
        <table>
            <tr>
                <td width="150">Nama Wajib Pajak</td>
                <td width="10">:</td>
                <td><strong><?= htmlspecialchars($this->session->userdata('username') ?: '..............................') ?></strong></td>
            </tr>
            <tr>
                <td>NPWP</td>
                <td>:</td>
                <td>..............................</td>
            </tr>
            <tr>
                <td>Pekerjaan/Usaha</td>
                <td>:</td>
                <td>Pekerja Bebas / Freelancer</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th>Pemberi Penghasilan (Klien)</th>
                <th>Uraian Pekerjaan</th>
                <th width="120">Penghasilan Bruto (Rp)</th>
                <th width="120">PPh Dipotong (Rp)</th>
                <th width="120">Nomor Bukti Potong</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(empty($incomes)): ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data penghasilan untuk tahun <?= $selected_year ?></td>
                </tr>
            <?php else: ?>
                <?php foreach($incomes as $inc): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($inc['receive_date'])) ?></td>
                        <td><?= htmlspecialchars($inc['client_name']) ?></td>
                        <td><?= htmlspecialchars($inc['description']) ?></td>
                        <td class="text-right"><?= number_format($inc['gross_amount'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($inc['tax_withheld'], 0, ',', '.') ?></td>
                        <td class="text-center"><?= htmlspecialchars($inc['tax_receipt_number'] ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="4" class="text-right">JUMLAH TOTAL</th>
                    <th class="text-right"><?= number_format($gross_total, 0, ',', '.') ?></th>
                    <th class="text-right"><?= number_format($tax_total, 0, ',', '.') ?></th>
                    <th></th>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 10px; font-size: 12px; font-style: italic;">
        * Laporan ini merupakan Lampiran SPT Tahunan PPh Orang Pribadi (Formulir 1770) bagi Wajib Pajak yang menyelenggarakan Pencatatan / NPPN.
    </div>

    <div class="footer-sign">
        <p>................., ................. <?= date('Y') ?></p>
        <p>Wajib Pajak,</p>
        <br><br><br>
        <p><strong><?= htmlspecialchars($this->session->userdata('username') ?: '..............................') ?></strong></p>
    </div>
</body>
</html>
