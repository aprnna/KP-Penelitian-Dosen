<div class="container py-4" style="max-width: 1400px;">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="fw-bold">
        <i class="bi bi-cloud-download"></i> Scraping Dashboard
      </h2>
      <p class="text-muted">Manage and monitor data scraping jobs</p>
    </div>
  </div>

  <!-- Trigger Scraping Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-play-circle"></i> Start New Scraping Job</h5>
        </div>
        <div class="card-body">
          <form id="scrapingForm">
            <button type="submit" class="btn btn-success btn-lg w-100" id="startScrapingBtn">
              <i class="bi bi-arrow-down-circle-fill"></i> Start Scraping
            </button>
            <small class="text-muted d-block mt-2 text-center">Will scrape data from both Crossref and OpenAlex</small>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Real-time Progress Monitor -->
  <div class="row mb-4" id="progressSection" style="display: none;">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bi bi-activity"></i> Live Progress Monitor</h5>
          <button class="btn btn-sm btn-light" id="stopMonitoringBtn">
            <i class="bi bi-x-circle"></i> Close
          </button>
        </div>
        <div class="card-body">
          <!-- Status Badge -->
          <div class="mb-3">
            <span class="badge" id="statusBadge">Pending</span>
            <span class="text-muted ms-2">Job ID: <code id="currentJobId"></code></span>
          </div>

          <!-- Progress Bar -->
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="fw-bold">Progress</span>
              <span id="progressPercentage">0%</span>
            </div>
            <div class="progress" style="height: 25px;">
              <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" role="progressbar"
                style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>
          </div>

          <!-- Counters -->
          <div class="row text-center mb-3">
            <div class="col-md-3">
              <div class="p-3 bg-light rounded">
                <h3 class="mb-0 text-primary" id="totalRecords">0</h3>
                <small class="text-muted">Total Records</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="p-3 bg-light rounded">
                <h3 class="mb-0 text-success" id="processedRecords">0</h3>
                <small class="text-muted">Processed</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="p-3 bg-light rounded">
                <h3 class="mb-0 text-info" id="elapsedTime">00:00:00</h3>
                <small class="text-muted">Elapsed Time</small>
              </div>
            </div>
            <div class="col-md-3">
              <div class="p-3 bg-light rounded">
                <h3 class="mb-0 text-warning" id="estimatedRemaining">--</h3>
                <small class="text-muted">Est. Remaining</small>
              </div>
            </div>
          </div>

          <!-- Log Stream -->
          <div class="border rounded p-3 bg-dark text-light"
            style="height: 300px; overflow-y: auto; font-family: 'Courier New', monospace; font-size: 0.85rem;"
            id="logStream">
            <div class="text-muted">Waiting for logs...</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Job History Table -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
          <h5 class="mb-0 fw-bold">Scraping Job History</h5>
          <button class="btn btn-sm btn-primary" id="refreshJobsBtn">
            <i class="bi bi-arrow-clockwise"></i> Refresh
          </button>
        </div>
        <div class="card-body">
          <!-- Filters -->
          <div class="row mb-3">
            <div class="col-md-6">
              <select class="form-select form-select-sm" id="filterStatus">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="running">Running</option>
                <option value="finished">Finished</option>
                <option value="failed">Failed</option>
              </select>
            </div>
            <div class="col-md-6 text-end">
              <button class="btn btn-sm btn-outline-secondary" id="applyFiltersBtn">
                <i class="bi bi-funnel"></i> Apply Filters
              </button>
            </div>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>Job ID</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Duration</th>
                  <th>Records</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="jobsTableBody">
                <tr>
                  <td colspan="6" class="text-center text-muted">Loading jobs...</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav>
            <ul class="pagination justify-content-center" id="pagination">
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Job Detail Modal -->
<div class="modal fade" id="jobDetailModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-info-circle"></i> Job Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="jobDetailBody">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const baseUrl = '<?php echo BASE_URL; ?>';
    let currentJobId = null;
    let progressPolling = null;
    let logPolling = null;
    let lastLogId = 0;
    let currentPage = 1;

    // Status badge colors
    const statusColors = {
      'pending': 'bg-secondary',
      'running': 'bg-primary',
      'finished': 'bg-success',
      'failed': 'bg-danger'
    };

    // Format duration
    function formatDuration(seconds) {
      if (!seconds) return '--';
      const h = Math.floor(seconds / 3600);
      const m = Math.floor((seconds % 3600) / 60);
      const s = seconds % 60;
      return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
    }

    // Format timestamp
    function formatTimestamp(dateStr) {
      if (!dateStr) return '--';
      const date = new Date(dateStr);
      return date.toLocaleString();
    }

    // Start scraping
    document.getElementById('scrapingForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const btn = document.getElementById('startScrapingBtn');
      btn.disabled = true;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Starting...';

      try {
        const response = await fetch(`${baseUrl}scraping/triggerScraping`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
        });

        const result = await response.json();

        if (result.success) {
          currentJobId = result.job_id;
          document.getElementById('currentJobId').textContent = currentJobId;
          document.getElementById('progressSection').style.display = 'block';
          startMonitoring(currentJobId);
          loadJobs(); // Refresh job list
        } else {
          alert('Failed to start scraping: ' + result.message);
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Failed to start scraping');
      } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-arrow-down-circle-fill"></i> Start Scraping';
      }
    });

    // Start monitoring
    function startMonitoring(jobId) {
      lastLogId = 0;
      document.getElementById('logStream').innerHTML = '<div class="text-muted">Connecting...</div>';

      // Poll progress every 2 seconds
      progressPolling = setInterval(() => updateProgress(jobId), 2000);

      // Poll logs every 1 second
      logPolling = setInterval(() => updateLogs(jobId), 1000);

      // Initial update
      updateProgress(jobId);
      updateLogs(jobId);
    }

    // Stop monitoring
    function stopMonitoring() {
      clearInterval(progressPolling);
      clearInterval(logPolling);
      progressPolling = null;
      logPolling = null;
    }

    document.getElementById('stopMonitoringBtn').addEventListener('click', function () {
      stopMonitoring();
      document.getElementById('progressSection').style.display = 'none';
    });

    // Update progress
    async function updateProgress(jobId) {
      try {
        const response = await fetch(`${baseUrl}scraping/getJobProgress/${jobId}`);
        const result = await response.json();

        if (result.success) {
          const data = result.data;

          // Update status badge
          const badge = document.getElementById('statusBadge');
          badge.className = 'badge ' + statusColors[data.status];
          badge.textContent = data.status.toUpperCase();

          // Update progress bar
          document.getElementById('progressBar').style.width = data.progress_percentage + '%';
          document.getElementById('progressPercentage').textContent = data.progress_percentage.toFixed(1) + '%';

          // Update counters
          document.getElementById('totalRecords').textContent = data.total_records.toLocaleString();
          document.getElementById('processedRecords').textContent = data.processed_records.toLocaleString();
          document.getElementById('elapsedTime').textContent = formatDuration(data.elapsed_seconds);
          document.getElementById('estimatedRemaining').textContent = formatDuration(data.estimated_remaining);

          // Stop polling if finished or failed
          if (data.status === 'finished' || data.status === 'failed') {
            setTimeout(() => {
              stopMonitoring();
              loadJobs(); // Refresh job list
            }, 3000);
          }
        }
      } catch (error) {
        console.error('Error updating progress:', error);
      }
    }

    // Update logs
    async function updateLogs(jobId) {
      try {
        const response = await fetch(`${baseUrl}scraping/getLogs/${jobId}?since_id=${lastLogId}`);
        const result = await response.json();

        if (result.success && result.data.length > 0) {
          const logStream = document.getElementById('logStream');

          // Clear "Waiting" message on first log
          if (lastLogId === 0) {
            logStream.innerHTML = '';
          }

          result.data.forEach(log => {
            const levelColors = {
              'DEBUG': 'text-secondary',
              'INFO': 'text-info',
              'WARNING': 'text-warning',
              'ERROR': 'text-danger'
            };

            const logEntry = document.createElement('div');
            logEntry.className = 'mb-1 ' + levelColors[log.level];
            logEntry.textContent = `[${log.created_at}] [${log.level}] ${log.message}`;
            logStream.appendChild(logEntry);

            lastLogId = Math.max(lastLogId, log.id);
          });

          // Auto-scroll to bottom
          logStream.scrollTop = logStream.scrollHeight;
        }
      } catch (error) {
        console.error('Error updating logs:', error);
      }
    }

    // Load jobs
    async function loadJobs(page = 1) {
      currentPage = page;
      const status = document.getElementById('filterStatus').value;

      let url = `${baseUrl}scraping/getJobs?page=${page}`;
      if (status) url += `&status=${status}`;

      try {
        const response = await fetch(url);
        const result = await response.json();

        if (result.success) {
          renderJobs(result.data);
          renderPagination(result.pagination);
        }
      } catch (error) {
        console.error('Error loading jobs:', error);
      }
    }

    // Render jobs table
    function renderJobs(jobs) {
      const tbody = document.getElementById('jobsTableBody');

      if (jobs.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No jobs found</td></tr>';
        return;
      }

      tbody.innerHTML = jobs.map(job => {
        const duration = job.started_at && job.finished_at ?
          Math.floor((new Date(job.finished_at) - new Date(job.started_at)) / 1000) : null;

        return `
        <tr>
          <td><code class="small">${job.job_id.substring(0, 8)}</code></td>
          <td><span class="badge ${statusColors[job.status]}">${job.status}</span></td>
          <td>${formatTimestamp(job.created_at)}</td>
          <td>${formatDuration(duration)}</td>
          <td>${job.processed_records}/${job.total_records}</td>
          <td>
            <button class="btn btn-sm btn-outline-primary view-details" data-id="${job.id}">
              <i class="bi bi-eye"></i> Details
            </button>
          </td>
        </tr>
      `;
      }).join('');

      // Add event listeners to detail buttons
      document.querySelectorAll('.view-details').forEach(btn => {
        btn.addEventListener('click', function () {
          viewJobDetails(this.dataset.id);
        });
      });
    }

    // Render pagination
    function renderPagination(pagination) {
      const paginationEl = document.getElementById('pagination');
      const totalPages = pagination.total_pages;
      const currentPage = pagination.page;

      if (totalPages <= 1) {
        paginationEl.innerHTML = '';
        return;
      }

      let html = '';

      // Previous button
      html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
    </li>`;

      // Page numbers
      for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
          html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
          <a class="page-link" href="#" data-page="${i}">${i}</a>
        </li>`;
        } else if (i === currentPage - 3 || i === currentPage + 3) {
          html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
      }

      // Next button
      html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
      <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
    </li>`;

      paginationEl.innerHTML = html;

      // Add event listeners
      paginationEl.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          if (!this.closest('.disabled')) {
            loadJobs(parseInt(this.dataset.page));
          }
        });
      });
    }

    // View job details
    async function viewJobDetails(jobId) {
      const modal = new bootstrap.Modal(document.getElementById('jobDetailModal'));
      const modalBody = document.getElementById('jobDetailBody');
      modalBody.innerHTML = '<div class="text-center text-muted">Loading...</div>';
      modal.show();

      try {
        const response = await fetch(`${baseUrl}scraping/getJobDetails/${jobId}`);
        const result = await response.json();

        if (result.success) {
          const data = result.data;
          const job = data.job;

          modalBody.innerHTML = `
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Job ID:</strong><br>
              <code>${job.job_id}</code>
            </div>
            <div class="col-md-6">
              <strong>Source:</strong><br>
              <span class="badge bg-secondary">${job.source}</span>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <strong>Status:</strong><br>
              <span class="badge ${statusColors[job.status]}">${job.status}</span>
            </div>
            <div class="col-md-6">
              <strong>Progress:</strong><br>
              ${data.progress_percentage.toFixed(1)}% (${job.processed_records}/${job.total_records})
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-4">
              <strong>Created:</strong><br>
              ${formatTimestamp(job.created_at)}
            </div>
            <div class="col-md-4">
              <strong>Started:</strong><br>
              ${formatTimestamp(job.started_at)}
            </div>
            <div class="col-md-4">
              <strong>Finished:</strong><br>
              ${formatTimestamp(job.finished_at)}
            </div>
          </div>
          ${data.duration ? `
          <div class="row mb-3">
            <div class="col-12">
              <strong>Duration:</strong><br>
              ${data.duration}
            </div>
          </div>
          ` : ''}
          <div class="row mb-3">
            <div class="col-12">
              <strong>Log Summary:</strong><br>
              <span class="badge bg-secondary">DEBUG: ${data.log_counts.DEBUG}</span>
              <span class="badge bg-info">INFO: ${data.log_counts.INFO}</span>
              <span class="badge bg-warning">WARNING: ${data.log_counts.WARNING}</span>
              <span class="badge bg-danger">ERROR: ${data.log_counts.ERROR}</span>
            </div>
          </div>
          ${job.error_message ? `
          <div class="alert alert-danger">
            <strong>Error:</strong><br>
            ${job.error_message}
          </div>
          ` : ''}
        `;
        }
      } catch (error) {
        console.error('Error loading job details:', error);
        modalBody.innerHTML = '<div class="alert alert-danger">Failed to load job details</div>';
      }
    }

    // Event listeners
    document.getElementById('refreshJobsBtn').addEventListener('click', () => loadJobs(currentPage));
    document.getElementById('applyFiltersBtn').addEventListener('click', () => loadJobs(1));

    // Initial load
    loadJobs();
  });
</script>