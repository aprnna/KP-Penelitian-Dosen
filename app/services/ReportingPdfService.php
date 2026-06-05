<?php

class ReportingPdfService
{
  private $pageWidth = 842;
  private $pageHeight = 595;
  private $margins = [
    'top' => 36,
    'right' => 24,
    'bottom' => 32,
    'left' => 24,
  ];
  private $headerFontSize = 9;
  private $bodyFontSize = 8;
  private $lineHeight = 10;

  private $objects = [];
  private $pages = [];
  private $currentContent = '';
  private $fontObjectId = 0;
  private $cursorY = 0;
  private $pageNumber = 0;
  private $pageInitialized = false;

  public function download(array $rows, $startYear, $endYear)
  {
    $startLabel = $this->sanitizeYearLabel($startYear);
    $endLabel = $this->sanitizeYearLabel($endYear);

    $this->resetState();
    $columns = $this->buildColumns();

    $this->openPage($columns, $startLabel, $endLabel);

    if (empty($rows)) {
      $this->ensureSpaceFor(32, $columns, $startLabel, $endLabel);
      $this->drawText($this->margins['left'], $this->cursorY + 14, 'Tidak ada data artikel pada rentang tahun tersebut.', 10);
      $this->cursorY += 32;
    } else {
      $rows = array_values($rows);
      foreach ($rows as $index => $row) {
        $rowData = $this->mapRowData($row, $index + 1);
        $layout = $this->measureRow($columns, $rowData);
        $this->ensureSpaceFor($layout['height'], $columns, $startLabel, $endLabel);
        $this->drawTableRow($columns, $rowData, $layout);
        $this->cursorY += $layout['height'];
      }
    }

    $this->closePage();

    $pdf = $this->buildPdf();
    $fileName = 'reporting-' . $startLabel . '-to-' . $endLabel . '.pdf';

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . strlen($pdf));
    echo $pdf;
    exit;
  }

  private function resetState()
  {
    $this->objects = [];
    $this->pages = [];
    $this->currentContent = '';
    $this->fontObjectId = 0;
    $this->cursorY = 0;
    $this->pageNumber = 0;
    $this->pageInitialized = false;
  }

  private function buildColumns()
  {
    $usableWidth = $this->pageWidth - $this->margins['left'] - $this->margins['right'];
    $definitions = [
      ['key' => 'no', 'label' => 'No', 'ratio' => 0.05, 'align' => 'center'],
      ['key' => 'title', 'label' => 'Judul Artikel', 'ratio' => 0.24, 'align' => 'left'],
      ['key' => 'authors', 'label' => 'Penulis', 'ratio' => 0.18, 'align' => 'left'],
      ['key' => 'doi', 'label' => 'DOI', 'ratio' => 0.11, 'align' => 'left'],
      ['key' => 'quartile', 'label' => 'Quartile', 'ratio' => 0.07, 'align' => 'center'],
      ['key' => 'url', 'label' => 'Link Artikel', 'ratio' => 0.17, 'align' => 'left'],
      ['key' => 'citation_count', 'label' => 'Jumlah Sitasi', 'ratio' => 0.08, 'align' => 'center'],
      ['key' => 'article_source', 'label' => 'Sumber Artikel', 'ratio' => 0.10, 'align' => 'left'],
    ];

    $columns = [];
    $allocated = 0;
    $count = count($definitions);

    foreach ($definitions as $index => $definition) {
      if ($index === $count - 1) {
        $width = $usableWidth - $allocated;
      } else {
        $width = (int) round($usableWidth * $definition['ratio']);
        $allocated += $width;
      }

      $columns[] = [
        'key' => $definition['key'],
        'label' => $definition['label'],
        'align' => $definition['align'],
        'width' => $width,
      ];
    }

    return $columns;
  }

  private function openPage(array $columns, $startYear, $endYear)
  {
    $this->beginPage($this->pageWidth, $this->pageHeight);
    $this->pageInitialized = true;
    $this->pageNumber++;
    $this->cursorY = $this->margins['top'];

    $this->drawPageHeader($startYear, $endYear);
    $this->drawTableHeader($columns);
  }

  private function closePage()
  {
    if (!$this->pageInitialized) {
      return;
    }

    $this->endPage();
    $this->pageInitialized = false;
  }

  private function ensureSpaceFor($requiredHeight, array $columns, $startYear, $endYear)
  {
    $available = $this->pageHeight - $this->margins['bottom'] - $this->cursorY;
    if ($requiredHeight <= $available) {
      return;
    }

    $this->closePage();
    $this->openPage($columns, $startYear, $endYear);
  }

  private function drawPageHeader($startYear, $endYear)
  {
    $left = $this->margins['left'];
    $this->drawText($left, $this->cursorY + 8, 'Laporan Reporting Artikel Dosen', 14);
    $this->drawText($left, $this->cursorY + 24, 'Periode: ' . $startYear . ' s.d. ' . $endYear, 10);

    $pageLabel = 'Halaman ' . $this->pageNumber;
    $labelWidth = $this->measureStringWidth($pageLabel, 10);
    $labelX = $this->pageWidth - $this->margins['right'] - $labelWidth - 2;
    if ($labelX < $left) {
      $labelX = $left;
    }
    $this->drawText($labelX, $this->cursorY + 24, $pageLabel, 10);

    $this->cursorY += 46;
  }

  private function drawTableHeader(array $columns)
  {
    $rowHeight = 22;
    $x = $this->margins['left'];
    foreach ($columns as $column) {
      $this->drawFilledRect($x, $this->cursorY, $column['width'], $rowHeight, 0.92);
      $this->drawRect($x, $this->cursorY, $column['width'], $rowHeight);

      $lines = $this->wrapCellText($column['label'], $column['width'], $this->headerFontSize);
      $lineY = $this->cursorY + 13;
      foreach ($lines as $line) {
        $textX = $this->resolveAlignedX($x, $column['width'], $line, 'center', $this->headerFontSize);
        $this->drawText($textX, $lineY, $line, $this->headerFontSize);
        $lineY += $this->lineHeight;
      }

      $x += $column['width'];
    }

    $this->cursorY += $rowHeight;
  }

  private function measureRow(array $columns, array $rowData)
  {
    $lines = [];
    $maxLines = 1;

    foreach ($columns as $column) {
      $cellLines = $this->wrapCellText($rowData[$column['key']], $column['width'], $this->bodyFontSize);
      $lines[$column['key']] = $cellLines;
      $maxLines = max($maxLines, count($cellLines));
    }

    $height = max(20, ($maxLines * $this->lineHeight) + 6);

    return [
      'height' => $height,
      'lines' => $lines,
    ];
  }

  private function drawTableRow(array $columns, array $rowData, array $layout)
  {
    $x = $this->margins['left'];
    $rowHeight = $layout['height'];

    foreach ($columns as $column) {
      $cKey = $column['key'];
      $cellLines = $layout['lines'][$cKey];
      $this->drawRect($x, $this->cursorY, $column['width'], $rowHeight);

      $lineY = $this->cursorY + 11;
      foreach ($cellLines as $line) {
        $textX = $this->resolveAlignedX($x, $column['width'], $line, $column['align'], $this->bodyFontSize);
        $this->drawText($textX, $lineY, $line, $this->bodyFontSize);
        $lineY += $this->lineHeight;
      }

      $x += $column['width'];
    }
  }

  private function mapRowData($row, $position)
  {
    return [
      'no' => (string) $position,
      'title' => $this->valueFromRow($row, 'title', '-'),
      'authors' => $this->valueFromRow($row, 'authors', '-'),
      'doi' => $this->valueFromRow($row, 'doi', '-'),
      'quartile' => $this->valueFromRow($row, 'quartile', '-'),
      'url' => $this->valueFromRow($row, 'url', '-'),
      'citation_count' => $this->formatNumeric($this->valueFromRow($row, 'citation_count', '-')),
      'article_source' => $this->valueFromRow($row, 'article_source', '-'),
    ];
  }

  private function valueFromRow($row, $key, $default = '-')
  {
    if (is_array($row) && array_key_exists($key, $row)) {
      return $row[$key] ?? $default;
    }

    if (is_object($row) && isset($row->$key)) {
      return $row->$key ?? $default;
    }

    return $default;
  }

  private function formatNumeric($value)
  {
    if ($value === null || $value === '') {
      return '-';
    }

    if (is_numeric($value)) {
      return (string) $value;
    }

    return (string) $value;
  }

  private function wrapCellText($text, $cellWidth, $fontSize)
  {
    $clean = $this->sanitizeText($text);
    if ($clean === '') {
      return ['-'];
    }

    $usableWidth = max(10, $cellWidth - 4);
    $words = preg_split('/\s+/u', $clean);
    $lines = [];
    $current = '';

    foreach ($words as $word) {
      $chunks = $this->splitWordByWidth($word, $usableWidth, $fontSize);
      foreach ($chunks as $chunk) {
        if ($current === '') {
          $current = $chunk;
          continue;
        }

        $candidate = $current . ' ' . $chunk;
        if ($this->measureStringWidth($candidate, $fontSize) <= $usableWidth) {
          $current = $candidate;
        } else {
          $lines[] = $current;
          $current = $chunk;
        }
      }
    }

    if ($current !== '') {
      $lines[] = $current;
    }

    return empty($lines) ? ['-'] : $lines;
  }

  private function splitWordByWidth($word, $maxWidth, $fontSize)
  {
    $word = (string) $word;
    if ($word === '') {
      return [''];
    }

    if ($this->measureStringWidth($word, $fontSize) <= $maxWidth) {
      return [$word];
    }

    $chunks = [];
    $buffer = '';
    $length = strlen($word);

    for ($i = 0; $i < $length; $i++) {
      $char = $word[$i];
      $candidate = $buffer . $char;
      if ($buffer !== '' && $this->measureStringWidth($candidate, $fontSize) > $maxWidth) {
        $chunks[] = $buffer;
        $buffer = $char;
      } else {
        $buffer = $candidate;
      }
    }

    if ($buffer !== '') {
      $chunks[] = $buffer;
    }

    return $chunks;
  }

  private function sanitizeYearLabel($value)
  {
    $value = trim((string) $value);
    if ($value === '') {
      return '-';
    }

    if (preg_match('/^\d{4}$/', $value)) {
      return $value;
    }

    $digits = preg_replace('/\D+/', '', $value);
    return $digits !== '' ? $digits : '-';
  }

  private function sanitizeText($text)
  {
    $text = trim(preg_replace('/\s+/u', ' ', (string) $text));
    if ($text === '') {
      return '';
    }

    if (function_exists('iconv')) {
      $converted = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
      if ($converted !== false) {
        $text = $converted;
      }
    }

    $text = preg_replace('/[^\x20-\x7E]/', '', $text);
    return trim($text);
  }

  private function resolveAlignedX($cellX, $cellWidth, $text, $align, $fontSize)
  {
    $textWidth = min($cellWidth - 4, $this->measureStringWidth($text, $fontSize));
    $padding = 2;

    if ($align === 'center') {
      $padding = max(2, ($cellWidth - $textWidth) / 2);
    } elseif ($align === 'right') {
      $padding = max(2, $cellWidth - $textWidth - 2);
    }

    return $cellX + $padding;
  }

  private function measureStringWidth($text, $fontSize)
  {
    $text = (string) $text;
    $totalUnits = 0;
    $length = strlen($text);

    for ($i = 0; $i < $length; $i++) {
      $totalUnits += $this->getCharWidth($text[$i]);
    }

    return ($totalUnits / 1000) * $fontSize;
  }

  private function getCharWidth($char)
  {
    $code = ord($char);
    $map = $this->charWidthMap();
    if (isset($map[$code])) {
      return $map[$code];
    }

    return 500;
  }

  private function charWidthMap()
  {
    static $map = null;
    if ($map !== null) {
      return $map;
    }

    $map = [
      32 => 278,
      33 => 278,
      34 => 355,
      35 => 556,
      36 => 556,
      37 => 889,
      38 => 667,
      39 => 191,
      40 => 333,
      41 => 333,
      42 => 389,
      43 => 584,
      44 => 278,
      45 => 333,
      46 => 278,
      47 => 278,
      48 => 556,
      49 => 556,
      50 => 556,
      51 => 556,
      52 => 556,
      53 => 556,
      54 => 556,
      55 => 556,
      56 => 556,
      57 => 556,
      58 => 278,
      59 => 278,
      60 => 584,
      61 => 584,
      62 => 584,
      63 => 556,
      64 => 1015,
      65 => 667,
      66 => 667,
      67 => 722,
      68 => 722,
      69 => 667,
      70 => 611,
      71 => 778,
      72 => 722,
      73 => 278,
      74 => 500,
      75 => 667,
      76 => 556,
      77 => 833,
      78 => 722,
      79 => 778,
      80 => 667,
      81 => 778,
      82 => 722,
      83 => 667,
      84 => 611,
      85 => 722,
      86 => 667,
      87 => 944,
      88 => 667,
      89 => 667,
      90 => 611,
      91 => 278,
      92 => 278,
      93 => 278,
      94 => 469,
      95 => 556,
      96 => 333,
      97 => 556,
      98 => 556,
      99 => 500,
      100 => 556,
      101 => 556,
      102 => 278,
      103 => 556,
      104 => 556,
      105 => 222,
      106 => 222,
      107 => 500,
      108 => 222,
      109 => 833,
      110 => 556,
      111 => 556,
      112 => 556,
      113 => 556,
      114 => 333,
      115 => 500,
      116 => 278,
      117 => 556,
      118 => 500,
      119 => 722,
      120 => 500,
      121 => 500,
      122 => 500,
      123 => 334,
      124 => 260,
      125 => 334,
      126 => 584,
    ];

    return $map;
  }

  private function drawText($x, $yFromTop, $text, $size = 10)
  {
    $x = $this->formatNumber($x);
    $y = $this->formatNumber($this->pageHeight - $yFromTop);
    $size = (int) $size;
    $safeText = $this->escapePdfText($text);

    $this->currentContent .= "BT /F1 {$size} Tf {$x} {$y} Td ({$safeText}) Tj ET\n";
  }

  private function drawRect($x, $yFromTop, $w, $h)
  {
    $x1 = $this->formatNumber($x);
    $y1 = $this->formatNumber($this->pageHeight - $yFromTop);
    $w = $this->formatNumber($w);
    $h = $this->formatNumber($h);

    $this->currentContent .= "{$x1} {$y1} m\n";
    $this->currentContent .= $this->formatNumber($x + $w) . " {$y1} l\n";
    $this->currentContent .= $this->formatNumber($x + $w) . ' ' . $this->formatNumber($this->pageHeight - ($yFromTop + $h)) . " l\n";
    $this->currentContent .= "{$x1} " . $this->formatNumber($this->pageHeight - ($yFromTop + $h)) . " l\n";
    $this->currentContent .= "{$x1} {$y1} l S\n";
  }

  private function drawFilledRect($x, $yFromTop, $w, $h, $gray)
  {
    $gray = max(0, min(1, $gray));
    $x1 = $this->formatNumber($x);
    $y1 = $this->formatNumber($this->pageHeight - $yFromTop - $h);
    $w = $this->formatNumber($w);
    $h = $this->formatNumber($h);

    $this->currentContent .= 'q ' . $this->formatNumber($gray) . ' g ' . $x1 . ' ' . $y1 . ' ' . $w . ' ' . $h . " re f Q\n";
  }

  private function beginPage($width, $height)
  {
    $this->pageWidth = (float) $width;
    $this->pageHeight = (float) $height;
    $this->currentContent = '';
  }

  private function endPage()
  {
    $this->pages[] = [
      'width' => $this->pageWidth,
      'height' => $this->pageHeight,
      'content' => $this->currentContent,
    ];

    $this->currentContent = '';
  }

  private function buildPdf()
  {
    $this->objects = [];

    $catalogId = $this->addObject('');
    $pagesId = $this->addObject('');
    $this->fontObjectId = $this->addObject('<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>');

    $pageObjectIds = [];
    foreach ($this->pages as $page) {
      $content = $page['content'];
      $contentObjectId = $this->addObject("<< /Length " . strlen($content) . " >>\nstream\n" . $content . "endstream");

      $pageBody = "<< /Type /Page /Parent {$pagesId} 0 R /MediaBox [0 0 " .
        $this->formatNumber($page['width']) . ' ' . $this->formatNumber($page['height']) .
        "] /Resources << /Font << /F1 {$this->fontObjectId} 0 R >> >> /Contents {$contentObjectId} 0 R >>";
      $pageObjectIds[] = $this->addObject($pageBody);
    }

    $kids = '';
    foreach ($pageObjectIds as $id) {
      $kids .= $id . ' 0 R ';
    }

    $this->setObject($pagesId, "<< /Type /Pages /Kids [{$kids}] /Count " . count($pageObjectIds) . ' >>');
    $this->setObject($catalogId, "<< /Type /Catalog /Pages {$pagesId} 0 R >>");

    return $this->renderPdf();
  }

  private function addObject($body)
  {
    $this->objects[] = (string) $body;
    return count($this->objects);
  }

  private function setObject($id, $body)
  {
    $this->objects[$id - 1] = (string) $body;
  }

  private function renderPdf()
  {
    $pdf = "%PDF-1.4\n";
    $offsets = [0];

    foreach ($this->objects as $index => $body) {
      $offsets[] = strlen($pdf);
      $objectId = $index + 1;
      $pdf .= "{$objectId} 0 obj\n{$body}\nendobj\n";
    }

    $xrefOffset = strlen($pdf);
    $count = count($this->objects) + 1;

    $pdf .= "xref\n0 {$count}\n";
    $pdf .= "0000000000 65535 f \n";

    for ($i = 1; $i < $count; $i++) {
      $pdf .= sprintf('%010d 00000 n ', $offsets[$i]) . "\n";
    }

    $pdf .= "trailer\n<< /Size {$count} /Root 1 0 R >>\n";
    $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

    return $pdf;
  }

  private function escapePdfText($text)
  {
    $text = (string) $text;
    $text = str_replace(["\r", "\n"], ' ', $text);
    $text = str_replace('\\', '\\\\', $text);
    $text = str_replace('(', '\(', $text);
    $text = str_replace(')', '\)', $text);
    return $text;
  }

  private function formatNumber($value)
  {
    return rtrim(rtrim(number_format((float) $value, 3, '.', ''), '0'), '.');
  }
}