<?php
/**
 * Cleaner Dashboard - Edit Profile
 */
$dash_page = 'profile';
$page_title = 'Edit Profile | FindMyCleaner';
require_once __DIR__ . '/inc_dashboard_head.php';

$db = get_db();
$cid = $_cleaner['id'];

$success = '';
$error = '';

// Process POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && verify_csrf($_POST['csrf_token'] ?? '')) {
    $business_name   = trim($_POST['business_name'] ?? '');
    $tagline         = trim($_POST['tagline'] ?? '');
    $description     = trim($_POST['description'] ?? '');
    $phone           = trim($_POST['phone'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $website         = trim($_POST['website'] ?? '');
    $address         = trim($_POST['address'] ?? '');
    $city            = trim($_POST['city'] ?? '');
    $state_id        = intval($_POST['state_id'] ?? 0);
    $zip_code        = trim($_POST['zip_code'] ?? '');
    $license_number  = trim($_POST['license_number'] ?? '');
    $years_experience = intval($_POST['years_experience'] ?? 0);
    $employees_count = trim($_POST['employees_count'] ?? '');

    // Validate
    if (empty($business_name)) {
        $error = 'Business name is required.';
    } elseif (empty($phone)) {
        $error = 'Phone number is required.';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'A valid email address is required.';
    } else {
        // Handle logo upload
        $logo_url = $_cleaner['logo'];
        if (!empty($_FILES['logo']['name']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $upload = handle_upload('logo', ['cleaner_id' => $cid, 'type' => 'logo']);
            if ($upload['success']) {
                $logo_url = $upload['url'];
            } else {
                $error = 'Logo upload failed: ' . $upload['error'];
            }
        }

        // Handle cover image upload
        $cover_url = $_cleaner['cover_image'];
        if (!$error && !empty($_FILES['cover_image']['name']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $upload = handle_upload('cover_image', ['cleaner_id' => $cid, 'type' => 'cover']);
            if ($upload['success']) {
                $cover_url = $upload['url'];
            } else {
                $error = 'Cover image upload failed: ' . $upload['error'];
            }
        }

        if (!$error) {
            $stmt = $db->prepare("UPDATE cleaners SET
                business_name = ?, tagline = ?, description = ?, phone = ?, email = ?,
                website = ?, address = ?, state_id = ?, zip_code = ?,
                license_number = ?, years_experience = ?, employees_count = ?,
                logo = ?, cover_image = ?, updated_at = NOW()
                WHERE id = ?");
            $stmt->execute([
                $business_name, $tagline, $description, $phone, $email,
                $website, $address, $state_id ?: null, $zip_code,
                $license_number, $years_experience ?: null, $employees_count,
                $logo_url, $cover_url, $cid
            ]);

            // Refresh cleaner data
            $stmt = $db->prepare("SELECT * FROM cleaners WHERE id = ?");
            $stmt->execute([$cid]);
            $_cleaner = $stmt->fetch();

            $success = 'Profile updated successfully!';
            log_activity('profile_update', 'cleaner', $cid);
        }
    }
}

// Get states for dropdown
$states = $db->query("SELECT id, name, code FROM states ORDER BY name")->fetchAll();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Profile</h4>
        <a href="/cleaner/<?php echo e($_cleaner['slug']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="ti-eye mr-1"></i> View Public Profile
        </a>
    </div>

    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="ti-check mr-1"></i> <?php echo e($success); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="ti-alert mr-1"></i> <?php echo e($error); ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="row">
            <!-- Business Info -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Business Information</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="business_name">Business Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="business_name" name="business_name" value="<?php echo e($_cleaner['business_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tagline">Tagline</label>
                            <input type="text" class="form-control" id="tagline" name="tagline" value="<?php echo e($_cleaner['tagline']); ?>" maxlength="300" placeholder="A short slogan for your business">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Describe your business, services, and what sets you apart..."><?php echo e($_cleaner['description']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Contact Information</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo e($_cleaner['phone']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo e($_cleaner['email']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" class="form-control" id="website" name="website" value="<?php echo e($_cleaner['website']); ?>" placeholder="https://www.example.com">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Location</h6></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="address">Street Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo e($_cleaner['address']); ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="<?php echo e($_cleaner['city'] ?? ''); ?>" placeholder="City name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state_id">State</label>
                                    <select class="form-control" id="state_id" name="state_id">
                                        <option value="">-- Select State --</option>
                                        <?php foreach ($states as $state): ?>
                                        <option value="<?php echo $state['id']; ?>" <?php echo ($_cleaner['state_id'] == $state['id']) ? 'selected' : ''; ?>>
                                            <?php echo e($state['name']); ?> (<?php echo e($state['code']); ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zip_code">ZIP Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo e($_cleaner['zip_code']); ?>" maxlength="10">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Credentials &amp; Experience</h6></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="license_number">License Number</label>
                                    <input type="text" class="form-control" id="license_number" name="license_number" value="<?php echo e($_cleaner['license_number']); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="years_experience">Years of Experience</label>
                                    <input type="number" class="form-control" id="years_experience" name="years_experience" value="<?php echo e($_cleaner['years_experience']); ?>" min="0" max="100">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employees_count">Number of Employees</label>
                                    <select class="form-control" id="employees_count" name="employees_count">
                                        <option value="">-- Select --</option>
                                        <?php
                                        $emp_options = ['1-5', '6-10', '11-25', '26-50', '50+'];
                                        foreach ($emp_options as $opt):
                                        ?>
                                        <option value="<?php echo $opt; ?>" <?php echo ($_cleaner['employees_count'] === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar: Images -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Logo</h6></div>
                    <div class="card-body text-center">
                        <img src="<?php echo e($_cleaner['logo'] ?: '/images/default-logo.png'); ?>" alt="Logo" class="img-fluid rounded mb-3" style="max-height:150px;">
                        <div class="form-group">
                            <label for="logo" class="btn btn-outline-primary btn-sm btn-block">
                                <i class="ti-upload mr-1"></i> Upload New Logo
                            </label>
                            <input type="file" class="d-none" id="logo" name="logo" accept="image/*">
                        </div>
                        <small class="text-muted">JPG, PNG, GIF, or WebP. Max 10MB.</small>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Cover Image</h6></div>
                    <div class="card-body text-center">
                        <?php if ($_cleaner['cover_image']): ?>
                        <img src="<?php echo e($_cleaner['cover_image']); ?>" alt="Cover" class="img-fluid rounded mb-3" style="max-height:150px;">
                        <?php else: ?>
                        <div class="bg-light rounded p-4 mb-3 text-muted">
                            <i class="ti-image display-4"></i>
                            <p class="small mt-2 mb-0">No cover image set</p>
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="cover_image" class="btn btn-outline-primary btn-sm btn-block">
                                <i class="ti-upload mr-1"></i> Upload Cover Image
                            </label>
                            <input type="file" class="d-none" id="cover_image" name="cover_image" accept="image/*">
                        </div>
                        <small class="text-muted">Recommended: 1200x400 pixels</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <i class="ti-save mr-1"></i> Save Profile
                </button>
            </div>
        </div>
    </form>
</div>

    </div><!-- /.dashboard-content -->
</div><!-- /.dashboard-wrapper -->

<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/js/dashboard.js"></script>
</body>
</html>
