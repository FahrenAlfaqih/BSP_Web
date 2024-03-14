@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">

                        <a href="{{ route('magang.download-pdf', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-danger btn-2x me-2">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>


                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah magang
                        </button>

                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah magang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                        <form action="{{ route('magang.store') }}" method="POST" class="row g-3">
                                            @csrf
                                            <!-- Isi formulir dengan input yang sesuai -->
                                            <div class="col-md-6">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="institusi" class="form-label">Institusi</label>
                                                <input type="text" class="form-control" id="institusi" name="institusi">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="dept" class="form-label">Departemen</label>
                                                <select class="form-select" id="dept" name="dept">
                                                    <!-- Tambahkan opsi nilai departemen di sini -->
                                                    <option value="">Pilih Departemen</option> <!-- Opsi default kosong -->
                                                    <option value="QHSE">QHSE</option>
                                                    <option value="PROD. OPERATION">PROD. OPERATION</option>
                                                    <option value="EA">EA</option>
                                                    <option value="EPT">EPT</option>
                                                    <option value="HR">HR</option>
                                                    <option value="FINEC">FINEC</option>
                                                    <option value="DWO">DWO</option>
                                                    <option value="IT Pekanbaru">IT Pekanbaru</option>
                                                    <option value="Production Operation Dept">Production Operation Dept</option>
                                                    <option value="OS Dept (Pedada)">OS Dept (Pedada)</option>
                                                    <option value="IT Zamrud">IT Zamrud</option>
                                                    <option value="HCM Dept (OPC)">HCM Dept (OPC)</option>
                                                    <option value="HCM Dept">HCM Dept</option>
                                                    <option value="QHSE Dept">QHSE Dept</option>
                                                    <option value="Corporate Secretary">Corporate Secretary</option>
                                                    <option value="EA Dept">EA Dept</option>
                                                    <!-- Tambahkan opsi nilai departemen di sini -->
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="kategori" class="form-label">Jenjang Pendidikan</label>
                                                <input type="text" class="form-control" id="kategori" name="kategori">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="jurusan_fakultas" class="form-label">Jurusan / Fakultas</label>
                                                <input type="text" class="form-control" id="jurusan_fakultas" name="jurusan_fakultas">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggalMulai" class="form-label">Tanggal Pelaksanaan Mulai</label>
                                                <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggalSelesai" class="form-label">Tanggal Pelaksanaan Selesai</label>
                                                <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="kegiatan" class="form-label">Kegiatan</label>
                                                <select class="form-select" id="kegiatan" name="kegiatan">
                                                    <!-- Tambahkan opsi-opsi kegiatan di sini -->
                                                    <option value="PKL">PKL</option>
                                                    <option value="KP">KP</option>
                                                    <option value="MAGANG">MAGANG</option>
                                                    <option value="Izin Penelitian">Izin Penelitian</option>
                                                    <option value="RISET PENELITIAN">RISET PENELITIAN</option>
                                                    <option value="JOB TRAINING">JOB TRAINING</option>
                                                    <option value="MAGANG GURU">MAGANG GURU</option>
                                                    <option value="TA">TA</option>
                                                    <option value="On Job Training">On Job Training</option>
                                                    <option value="MAGANG/KP">MAGANG/KP</option>
                                                    <option value="Tugas Akhir">Tugas Akhir</option>
                                                    <option value="Kerja Praktek">Kerja Praktek</option>
                                                    <option value="pra Riset">pra Riset</option>
                                                    <option value="Penelitian Master">Penelitian Master</option>
                                                    <!-- Tambahkan opsi-opsi kegiatan di sini -->
                                                </select>
                                            </div>


                                            <div class="col-md-6">
                                                <label for="daring_luring" class="form-label">Jenis Pelaksanaan</label>
                                                <select class="form-select" id="daring_luring" name="daring_luring">
                                                    <option value="OFFLINE">OFFLINE</option>
                                                    <option value="ONLINE">ONLINE</option>
                                                    <option value="HYBRID">HYBRID</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="lokasi" class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mentor" class="form-label">Nama Mentor</label>
                                                <input type="text" class="form-control" id="mentor" name="mentor">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="statusSurat" class="form-label">Status Surat</label>
                                                <select class="form-select" id="statusSurat" name="statusSurat">
                                                    <option value="OK">OK</option>
                                                    <option value="TIDAK OK">TIDAK OK</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <input type="text" class="form-control" id="keterangan" name="keterangan">
                                            </div>
                                            <!-- Tambahkan input lain sesuai kebutuhan -->
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- upload file excel -->

                        <form id="uploadForm" action="{{ route('magang.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
                            @csrf
                            <i class="fas fa-file-excel fa-sm"></i>
                            <input type="file" name="file[]" class="rounded" multiple>
                            <button type="submit" class="btn-outline-dark rounded">Unggah Excel</button>
                        </form>

                        <!-- Icon informasi -->
                        <a href="#" class="btn btn-light btn-2x me-2" data-bs-toggle="modal" data-bs-target="#modalInformasi">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </a>

                        <!-- Modal Informasi-->
                        <div class="modal fade" id="modalInformasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Contoh format Excel yang diterima</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <img src="../assets/img/contohExcel.png" class="img-fluid" alt="Contoh Isi Excel">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Reload Data Terbaru-->
                        <a href="{{ route('magang') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                        <!-- Filter data berdasarkan tahun magang-->
                        <form action="{{ route('magang.filterByDate') }}" method="GET" class="ms-3" id="filterForm">
                            <div class="d-flex">
                                <!-- Filter data berdasarkan tahun sertifikasi -->
                                <div class="me-3">
                                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                        <option value="">Tahun</option>
                                        @for ($i = 2003; $i <= 2024; $i++) <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>

                                <!-- Filter data berdasarkan bulan sertifikasi -->
                                <div>
                                    <select name="bulan" id="bulan" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                        <option value="">Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>


            </div>
            <!-- Table Sertifkasi -->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data magang</h6>
                </div>
                <form id="filterNamaProgramForm" class="ms-3" action="{{ route('magang.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Institusi, atau Departemen">
                </form>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Institusi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Kategori</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Jurusan/Fakultas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Tanggal Mulai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Tanggal Selesai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Kegiatan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Dept</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Daring/Luring</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Lokasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Mentor</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Status Surat</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Keterangan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1 @endphp
                                @foreach ($magangs as $magang)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $magang->nama }}</td>
                                    <td style="font-size: 14px;">{{ $magang->institusi }}</td>
                                    <td style="font-size: 14px;">{{ $magang->kategori }}</td>
                                    <td style="font-size: 14px;">{{ $magang->jurusan_fakultas }}</td>
                                    <td style="font-size: 14px;">{{ $magang->tanggalMulai }}</td>
                                    <td style="font-size: 14px;">{{ $magang->tanggalSelesai }}</td>
                                    <td style="font-size: 14px;">{{ $magang->kegiatan }}</td>
                                    <td style="font-size: 14px;">{{ $magang->dept }}</td>
                                    <td style="font-size: 14px;">{{ $magang->daring_luring }}</td>
                                    <td style="font-size: 14px;">{{ $magang->lokasi }}</td>
                                    <td style="font-size: 14px;">{{ $magang->mentor }}</td>
                                    <td style="font-size: 14px;">{{ $magang->statusSurat }}</td>
                                    <td style="font-size: 14px;">{{ $magang->keterangan }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target=".modalEdit" data-id="{{ $magang->id }}">Edit</a>
                                        <form action="{{ route('magang.destroy', $magang->id) }}" method="POST" class="d-inline deleteForm" data-id="{{ $magang->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                <!-- Modal edit data -->
                                <div class="modal fade modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditLabel">Edit magang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body " style="max-height: 450px; overflow-y: auto;">
                                                <!-- Form untuk mengedit magang -->
                                                <form action="{{ route('magang.edit', $magang->id) }}" method="POST" id="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-6">
                                                        <label for="nama" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $magang->nama }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="institusi" class="form-label">Institusi</label>
                                                        <input type="text" class="form-control" id="institusi" name="institusi" value="{{ $magang->institusi }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="dept" class="form-label">Departemen</label>
                                                        <select class="form-select" id="dept" name="dept" value="{{ $magang->dept }}">
                                                            <!-- Tambahkan opsi nilai departemen di sini -->
                                                            <option value="">Pilih Departemen</option> <!-- Opsi default kosong -->
                                                            <option value="QHSE">QHSE</option>
                                                            <option value="PROD. OPERATION">PROD. OPERATION</option>
                                                            <option value="EA">EA</option>
                                                            <option value="EPT">EPT</option>
                                                            <option value="HR">HR</option>
                                                            <option value="FINEC">FINEC</option>
                                                            <option value="DWO">DWO</option>
                                                            <option value="IT Pekanbaru">IT Pekanbaru</option>
                                                            <option value="Production Operation Dept">Production Operation Dept</option>
                                                            <option value="OS Dept (Pedada)">OS Dept (Pedada)</option>
                                                            <option value="IT Zamrud">IT Zamrud</option>
                                                            <option value="HCM Dept (OPC)">HCM Dept (OPC)</option>
                                                            <option value="HCM Dept">HCM Dept</option>
                                                            <option value="QHSE Dept">QHSE Dept</option>
                                                            <option value="Corporate Secretary">Corporate Secretary</option>
                                                            <option value="EA Dept">EA Dept</option>
                                                            <!-- Tambahkan opsi nilai departemen di sini -->
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="kategori" class="form-label">Jenjang Pendidikan</label>
                                                        <input type="text" class="form-control" id="kategori" name="kategori" value="{{ $magang->kategori }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="jurusan_fakultas" class="form-label">Jurusan / Fakultas</label>
                                                        <input type="text" class="form-control" id="jurusan_fakultas" name="jurusan_fakultas" value="{{ $magang->jurusan_fakultas }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggalMulai" class="form-label">Tanggal Pelaksanaan Mulai</label>
                                                        <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai" value="{{ $magang->tanggalMulai }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggalSelesai" class="form-label">Tanggal Pelaksanaan Selesai</label>
                                                        <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai"  value="{{ $magang->tanggalSelesai}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="kegiatan" class="form-label">Kegiatan</label>
                                                        <select class="form-select" id="kegiatan" name="kegiatan" value="{{ $magang->kegiatan}}">
                                                            <!-- Tambahkan opsi-opsi kegiatan di sini -->
                                                            <option value="PKL">PKL</option>
                                                            <option value="KP">KP</option>
                                                            <option value="MAGANG">MAGANG</option>
                                                            <option value="Izin Penelitian">Izin Penelitian</option>
                                                            <option value="RISET PENELITIAN">RISET PENELITIAN</option>
                                                            <option value="JOB TRAINING">JOB TRAINING</option>
                                                            <option value="MAGANG GURU">MAGANG GURU</option>
                                                            <option value="TA">TA</option>
                                                            <option value="On Job Training">On Job Training</option>
                                                            <option value="MAGANG/KP">MAGANG/KP</option>
                                                            <option value="Tugas Akhir">Tugas Akhir</option>
                                                            <option value="Kerja Praktek">Kerja Praktek</option>
                                                            <option value="pra Riset">pra Riset</option>
                                                            <option value="Penelitian Master">Penelitian Master</option>
                                                            <!-- Tambahkan opsi-opsi kegiatan di sini -->
                                                        </select>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <label for="daring_luring" class="form-label">Jenis Pelaksanaan</label>
                                                        <select class="form-select" id="daring_luring" name="daring_luring" value="{{ $magang->daring_luring}}">
                                                            <option value="OFFLINE">OFFLINE</option>
                                                            <option value="ONLINE">ONLINE</option>
                                                            <option value="HYBRID">HYBRID</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="lokasi" class="form-label">Lokasi</label>
                                                        <input type="text" class="form-control" id="lokasi" name="lokasi"  value="{{ $magang->lokasi}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="mentor" class="form-label">Nama Mentor</label>
                                                        <input type="text" class="form-control" id="mentor" name="mentor" value="{{ $magang->mentor}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="statusSurat" class="form-label">Status Surat</label>
                                                        <select class="form-select" id="statusSurat" name="statusSurat" value="{{ $magang->statusSurat}}">
                                                            <option value="OK">OK</option>
                                                            <option value="TIDAK OK">TIDAK OK</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $magang->keterangan}}">
                                                    </div>
                                                    <!-- Tambahkan input lainnya sesuai kebutuhan -->
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-primary" id="saveChangesBtn">Simpan Perubahan</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                            </tbody>
                        </table>

                        <div class="d-flex">
                            {{ $magangs->links() }}
                        </div>

                        <div class="float-start">
                            <p class="text-muted">
                                Showing {{ $magangs->firstItem() }} to {{ $magangs->lastItem() }} of {{ $magangs->total() }} entries
                            </p>
                        </div>

                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                        <script>
                            //Konfirmasi untuk hapus data
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

                            //script agar tahun pada tanggalPelaksanaanMulai dan Selesai otomatis terubah sesuai dengan
                            //Tahun magang yang diinputkan sebelumnya
                            document.addEventListener('DOMContentLoaded', function() {
                                // Ambil elemen input tahunmagang
                                var tahunmagangInput = document.getElementById('tahunmagang');

                                // Ambil elemen input tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                var tanggalPelaksanaanMulaiInput = document.getElementById('tanggalPelaksanaanMulai');
                                var tanggalPelaksanaanSelesaiInput = document.getElementById('tanggalPelaksanaanSelesai');

                                // Tambahkan event listener ketika nilai tahunmagang berubah
                                tahunmagangInput.addEventListener('change', function() {
                                    // Ambil nilai tahunmagang
                                    var tahunmagang = tahunmagangInput.value;

                                    // Periksa apakah tahunmagang memiliki nilai
                                    if (tahunmagang) {
                                        // Set nilai tahun pada tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                        tanggalPelaksanaanMulaiInput.value = tahunmagang + '-01-01'; // Tanggal mulai diatur menjadi 01 Januari tahunmagang
                                        tanggalPelaksanaanSelesaiInput.value = tahunmagang + '-12-31'; // Tanggal selesai diatur menjadi 31 Desember tahunmagang
                                    } else {
                                        // Kosongkan nilai tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai jika tahunmagang tidak memiliki nilai
                                        tanggalPelaksanaanMulaiInput.value = '';
                                        tanggalPelaksanaanSelesaiInput.value = '';
                                    }
                                });
                            });

                            //unutk menampilkan notif jika file excel belum diinputkan tetapi sudah pencet unggah
                            document.addEventListener('DOMContentLoaded', function() {
                                const uploadForm = document.querySelector('#uploadForm');
                                const submitButton = document.querySelector('#submitBtn');

                                uploadForm.addEventListener('submit', function(event) {
                                    // Periksa apakah file sudah dipilih
                                    if (!document.querySelector('input[name="file"]').files[0]) {
                                        event.preventDefault();
                                        swal({
                                            title: "Oops...",
                                            text: "Anda belum memilih file!",
                                            icon: "error",
                                        });
                                    }
                                });
                            });

                            //notif untuk berhasil atau error saat input data
                            document.addEventListener('DOMContentLoaded', function() {
                                const successMessage = "{{ session('success_add') }}";
                                const errorMessage = "{{ session('error_add') }}";

                                if (successMessage) {
                                    swal({
                                        title: "Sukses",
                                        text: successMessage,
                                        icon: "success",
                                    });
                                }

                                if (errorMessage) {
                                    swal({
                                        title: "Error",
                                        text: errorMessage,
                                        icon: "error",
                                    });
                                }
                            });


                            document.getElementById('saveChangesBtn').addEventListener('click', function() {
                                document.getElementById('editForm').submit();
                            });

                            //notif untuk berhasil atau error saat update data
                            document.addEventListener('DOMContentLoaded', function() {
                                const successMessage = "{{ session('success_update') }}";
                                const errorMessage = "{{ session('error_update') }}";

                                if (successMessage) {
                                    swal({
                                        title: "Sukses",
                                        text: successMessage,
                                        icon: "success",
                                    });
                                }

                                if (errorMessage) {
                                    swal({
                                        title: "Error",
                                        text: errorMessage,
                                        icon: "error",
                                    });
                                }
                            });


                            //notifikasi untuk menampilkan pesan sukses atau eror saat upload file excel
                            document.addEventListener('DOMContentLoaded', function() {
                                const successMessage = "{{ session('success_message') }}";
                                const errorMessage = "{{ session('error_message') }}";

                                if (successMessage) {
                                    swal({
                                        title: "Sukses",
                                        text: successMessage,
                                        icon: "success",
                                    });
                                }

                                if (errorMessage) {
                                    swal({
                                        title: "Error",
                                        text: errorMessage,
                                        icon: "error",
                                    });
                                }
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