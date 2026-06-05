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
$isFaded = $rank > 3;
$opacityStyle = $isFaded ? 'opacity: 0.6;' : '';
?>

<div class="ranked-item <?php echo $isAlternate ? 'ranked-item-alt' : ''; ?>" style="<?php echo $opacityStyle; ?>">
  <div class="ranked-content">
    <!-- Rank Number -->
    <div class="ranked-badge <?php echo $rank <= 3 ? 'ranked-badge-top' : 'ranked-badge-normal'; ?>">
      <?php echo $rank; ?>
    </div>

    <!-- Avatar -->
    <div class="ranked-avatar">
      <img src="<?php echo BASE_URL; ?>logo_only.png" alt="Avatar">
    </div>

    <!-- Info -->
    <div class="ranked-info">
      <div class="ranked-name"><?php echo htmlspecialchars($name); ?></div>
      <div class="ranked-meta">
        <span><i class="bi bi-building-fill"></i> <?php echo htmlspecialchars($faculty); ?></span>
        <span><i class="bi bi-person-fill"></i> NIDN: <?php echo htmlspecialchars($nidn); ?></span>
      </div>
      <div class="ranked-count">
        <i class="bi bi-journal-text"></i> <?php echo $publications; ?> publikasi terindeks
      </div>
    </div>

    <!-- Badge -->
    <?php if (!empty($badge_icon)): ?>
    <div class="ranked-icon">
      <img src="<?php echo BASE_URL; ?><?php echo $badge_icon; ?>" alt="Badge">
    </div>
    <?php endif; ?>
  </div>
</div>

<style>
  .ranked-item {
    padding: 0.875rem 1rem;
    border-bottom: 1px solid var(--dash-border, #e2e8f0);
    transition: background-color 0.15s ease;
  }

  .ranked-item:last-child {
    border-bottom: none;
  }

  .ranked-item:hover {
    background: #f8fafc;
  }

  .ranked-item-alt {
    background: #fafbfc;
  }

  .ranked-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .ranked-badge {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    flex-shrink: 0;
  }

  .ranked-badge-top {
    background: var(--dash-primary, #0066cc);
    color: #ffffff;
  }

  .ranked-badge-normal {
    background: #f1f5f9;
    color: #64748b;
  }

  .ranked-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    background: #f1f5f9;
  }

  .ranked-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .ranked-info {
    flex: 1;
    min-width: 0;
  }

  .ranked-name {
    font-weight: 600;
    font-size: 0.9375rem;
    color: #1e293b;
    margin-bottom: 0.125rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .ranked-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 0.125rem;
  }

  .ranked-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .ranked-meta i {
    color: var(--dash-primary, #0066cc);
    font-size: 0.6875rem;
  }

  .ranked-count {
    font-size: 0.75rem;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .ranked-count i {
    color: var(--dash-primary, #0066cc);
  }

  .ranked-icon {
    width: 36px;
    height: 36px;
    flex-shrink: 0;
  }

  .ranked-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 50%;
  }

  @media (max-width: 575.98px) {
    .ranked-meta {
      flex-direction: column;
      gap: 0.125rem;
    }
  }
</style>