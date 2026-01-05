let activeTabType = 'tiket';
let activeTabEl = null;

let chartPendapatan;
let chartTrxHarian;
let chartStatusTrx;
let chartNominal;

function hasData(obj) {
    if (!obj) return false;
    return Object.values(obj).some(v => Number(v) > 0);
}

window.loadTable = function(type, el = null, page = 1) {

    if (el) {
        activeTabEl = el;
        activeTabType = type;
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('tab-active');
    });
    if (activeTabEl) activeTabEl.classList.add('tab-active');

    const container = document.getElementById('table-container');
    container.innerHTML = `
        <div class="text-center py-12 text-gray-400">
            <i class="fa fa-spinner fa-spin mr-2"></i> Memuat data...
        </div>
    `;

    let pageParam = '';
    if (type === 'tiket') pageParam = `&page_tiket=${page}`;
    if (type === 'transaksi') pageParam = `&page_trx=${page}`;
    if (type === 'user') pageParam = `&page_user=${page}`;

    fetch(`ajax/load-dashboard-table.php?type=${type}${pageParam}`)
        .then(res => res.json())

    .then(data => {
        container.innerHTML = data.html;

        if (type === 'tiket') {

            const hasChart =
                hasData(data.statusCount) ||
                hasData(data.kendaraanCount);

            const chartContainer = document.getElementById('chart-container');

            if (!hasChart) {
                if (chartContainer) chartContainer.style.display = 'none';
                return;
            }

            if (chartContainer) chartContainer.style.display = 'grid';
            setTimeout(() => {
                renderChartTiket(data.statusCount, data.kendaraanCount);
            }, 50);
        }

    if (type === 'transaksi') {

        const hasChart =
            hasData(data.pendapatan?.data) ||
            hasData(data.trxHarian?.data) ||
            hasData(data.statusCount) ||
            hasData(data.nominalCount);

        const chartContainer = document.getElementById('chart-container');

        if (!hasChart) {
            if (chartContainer) chartContainer.style.display = 'none';
            return;
        }

        if (chartContainer) chartContainer.style.display = 'grid';

        setTimeout(() => {
            renderChartTransaksi(data);
        }, 50);
    }

    if (type === 'user') {

        const hasChart =
            hasData(data.roleCount) ||
            hasData(data.genderCount) ||
            hasData(data.verifCount) ||
            hasData(data.userHarian?.data);

        const chartContainer = document.getElementById('chart-container');

        if (!hasChart) {
            if (chartContainer) chartContainer.style.display = 'none';
            return;
        }

        if (chartContainer) chartContainer.style.display = 'grid';

        renderChartUser({
            roleCount: data.roleCount,
            genderCount: data.genderCount,
            verifCount: data.verifCount,
            userHarian: data.userHarian
        });
    }


})

        .catch(err => {
            console.error('Load table error:', err);
            container.innerHTML = "<div class='text-red-400 text-center py-10'>Gagal memuat data</div>";
        });

    }

document.addEventListener('DOMContentLoaded', () => {
    const defaultTab = document.getElementById('tab-tiket');
    loadTable('tiket', defaultTab);
});

function renderChartTiket(statusData, kendaraanData) { 
        const statusCanvas = document.getElementById('chartStatusTiket');
    const kendaraanCanvas = document.getElementById('chartJenisKendaraan');

    if (!statusCanvas || !kendaraanCanvas) return;
    if (window.chartStatus) window.chartStatus.destroy();
    if (window.chartKendaraan) window.chartKendaraan.destroy();

    const ctxStatus = document.getElementById('chartStatusTiket').getContext('2d');
    window.chartStatus = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Masuk', 'Keluar', 'Sedang Parkir'],
            datasets: [{
                label: 'Jumlah Tiket',
                data: [statusData.masuk, statusData.keluar, statusData.parkir],
                backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                borderWidth: 1
            }]
        },
    });

    const ctxKendaraan = document.getElementById('chartJenisKendaraan').getContext('2d');
    window.chartKendaraan = new Chart(ctxKendaraan, {
        type: 'bar',
        data: {
            labels: ['Motor', 'Mobil'],
            datasets: [{
                label: 'Jumlah Kendaraan',
                data: [kendaraanData.motor, kendaraanData.mobil],
                backgroundColor: ['#0ea5e9', '#f59e0b'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
}

function renderChartTransaksi(res) {
        if (
        !document.getElementById('chartPendapatan') ||
        !document.getElementById('chartTrxHarian') ||
        !document.getElementById('chartStatus') ||
        !document.getElementById('chartNominal')
    ) return;

    chartPendapatan?.destroy();
    chartTrxHarian?.destroy();
    chartStatusTrx?.destroy();
    chartNominal?.destroy();

chartPendapatan = new Chart(
    document.getElementById('chartPendapatan'),
    {
        type: 'line',
        data: {
            labels: res.pendapatan.labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: res.pendapatan.data,
                borderColor: '#22c55e',          
                backgroundColor: 'rgba(34,197,94,0.25)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#16a34a',
                pointRadius: 4
            }]
        }
    }
);

chartTrxHarian = new Chart(
    document.getElementById('chartTrxHarian'),
    {
        type: 'bar',
        data: {
            labels: res.trxHarian.labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: res.trxHarian.data,
                backgroundColor: '#06b6d4', 
                borderRadius: 8
            }]
        }
    }
);

chartStatusTrx = new Chart(
    document.getElementById('chartStatus'),
    {
        type: 'doughnut',
        data: {
            labels: Object.keys(res.statusCount),
            datasets: [{
                data: Object.values(res.statusCount),
                backgroundColor: [
                    '#22c55e', 
                    '#facc15', 
                ],
                borderWidth: 1
            }]
        }
    }
);

chartNominal = new Chart(
    document.getElementById('chartNominal'),
    {
        type: 'bar',
        data: {
            labels: Object.keys(res.nominalCount),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: Object.values(res.nominalCount),
                backgroundColor: [
                    '#a855f7',
                    '#ec4899',
                    '#6366f1',
                    '#14b8a6'
                ],
                borderRadius: 8
            }]
        }
    }
);
}

function renderChartUser(data) {
        if (!data) return;

    const ctxRole = document.getElementById('chartRole');
    if (!ctxRole) return;

    if (window.chartRole instanceof Chart) {
        window.chartRole.destroy();
    }

    window.chartRole = new Chart(ctxRole, {
        type: 'doughnut',
        data: {
            labels: Object.keys(data.roleCount),
            datasets: [{
                data: Object.values(data.roleCount),
            }]
        }
    });

    const ctxGender = document.getElementById('chartGender');
    if (window.chartGender instanceof Chart) {
        window.chartGender.destroy();
    }

    window.chartGender = new Chart(ctxGender, {
        type: 'pie',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: Object.values(data.genderCount),
            }]
        }
    });

    const ctxVerif = document.getElementById('chartVerif');
    if (window.chartVerif instanceof Chart) {
        window.chartVerif.destroy();
    }

    window.chartVerif = new Chart(ctxVerif, {
        type: 'bar',
        data: {
            labels: Object.keys(data.verifCount),
            datasets: [{
                data: Object.values(data.verifCount),
            }]
        }
    });

    const ctxUserHarian = document.getElementById('chartUserHarian');
    if (window.chartUserHarian instanceof Chart) {
        window.chartUserHarian.destroy();
    }

    window.chartUserHarian = new Chart(ctxUserHarian, {
        type: 'line',
        data: {
            labels: data.userHarian.labels,
            datasets: [{
                label: 'User Baru',
                data: data.userHarian.data,
                tension: 0.3
            }]
        }
    });
}