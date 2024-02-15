@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
            <div class="input-group">
            <form action="{{ route('sertifikasi.filterNamaProgram') }}" method="GET">
                <input type="text" name="namaProgram" class="form-control" class="fas fa-search" placeholder="Filter Nama Program">
            </form>
            </div>
            
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Tabel Sertifikasi</h6>
                        <form action="{{ route('sertifikasi.filterYear') }}" method="GET" class="mt-3" id="filterForm">
                            <label for="tahun">Pilih Tahun:</label>
                            <select name="tahun" id="tahun" onchange="this.form.submit()">
                                @for ($i = 2002; $i <= 2021; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </form>


                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p- 0  ">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NoPek</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Pekerja</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Dept</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Program</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Pelaksanaan Mulai</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Pelaksanaan Selesai</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Days</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tempat</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Penyelenggara</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sertifikasis as $sertifikasi)
                                    <tr>
                                        <td>{{ $sertifikasi->id }}</td>
                                        <td>{{ $sertifikasi->noPek }}</td>
                                        <td>{{ $sertifikasi->namaPekerja }}</td>
                                        <td>{{ $sertifikasi->dept }}</td>
                                        <td>{{ $sertifikasi->namaProgram }}</td>
                                        <td>{{ $sertifikasi->tanggalPelaksanaanMulai }}</td>
                                        <td>{{ $sertifikasi->tanggalPelaksanaanSelesai }}</td>
                                        <td>{{ $sertifikasi->days }}</td>
                                        <td>{{ $sertifikasi->tempat }}</td>
                                        <td>{{ $sertifikasi->namaPenyelenggara }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection