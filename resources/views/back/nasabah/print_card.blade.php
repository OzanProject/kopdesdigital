<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Kartu Anggota</title>
    <style>
        @media print {
            body { 
                -webkit-print-color-adjust: exact; 
                margin: 0;
                padding: 0;
            }
            @page {
                size: A4;
                margin: 0; /* Let grid handle margins */
            }
        }

        body {
            font-family: Arial, sans-serif;
            background: #eee;
        }

        .page-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            padding: 10mm; /* Margin for printer */
            box-sizing: border-box;
        }

        .card-container {
            width: 85.6mm;
            height: 53.98mm;
            border: 1px solid #ccc; /* Cut guide */
            margin: 2mm;
            position: relative;
            background: linear-gradient(135deg, #004d40 0%, #00695c 100%);
            color: white;
            border-radius: 4px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .card-bg-pattern {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            opacity: 0.1;
            background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, #fff 10px, #fff 12px);
            z-index: 0;
        }

        .card-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
        }

        /* Left Side: Photo & QR */
        .left-col {
            width: 30%;
            background: rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 5px;
        }

        .photo-box {
            width: 25mm;
            height: 30mm;
            background: #fff;
            margin-bottom: 5px;
            border: 2px solid #fff;
            overflow: hidden;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .qr-box {
            width: 20mm;
            height: 20mm;
            background: #fff;
            padding: 2px;
        }

        /* Right Side: Biodata */
        .right-col {
            width: 70%;
            padding: 10px 15px;
            position: relative;
        }

        .logo-area {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            padding-bottom: 5px;
        }

        .logo-area img {
            height: 30px;
            margin-right: 10px;
        }

        .coop-name {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .coop-address {
            font-size: 6pt;
            opacity: 0.8;
        }

        .member-info {
            font-size: 8pt;
        }

        .info-row {
            margin-bottom: 4px;
        }

        .label {
            display: inline-block;
            width: 55px;
            opacity: 0.8;
            font-size: 7pt;
        }

        .value {
            font-weight: bold;
        }

        .member-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            text-transform: uppercase;
        }

        .card-footer-strip {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 5mm;
            background: #ffc107;
            color: #333;
            font-size: 6pt;
            text-align: right;
            padding-right: 10px;
            line-height: 5mm;
            font-weight: bold;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page-container">
        @foreach($nasabahs as $nasabah)
        <div class="card-container">
            <div class="card-bg-pattern"></div>
            <div class="card-footer-strip">KARTU ANGGOTA</div>
            <div class="card-content">
                <div class="left-col">
                    <div class="photo-box">
                        @if($nasabah->foto)
                            <img src="{{ asset('storage/' . $nasabah->foto) }}" alt="Foto">
                        @else
                            <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" alt="Foto">
                        @endif
                    </div>
                </div>
                <div class="right-col">
                    <div class="logo-area">
                        @if(Auth::user()->koperasi->logo)
                            <img src="{{ asset('storage/' . Auth::user()->koperasi->logo) }}" alt="Logo">
                        @else
                            <!-- Placeholder Logo -->
                             <span style="font-size:20px; margin-right:5px;">🏦</span>
                        @endif
                        <div>
                            <div class="coop-name">{{ Auth::user()->koperasi->nama }}</div>
                            <div style="font-size: 6pt; font-weight: bold;">BH No: {{ Auth::user()->koperasi->no_badan_hukum ?? '-' }}</div>
                            <div class="coop-address">{{ Str::limit(Auth::user()->koperasi->alamat, 40) }}</div>
                        </div>
                    </div>

                    <div class="member-info">
                        <span class="member-name">{{ $nasabah->nama }}</span>
                        
                        <div class="info-row">
                            <span class="label">NO. ANG</span>
                            <span class="value">{{ $nasabah->no_anggota }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">BERGABUNG</span>
                            <span class="value">{{ \Carbon\Carbon::parse($nasabah->tanggal_bergabung)->format('d M Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">PEKERJAAN</span>
                            <span class="value">{{ $nasabah->pekerjaan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
