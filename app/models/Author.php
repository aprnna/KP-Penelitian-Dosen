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

  // Get authors with pagination
  public function getAuthors($limit = 10, $offset = 0)
  {
    $this->db->query('SELECT * FROM authors LIMIT :limit OFFSET :offset');
    $this->db->bind(':limit', $limit);
    $this->db->bind(':offset', $offset);
    return $this->db->resultSet();
  }

  // Get author by ID
  public function getAuthorById($id)
  {
    $this->db->query('SELECT * FROM authors WHERE id_author = :id');
    $this->db->bind(':id', $id);
    return $this->db->single();
  }

  // Get author count
  public function countAuthors()
  {
    $this->db->query('SELECT COUNT(*) as total FROM authors');
    $result = $this->db->single();
    return $result->total;
  }

  // Get top authors by Sinta Score V3 Overall
  public function getTopAuthors($limit = 10)
  {
    $this->db->query('SELECT * FROM authors ORDER BY sinta_score_v3_overall DESC LIMIT :limit');
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

  // Get authors by Faculty (programs_name)
  public function getAuthorsByFaculty($faculty)
  {
    $this->db->query('SELECT * FROM authors WHERE programs_name LIKE :faculty');
    $this->db->bind(':faculty', "%$faculty%");
    return $this->db->resultSet();
  }

  // Get faculty distribution (for Treemap) - Count total publications per faculty
  public function getFacultyPublicationStats($year = null)
  {
    $sql = '
      SELECT a.programs_name as faculty, COUNT(aw.id_work) as total_publications
      FROM authors a
      JOIN author_works aw ON a.id_author = aw.id_author
    ';

    if ($year) {
      $sql .= ' JOIN works w ON aw.id_work = w.id_work WHERE w.published LIKE :year ';
    } else {
      $sql .= ' JOIN works w ON aw.id_work = w.id_work '; // Ensure join for consistency if no year
    }

    $sql .= ' GROUP BY a.programs_name ORDER BY total_publications DESC';

    $this->db->query($sql);

    if ($year) {
      $this->db->bind(':year', "$year%");
    }

    return $this->db->resultSet();
  }

  // Get top authors based on Growth (Last Year Count - First Year Count)
  // This is a bit complex in SQL, doing a simplified version:
  // Count in End Year, Count in Start Year, subtract.
  public function getTopAuthorsByGrowth($limit = 5, $startYear, $endYear, $faculty = null)
  {
    $sql = '
        SELECT 
            a.id_author, 
            a.fullname,
            (SELECT COUNT(*) 
             FROM author_works aw2 
             JOIN works w2 ON aw2.id_work = w2.id_work 
             WHERE aw2.id_author = a.id_author AND w2.published LIKE :end_year
             AND w2.indexed_date_time IS NOT NULL AND w2.indexed_date_time != ""
            ) as end_count,
            (SELECT COUNT(*) 
             FROM author_works aw3 
             JOIN works w3 ON aw3.id_work = w3.id_work 
             WHERE aw3.id_author = a.id_author AND w3.published LIKE :start_year
             AND w3.indexed_date_time IS NOT NULL AND w3.indexed_date_time != ""
            ) as start_count
        FROM authors a
      ';

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' WHERE a.programs_name LIKE :faculty ';
    }

    $sql .= ' ORDER BY (end_count - start_count) DESC LIMIT :limit';

    $this->db->query($sql);
    $this->db->bind(':end_year', "$endYear%");
    $this->db->bind(':start_year', "$startYear%");

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
        SELECT a.id_author, a.fullname, a.programs_name, a.nidn, a.sinta_score_v3_overall, COUNT(w.id_work) as pub_count
        FROM authors a
        JOIN author_works aw ON a.id_author = aw.id_author
        JOIN works w ON aw.id_work = w.id_work
      ';

    $conditions = [];
    // Filter by type Journal if requested "jurnal terindeks" or similar.
    // We filter where indexed_date_time is not null.
    $conditions[] = 'w.indexed_date_time IS NOT NULL AND w.indexed_date_time != ""';
    if ($year) {
      $conditions[] = 'w.published LIKE :year';
    }

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $conditions[] = 'a.programs_name LIKE :faculty';
    }

    if (!empty($conditions)) {
      $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $sql .= ' GROUP BY a.id_author ORDER BY pub_count DESC LIMIT :limit';

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

  // Get Top 1 Representative Author per Faculty (Max Impact) and return Top Faculties
  public function getTopImpactFacultyRepresentatives($limit = 5)
  {
    // Logic: For each faculty, find the max Sinta Score.
    // Then find the author who has that max score.
    // Return top faculties by their max score.

    // Since MySQL < 8.0 doesn't support easy window functions, we use a join trick or simple group max
    // Assuming sinta_score_v3_overall is the metric.

    $this->db->query('
        SELECT a.programs_name as faculty, MAX(a.sinta_score_v3_overall) as max_score
        FROM authors a
        WHERE a.programs_name IS NOT NULL AND a.programs_name != ""
        GROUP BY a.programs_name
        ORDER BY max_score DESC
        LIMIT :limit
      ');
    $this->db->bind(':limit', $limit);
    $topFaculties = $this->db->resultSet();

    $results = [];
    foreach ($topFaculties as $fac) {
      // Get the author for this faculty and score
      $this->db->query('
            SELECT * FROM authors 
            WHERE programs_name = :faculty AND sinta_score_v3_overall = :score
            LIMIT 1
          ');
      $this->db->bind(':faculty', $fac->faculty);
      $this->db->bind(':score', $fac->max_score);
      $author = $this->db->single();
      if ($author) {
        $results[] = $author;
      }
    }
    return $results;
  }

  // Get top 5 authors by impact (Sinta Score) for specific faculty
  public function getTopAuthorsByFaculty($faculty = null, $limit = 5)
  {
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->query('
        SELECT * FROM authors 
        WHERE programs_name LIKE :faculty 
        ORDER BY sinta_score_v3_overall DESC 
        LIMIT :limit
      ');
      $this->db->bind(':faculty', "%$faculty%");
    } else {
      $this->db->query('
        SELECT * FROM authors 
        ORDER BY sinta_score_v3_overall DESC 
        LIMIT :limit
      ');
    }
    $this->db->bind(':limit', $limit);
    return $this->db->resultSet();
  }
  // Get all unique faculties from authors table
  public function getUniqueFaculties()
  {
    $this->db->query('SELECT DISTINCT programs_name FROM authors WHERE programs_name IS NOT NULL AND programs_name != "" ORDER BY programs_name ASC');
    return $this->db->resultSet();
  }
}
