@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">

                        <a href="{{ route('prreimburst.download-excel', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-success btn-2x me-2">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </a>

                        <a href="{{ route('poreimburst.download-pdf', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-danger btn-2x me-2">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>


                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah prreimburst
                        </button>

                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah prreimburst</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <!-- Isi formulir di sini -->
                                        <form action="{{ route('prreimburst.store') }}" method="POST">
                                            @csrf
                                            <!-- Isi formulir dengan input yang sesuai -->
                                            <div class="mb-3">
                                                <label for="idReimburstPR" class="form-label">Nomor PR Reimburst</label>
                                                <input type="number" class="form-control" id="idReimburstPR" name="idReimburstPR">
                                            </div>
                                            <div class="mb-3">
                                                <label for="judulPekerjaan" class="form-label">Judul Pekerjaan</label>
                                                <input type="text" class="form-control" id="judulPekerjaan" name="judulPekerjaan">
                                            </div>
                                            <!-- Tambahkan input lain sesuai kebutuhan -->
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- upload file excel -->
                        <form id="uploadForm" action="{{ route('prreimburst.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
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
                        <a href="{{ route('magang') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>

                        <form id="myForm" class="ms-3">
                            <select name="pilihan" id="pilihan" class="form-select" style="min-width: 130px;">
                                <option value="Non Ada">PR Non Ada</option>
                                <option value="Service">PR Service</option>
                                <option value="Reimburst">PR Reimburst</option>
                            </select>
                        </form>


                    </div>
                </div>


            </div>
            <!-- Table Sertifkasi -->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Purchase Request Non Ada</h6>
                </div>
                <form id="filterNamaProgramForm" class="ms-3" action="{{ route('prreimburst.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Institusi, atau Departemen">
                </form>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Nomor PR </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Judul Pekerjaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1 @endphp
                                @foreach ($prreimbursts as $prreimburst)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $prreimburst->idReimburstPR }}</td>
                                    <td style="font-size: 14px;">{{ $prreimburst->judulPekerjaan }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target=".modalEdit" data-id="{{ $prreimburst->idReimburstPR }}">Edit</a>
                                        <form action="{{ route('prreimburst.destroy', $prreimburst->idReimburstPR) }}" method="POST" class="d-inline deleteForm" data-id="{{ $prreimburst->idReimburstPR }}">
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
                                                <h5 class="modal-title" id="modalEditLabel">Edit prreimburst</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body " style="max-height: 450px; overflow-y: auto;">
                                                <!-- Form untuk mengedit prreimburst -->
                                                <form action="{{ route('prreimburst.edit', $prreimburst->idReimburstPR) }}" method="POST" id="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Isi form sesuai kebutuhan -->
                                                    <div class="mb-3">
                                                        <label for="noPek" class="form-label">Nomor Pekerja</label>
                                                        <input type="number" class="form-control" id="noPek" name="noPek" value="{{ $prreimburst->noPek }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="namaPekerja" class="form-label">Nama Pekerja</label>
                                                        <input type="text" class="form-control" id="namaPekerja" name="namaPekerja" value="{{ $prreimburst->namaPekerja }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="dept" class="form-label">Nama Departemen</label>
                                                        <select class="form-select" id="dept" name="dept">
                                                            <option>{{ $prreimburst->dept}}</option>
                                                            <option value="SPRM">SPRM</option>
                                                            <option value="Corporate Secretary">Corporate Secretary</option>
                                                            <option value="Exploration">Exploration</option>
                                                            <option value="Exploitation">Exploitation</option>
                                                            <option value="Production Operation">Production Operation</option>
                                                            <option value="Drilling & Worker">Drilling & Worker</option>
                                                            <option value="Operation Support">Operation Support</option>
                                                            <option value="HCM">HCM</option>
                                                            <option value="SCM">SCM</option>
                                                            <option value="Internal Audit">Internal Audit</option>
                                                            <option value="External Affair">External Affair</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="namaProgram" class="form-label">Nama Program</label>
                                                        <input type="text" class="form-control" id="namaProgram" name="namaProgram" value="{{ $prreimburst->namaProgram }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tahunprreimburst" class="form-label">Tahun prreimburst</label>
                                                        <input type="number" class="form-control" id="tahunprreimburst" name="tahunprreimburst" value="{{ $prreimburst->tahunprreimburst }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggalPelaksanaanMulai" class="form-label">Tanggal Pelaksanaan Mulai</label>
                                                        <input type="date" class="form-control" id="tanggalPelaksanaanMulai" name="tanggalPelaksanaanMulai" value="{{ $prreimburst->tanggalPelaksanaanMulai }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggalPelaksanaanSelesai" class="form-label">Tanggal Pelaksanaan Selesai</label>
                                                        <input type="date" class="form-control" id="tanggalPelaksanaanSelesai" name="tanggalPelaksanaanSelesai" value="{{ $prreimburst->tanggalPelaksanaanSelesai }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tempat" class="form-label">Tempat</label>
                                                        <input type="text" class="form-control" id="tempat" name="tempat" value="{{ $prreimburst->tempat }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="days" class="form-label">Jumlah Hari</label>
                                                        <input type="text" class="form-control" id="days" name="days" value="{{ $prreimburst->days }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="namaPenyelenggara" class="form-label">Nama Penyelenggara</label>
                                                        <input type="text" class="form-control" id="namaPenyelenggara" name="namaPenyelenggara" value="{{ $prreimburst->namaPenyelenggara }}">
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

                        <div class="float-start">
                            <p class="text-muted">
                                Showing {{ $prreimbursts->firstItem() }} to {{ $prreimbursts->lastItem() }} of {{ $prreimbursts->total() }} entries
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
                            //Tahun prreimburst yang diinputkan sebelumnya
                            document.addEventListener('DOMContentLoaded', function() {
                                // Ambil elemen input tahunprreimburst
                                var tahunprreimburstInput = document.getElementById('tahunprreimburst');

                                // Ambil elemen input tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                var tanggalPelaksanaanMulaiInput = document.getElementById('tanggalPelaksanaanMulai');
                                var tanggalPelaksanaanSelesaiInput = document.getElementById('tanggalPelaksanaanSelesai');

                                // Tambahkan event listener ketika nilai tahunprreimburst berubah
                                tahunprreimburstInput.addEventListener('change', function() {
                                    // Ambil nilai tahunprreimburst
                                    var tahunprreimburst = tahunprreimburstInput.value;

                                    // Periksa apakah tahunprreimburst memiliki nilai
                                    if (tahunprreimburst) {
                                        // Set nilai tahun pada tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                        tanggalPelaksanaanMulaiInput.value = tahunprreimburst + '-01-01'; // Tanggal mulai diatur menjadi 01 Januari tahunprreimburst
                                        tanggalPelaksanaanSelesaiInput.value = tahunprreimburst + '-12-31'; // Tanggal selesai diatur menjadi 31 Desember tahunprreimburst
                                    } else {
                                        // Kosongkan nilai tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai jika tahunprreimburst tidak memiliki nilai
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