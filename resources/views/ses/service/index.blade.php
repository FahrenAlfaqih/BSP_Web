@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <a href="{{ route('sesservice.download-excel', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-success btn-2x me-2">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </a>
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah SES Service
                        </button>
                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah SES Service</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <!-- Form untuk menambahkan data -->
                                        <form action="{{ route('sesservice.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="idServiceSES" class="form-label">Nomor SES Service</label>
                                                <input type="text" class="form-control" id="idServiceSES" name="idServiceSES">
                                            </div>
                                            <div class="mb-3">
                                                <label for="idServicePO" class="form-label">Pilih PO Service</label>
                                                <select class="form-select" id="idServicePO" name="idServicePO">
                                                    @foreach($poservices as $poservice)
                                                    <option value="{{ $poservice->idServicePO }}">
                                                        {{ $poservice->idServicePO }} - {{ $poservice->judulPekerjaan }}
                                                    </option>
                                                    @endforeach
                                                </select>
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
                        <!-- <form id="uploadForm" action="{{ route('poreimburst.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
                            @csrf
                            <i class="fas fa-file-excel  fa-sm"></i>
                            <input type="file" name="file" class="rounded">
                            <button type="submit" class="btn-outline-dark rounded">Unggah Excel</button>
                        </form> -->
                        <!-- Icon informasi -->
                        <!-- <a href="#" class="btn btn-light btn-2x me-2" data-bs-toggle="modal" data-bs-target="#modalInformasi">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </a> -->
                        <!-- Modal informasi-->
                        <!-- <div class="modal fade" id="modalInformasi" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Contoh format Excel yang diterima</h5>
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
                        </div> -->
                        <!-- Reload data terbaru -->
                        <a href="{{ route('sesservice') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                        <form id="myForm" class="ms-3">
                            <select name="pilihan" id="pilihan" class="form-select" style="min-width: 130px;">
                                <!-- Di dalam tag select -->
                                <option value="reimburst" {{ session('selected_option') == 'sesreimburst' ? 'selected' : '' }}>SES Reimburst</option>
                                <option value="service" {{ session('selected_option') == 'sesservice' ? 'selected' : '' }}>SES Service</option>
                                <option value="nonada" {{ session('selected_option') == 'sesnonada' ? 'selected' : '' }}>SES Non Ada</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Table SES -->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Service Entry Sheet Service</h6>
                </div>
                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('sesservice.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nomor SES, Nomor PO atau Judul Pekerjaan">
                </form>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nomor SES Service </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nomor PO Service </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Judul Pekerjaan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($sesservices->currentPage() - 1) * $sesservices->perPage() + 1 @endphp
                                @foreach ($sesservices as $sesservice)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $sesservice->idServiceSES   }}</td>
                                    <td style="font-size: 14px;">{{ $sesservice->idServicePO   }}</td>
                                    <td style="font-size: 14px;">{{ $sesservice->judulPekerjaan }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $sesservice->idServiceSES }}">Edit</a>
                                        <form action="{{ route('sesservice.destroy', $sesservice->idServiceSES) }}" method="POST" class="d-inline deleteForm" data-id="{{ $sesservice->idServiceSES  }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                <!-- Modal edit data -->
                                <div class="modal fade" id="modalEdit{{ $sesservice->idServiceSES }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit SES Service</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body " style="max-height: 450px; overflow-y: auto;">
                                            <!-- Form untuk mengedit data -->
                                                <form action="{{ route('sesservice.edit', $sesservice->idServiceSES) }}" method="POST" id="editForm" class="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="idServiceSES" class="form-label">Nomor SES Service</label>
                                                        <input type="text" class="form-control" id="idServiceSES" name="idServiceSES" value="{{ $sesservice->idServiceSES }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="idServicePO" class="form-label">Pilih PO Service</label>
                                                        <select class="form-select" id="idServicePO" name="idServicePO">
                                                            @foreach($poservices as $poservice)
                                                            <option value="{{ $poservice->idServicePO }}" {{ $poservice->idServicePO == $poservice->idServicePO ? 'selected' : '' }}>
                                                                {{ $poservice->idServicePO }} - {{ $poservice->judulPekerjaan }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="judulPekerjaan" class="form-label">Judul Pekerjaan</label>
                                                        <input type="text" class="form-control" id="judulPekerjaan" name="judulPekerjaan" value="{{ $sesservice->judulPekerjaan }}">
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
                        <div class="float-start mx-2    ">
                            <p class="text-muted">
                                Showing {{ $sesservices->firstItem() }} to {{ $sesservices->lastItem() }} of {{ $sesservices->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($sesservices->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $sesservices->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($sesservices->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $sesservices->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $sesservices->currentPage() - 2); $i <= min($sesservices->lastPage(), $sesservices->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($sesservices->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $sesservices->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($sesservices->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $sesservices->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($sesservices->currentPage() == $sesservices->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $sesservices->url($sesservices->lastPage()) }}" aria-label="Last">
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
                                    window.location.href = "{{ route('sesreimburst') }}";
                                } else if (selectedValue === 'service') {
                                    window.location.href = "{{ route('sesservice') }}";
                                } else if (selectedValue === 'nonada') {
                                    window.location.href = "{{ route('sesnonada') }}";
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
                            //Tahun poreimburst yang diinputkan sebelumnya
                            document.addEventListener('DOMContentLoaded', function() {
                                // Ambil elemen input tahunporeimburst
                                var tahunporeimburstInput = document.getElementById('tahunporeimburst');
                                // Ambil elemen input tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                var tanggalPelaksanaanMulaiInput = document.getElementById('tanggalPelaksanaanMulai');
                                var tanggalPelaksanaanSelesaiInput = document.getElementById('tanggalPelaksanaanSelesai');
                                // Tambahkan event listener ketika nilai tahunporeimburst berubah
                                tahunporeimburstInput.addEventListener('change', function() {
                                    // Ambil nilai tahunporeimburst
                                    var tahunporeimburst = tahunporeimburstInput.value;
                                    // Periksa apakah tahunporeimburst memiliki nilai
                                    if (tahunporeimburst) {
                                        // Set nilai tahun pada tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                        tanggalPelaksanaanMulaiInput.value = tahunporeimburst + '-01-01'; // Tanggal mulai diatur menjadi 01 Januari tahunporeimburst
                                        tanggalPelaksanaanSelesaiInput.value = tahunporeimburst + '-12-31'; // Tanggal selesai diatur menjadi 31 Desember tahunporeimburst
                                    } else {
                                        // Kosongkan nilai tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai jika tahunporeimburst tidak memiliki nilai
                                        tanggalPelaksanaanMulaiInput.value = '';
                                        tanggalPelaksanaanSelesaiInput.value = '';
                                    }
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