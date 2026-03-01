<?php
/**
 * Admin - Edit Cleaner
 */
$page_title = 'Edit Cleaner | Admin';
$admin_page = 'cleaners';
require_once __DIR__ . '/inc_admin_head.php';

$db = get_db();
$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    header('Location: /admin/cleaners');
    exit;
}

// Fetch cleaner
$stmt = $db->prepare("SELECT c.*, u.email, u.first_name, u.last_name, u.phone AS user_phone, u.status AS user_status FROM cleaners c JOIN users u ON c.user_id = u.id WHERE c.id = ?");
$stmt->execute([$id]);
$cleaner = $stmt->fetch();

if (!$cleaner) {
    header('Location: /admin/cleaners');
    exit;
}

// Fetch related counts
$photo_count = $db->prepare("SELECT COUNT(*) FROM cleaner_photos WHERE cleaner_id = ?");
$photo_count->execute([$id]);
$photo_count = $photo_count->fetchColumn();

$review_count = $db->prepare("SELECT COUNT(*) FROM reviews WHERE cleaner_id = ?");
$review_count->execute([$id]);
$review_count = $review_count->fetchColumn();

// Fetch cleaner's categories
$cat_stmt = $db->prepare("SELECT cc.category_id, cat.name FROM cleaner_categories cc JOIN categories cat ON cc.category_id = cat.id WHERE cc.cleaner_id = ?");
$cat_stmt->execute([$id]);
$cleaner_categories = $cat_stmt->fetchAll();

// All categories for selection
$all_categories = $db->query("SELECT id, name FROM categories WHERE is_active = 1 ORDER BY name")->fetchAll();

// Handle POST
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $business_name = trim($_POST['business_name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;
    $license_number = trim($_POST['license_number'] ?? '');
    $years_experience = (int)($_POST['years_experience'] ?? 0);
    $is_insured = isset($_POST['is_insured']) ? 1 : 0;
    $is_bonded = isset($_POST['is_bonded']) ? 1 : 0;
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $plan = $_POST['plan'] ?? 'free';
    $status = $_POST['status'] ?? 'active';
    $service_radius = (int)($_POST['service_radius'] ?? 25);
    $selected_cats = $_POST['categories'] ?? [];

    if (!$business_name) $errors[] = 'Business name is required.';
    if (!$slug) $slug = slugify($business_name);

    // Check slug uniqueness
    $slug_check = $db->prepare("SELECT id FROM cleaners WHERE slug = ? AND id != ?");
    $slug_check->execute([$slug, $id]);
    if ($slug_check->fetch()) {
        $errors[] = 'This slug is already in use by another cleaner.';
    }

    // Handle logo upload
    $logo = $cleaner['logo'];
    if (!empty($_FILES['logo']['name'])) {
        $upload = handle_upload('logo', ['type' => 'cleaner_logo', 'cleaner_id' => $id]);
        if ($upload['success']) {
            $logo = $upload['url'];
        } else {
            $errors[] = 'Logo upload: ' . $upload['error'];
        }
    }

    // Handle cover image upload
    $cover_image = $cleaner['cover_image'];
    if (!empty($_FILES['cover_image']['name'])) {
        $upload = handle_upload('cover_image', ['type' => 'cleaner_cover', 'cleaner_id' => $id]);
        if ($upload['success']) {
            $cover_image = $upload['url'];
        } else {
            $errors[] = 'Cover upload: ' . $upload['error'];
        }
    }

    if (empty($errors)) {
        $stmt = $db->prepare("UPDATE cleaners SET
            business_name = ?, slug = ?, description = ?, phone = ?, website = ?,
            address = ?, city = ?, state = ?, zip = ?, latitude = ?, longitude = ?,
            license_number = ?, years_experience = ?, is_insured = ?, is_bonded = ?,
            is_verified = ?, is_featured = ?, plan = ?, status = ?,
            service_radius = ?, logo = ?, cover_image = ?, updated_at = NOW()
            WHERE id = ?");
        $stmt->execute([
            $business_name, $slug, $description, $phone, $website,
            $address, $city, $state, $zip, $latitude, $longitude,
            $license_number, $years_experience, $is_insured, $is_bonded,
            $is_verified, $is_featured, $plan, $status,
            $service_radius, $logo, $cover_image, $id
        ]);

        // Update categories
        $db->prepare("DELETE FROM cleaner_categories WHERE cleaner_id = ?")->execute([$id]);
        if (!empty($selected_cats)) {
            $cat_insert = $db->prepare("INSERT INTO cleaner_categories (cleaner_id, category_id) VALUES (?, ?)");
            foreach ($selected_cats as $cat_id) {
                $cat_insert->execute([$id, (int)$cat_id]);
            }
        }

        log_activity('edit_cleaner', 'cleaner', $id, "Edited: $business_name");
        $success = 'Cleaner updated successfully.';

        // Refresh data
        $stmt = $db->prepare("SELECT c.*, u.email, u.first_name, u.last_name, u.phone AS user_phone, u.status AS user_status FROM cleaners c JOIN users u ON c.user_id = u.id WHERE c.id = ?");
        $stmt->execute([$id]);
        $cleaner = $stmt->fetch();

        $cat_stmt->execute([$id]);
        $cleaner_categories = $cat_stmt->fetchAll();
    }
}

$cat_ids = array_column($cleaner_categories, 'category_id');
?>

<div class="container-fluid py-4">
    <?php echo render_breadcrumbs([['name' => 'Cleaners', 'url' => '/admin/cleaners'], ['name' => 'Edit: ' . $cleaner['business_name']]]); ?>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo e($success); ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0"><?php foreach ($errors as $err): ?><li><?php echo e($err); ?></li><?php endforeach; ?></ul><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <form method="POST" enctype="multipart/form-data" id="mainForm">
                <?php echo csrf_field(); ?>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Business Information</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label>Business Name *</label>
                                <input type="text" name="business_name" class="form-control" value="<?php echo e($cleaner['business_name']); ?>" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" value="<?php echo e($cleaner['slug']); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="5"><?php echo e($cleaner['description']); ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo e($cleaner['phone']); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Website</label>
                                <input type="url" name="website" class="form-control" value="<?php echo e($cleaner['website']); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Location</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo e($cleaner['address']); ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="<?php echo e($cleaner['city']); ?>">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>State</label>
                                <input type="text" name="state" class="form-control" value="<?php echo e($cleaner['state']); ?>" maxlength="2">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>ZIP</label>
                                <input type="text" name="zip" class="form-control" value="<?php echo e($cleaner['zip']); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control" value="<?php echo e($cleaner['latitude']); ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control" value="<?php echo e($cleaner['longitude']); ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Service Radius (mi)</label>
                                <input type="number" name="service_radius" class="form-control" value="<?php echo e($cleaner['service_radius']); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Credentials</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>License Number</label>
                                <input type="text" name="license_number" class="form-control" value="<?php echo e($cleaner['license_number']); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Years of Experience</label>
                                <input type="number" name="years_experience" class="form-control" value="<?php echo e($cleaner['years_experience']); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_insured" name="is_insured" <?php echo $cleaner['is_insured'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="is_insured">Insured</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_bonded" name="is_bonded" <?php echo $cleaner['is_bonded'] ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="is_bonded">Bonded</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Categories</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($all_categories as $cat): ?>
                            <div class="col-md-4 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cat_<?php echo $cat['id']; ?>" name="categories[]" value="<?php echo $cat['id']; ?>" <?php echo in_array($cat['id'], $cat_ids) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="cat_<?php echo $cat['id']; ?>"><?php echo e($cat['name']); ?></label>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Images</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Logo</label>
                                <?php if ($cleaner['logo']): ?>
                                <div class="mb-2"><img src="<?php echo e($cleaner['logo']); ?>" alt="Logo" class="img-thumbnail" style="max-height:80px;"></div>
                                <?php endif; ?>
                                <input type="file" name="logo" class="form-control-file" accept="image/*">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Cover Image</label>
                                <?php if ($cleaner['cover_image']): ?>
                                <div class="mb-2"><img src="<?php echo e($cleaner['cover_image']); ?>" alt="Cover" class="img-thumbnail" style="max-height:80px;"></div>
                                <?php endif; ?>
                                <input type="file" name="cover_image" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg mb-4"><i class="ti-save mr-1"></i> Save Changes</button>
                <a href="/admin/cleaners" class="btn btn-outline-secondary btn-lg mb-4">Cancel</a>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Status & Plan</h6></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" form="mainForm">
                            <option value="active" <?php echo $cleaner['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="pending" <?php echo $cleaner['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="suspended" <?php echo $cleaner['status'] === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Plan</label>
                        <select name="plan" class="form-control" form="mainForm">
                            <option value="free" <?php echo $cleaner['plan'] === 'free' ? 'selected' : ''; ?>>Free</option>
                            <option value="basic" <?php echo $cleaner['plan'] === 'basic' ? 'selected' : ''; ?>>Basic</option>
                            <option value="pro" <?php echo $cleaner['plan'] === 'pro' ? 'selected' : ''; ?>>Pro</option>
                            <option value="premium" <?php echo $cleaner['plan'] === 'premium' ? 'selected' : ''; ?>>Premium</option>
                        </select>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="is_verified" name="is_verified" form="mainForm" <?php echo $cleaner['is_verified'] ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="is_verified">Verified</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" form="mainForm" <?php echo $cleaner['is_featured'] ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="is_featured">Featured</label>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Account Info</h6></div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td class="text-muted">Email</td><td><?php echo e($cleaner['email']); ?></td></tr>
                        <tr><td class="text-muted">User ID</td><td><?php echo $cleaner['user_id']; ?></td></tr>
                        <tr><td class="text-muted">Rating</td><td><?php echo format_rating($cleaner['avg_rating']); ?></td></tr>
                        <tr><td class="text-muted">Reviews</td><td><?php echo number_format($review_count); ?></td></tr>
                        <tr><td class="text-muted">Photos</td><td><?php echo number_format($photo_count); ?></td></tr>
                        <tr><td class="text-muted">Views</td><td><?php echo number_format($cleaner['profile_views']); ?></td></tr>
                        <tr><td class="text-muted">Leads</td><td><?php echo number_format($cleaner['leads_received']); ?></td></tr>
                        <tr><td class="text-muted">Joined</td><td><?php echo date('M j, Y', strtotime($cleaner['created_at'])); ?></td></tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <a href="/cleaner/<?php echo e($cleaner['slug']); ?>" target="_blank" class="btn btn-outline-primary btn-block"><i class="ti-eye mr-1"></i> View Public Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/admin.js"></script>
</body>
</html>
