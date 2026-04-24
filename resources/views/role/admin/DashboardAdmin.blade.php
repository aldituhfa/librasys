@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">Dashboard</h4>
            <p class="text-muted small mb-0">Selamat datang kembali, {{ auth()->user()->name }}</p>
        </div>
    </div>

    {{-- METRIC CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Total User</span>
                            <h3 class="fw-bold mt-2 mb-0">{{ number_format($totalUsers) }}</h3>
                            <div class="mt-2">
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small">
                                    <i class="ti ti-trending-up"></i> +12%
                                </span>
                                <span class="text-muted small ms-1">dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 p-2">
                            <i class="ti ti-users fs-5 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Total Buku</span>
                            <h3 class="fw-bold mt-2 mb-0">{{ number_format($totalBooks) }}</h3>
                            <div class="mt-2">
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill small">
                                    <i class="ti ti-trending-up"></i> +5%
                                </span>
                                <span class="text-muted small ms-1">dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 p-2">
                            <i class="ti ti-book-2 fs-5 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Kategori</span>
                            <h3 class="fw-bold mt-2 mb-0">{{ number_format($totalCategories) }}</h3>
                            <div class="mt-2">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1 rounded-pill small">
                                    <i class="ti ti-minus"></i> 0%
                                </span>
                                <span class="text-muted small ms-1">stabil</span>
                            </div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-3 p-2">
                            <i class="ti ti-category fs-5 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Total Denda</span>
                            <h4 class="fw-bold mt-2 mb-0">Rp {{ number_format($totalFine, 0, ',', '.') }}</h4>
                            <div class="mt-2">
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill small">
                                    <i class="ti ti-trending-up"></i> +8%
                                </span>
                                <span class="text-muted small ms-1">dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-3 p-2">
                            <i class="ti ti-coin fs-5 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECOND ROW - Pemakaian 2 Card untuk Peminjaman Aktif dan Selesai (Diperkecil tingginya) --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Peminjaman Aktif</span>
                            <h2 class="fw-bold mb-0 text-primary mt-1">{{ $activeTransactions }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="ti ti-book fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Peminjaman Selesai</span>
                            <h2 class="fw-bold mb-0 text-success mt-1">{{ $finishedTransactions }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="ti ti-check-circle fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ROW: LINE CHART + DONUT CHART 7 HARI TERAKHIR --}}
    <div class="row g-3 mb-4">
        {{-- LINE CHART - GRAFIK PEMINJAMAN 7 HARI --}}
        <div class="col-lg-8">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-header bg-white border-0 pt-3 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-semibold mb-0">Grafik Peminjaman</h6>
                            <p class="text-muted small mb-0">7 Hari Terakhir</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="chartTransaction"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- DONUT CHART - RINGKASAN 7 HARI TERAKHIR --}}
        <div class="col-lg-4">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-3 text-center">Ringkasan 7 Hari Terakhir</h6>
                    <div style="position: relative; height: 260px; width: 100%; display: flex; justify-content: center; align-items: center;">
                        <div style="position: relative; width: 220px; height: 220px; margin: 0 auto;">
                            <canvas id="donutChartWeek" style="width: 100% !important; height: 100% !important;"></canvas>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill">
                                    <i class="ti ti-book"></i> Total Peminjaman
                                </span>
                            </div>
                            <div class="fw-bold">
                                @php
                                $total7DaysData = 0;
                                if(isset($chart) && count($chart) > 0) {
                                    foreach($chart as $item) {
                                        $total7DaysData += isset($item->total) ? $item->total : (isset($item['total']) ? $item['total'] : 0);
                                    }
                                }
                                echo number_format($total7DaysData);
                                @endphp
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">
                                    <i class="ti ti-chart-bar"></i> Rata-rata per hari
                                </span>
                            </div>
                            <div class="fw-bold">
                                @php
                                $avgPerDay = isset($chart) && count($chart) > 0 ? round($total7DaysData / count($chart)) : 0;
                                echo number_format($avgPerDay);
                                @endphp
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-pill">
                                    <i class="ti ti-calendar"></i> Hari Tertinggi
                                </span>
                            </div>
                            <div class="fw-bold">
                                @php
                                $maxValue = 0;
                                if(isset($chart) && count($chart) > 0) {
                                    foreach($chart as $item) {
                                        $val = isset($item->total) ? $item->total : (isset($item['total']) ? $item['total'] : 0);
                                        if($val > $maxValue) $maxValue = $val;
                                    }
                                }
                                echo number_format($maxValue) . ' pinjam';
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE TRANSAKSI TERBARU (3 DATA SAJA) --}}
    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-header bg-white border-0 pt-3 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-semibold mb-0">Transaksi Terbaru</h6>
                    <p class="text-muted small mb-0">3 aktivitas peminjaman buku terkini</p>
                </div>
                <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-light rounded-pill px-3">
                    Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3 py-2 small text-muted fw-semibold">Peminjam</th>
                            <th class="py-2 small text-muted fw-semibold">Buku</th>
                            <th class="py-2 small text-muted fw-semibold">Status</th>
                            <th class="py-2 small text-muted fw-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestTransactions->take(3) as $trx)
                        <tr>
                            <td class="ps-3 py-2">
                                <div class="fw-medium" style="color: #1e293b;">{{ $trx->user->name }}</div>
                                <small class="text-muted">{{ $trx->user->email ?? 'user@example.com' }}</small>
                            </td>
                            <td class="py-2">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('storage/'.$trx->book->cover) }}"
                                        width="32" height="44"
                                        class="rounded-1"
                                        style="object-fit: cover;"
                                        onerror="this.src='https://placehold.co/32x44?text=📖'">
                                    <div>
                                        <div class="fw-medium small">{{ Str::limit($trx->book->title, 35) }}</div>
                                        <small class="text-muted">{{ $trx->book->code ?? 'ISBN: N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">
                                @php
                                $statusBadge = [
                                'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'ti ti-hourglass-empty', 'label' => 'Pending'],
                                'approved' => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' => 'ti ti-check-circle', 'label' => 'Dipinjam'],
                                'return_pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'ti ti-clock', 'label' => 'Menunggu'],
                                'done' => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' => 'ti ti-checks', 'label' => 'Selesai'],
                                'late' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icon' => 'ti ti-alert-triangle', 'label' => 'Terlambat'],
                                ];
                                $badge = $statusBadge[$trx->status] ?? ['class' => 'bg-secondary bg-opacity-10 text-secondary', 'icon' => 'ti ti-help', 'label' => ucfirst($trx->status)];
                                @endphp
                                <span class="badge py-1 px-2 rounded-pill {{ $badge['class'] }}" style="font-size: 0.7rem;">
                                    <i class="{{ $badge['icon'] }} me-1" style="font-size: 10px;"></i>
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="py-2">
                                <span class="small">{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}</span>
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="ti ti-inbox fs-4"></i>
                                <p class="mb-0 small">Belum ada transaksi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Data dari controller untuk 7 hari terakhir
    const chartLabels = @json($chart->pluck('date'));
    const chartDataRaw = @json($chart);
    
    // Extract total values dengan aman
    let chartData = [];
    if (chartDataRaw && chartDataRaw.length > 0) {
        chartData = chartDataRaw.map(item => {
            return typeof item === 'object' ? (item.total || item['total'] || 0) : 0;
        });
    }
    
    // Hitung total dan persentase untuk donut chart
    const total7Days = chartData.reduce((a, b) => a + b, 0);
    
    // Cari nilai tertinggi
    let highestValue = 0;
    let highestIndex = 0;
    chartData.forEach((value, index) => {
        if (value > highestValue) {
            highestValue = value;
            highestIndex = index;
        }
    });
    
    const highestDayTotal = highestValue;
    const otherDaysTotal = total7Days - highestDayTotal;
    
    console.log('Labels:', chartLabels);
    console.log('Data:', chartData);
    console.log('Total 7 hari:', total7Days);
    console.log('Hari tertinggi:', chartLabels[highestIndex], 'dengan', highestDayTotal, 'peminjaman');

    // Tunggu hingga halaman selesai loading
    window.addEventListener('load', function() {
        // Line Chart untuk Grafik Peminjaman
        const canvasLine = document.getElementById('chartTransaction');
        
        if (canvasLine) {
            const ctx = canvasLine.getContext('2d');
            
            if (window.myLineChart) {
                window.myLineChart.destroy();
            }
            
            window.myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: chartData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2.5,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#ffffff',
                            bodyColor: '#cbd5e1',
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return `📊 ${context.parsed.y} peminjaman`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e9ecef',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return value + ' pinjam';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Peminjaman',
                                font: {
                                    size: 11
                                },
                                color: '#6c757d'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                            title: {
                                display: true,
                                text: 'Tanggal',
                                font: {
                                    size: 11
                                },
                                color: '#6c757d'
                            }
                        }
                    }
                }
            });
        }
        
        // Donut Chart untuk Ringkasan 7 Hari Terakhir
        const canvasDonut = document.getElementById('donutChartWeek');
        
        if (canvasDonut) {
            const ctxDonut = canvasDonut.getContext('2d');
            
            if (window.donutChart) {
                window.donutChart.destroy();
            }
            
            // Jika total 0, tampilkan data placeholder
            const donutData = total7Days > 0 ? [highestDayTotal, otherDaysTotal] : [1, 0];
            const donutLabels = total7Days > 0 
                ? [`Hari Tertinggi (${chartLabels[highestIndex] || '-'})`, '6 Hari Lainnya']
                : ['Tidak ada data', ''];
            const donutColors = total7Days > 0
                ? ['#3b82f6', '#e2e8f0']
                : ['#cbd5e1', '#e2e8f0'];
            
            window.donutChart = new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: donutLabels,
                    datasets: [{
                        data: donutData,
                        backgroundColor: donutColors,
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 8,
                        borderRadius: 8,
                        spacing: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    layout: {
                        padding: 10
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                boxWidth: 12,
                                boxHeight: 12,
                                padding: 12,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleColor: '#ffffff',
                            bodyColor: '#cbd5e1',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const percentage = total7Days > 0 ? ((value / total7Days) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} peminjaman (${percentage}%)`;
                                }
                            }
                        }
                    },
                    elements: {
                        arc: {
                            borderWidth: 3,
                            borderColor: '#ffffff'
                        }
                    }
                }
            });
            
            // Tambahkan teks di tengah donut chart
            const centerText = document.createElement('div');
            centerText.style.position = 'absolute';
            centerText.style.top = '50%';
            centerText.style.left = '50%';
            centerText.style.transform = 'translate(-50%, -50%)';
            centerText.style.textAlign = 'center';
            centerText.style.zIndex = '10';
            centerText.style.pointerEvents = 'none';
            centerText.innerHTML = `
            `;
            
            // Hapus teks tengah yang lama jika ada
            const existingText = canvasDonut.parentElement.querySelector('.donut-center-text');
            if (existingText) {
                existingText.remove();
            }
            centerText.classList.add('donut-center-text');
            
            // Pastikan parent memiliki posisi relative
            const wrapperDiv = canvasDonut.parentElement;
            wrapperDiv.style.position = 'relative';
            wrapperDiv.style.display = 'flex';
            wrapperDiv.style.justifyContent = 'center';
            wrapperDiv.style.alignItems = 'center';
            wrapperDiv.appendChild(centerText);
        }
        
        console.log('Charts berhasil dibuat!');
    });
</script>

<style>
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
    }
    
    .progress-bar {
        border-radius: 10px;
        transition: width 0.3s ease;
    }
    
    #donutChartWeek {
        display: block !important;
        width: 100% !important;
        height: 100% !important;
    }
</style>

@endsection