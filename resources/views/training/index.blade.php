@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah Pelatihan
                        </button>
                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Pelatihan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <!-- Form untuk menambahkan data -->
                                        <form action="{{ route('training.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="judulPelatihan" class="form-label">Judul Pelatihan</label>
                                                <input type="text" class="form-control" id="judulPelatihan" name="judulPelatihan">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tglMulai" class="form-label">Tanggal Pelaksanaan Mulai</label>
                                                <input type="date" class="form-control" id="tglMulai" name="tglMulai">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tglSelesai" class="form-label">Tanggal Pelaksanaan Selesai</label>
                                                <input type="date" class="form-control" id="tglSelesai" name="tglSelesai">
                                            </div>
                                            <div class="mb-3">
                                                <label for="man" class="form-label">Man</label>
                                                <input type="number" class="form-control" id="man" name="man">
                                            </div>
                                            <div class="mb-3">
                                                <label for="days" class="form-label">Days</label>
                                                <input type="number" class="form-control" id="days" name="days">
                                            </div>
                                            <div class="mb-3">
                                                <label for="hours" class="form-label">Hours</label>
                                                <input type="number" class="form-control" id="hours" name="hours">
                                            </div>

                                            <div class="mb-3">
                                                <label for="total_man_hours" class="form-label">Total Man Hours</label>
                                                <input type="number" class="form-control" id="total_man_hours" name="total_man_hours">
                                            </div>
                                            <div class="mb-3">
                                                <label for="hse" class="form-label">HSE</label>
                                                <input type="number" class="form-control" id="hse" name="hse">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nonhse" class="form-label">Non HSE</label>
                                                <input type="number" class="form-control" id="nonhse" name="nonhse">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inhouse" class="form-label">Inhouse</label>
                                                <input type="number" class="form-control" id="inhouse" name="inhouse">
                                            </div>
                                            <div class="mb-3">
                                                <label for="sertifikasi" class="form-label">Sertifikasi</label>
                                                <input type="number" class="form-control" id="sertifikasi" name="sertifikasi">
                                            </div>
                                            <div class="mb-3">
                                                <label for="teknikal" class="form-label">Teknikal</label>
                                                <input type="number" class="form-control" id="teknikal" name="teknikal">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Upload file excel -->
                        <form id="uploadForm" action="{{ route('training.upload-excel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
                            @csrf
                            <i class="fas fa-file-excel fa-sm"></i>
                            <input type="file" name="file[]" class="rounded" multiple>
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
                                        <img src="../assets/img/ContohExcel/Sertifikasi.png" class="img-fluid" alt="Contoh Isi Excel">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Reload data terbaru -->
                        <a href="{{ route('training') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                        <!-- Filter data -->
                        <!-- <form action="{{ route('sertifikasi.filterByDate') }}" method="GET" class="ms-3" id="filterForm">
                            <div class="d-flex">
                                
                                <div class="me-3">
                                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                        <option value="">Tahun</option>
                                        @for ($i = 2003; $i <= 2024; $i++) <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>
                                
                                <div>
                                    <select name="bulan" id="bulan" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                        <option value="">Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                            @endfor
                                    </select>
                                </div>
                                <div style="margin-left: 10px;">
                                    <select name="dept" id="dept" onchange="this.form.submit()" class="form-select" style="min-width: 150px;">
                                        <option value="">Pilih Departemen</option>
                                        <option value="HSE" {{ request('dept') == 'HSE' ? 'selected' : '' }}>HSE</option>
                                        <option value="FM" {{ request('dept') == 'FM' ? 'selected' : '' }}>FM</option>
                                        <option value="IT" {{ request('dept') == 'IT' ? 'selected' : '' }}>IT</option>
                                        <option value="Prod Opts" {{ request('dept') == 'Prod Opts' ? 'selected' : '' }}>PROD OPERATION</option>
                                        <option value="SPRM" {{ request('dept') == 'SPRM' ? 'selected' : '' }}>SPRM</option>
                                        <option value="CPS" {{ request('dept') == 'CPS' ? 'selected' : '' }}>CPS</option>
                                        <option value="OS" {{ request('dept') == 'OS' ? 'selected' : '' }}>OS</option>
                                        <option value="DWO" {{ request('dept') == 'DWO' ? 'selected' : '' }}>DWO</option>
                                        <option value="EPT" {{ request('dept') == 'EPT' ? 'selected' : '' }}>EPT</option>
                                        <option value="EKS" {{ request('dept') == 'EKS' ? 'selected' : '' }}>EKS</option>
                                        <option value="QHSE Dept" {{ request('dept') == 'QHSE Dept' ? 'selected' : '' }}>QHSE</option>
                                        <option value="SCM" {{ request('dept') == 'SCM' ? 'selected' : '' }}>SCM</option>
                                        <option value="EA" {{ request('dept') == 'EA' ? 'selected' : '' }}>EA</option>
                                        <option value="IA" {{ request('dept') == 'IA' ? 'selected' : '' }}>IA</option>
                                        <option value="FINEC" {{ request('dept') == 'FINEC' ? 'selected' : '' }}>FINEC & ICT</option>
                                        <option value="HRM" {{ request('dept') == 'HRM' ? 'selected' : '' }}>HRM</option>
                                    </select>
                                </div>
                            </div>
                        </form> -->

                        <!-- <form action="{{ route('sertifikasi.filterByDept') }}" method="GET" class="ms-3" style="margin-bottom: 10px;">
                            <select name="dept" onchange="this.form.submit()" class="form-select">
                                <option value=""> Pilih Departement</option>
                                <option value="HSE">HSE</option>
                                <option value="FM">FM</option>
                                <option value="IT">IT</option>
                                <option value="Prod Opts">PROD OPERATION</option>
                                <option value="SPRM">SPRM</option>
                                <option value="CPS">CPS</option>
                                <option value="OS">OS</option>
                                <option value="DWO">DWO</option>
                                <option value="EPT">EPT</option>
                                <option value="EKS">EKS</option>
                                <option value="QHSE Dept">QHSE</option>
                                <option value="SCM">SCM</option>
                                <option value="EA">EA</option>
                                <option value="IA">IA</option>
                                <option value="FINEC">FINEC & ICT</option>
                                <option value="HRM">HRM</option>
                            </select>
                        </form> -->
                    </div>
                </div>
            </div>
            <!-- Tabel Training -->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Training</h6>
                </div>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Judul Pelatihan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Tanggal Mulai</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Tanggal Selesai </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Man</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Days</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Hours</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Total LH</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        HSE</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        NonHse</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Inhouse</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Sertifikasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Teknikal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($trainings->currentPage() - 1) * $trainings->perPage() + 1 @endphp
                                @foreach ($trainings as $training)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $training->judulPelatihan }}</td>
                                    <td style="font-size: 14px;">{{ $training->tglMulai }}</td>
                                    <td style="font-size: 14px;">{{ $training->tglSelesai }}</td>
                                    <td style="font-size: 14px;">{{ $training->man }}</td>
                                    <td style="font-size: 14px;">{{ $training->days }}</td>
                                    <td style="font-size: 14px;">{{ $training->hours }}</td>
                                    <td style="font-size: 14px;">{{ $training->total_man_hours }}</td>
                                    <td style="font-size: 14px;">{{ $training->hse }}</td>
                                    <td style="font-size: 14px;">{{ $training->nonhse }}</td>
                                    <td style="font-size: 14px;">{{ $training->inhouse }}</td>
                                    <td style="font-size: 14px;">{{ $training->sertifikasi }}</td>
                                    <td style="font-size: 14px;">{{ $training->teknikal }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $training->id }}">Edit</a>
                                        <form action="{{ route('training.destroy', $training->id) }}" method="POST" class="d-inline deleteForm" data-id="{{ $training->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                <!-- Modal edit data -->
                                <div class="modal fade" id="modalEdit{{ $training->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Sertifikasi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body " style="max-height: 450px; overflow-y: auto;">
                                                <!-- Form untuk mengedit data -->
                                                <form action="{{ route('training.edit', $training->id) }}" method="POST" class="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="judulPelatihan" class="form-label">Judul Pelatihan</label>
                                                        <input type="text" class="form-control" id="judulPelatihan" name="judulPelatihan"  value="{{ $training->judulPelatihan }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tglMulai" class="form-label">Tanggal Pelaksanaan Mulai</label>
                                                        <input type="date" class="form-control" id="tglMulai" name="tglMulai" value="{{ $training->tglMulai }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tglSelesai" class="form-label">Tanggal Pelaksanaan Selesai</label>
                                                        <input type="date" class="form-control" id="tglSelesai" name="tglSelesai" value="{{ $training->tglSelesai }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="man" class="form-label">Man</label>
                                                        <input type="number" class="form-control" id="man" name="man" value="{{ $training->man }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="days" class="form-label">Days</label>
                                                        <input type="number" class="form-control" id="days" name="days" value="{{ $training->days }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="hours" class="form-label">Hours</label>
                                                        <input type="number" class="form-control" id="hours" name="hours" value="{{ $training->hours }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="total_man_hours" class="form-label">Total Man Hours</label>
                                                        <input type="number" class="form-control" id="total_man_hours" name="total_man_hours" value="{{ $training->total_man_hours }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="hse" class="form-label">HSE</label>
                                                        <input type="number" class="form-control" id="hse" name="hse" value="{{ $training->hse }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nonhse" class="form-label">Non HSE</label>
                                                        <input type="number" class="form-control" id="nonhse" name="nonhse" value="{{ $training->nonhse }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="inhouse" class="form-label">Inhouse</label>
                                                        <input type="number" class="form-control" id="inhouse" name="inhouse" value="{{ $training->inhouse }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="sertifikasi" class="form-label">Sertifikasi</label>
                                                        <input type="number" class="form-control" id="sertifikasi" name="sertifikasi" value="{{ $training->sertifikasi }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="teknikal" class="form-label">Teknikal</label>
                                                        <input type="number" class="form-control" id="teknikal" name="teknikal" value="{{ $training->teknikal }}">
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
                                Showing {{ $trainings->firstItem() }} to {{ $trainings->lastItem() }} of {{ $trainings->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($trainings->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $trainings->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($trainings->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $trainings->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $trainings->currentPage() - 2); $i <= min($trainings->lastPage(), $trainings->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($trainings->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $trainings->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($trainings->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $trainings->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($trainings->currentPage() == $trainings->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $trainings->url($trainings->lastPage()) }}" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>

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
                                        const form = this.closest('.modal-content').querySelector('form');
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
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection