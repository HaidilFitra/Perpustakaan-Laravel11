<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-danger {
            color: red;
        }

        .email {
            font-size: 12px;
            color: #666;
        }

        .kop-surat {
            margin-bottom: 30px;
            position: relative;
            padding-top: 20px;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 100px;
            height: auto;
        }

        .header-text {
            text-align: center;
            margin-left: 120px;
        }

        .header-text h2 {
            font-size: 24px;
            margin: 0 0 10px 0;
            line-height: 1.2;
        }

        .header-text p {
            font-size: 14px;
            margin: 5px 0;
            line-height: 1.4;
        }

        .divider {
            clear: both;
            border-bottom: 3px solid #000;
            margin-top: 20px;
            margin-bottom: 5px;
        }

        .divider-2 {
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            right: 0;
            width: 200px;
            text-align: center;
            padding: 20px 0;
        }

        .signature {
            margin-top: 15px;
        }

        .signature-image {
            width: 150px;
            height: auto;
            margin-bottom: -20px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 10px auto;
        }

        .footer p {
            margin: 3px 0;
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <img src="{{ public_path('img/logo-smk.jpeg') }}" class="logo" alt="Logo">
        <div class="header-text">
            <h2>PERPUSTAKAAN LITERALINK</h2>
            <p>Jl. Muchtar Latief, Padang Sikabu, Kec. Lamposi Tigo Nagori, Kota Payakumbuh, Sumatera Barat 26219</p>
            <p>Telp: (021) 1234567 | Email: perpustakaan@literalink.com</p>
        </div>
        <div class="divider"></div>
        <div class="divider-2"></div>
    </div>

    <h3 style="text-align: center;">LAPORAN PEMINJAMAN BUKU</h3>
    <div class="periode">
        @php
            $date = request('date', date('Y-m-d'));
            $period = request('period', 'daily');
            
            switch($period) {
                case 'daily':
                    $periodText = 'Tanggal: ' . date('d F Y', strtotime($date));
                    break;
                case 'weekly':
                    $startWeek = date('d F Y', strtotime('monday this week', strtotime($date)));
                    $endWeek = date('d F Y', strtotime('sunday this week', strtotime($date)));
                    $periodText = "Periode: $startWeek - $endWeek";
                    break;
                case 'monthly':
                    $periodText = 'Periode: ' . date('F Y', strtotime($date));
                    break;
            }
        @endphp
        {{ $periodText }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $index => $pinjam)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ $pinjam->user->nama_lengkap }}<br>
                    <span class="email">{{ $pinjam->user->email }}</span>
                </td>
                <td>{{ $pinjam->buku->judul }}</td>
                <td>{{ \Carbon\Carbon::parse($pinjam->TanggalPeminjaman)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($pinjam->TanggalPengembalian)->format('d/m/Y') }}</td>
                <td>
                    @if($pinjam->pengembalian)
                        {{ $pinjam->pengembalian->Status }}
                        @php
                            $terlambat = \Carbon\Carbon::parse($pinjam->TanggalPengembalian)->diffInDays(\Carbon\Carbon::parse($pinjam->pengembalian->TanggalPengembalian), false);
                            $denda = $terlambat > 0 ? $terlambat * 1000 : 0; // Denda Rp 1.000 per hari
                        @endphp
                        @if($terlambat > 0)
                            <br><span class="text-danger">(Terlambat {{ $terlambat }} hari)</span>
                            <br><span class="text-danger">Denda: Rp {{ number_format($denda, 0, ',', '.') }}</span>
                        @endif
                    @else
                        {{ $pinjam->Status }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>{{ Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
        <p>Kepala Perpustakaan</p>
        <div class="signature">
            <img src="{{ public_path('img/Tanda_tangan.png') }}" alt="Signature" class="signature-image">
            <div class="signature-line"></div>
            <p><strong>Yeni Nora Wiwi</strong></p>
            <p>NIP. 123456789</p>
        </div>
    </div>
</body>

</html>