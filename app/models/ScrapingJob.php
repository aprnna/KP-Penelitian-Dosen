<?php

class ScrapingJob
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Create a new scraping job
  public function create($parameters = null)
  {
    $jobId = $this->generateJobId();

    $sql = 'INSERT INTO scraping_jobs (job_id,  status, parameters) 
            VALUES (:job_id,  :status, :parameters)';

    $this->db->query($sql);
    $this->db->bind(':job_id', $jobId);
    $this->db->bind(':status', 'pending');
    $this->db->bind(':parameters', json_encode($parameters));

    if ($this->db->execute()) {
      return $jobId;
    }
    return false;
  }

  // Get all jobs with optional filters and pagination
  public function getAll($filters = [], $limit = 20, $offset = 0)
  {
    $sql = 'SELECT * FROM scraping_jobs WHERE 1=1';

    if (!empty($filters['status'])) {
      $sql .= ' AND status = :status';
    }

    if (!empty($filters['source'])) {
      $sql .= ' AND source = :source';
    }

    if (!empty($filters['date_from'])) {
      $sql .= ' AND created_at >= :date_from';
    }

    if (!empty($filters['date_to'])) {
      $sql .= ' AND created_at <= :date_to';
    }

    $sql .= ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';

    $this->db->query($sql);

    if (!empty($filters['status'])) {
      $this->db->bind(':status', $filters['status']);
    }
    if (!empty($filters['source'])) {
      $this->db->bind(':source', $filters['source']);
    }
    if (!empty($filters['date_from'])) {
      $this->db->bind(':date_from', $filters['date_from']);
    }
    if (!empty($filters['date_to'])) {
      $this->db->bind(':date_to', $filters['date_to']);
    }

    $this->db->bind(':limit', $limit);
    $this->db->bind(':offset', $offset);

    return $this->db->resultSet();
  }

  // Get total count for pagination
  public function getCount($filters = [])
  {
    $sql = 'SELECT COUNT(*) as total FROM scraping_jobs WHERE 1=1';

    if (!empty($filters['status'])) {
      $sql .= ' AND status = :status';
    }
    if (!empty($filters['source'])) {
      $sql .= ' AND source = :source';
    }
    if (!empty($filters['date_from'])) {
      $sql .= ' AND created_at >= :date_from';
    }
    if (!empty($filters['date_to'])) {
      $sql .= ' AND created_at <= :date_to';
    }

    $this->db->query($sql);

    if (!empty($filters['status'])) {
      $this->db->bind(':status', $filters['status']);
    }
    if (!empty($filters['source'])) {
      $this->db->bind(':source', $filters['source']);
    }
    if (!empty($filters['date_from'])) {
      $this->db->bind(':date_from', $filters['date_from']);
    }
    if (!empty($filters['date_to'])) {
      $this->db->bind(':date_to', $filters['date_to']);
    }

    $result = $this->db->single();
    return $result->total;
  }

  // Get job by ID
  public function getById($id)
  {
    $this->db->query('SELECT * FROM scraping_jobs WHERE id = :id');
    $this->db->bind(':id', $id);
    return $this->db->single();
  }

  // Get job by job_id (UUID)
  public function getByJobId($jobId)
  {
    $this->db->query('SELECT * FROM scraping_jobs WHERE job_id = :job_id');
    $this->db->bind(':job_id', $jobId);
    return $this->db->single();
  }

  // Update job status
  public function updateStatus($id, $status, $errorMessage = null)
  {
    $sql = 'UPDATE scraping_jobs SET status = :status';

    if ($status === 'running' && !$this->getStartedAt($id)) {
      $sql .= ', started_at = NOW()';
    }

    if ($status === 'finished' || $status === 'failed') {
      $sql .= ', finished_at = NOW()';
    }

    if ($errorMessage) {
      $sql .= ', error_message = :error_message';
    }

    $sql .= ' WHERE id = :id';

    $this->db->query($sql);
    $this->db->bind(':status', $status);
    $this->db->bind(':id', $id);

    if ($errorMessage) {
      $this->db->bind(':error_message', $errorMessage);
    }

    return $this->db->execute();
  }

  // Update job progress
  public function updateProgress($id, $processed, $total = null)
  {
    $sql = 'UPDATE scraping_jobs SET processed_records = :processed';

    if ($total !== null) {
      $sql .= ', total_records = :total';
    }

    $sql .= ' WHERE id = :id';

    $this->db->query($sql);
    $this->db->bind(':processed', $processed);
    $this->db->bind(':id', $id);

    if ($total !== null) {
      $this->db->bind(':total', $total);
    }

    return $this->db->execute();
  }

  // Get job statistics
  public function getStatistics($id)
  {
    $job = $this->getById($id);

    if (!$job) {
      return null;
    }

    // Calculate duration
    $duration = null;
    if ($job->started_at && $job->finished_at) {
      $start = new DateTime($job->started_at);
      $end = new DateTime($job->finished_at);
      $duration = $end->diff($start);
    }

    // Calculate progress percentage
    $progress = 0;
    if ($job->total_records > 0) {
      $progress = ($job->processed_records / $job->total_records) * 100;
    }

    return [
      'job' => $job,
      'duration' => $duration,
      'progress_percentage' => round($progress, 2),
      'is_running' => $job->status === 'running',
      'is_finished' => $job->status === 'finished',
      'is_failed' => $job->status === 'failed'
    ];
  }

  // Helper to check if job has started
  private function getStartedAt($id)
  {
    $this->db->query('SELECT started_at FROM scraping_jobs WHERE id = :id');
    $this->db->bind(':id', $id);
    $result = $this->db->single();
    return $result ? $result->started_at : null;
  }

  // Generate unique job ID
  private function generateJobId()
  {
    return sprintf(
      '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0x0fff) | 0x4000,
      mt_rand(0, 0x3fff) | 0x8000,
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0xffff)
    );
  }
}
