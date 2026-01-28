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

<tr class="<?php echo $isAlternate ? 'bg-light' : ''; ?> clickable-row" data-href="<?php echo $detailUrl; ?>"
  style=" cursor: pointer;">
  <td class="py-3 px-4">
    <div class="d-flex flex-column">
      <span class="fw-bold"><?php echo htmlspecialchars($name); ?></span>
      <small class="text-muted">
        <i class="bi bi-person-fill text-primary"></i>
        NIDN: <?php echo htmlspecialchars($id); ?>
      </small>
      <small class="text-muted">
        <i class="bi bi-building-fill text-primary"></i>
        <?php echo htmlspecialchars($faculty); ?>
      </small>
      <div class="d-flex gap-3 mt-1">
        <small class="text-muted">
          <i class="bi bi-bookmark-star text-primary"></i>
          Scopus H-Index: <strong><?php echo $scopus_h_index; ?></strong>
        </small>
        <small class="text-muted">
          <i class="bi bi-google text-primary"></i>
          GS H-Index: <strong><?php echo $gs_h_index; ?></strong>
        </small>
      </div>
    </div>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo $jumlah_jurnal; ?></span>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo number_format($sinta_score_3yr, 2); ?></span>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo number_format($sinta_score, 2); ?></span>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo number_format($affil_score_3yr, 2); ?></span>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo number_format($affil_score, 2); ?></span>
  </td>
</tr>