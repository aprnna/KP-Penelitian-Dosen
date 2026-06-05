<!-- Dashboard Styles for Consistent Colors -->
<style>
  /* Design System Tokens */
  :root {
    --dash-primary: #0066cc;
    --dash-primary-hover: #0056b3;
    --dash-primary-light: #e6f2ff;
    --dash-success: #16a34a;
    --dash-success-light: #dcfce7;
    --dash-warning: #d97706;
    --dash-warning-light: #fef3c7;
    --dash-danger: #dc2626;
    --dash-danger-light: #fee2e2;
    --dash-muted: #64748b;
    --dash-border: #e2e8f0;
    --dash-card-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.04);
    --dash-radius: 12px;
    --dash-radius-sm: 8px;
    --dash-bg: #F6FCFF;
  }

  /* Stat Cards */
  .stat-card {
    background: #ffffff;
    border-radius: var(--dash-radius);
    box-shadow: var(--dash-card-shadow);
    border: 1px solid var(--dash-border);
    transition: box-shadow 0.2s ease, transform 0.2s ease;
  }

  .stat-card:hover {
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.1);
  }

  .stat-card-body {
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .stat-icon {
    width: 56px;
    height: 56px;
    border-radius: var(--dash-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .stat-icon.warning {
    background: var(--dash-warning-light);
    color: var(--dash-warning);
    font-size: 1.75rem;
  }

  .stat-icon.danger {
    background: var(--dash-danger-light);
    color: var(--dash-danger);
    font-size: 1.75rem;
  }

  .stat-icon.success {
    background: var(--dash-success-light);
    color: var(--dash-success);
    font-size: 1.75rem;
  }

  .stat-content {
    flex: 1;
    min-width: 0;
  }

  .stat-label {
    font-size: 0.8125rem;
    color: var(--dash-muted);
    margin-bottom: 0.25rem;
  }

  .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.2;
  }

  /* Chart Cards */
  .chart-card {
    background: #ffffff;
    border-radius: var(--dash-radius);
    box-shadow: var(--dash-card-shadow);
    border: 1px solid var(--dash-border);
    overflow: hidden;
  }

  .chart-card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--dash-border);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 0.75rem;
  }

  .chart-card-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
  }

  .chart-card-subtitle {
    font-size: 0.8125rem;
    color: var(--dash-muted);
    margin-top: 0.25rem;
  }

  .chart-card-filters {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
  }

  .chart-select {
    border-radius: var(--dash-radius-sm);
    border: 1px solid var(--dash-border);
    font-size: 0.8125rem;
    padding: 0.375rem 0.75rem;
    min-width: 100px;
    background: #ffffff;
    color: #475569;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .chart-select:focus {
    border-color: var(--dash-primary);
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    outline: none;
  }

  .chart-card-body {
    padding: 1rem 1.25rem;
    min-height: 300px;
  }

  /* Ranked List */
  .ranked-list-card {
    background: #ffffff;
    border-radius: var(--dash-radius);
    box-shadow: var(--dash-card-shadow);
    border: 1px solid var(--dash-border);
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .ranked-list-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--dash-border);
  }

  .ranked-list-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
  }

  .ranked-list-filters {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
  }

  .ranked-list-body {
    flex: 1;
    overflow-y: auto;
  }

  /* Welcome Banner */
  .welcome-banner {
    background: linear-gradient(135deg, var(--dash-primary) 0%, #0052a3 100%);
    border-radius: var(--dash-radius);
    padding: 1.25rem 1.5rem;
    color: #ffffff;
    margin-bottom: 1.5rem;
    box-shadow: var(--dash-card-shadow);
  }

  .welcome-banner h5 {
    font-size: 1.125rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .welcome-banner p {
    font-size: 0.9375rem;
    margin: 0;
    opacity: 0.9;
  }

  /* Chart Colors - Consistent Primary Blue */
  .chart-primary {
    color: var(--dash-primary);
  }

  /* Responsive */
  @media (max-width: 991.98px) {
    .chart-card-header {
      flex-direction: column;
      align-items: stretch;
    }

    .chart-card-filters {
      justify-content: flex-start;
    }
  }

  @media (max-width: 575.98px) {
    .stat-card-body {
      flex-direction: column;
      text-align: center;
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      font-size: 1.5rem;
    }

    .stat-value {
      font-size: 1.5rem;
    }
  }
</style>

<div class="container py-4" style="max-width: 1400px;">

  <!-- Welcome Banner -->
  <div class="welcome-banner">
    <h5><i class="bi bi-check-circle-fill"></i> Selamat Datang!</h5>
    <p>Selamat datang di website visualisasi data jurnal penelitian UNIKOM</p>
  </div>

  <!-- Stats Row -->
  <div class="row g-3 mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h6 class="mb-0 fw-bold">Ringkasan Statistik</h6>
          <small class="text-muted">Periode 1 tahun terakhir</small>
        </div>
        <div class="d-flex gap-2">
          <select class="form-select form-select-sm chart-select" id="statsFaculty" style="width: 150px;">
            <option value="Semua Fakultas">Semua Fakultas</option>
            <?php foreach ($faculties as $fac): ?>
              <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                <?php echo htmlspecialchars($fac->faculty); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <select class="form-select form-select-sm chart-select" id="statsYear" style="width: 100px;">
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
      <div class="stat-card">
        <div class="stat-card-body">
          <div class="stat-icon warning">
            <i class="bi bi-people-fill"></i>
          </div>
          <div class="stat-content">
            <div class="stat-label">Total Dosen</div>
            <div class="stat-value" id="totalDosen"><?php echo $stats['total_dosen']; ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card">
        <div class="stat-card-body">
          <div class="stat-icon danger">
            <i class="bi bi-file-earmark-text-fill"></i>
          </div>
          <div class="stat-content">
            <div class="stat-label">Total Publikasi</div>
            <div class="stat-value" id="totalPublikasi"><?php echo $stats['total_publikasi']; ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="stat-card">
        <div class="stat-card-body">
          <div class="stat-icon success">
            <i class="bi bi-bookmark-check-fill"></i>
          </div>
          <div class="stat-content">
            <div class="stat-label">Total Terindeksasi</div>
            <div class="stat-value" id="totalTerindeksasi"><?php echo $stats['total_terindeksasi']; ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="row g-3">
    <div class="col-lg-8">
      <!-- Productivity Trend Chart -->
      <div class="chart-card mb-3" style="height: 400px;">
        <div class="chart-card-header">
          <div>
            <h6 class="chart-card-title">Fluktuasi Produktivitas Publikasi 5 Dosen Tertinggi</h6>
            <p class="chart-card-subtitle">Periode 5 Tahun Terakhir (2022-2026)</p>
          </div>
          <div class="chart-card-filters">
            <select class="form-select form-select-sm chart-select" id="trendFaculty" style="width: 150px;">
              <option value="Semua Fakultas">Semua Fakultas</option>
              <?php foreach ($faculties as $fac): ?>
                <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                  <?php echo htmlspecialchars($fac->faculty); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <select class="form-select form-select-sm chart-select" id="trendYear" style="width: 100px;">
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
        <div class="chart-card-body">
          <canvas id="multiLineChart" style="max-height: 320px;"></canvas>
        </div>
      </div>

      <!-- Treemap Chart -->
      <div class="chart-card mb-3" style="height: 400px;">
        <div class="chart-card-header">
          <div>
            <h6 class="chart-card-title">Distribusi Publikasi per Fakultas</h6>
            <p class="chart-card-subtitle">Periode 1 tahun terakhir</p>
          </div>
          <select class="form-select form-select-sm chart-select" id="treemapYear" style="width: 130px;">
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
        <div class="chart-card-body">
          <canvas id="treemapChart" style="max-height: 320px;"></canvas>
        </div>
      </div>

      <!-- Publication Type Chart -->
      <div class="chart-card mb-3" style="height: 400px;">
        <div class="chart-card-header">
          <div>
            <h6 class="chart-card-title">Fluktuasi Jumlah Publikasi per Tipe</h6>
            <p class="chart-card-subtitle">Periode 5 Tahun Terakhir</p>
          </div>
          <div class="chart-card-filters">
            <select class="form-select form-select-sm chart-select" id="pubTypeFaculty" style="width: 150px;">
              <option value="Semua Fakultas">Semua Fakultas</option>
              <?php foreach ($faculties as $fac): ?>
                <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                  <?php echo htmlspecialchars($fac->faculty); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <select class="form-select form-select-sm chart-select" id="pubTypeYear" style="width: 100px;">
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
        <div class="chart-card-body">
          <canvas id="publicationTypeChart" style="max-height: 320px;"></canvas>
        </div>
      </div>

      <!-- Top Journals Chart -->
      <div class="chart-card mb-3" style="height: 350px;">
        <div class="chart-card-header">
          <div>
            <h6 class="chart-card-title">5 Jurnal Publikasi Tertinggi per Fakultas</h6>
            <p class="chart-card-subtitle">Periode 1 tahun terakhir</p>
          </div>
          <div class="chart-card-filters">
            <select class="form-select form-select-sm chart-select" id="journalFaculty" style="width: 150px;">
              <?php foreach ($faculties as $fac): ?>
                <option value="<?php echo htmlspecialchars($fac->faculty); ?>" <?php if ($fac->faculty == $defaultFaculty) echo 'selected'; ?>>
                  <?php echo htmlspecialchars($fac->faculty); ?>
                </option>
              <?php endforeach; ?>
              <option value="Semua Fakultas">Semua Fakultas</option>
            </select>
            <select class="form-select form-select-sm chart-select" id="journalYear" style="width: 100px;">
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
        <div class="chart-card-body">
          <canvas id="horizontalBar1"></canvas>
        </div>
      </div>

      <!-- Impact Authors Chart -->
      <div class="chart-card" style="height: 350px;">
        <div class="chart-card-header">
          <div>
            <h6 class="chart-card-title">5 Dosen dengan Score SINTA Tertinggi per Fakultas</h6>
            <p class="chart-card-subtitle">Peringkat berdasarkan SINTA Score Overall</p>
          </div>
          <select class="form-select form-select-sm chart-select" id="impactFaculty" style="width: 150px;">
            <?php foreach ($faculties as $fac): ?>
              <option value="<?php echo htmlspecialchars($fac->faculty); ?>" <?php if ($fac->faculty == $defaultFaculty) echo 'selected'; ?>>
                <?php echo htmlspecialchars($fac->faculty); ?>
              </option>
            <?php endforeach; ?>
            <option value="Semua Fakultas">Semua Fakultas</option>
          </select>
        </div>
        <div class="chart-card-body">
          <canvas id="impactChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Ranked List -->
    <div class="col-lg-4">
      <div class="ranked-list-card">
        <div class="ranked-list-header">
          <h6 class="ranked-list-title">Top 10 Dosen Publikasi Jurnal</h6>
          <div class="ranked-list-filters">
            <select class="form-select form-select-sm chart-select" id="rankFaculty">
              <option value="Semua Fakultas">Semua Fakultas</option>
              <?php foreach ($faculties as $fac): ?>
                <option value="<?php echo htmlspecialchars($fac->faculty); ?>">
                  <?php echo htmlspecialchars($fac->faculty); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <select class="form-select form-select-sm chart-select" id="rankYear" style="width: 100px;">
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
        <div class="ranked-list-body">
          <div class="list-group list-group-flush" id="rankedListContainer">
            <?php foreach ($topDosen as $index => $dosen): ?>
              <?php
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fontFamily = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    const chartData = <?php echo json_encode($charts); ?>;
    const baseUrl = '<?php echo BASE_URL; ?>';

    // Primary blue color palette
    const primaryBlue = '#0066cc';
    const primaryBlueLight = '#e6f2ff';
    const chartColors = [
      '#0066cc', // Primary blue
      '#0052a3', // Darker blue
      '#3388dd', // Lighter blue
      '#003d7a', // Navy
      '#4da6ff'  // Sky blue
    ];

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

      const datasets = data.datasets.map((ds, index) => {
        const isTop = index === maxIndex;
        const baseColor = chartColors[index % chartColors.length];
        return {
          label: ds.label,
          data: ds.data,
          borderColor: isTop ? primaryBlue : baseColor + '99',
          backgroundColor: isTop ? primaryBlueLight : baseColor + '22',
          borderWidth: isTop ? 3 : 1.5,
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
                font: { family: fontFamily, size: 11 },
                usePointStyle: true,
                padding: 15
              }
            },
            tooltip: {
              titleFont: { family: fontFamily, size: 13, weight: 'bold' },
              bodyFont: { family: fontFamily, size: 12 }
            },
            datalabels: {
              anchor: 'end',
              align: 'top',
              offset: 4,
              formatter: (value) => value,
              color: (ctx) => ctx.datasetIndex === maxIndex ? '#003366' : '#6b7280',
              font: (ctx) => ({
                family: fontFamily,
                size: ctx.datasetIndex === maxIndex ? 11 : 10,
                weight: ctx.datasetIndex === maxIndex ? 'bold' : 'normal'
              })
            }
          },
          scales: {
            y: {
              display: false,
              beginAtZero: false,
              grid: { display: true, color: 'rgba(0,0,0,0.05)' }
            },
            x: {
              grid: { display: true, color: 'rgba(0,0,0,0.05)' }
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
        value: Number(item.value)
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
              if (!ctx.raw || typeof ctx.raw.v !== 'number') return primaryBlueLight;
              const value = ctx.raw.v;
              const ratio = value / maxValue;
              // Gradient from light to primary blue
              const r = Math.round(230 - (230 - 0) * ratio);
              const g = Math.round(240 - (240 - 102) * ratio);
              const b = Math.round(255 - (255 - 204) * ratio);
              return `rgb(${r}, ${g}, ${b})`;
            },
            labels: {
              display: true,
              color: (ctx) => ctx.raw.v === maxValue ? '#ffffff' : '#1f2937',
              font: { family: fontFamily, size: 12, weight: 'bold' },
              formatter: (ctx) => ctx.raw._data.name + '\n' + ctx.raw.v
            }
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              titleFont: { family: fontFamily, size: 13, weight: 'bold' },
              bodyFont: { family: fontFamily, size: 12 },
              callbacks: {
                title: (ctx) => ctx[0].raw._data.name,
                label: (ctx) => 'Publikasi: ' + ctx.raw._data.value
              }
            },
            datalabels: {
              display: (ctx) => {
                if (!ctx.raw || typeof ctx.raw.v !== 'number') return false;
                return ctx.raw.v / maxValue > 0.08;
              },
              formatter: (value, ctx) => {
                const d = ctx.raw._data;
                return `${d.name}\n${d.value.toLocaleString('id-ID')}`;
              },
              color: (ctx) => ctx.raw.v / maxValue > 0.2 ? '#ffffff' : '#1f2937',
              font: { family: fontFamily, weight: 'bold', size: 11 },
              align: 'center',
              anchor: 'center',
              clamp: true
            }
          }
        }
      });
    };
    initTreemapChart(chartData.treemap.map(d => ({ ...d, percentage: '' })));

    // --- 3. Pub Type Chart ---
    const initPubTypeChart = (data) => {
      const ctx = document.getElementById('publicationTypeChart').getContext('2d');
      if (pubTypeChartInstance) pubTypeChartInstance.destroy();

      const totals = data.datasets.map(ds =>
        ds.data.reduce((sum, v) => sum + parseInt(v, 10), 0)
      );
      const maxTotal = Math.max(...totals);
      const maxIndex = totals.indexOf(maxTotal);

      const datasets = data.datasets.map((ds, index) => {
        const isTop = index === maxIndex;
        const baseColor = chartColors[index % chartColors.length];
        return {
          label: ds.label,
          data: ds.data,
          borderColor: isTop ? primaryBlue : baseColor + '99',
          backgroundColor: isTop ? primaryBlueLight : baseColor + '22',
          borderWidth: isTop ? 3 : 1.5,
          tension: 0.4,
          order: isTop ? 0 : 1
        };
      });

      pubTypeChartInstance = new Chart(ctx, {
        type: 'line',
        data: { labels: data.labels, datasets: datasets },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          layout: { padding: { top: 40 } },
          plugins: {
            tooltip: { titleFont: { family: fontFamily, size: 13, weight: 'bold' } },
            legend: {
              position: 'bottom',
              labels: { font: { family: fontFamily, size: 12 } }
            },
            datalabels: {
              anchor: 'end',
              align: 'top',
              offset: 4,
              formatter: (value) => value,
              color: (ctx) => ctx.datasetIndex === maxIndex ? '#003366' : '#6b7280',
              font: (ctx) => ({
                family: fontFamily,
                size: ctx.datasetIndex === maxIndex ? 11 : 10,
                weight: ctx.datasetIndex === maxIndex ? 'bold' : 'normal'
              })
            }
          },
          scales: {
            y: { display: false, beginAtZero: false, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { color: 'rgba(0,0,0,0.05)' } }
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
            backgroundColor: (ctx) => ctx.dataIndex === 0 ? primaryBlue : primaryBlueLight,
            borderRadius: 6
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          layout: { padding: { right: 30, left: 5 } },
          plugins: {
            legend: { display: false },
            tooltip: {
              titleFont: { family: fontFamily, size: 13, weight: 'bold' },
              bodyFont: { family: fontFamily, size: 12 }
            },
            datalabels: {
              display: true,
              align: 'right',
              anchor: 'end',
              offset: 6,
              formatter: (value) => value.toLocaleString('id-ID'),
              color: '#003366',
              font: { family: fontFamily, size: 11, weight: 'bold' }
            }
          },
          scales: {
            x: { display: false, beginAtZero: true },
            y: { grid: { display: false } }
          }
        }
      });
    };
    initTopJournalsChart(chartData.bar1);

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
            backgroundColor: (ctx) => ctx.dataIndex === 0 ? primaryBlue : primaryBlueLight
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          layout: { padding: { right: 40 } },
          plugins: {
            tooltip: { titleFont: { family: fontFamily, size: 13, weight: 'bold' } },
            legend: { display: false },
            datalabels: {
              display: true,
              align: 'right',
              anchor: 'end',
              offset: 6,
              formatter: (value) => value.toLocaleString('id-ID'),
              color: (ctx) => ctx.dataIndex === 0 ? '#003366' : '#374151',
              font: { family: fontFamily, size: 11, weight: 'bold' }
            }
          },
          scales: {
            x: { display: false },
            y: { grid: { display: false } }
          }
        }
      });
    };
    initImpactChart(chartData.impact);

    // --- Ranked List Updater ---
    const updateRankedList = (html) => {
      document.getElementById('rankedListContainer').innerHTML = html;
    };

    // --- AJAX Handler ---
    const updateDashboardData = async (type) => {
      let params = new URLSearchParams({ type: type });

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
      try {
        const response = await fetch(url);
        if (!response.ok) return;
        const result = await response.json();

        if (type === 'ranked_list') updateRankedList(result.html);
        else if (type === 'productivity') initProductivityChart(result);
        else if (type === 'treemap') initTreemapChart(result.data);
        else if (type === 'pub_type') initPubTypeChart(result);
        else if (type === 'top_journals') initTopJournalsChart(result);
        else if (type === 'top_impact') initImpactChart(result);
        else if (type === 'stats') {
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
    document.getElementById('statsFaculty').addEventListener('change', () => updateDashboardData('stats'));
    document.getElementById('statsYear').addEventListener('change', () => updateDashboardData('stats'));
    document.getElementById('pubTypeFaculty').addEventListener('change', () => updateDashboardData('pub_type'));
    document.getElementById('pubTypeYear').addEventListener('change', () => updateDashboardData('pub_type'));
    document.getElementById('journalFaculty').addEventListener('change', () => updateDashboardData('top_journals'));
    document.getElementById('journalYear').addEventListener('change', () => updateDashboardData('top_journals'));
    document.getElementById('impactFaculty').addEventListener('change', () => updateDashboardData('top_impact'));
  });
</script>