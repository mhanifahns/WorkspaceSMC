<!-- Created by Hanif -->
<style>
    .finance-dashboard {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: rgba(0,0,0,0.3);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        transition: all 0.3s;
    }

    .stat-card:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
    }

    .stat-icon {
        font-size: 32px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-gross .stat-icon { background: rgba(33, 150, 243, 0.2); color: #2196F3; }
    .stat-tax .stat-icon { background: rgba(244, 67, 54, 0.2); color: #F44336; }
    .stat-net .stat-icon { background: rgba(76, 175, 80, 0.2); color: #4CAF50; }

    .stat-info {
        flex-grow: 1;
    }

    .stat-label {
        font-family: 'Consolas', monospace;
        font-size: 12px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .stat-value {
        font-family: 'Consolas', monospace;
        font-size: 24px;
        font-weight: bold;
        color: #fff;
    }

    .table-container {
        background-color: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        overflow: hidden;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th, .data-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .data-table th {
        background-color: rgba(0,0,0,0.5);
        font-family: 'Consolas', monospace;
        font-size: 12px;
        color: var(--accent);
        text-transform: uppercase;
    }

    .data-table td {
        font-size: 14px;
    }

    .data-table tr:hover td {
        background-color: rgba(0, 255, 209, 0.05);
    }

    .currency {
        font-family: 'Consolas', monospace;
        text-align: right;
    }

    /* Modal overrides for finance form */
    .modal-finance .modal-content {
        width: 500px;
    }

    .input-group {
        display: flex;
        gap: 15px;
    }

    .input-group .form-group {
        flex: 1;
    }
</style>

<div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h1 class="page-title anim-slide-left">
        <i class="fas fa-file-invoice-dollar"></i> Tax & Income Tracker
    </h1>
    <div class="anim-slide-right" style="display: flex; gap: 15px;">
        <form action="<?= site_url('incomes') ?>" method="GET" style="display: flex; align-items: center; gap: 10px;">
            <label style="font-family: 'Consolas', monospace; font-size: 12px;">YEAR:</label>
            <select name="year" class="form-control" style="width: auto; padding: 6px 12px; font-family: 'Consolas', monospace;" onchange="this.form.submit()">
                <?php for($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                    <option value="<?= $i ?>" <?= $selected_year == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </form>
        <button class="btn" style="border-color: #F44336; color: #F44336;" onclick="window.open('<?= site_url('incomes/report?year='.$selected_year) ?>', '_blank')"><i class="fas fa-file-pdf"></i> SPT Report</button>
        <button class="btn" onclick="openModal()"><i class="fas fa-plus"></i> Add Income</button>
    </div>
</div>

<div class="finance-dashboard anim-fade-up">
    <div class="stat-card stat-gross">
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <div class="stat-label">Gross Income (Bruto)</div>
            <div class="stat-value">Rp <?= number_format($gross_total, 0, ',', '.') ?></div>
        </div>
    </div>
    
    <div class="stat-card stat-tax">
        <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
        <div class="stat-info">
            <div class="stat-label">Tax Withheld (PPh 21)</div>
            <div class="stat-value">Rp <?= number_format($tax_total, 0, ',', '.') ?></div>
        </div>
    </div>
    
    <div class="stat-card stat-net">
        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        <div class="stat-info">
            <div class="stat-label">Net Received (Bersih)</div>
            <div class="stat-value">Rp <?= number_format($net_total, 0, ',', '.') ?></div>
        </div>
    </div>
</div>

<div class="table-container anim-fade-up" style="animation-delay: 0.1s;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Client / Project</th>
                <th style="text-align: right;">Gross (Rp)</th>
                <th style="text-align: right;">Tax (Rp)</th>
                <th style="text-align: right;">Net (Rp)</th>
                <th>Bukti Potong</th>
                <th style="text-align: center;">Receipt File</th>
                <th style="width: 50px; text-align: center;">Act</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($incomes)): ?>
            <tr>
                <td colspan="8" style="text-align: center; padding: 30px; color: #666; font-family: 'Consolas', monospace;">
                    NO INCOME DATA FOR <?= $selected_year ?>
                </td>
            </tr>
            <?php else: ?>
                <?php foreach($incomes as $inc): ?>
                <tr>
                    <td style="font-family: 'Consolas', monospace; font-size: 13px; color: #888;">
                        <?= date('d M Y', strtotime($inc['receive_date'])) ?>
                    </td>
                    <td>
                        <div style="font-weight: bold; color: #fff;"><?= htmlspecialchars($inc['client_name']) ?></div>
                        <?php if(!empty($inc['description'])): ?>
                            <div style="font-size: 12px; color: #aaa; margin-top: 4px;"><?= htmlspecialchars($inc['description']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="currency" style="color: #2196F3;"><?= number_format($inc['gross_amount'], 0, ',', '.') ?></td>
                    <td class="currency" style="color: #F44336;"><?= number_format($inc['tax_withheld'], 0, ',', '.') ?></td>
                    <td class="currency" style="color: #4CAF50; font-weight: bold;"><?= number_format($inc['net_amount'], 0, ',', '.') ?></td>
                    <td style="font-family: 'Consolas', monospace; font-size: 13px; color: #aaa;">
                        <?= htmlspecialchars($inc['tax_receipt_number'] ?: '-') ?>
                    </td>
                    <td style="text-align: center;">
                        <?php if(!empty($inc['receipt_file'])): ?>
                            <a href="<?= base_url('uploads/receipts/'.$inc['receipt_file']) ?>" target="_blank" style="color: var(--secondary);" title="View Receipt">
                                <i class="fas fa-file-invoice"></i>
                            </a>
                        <?php else: ?>
                            <span style="color: #555;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="<?= site_url('incomes/delete/'.$inc['id']) ?>" style="color: #ff4d4d;" onclick="return confirm('Delete this record?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal modal-finance" id="financeModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 style="margin:0;">Add Income Record</h3>
            <i class="fas fa-times close-modal" onclick="closeModal()"></i>
        </div>
        <div class="modal-body">
            <form action="<?= site_url('incomes/create') ?>" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <div class="form-group">
                        <label>Date Received</label>
                        <input type="date" name="receive_date" class="form-control" required value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label>Tax Receipt No. (Bukti Potong)</label>
                        <input type="text" name="tax_receipt_number" class="form-control" placeholder="Optional">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Client / Company Name</label>
                    <input type="text" name="client_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Description / Project Details</label>
                    <input type="text" name="description" class="form-control">
                </div>
                
                <div class="input-group">
                    <div class="form-group">
                        <label>Gross Amount (Rp)</label>
                        <input type="text" name="gross_amount" id="gross_amount" class="form-control" required oninput="formatCurrency(this); calculateNet();" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label>Tax Withheld (Rp)</label>
                        <input type="text" name="tax_withheld" id="tax_withheld" class="form-control" required oninput="formatCurrency(this); calculateNet();" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload Payment Receipt (Bukti Bayar)</label>
                    <input type="file" name="receipt_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    <small style="color: #888; font-family: 'Consolas', monospace; font-size: 11px;">Max size 2MB. JPG, PNG, PDF allowed.</small>
                </div>

                <div class="form-group" style="background: rgba(0,255,209,0.05); padding: 15px; border-radius: 4px; border: 1px dashed var(--accent); margin-top: 10px;">
                    <label style="color: var(--accent);">Net Received (Auto-calculated)</label>
                    <div id="net_preview" style="font-family: 'Consolas', monospace; font-size: 24px; font-weight: bold; color: #fff;">Rp 0</div>
                </div>

                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="btn" style="border-color: #888; color: #888;" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('financeModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('financeModal').style.display = 'none';
    }

    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        if (value === '') {
            input.value = '';
            return;
        }
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    function getNumber(str) {
        if(!str) return 0;
        return parseFloat(str.replace(/\./g, '')) || 0;
    }

    function calculateNet() {
        const gross = getNumber(document.getElementById('gross_amount').value);
        const tax = getNumber(document.getElementById('tax_withheld').value);
        const net = gross - tax;
        
        document.getElementById('net_preview').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(net);
    }
</script>
