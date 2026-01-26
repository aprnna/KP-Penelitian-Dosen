<?php
/**
 * Penelitian Table Row Component
 * 
 * @param string $name - Dosen name
 * @param string $id - Dosen ID
 * @param string $faculty - Faculty name
 * @param int $jumlah_jurnal - Number of journals
 * @param int $skor_relevansi - Relevance score
 * @param int $h_index - H-index score
 * @param int $i10_index - i10-index score
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
    </div>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo $jumlah_jurnal; ?></span>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo $skor_relevansi; ?></span>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo $h_index; ?></span>
  </td>
  <td class="py-3 px-4 text-center align-middle">
    <span class="fw-bold fs-5"><?php echo $i10_index; ?></span>
  </td>
</tr>