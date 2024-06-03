@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <a href="{{ route('pegawai.download-excel', ['search' => request()->input('search'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-success btn-2x me-2">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </a>
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Pegawai
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
                                        <form action="{{ route('pegawai.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="idReimburstPR" class="form-label">Nomor PR Reimburst</label>
                                                <input type="number" class="form-control" id="idReimburstPR" name="idReimburstPR">
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
                        <form id="uploadForm" action="{{ route('pegawai.upload-excel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
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
                        <a href="{{ route('pegawai') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                    </div>
                </div>
            </div>
            <!-- Table PR -->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Master Data Pegawai</h6>
                </div>
                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('pegawai.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nomor Pekerja atau Nama Pekerja">
                </form>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nomor Pekerja</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nama Pekerja</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Departemen</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($pegawais->currentPage() - 1) * $pegawais->perPage() + 1 @endphp
                                @foreach ($pegawais as $pegawai)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $pegawai->nopek }}</td>
                                    <td style="font-size: 14px;">{{ $pegawai->namaPekerja }}</td>
                                    <td style="font-size: 14px;">{{ $pegawai->dept }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $pegawai->nopek }}">Edit</a>
                                        <form action="{{ route('pegawai.destroy', $pegawai->nopek) }}" method="POST" class="d-inline deleteForm" data-id="{{ $pegawai->nopek }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                <!-- Modal edit data -->
                                <div class="modal fade" id="modalEdit{{ $pegawai->idReimburstPR }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit PR Reimburst</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                                <!-- Form untuk mengedit data -->
                                                <form action="{{ route('pegawai.edit', $pegawai->nopek) }}" method="POST" class="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="idReimburstPR" class="form-label">Nomor PR Reimburst</label>
                                                        <input type="number" class="form-control" id="idReimburstPR" name="idReimburstPR" value="{{ $pegawai->idReimburstPR }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="judulPekerjaan" class="form-label">Judul Pekerjaan</label>
                                                        <input type="text" class="form-control" id="judulPekerjaan" name="judulPekerjaan" value="{{ $pegawai->judulPekerjaan }}">
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
                                Showing {{ $pegawais->firstItem() }} to {{ $pegawais->lastItem() }} of {{ $pegawais->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($pegawais->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $pegawais->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($pegawais->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $pegawais->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $pegawais->currentPage() - 2); $i <= min($pegawais->lastPage(), $pegawais->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($pegawais->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $pegawais->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($pegawais->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $pegawais->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($pegawais->currentPage() == $pegawais->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $pegawais->url($pegawais->lastPage()) }}" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>

                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                        <script>
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
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection