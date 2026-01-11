<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Kartu Anggota Digital</title>
    <style>
        /* Google Fonts untuk tampilan profesional */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        @media print {
            body { 
                -webkit-print-color-adjust: exact; 
                margin: 0;
                padding: 0;
                background: white;
            }
            @page {
                size: A4;
                margin: 0;
            }
            .no-print { display: none; }
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }

        .page-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            padding: 10mm;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card-container {
            width: 85.6mm;
            height: 53.98mm;
            margin: 3mm;
            position: relative;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            border-radius: 12px;
            overflow: hidden;
            page-break-inside: avoid;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Dekorasi Glossy & Pattern Modern */
        .card-decoration {
            position: absolute;
            top: -20%;
            right: -10%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.2) 0%, transparent 70%);
            z-index: 0;
        }

        .card-bg-overlay {
            position: absolute;
            bottom: 0; left: 0; right: 0; top: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
        }

        .card-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
        }

        /* Sisi Kiri: Foto */
        .left-col {
            width: 32%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-left: 10px;
        }

        .photo-wrapper {
            width: 24mm;
            height: 32mm;
            background: #334155;
            border-radius: 8px;
            border: 2px solid rgba(255,255,255,0.2);
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        .photo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Sisi Kanan: Biodata */
        .right-col {
            width: 68%;
            padding: 12px 15px;
            display: flex;
            flex-direction: column;
        }

        .header-card {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            padding-bottom: 6px;
        }

        .header-card img {
            height: 24px;
            margin-right: 8px;
            filter: brightness(0) invert(1); /* Pastikan logo putih */
        }

        .coop-name {
            font-size: 8pt;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .coop-meta {
            font-size: 5pt;
            color: rgba(255,255,255,0.6);
            font-weight: 400;
        }

        .member-main {
            flex-grow: 1;
        }

        .member-name {
            font-size: 10pt;
            font-weight: 700;
            color: #38bdf8; /* Warna highlight biru muda */
            margin-bottom: 8px;
            text-transform: uppercase;
            display: block;
        }

        .data-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 4px;
        }

        .data-item {
            display: flex;
            flex-direction: column;
        }

        .data-label {
            font-size: 5pt;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 1px;
        }

        .data-value {
            font-size: 7.5pt;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .footer-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #0d6efd;
            padding: 4px 15px;
            border-top-left-radius: 12px;
            font-size: 6pt;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .chip-icon {
            width: 25px;
            height: 20px;
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            border-radius: 4px;
            margin-bottom: 10px;
            opacity: 0.8;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page-container">
        @foreach($nasabahs as $nasabah)
        <div class="card-container">
            <div class="card-decoration"></div>
            <div class="card-bg-overlay"></div>
            <div class="footer-badge">MEMBER CARD</div>
            
            <div class="card-content">
                <div class="left-col">
                    <div class="photo-wrapper">
                        @if($nasabah->foto)
                            <img src="{{ asset('storage/' . $nasabah->foto) }}" alt="Foto">
                        @else
                            <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" alt="Default">
                        @endif
                    </div>
                </div>

                <div class="right-col">
                    <div class="header-card">
                        @if(Auth::user()->koperasi->logo)
                            <img src="{{ asset('storage/' . Auth::user()->koperasi->logo) }}" alt="Logo">
                        @else
                            <span style="font-size:18px; margin-right:8px;">🏦</span>
                        @endif
                        <div>
                            <div class="coop-name">{{ Auth::user()->koperasi->nama }}</div>
                            <div class="coop-meta">BH: {{ Auth::user()->koperasi->no_badan_hukum ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="member-main">
                        <div class="chip-icon"></div>
                        <span class="member-name">{{ Str::limit($nasabah->nama, 25) }}</span>
                        
                        <div class="data-grid">
                            <div class="data-item">
                                <span class="data-label">ID Anggota</span>
                                <span class="data-value">{{ $nasabah->no_anggota }}</span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Tanggal Bergabung</span>
                                <span class="data-value">{{ \Carbon\Carbon::parse($nasabah->tanggal_bergabung)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.close()" style="padding: 10px 20px; border-radius: 5px; cursor: pointer; background: #333; color: white; border: none;">Tutup Halaman</button>
    </div>
</body>
</html>