@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="card mb-3">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex">

                        <!-- Modal input data -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah PR Non Ada</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                                        <!-- Form untuk menambahkan data -->
                                        <form action="{{ route('pr.storePrNonada') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="idNonadaPR" class="form-label">Nomor PR Non Ada</label>
                                                <input type="number" class="form-control" id="idNonadaPR" name="idNonadaPR" maxlength="10" oninput="checkLength()">
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
                        <div class="d-flex">
                            <a href="{{ route('spd.download-pdf', [
                                'search' => request()->input('search'),
                                'dept' => request()->input('dept'),
                                'tahun' => request()->input('tahun'),
                                'bulan' => request()->input('bulan')
                                ]) }}" class="btn btn-danger btn-2x me-2">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                        <!-- Reload data terbaru-->
                        <a href="{{ route('departemen') }}" class="btn btn-light btn-2x me-2">
                            <i class="fas fa-sync fa-sm"></i> Reload Data
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Data Anggaran Dinas Departemen</h6>
                </div>
                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('dpd.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Nomor SPD, atau Departemen">
                </form>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0" style="max-height: 400px; overflow-y: auto;">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Nama Departemen</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Biaya Perjalanan Dinas</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Tahun</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = ($departments->currentPage() - 1) * $departments->perPage() + 1 @endphp
                                @foreach ($departments as $dpd)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->name }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->initial_fund }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->updated_at }}</td>
                                    <td style="font-size: 14px;">
                                        <a href="#" class="btn btn-sm btn-outline-warning editButton" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $dpd->id }}">Edit</a>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="float-start mx-2">
                            <p class="text-muted">
                                Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($departments->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $departments->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($departments->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $departments->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $departments->currentPage() - 2); $i <= min($departments->lastPage(), $departments->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($departments->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $departments->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($departments->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $departments->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($departments->currentPage() == $departments->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $departments->url($departments->lastPage()) }}" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Riwayat Perubahan Pagu Awal</h6>
                </div>
                <form id="filterNamaProgramForm" class="mx-3" action="{{ route('dpd.filterData') }}" method="GET">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari Berdasarkan Nama, Nomor SPD, atau Departemen">
                </form>
                <div class="card-body px-3 pt-0 pb-2">
                    <div class="table-responsive p-0" style="max-height: 400px; overflow-y: auto;">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Nama Departemen</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Tahun</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Waktu Perubahan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Anggaran Sebelum</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Anggaran Sesudah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $index = ($departments->currentPage() - 1) * $departments->perPage() + 1;
                                @endphp

                                @foreach ($departments as $dpd)
                                <tr>
                                    <td style="font-size: 14px;">{{ $index }}</td>
                                    <td style="font-size: 14px;">{{ $dpd->name }}</td>
                                    <td style="font-size: 14px;">
                                        @if ($dpd->created_at)
                                        {{ $dpd->created_at->year }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td style="font-size: 14px;">
                                        @if ($dpd->updated_at)
                                        {{ $dpd->updated_at->format('d-m-Y H:i:s') }}
                                        @else
                                        N/A
                                        @endif
                                    </td>

                                    <!-- Anggaran Sebelum: Format ke Rupiah -->
                                    <td style="font-size: 14px;">
                                        @if ($dpd->fundChanges->isNotEmpty())
                                        @php
                                        $latestChange = $dpd->fundChanges->sortByDesc('changed_at')->first();
                                        $formattedOldFund = number_format($latestChange->old_fund, 0, ',', '.');
                                        @endphp
                                        Rp. {{ $formattedOldFund }}
                                        @else
                                        N/A
                                        @endif
                                    </td>

                                    <!-- Anggaran Sesudah: Format ke Rupiah -->
                                    <td style="font-size: 14px;">
                                        @if ($dpd->fundChanges->isNotEmpty())
                                        @php
                                        $latestChange = $dpd->fundChanges->sortByDesc('changed_at')->first();
                                        $formattedNewFund = number_format($latestChange->new_fund, 0, ',', '.');
                                        @endphp
                                        Rp. {{ $formattedNewFund }}
                                        @else
                                        N/A
                                        @endif
                                    </td>


                                </tr>
                                @php $index++ @endphp
                                @endforeach
                            </tbody>
                        </table>


                        <!-- Pagination -->
                        <div class="float-start mx-2">
                            <p class="text-muted">
                                Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} entries
                            </p>
                        </div>
                        <div class="clearfix"></div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ ($departments->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $departments->url(1) }}" aria-label="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item {{ ($departments->onFirstPage()) ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $departments->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = max(1, $departments->currentPage() - 2); $i <= min($departments->lastPage(), $departments->currentPage() + 2); $i++)
                                    <li class="page-item {{ ($departments->currentPage() == $i) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $departments->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($departments->hasMorePages()) ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $departments->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ ($departments->currentPage() == $departments->lastPage()) ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $departments->url($departments->lastPage()) }}" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>


            <!-- Kolom Pertama (6 Departemen)  -->
            <!-- <div class="col-md-6">
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Set Anggaran Awal Departemen</h6>
                    </div>
                    <div class="card-body px-4 pt-2 pb-2">
                        <form action="{{ route('updateInitialFunds') }}" method="POST">
                            @csrf
                            @foreach($departments->take(6) as $department)
                            <div class="form-group">
                                <label for="initial_fund_{{ $department->id }}">{{ $department->name }}</label>
                                <input type="number" class="form-control" id="initial_fund_{{ $department->id }}" name="initial_fund_{{ $department->id }}" value="{{ $department->initial_fund }}">
                            </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div> -->
            <!-- Kolom Kedua (6 Departemen) -->
            <!-- <div class="col-md-6">
                <div class="card mb-3" style="width: 100%;">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Set Anggaran Awal Departemen</h6>
                    </div>
                    <div class="card-body px-4 pt-2 pb-2">
                        <form action="{{ route('updateInitialFunds') }}" method="POST">
                            @csrf
                            @foreach($departments->skip(6)->take(6) as $department)
                            <div class="form-group">
                                <label for="initial_fund_{{ $department->id }}">{{ $department->name }}</label>
                                <input type="number" class="form-control" id="initial_fund_{{ $department->id }}" name="initial_fund_{{ $department->id }}" value="{{ $department->initial_fund }}">
                            </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div> -->
</main>

@endsection