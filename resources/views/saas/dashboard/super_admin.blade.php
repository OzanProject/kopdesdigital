@extends('layouts.admin')

@section('title', 'Control Panel Super Admin')

@section('content')

<!-- Realtime Clock Widget -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card bg-gradient-dark shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="mb-0"><i class="far fa-clock mr-2"></i> Waktu Server Realtime</h5>
                    <small class="text-white-50">Zona Waktu Sistem: <strong>{{ config('app.timezone') }}</strong></small>
                </div>
                <h3 class="mb-0 font-weight-bold" id="server-clock">{{ now()->translatedFormat('H:i:s') }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Row 1: Key Metrics -->
<div class="row">
    <!-- Tenants -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalKoperasi }}</h3>
                <p>Total Koperasi (Tenant)</p>
            </div>
            <div class="icon"><i class="fas fa-building"></i></div>
            <a href="{{ route('koperasi.index') }}" class="small-box-footer">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- Revenue -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup>{{ number_format($estimatedRevenue, 0, ',', '.') }}</h3>
                <p>Est. Pendapatan Bulanan</p>
            </div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            <a href="{{ route('subscription-packages.index') }}" class="small-box-footer">Kelola Paket <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- Support Tickets -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingTickets }}</h3>
                <p>Tiket Support (Pending)</p>
            </div>
            <div class="icon"><i class="fas fa-headset"></i></div>
            <a href="{{ route('support-tickets.index') }}" class="small-box-footer">Segera Tangani <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- Active Users -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalActiveUsers }}</h3>
                <p>Total User Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('global-users.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Row 2: Charts -->
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Pertumbuhan Tenant (6 Bulan Terakhir)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="growthChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">Popularitas Paket Langganan</h3>
            </div>
            <div class="card-body">
                <canvas id="packageChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Activity & Helper Stats -->
<div class="row">
    <!-- Left: New Tenants -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Pendaftaran Koperasi Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0 table-striped">
                        <thead>
                        <tr>
                            <th>Nama Koperasi</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Tanggal Gabung</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($newKoperasis as $kop)
                        <tr>
                            <td>{{ $kop->nama }}</td>
                            <td><span class="badge badge-info">{{ $kop->subscriptionPackage->name ?? 'Free' }}</span></td>
                            <td>
                                @if($kop->status == 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-warning">{{ ucfirst($kop->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $kop->created_at->translatedFormat('d M Y') }}</td>
                            <td>
                                <a href="{{ route('koperasi.edit', $kop->id) }}" class="btn btn-xs btn-primary"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pendaftaran baru.</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <a href="{{ route('koperasi.create') }}" class="btn btn-sm btn-info float-left">Tambah Koperasi</a>
                <a href="{{ route('koperasi.index') }}" class="btn btn-sm btn-secondary float-right">Lihat Semua</a>
            </div>
        </div>
    </div>

    <!-- Right: Knowledge Base Stats -->
    <div class="col-md-4">
        <div class="card card-secondary card-outline">
            <div class="card-header">
                <h3 class="card-title">Statistik Pusat Bantuan</h3>
            </div>
            <div class="card-body">
                <div class="info-box mb-3 bg-light">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Artikel</span>
                        <span class="info-box-number">{{ $totalArticles }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-light">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-eye"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Dilihat (Views)</span>
                        <span class="info-box-number">{{ number_format($totalArticleViews) }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-block btn-outline-primary btn-sm">Kelola Artikel</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<!-- ChartJS -->
<script src="{{ asset('adminlte3/plugins/chart.js/Chart.min.js') }}"></script>
<script>
$(document).ready(function() {
    // --- 1. Realtime Clock Logic ---
    var serverTime = new Date("{{ now()->format('Y-m-d H:i:s') }}");
    function updateClock() {
        serverTime.setSeconds(serverTime.getSeconds() + 1);
        var hours = String(serverTime.getHours()).padStart(2, '0');
        var minutes = String(serverTime.getMinutes()).padStart(2, '0');
        var seconds = String(serverTime.getSeconds()).padStart(2, '0');
        $('#server-clock').text(hours + ':' + minutes + ':' + seconds);
    }
    setInterval(updateClock, 1000);

    // --- 2. Chart Configurations ---
    
    // Growth Chart (Line)
    var ctxGrowth = document.getElementById('growthChart').getContext('2d');
    var growthChart = new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Tenant Baru',
                data: {!! json_encode($data) !!},
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 2,
                pointRadius: 4,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            },
            tooltips: {
                mode: 'index',
                intersect: false
            }
        }
    });

    // Package Chart (Pie)
    var ctxPie = document.getElementById('packageChart').getContext('2d');
    var packageChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($pieLabels) !!},
            datasets: [{
                data: {!! json_encode($pieData) !!},
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                position: 'bottom'
            }
        }
    });
});
</script>
@endpush
