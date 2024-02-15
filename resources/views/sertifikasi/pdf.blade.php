<!-- resources/views/sertifikasi/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Sertifikasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #000; /* Garis bawah */
            padding-bottom: 10px; /* Jarak dari garis bawah */
        }
        .logo {
            width: 100px; /* Sesuaikan dengan lebar logo */
            height: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT. Bumi Siak Pusako</h1>
        <p>Gedung Surya Dumai LT. 6 Jalan Jendral Sudirman No.395</p>
        <p>Pekanbaru 2866 - INDONESIA</p>
    </div>
    <p>Berikut lampiran data rekap sertifikasi PT Bumi Siak Pusako : </p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NoPek</th>
                <th>Nama Pekerja</th>
                <th>Dept</th>
                <th>Nama Program</th>
                <th>Tahun Sertifikasi</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Days</th>
                <th>Tempat</th>
                <th>Nama Penyelenggara</th>
                <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
            </tr>
        </thead>
        <tbody>
            @foreach($sertifikasis as $sertifikasi)
            <tr>
                <td>{{ $sertifikasi->id }}</td>
                <td>{{ $sertifikasi->noPek }}</td>
                <td>{{ $sertifikasi->namaPekerja }}</td>
                <td>{{ $sertifikasi->dept }}</td>
                <td>{{ $sertifikasi->namaProgram }}</td>
                <td>{{ $sertifikasi->tahunSertifikasi }}</td>
                <td>{{ $sertifikasi->tanggalPelaksanaanMulai }}</td>
                <td>{{ $sertifikasi->tanggalPelaksanaanSelesai }}</td>
                <td>{{ $sertifikasi->days }}</td>
                <td>{{ $sertifikasi->tempat }}</td>
                <td>{{ $sertifikasi->namaPenyelenggara }}</td>
                <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
