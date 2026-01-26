<?php
/**
 * Ranked List Item Component
 * 
 * @param int $rank - Ranking number
 * @param string $name - Dosen name
 * @param string $faculty - Faculty name
 * @param int $nidn - NIDN
 * @param int $publications - Number of publications
 * @param string $detail - Additional detail text
 * @param string $badge_class - Bootstrap badge class
 * @param string $badge_icon - Bootstrap icon class
 * @param bool $isAlternate - Alternate background color
 */
?>

<div class="list-group-item border-0 py-3 <?php echo $isAlternate ? 'bg-light' : ''; ?>">
  <div class="d-flex align-items-center">
    <div class="flex-shrink-0">
      <span class="badge <?php echo $badge_class; ?> rounded-circle"
        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
        <?php if (!empty($badge_icon)): ?>
          <i class="bi <?php echo $badge_icon; ?>"></i>
        <?php else: ?>
          <?php echo $rank; ?>
        <?php endif; ?>
      </span>
    </div>
    <div class="flex-shrink-0 ms-3">
      <img src="<?php echo BASE_URL; ?>logo_only.png" alt="Avatar" class="rounded-circle"
        style="width: 40px; height: 40px; object-fit: cover;">
    </div>
    <div class="ms-3 flex-grow-1">
      <p class="mb-0 fw-bold small"><?php echo $name; ?></p>
      <small class="text-muted"> <i class="bi bi-building-fill text-primary"></i> <?php echo $faculty; ?></small><br />
      <small class="text-muted"> <i class="bi bi-person-fill text-primary"></i> NIDN: <?php echo $nidn; ?></small><br />
      <small class="text-muted">Jumlah Publikasi Ter-Index: <?php echo $publications; ?></small>
    </div>
  </div>
</div>