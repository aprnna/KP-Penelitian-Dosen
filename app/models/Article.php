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

  // Get article by title (case-insensitive)
  public function getArticleByTitle($title)
  {
    $this->db->query('SELECT * FROM articles WHERE LOWER(TRIM(title)) = LOWER(TRIM(:title)) LIMIT 1');
    $this->db->bind(':title', $title);
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

  // Check whether an author exists in local DB
  public function authorExists($idSinta)
  {
    $this->db->query('SELECT id_sinta FROM authors WHERE id_sinta = :id_sinta LIMIT 1');
    $this->db->bind(':id_sinta', $idSinta);
    return (bool) $this->db->single();
  }

  // Insert/update a SINTA article into local articles table.
  // Match behavior is based on title, not id_article.
  // Return: ['status' => inserted|updated|unchanged, 'id_article' => int].
  public function upsertFromSintaArticle(array $article)
  {
    $title = $this->normalizeNullableText($article['title'] ?? null);
    if ($title === null) {
      throw new InvalidArgumentException('Invalid article title');
    }

    $existing = $this->getArticleByTitle($title);

    if (!$existing) {
      $incomingIdArticle = isset($article['id_article']) ? (int) $article['id_article'] : 0;

      if ($incomingIdArticle > 0) {
        $this->db->query('INSERT INTO articles (
            id_article,
            id_sinta,
            doi,
            title,
            authors,
            journal_title,
            short_journal_title,
            publisher,
            issue,
            volume,
            page,
            published,
            type,
            pdf_link,
            issn,
            issn_type,
            indexed_date_time,
            indexed_date_parts,
            url
          ) VALUES (
            :id_article,
            :id_sinta,
            :doi,
            :title,
            :authors,
            :journal_title,
            :short_journal_title,
            :publisher,
            :issue,
            :volume,
            :page,
            :published,
            :type,
            :pdf_link,
            :issn,
            :issn_type,
            :indexed_date_time,
            :indexed_date_parts,
            :url
          )');
      } else {
        $this->db->query('INSERT INTO articles (
            id_sinta,
            doi,
            title,
            authors,
            journal_title,
            short_journal_title,
            publisher,
            issue,
            volume,
            page,
            published,
            type,
            pdf_link,
            issn,
            issn_type,
            indexed_date_time,
            indexed_date_parts,
            url
          ) VALUES (
            :id_sinta,
            :doi,
            :title,
            :authors,
            :journal_title,
            :short_journal_title,
            :publisher,
            :issue,
            :volume,
            :page,
            :published,
            :type,
            :pdf_link,
            :issn,
            :issn_type,
            :indexed_date_time,
            :indexed_date_parts,
            :url
          )');
      }

      $this->bindArticleParams($article, $incomingIdArticle > 0 ? $incomingIdArticle : null);
      $this->db->execute();

      $resolvedIdArticle = $incomingIdArticle > 0 ? $incomingIdArticle : (int) $this->db->lastInsertId();

      return [
        'status' => 'inserted',
        'id_article' => $resolvedIdArticle,
      ];
    }

    if (!$this->articleFieldsChanged($existing, $article)) {
      return [
        'status' => 'unchanged',
        'id_article' => (int) $existing->id_article,
      ];
    }

    $this->db->query('UPDATE articles SET
        id_sinta = :id_sinta,
        doi = :doi,
        title = :title,
        authors = :authors,
        journal_title = :journal_title,
        short_journal_title = :short_journal_title,
        publisher = :publisher,
        issue = :issue,
        volume = :volume,
        page = :page,
        published = :published,
        type = :type,
        pdf_link = :pdf_link,
        issn = :issn,
        issn_type = :issn_type,
        indexed_date_time = :indexed_date_time,
        indexed_date_parts = :indexed_date_parts,
        url = :url
      WHERE id_article = :id_article');

    $this->bindArticleParams($article, (int) $existing->id_article);
    $this->db->execute();

    return [
      'status' => 'updated',
      'id_article' => (int) $existing->id_article,
    ];
  }

  // Ensure author-article relation exists.
  // Return true if new relation inserted, false if already exists.
  public function ensureAuthorArticleRelation($idSinta, $idArticle)
  {
    $this->db->query('INSERT IGNORE INTO author_article (id_sinta, id_article)
      VALUES (:id_sinta, :id_article)');
    $this->db->bind(':id_sinta', (int) $idSinta);
    $this->db->bind(':id_article', (int) $idArticle);
    $this->db->execute();

    return $this->db->rowCount() > 0;
  }

  private function bindArticleParams(array $article, $idArticleOverride = null)
  {
    if ($idArticleOverride !== null) {
      $this->db->bind(':id_article', (int) $idArticleOverride);
    }
    $this->db->bind(':id_sinta', isset($article['id_sinta']) ? (int) $article['id_sinta'] : null);
    $this->db->bind(':doi', $this->normalizeNullableText($article['doi'] ?? null));
    $this->db->bind(':title', $this->normalizeNullableText($article['title'] ?? null));
    $this->db->bind(':authors', $this->normalizeNullableText($article['authors'] ?? null));
    $this->db->bind(':journal_title', $this->normalizeNullableText($article['journal_title'] ?? null));
    $this->db->bind(':short_journal_title', $this->normalizeNullableText($article['short_journal_title'] ?? null));
    $this->db->bind(':publisher', $this->normalizeNullableText($article['publisher'] ?? null));
    $this->db->bind(':issue', $this->normalizeNullableText($article['issue'] ?? null));
    $this->db->bind(':volume', $this->normalizeNullableText($article['volume'] ?? null));
    $this->db->bind(':page', $this->normalizeNullableText($article['page'] ?? null));
    $this->db->bind(':published', $this->normalizeNullableText($article['published'] ?? null));
    $this->db->bind(':type', $this->normalizeNullableText($article['type'] ?? null));
    $this->db->bind(':pdf_link', $this->normalizeNullableText($article['pdf_link'] ?? null));
    $this->db->bind(':issn', $this->normalizeNullableText($article['issn'] ?? null));
    $this->db->bind(':issn_type', $this->normalizeNullableText($article['issn_type'] ?? null));
    $this->db->bind(':indexed_date_time', $this->normalizeNullableText($article['indexed_date_time'] ?? null));
    $this->db->bind(':indexed_date_parts', $this->normalizeNullableText($article['indexed_date_parts'] ?? null));
    $this->db->bind(':url', $this->normalizeNullableText($article['url'] ?? null));
  }

  private function articleFieldsChanged($existing, array $incoming)
  {
    $fields = [
      'id_sinta',
      'doi',
      'title',
      'authors',
      'journal_title',
      'short_journal_title',
      'publisher',
      'issue',
      'volume',
      'page',
      'published',
      'type',
      'pdf_link',
      'issn',
      'issn_type',
      'indexed_date_time',
      'indexed_date_parts',
      'url',
    ];

    foreach ($fields as $field) {
      $currentVal = $this->normalizeNullableText($existing->{$field} ?? null);
      $incomingVal = $this->normalizeNullableText($incoming[$field] ?? null);

      if ($field === 'id_sinta') {
        $currentVal = $currentVal === null ? null : (int) $currentVal;
        $incomingVal = $incomingVal === null ? null : (int) $incomingVal;
      }

      if ($currentVal !== $incomingVal) {
        return true;
      }
    }

    return false;
  }

  private function normalizeNullableText($value)
  {
    if ($value === null) {
      return null;
    }

    $value = trim((string) $value);
    return $value === '' ? null : $value;
  }
}
