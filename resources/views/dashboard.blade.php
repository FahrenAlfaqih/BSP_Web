@extends('layouts.user_type.auth')

@section('content')

<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" crossorigin="" /> -->
<div class="row">
</div>
<div class="row mt-4">
  <div class="col-lg-12 mb-lg-0 mb-4"> <!-- Ubah dari col-lg-7 menjadi col-lg-12 -->
    <div class="card">
      <div class="card-body p-6">
        <div class="row">
          <div class="col-lg-12"> <!-- Ubah dari col-lg-16 menjadi col-lg-12 -->
            <div class="d-flex flex-column h-100">
              <h5 class="font-weight-bolder">Grafik Departemen yang Sering Melaksanakan Perjalanan Dinas </h5>
              <p class="mb-5">Mengelola data Perjalanan Dinas menjadi lebih efisien dan dapatkan kontrol penuh atas informasi Perjalanan Dinas</p>
              <div class="bg-gradient-dark border-radius-lg ">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas" height="350"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row mt-4">
  <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card z-index-2">
      <div class="card-body p-3">
        <p class="font-weight-bolder">Grafik Perjalanan Dinas dari Tahun ke Tahun</p>
        <div class="">
          <div class="chart">
            <canvas id="chart-spd" class="chart-canvas" height="350"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5 mb-lg-0 mb-4"> <!-- Ubah dari col-lg-6 menjadi col-lg-5 -->
    <div class="card z-index-2">
      <div class="card-body p-3">
        <p class="font-weight-bolder">Grafik Anggaran Perjalanan Dinas yang Digunakan Setiap Departemen</p>
        <div class="chart">
          <canvas id="pengeluaranDepartemenChart" class="chart-canvas" height="170"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var _ydata = JSON.parse('{!! json_encode($years) !!}');
  var _xdata = JSON.parse('{!! json_encode($yearCount) !!}');
  var _ydata2 = JSON.parse('{!! json_encode($years2) !!}');
  var _xdata2 = JSON.parse('{!! json_encode($yearCount2) !!}');
</script>
@endsection
@push('dashboard')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Define the gradientStroke variable inside this scope
    var ctxSpd = document.getElementById("chart-spd").getContext("2d");
    var gradientStroke = ctxSpd.createLinearGradient(0, 230, 0, 50);
    gradientStroke.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke.addColorStop(0, 'rgba(203,12,159,0)');

    // Ambil data dari Blade template
    var spdYears = @json($spdYears);
    var spdYearCount = @json($spdYearCount);

    new Chart(ctxSpd, {
      type: "line",
      data: {
        labels: spdYears,
        datasets: [{
          label: "Jumlah Perjalanan Dinas",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 5,
          borderColor: "#cb0c9f",
          borderWidth: 3,
          backgroundColor: gradientStroke,
          fill: true,
          data: spdYearCount,
          maxBarThickness: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#b2b9bf',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              }
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#b2b9bf',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              }
            }
          }
        }
      }
    });
  });

  window.onload = function() {
    var ctx = document.getElementById("chart-bars").getContext("2d");

    // Ambil data dari Blade template
    var labels_totaldept = @json($labels_totaldept);
    var data__totaldept = @json($data__totaldept);

    // Pisahkan data berdasarkan nilai
    var highValues = data__totaldept.map(value => value > 50 ? value : 0);
    var lowValues = data__totaldept.map(value => value <= 50 ? value : 0);

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels_totaldept, // Menggunakan label departemen
        datasets: [{
          label: "Jumlah Perjalanan Dinas Tinggi (≥ 50)",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#4caf50", // Hijau untuk nilai tinggi
          data: highValues, // Data untuk nilai tinggi
          maxBarThickness: 10
        }, {
          label: "Jumlah Perjalanan Dinas Rendah (< 50)",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#f44336", // Merah untuk nilai rendah
          data: lowValues, // Data untuk nilai rendah
          maxBarThickness: 10
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true, // Menampilkan legenda
          },
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: true,
              display: true,
              color: '#e0e0e0', // Warna grid
              borderDash: [5, 5],
            },
            ticks: {
              beginAtZero: true,
              stepSize: 10, // Mengatur langkah interval sumbu Y
              padding: 15,
              font: {
                size: 14,
                family: "Open Sans",
                style: 'normal',
                weight: 'bold',
                lineHeight: 2,
              },
              color: "#b2b9bf"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
            },
            ticks: {
              display: true,
              font: {
                size: 14,
                family: "Open Sans",
                style: 'normal',
                weight: 'bold',
                lineHeight: 2,
              },
              color: "#b2b9bf"
            },
          },
        },
      },
    });
  };

  // Grafik Anggaran Perjalanan Dinas yang Digunakan Setiap Departemen per Bulan 
  var pengeluaranData = @json($pengeluaranPerDepartemen);
  var labels = pengeluaranData.map(function(item) {
    return item.dept;
  });
  var data = pengeluaranData.map(function(item) {
    return item.total_biaya;
  });
  var ctx = document.getElementById('pengeluaranDepartemenChart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar', // atau 'pie' untuk pie chart
    data: {
      labels: labels,
      datasets: [{
        label: 'Pengeluaran Anggaran per Departemen',
        data: data,
        backgroundColor: [
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 0.2)'
        ],
        borderColor: [
          'rgba(75, 192, 192, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

@endpush