<?php
/**
 * Penelitian Table Row Component
 *
 * @param string $name - Dosen name
 * @param string $id - Dosen NIDN
 * @param string $faculty - Faculty name
 * @param int $jumlah_jurnal - Number of journals
 * @param int $sinta_score_3yr - SINTA Score 3 Year
 * @param int $sinta_score - SINTA Score Overall
 * @param int $affil_score_3yr - Affiliation Score 3 Year
 * @param int $affil_score - Affiliation Score
 * @param int $scopus_h_index - Scopus H-Index
 * @param int $gs_h_index - Google Scholar H-Index
 * @param bool $isAlternate - Alternate row background
 * @param string $detailUrl - URL to detail page
 */
?>

<tr class="clickable-row <?php echo $isAlternate ? 'bg-light' : ''; ?>" data-href="<?php echo $detailUrl; ?>">
  <td>
    <div class="dosen-info">
      <span class="dosen-name"><?php echo htmlspecialchars($name); ?></span>
      <span class="dosen-meta">
        <i class="bi bi-person-badge-fill"></i>
        NIDN: <?php echo htmlspecialchars($id); ?>
      </span>
      <span class="dosen-meta">
        <i class="bi bi-building-fill"></i>
        <?php echo htmlspecialchars($faculty); ?>
      </span>
      <div class="dosen-badges">
        <span class="dosen-badge">
          <i class="bi bi-bookmark-star-fill"></i>
          Scopus H-Index: <strong><?php echo $scopus_h_index; ?></strong>
        </span>
        <span class="dosen-badge">
          <i class="bi bi-google"></i>
          GS H-Index: <strong><?php echo $gs_h_index; ?></strong>
        </span>
      </div>
    </div>
  </td>
  <td class="score-cell"><?php echo $jumlah_jurnal; ?></td>
  <td class="score-cell"><?php echo number_format($sinta_score_3yr, 2); ?></td>
  <td class="score-cell"><?php echo number_format($sinta_score, 2); ?></td>
  <td class="score-cell"><?php echo number_format($affil_score_3yr, 2); ?></td>
  <td class="score-cell"><?php echo number_format($affil_score, 2); ?></td>
</tr>