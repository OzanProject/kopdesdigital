<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page { size: A4; margin: 15mm; }
        body { font-family: 'Times New Roman', serif; font-size: 11pt; line-height: 1.4; color: #000; margin: 0; padding: 0; }
        
        /* Kop Surat */
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-box { width: 80px; text-align: center; }
        .logo-box img { max-width: 70px; height: auto; }
        .instansi-box { text-align: center; }
        .instansi-box h2 { margin: 0; font-size: 16pt; text-transform: uppercase; letter-spacing: 1px; }
        .instansi-box p { margin: 2px 0; font-size: 9pt; font-family: sans-serif; }

        /* Judul Laporan */
        .report-title { text-align: center; margin-bottom: 25px; }
        .report-title h3 { margin: 0; text-decoration: underline; font-size: 14pt; }
        .report-title p { margin: 5px 0; font-style: italic; font-size: 10pt; }

        /* Tabel Akuntansi */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 8px; font-size: 10pt; text-transform: uppercase; }
        td { border: 1px solid #000; padding: 6px 8px; font-size: 10pt; vertical-align: top; }
        
        .amount { text-align: right; font-family: 'Courier New', Courier, monospace; font-weight: bold; }
        .center { text-align: center; }
        .total-row { background-color: #eee; font-weight: bold; }
        
        /* Tanda Tangan */
        .ttd-container { margin-top: 50px; width: 100%; }
        .ttd-box { float: right; width: 250px; text-align: center; }
        .ttd-space { height: 70px; }
        
        .text-green { color: #006400; }
        .text-red { color: #8b0000; }
    </style>
</head>
<body onload="window.print()">
    <div class="kop-surat">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none;" class="logo-box">
                    @if($koperasi && $koperasi->logo)
                        <img src="{{ asset('storage/' . $koperasi->logo) }}" alt="Logo">
                    @else
                        <span style="font-size: 40pt;">🏦</span>
                    @endif
                </td>
                <td style="border: none;" class="instansi-box">
                    <h2>{{ $koperasi->nama ?? 'Koperasi Digital Indonesia' }}</h2>
                    <p>Badan Hukum No: {{ $koperasi->no_badan_hukum ?? '-' }}</p>
                    <p>{{ $koperasi->alamat ?? 'Alamat belum diatur dalam sistem' }}</p>
                    <p>Kontak: {{ $koperasi->telp ?? '-' }} | Email: {{ $koperasi->email ?? '-' }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="report-title">
        <h3>{{ $title }}</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($start_date)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($end_date)->format('d F Y') }}</p>
    </div>

    @if($jenis == 'simpanan')
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Tgl Transaksi</th>
                    <th>ID & Nama Anggota</th>
                    <th>Jenis Simpanan</th>
                    <th style="width: 25%">Jumlah Setoran</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($data as $item)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="center">{{ $item->tanggal_transaksi->format('d/m/Y') }}</td>
                    <td><b>{{ $item->nasabah->no_anggota }}</b><br>{{ $item->nasabah->nama }}</td>
                    <td class="center">{{ strtoupper($item->jenis) }}</td>
                    <td class="amount">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @php $total += $item->jumlah; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="center">TOTAL PENERIMAAN SIMPANAN</td>
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
                    <th>Plafond (Rp)</th>
                    <th>Tenor</th>
                    <th>Bunga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $totalDisetujui = 0; @endphp
                @foreach($data as $item)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="center">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td>{{ $item->nasabah->nama }}</td>
                    <td class="amount">Rp {{ number_format($item->jumlah_disetujui ?: $item->jumlah_pengajuan, 0, ',', '.') }}</td>
                    <td class="center">{{ $item->tenor_bulan }} Bln</td>
                    <td class="center">{{ $item->bunga_persen }}%</td>
                    <td class="center">{{ strtoupper($item->status) }}</td>
                </tr>
                @php $totalDisetujui += ($item->jumlah_disetujui ?: $item->jumlah_pengajuan); @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="center">TOTAL PINJAMAN DISALURKAN</td>
                    <td class="amount">Rp {{ number_format($totalDisetujui, 0, ',', '.') }}</td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>

    @elseif($jenis == 'cashflow')
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Tanggal</th>
                    <th>Keterangan Transaksi</th>
                    <th>Debet (Masuk)</th>
                    <th>Kredit (Keluar)</th>
                </tr>
            </thead>
            <tbody>
                @php $totalIn = 0; $totalOut = 0; @endphp
                @foreach($data as $item)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                    <td><b>{{ $item['source'] }}</b><br><small>{{ $item['desc'] }}</small></td>
                    <td class="amount text-green">
                        @if($item['type'] == 'Masuk')
                            {{ number_format($item['amount'], 0, ',', '.') }}
                            @php $totalIn += $item['amount']; @endphp
                        @else - @endif
                    </td>
                    <td class="amount text-red">
                        @if($item['type'] == 'Keluar')
                            {{ number_format($item['amount'], 0, ',', '.') }}
                            @php $totalOut += $item['amount']; @endphp
                        @else - @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="center">TOTAL MUTASI PERIODE INI</td>
                    <td class="amount text-green">Rp {{ number_format($totalIn, 0, ',', '.') }}</td>
                    <td class="amount text-red">Rp {{ number_format($totalOut, 0, ',', '.') }}</td>
                </tr>
                <tr style="background-color: #000; color: #fff;">
                    <td colspan="3" class="center">SURPLUS / DEFISIT (NET)</td>
                    <td colspan="2" class="center" style="font-size: 12pt;">
                        Rp {{ number_format($totalIn - $totalOut, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif

    <div class="ttd-container">
        <div class="ttd-box">
            <p>{{ $koperasi->kota ?? 'Indonesia' }}, {{ now()->format('d F Y') }}</p>
            <p>Pejabat Berwenang,</p>
            <div class="ttd-space"></div>
            <p><b><u>{{ Auth::user()->name }}</u></b></p>
            <p>Administrator Sistem</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div style="margin-top: 30px; text-align: center; border-top: 1px dashed #ccc; padding-top: 10px;">
        <small style="color: #666;">Dokumen ini dihasilkan secara otomatis oleh {{ config('app.name') }} dan sah secara sistem.</small>
    </div>
</body>
</html>