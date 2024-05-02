@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <a href="{{ route('prservice.download-excel', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-success btn-2x me-2">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </a>
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah PR Service
                        </button>
                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah PR Service</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <!-- Isi formulir di sini -->
                                        <form action="{{ route('pr.storePrService') }}" method="POST">
                                            @csrf
                                            <!-- Isi formulir dengan input yang sesuai -->
                                            <div class="mb-3">
                                                <label for="idServicePR" class="form-label">Nomor PR Service</label>
                                                <input type="number" class="form-control" id="idServicePR" name="idServicePR">
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
                        <form id="uploadForm" action="{{ route('prservice.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
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
                                        <img src="../assets/img/contohExcelTransaksi.png" class="img-fluid" alt="Contoh Isi Excel">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Reload Data Terbaru-->
                        <a href="{{ route('prservice') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                        <form id="myForm" class="ms-3">
                            <select name="pilihan" id="pilihan" class="form-select" style="min-width: 130px;">
                                <!-- Di dalam tag select -->
                                <option value="reimburst" {{ session('selected_option') == 'prreimburst' ? 'selected' : '' }}>PR Reimburst</option>
                                <option value="service" {{ session('selected_option') == 'prservice' ? 'selected' : '' }}>PR Service</option>
                                <option value="nonada" {{ session('selected_option') == 'prnonada' ? 'selected' : '' }}>PR Non Ada</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Table Sertifkasi -->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Purchase Request Service</h6>
                </div>
                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('prservice.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nomor PR atau Judul Pekerjaan">
                </form>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nomor Purchase Request Service </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Judul Pekerjaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($prservices->currentPage() - 1) * $prservices->perPage() + 1 @endphp
                                @foreach ($prservices as $prservice)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $prservice->idServicePR }}</td>
                                    <td style="font-size: 14px;">{{ $prservice->judulPekerjaan }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target=".modalEdit" data-id="{{ $prservice->idServicePR }}">Edit</a>
                                        <form action="{{ route('prservice.destroy', $prservice ->idServicePR) }}" method="POST" class="d-inline deleteForm" data-id="{{ $prservice->idServicePR }}">
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
                                                <h5 class="modal-title" id="modalEditLabel">Edit PR Service</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body " style="max-height: 450px; overflow-y: auto;">
                                                <!-- Form untuk mengedit prservice -->
                                                <form action="{{ route('prservice.edit', $prservice->idServicePR ) }}" method="POST" id="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Isi form sesuai kebutuhan -->
                                                    <div class="mb-3">
                                                        <label for="idServicePR " class="form-label">Nomor PR Service</label>
                                                        <input type="number" class="form-control" id="idServicePR" name="idServicePR" value="{{ $prservice->idServicePR  }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="judulPekerjaan" class="form-label">Nama Pekerja</label>
                                                        <input type="text" class="form-control" id="judulPekerjaan" name="judulPekerjaan" value="{{ $prservice->judulPekerjaan }}">
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
                        </table>
                        <!-- Pagination -->
                        <div class="float-start mx-2">
                            <p class="text-muted">
                                Showing {{ $prservices->firstItem() }} to {{ $prservices->lastItem() }} of {{ $prservices->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($prservices->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $prservices->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($prservices->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $prservices->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $prservices->currentPage() - 2); $i <= min($prservices->lastPage(), $prservices->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($prservices->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $prservices->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($prservices->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $prservices->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($prservices->currentPage() == $prservices->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $prservices->url($prservices->lastPage()) }}" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>

                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                        <script>
                            document.getElementById('myForm').addEventListener('change', function(event) {
                                event.preventDefault(); // Mencegah formulir untuk melakukan submit
                                var selectedValue = document.getElementById('pilihan').value;
                                if (selectedValue === 'reimburst') {
                                    window.location.href = "{{ route('prreimburst') }}";
                                } else if (selectedValue === 'service') {
                                    window.location.href = "{{ route('prservice') }}";
                                } else if (selectedValue === 'nonada') {
                                    window.location.href = "{{ route('prnonada') }}";
                                }
                            });
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
</main>

@endsection