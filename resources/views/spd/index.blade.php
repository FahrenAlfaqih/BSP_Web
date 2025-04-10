@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <div class="d-flex">
                            <button type="button" class="btn btn-success btn-2x me-2" onclick="handleExportToExcel()">Cetak Excel</button>
                            <a href="{{ route('spd.download-pdf', [
                                'search' => request()->input('search'),
                                'dept' => request()->input('dept'),
                                'tahun' => request()->input('tahun'),
                                'bulan' => request()->input('bulan')
                                ]) }}" class="btn btn-danger btn-2x me-2">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah SPD
                        </button>
                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah SPD</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                        <!-- Form untuk menambahkan data -->
                                        <form action="{{ route('spd.store') }}" method="POST" class="row g-3">
                                            @csrf
                                            <div class="col-md-6">
                                                <label for="nomor_spd" class="form-label">Nomor SPD</label>
                                                <input type="text" class="form-control" id="nomor_spd" name="nomor_spd">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="dept" class="form-label">Departemen</label>
                                                <select class="form-select" id="dept" name="dept">
                                                    <option value="">Pilih Departemen</option>
                                                    <option value="GM">GM</option>
                                                    <option value="PRODUCTION OPERATION">PRODUCTION OPERATION</option>
                                                    <option value="OPERATION SUPPORT">OPERATION SUPPORT</option>
                                                    <option value="DRILLING & WORK OVER">DRILLING & WORK OVER</option>
                                                    <option value="EXPLOITATION">EXPLOITATION</option>
                                                    <option value="EXPLORATION">EXPLORATION</option>
                                                    <option value="QHSE">QHSE</option>
                                                    <option value="SCM">SCM</option>
                                                    <option value="EXTERNAL AFFAIR">EXTERNAL AFFAIR</option>
                                                    <option value="INTERNAL AUDIT">INTERNAL AUDIT</option>
                                                    <option value="FINEC & ICT">FINEC & ICT</option>
                                                    <option value="HCM">HCM</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="wbs" class="form-label">BS</label>
                                                <input type="text" class="form-control" id="wbs" name="wbs">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pr" class="form-label">PR</label>
                                                <input type="text" class="form-control" id="pr" name="pr">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="po" class="form-label">PO</label>
                                                <input type="text" class="form-control" id="po" name="po">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="ses" class="form-label">SES</label>
                                                <input type="text" class="form-control" id="ses" name="ses">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="dari" class="form-label">Dari</label>
                                                <input type="text" class="form-control" id="dari" name="dari">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tujuan" class="form-label">Tujuan</label>
                                                <input type="text" class="form-control" id="tujuan" name="tujuan">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai Dinas</label>
                                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai Dinas</label>
                                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="keterangan_dinas" class="form-label">Keterangan Dinas</label>
                                                <input type="text" class="form-control" id="keterangan_dinas" name="keterangan_dinas">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="biaya_dpd" class="form-label">Biaya DPD</label>
                                                <input type="text" class="form-control" id="biaya_dpd" name="biaya_dpd">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="accrual" class="form-label">Accrual</label>
                                                <input type="text" class="form-control" id="accrual" name="accrual">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="submit_tgl" class="form-label">Submit Tanggal</label>
                                                <input type="date" class="form-control" id="submit_tgl" name="submit_tgl">
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Upload file excel -->
                        <form id="uploadForm" action="{{ route('spd.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
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
                                        <img src="../assets/img/contohExcel/SPD.png" class="img-fluid" alt="Contoh Isi Excel">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Reload data terbaru-->
                        <a href="{{ route('spd') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                        <!-- Filter data -->
                        <form action="{{ route('spd.filterByDate') }}" method="GET" class="ms-3" id="filterForm">
                            <div class="d-flex">
                                <!-- Filter data berdasarkan tahun -->
                                <div class="me-3">
                                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                        <option value="">Tahun</option>
                                        @for ($i = 2003; $i <= 2024; $i++) <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>
                                <!-- Filter data berdasarkan bulan -->
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
                                        <option value="">Pilih Departement</option>
                                        <option value="GM" {{ request('dept') == 'GM' ? 'selected' : '' }}>GM</option>
                                        <option value="OPS" {{ request('dept') == 'OPS' ? 'selected' : '' }}>OPS</option>
                                        <option value="OS" {{ request('dept') == 'OS' ? 'selected' : '' }}>OS</option>
                                        <option value="DWO" {{ request('dept') == 'DWO' ? 'selected' : '' }}>DWO</option>
                                        <option value="EPT" {{ request('dept') == 'EPT' ? 'selected' : '' }}>EPT</option>
                                        <option value="EKS" {{ request('dept') == 'EKS' ? 'selected' : '' }}>EKS</option>
                                        <option value="QHSE" {{ request('dept') == 'QHSE' ? 'selected' : '' }}>QHSE</option>
                                        <option value="SCM" {{ request('dept') == 'SCM' ? 'selected' : '' }}>SCM</option>
                                        <option value="EA" {{ request('dept') == 'EA' ? 'selected' : '' }}>EA</option>
                                        <option value="IA" {{ request('dept') == 'IA' ? 'selected' : '' }}>IA</option>
                                        <option value="FINEC & ICT" {{ request('dept') == 'FINEC & ICT' ? 'selected' : '' }}>FINEC & ICT</option>
                                        <option value="HCM" {{ request('dept') == 'HCM' ? 'selected' : '' }}>HCM</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tabel SPD-->
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Surat Perjalanan Dinas</h6>
                </div>
                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('spd.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Nomor SPD, atau Departemen">
                </form>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="selectAll(this)">
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nomor SPD</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Dept</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        BS</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        PR</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        PO </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        SES</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Dari</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Tujuan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Tanggal Mulai Dinas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Tanggal Selesai Dinas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Keterangan Dinas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Biaya DPD</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        ACCRUAL</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Submit Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($spds->currentPage() - 1) * $spds->perPage() + 1 @endphp
                                @foreach ($spds as $spd)
                                <tr>
                                    <td>
                                        <input type="checkbox" value="{{ $spd->id }}" onchange="handleCheckboxChange(event)">
                                    </td>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $spd->nomor_spd }}</td>
                                    <td style="font-size: 14px;">{{ $spd->nama }}</td>
                                    <td style="font-size: 14px;">{{ $spd->dept }}</td>
                                    <td style="font-size: 14px;">{{ $spd->wbs }}</td>
                                    <td style="font-size: 14px;">{{ $spd->pr }}</td>
                                    <td style="font-size: 14px;">{{ $spd->po }}</td>
                                    <td style="font-size: 14px;">{{ $spd->ses }}</td>
                                    <td style="font-size: 14px;">{{ $spd->dari }}</td>
                                    <td style="font-size: 14px;">{{ $spd->tujuan }}</td>
                                    <td style="font-size: 14px;">{{ $spd->tanggal_mulai  }}</td>
                                    <td style="font-size: 14px;">{{ $spd->tanggal_selesai  }}</td>
                                    <td style="font-size: 14px;">{{ $spd->keterangan_dinas }}</td>
                                    <td style="font-size: 14px;">Rp. {{ number_format($spd->biaya_dpd, 0, ',', '.') }}</td>
                                    <td style="font-size: 14px;">{{ $spd->accrual }}</td>
                                    <td style="font-size: 14px;">{{ $spd->submit_tgl }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $spd->id }}">Edit</a>
                                        <form action="{{ route('spd.destroy', $spd->id) }}" method="POST" class="d-inline deleteForm" data-id="{{ $spd->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                <!-- Modal edit data -->
                                <div class="modal fade" id="modalEdit{{ $spd->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit SPD</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                                <!-- Form untuk mengedit data -->
                                                <form action="{{ route('spd.edit', $spd->id) }}" method="POST" class="row g-3">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-6">
                                                        <label for="nomor_spd" class="form-label">Nomor SPD</label>
                                                        <input type="text" class="form-control" id="nomor_spd" name="nomor_spd" value="{{ $spd->nomor_spd }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="nama" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $spd->nama }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="dept" class="form-label">Departemen</label>
                                                        <select class="form-select" id="dept" name="dept">
                                                            <option>{{ $spd->dept }}</option>
                                                            <option value="GM">GM</option>
                                                            <option value="PRODUCTION OPERATION">PRODUCTION OPERATION</option>
                                                            <option value="OPERATION SUPPORT">OPERATION SUPPORT</option>
                                                            <option value="DRILLING & WORK OVER">DRILLING & WORK OVER</option>
                                                            <option value="EXPLOITATION">EXPLOITATION</option>
                                                            <option value="EXPLORATION">EXPLORATION</option>
                                                            <option value="QHSE">QHSE</option>
                                                            <option value="SCM">SCM</option>
                                                            <option value="EXTERNAL AFFAIR">EXTERNAL AFFAIR</option>
                                                            <option value="INTERNAL AUDIT">INTERNAL AUDIT</option>
                                                            <option value="FINEC & ICT">FINEC & ICT</option>
                                                            <option value="HCM">HCM</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="wbs" class="form-label">BS</label>
                                                        <input type="text" class="form-control" id="wbs" name="wbs" value="{{ $spd->wbs }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="pr" class="form-label">PR</label>
                                                        <input type="text" class="form-control" id="pr" name="pr" value="{{ $spd->pr }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="po" class="form-label">PO</label>
                                                        <input type="text" class="form-control" id="po" name="po" value="{{ $spd->po }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="ses" class="form-label">SES</label>
                                                        <input type="text" class="form-control" id="ses" name="ses" value="{{ $spd->ses }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="dari" class="form-label">Dari</label>
                                                        <input type="text" class="form-control" id="dari" name="dari" value="{{ $spd->dari }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tujuan" class="form-label">Tujuan</label>
                                                        <input type="text" class="form-control" id="tujuan" name="tujuan" value="{{ $spd->tujuan }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai Dinas</label>
                                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $spd->tanggal_mulai }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai Dinas</label>
                                                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $spd->tanggal_selesai }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="keterangan_dinas" class="form-label">Keterangan Dinas</label>
                                                        <input type="text" class="form-control" id="keterangan_dinas" name="keterangan_dinas" value="{{ $spd->keterangan_dinas }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="biaya_dpd" class="form-label">Biaya DPD</label>
                                                        <input type="text" class="form-control" id="biaya_dpd" name="biaya_dpd" value="{{ $spd->biaya_dpd }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="accrual" class="form-label">Accrual</label>
                                                        <input type="text" class="form-control" id="accrual" name="accrual" value="{{ $spd->accrual }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="submit_tgl" class="form-label">Submit Tanggal</label>
                                                        <input type="date" class="form-control" id="submit_tgl" name="submit_tgl" value="{{ $spd->submit_tgl }}">
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
                                Showing {{ $spds->firstItem() }} to {{ $spds->lastItem() }} of {{ $spds->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($spds->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $spds->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($spds->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $spds->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $spds->currentPage() - 2); $i <= min($spds->lastPage(), $spds->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($spds->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $spds->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($spds->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $spds->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($spds->currentPage() == $spds->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $spds->url($spds->lastPage()) }}" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>

                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                        <script>
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
                            let selectedItems = [];
                            // Handle checkbox change event
                            function handleCheckboxChange(event) {
                                const spdId = event.target.value;
                                if (event.target.checked) {
                                    // Add to selected items
                                    selectedItems.push(spdId);
                                } else {
                                    // Remove from selected items
                                    const index = selectedItems.indexOf(spdId);
                                    if (index !== -1) {
                                        selectedItems.splice(index, 1);
                                    }
                                }
                            }
                            // Handle export button click event
                            function handleExportToExcel() {
                                // Send selected item IDs to server for export
                                const url = '{{ route("export-selected-spds") }}';
                                fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            selectedItems: selectedItems
                                        })
                                    })
                                    .then(response => response.blob())
                                    .then(blob => {
                                        const url = window.URL.createObjectURL(new Blob([blob]));
                                        const a = document.createElement('a');
                                        a.href = url;
                                        a.download = 'selected_spds.xlsx';
                                        document.body.appendChild(a);
                                        a.click();
                                        document.body.removeChild(a);
                                    })
                                    .catch(error => {
                                        console.error('Error exporting to Excel:', error);
                                    });
                            }
                            document.addEventListener('DOMContentLoaded', function() {
                                const deptSelect = document.getElementById('dept');
                                const wbsInput = document.getElementById('wbs');
                                // Tambahkan event listener untuk memantau perubahan pada select departemen
                                deptSelect.addEventListener('change', function() {
                                    const selectedDept = deptSelect.value;
                                    let wbsValue = '';
                                    switch (selectedDept) {
                                        case 'EXPLOITATION':
                                        case 'EXPLORATION':
                                            wbsValue = '4';
                                            break;
                                        case 'OPERATION SUPPORT':
                                        case 'PRODUCTION OPERATION':
                                        case 'DRILLING & WORK OVER':
                                        case 'QHSE':
                                        case 'EXTERNAL AFFAIR':
                                            wbsValue = '8';
                                            break;
                                        case 'HCM':
                                        case 'SCM':
                                        case 'GM':
                                        case 'INTERNAL AUDIT':
                                        case 'FINEC & ICT':
                                            wbsValue = '11';
                                            break;
                                        default:
                                            wbsValue = ''; // Jika tidak ada departemen yang cocok
                                            break;
                                    }
                                    // Set nilai WBS ke dalam input WBS
                                    wbsInput.value = wbsValue;
                                });
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
                            //Menampilkan notif jika file excel belum diinputkan tetapi sudah pencet unggah
                            document.addEventListener('DOMContentLoaded', function() {
                                const uploadForm = document.querySelector('#uploadForm');
                                uploadForm.addEventListener('submit', function(event) {
                                    // Periksa apakah file sudah dipilih
                                    if (!document.querySelector('input[name="file[]"]').files[0]) {
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
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection