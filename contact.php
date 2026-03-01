<?php
/**
 * Contact Page - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_recaptcha.php';
require_once 'includes/inc_schema.php';

$load_recaptcha = true;
$page_title = 'Contact Us | FindMyCleaner';
$page_description = 'Get in touch with the FindMyCleaner team. We are here to help homeowners and cleaning professionals with any questions.';
$page_canonical = '/contact';
$active_page = 'contact';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-4">
    <div class="container">
        <h1 class="h3 mb-1">Contact Us</h1>
        <p class="mb-0 small opacity-75">Have a question? We'd love to hear from you.</p>
    </div>
</section>

<!-- Contact Hero Image -->
<div class="container mt-n3 mb-4" style="position:relative;z-index:1;">
    <img src="/images/contact-support.webp" alt="Friendly customer support team ready to help homeowners and cleaning professionals" width="1200" height="500" class="img-fluid rounded shadow w-100" style="max-height:450px;object-fit:cover;object-position:top;" loading="eager">
</div>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="h5 mb-4">Send Us a Message</h3>

                        <form action="/api/handle_contact.php" method="POST" data-ajax data-reset="true" data-recaptcha-action="contact">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="contact">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="John Doe" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject <span class="text-danger">*</span></label>
                                <select name="subject" id="subject" class="form-control" required>
                                    <option value="">Select a subject...</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Homeowner Support">Homeowner Support</option>
                                    <option value="Cleaner Support">Cleaner Support</option>
                                    <option value="Billing & Payments">Billing & Payments</option>
                                    <option value="Report an Issue">Report an Issue</option>
                                    <option value="Partnership">Partnership Opportunities</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" class="form-control" rows="6" placeholder="Tell us how we can help..." required></textarea>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" id="recaptchaContact">

                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="ti-email mr-1"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Contact Information</h5>

                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <i class="ti-email text-primary" style="font-size:1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <a href="mailto:info@cleaners-247.com" class="text-muted">info@cleaners-247.com</a>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <i class="ti-headphone-alt text-primary" style="font-size:1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Phone</h6>
                                <a href="tel:+18003463776" class="text-muted">1-800-FIND-PRO</a>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <i class="ti-time text-primary" style="font-size:1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Business Hours</h6>
                                <p class="text-muted mb-0 small">Monday - Friday: 8am - 6pm EST<br>Saturday: 9am - 2pm EST<br>Sunday: Closed</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="mr-3">
                                <i class="ti-location-pin text-primary" style="font-size:1.5rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Location</h6>
                                <p class="text-muted mb-0 small">Miami, FL 33101<br>United States</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar-cta">
                    <h5 class="mb-3">Own a Cleaning Business?</h5>
                    <p class="small">Join our network and start receiving cleaning leads from homeowners in your area.</p>
                    <a href="/join" class="btn btn-primary btn-block">List Your Business Free</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
echo schema_organization();
echo schema_breadcrumb([
    ['name' => 'Home', 'url' => 'https://cleaners-247.com/'],
    ['name' => 'Contact Us', 'url' => 'https://cleaners-247.com/contact']
]);
?>

<?php include 'includes/inc_footer.php'; ?>
