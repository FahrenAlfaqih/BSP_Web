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
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah PR Reimburst
                        </button>
                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah PR Reimburst</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <!-- Form untuk menambahkan data -->
                                        <form action="{{ route('prreimburst.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="idReimburstPR" class="form-label">Nomor PR Reimburst</label>
                                                <input type="text" class="form-control" id="idReimburstPR" name="idReimburstPR" maxlength="10" oninput="checkLength()">
                                            </div>
                                            <div class="mb-3">
                                                <label for="judulPekerjaan" class="form-label">Judul Pekerjaan</label>
                                                <input type="text" class="form-control" id="judulPekerjaan" name="judulPekerjaan">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Upload file excel -->
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
                        <!-- Modal informasi-->
                        <div class="modal fade" id="modalInformasi" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Contoh format Excel yang diterima</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <img src="../assets/img/ContohExcel/PR.png" class="img-fluid" alt="Contoh Isi Excel">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Reload data terbaru-->
                        <a href="{{ route('prreimburst') }}" class="btn btn-light btn-2x me-2">
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
            <!-- Table PR -->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Purchase Request Reimburst</h6>
                </div>
                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('prreimburst.filterData') }}" method="GET">
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
                                        Nomor PR Reimburst</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Judul Pekerjaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($prreimbursts->currentPage() - 1) * $prreimbursts->perPage() + 1 @endphp
                                @foreach ($prreimbursts as $prreimburst)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $prreimburst->idReimburstPR }}</td>
                                    <td style="font-size: 14px;">{{ $prreimburst->judulPekerjaan }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $prreimburst->idReimburstPR }}">Edit</a>
                                        <form action="{{ route('prreimburst.destroy', $prreimburst->idReimburstPR) }}" method="POST" class="d-inline deleteForm" data-id="{{ $prreimburst->idReimburstPR }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                <!-- Modal edit data -->
                                <div class="modal fade" id="modalEdit{{ $prreimburst->idReimburstPR }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit PR Reimburst</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                                <!-- Form untuk mengedit data -->
                                                <form action="{{ route('prreimburst.edit', $prreimburst->idReimburstPR) }}" method="POST" class="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="idReimburstPR" class="form-label">Nomor PR Reimburst</label>
                                                        <input type="number" class="form-control" id="idReimburstPR" name="idReimburstPR" value="{{ $prreimburst->idReimburstPR }}" maxlength="10" oninput="checkLength()">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="judulPekerjaan" class="form-label">Judul Pekerjaan</label>
                                                        <input type="text" class="form-control" id="judulPekerjaan" name="judulPekerjaan" value="{{ $prreimburst->judulPekerjaan }}">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="button" class="btn btn-primary saveChangesBtn">Simpan Perubahan</button>
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
                                Showing {{ $prreimbursts->firstItem() }} to {{ $prreimbursts->lastItem() }} of {{ $prreimbursts->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($prreimbursts->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $prreimbursts->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($prreimbursts->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $prreimbursts->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $prreimbursts->currentPage() - 2); $i <= min($prreimbursts->lastPage(), $prreimbursts->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($prreimbursts->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $prreimbursts->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($prreimbursts->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $prreimbursts->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($prreimbursts->currentPage() == $prreimbursts->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $prreimbursts->url($prreimbursts->lastPage()) }}" aria-label="Last">
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
                            //Limit Karakter pada Nomor PR
                            function checkLength() {
                                const idReimburstPR = document.getElementById('idReimburstPR');
                                if (idReimburstPR.value.length > 10) {
                                    idReimburstPR.value = idReimburstPR.value.slice(0, 10);
                                }
                            }
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
                            //Menampilkan notif jika file excel belum diinputkan tetapi sudah pencet unggah
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
                            //Notif untuk berhasil atau error saat input data
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
                            //Agar data dapat tersimpan
                            document.addEventListener('DOMContentLoaded', function() {
                                const saveButtons = document.querySelectorAll('.saveChangesBtn');
                                saveButtons.forEach(button => {
                                    button.addEventListener('click', function() {
                                        const form = this.closest('.modal-content').querySelector('.editForm');
                                        form.submit();
                                    });
                                });
                            });
                            //Notif untuk berhasil atau error saat update data
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
                            //Notifikasi untuk menampilkan pesan sukses atau eror saat upload file excel
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