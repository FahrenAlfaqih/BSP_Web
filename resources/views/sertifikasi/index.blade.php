@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="input-group mb-3">
                <form id="filterNamaProgramForm" action="{{ route('sertifikasi.filterNamaProgram') }}" method="GET">
                    <input type="text" name="namaProgram" id="namaProgram" class="form-control"
                        placeholder="Filter Nama Program">
                </form>
                <form action="{{ route('sertifikasi.filterYear') }}" method="GET" class="ms-3">
                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="form-select"
                        style="min-width: 100px;">
                        @for ($i = 2002; $i <= 2021; $i++) <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                    </select>
                </form>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Tabel Sertifikasi</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
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
                                        Tanggal Mulai</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tanggal Selesai</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Days</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tempat</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Penyelenggara</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1 @endphp
                                @foreach ($sertifikasis as $sertifikasi)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $sertifikasi->noPek }}</td>
                                    <td>{{ $sertifikasi->namaPekerja }}</td>
                                    <td>{{ $sertifikasi->dept }}</td>
                                    <td>{{ $sertifikasi->namaProgram }}</td>
                                    <td>{{ $sertifikasi->tanggalPelaksanaanMulai }}</td>
                                    <td>{{ $sertifikasi->tanggalPelaksanaanSelesai }}</td>
                                    <td>{{ $sertifikasi->days }}</td>
                                    <td>{{ $sertifikasi->tempat }}</td>
                                    <td>{{ $sertifikasi->namaPenyelenggara }}</td>
                                    <td>
                                        <a href="{{ route('sertifikasi.edit', $sertifikasi->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('sertifikasi.destroy', $sertifikasi->id) }}"
                                            method="POST" class="d-inline deleteForm" data-id="{{ $sertifikasi->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-danger deleteButton">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $index++ @endphp
                                @endforeach
                            </tbody>
                        </table>
                        


                        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const deleteButtons = document.querySelectorAll('.deleteButton');

                                deleteButtons.forEach(button => {
                                    button.addEventListener('click', function (e) {
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
                                                    setTimeout(function () {
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

                            
                        </script>

                    </div>

                </div>
            </div>
        </div>
        <div class="nav-item d-flex align-self-end">
            <a href="{{ route('sertifikasi.download-pdf') }}" class="btn btn-primary active mb-0 text-white"
                role="button" aria-pressed="true">
                Download PDF
            </a>
        </div>
    </div>
    </div>
</main>

@endsection