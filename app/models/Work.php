<?php

class Work
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get work by ID
  public function getWorkById($id)
  {
    $this->db->query('SELECT * FROM works WHERE id_work = :id');
    $this->db->bind(':id', $id);
    return $this->db->single();
  }

  // Get all works for a specific author
  public function getWorksByAuthorId($authorId)
  {
    $this->db->query('
      SELECT w.* 
      FROM works w
      JOIN author_works aw ON w.id_work = aw.id_work
      WHERE aw.id_author = :author_id
      ORDER BY w.published DESC
    ');
    $this->db->bind(':author_id', $authorId);
    return $this->db->resultSet();
  }

  // Count works for a specific author
  public function countWorksByAuthorId($authorId)
  {
    $this->db->query('
      SELECT COUNT(*) as total
      FROM author_works
      WHERE id_author = :author_id
    ');
    $this->db->bind(':author_id', $authorId);
    $result = $this->db->single();
    return $result->total;
  }

  // Get works statistics by type for detailed graphs (Overall or filtered)
  // Get works statistics by type for detailed graphs (Overall or filtered)
  public function getWorkTypeStats($startYear = null, $faculty = null)
  {
    $sql = '
      SELECT w.type, SUBSTRING(w.published, 1, 4) as year, COUNT(*) as count 
      FROM works w
    ';

    // If filtering by faculty, we need to join authors
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' JOIN author_works aw ON w.id_work = aw.id_work 
                  JOIN authors a ON aw.id_author = a.id_author ';
    }

    $sql .= ' WHERE w.published IS NOT NULL AND w.published != "" ';

    if ($startYear) {
      $sql .= ' AND SUBSTRING(w.published, 1, 4) >= :start_year ';
    }

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' AND a.programs_name LIKE :faculty ';
    }

    $sql .= ' GROUP BY w.type, year ORDER BY year ASC';

    $this->db->query($sql);

    if ($startYear) {
      $this->db->bind(':start_year', $startYear);
    }
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }

    return $this->db->resultSet();
  }

  // Get Top Journals by Article Count (Filtered by Faculty and Year)
  public function getTopJournals($limit = 5, $faculty = null, $year = null)
  {
    $sql = '
          SELECT w.container_title as journal_name, COUNT(*) as total
          FROM works w
          JOIN author_works aw ON w.id_work = aw.id_work
          JOIN authors a ON aw.id_author = a.id_author
          WHERE w.container_title IS NOT NULL AND w.container_title != ""
      ';

    if ($year) {
      $sql .= ' AND w.published LIKE :year ';
    }
    $sql .= ' AND w.indexed_date_time IS NOT NULL AND w.indexed_date_time != "" ';

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' AND a.programs_name LIKE :faculty ';
    }

    $sql .= ' GROUP BY w.container_title ORDER BY total DESC LIMIT :limit';

    $this->db->query($sql);

    if ($year)
      $this->db->bind(':year', "$year%");
    if ($faculty && $faculty !== 'Semua Fakultas')
      $this->db->bind(':faculty', "%$faculty%");
    $this->db->bind(':limit', $limit);

    return $this->db->resultSet();
  }

  // Count total publications
  public function countTotalWorks()
  {
    $this->db->query('SELECT COUNT(*) as total FROM works');
    $result = $this->db->single();
    return $result->total;
  }

  // Get recent works
  public function getRecentWorks($limit = 10)
  {
    $this->db->query('SELECT * FROM works ORDER BY published DESC LIMIT :limit');
    $this->db->bind(':limit', $limit);
    return $this->db->resultSet();
  }

  // Get publication counts per year for a specific author (for productivity chart)
  public function getProductivityTrend($authorId)
  {
    // Group by first 4 characters of published date (Year)
    $this->db->query('
        SELECT SUBSTRING(published, 1, 4) as year, COUNT(*) as count
        FROM works w
        JOIN author_works aw ON w.id_work = aw.id_work
        WHERE aw.id_author = :author_id AND w.published IS NOT NULL AND w.published != ""
        GROUP BY year
        ORDER BY year ASC
     ');
    $this->db->bind(':author_id', $authorId);
    return $this->db->resultSet();
  }

  // Count works that are indexed (have indexed_date_time)
  public function countIndexedWorks($year = null)
  {
    $sql = 'SELECT COUNT(*) as total FROM works WHERE indexed_date_time IS NOT NULL AND indexed_date_time != ""';

    // User requested that indexing is based on presence of data.
    // However, if we still want to filter by year, we use published year.
    if ($year) {
      $sql .= ' AND published LIKE :year ';
    }

    $this->db->query($sql);
    if ($year) {
      $this->db->bind(':year', "$year%");
    }
    $result = $this->db->single();
    return $result->total;
  }

  // Get ratio of Main Author vs Co-Author
  public function getAuthorRoleRatios($authorId)
  {
    $this->db->query('
      SELECT w.authors, a.fullname
      FROM works w
      JOIN author_works aw ON w.id_work = aw.id_work
      JOIN authors a ON aw.id_author = a.id_author
      WHERE aw.id_author = :author_id
    ');
    $this->db->bind(':author_id', $authorId);
    $works = $this->db->resultSet();

    $utama = 0;
    $co = 0;

    foreach ($works as $work) {
      if (empty($work->authors))
        continue;

      $authorsList = explode(';', $work->authors);
      $firstAuthor = trim($authorsList[0]);

      if (strcasecmp($firstAuthor, $work->fullname) == 0) {
        $utama++;
      } else {
        $co++;
      }
    }

    $total = $utama + $co;
    $rasioUtama = $total > 0 ? round(($utama / $total) * 100, 1) : 0;
    $rasioCo = $total > 0 ? round(($co / $total) * 100, 1) : 0;

    return [
      'utama_count' => $utama,
      'co_count' => $co,
      'rasio_utama' => $rasioUtama,
      'rasio_coauthor' => $rasioCo
    ];
  }

  // Get unique work types for a specific author
  public function getUniqueTypesByAuthor($authorId)
  {
    $this->db->query('
      SELECT DISTINCT w.type 
      FROM works w
      JOIN author_works aw ON w.id_work = aw.id_work
      WHERE aw.id_author = :author_id AND w.type IS NOT NULL AND w.type != ""
      ORDER BY w.type ASC
    ');
    $this->db->bind(':author_id', $authorId);
    return $this->db->resultSet();
  }

  // Get paginated works by type for a specific author
  public function getWorksByTypeAndAuthor($authorId, $type, $limit, $offset)
  {
    $this->db->query('
      SELECT w.* 
      FROM works w
      JOIN author_works aw ON w.id_work = aw.id_work
      WHERE aw.id_author = :author_id AND w.type = :type
      ORDER BY w.published DESC
      LIMIT :limit OFFSET :offset
    ');
    $this->db->bind(':author_id', $authorId);
    $this->db->bind(':type', $type);
    $this->db->bind(':limit', $limit);
    $this->db->bind(':offset', $offset);
    return $this->db->resultSet();
  }

  // Count works by type for a specific author
  public function countWorksByTypeAndAuthor($authorId, $type)
  {
    $this->db->query('
      SELECT COUNT(*) as total 
      FROM works w
      JOIN author_works aw ON w.id_work = aw.id_work
      WHERE aw.id_author = :author_id AND w.type = :type
    ');
    $this->db->bind(':author_id', $authorId);
    $this->db->bind(':type', $type);
    $result = $this->db->single();
    return $result->total;
  }
}
