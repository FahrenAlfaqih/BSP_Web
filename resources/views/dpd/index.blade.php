@extends('layouts.user_type.auth')

@section('content')


<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-6">
                <!-- Card List Top Tier Anggaran Pekerja -->
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>List Top Tier Anggaran Pekerja</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Nama</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Nomor SPD</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Departement</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                            Biaya DPD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($highestBiayaDPDList as $dpd)
                                    <tr>
                                        <td style="font-size: 14px;">{{ $dpd->nama }}</td>
                                        <td style="font-size: 14px;">{{ $dpd->nomorspd }}</td>
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


            <!-- Card 5 Departemen dengan Total Biaya DPD Tertinggi -->
            <div class="col-md-6">
                <div class="card mb-4" style="width: 48%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>5 Departemen dengan Total Biaya DPD Tertinggi</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
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




        </div>


        <div class="card mb-3">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <div class="d-flex">

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
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah dpd</h5>
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
                                                <option value="dpd">dpd</option>
                                                <option value="Izin Penelitian">Izin Penelitian</option>
                                                <option value="RISET PENELITIAN">RISET PENELITIAN</option>
                                                <option value="JOB TRAINING">JOB TRAINING</option>
                                                <option value="dpd GURU">dpd GURU</option>
                                                <option value="TA">TA</option>
                                                <option value="On Job Training">On Job Training</option>
                                                <option value="dpd/KP">dpd/KP</option>
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
                    <!-- Filter data berdasarkan tahun dpd-->
                    <form action="{{ route('dpd.filterByDate') }}" method="GET" class="ms-3" id="filterForm">
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


        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Data Dana Perjalanan Dinas</h6>
                <form action="{{ route('dpd.filterByDept') }}" method="GET" class="ms-3">
                    <select name="dept" onchange="this.form.submit()" class="form-select">
                        <option value=""> Departmen</option>
                        @foreach($depts as $dept)
                        <option value="{{ $dept }}" {{ request('depts') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <form id="filterNamaProgramForm" class="ms-3" action="{{ route('dpd.filterData') }}" method="GET">
                <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Nomor SPD">
            </form>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Nama</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Nomor SPD</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Department</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    BS NO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    PR</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    PO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    SES</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Biaya DPD</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Submit Finec</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Payment By Finec</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Keterangan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  ps-2">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1 @endphp
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
                                            <h5 class="modal-title" id="modalEditLabel">Edit dpd</h5>
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
                                                    <label for="institusi" class="form-label">Institusi</label>
                                                    <input type="text" class="form-control" id="institusi" name="institusi" value="{{ $dpd->institusi }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="dept" class="form-label">Departemen</label>
                                                    <select class="form-select" id="dept" name="dept" value="{{ $dpd->dept }}">
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
                                                    <input type="text" class="form-control" id="kategori" name="kategori" value="{{ $dpd->kategori }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="jurusan_fakultas" class="form-label">Jurusan / Fakultas</label>
                                                    <input type="text" class="form-control" id="jurusan_fakultas" name="jurusan_fakultas" value="{{ $dpd->jurusan_fakultas }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="tanggalMulai" class="form-label">Tanggal Pelaksanaan Mulai</label>
                                                    <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai" value="{{ $dpd->tanggalMulai }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="tanggalSelesai" class="form-label">Tanggal Pelaksanaan Selesai</label>
                                                    <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai" value="{{ $dpd->tanggalSelesai}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="kegiatan" class="form-label">Kegiatan</label>
                                                    <select class="form-select" id="kegiatan" name="kegiatan" value="{{ $dpd->kegiatan}}">
                                                        <!-- Tambahkan opsi-opsi kegiatan di sini -->
                                                        <option value="PKL">PKL</option>
                                                        <option value="KP">KP</option>
                                                        <option value="dpd">dpd</option>
                                                        <option value="Izin Penelitian">Izin Penelitian</option>
                                                        <option value="RISET PENELITIAN">RISET PENELITIAN</option>
                                                        <option value="JOB TRAINING">JOB TRAINING</option>
                                                        <option value="dpd GURU">dpd GURU</option>
                                                        <option value="TA">TA</option>
                                                        <option value="On Job Training">On Job Training</option>
                                                        <option value="dpd/KP">dpd/KP</option>
                                                        <option value="Tugas Akhir">Tugas Akhir</option>
                                                        <option value="Kerja Praktek">Kerja Praktek</option>
                                                        <option value="pra Riset">pra Riset</option>
                                                        <option value="Penelitian Master">Penelitian Master</option>
                                                        <!-- Tambahkan opsi-opsi kegiatan di sini -->
                                                    </select>
                                                </div>


                                                <div class="col-md-6">
                                                    <label for="daring_luring" class="form-label">Jenis Pelaksanaan</label>
                                                    <select class="form-select" id="daring_luring" name="daring_luring" value="{{ $dpd->daring_luring}}">
                                                        <option value="OFFLINE">OFFLINE</option>
                                                        <option value="ONLINE">ONLINE</option>
                                                        <option value="HYBRID">HYBRID</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="lokasi" class="form-label">Lokasi</label>
                                                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $dpd->lokasi}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="mentor" class="form-label">Nama Mentor</label>
                                                    <input type="text" class="form-control" id="mentor" name="mentor" value="{{ $dpd->mentor}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="statusSurat" class="form-label">Status Surat</label>
                                                    <select class="form-select" id="statusSurat" name="statusSurat" value="{{ $dpd->statusSurat}}">
                                                        <option value="OK">OK</option>
                                                        <option value="TIDAK OK">TIDAK OK</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $dpd->keterangan}}">
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
                        {{ $dpdList->links() }}
                    </div>

                    <div class="float-start">
                        <p class="text-muted">
                            Showing {{ $dpdList->firstItem() }} to {{ $dpdList->lastItem() }} of {{ $dpdList->total() }} entries
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

        <div class="row">
            <!-- Card untuk progress anggaran -->
            <div class="col-md-6">
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Progress Anggaran Dana DPD</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @foreach ($departmentProgress as $dept => $percentage)
                        <div class="m-3">
                            <p>{{ $dept }}</p>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" style="height: 20px;" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $percentage }}%</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

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

    </div>
    </div>
</main>

@endsection