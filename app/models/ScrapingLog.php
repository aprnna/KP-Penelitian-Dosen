<?php

class ScrapingLog
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Add a log entry
  public function add($jobId, $level, $message, $extraData = null)
  {
    $sql = 'INSERT INTO scraping_logs (job_id, level, message, extra_data) 
            VALUES (:job_id, :level, :message, :extra_data)';

    $this->db->query($sql);
    $this->db->bind(':job_id', $jobId);
    $this->db->bind(':level', $level);
    $this->db->bind(':message', $message);
    $this->db->bind(':extra_data', $extraData ? json_encode($extraData) : null);

    return $this->db->execute();
  }

  // Get logs for a specific job
  public function getByJob($jobId, $level = null, $limit = 100, $offset = 0)
  {
    $sql = 'SELECT * FROM scraping_logs WHERE job_id = :job_id';

    if ($level) {
      $sql .= ' AND level = :level';
    }

    $sql .= ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';

    $this->db->query($sql);
    $this->db->bind(':job_id', $jobId);

    if ($level) {
      $this->db->bind(':level', $level);
    }

    $this->db->bind(':limit', $limit);
    $this->db->bind(':offset', $offset);

    return $this->db->resultSet();
  }

  // Get log count by level
  public function getCountByLevel($jobId)
  {
    $sql = 'SELECT level, COUNT(*) as count 
            FROM scraping_logs 
            WHERE job_id = :job_id 
            GROUP BY level';

    $this->db->query($sql);
    $this->db->bind(':job_id', $jobId);

    $results = $this->db->resultSet();

    $counts = [
      'DEBUG' => 0,
      'INFO' => 0,
      'WARNING' => 0,
      'ERROR' => 0
    ];

    foreach ($results as $result) {
      $counts[$result->level] = $result->count;
    }

    return $counts;
  }

  // Get latest logs (for real-time monitoring)
  public function getLatest($jobId, $sinceId = 0, $limit = 50)
  {
    $sql = 'SELECT * FROM scraping_logs 
            WHERE job_id = :job_id AND id > :since_id 
            ORDER BY created_at ASC 
            LIMIT :limit';

    $this->db->query($sql);
    $this->db->bind(':job_id', $jobId);
    $this->db->bind(':since_id', $sinceId);
    $this->db->bind(':limit', $limit);

    return $this->db->resultSet();
  }

  // Clear logs for a job
  public function clearByJob($jobId)
  {
    $this->db->query('DELETE FROM scraping_logs WHERE job_id = :job_id');
    $this->db->bind(':job_id', $jobId);
    return $this->db->execute();
  }
}
