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

<?php
// Determine if this item should be faded (rank > 3)
$isFaded = $rank > 3;
$opacityStyle = $isFaded ? 'opacity: 0.5;' : '';
$badgeBgClass = $isFaded ? 'bg-secondary' : 'bg-primary';
?>

<div class="list-group-item border-0 py-3 <?php echo $isAlternate ? 'bg-light' : ''; ?>"
  style="<?php echo $opacityStyle; ?>">
  <div class="d-flex align-items-center">
    <!-- Rank Badge - Prominent on Left -->
    <div class="flex-shrink-0">
      <span class="badge <?php echo $badgeBgClass; ?> rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center;
        justify-content: center; font-weight: bold; font-size: 1rem;">
        <?php echo $rank; ?>
      </span>
    </div>

    <!-- Avatar -->
    <div class="flex-shrink-0 ms-3">
      <img src="<?php echo BASE_URL; ?>logo_only.png" alt="Avatar" class="rounded-circle"
        style="width: 40px; height: 40px; object-fit: cover;">
    </div>

    <!-- Content -->
    <div class="ms-3 flex-grow-1">
      <div>
        <p class="mb-0 fw-bold small">
          <?php echo $name; ?>
        </p>
        <small class="text-muted"> <i class="bi bi-building-fill text-primary"></i>
          <?php echo $faculty; ?>
        </small><br />
        <small class="text-muted"> <i class="bi bi-person-fill text-primary"></i> NIDN:
          <?php echo $nidn; ?>
        </small><br />
        <small class="text-muted">Jumlah Publikasi Ter-Index:
          <?php echo $publications; ?>
        </small>
      </div>
    </div>

    <!-- Status Badge - Right Side -->
    <div class="flex-shrink-0">
      <?php if (!empty($badge_icon)): ?>
        <img src="<?php echo BASE_URL; ?><?php echo $badge_icon; ?>" alt=" Badge" class="rounded-circle"
          style="width: 40px; height: 40px; object-fit: cover;">
      <?php endif; ?>

    </div>
  </div>
</div>