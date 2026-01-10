<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .amount { text-align: right; }
        .total { font-weight: bold; background-color: #eee; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <table style="border: none; margin-bottom: 20px;">
            <tr style="border: none;">
                <td style="border: none; width: 80px; text-align: center;">
                    @if($koperasi && $koperasi->logo)
                        <img src="{{ asset('storage/' . $koperasi->logo) }}" alt="Logo" style="width: 70px;">
                    @else
                         <h1 style="margin:0;">🏦</h1>
                    @endif
                </td>
                <td style="border: none; text-align: center;">
                    <h2 style="margin: 0; text-transform: uppercase;">{{ $koperasi->nama ?? 'Koperasi Simpan Pinjam' }}</h2>
                    <p style="margin: 2px 0; font-size: 11px; font-weight: bold;">Badan Hukum No: {{ $koperasi->no_badan_hukum ?? '-' }}</p>
                    <p style="margin: 2px 0; font-size: 11px;">{{ $koperasi->alamat ?? 'Alamat Belum Diatur' }}</p>
                    <p style="margin: 0; font-size: 11px;">Email: {{ $koperasi->email ?? '-' }} | Telp: {{ $koperasi->telp ?? '-' }}</p>
                </td>
            </tr>
        </table>
        <hr style="border-top: 2px solid black; border-bottom: 1px solid black; height: 1px; margin-top: 5px;">
        
        <h3 style="text-align: center; margin-bottom: 5px;">{{ $title }}</h3>
        <p style="text-align: center; margin-top: 0;">Periode: {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}</p>
    </div>

    @if($jenis == 'simpanan')
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal_transaksi->format('d/m/Y') }}</td>
                    <td>{{ $item->nasabah->no_anggota }}</td>
                    <td>{{ $item->nasabah->nama }}</td>
                    <td>{{ ucfirst($item->jenis) }}</td>
                    <td class="amount">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @php $total += $item->jumlah; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="5" style="text-align: center;">TOTAL TRANSAKSI</td>
                    <td class="amount">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

    @elseif($jenis == 'pinjaman')
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Pengajuan</th>
                    <th>Anggota</th>
                    <th>Jumlah Pengajuan</th>
                    <th>Jumlah Disetujui</th>
                    <th>Tenor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPengajuan = 0; $totalDisetujui = 0; @endphp
                @foreach($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td>{{ $item->nasabah->nama }}</td>
                    <td class="amount">Rp {{ number_format($item->jumlah_pengajuan, 0, ',', '.') }}</td>
                    <td class="amount">Rp {{ number_format($item->jumlah_disetujui, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->tenor_bulan }} Bln</td>
                    <td style="text-align: center;">
                        @if($item->status == 'approved') <span style="font-weight:bold;">Disetujui</span>
                        @elseif($item->status == 'pending') Pending
                        @elseif($item->status == 'rejected') Ditolak
                        @elseif($item->status == 'lunas') Lunas
                        @endif
                    </td>
                </tr>
                @php 
                    $totalPengajuan += $item->jumlah_pengajuan;
                    $totalDisetujui += $item->jumlah_disetujui;
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="3" style="text-align: center;">TOTAL</td>
                    <td class="amount">Rp {{ number_format($totalPengajuan, 0, ',', '.') }}</td>
                    <td class="amount">Rp {{ number_format($totalDisetujui, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>

    @elseif($jenis == 'anggota')
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Telepon</th>
                    <th>Tgl Bergabung</th>
                    <th>Total Simpanan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->no_anggota }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->user->email ?? $item->no_hp ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td class="amount">Rp {{ number_format($item->total_simpanan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($jenis == 'shu')
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Buku</th>
                    <th>Total SHU</th>
                    <th>Dibagikan ke Anggota</th>
                    <th>Jasa Modal (%)</th>
                    <th>Jasa Usaha (%)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $item->tahun }}</td>
                    <td class="amount">Rp {{ number_format($item->total_shu, 0, ',', '.') }}</td>
                    <td class="amount">Rp {{ number_format($item->total_dibagikan, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->persentase_modal }}%</td>
                    <td style="text-align: center;">{{ $item->persentase_usaha }}%</td>
                    <td style="text-align: center;">{{ ucfirst($item->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($jenis == 'cashflow')
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan Transaksi</th>
                    <th>Masuk (In)</th>
                    <th>Keluar (Out)</th>
                </tr>
            </thead>
            <tbody>
                @php $totalIn = 0; $totalOut = 0; @endphp
                @foreach($data as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                    <td>
                        <b>{{ $item['source'] }}</b><br>
                        <small>{{ $item['desc'] }}</small>
                    </td>
                    <td class="amount" style="color: green;">
                        @if($item['type'] == 'Masuk')
                            Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            @php $totalIn += $item['amount']; @endphp
                        @else - @endif
                    </td>
                    <td class="amount" style="color: red;">
                        @if($item['type'] == 'Keluar')
                            Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            @php $totalOut += $item['amount']; @endphp
                        @else - @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="3" style="text-align: center;">TOTAL MUTASI</td>
                    <td class="amount" style="color: green;">Rp {{ number_format($totalIn, 0, ',', '.') }}</td>
                    <td class="amount" style="color: red;">Rp {{ number_format($totalOut, 0, ',', '.') }}</td>
                </tr>
                <tr style="background-color: #ddd; font-weight: bold;">
                    <td colspan="3" style="text-align: center;">NET CASHFLOW (SURPLUS/DEFISIT)</td>
                    <td colspan="2" style="text-align: center; font-size: 14px;">
                        Rp {{ number_format($totalIn - $totalOut, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif

    <table style="border: none; margin-top: 40px;">
        <tr style="border: none;">
            <td style="border: none; width: 60%;"></td>
            <td style="border: none; text-align: center;">
                <p>Dicetak di: {{ $koperasi->kota ?? 'Indonesia' }}, {{ now()->format('d M Y') }}</p>
                <p>Mengetahui,</p>
                <br><br><br>
                <p><b><u>{{ Auth::user()->name }}</u></b></p>
                <p>Administrator</p>
            </td>
        </tr>
    </table>
</body>
</html>
