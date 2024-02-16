@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <!-- Tombol Download PDF -->
                        <a href="{{ route('sertifikasi.download-pdf') }}" class="btn btn-info btn-2x me-2">
                            <i class="fas fa-file-pdf"></i> Cetak Sertifikasi PDF
                        </a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Sertifikasi
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                        <!-- Isi formulir di sini -->
                                        <form action="{{ route('sertifikasi.store') }}" method="POST">
                                            @csrf
                                            <!-- Isi formulir dengan input yang sesuai -->
                                            <div class="mb-3">
                                                <label for="noPek" class="form-label">Nomor Pekerja</label>
                                                <input type="number" class="form-control" id="noPek" name="noPek">
                                            </div>
                                            <div class="mb-3">
                                                <label for="namaPekerja" class="form-label">Nama Pekerja</label>
                                                <input type="text" class="form-control" id="namaPekerja" name="namaPekerja">
                                            </div>
                                            <div class="mb-3">
                                                <label for="dept" class="form-label">Nama Departemen</label>
                                                <input type="text" class="form-control" id="dept" name="dept">
                                            </div>
                                            <div class="mb-3">
                                                <label for="namaProgram" class="form-label">Nama Program</label>
                                                <input type="text" class="form-control" id="namaProgram" name="namaProgram">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tahunSertifikasi" class="form-label">Tahun Sertifikasi</label>
                                                <input type="number" class="form-control" id="tahunSertifikasi" name="tahunSertifikasi">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggalPelaksanaanMulai" class="form-label">Tanggal Pelaksanaan Mulai</label>
                                                <input type="date" class="form-control" id="tanggalPelaksanaanMulai" name="tanggalPelaksanaanMulai">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggalPelaksanaanSelesai" class="form-label">Tanggal Pelaksanaan Selesai</label>
                                                <input type="date" class="form-control" id="tanggalPelaksanaanSelesai" name="tanggalPelaksanaanSelesai">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tempat" class="form-label">Tempat</label>
                                                <input type="text" class="form-control" id="tempat" name="tempat">
                                            </div>
                                            <div class="mb-3">
                                                <label for="days" class="form-label">Jumlah Hari</label>
                                                <input type="text" class="form-control" id="days" name="days">
                                            </div>
                                            <div class="mb-3">
                                                <label for="namaPenyelenggara" class="form-label">Nama Penyelenggara</label>
                                                <input type="text" class="form-control" id="namaPenyelenggara" name="namaPenyelenggara">
                                            </div>
                                            <!-- Tambahkan input lain sesuai kebutuhan -->
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <a href="{{ route('sertifikasi.download-pdf') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-file-excel  fa-sm"></i> Upload file Sertifikasi
                        </a>
                        <!-- Filter Dropdown -->
                        <form action="{{ route('sertifikasi.filterYear') }}" method="GET" class="ms-3">
                            <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                @for ($i = 2002; $i <= 2021; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </form>
                    </div>
                </div>


            </div>


            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Tabel Sertifikasi</h6>
                </div>
                <form id="filterNamaProgramForm" class="ms-3" action="{{ route('sertifikasi.filterNamaProgram') }}" method="GET">
                    <input type="text" name="namaProgram" id="namaProgram" class="form-control" placeholder="Cari Berdasarkan Nama Program">
                </form>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NoPek</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Pekerja</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dept</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Program</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal Mulai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal Selesai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Days</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tempat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Penyelenggara</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1 @endphp
                                @foreach ($sertifikasis as $sertifikasi)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $sertifikasi->noPek }}</td>
                                    <td>{{ $sertifikasi->namaPekerja }}</td>
                                    <td>{{ $sertifikasi->dept }}</td>
                                    <td>{{ $sertifikasi->namaProgram }}</td>
                                    <td>{{ $sertifikasi->tanggalPelaksanaanMulai }}</td>
                                    <td>{{ $sertifikasi->tanggalPelaksanaanSelesai }}</td>
                                    <td>{{ $sertifikasi->days }}</td>
                                    <td>{{ $sertifikasi->tempat }}</td>
                                    <td>{{ $sertifikasi->namaPenyelenggara }}</td>
                                    <td>
                                        <a href="{{ route('sertifikasi.edit', $sertifikasi->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <form action="{{ route('sertifikasi.destroy', $sertifikasi->id) }}" method="POST" class="d-inline deleteForm" data-id="{{ $sertifikasi->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                @endforeach
                            </tbody>
                        </table>



                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const deleteButtons = document.querySelectorAll('.deleteButton');

                                deleteButtons.forEach(button => {
                                    button.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const deleteForm = this.parentElement;
                                        const id = deleteForm.getAttribute('data-id');

                                        swal({
                                            title: "Apakah Anda yakin?",
                                            text: "Data akan dihapus permanen.",
                                            icon: "warning",
                                            buttons: true,
                                            dangerMode: true,
                                        }).then((willDelete) => {
                                            if (willDelete) {
                                                swal("Data berhasil dihapus!", {
                                                    icon: "success",
                                                }).then(() => {
                                                    deleteForm.submit();
                                                    // Setelah data terhapus, segarkan halaman setelah 1 detik
                                                    setTimeout(function() {
                                                        location.reload();
                                                    }, 1000);
                                                });
                                            } else {
                                                swal("Data tidak jadi dihapus.", {
                                                    icon: "info",
                                                });
                                            }
                                        });
                                    });
                                });
                            });

                            // Ambil elemen input untuk tanggal mulai dan selesai
                            const inputMulai = document.getElementById('tanggalPelaksanaanMulai');
                            const inputSelesai = document.getElementById('tanggalPelaksanaanSelesai');
                            const inputDays = document.getElementById('days');

                            // Tambahkan event listener untuk perubahan nilai tanggal
                            inputMulai.addEventListener('change', hitungJumlahHari);
                            inputSelesai.addEventListener('change', hitungJumlahHari);

                            // Fungsi untuk menghitung jumlah hari
                            function hitungJumlahHari() {
                                // Ambil nilai dari kedua input tanggal
                                const tanggalMulai = new Date(inputMulai.value);
                                const tanggalSelesai = new Date(inputSelesai.value);

                                // Hitung selisih hari antara kedua tanggal
                                const selisihHari = Math.ceil((tanggalSelesai - tanggalMulai) / (1000 * 3600 * 24));

                                // Masukkan nilai selisih hari ke dalam input days
                                inputDays.value = selisihHari;
                            }
                        </script>

                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>
</main>

@endsection