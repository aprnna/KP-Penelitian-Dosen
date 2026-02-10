<div class="container py-4" style="max-width: 1400px;">
  <!-- Welcome Alert -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="alert alert-success" role="alert">
        <h5 class="alert-heading"><i class="bi bi-check-circle me-2"></i>Selamat Datang!</h5>
        <p class="mb-0">Selamat datang di website visualisasi data jurnal penelitian UNIKOM</p>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-lg-8">
      <!-- Stats Cards -->
      <div class="row g-3 mb-4">
        <!-- Stats Filters -->
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <h6 class="mb-0 fw-bold">Ringkasan Statistik</h6>
              <small>Periode 1 tahun terakhir</small>
            </div>
            <div class="d-flex gap-2">
              <select class="form-select form-select-sm" id="statsFaculty" style="width: 150px;">
                <option value="Semua Fakultas">Semua Fakultas</option>
                <?php foreach ($faculties as $fac): ?>
                  <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                    <?php echo htmlspecialchars($fac->faculty); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <select class="form-select form-select-sm" id="statsYear" style="width: 100px;">
                <?php
                $currentYear = date('Y');
                for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
                  $selected = ($i == $defaultYear) ? 'selected' : '';
                  echo "<option value='$i' $selected>$i</option>";
                }
                ?>
                <option value="Semua Tahun">Semua Tahun</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <i class="bi bi-people text-warning" style="font-size: 2.5rem;"></i>
                </div>
                <div class="ms-3">
                  <p class="text-muted mb-1 small">Total Dosen</p>
                  <h3 class="mb-0 fw-bold" id="totalDosen"><?php echo $stats['total_dosen']; ?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <i class="bi bi-file-earmark-text text-danger" style="font-size: 2.5rem;"></i>
                </div>
                <div class="ms-3">
                  <p class="text-muted mb-1 small">Total Publikasi</p>
                  <h3 class="mb-0 fw-bold" id="totalPublikasi"><?php echo $stats['total_publikasi']; ?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <i class="bi bi-bookmark-check text-success" style="font-size: 2.5rem;"></i>
                </div>
                <div class="ms-3">
                  <p class="text-muted mb-1 small">Total Terindeksasi</p>
                  <h3 class="mb-0 fw-bold" id="totalTerindeksasi"><?php echo $stats['total_terindeksasi']; ?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Multiple Line Chart -->
      <div class="card border-0 shadow-sm mb-4 " style="height: 500px;">
        <div class=" card-header bg-white border-0 py-3">
          <div class="d-flex justify-content-between align-items-center mb-0">
            <div>
              <h6 class="mb-0 fw-bold">Fluktuasi Produktivitas Publikasi 5 Dosen Tertinggi</h6>
              <small class="text-muted">Periode 5 Tahun Terakhir (2022-2026)</small>
            </div>
            <div class="d-flex gap-2">
              <select class="form-select form-select-sm" id="trendFaculty" style="width: 150px;">
                <option value="Semua Fakultas">Semua Fakultas</option>
                <?php foreach ($faculties as $fac): ?>
                  <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                    <?php echo htmlspecialchars($fac->faculty); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <select class="form-select form-select-sm" id="trendYear" style="width: 100px;">
                <?php
                $currentYear = date('Y');
                for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
                  $selected = ($i == $defaultYear) ? 'selected' : '';
                  echo "<option value='$i' $selected>$i</option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body ">
          <canvas id="multiLineChart" style="max-height: 600px;"></canvas>
        </div>
      </div>

      <!-- Treemap -->
      <div class="card border-0 shadow-sm mb-4" style="height: 500px;">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
          <div>
            <h6 class="mb-0 fw-bold">Informasi Distribusi Setiap Fakultas Terhadap Total Publikasi UNIKOM</h6>
            <small>Periode 1 tahun terakhir</small>
          </div>

          <select class="form-select form-select-sm" id="treemapYear" style="width: 130px;">
            <?php
            $currentYear = date('Y');
            for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
              $selected = ($i == $defaultYear) ? 'selected' : '';
              echo "<option value='$i' $selected>$i</option>";
            }
            ?>
            <option value="">Semua Tahun</option>
          </select>
        </div>
        <div class="card-body">
          <canvas id="treemapChart" style="max-height: 600px;"></canvas>
        </div>
      </div>

      <!-- Line Chart - Publication Type Trends -->
      <div class="card border-0 shadow-sm mb-4" style="height: 500px;">
        <div class="card-header bg-white border-0 py-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-0 fw-bold">Informasi Fluktuasi Jumlah Publikasi Berdasarkan Tipe Publikasi</h6>
              <small class="text-muted">Periode 5 Tahun Terakhir</small>
            </div>
            <div class="d-flex gap-2">
              <select class="form-select form-select-sm" id="pubTypeFaculty" style="width: 150px;">
                <option value="Semua Fakultas">Semua Fakultas</option>
                <?php foreach ($faculties as $fac): ?>
                  <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                    <?php echo htmlspecialchars($fac->faculty); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <select class="form-select form-select-sm" id="pubTypeYear" style="width: 100px;">
                <?php
                $currentYear = date('Y');
                for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
                  $selected = ($i == $defaultYear) ? 'selected' : '';
                  echo "<option value='$i' $selected>$i</option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="publicationTypeChart" style="max-height: 400px;"></canvas>
        </div>
      </div>

      <!-- Horizontal Bar Charts Row -->
      <div class="row g-3">
        <div class="col-md-12">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0 fw-bold">Informasi 5 Jurnal Publikasi Penelitian Tertinggi Per Fakultas</h6>
                  <small class="text-muted">Periode 1 tahun terakhir</small>
                </div>
                <div class="d-flex gap-2">
                  <select class="form-select form-select-sm" id="journalFaculty" style="width: 150px;">
                    <?php foreach ($faculties as $fac): ?>
                      <option value="<?php echo htmlspecialchars($fac->faculty); ?>" <?php if ($fac->faculty == $defaultFaculty) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($fac->faculty); ?>
                      </option>
                    <?php endforeach; ?>
                    <option value="Semua Fakultas">Semua Fakultas</option>
                  </select>
                  <select class="form-select form-select-sm" id="journalYear" style="width: 100px;">
                    <?php
                    $currentYear = date('Y');
                    for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
                      $selected = ($i == $defaultYear) ? 'selected' : '';
                      echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                    <option value="">Semua Tahun</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="card-body">
              <canvas id="horizontalBar1"></canvas>
            </div>
          </div>
        </div>

        <!-- NEW CHART: Top 5 Impact Authors -->
        <div class="col-md-12">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0 fw-bold">Informasi 5 Dosen dengan Score Sinta Tertinggi per Fakultas
                  </h6>
                  <small class="text-muted"></small>
                </div>
                <div class="d-flex gap-2">
                  <select class="form-select form-select-sm" id="impactFaculty" style="width: 150px;">
                    <?php foreach ($faculties as $fac): ?>
                      <option value="<?php echo htmlspecialchars($fac->faculty); ?>" <?php if ($fac->faculty == $defaultFaculty) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($fac->faculty); ?>
                      </option>
                    <?php endforeach; ?>
                    <option value="Semua Fakultas">Semua Fakultas</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="card-body">
              <canvas id="impactChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Ranked List -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 py-3">
          <h6 class="mb-0 fw-bold">Top 10 Dosen Publikasi Jurnal</h6>
          <div class="d-flex gap-2 mt-2">
            <select class="form-select form-select-sm" id="rankFaculty">
              <option value="Semua Fakultas">Semua Fakultas</option>
              <?php foreach ($faculties as $fac): ?>
                <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                  <?php echo htmlspecialchars($fac->faculty); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <select class="form-select form-select-sm" id="rankYear" style="width: 100px;">
              <?php
              $currentYear = date('Y');
              for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
                $selected = ($i == $defaultYear) ? 'selected' : '';
                echo "<option value='$i' $selected>$i</option>";
              }
              ?>
              <option value="">Semua Tahun</option>
            </select>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="list-group list-group-flush">
            <div id="rankedListContainer">
              <?php foreach ($topDosen as $index => $dosen): ?>
                <?php
                // Initial render
                $rank = $dosen['rank'];
                $name = $dosen['name'];
                $faculty = $dosen['faculty'];
                $nidn = $dosen['nidn'];
                $publications = $dosen['publications'];
                $detail = $dosen['detail'];
                $badge_class = $dosen['badge_class'];
                $badge_icon = $dosen['badge_icon'];
                $isAlternate = $index % 2 == 1;
                include '../app/views/components/ranked_list_item.php';
                ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fontFamily = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    const chartData = <?php echo json_encode($charts); ?>;
    const baseUrl = '<?php echo BASE_URL; ?>';

    // --- Chart Instances ---
    let multiLineChartInstance = null;
    let treemapChartInstance = null;
    let pubTypeChartInstance = null;
    let topJournalsChartInstance = null;
    let impactChartInstance = null;

    // --- 1. Productivity Trend Chart ---
    const initProductivityChart = (data) => {
      const ctx = document.getElementById('multiLineChart').getContext('2d');
      if (multiLineChartInstance) multiLineChartInstance.destroy();

      const totals = data.datasets.map(ds =>
        ds.data.reduce((sum, v) => sum + parseInt(v, 10), 0)
      );

      const maxTotal = Math.max(...totals);
      const maxIndex = totals.indexOf(maxTotal);
      const baseColors = ['#0066cc', '#dc3545', '#ffc107', '#198754', '#9b59b6'];

      const datasets = data.datasets.map((ds, index) => {
        const isTop = index === maxIndex;
        const baseColor = baseColors[index % baseColors.length];
        return {
          label: ds.label,
          data: ds.data,
          borderColor: isTop ? baseColor : baseColor + '55',
          backgroundColor: isTop ? baseColor + '33' : baseColor + '11',
          borderWidth: isTop ? 3.5 : 1.5,
          pointRadius: isTop ? 5 : 3,
          pointHoverRadius: isTop ? 7 : 4,
          tension: 0.4,
          order: isTop ? 0 : 1
        };
      });

      multiLineChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.years,
          datasets: datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                font: {
                  family: fontFamily,
                  size: 11
                },
                usePointStyle: true,
                padding: 15
              }
            },
            tooltip: {
              titleFont: {
                family: fontFamily,
                size: 13,
                weight: 'bold'
              },
              bodyFont: {
                family: fontFamily,
                size: 12
              }
            },
            datalabels: {
              anchor: 'end',
              align: 'top',
              offset: 4,

              formatter: (value) => value, // tampilkan angka

              color: (ctx) => {
                const isTop = ctx.datasetIndex === maxIndex;
                return isTop ? '#003366' : '#6b7280';
              },

              font: (ctx) => {
                const isTop = ctx.datasetIndex === maxIndex;
                return {
                  family: fontFamily,
                  size: isTop ? 11 : 10,
                  weight: isTop ? 'bold' : 'normal'
                };
              }
            }
          },
          scales: {
            y: {
              display: false,
              beginAtZero: false,
              grid: {
                display: true,
                color: 'rgba(0,0,0,0.05)'
              },
            },
            x: {
              grid: {
                display: true,
                color: 'rgba(0,0,0,0.05)'
              },
            }
          }
        }

      });
    };
    initProductivityChart(chartData.productivity);


    // --- 2. Treemap Chart ---
    const initTreemapChart = (data) => {
      const ctx = document.getElementById('treemapChart').getContext('2d');
      if (treemapChartInstance) treemapChartInstance.destroy();

      const formattedData = data.map(item => ({
        name: item.name,
        value: Number(item.value),
      }));

      const maxValue = Math.max(...formattedData.map(d => d.value));

      treemapChartInstance = new Chart(ctx, {
        type: 'treemap',
        data: {
          datasets: [{
            tree: formattedData,
            key: 'value',
            groups: ['name'],
            spacing: 1,
            borderWidth: 2,
            borderColor: '#fff',
            backgroundColor: (ctx) => {
              if (!ctx.raw || typeof ctx.raw.v !== 'number') {
                return '#e5effa'; // warna fallback (biru sangat pucat)
              }

              const value = ctx.raw.v;
              const ratio = value / maxValue; // 0 → 1

              // Biru utama: rgb(0,102,204)
              const r = Math.round(230 - (230 - 0) * ratio);
              const g = Math.round(240 - (240 - 102) * ratio);
              const b = Math.round(255 - (255 - 204) * ratio);

              return `rgb(${r}, ${g}, ${b})`;
            },
            labels: {
              display: true,
              color: (ctx) => {
                // teks putih hanya untuk yang dominan
                const value = ctx.raw.v;
                return value === maxValue ? '#ffffff' : '#1f2937';
              },
              font: {
                family: fontFamily,
                size: 12,
                weight: 'bold'
              },
              formatter: (ctx) => ctx.raw._data.name + '\n' + ctx.raw.v
            }
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              titleFont: {
                family: fontFamily,
                size: 13,
                weight: 'bold'
              },
              bodyFont: {
                family: fontFamily,
                size: 12
              },
              callbacks: {
                title: (ctx) => ctx[0].raw._data.name,
                label: (ctx) => {
                  const item = ctx.raw._data;
                  return `Publikasi: ${item.value}`;
                }
              }
            },
            datalabels: {
              display: (ctx) => {
                if (!ctx.raw || typeof ctx.raw.v !== 'number') return false;
                return ctx.raw.v / maxValue > 0.08; // 8%
              },

              formatter: (value, ctx) => {
                const d = ctx.raw._data;
                return `${d.name}\n${d.value.toLocaleString('id-ID')}`;
              },

              color: (ctx) =>
                ctx.raw.v / maxValue > 0.2 ? '#ffffff' : '#1f2937',

              font: {
                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
                weight: 'bold',
                size: 11
              },

              align: 'center',
              anchor: 'center',
              clamp: true
            }
          }
        }
      });
    };
    initTreemapChart(chartData.treemap.map(d => ({
      ...d,
      percentage: ''
    })));


    // --- 3. Pub Type Chart ---
    const initPubTypeChart = (data) => {
      const ctx = document.getElementById('publicationTypeChart').getContext('2d');
      if (pubTypeChartInstance) pubTypeChartInstance.destroy();

      const totals = data.datasets.map(ds =>
        ds.data.reduce((sum, v) => sum + parseInt(v, 10), 0)
      );

      const maxTotal = Math.max(...totals);
      const maxIndex = totals.indexOf(maxTotal);

      const baseColors = ['#0066cc', '#dc3545', '#ffc107', '#198754', '#9b59b6'];

      const datasets = data.datasets.map((ds, index) => {
        const isTop = index === maxIndex;
        const baseColor = baseColors[index % baseColors.length];
        return {
          label: ds.label,
          data: ds.data,
          borderColor: isTop ? baseColor : baseColor + '55',
          backgroundColor: isTop ? baseColor + '33' : baseColor + '11',
          borderWidth: isTop ? 3.5 : 1.5,
          tension: 0.4,
          order: isTop ? 0 : 1
        };
      });

      pubTypeChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: datasets
        },
        options: {
          responsive: true,
          layout: {
            padding: {
              top: 40
            }
          },
          plugins: {
            tooltip: {
              titleFont: {
                family: fontFamily,
                size: 13,
                weight: 'bold'
              }
            },
            legend: {
              position: 'bottom',
              labels: {
                font: {
                  family: fontFamily,
                  size: 12
                }
              }
            },
            datalabels: {
              anchor: 'end',
              align: 'top',
              offset: 4,

              formatter: (value) => value, // tampilkan angka

              color: (ctx) => {
                const isTop = ctx.datasetIndex === maxIndex;
                return isTop ? '#003366' : '#6b7280';
              },

              font: (ctx) => {
                const isTop = ctx.datasetIndex === maxIndex;
                return {
                  family: fontFamily,
                  size: isTop ? 11 : 10,
                  weight: isTop ? 'bold' : 'normal'
                };
              }
            }
          },
          scales: {
            y: {
              display: false,
              beginAtZero: false,
              grid: {
                color: 'rgba(0,0,0,0.05)'
              },
            },
            x: {
              grid: {
                color: 'rgba(0,0,0,0.05)'
              },
            }
          }
        }
      });
    };
    initPubTypeChart(chartData.pubType);


    // --- 4. Top Journals Chart ---
    const initTopJournalsChart = (data) => {
      const ctx = document.getElementById('horizontalBar1').getContext('2d');
      if (topJournalsChartInstance) topJournalsChartInstance.destroy();

      topJournalsChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Jumlah Artikel',
            data: data.data,
            backgroundColor: (ctx) => {
              if (ctx.dataIndex === 0) {
                return '#0066cc';
              }
              return '#83bef9ff';
            },
            borderRadius: 6
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          layout: {
            padding: {
              right: 30,
              left: 5,
            }
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              titleFont: {
                family: fontFamily,
                size: 13,
                weight: 'bold'
              },
              bodyFont: {
                family: fontFamily,
                size: 12
              },
              legend: {
                display: false
              }
            },
            datalabels: {
              display: true,
              align: 'right',
              anchor: 'end',
              offset: 6,
              formatter: (value) => value.toLocaleString('id-ID'),
              color: '#003366',
              font: {
                family: fontFamily,
                size: 11,
                weight: 'bold'
              }
            }
          },
          scales: {
            x: {
              display: false,
              beginAtZero: true
            },
            y: {
              grid: {
                display: false
              }
            }
          }
        }
      });
    };
    initTopJournalsChart(chartData.bar1); // Load Top Journals

    // --- 5. Impact Chart ---
    const initImpactChart = (data) => {
      const ctx = document.getElementById('impactChart').getContext('2d');
      if (impactChartInstance) impactChartInstance.destroy();

      impactChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Sinta Score Overall',
            data: data.data,
            borderRadius: 5,
            backgroundColor: (ctx) => {
              if (ctx.dataIndex === 0) {
                return '#0066cc';
              }
              return '#83bef9ff';
            }
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          layout: {
            padding: {
              right: 40
            }
          },
          plugins: {
            tooltip: {
              titleFont: {
                family: fontFamily,
                size: 13,
                weight: 'bold'
              }
            },
            legend: {
              display: false
            },
            datalabels: {
              display: true,
              align: 'right',
              anchor: 'end',
              offset: 6,
              formatter: (value) => value.toLocaleString('id-ID'),
              color: '#003366',
              color: (ctx) =>
                ctx.dataIndex === 0 ? '#312e81' : '#374151',
              font: {
                family: fontFamily,
                size: 11,
                weight: 'bold'
              }
            }
          },
          scales: {
            x: {
              display: false,
            },
            y: {
              grid: {
                display: false
              }
            }
          }
        }
      });
    };
    initImpactChart(chartData.impact);


    // --- Ranked List Updater ---
    const updateRankedList = (html) => {
      const container = document.getElementById('rankedListContainer');
      container.innerHTML = html;
    };


    // --- AJAX Handler ---
    const updateDashboardData = async (type) => {
      let params = new URLSearchParams({
        type: type
      });

      if (type === 'ranked_list') {
        params.append('faculty', document.getElementById('rankFaculty').value);
        params.append('year', document.getElementById('rankYear').value);
      } else if (type === 'productivity') {
        params.append('faculty', document.getElementById('trendFaculty').value);
        params.append('year', document.getElementById('trendYear').value);
      } else if (type === 'treemap') {
        params.append('year', document.getElementById('treemapYear').value);
      } else if (type === 'pub_type') {
        params.append('faculty', document.getElementById('pubTypeFaculty').value);
        params.append('year', document.getElementById('pubTypeYear').value);
      } else if (type === 'top_journals') {
        params.append('faculty', document.getElementById('journalFaculty').value);
        params.append('year', document.getElementById('journalYear').value);
      } else if (type === 'top_impact') {
        params.append('faculty', document.getElementById('impactFaculty').value);
      } else if (type === 'stats') {
        params.append('faculty', document.getElementById('statsFaculty').value);
        params.append('year', document.getElementById('statsYear').value);
      }

      const url = `${baseUrl}dashboard/filterData?${params.toString()}`;
      console.log('Fetching URL:', url); // Debug

      try {
        const response = await fetch(url);
        if (!response.ok) return;

        const result = await response.json();

        if (type === 'ranked_list') {
          updateRankedList(result.html);
        } else if (type === 'productivity') {
          initProductivityChart(result);
        } else if (type === 'treemap') {
          initTreemapChart(result.data);
        } else if (type === 'pub_type') {
          initPubTypeChart(result);
        } else if (type === 'top_journals') {
          initTopJournalsChart(result);
        } else if (type === 'top_impact') {
          initImpactChart(result);
        } else if (type === 'stats') {
          document.getElementById('totalDosen').innerText = result.total_dosen;
          document.getElementById('totalPublikasi').innerText = result.total_publikasi;
          document.getElementById('totalTerindeksasi').innerText = result.total_terindeksasi;
        }
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
      }
    };

    // --- Event Listeners ---
    document.getElementById('rankFaculty').addEventListener('change', () => updateDashboardData('ranked_list'));
    document.getElementById('rankYear').addEventListener('change', () => updateDashboardData('ranked_list'));
    document.getElementById('trendFaculty').addEventListener('change', () => updateDashboardData('productivity'));
    document.getElementById('trendYear').addEventListener('change', () => updateDashboardData('productivity'));
    document.getElementById('treemapYear').addEventListener('change', () => updateDashboardData('treemap'));

    // Stats Filters
    document.getElementById('statsFaculty').addEventListener('change', () => updateDashboardData('stats'));
    document.getElementById('statsYear').addEventListener('change', () => updateDashboardData('stats'));

    // New Filters
    document.getElementById('pubTypeFaculty').addEventListener('change', () => updateDashboardData('pub_type'));
    document.getElementById('pubTypeYear').addEventListener('change', () => updateDashboardData('pub_type'));
    document.getElementById('journalFaculty').addEventListener('change', () => updateDashboardData('top_journals'));
    document.getElementById('journalYear').addEventListener('change', () => updateDashboardData('top_journals'));
    document.getElementById('impactFaculty').addEventListener('change', () => updateDashboardData('top_impact'));

  });
</script>