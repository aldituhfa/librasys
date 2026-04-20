@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1e293b;">Dashboard</h4>
            <p class="text-muted small mb-0">Selamat datang kembali, {{ auth()->user()->name }}</p>
        </div>
        <div>
            <select class="form-select form-select-sm rounded-3 border-0 bg-light" style="width: auto;" id="periodSelect">
                <option value="7">7 Hari terakhir</option>
                <option value="14">14 Hari terakhir</option>
                <option value="30">Bulan ini</option>
            </select>
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

    {{-- SECOND ROW METRICS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Peminjaman Aktif</span>
                            <h4 class="fw-bold mb-0 text-primary">{{ $activeTransactions }}</h4>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                            <i class="ti ti-book fs-5 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Peminjaman Selesai</span>
                            <h4 class="fw-bold mb-0 text-success">{{ $finishedTransactions }}</h4>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-2">
                            <i class="ti ti-check-circle fs-5 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Menunggu Persetujuan</span>
                            <h4 class="fw-bold mb-0 text-warning">{{ $pendingTransactions ?? 0 }}</h4>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                            <i class="ti ti-hourglass-empty fs-5 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 rounded-3 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Denda Belum Bayar</span>
                            <h4 class="fw-bold mb-0 text-danger">{{ $unpaidFines ?? 0 }}</h4>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                            <i class="ti ti-alert-triangle fs-5 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ROW: CHART + STATS MINI --}}
    <div class="row g-3 mb-4">
        {{-- CHART --}}
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

        {{-- MINI STATS --}}
        <div class="col-lg-4">
            <div class="card border-0 rounded-3 shadow-sm h-100">
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-3">Ringkasan Hari Ini</h6>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted small">Peminjaman Baru</span>
                            <div class="fw-bold">{{ $newLoansToday ?? 0 }}</div>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">
                            <i class="ti ti-trending-up"></i> +{{ $newLoansPercent ?? 0 }}%
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted small">Pengembalian</span>
                            <div class="fw-bold">{{ $returnsToday ?? 0 }}</div>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-pill">
                            <i class="ti ti-check"></i> selesai
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="text-muted small">Pendapatan Denda</span>
                            <div class="fw-bold text-danger">Rp {{ number_format($fineToday ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill">
                            <i class="ti ti-coin"></i> hari ini
                        </span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Konversi Peminjaman</span>
                            <div class="fw-bold">{{ $conversionRate ?? 75 }}%</div>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">
                            <i class="ti ti-trending-up"></i> +7%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE TRANSAKSI TERBARU --}}
    <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-header bg-white border-0 pt-3 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-semibold mb-0">Transaksi Terbaru</h6>
                    <p class="text-muted small mb-0">Aktivitas peminjaman buku terkini</p>
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
                            <th class="pe-3 py-2 small text-muted fw-semibold text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestTransactions as $trx)
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
                            <td class="pe-3 py-2 text-end">
                                <button class="btn btn-sm btn-light rounded-circle p-1" style="width: 28px; height: 28px;" title="Detail">
                                    <i class="ti ti-eye fs-6"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
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
    // Data dari controller (pastikan data tersedia)
    const chartLabels = @json($chart -> pluck('date'));
    const chartData = @json($chart -> pluck('total'));

    console.log('Labels:', chartLabels);
    console.log('Data:', chartData);

    // Tunggu hingga halaman selesai loading
    window.addEventListener('load', function() {
        const canvas = document.getElementById('chartTransaction');

        if (!canvas) {
            console.error('Canvas element tidak ditemukan!');
            return;
        }

        const ctx = canvas.getContext('2d');

        // Hapus chart yang sudah ada
        if (window.myChart) {
            window.myChart.destroy();
        }

        // Buat chart baru
        window.myChart = new Chart(ctx, {
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

        console.log('Chart berhasil dibuat!');
    });
</script>

@endsection