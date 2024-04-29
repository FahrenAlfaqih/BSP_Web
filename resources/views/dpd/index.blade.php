@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Card List Top Tier Anggaran Pekerja -->
            <div class="col-md-4">
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>List Top Tier Anggaran Pekerja</h6>
                    </div>
                    <div class="card-body px-4 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Nama</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Departement</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Biaya DPD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topKaryawan as $dpd)
                                    <tr>
                                        <td style="font-size: 14px;">{{ $dpd->nama }}</td>
                                        <td style="font-size: 14px;">{{ $dpd->dept }}</td>
                                        <td style="font-size: 14px;">{{ $dpd->biayadpd }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 10 Departemen dengan Total Biaya DPD Tertinggi -->
            <div class="col-md-4">
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>10 Departemen dengan Total Biaya DPD Tertinggi</h6>
                    </div>
                    <div class="card-body px-4 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Departemen</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Total Biaya DPD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topDepartments as $department)
                                    <tr>
                                        <td style="font-size: 14px;">{{ $department->dept }}</td>
                                        <td style="font-size: 14px;">{{ $department->total }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Dana Tersisa dari 10 Departemen -->
            <div class="col-md-4">
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Dana Tersisa Setiap Department</h6>
                    </div>
                    <div class="card-body px-4 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Departemen</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Dana Tersisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($remainingFundsData as $dept => $remainingFunds)
                                    <tr>
                                        <td style="font-size: 14px;">{{ $dept }}</td>
                                        <td style="font-size: 14px;">
                                            @if($remainingFunds !== null)
                                            {{ $remainingFunds }}
                                            @else
                                            Belum Dihitung
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">

                        <a href="{{ route('dpd.download-excel', ['dept' => request()->input('dept'),'search' => request()->input('search'), 'hari' => request()->input('hari'),'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-success btn-2x me-2">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </a>
                        <a href="{{ route('dpd.download-pdf', ['search' => request()->input('search'),'dept' => request()->input('dept'), 'tahun' => request()->input('tahun'),'bulan' => request()->input('bulan')]) }}" class="btn btn-danger btn-2x me-2">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                        <!-- Button trigger modal input -->
                        <button type="button" class="btn btn-dark btn-2x me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-plus"></i> Tambah DPD
                        </button>
                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 60%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah DPD</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                        <form action="{{ route('dpd.store') }}" method="POST" class="row g-3">
                                            @csrf
                                            <!-- Isi formulir dengan input yang sesuai -->
                                            <div class="col-md-6">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nomorspd" class="form-label">Nomor SPD</label>
                                                <input type="text" class="form-control" id="nomorspd" name="nomorspd">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="dept" class="form-label">Departemen</label>
                                                <select class="form-select" id="dept" name="dept">
                                                    <!-- Tambahkan opsi nilai departemen di sini -->
                                                    <option value="">Pilih Departemen</option> <!-- Opsi default kosong -->
                                                    <option value="GM">GM</option>
                                                    <option value="OPS">OPS</option>
                                                    <option value="OS">OS</option>
                                                    <option value="DWO">DWO</option>
                                                    <option value="EPT">EPT</option>
                                                    <option value="EKS">EKS</option>
                                                    <option value="QHSE">QHSE</option>
                                                    <option value="SCM">SCM</option>
                                                    <option value="EA">EA</option>
                                                    <option value="IA">IA</option>
                                                    <option value="FINEC & ICT">FINEC & ICT</option>
                                                    <option value="HCM">HCM</option>
                                                    <!-- Tambahkan opsi nilai departemen di sini -->
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="bsno" class="form-label">NO BS</label>
                                                <input type="text" class="form-control" id="bsno" name="bsno">
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
                                                <label for="biayadpd" class="form-label">Biaya DPD</label>
                                                <input type="number" class="form-control" id="biayadpd" name="biayadpd">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="submitfinec" class="form-label">Submit Finec</label>
                                                <input type="date" class="form-control" id="submitfinec" name="submitfinec">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="status" class="form-label">Status</label>
                                                <input type="text" class="form-control" id="status" name="status">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="paymentbyfinec" class="form-label">Payment By Finec</label>
                                                <input type="text" class="form-control" id="paymentbyfinec" name="paymentbyfinec">
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
                        <form id="uploadForm" action="{{ route('dpd.uploadExcel') }}" method="POST" enctype="multipart/form-data" class="btn btn-light btn-2x me-2">
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
                        <a href="{{ route('dpd') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload
                        </a>
                        <!-- Filter data berdasarkan tahun, bulan, dan hari -->
                        <form action="{{ route('dpd.filterByDate') }}" method="GET" class="ms-3" id="filterForm">
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
                                <div class="me-3">
                                    <select name="bulan" id="bulan" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                        <option value="">Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                            @endfor
                                    </select>
                                </div>
                                <!-- Filter data berdasarkan hari -->
                                <div>
                                    <select name="hari" id="hari" onchange="this.form.submit()" class="form-select" style="min-width: 90px;">
                                        <option value="">Hari</option>
                                        @for ($j = 1; $j <= 31; $j++) <option value="{{ str_pad($j, 2, '0', STR_PAD_LEFT) }}" {{ request('hari') == str_pad($j, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            {{ str_pad($j, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                            @endfor
                                    </select>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Dana Perjalanan Dinas</h6>
                    <form action="{{ route('dpd.filterByDept') }}" method="GET" class="ms-3">
                        <select name="dept" onchange="this.form.submit()" class="form-select">
                            <option value=""> Pilih Departement</option>
                            <option value="GM">GM</option>
                            <option value="OPS">OPS</option>
                            <option value="OS">OS</option>
                            <option value="DWO">DWO</option>
                            <option value="EPT">EPT</option>
                            <option value="EKS">EKS</option>
                            <option value="QHSE">QHSE</option>
                            <option value="SCM">SCM</option>
                            <option value="EA">EA</option>
                            <option value="IA">IA</option>
                            <option value="FINEC & ICT">FINEC & ICT</option>
                            <option value="HCM">HCM</option>
                        </select>
                    </form>
                </div>

                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('dpd.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Nomor SPD, atau Departemen">
                </form>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nomor SPD</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Department</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        BS NO</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        PR</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        PO</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        SES</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Biaya DPD</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Submit Finec</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Payment By Finec</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Keterangan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($dpdList->currentPage() - 1) * $dpdList->perPage() + 1 @endphp
                                @foreach ($dpdList as $dpd)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->nama }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->nomorspd }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->dept }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->bsno }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->pr }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->po }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->ses }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->biayadpd }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->submitfinec}}</td>
                                    <td style="font-size: 14px;">{{ $dpd->status }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->paymentbyfinec }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->keterangan }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target=".modalEdit" data-id="{{ $dpd->id }}">Edit</a>
                                        <form action="{{ route('dpd.destroy', $dpd->id) }}" method="POST" class="d-inline deleteForm" data-id="{{ $dpd->id }}">
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
                                                <h5 class="modal-title" id="modalEditLabel">Edit DPD</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body " style="max-height: 450px; overflow-y: auto;">
                                                <!-- Form untuk mengedit dpd -->
                                                <form action="{{ route('dpd.edit', $dpd->id) }}" method="POST" id="editForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-md-6">
                                                        <label for="nama" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $dpd->nama }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="nomorspd" class="form-label">Nomor SPD</label>
                                                        <input type="text" class="form-control" id="nomorspd" name="nomorspd" value="{{ $dpd->nomorspd }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="dept" class="form-label">Departemen</label>
                                                        <select class="form-select" id="dept" name="dept">
                                                            <!-- Tambahkan opsi nilai departemen di sini -->
                                                            <option>{{ $dpd->dept }}</option>
                                                            <option value="GM">GM</option>
                                                            <option value="OPS">OPS</option>
                                                            <option value="OS">OS</option>
                                                            <option value="DWO">DWO</option>
                                                            <option value="EPT">EPT</option>
                                                            <option value="EKS">EKS</option>
                                                            <option value="QHSE">QHSE</option>
                                                            <option value="SCM">SCM</option>
                                                            <option value="EA">EA</option>
                                                            <option value="IA">IA</option>
                                                            <option value="FINEC & ICT">FINEC & ICT</option>
                                                            <option value="HCM">HCM</option>
                                                            <!-- Tambahkan opsi nilai departemen di sini -->
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="bsno" class="form-label">NO BS</label>
                                                        <input type="text" class="form-control" id="bsno" name="bsno" value="{{ $dpd->bsno }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="pr" class="form-label">PR</label>
                                                        <input type="text" class="form-control" id="pr" name="pr" value="{{ $dpd->pr }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="po" class="form-label">PO</label>
                                                        <input type="text" class="form-control" id="po" name="po" value="{{ $dpd->po }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="ses" class="form-label">SES</label>
                                                        <input type="text" class="form-control" id="ses" name="ses" value="{{ $dpd->ses }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="biayadpd" class="form-label">Biaya DPD</label>
                                                        <input type="number" class="form-control" id="biayadpd" name="biayadpd" value="{{ $dpd->biayadpd }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="submitfinec" class="form-label">Submit Finec</label>
                                                        <input type="date" class="form-control" id="submitfinec" name="submitfinec" value="{{ $dpd->submitfinec }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="status" class="form-label">Status</label>
                                                        <input type="text" class="form-control" id="status" name="status" value="{{ $dpd->status }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="paymentbyfinec" class="form-label">Payment By Finec</label>
                                                        <input type="text" class="form-control" id="paymentbyfinec" name="paymentbyfinec" value="{{ $dpd->paymentbyfinec }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $dpd->keterangan }}">
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
                                Showing {{ $dpdList->firstItem() }} to {{ $dpdList->lastItem() }} of {{ $dpdList->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($dpdList->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $dpdList->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($dpdList->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $dpdList->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $dpdList->currentPage() - 2); $i <= min($dpdList->lastPage(), $dpdList->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($dpdList->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $dpdList->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($dpdList->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $dpdList->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($dpdList->currentPage() == $dpdList->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $dpdList->url($dpdList->lastPage()) }}" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>

                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const deptSelect = document.getElementById('dept');
                                const wbsInput = document.getElementById('bsno');

                                // Tambahkan event listener untuk memantau perubahan pada select departemen
                                deptSelect.addEventListener('change', function() {
                                    const selectedDept = deptSelect.value;
                                    let wbsValue = '';

                                    switch (selectedDept) {
                                        case 'EPT':
                                        case 'EKS':
                                            wbsValue = '4';
                                            break;
                                        case 'OS':
                                        case 'OPS':
                                        case 'DWO':
                                        case 'QHSE':
                                        case 'EA':
                                            wbsValue = '8';
                                            break;
                                        case 'HCM':
                                        case 'SCM':
                                        case 'GM':
                                        case 'IA':
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
                            //script agar tahun pada tanggalPelaksanaanMulai dan Selesai otomatis terubah sesuai dengan
                            //Tahun dpd yang diinputkan sebelumnya
                            document.addEventListener('DOMContentLoaded', function() {
                                // Ambil elemen input tahundpd
                                var tahundpdInput = document.getElementById('tahundpd');
                                // Ambil elemen input tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                var tanggalPelaksanaanMulaiInput = document.getElementById('tanggalPelaksanaanMulai');
                                var tanggalPelaksanaanSelesaiInput = document.getElementById('tanggalPelaksanaanSelesai');
                                // Tambahkan event listener ketika nilai tahundpd berubah
                                tahundpdInput.addEventListener('change', function() {
                                    // Ambil nilai tahundpd
                                    var tahundpd = tahundpdInput.value;
                                    // Periksa apakah tahundpd memiliki nilai
                                    if (tahundpd) {
                                        // Set nilai tahun pada tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai
                                        tanggalPelaksanaanMulaiInput.value = tahundpd + '-01-01'; // Tanggal mulai diatur menjadi 01 Januari tahundpd
                                        tanggalPelaksanaanSelesaiInput.value = tahundpd + '-12-31'; // Tanggal selesai diatur menjadi 31 Desember tahundpd
                                    } else {
                                        // Kosongkan nilai tanggalPelaksanaanMulai dan tanggalPelaksanaanSelesai jika tahundpd tidak memiliki nilai
                                        tanggalPelaksanaanMulaiInput.value = '';
                                        tanggalPelaksanaanSelesaiInput.value = '';
                                    }
                                });
                            });
                            //untuk menampilkan notif jika file excel belum diinputkan tetapi sudah pencet unggah
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
            <div class="row">

                <!-- Card untuk input dana awal -->
                <div class="col-md-6">
                    <div class="card mb-3" style="width: 100%;">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Set Anggaran Awal Departemen</h6>
                        </div>
                        <div class="card-body px-4 pt-2 pb-2">
                            <form action="{{ route('updateInitialFunds') }}" method="POST">
                                @csrf
                                @foreach($departments as $department)
                                <div class="form-group">
                                    <label for="initial_fund_{{ $department->id }}">{{ $department->name }}</label>
                                    <input type="number" class="form-control" id="initial_fund_{{ $department->id }}" name="initial_fund_{{ $department->id }}" value="{{ $department->initial_fund }}">
                                </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

@endsection