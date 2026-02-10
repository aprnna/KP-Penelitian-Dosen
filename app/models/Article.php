<?php

class Article
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  // Get article by ID
  public function getArticleById($id)
  {
    $this->db->query('SELECT * FROM articles WHERE id_article = :id');
    $this->db->bind(':id', $id);
    return $this->db->single();
  }

  // Get all articles for a specific author
  public function getArticlesByAuthorId($authorId)
  {
    $this->db->query('
      SELECT a.* 
      FROM articles a
      JOIN author_article aa ON a.id_article = aa.id_article
      WHERE aa.id_sinta = :author_id
      ORDER BY a.published DESC
    ');
    $this->db->bind(':author_id', $authorId);
    return $this->db->resultSet();
  }

  // Count articles for a specific author
  public function countArticlesByAuthorId($authorId)
  {
    $this->db->query('
      SELECT COUNT(*) as total
      FROM author_article
      WHERE id_sinta = :author_id
    ');
    $this->db->bind(':author_id', $authorId);
    $result = $this->db->single();
    return $result->total;
  }

  // Get articles statistics by type for detailed graphs (Overall or filtered)
  public function getArticleTypeStats($startYear = null, $endYear = null, $faculty = null)
  {
    $sql = '
      SELECT a.type, SUBSTRING(a.published, 1, 4) as year, COUNT(*) as count 
      FROM articles a
    ';

    // If filtering by faculty, we need to join authors
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' JOIN author_article aa ON a.id_article = aa.id_article 
                  JOIN authors au ON aa.id_sinta = au.id_sinta ';
    }

    $sql .= ' WHERE a.published IS NOT NULL AND a.published != "" ';

    if ($startYear) {
      $sql .= ' AND SUBSTRING(a.published, 1, 4) >= :start_year ';
    }

    if ($endYear) {
      $sql .= ' AND SUBSTRING(a.published, 1, 4) <= :end_year ';
    }

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' AND au.faculty LIKE :faculty ';
    }

    $sql .= ' GROUP BY a.type, year ORDER BY year ASC';

    $this->db->query($sql);

    if ($startYear) {
      $this->db->bind(':start_year', $startYear);
    }
    if ($endYear) {
      $this->db->bind(':end_year', $endYear);
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
          SELECT a.journal_title as journal_name, COUNT(*) as total
          FROM articles a
          JOIN author_article aa ON a.id_article = aa.id_article
          JOIN authors au ON aa.id_sinta = au.id_sinta
          WHERE a.journal_title IS NOT NULL AND a.journal_title != ""
      ';

    if ($year) {
      $sql .= ' AND a.published LIKE :year ';
    }
    $sql .= ' AND a.indexed_date_time IS NOT NULL AND a.indexed_date_time != "" ';

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' AND au.faculty LIKE :faculty ';
    }

    $sql .= ' GROUP BY a.journal_title ORDER BY total DESC LIMIT :limit';

    $this->db->query($sql);

    if ($year)
      $this->db->bind(':year', "$year%");
    if ($faculty && $faculty !== 'Semua Fakultas')
      $this->db->bind(':faculty', "%$faculty%");
    $this->db->bind(':limit', $limit);

    return $this->db->resultSet();
  }

  // Count total publications
  public function countTotalArticles($year = null, $faculty = null)
  {
    $sql = 'SELECT COUNT(DISTINCT a.id_article) as total FROM articles a';

    // Joins needed if filtering by faculty
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' JOIN author_article aa ON a.id_article = aa.id_article 
                JOIN authors au ON aa.id_sinta = au.id_sinta ';
    }

    $conditions = [];
    // Only published year check if year is set
    if ($year) {
      $conditions[] = 'a.published LIKE :year';
    }

    // Faculty check
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $conditions[] = 'au.faculty LIKE :faculty';
    }

    if (!empty($conditions)) {
      $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $this->db->query($sql);

    if ($year) {
      $this->db->bind(':year', "$year%");
    }
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }

    $result = $this->db->single();
    return $result->total;
  }

  // Get recent articles
  public function getRecentArticles($limit = 10)
  {
    $this->db->query('SELECT * FROM articles ORDER BY published DESC LIMIT :limit');
    $this->db->bind(':limit', $limit);
    return $this->db->resultSet();
  }

  // Get publication counts per year for a specific author (for productivity chart)
  public function getProductivityTrend($authorId)
  {
    // Group by first 4 characters of published date (Year)
    $this->db->query('
        SELECT SUBSTRING(published, 1, 4) as year, COUNT(*) as count
        FROM articles a
        JOIN author_article aa ON a.id_article = aa.id_article
        WHERE aa.id_sinta = :author_id AND a.published IS NOT NULL AND a.published != ""
        GROUP BY year
        ORDER BY year ASC
     ');
    $this->db->bind(':author_id', $authorId);
    return $this->db->resultSet();
  }

  // Count articles that are indexed (have indexed_date_time)
  public function countIndexedArticles($year = null, $faculty = null)
  {
    $sql = 'SELECT COUNT(DISTINCT a.id_article) as total FROM articles a';

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $sql .= ' JOIN author_article aa ON a.id_article = aa.id_article 
                JOIN authors au ON aa.id_sinta = au.id_sinta ';
    }

    $conditions = [];
    $conditions[] = 'a.indexed_date_time IS NOT NULL AND a.indexed_date_time != ""';

    if ($year) {
      $conditions[] = 'a.published LIKE :year';
    }

    if ($faculty && $faculty !== 'Semua Fakultas') {
      $conditions[] = 'au.faculty LIKE :faculty';
    }

    $sql .= ' WHERE ' . implode(' AND ', $conditions);

    $this->db->query($sql);
    if ($year) {
      $this->db->bind(':year', "$year%");
    }
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $this->db->bind(':faculty', "%$faculty%");
    }

    $result = $this->db->single();
    return $result->total;
  }

  // Get ratio of Main Author vs Co-Author
  public function getAuthorRoleRatios($authorId, $year = null)
  {
    $sql = '
      SELECT a.authors, au.fullname
      FROM articles a
      JOIN author_article aa ON a.id_article = aa.id_article
      JOIN authors au ON aa.id_sinta = au.id_sinta
      WHERE aa.id_sinta = :author_id
    ';

    if ($year && $year !== 'Semua Tahun') {
      $sql .= ' AND a.published LIKE :year ';
    }

    $this->db->query($sql);
    $this->db->bind(':author_id', $authorId);
    if ($year && $year !== 'Semua Tahun') {
      $this->db->bind(':year', "$year%");
    }
    $articles = $this->db->resultSet();

    $utama = 0;
    $co = 0;

    foreach ($articles as $article) {
      if (empty($article->authors))
        continue;

      $authorsList = explode(';', $article->authors);
      $firstAuthor = trim($authorsList[0]);

      if (strcasecmp($firstAuthor, $article->fullname) == 0) {
        $utama++;
      } else {
        $co++;
      }
    }

    $total = $utama + $co;
    $rasioUtama = $total > 0 ? ceil(($utama / $total) * 100) : 0;
    $rasioCo = $total > 0 ? ceil(($co / $total) * 100) : 0;

    return [
      'utama_count' => $utama,
      'co_count' => $co,
      'rasio_utama' => $rasioUtama,
      'rasio_coauthor' => $rasioCo
    ];
  }

  // Get unique journals (short title) for a specific author
  public function getUniqueJournalsByAuthor($authorId)
  {
    $this->db->query('
      SELECT DISTINCT COALESCE(a.short_journal_title, "Other") as journal_title
      FROM articles a
      JOIN author_article aa ON a.id_article = aa.id_article
      WHERE aa.id_sinta = :author_id
      ORDER BY journal_title ASC
    ');
    $this->db->bind(':author_id', $authorId);
    return $this->db->resultSet();
  }

  // Get paginated articles by journal (short title) for a specific author
  public function getArticlesByJournalAndAuthor($authorId, $journal, $limit, $offset)
  {
    $sql = '
      SELECT a.*
      FROM articles a
      JOIN author_article aa ON a.id_article = aa.id_article
      WHERE aa.id_sinta = :author_id
    ';

    if ($journal === 'Other') {
      $sql .= ' AND (a.short_journal_title IS NULL OR a.short_journal_title = "") ';
    } else {
      $sql .= ' AND a.short_journal_title = :journal ';
    }

    $sql .= ' ORDER BY a.published DESC LIMIT :limit OFFSET :offset ';

    $this->db->query($sql);
    $this->db->bind(':author_id', $authorId);
    if ($journal !== 'Other') {
      $this->db->bind(':journal', $journal);
    }
    $this->db->bind(':limit', $limit);
    $this->db->bind(':offset', $offset);
    return $this->db->resultSet();
  }

  // Count articles by journal (short title) for a specific author
  public function countArticlesByJournalAndAuthor($authorId, $journal)
  {
    $sql = '
      SELECT COUNT(*) as total
      FROM articles a
      JOIN author_article aa ON a.id_article = aa.id_article
      WHERE aa.id_sinta = :author_id
    ';

    if ($journal === 'Other') {
      $sql .= ' AND (a.short_journal_title IS NULL OR a.short_journal_title = "") ';
    } else {
      $sql .= ' AND a.short_journal_title = :journal ';
    }

    $this->db->query($sql);
    $this->db->bind(':author_id', $authorId);
    if ($journal !== 'Other') {
      $this->db->bind(':journal', $journal);
    }
    $result = $this->db->single();
    return $result->total;
  }
}
