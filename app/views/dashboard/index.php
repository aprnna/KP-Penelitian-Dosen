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
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <i class="bi bi-people text-warning" style="font-size: 2.5rem;"></i>
                </div>
                <div class="ms-3">
                  <p class="text-muted mb-1 small">Total Dosen</p>
                  <h3 class="mb-0 fw-bold"><?php echo $stats['total_dosen']; ?></h3>
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
                  <h3 class="mb-0 fw-bold"><?php echo $stats['total_publikasi']; ?></h3>
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
                  <h3 class="mb-0 fw-bold"><?php echo $stats['total_terindeksasi']; ?></h3>
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
              <h6 class="mb-0 fw-bold">Informasi 5 Dosen Dengan Trend Produktivitas Publikasi Paling Meningkat</h6>
            </div>
            <div class="d-flex gap-2">
              <select class="form-select form-select-sm" id="trendFaculty" style="width: 150px;">
                <option value="Semua Fakultas">Semua Fakultas</option>
                <?php foreach ($faculties as $fac): ?>
                  <option value="<?php echo htmlspecialchars($fac->programs_name); ?>">
                    <?php echo htmlspecialchars($fac->programs_name); ?>
                  </option>
                <?php endforeach; ?>
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
          <h6 class="mb-0 fw-bold">Informasi Distribusi Setiap Fakultas Terhadap Total Publikasi UNIKOM</h6>
          <select class="form-select form-select-sm" id="treemapYear" style="width: 130px;">
            <option value="">Semua Tahun</option>
            <?php
            $currentYear = date('Y');
            for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
              echo "<option value='$i'>$i</option>";
            }
            ?>
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
              <h6 class="mb-0 fw-bold">Informasi Trend Jumlah Publikasi Berdasarkan Tipe Publikasi</h6>
              <small class="text-muted">Periode 5 Tahun Terakhir</small>
            </div>
            <select class="form-select form-select-sm" id="pubTypeFaculty" style="width: 150px;">
              <option value="Semua Fakultas">Semua Fakultas</option>
              <?php foreach ($faculties as $fac): ?>
                <option value="<?php echo htmlspecialchars($fac->programs_name); ?>">
                  <?php echo htmlspecialchars($fac->programs_name); ?>
                </option>
              <?php endforeach; ?>
            </select>
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
                  <h6 class="mb-0 fw-bold">Informasi 5 Jurnal dengan Jumlah Artikel Terbanyak</h6>
                  <small class="text-muted">Jumlah artikel dosen terindeks terbanyak per fakultas dalam periode 1
                    tahun</small>
                </div>
                <div class="d-flex gap-2">
                  <select class="form-select form-select-sm" id="journalFaculty" style="width: 150px;">
                    <option value="Semua Fakultas">Semua Fakultas</option>
                    <?php foreach ($faculties as $fac): ?>
                      <option value="<?php echo htmlspecialchars($fac->programs_name); ?>">
                        <?php echo htmlspecialchars($fac->programs_name); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <select class="form-select form-select-sm" id="journalYear" style="width: 100px;">
                    <option value="">Semua Tahun</option>
                    <?php
                    $currentYear = date('Y');
                    for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
                      echo "<option value='$i'>$i</option>";
                    }
                    ?>
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
                  <h6 class="mb-0 fw-bold">Informasi 5 Dosen dengan Dampak Penelitian Tertinggi</h6>
                  <small class="text-muted">Berdasarkan Analisis Komposit Metrik Kutipan (Sinta Score)</small>
                </div>
                <div class="d-flex gap-2">
                  <select class="form-select form-select-sm" id="impactFaculty" style="width: 150px;">
                    <option value="Semua Fakultas">Semua Fakultas</option>
                    <?php foreach ($faculties as $fac): ?>
                      <option value="<?php echo htmlspecialchars($fac->programs_name); ?>">
                        <?php echo htmlspecialchars($fac->programs_name); ?>
                      </option>
                    <?php endforeach; ?>
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
                <option value="<?php echo htmlspecialchars($fac->programs_name); ?>">
                  <?php echo htmlspecialchars($fac->programs_name); ?>
                </option>
              <?php endforeach; ?>
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
  document.addEventListener('DOMContentLoaded', function () {
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

      const datasets = data.datasets.map((ds, index) => {
        const colors = ['#0066cc', '#dc3545', '#ffc107', '#198754', '#9b59b6'];
        return {
          label: ds.label,
          data: ds.data,
          borderColor: colors[index % colors.length],
          backgroundColor: colors[index % colors.length] + '1A',
          tension: 0.4,
          borderWidth: 2,
          pointRadius: 4
        };
      });

      multiLineChartInstance = new Chart(ctx, {
        type: 'line',
        data: { labels: data.years, datasets: datasets },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'bottom', labels: { font: { family: fontFamily, size: 11 }, usePointStyle: true, padding: 15 } },
            tooltip: { titleFont: { family: fontFamily, size: 13, weight: 'bold' }, bodyFont: { family: fontFamily, size: 12 } }
          },
          scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { family: fontFamily, size: 11 } } },
            x: { grid: { display: false }, ticks: { font: { family: fontFamily, size: 11 } } }
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
              const colors = ['#0066cc', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14'];
              return colors[ctx.dataIndex % colors.length];
            },
            labels: {
              display: true, color: '#fff',
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
              titleFont: { family: fontFamily, size: 13, weight: 'bold' }, bodyFont: { family: fontFamily, size: 12 },
              callbacks: {
                title: (ctx) => ctx[0].raw._data.name,
                label: (ctx) => {
                  const item = ctx.raw._data;
                  return `Publikasi: ${item.value}`;
                }
              }
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

      const datasets = data.datasets.map((ds, index) => {
        const colors = ['#0066cc', '#ffc107', '#dc3545', '#9b59b6', '#6c757d'];
        return {
          label: ds.label, data: ds.data,
          borderColor: colors[index % colors.length],
          backgroundColor: colors[index % colors.length] + '1A',
          tension: 0.4, borderWidth: 2, fill: true
        };
      });

      pubTypeChartInstance = new Chart(ctx, {
        type: 'line',
        data: { labels: data.labels, datasets: datasets },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
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
            backgroundColor: '#a78bfa',
            borderRadius: 5
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          plugins: { tooltip: { titleFont: { family: fontFamily, size: 13, weight: 'bold' } }, bodyFont: { family: fontFamily, size: 12 }, legend: { display: false } },
          scales: { x: { beginAtZero: true }, y: { grid: { display: false } } }
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
            backgroundColor: '#20c997', // Teal color
            borderRadius: 5
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          plugins: { tooltip: { titleFont: { family: fontFamily, size: 13, weight: 'bold' } }, legend: { display: false } },
          scales: { x: { beginAtZero: true }, y: { grid: { display: false } } }
        }
      });
    };
    initImpactChart(chartData.impact);


    // --- Ranked List Updater ---
    const updateRankedList = (data) => {
      const container = document.getElementById('rankedListContainer');
      let html = '';
      data.forEach((dosen, index) => {
        const isAlternate = index % 2 === 1;
        html += `
            <div class="list-group-item border-0 py-3 ${isAlternate ? 'bg-light' : ''}">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <span class="badge ${dosen.badge_class} rounded-circle"
                    style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    ${dosen.badge_icon ? `<i class="bi ${dosen.badge_icon}"></i>` : dosen.rank}
                  </span>
                </div>
                <div class="flex-shrink-0 ms-3">
                  <img src="${baseUrl}logo_only.png" alt="Avatar" class="rounded-circle"
                    style="width: 40px; height: 40px; object-fit: cover;">
                </div>
                <div class="ms-3 flex-grow-1">
                  <p class="mb-0 fw-bold small">${dosen.name}</p>
                  <small class="text-muted"> <i class="bi bi-building-fill text-primary"></i> ${dosen.faculty}</small><br />
                  <small class="text-muted"> <i class="bi bi-person-fill text-primary"></i> NIDN: ${dosen.nidn}</small><br />
                  <small class="text-muted">Jumlah Publikasi Ter-Index: ${dosen.publications}</small>
                </div>
              </div>
            </div>`;
      });
      container.innerHTML = html;
    };


    // --- AJAX Handler ---
    const updateDashboardData = async (type) => {
      let params = new URLSearchParams({ type: type });

      if (type === 'ranked_list') {
        params.append('faculty', document.getElementById('rankFaculty').value);
      } else if (type === 'productivity') {
        params.append('faculty', document.getElementById('trendFaculty').value);
      } else if (type === 'treemap') {
        params.append('year', document.getElementById('treemapYear').value);
      } else if (type === 'pub_type') {
        params.append('faculty', document.getElementById('pubTypeFaculty').value);
      } else if (type === 'top_journals') {
        params.append('faculty', document.getElementById('journalFaculty').value);
        params.append('year', document.getElementById('journalYear').value);
      } else if (type === 'top_impact') {
        params.append('faculty', document.getElementById('impactFaculty').value);
      }

      const url = `${baseUrl}dashboard/filterData?${params.toString()}`;
      console.log('Fetching URL:', url); // Debug

      try {
        const response = await fetch(url);
        if (!response.ok) return;

        const result = await response.json();

        if (type === 'ranked_list') {
          updateRankedList(result.data);
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
        }
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
      }
    };

    // --- Event Listeners ---
    document.getElementById('rankFaculty').addEventListener('change', () => updateDashboardData('ranked_list'));
    document.getElementById('trendFaculty').addEventListener('change', () => updateDashboardData('productivity'));
    document.getElementById('treemapYear').addEventListener('change', () => updateDashboardData('treemap'));

    // New Filters
    document.getElementById('pubTypeFaculty').addEventListener('change', () => updateDashboardData('pub_type'));
    document.getElementById('journalFaculty').addEventListener('change', () => updateDashboardData('top_journals'));
    document.getElementById('journalYear').addEventListener('change', () => updateDashboardData('top_journals'));
    document.getElementById('impactFaculty').addEventListener('change', () => updateDashboardData('top_impact'));

  });
</script>