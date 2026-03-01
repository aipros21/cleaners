<?php
/**
 * Privacy Policy - FindMyCleaner
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';

$page_title = 'Privacy Policy | FindMyCleaner';
$page_description = 'Read the FindMyCleaner privacy policy. Learn how we collect, use, and protect your personal information.';
$page_canonical = '/privacy-policy';
$active_page = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<section class="page-header py-4">
    <div class="container">
        <h1 class="h3 mb-1">Privacy Policy</h1>
        <p class="mb-0 small opacity-75">Last updated: January 1, 2025</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="legal-content">

                    <h2 class="h5 mt-4">1. Introduction</h2>
                    <p>FindMyCleaner ("we," "our," or "us") operates the website cleaners-247.com (the "Site"). This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, create an account, or use our services.</p>
                    <p>By using the Site, you agree to the collection and use of information in accordance with this policy. If you do not agree with the terms of this Privacy Policy, please do not access the Site.</p>

                    <h2 class="h5 mt-4">2. Information We Collect</h2>
                    <h6>Personal Information</h6>
                    <p>We may collect personally identifiable information that you voluntarily provide when you:</p>
                    <ul>
                        <li>Register for an account (name, email address, phone number, password)</li>
                        <li>Create a cleaning business profile (business name, address, insurance information, service categories, photos)</li>
                        <li>Submit a quote request or contact form (name, email, project details)</li>
                        <li>Leave a review (name, rating, review content)</li>
                        <li>Subscribe to our newsletter (email address)</li>
                        <li>Make a payment (billing information processed securely via Stripe)</li>
                    </ul>

                    <h6>Automatically Collected Information</h6>
                    <p>When you visit the Site, we may automatically collect certain information, including:</p>
                    <ul>
                        <li>IP address and geolocation data</li>
                        <li>Browser type and version</li>
                        <li>Operating system</li>
                        <li>Referring website URLs</li>
                        <li>Pages viewed and time spent on pages</li>
                        <li>Device identifiers</li>
                        <li>Cookies and similar tracking technologies</li>
                    </ul>

                    <h2 class="h5 mt-4">3. How We Use Your Information</h2>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Provide, operate, and maintain the Site and our services</li>
                        <li>Create and manage your account</li>
                        <li>Match homeowners with cleaning service providers based on location and service needs</li>
                        <li>Process transactions and send related information (confirmations, invoices)</li>
                        <li>Send promotional communications (with your consent, which you can withdraw at any time)</li>
                        <li>Respond to your comments, questions, and support requests</li>
                        <li>Monitor and analyze usage trends to improve the Site</li>
                        <li>Detect, prevent, and address fraud and technical issues</li>
                        <li>Comply with legal obligations</li>
                    </ul>

                    <h2 class="h5 mt-4">4. Sharing Your Information</h2>
                    <p>We may share your information in the following situations:</p>
                    <ul>
                        <li><strong>Between Users:</strong> When a homeowner requests a quote, their project information is shared with matched cleaning businesses. Cleaning business profile information is publicly visible on the Site.</li>
                        <li><strong>Service Providers:</strong> We may share information with third-party vendors who perform services on our behalf (e.g., payment processing, email delivery, analytics).</li>
                        <li><strong>Legal Requirements:</strong> We may disclose information if required by law, regulation, or legal process.</li>
                        <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets, your information may be transferred.</li>
                        <li><strong>With Your Consent:</strong> We may share information for any other purpose with your consent.</li>
                    </ul>
                    <p>We do not sell your personal information to third parties.</p>

                    <h2 class="h5 mt-4">5. Cookies and Tracking Technologies</h2>
                    <p>We use cookies and similar tracking technologies to track activity on the Site and hold certain information. Cookies are small data files stored on your device. You can instruct your browser to refuse all cookies or indicate when a cookie is being sent. However, some parts of the Site may not function properly without cookies.</p>
                    <p>We use the following types of cookies:</p>
                    <ul>
                        <li><strong>Essential Cookies:</strong> Required for the Site to function (e.g., session management, authentication)</li>
                        <li><strong>Analytics Cookies:</strong> Help us understand how visitors interact with the Site (e.g., Google Analytics)</li>
                        <li><strong>Functionality Cookies:</strong> Remember your preferences (e.g., location, language)</li>
                    </ul>

                    <h2 class="h5 mt-4">6. Data Security</h2>
                    <p>We implement industry-standard security measures to protect your personal information, including:</p>
                    <ul>
                        <li>SSL/TLS encryption for data transmission</li>
                        <li>Encrypted password storage using bcrypt hashing</li>
                        <li>Regular security audits and vulnerability assessments</li>
                        <li>Access controls limiting employee access to personal data</li>
                        <li>PCI-compliant payment processing through Stripe</li>
                    </ul>
                    <p>While we strive to protect your information, no method of transmission over the Internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>

                    <h2 class="h5 mt-4">7. Data Retention</h2>
                    <p>We retain your personal information for as long as your account is active or as needed to provide you services. We will retain and use your information as necessary to comply with legal obligations, resolve disputes, and enforce our agreements. You may request deletion of your account and data at any time by contacting us.</p>

                    <h2 class="h5 mt-4">8. Your Rights</h2>
                    <p>Depending on your location, you may have the following rights regarding your personal information:</p>
                    <ul>
                        <li><strong>Access:</strong> Request a copy of the personal information we hold about you</li>
                        <li><strong>Correction:</strong> Request correction of inaccurate or incomplete data</li>
                        <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                        <li><strong>Portability:</strong> Request a machine-readable copy of your data</li>
                        <li><strong>Opt-Out:</strong> Unsubscribe from marketing communications at any time</li>
                        <li><strong>Restriction:</strong> Request that we limit the processing of your data</li>
                    </ul>
                    <p>To exercise any of these rights, please contact us at <a href="mailto:info@cleaners-247.com">info@cleaners-247.com</a>.</p>

                    <h2 class="h5 mt-4">9. California Privacy Rights (CCPA)</h2>
                    <p>If you are a California resident, you have additional rights under the California Consumer Privacy Act (CCPA), including the right to know what personal information we collect, the right to delete your information, and the right to opt out of the sale of personal information. As stated above, we do not sell personal information.</p>

                    <h2 class="h5 mt-4">10. Children's Privacy</h2>
                    <p>The Site is not intended for children under the age of 18. We do not knowingly collect personal information from children under 18. If we become aware that we have collected personal information from a child under 18, we will take steps to delete that information.</p>

                    <h2 class="h5 mt-4">11. Third-Party Links</h2>
                    <p>The Site may contain links to third-party websites. We are not responsible for the privacy practices or content of those sites. We encourage you to read the privacy policies of any third-party sites you visit.</p>

                    <h2 class="h5 mt-4">12. Changes to This Privacy Policy</h2>
                    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. You are advised to review this Privacy Policy periodically for any changes.</p>

                    <h2 class="h5 mt-4">13. Contact Us</h2>
                    <p>If you have any questions about this Privacy Policy, please contact us:</p>
                    <ul>
                        <li>Email: <a href="mailto:info@cleaners-247.com">info@cleaners-247.com</a></li>
                        <li>Phone: 1-800-FIND-PRO</li>
                        <li>Mail: FindMyCleaner, Miami, FL 33101</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
