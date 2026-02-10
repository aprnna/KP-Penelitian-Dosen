<?php

class Author
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get all authors
  public function getAllAuthors()
  {
    $this->db->query('SELECT * FROM authors');
    return $this->db->resultSet();
  }

  // Get authors with pagination and optional filtering
  public function getAuthors($limit = 10, $offset = 0, $faculty = null, $search = null)
  {
    $sql = 'SELECT * FROM authors WHERE 1=1';

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' AND faculty LIKE :faculty';
    }

    if ($search) {
      $sql .= ' AND fullname LIKE :search';
    }

    $sql .= ' LIMIT :limit OFFSET :offset';

    $this->db->query($sql);

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }

    if ($search) {
      $this->db->bind(':search', "%$search%");
    }

    $this->db->bind(':limit', $limit);
    $this->db->bind(':offset', $offset);
    return $this->db->resultSet();
  }

  // Get author by ID
  public function getAuthorById($id)
  {
    $this->db->query('SELECT * FROM authors WHERE id_sinta = :id');
    $this->db->bind(':id', $id);
    return $this->db->single();
  }

  // Get author count with optional filtering
  public function countAuthors($faculty = null, $search = null)
  {
    $sql = 'SELECT COUNT(*) as total FROM authors WHERE 1=1';

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' AND faculty LIKE :faculty';
    }

    if ($search) {
      $sql .= ' AND fullname LIKE :search';
    }

    $this->db->query($sql);

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }

    if ($search) {
      $this->db->bind(':search', "%$search%");
    }

    $result = $this->db->single();
    return $result->total;
  }

  // Get top authors by Relevance Score
  public function getTopAuthors($limit = 10)
  {
    $this->db->query('SELECT * FROM authors ORDER BY sinta_score_overall DESC LIMIT :limit');
    $this->db->bind(':limit', $limit);
    return $this->db->resultSet();
  }

  // Search authors by name
  public function searchAuthors($keyword)
  {
    $this->db->query('SELECT * FROM authors WHERE fullname LIKE :keyword');
    $this->db->bind(':keyword', "%$keyword%");
    return $this->db->resultSet();
  }

  // Get authors by Faculty 
  public function getAuthorsByFaculty($faculty)
  {
    $this->db->query('SELECT * FROM authors WHERE faculty LIKE :faculty');
    $this->db->bind(':faculty', "%$faculty%");
    return $this->db->resultSet();
  }

  // Get faculty distribution (for Treemap) - Count total publications per faculty
  public function getFacultyPublicationStats($year = null)
  {
    $sql = '
      SELECT a.faculty as faculty, COUNT(aa.id_article) as total_publications
      FROM authors a
      JOIN author_article aa ON a.id_sinta = aa.id_sinta
    ';

    if ($year) {
      $sql .= ' JOIN articles ar ON aa.id_article = ar.id_article WHERE ar.published LIKE :year ';
    } else {
      $sql .= ' JOIN articles ar ON aa.id_article = ar.id_article '; // Ensure join for consistency if no year
    }

    $sql .= ' GROUP BY a.faculty ORDER BY total_publications DESC';

    $this->db->query($sql);

    if ($year) {
      $this->db->bind(':year', "$year%");
    }

    return $this->db->resultSet();
  }

  // Get top authors 
  // Count in End Year, Count in Start Year, subtract.
  // Get top authors based on Publication Count in a Date Range (for Trend Chart)
  public function getTopAuthorsByRangeCount($limit = 5, $startYear, $endYear, $faculty = null)
  {
    $sql = '
        SELECT 
            a.id_sinta, 
            a.fullname,
            COUNT(ar.id_article) as total_count
        FROM authors a
        JOIN author_article aa ON a.id_sinta = aa.id_sinta
        JOIN articles ar ON aa.id_article = ar.id_article
        WHERE ar.published IS NOT NULL AND ar.published != ""
        AND SUBSTRING(ar.published, 1, 4) BETWEEN :start_year AND :end_year
        AND ar.indexed_date_time IS NOT NULL AND ar.indexed_date_time != ""
      ';

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' AND a.faculty LIKE :faculty ';
    }

    $sql .= ' GROUP BY a.id_sinta ORDER BY total_count DESC LIMIT :limit';

    $this->db->query($sql);
    $this->db->bind(':start_year', $startYear);
    $this->db->bind(':end_year', $endYear);

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }
    $this->db->bind(':limit', $limit);
    return $this->db->resultSet();
  }

  // Get Top Authors filtered by Faculty and Year (Journal Count) for Ranked List
  public function getTopAuthorsByPublicationCount($limit = 10, $faculty = null, $year = null)
  {
    $sql = '
        SELECT a.id_sinta, a.fullname, a.faculty, a.nidn, a.sinta_score_overall as sinta_score_overall, a.s_hindex_scopus as h_index, COUNT(ar.id_article) as pub_count
        FROM authors a
        JOIN author_article aa ON a.id_sinta = aa.id_sinta
        JOIN articles ar ON aa.id_article = ar.id_article
      ';

    $conditions = [];
    // Filter by type Journal if requested "jurnal terindeks" or similar.
    // We filter where indexed_date_time is not null.
    $conditions[] = 'ar.indexed_date_time IS NOT NULL AND ar.indexed_date_time != ""';
    if ($year) {
      $conditions[] = 'ar.published LIKE :year';
    }

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $conditions[] = 'a.faculty LIKE :faculty';
    }

    if (!empty($conditions)) {
      $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $sql .= ' GROUP BY a.id_sinta ORDER BY pub_count DESC LIMIT :limit';

    $this->db->query($sql);

    if ($year) {
      $this->db->bind(':year', "$year%");
    }
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }
    $this->db->bind(':limit', $limit);

    return $this->db->resultSet();
  }

  // Get top 5 authors by impact (Sinta Score) for specific faculty
  public function getTopAuthorsByFaculty($faculty = null, $year = null, $limit = 5)
  {
    $sql = 'SELECT DISTINCT a.* FROM authors a';

    // If year is provided, we need to join works to check for activity
    if ($year) {
      $sql .= ' JOIN author_article aa ON a.id_sinta = aa.id_sinta 
                JOIN articles ar ON aa.id_article = ar.id_article ';
    }

    $conditions = [];
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $conditions[] = 'a.faculty LIKE :faculty';
    }

    if ($year) {
      $conditions[] = 'ar.published LIKE :year';
    }

    if (!empty($conditions)) {
      $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $sql .= ' ORDER BY a.sinta_score_overall DESC LIMIT :limit';

    $this->db->query($sql);

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }
    if ($year) {
      $this->db->bind(':year', "$year%");
    }
    $this->db->bind(':limit', $limit);
    return $this->db->resultSet();
  }
  // Get all unique faculties from authors table
  public function getUniqueFaculties()
  {
    $this->db->query('SELECT DISTINCT faculty FROM authors WHERE faculty IS NOT NULL AND faculty != "" ORDER BY faculty ASC');
    return $this->db->resultSet();
  }
}
