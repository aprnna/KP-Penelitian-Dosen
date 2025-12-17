<div class="container py-5">
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
          <h4 class="mb-0 fw-bold">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
          </h4>
        </div>
        <div class="card-body p-4">
          <div class="alert alert-success" role="alert">
            <h5 class="alert-heading"><i class="bi bi-check-circle me-2"></i>Selamat Datang!</h5>
            <p class="mb-0">Halo, <strong><?php echo htmlspecialchars($user->full_name); ?></strong>! Anda berhasil login ke sistem.</p>
          </div>
          
          <!-- Stats Cards -->
          <div class="row g-4 mt-3">
            <div class="col-md-4">
              <div class="card bg-primary text-white h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-people fs-1 me-3"></i>
                    <div>
                      <h6 class="card-title mb-0">Total Users</h6>
                      <p class="card-text fs-4 fw-bold mb-0">150</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card bg-success text-white h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-journal-text fs-1 me-3"></i>
                    <div>
                      <h6 class="card-title mb-0">Penelitian</h6>
                      <p class="card-text fs-4 fw-bold mb-0">75</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card bg-warning text-white h-100">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-clock-history fs-1 me-3"></i>
                    <div>
                      <h6 class="card-title mb-0">Pending</h6>
                      <p class="card-text fs-4 fw-bold mb-0">12</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Charts Section -->
          <div class="row g-4 mt-4">
            <!-- Pie Chart -->
            <div class="col-md-6">
              <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                  <h5 class="mb-0 fw-bold">
                    <i class="bi bi-pie-chart me-2"></i>Status Penelitian
                  </h5>
                </div>
                <div class="card-body">
                  <canvas id="pieChart"></canvas>
                </div>
              </div>
            </div>

            <!-- Bar Chart -->
            <div class="col-md-6">
              <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                  <h5 class="mb-0 fw-bold">
                    <i class="bi bi-bar-chart me-2"></i>Penelitian per Bulan
                  </h5>
                </div>
                <div class="card-body">
                  <canvas id="barChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Additional Charts -->
          <div class="row g-4 mt-2">
            <!-- Line Chart -->
            <div class="col-12">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                  <h5 class="mb-0 fw-bold">
                    <i class="bi bi-graph-up me-2"></i>Trend Penelitian Tahunan
                  </h5>
                </div>
                <div class="card-body">
                  <canvas id="lineChart" style="max-height: 300px;"></canvas>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Pie Chart - Status Penelitian
  const pieCtx = document.getElementById('pieChart').getContext('2d');
  new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: ['Selesai', 'Dalam Proses', 'Pending', 'Ditolak'],
      datasets: [{
        data: [45, 25, 20, 10],
        backgroundColor: [
          '#198754',  // success green
          '#0d6efd',  // primary blue
          '#ffc107',  // warning yellow
          '#dc3545'   // danger red
        ],
        borderWidth: 2,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            usePointStyle: true
          }
        }
      }
    }
  });

  // Bar Chart - Penelitian per Bulan
  const barCtx = document.getElementById('barChart').getContext('2d');
  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: 'Jumlah Penelitian',
        data: [12, 19, 8, 15, 22, 18],
        backgroundColor: [
          'rgba(13, 110, 253, 0.8)',
          'rgba(25, 135, 84, 0.8)',
          'rgba(255, 193, 7, 0.8)',
          'rgba(220, 53, 69, 0.8)',
          'rgba(13, 202, 240, 0.8)',
          'rgba(111, 66, 193, 0.8)'
        ],
        borderColor: [
          'rgb(13, 110, 253)',
          'rgb(25, 135, 84)',
          'rgb(255, 193, 7)',
          'rgb(220, 53, 69)',
          'rgb(13, 202, 240)',
          'rgb(111, 66, 193)'
        ],
        borderWidth: 2,
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      }
    }
  });

  // Line Chart - Trend Tahunan
  const lineCtx = document.getElementById('lineChart').getContext('2d');
  new Chart(lineCtx, {
    type: 'line',
    data: {
      labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
      datasets: [{
        label: 'Total Penelitian',
        data: [35, 42, 55, 68, 82, 95],
        fill: true,
        backgroundColor: 'rgba(25, 135, 84, 0.1)',
        borderColor: 'rgb(25, 135, 84)',
        borderWidth: 3,
        tension: 0.4,
        pointBackgroundColor: 'rgb(25, 135, 84)',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 6
      }, {
        label: 'Publikasi',
        data: [20, 28, 38, 45, 58, 72],
        fill: true,
        backgroundColor: 'rgba(13, 110, 253, 0.1)',
        borderColor: 'rgb(13, 110, 253)',
        borderWidth: 3,
        tension: 0.4,
        pointBackgroundColor: 'rgb(13, 110, 253)',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            usePointStyle: true
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      }
    }
  });
});
</script>