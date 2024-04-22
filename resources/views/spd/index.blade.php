@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <a href="{{ route('spd.download-excel', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-success btn-2x me-2">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </a>

                        <a href="{{ route('spd.download-pdf', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-danger btn-2x me-2">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah SPD
                        </button>

                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah SPD</h5>
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
                        <form id="uploadForm" action="{{ route('spd.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
                            @csrf
                            <i class="fas fa-file-excel  fa-sm"></i>
                            <input type="file" name="file" class="rounded">
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
                        <a href="{{ route('spd') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                        <!-- Filter data berdasarkan tahun magang-->
                        <form action="{{ route('spd.filterByDate') }}" method="GET" class="ms-3" id="filterForm">
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
                    <h6>Data Surat Perjalanan Dinas</h6>
                </div>
                <form id="filterNamaProgramForm" class="ms-3" action="{{ route('spd.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Nomor SPD, atau Departemen">
                </form>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Nomor SPD</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Dept</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        WBS</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        PR</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        PO </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        SES</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        MIR7</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Dari</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Tujuan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Tanggal Dinas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Keterangan Dinas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Biaya DPD</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        RKAP</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        ACCRUAL</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Submit Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1 @endphp
                                @foreach ($spds as $spd)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $spd->nomor_spd }}</td>
                                    <td style="font-size: 14px;">{{ $spd->nama }}</td>
                                    <td style="font-size: 14px;">{{ $spd->dept }}</td>
                                    <td style="font-size: 14px;">{{ $spd->wbs }}</td>
                                    <td style="font-size: 14px;">{{ $spd->pr }}</td>
                                    <td style="font-size: 14px;">{{ $spd->po }}</td>
                                    <td style="font-size: 14px;">{{ $spd->ses }}</td>
                                    <td style="font-size: 14px;">{{ $spd->mir7 }}</td>
                                    <td style="font-size: 14px;">{{ $spd->dari }}</td>
                                    <td style="font-size: 14px;">{{ $spd->tujuan }}</td>
                                    <td style="font-size: 14px;">{{ $spd->tanggal_dinas  }}</td>
                                    <td style="font-size: 14px;">{{ $spd->keterangan_dinas }}</td>
                                    <td style="font-size: 14px;">{{ $spd->rkap }}</td>
                                    <td style="font-size: 14px;">{{ $spd->accrual }}</td>
                                    <td style="font-size: 14px;">{{ $spd->submit_tgl }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target=".modalEdit" data-id="{{ $spd->id }}">Edit</a>
                                        <form action="{{ route('spd.destroy', $spd->id) }}" method="POST" class="d-inline deleteForm" data-id="{{ $spd->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                <!-- Modal edit data -->

                                @endforeach
                            </tbody>
                            </tbody>
                        </table>

                        <div class="d-flex">
                            {{ $spds->links() }}
                        </div>

                        <div class="float-start">
                            <p class="text-muted">
                                Showing {{ $spds->firstItem() }} to {{ $spds->lastItem() }} of {{ $spds->total() }} entries
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
                        </script>

                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>
</main>

@endsection