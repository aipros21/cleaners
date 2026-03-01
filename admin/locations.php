<?php
/**
 * Admin - Manage Locations (States & Cities)
 */
$page_title = 'Manage Locations | Admin';
$admin_page = 'locations';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();

// Fetch states with cleaner and city counts
$states = $db->query("
    SELECT s.*,
        (SELECT COUNT(*) FROM cities WHERE state_id = s.id) AS city_count,
        (SELECT COUNT(*) FROM cleaners WHERE state_id = s.id AND status = 'active') AS cleaner_count
    FROM states s
    ORDER BY s.name ASC
")->fetchAll();

// Pre-fetch all cities grouped by state_id for efficiency (avoids N+1 queries)
$all_cities = $db->query("
    SELECT ci.*, s.code AS state_code,
        (SELECT COUNT(*) FROM cleaners c WHERE c.city_id = ci.id AND c.status = 'active') AS cleaner_count
    FROM cities ci
    JOIN states s ON ci.state_id = s.id
    ORDER BY ci.population DESC, ci.name ASC
")->fetchAll();

$cities_by_state = [];
foreach ($all_cities as $city) {
    $cities_by_state[$city['state_id']][] = $city;
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Locations <small class="text-muted">(<?php echo count($states); ?> states)</small></h4>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:40px;"></th>
                            <th>State</th>
                            <th>Code</th>
                            <th>Cities</th>
                            <th>Cleaners</th>
                            <th>Coordinates</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($states)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No locations found.</td></tr>
                        <?php else: ?>
                        <?php foreach ($states as $st): ?>
                        <tr class="state-row" data-state-id="<?php echo $st['id']; ?>" style="cursor:pointer;">
                            <td class="text-center">
                                <i class="ti-angle-right toggle-icon" id="icon-<?php echo $st['id']; ?>"></i>
                            </td>
                            <td><strong><?php echo e($st['name']); ?></strong></td>
                            <td><span class="badge badge-light"><?php echo e($st['code']); ?></span></td>
                            <td><span class="badge badge-info"><?php echo number_format($st['city_count']); ?></span></td>
                            <td><span class="badge badge-secondary"><?php echo number_format($st['cleaner_count']); ?></span></td>
                            <td><small class="text-muted"><?php echo e($st['lat']); ?>, <?php echo e($st['lng']); ?></small></td>
                        </tr>
                        <!-- Expandable city rows -->
                        <?php $state_cities = $cities_by_state[$st['id']] ?? []; ?>
                        <?php if (!empty($state_cities)): ?>
                        <?php foreach ($state_cities as $city): ?>
                        <tr class="city-row city-group-<?php echo $st['id']; ?>" style="display:none; background-color:#f8f9fa;">
                            <td></td>
                            <td class="pl-4">
                                <i class="ti-location-pin text-muted mr-1"></i>
                                <?php echo e($city['name']); ?>
                            </td>
                            <td><small class="text-muted"><?php echo e($city['slug']); ?></small></td>
                            <td><small>Pop: <?php echo number_format($city['population'] ?? 0); ?></small></td>
                            <td><span class="badge badge-light"><?php echo number_format($city['cleaner_count']); ?></span></td>
                            <td><small class="text-muted"><?php echo e($city['lat']); ?>, <?php echo e($city['lng']); ?></small></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr class="city-row city-group-<?php echo $st['id']; ?>" style="display:none; background-color:#f8f9fa;">
                            <td></td>
                            <td colspan="5" class="text-muted pl-4"><em>No cities added for this state.</em></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('.state-row').on('click', function() {
        var stateId = $(this).data('state-id');
        var icon = $('#icon-' + stateId);

        $('.city-group-' + stateId).toggle();

        if (icon.hasClass('ti-angle-right')) {
            icon.removeClass('ti-angle-right').addClass('ti-angle-down');
        } else {
            icon.removeClass('ti-angle-down').addClass('ti-angle-right');
        }
    });
});
</script>
<script src="/js/admin.js"></script>
</body>
</html>
