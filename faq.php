<?php
/**
 * FAQ Page - FindMyCleaner
 * URL: /faq
 */
require_once 'includes/inc_db.php';
require_once 'includes/inc_helpers.php';
require_once 'includes/inc_schema.php';

$page_title = 'Frequently Asked Questions | FindMyCleaner';
$page_description = 'Get answers to common questions about finding cleaning services, getting quotes, pricing, insurance, and how FindMyCleaner connects you with trusted local cleaners.';
$page_keywords = 'cleaning service FAQ, how to find a cleaner, cleaning costs, insured cleaner, house cleaning questions, commercial cleaning, eco-friendly cleaning';
$page_canonical = '/faq';
$active_page = 'faq';

$breadcrumbs = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'FAQ', 'url' => '']
];

// FAQ content grouped by section
$faq_sections = [
    'Finding a Cleaner' => [
        ['question' => 'How do I find a reliable cleaner near me?', 'answer' => 'Browse our directory by cleaning category and location to find trusted professionals in your area. We list cleaners across 20 specialties, from House Cleaning and Commercial Cleaning to Carpet Cleaning and Pressure Washing. Look for cleaners with high ratings, verified badges, and detailed reviews. We recommend comparing at least 3 profiles before making your choice.'],
        ['question' => 'What cleaning categories are available on FindMyCleaner?', 'answer' => 'We cover 20 cleaning categories: House Cleaning, Commercial Cleaning, Carpet Cleaning, Pressure Washing, Window Cleaning, Move-In/Move-Out Cleaning, Deep Cleaning, Office Cleaning, Post-Construction Cleanup, Pool Cleaning, Janitorial Services, Upholstery Cleaning, Air Duct Cleaning, Tile & Grout Cleaning, Hoarding Cleanup, Green/Eco Cleaning, Vacation Rental Cleaning, Restaurant Cleaning, Medical Facility Cleaning, and Garage & Warehouse Cleaning.'],
        ['question' => 'What should I look for when hiring a cleaning service?', 'answer' => 'Key factors to consider include: proper business insurance and bonding, positive reviews from verified clients, clear pricing with no hidden fees, background-checked staff, a satisfaction guarantee or re-clean policy, and professional communication. Ask whether they bring their own supplies and equipment, and confirm their availability matches your schedule.'],
        ['question' => 'What is the difference between residential and commercial cleaning?', 'answer' => 'Residential cleaning focuses on private homes and apartments, covering tasks like dusting, vacuuming, mopping, kitchen and bathroom sanitation, and laundry areas. Commercial cleaning serves businesses, offices, retail spaces, and industrial facilities, often requiring specialized equipment, after-hours scheduling, and compliance with health and safety regulations. Commercial cleaners typically handle larger spaces and may offer janitorial contracts.'],
        ['question' => 'What questions should I ask a cleaner before hiring them?', 'answer' => 'Ask about their experience with your specific type of cleaning, what products and equipment they use, whether staff are background-checked, their cancellation and rescheduling policy, if they carry liability insurance and bonding, whether they offer a satisfaction guarantee, and how they handle access to your property. Also ask for references or check their reviews on FindMyCleaner.'],
    ],
    'Pricing & Quotes' => [
        ['question' => 'How much does a cleaning service typically cost?', 'answer' => 'Costs vary based on the type of cleaning, property size, location, and frequency. A standard house cleaning typically ranges from $100 to $250 per visit, deep cleaning from $200 to $500+, carpet cleaning from $75 to $300 per room, and commercial cleaning contracts from $500 to $2,000+ per month. Use our free quote feature to get personalized estimates from cleaners in your area.'],
        ['question' => 'How does the quote request process work?', 'answer' => 'Select your cleaning category, describe your needs including property size and any special requirements, and submit a quote request. We match you with qualified local cleaning professionals who will contact you with personalized estimates. You can compare quotes side by side and choose the cleaner that best fits your budget and needs, with no obligation.'],
        ['question' => 'Why do cleaning quotes vary so much between companies?', 'answer' => 'Price differences reflect factors such as the cleaning company\'s experience level, quality of products and equipment used, whether staff are insured and bonded, included extras like interior windows or appliance cleaning, frequency discounts, the company\'s overhead and staffing costs, and whether the estimate is flat-rate or hourly. The lowest quote is not always the best value; compare what is included in each estimate.'],
        ['question' => 'Do cleaning services charge by the hour or by the job?', 'answer' => 'Both models are common. Hourly rates typically range from $25 to $75 per cleaner per hour and work well for ongoing maintenance cleaning. Flat-rate pricing is based on your home size and the scope of work, which gives you cost certainty. Many companies offer discounts for recurring service, such as weekly, biweekly, or monthly plans. Ask your cleaner which pricing model they use and what is included.'],
    ],
    'Using FindMyCleaner' => [
        ['question' => 'Is FindMyCleaner free for homeowners and businesses?', 'answer' => 'Yes, FindMyCleaner is completely free for anyone looking to hire a cleaning service. You can browse cleaner profiles, read verified reviews, compare ratings across categories, and request quotes at no cost. Cleaning businesses pay a listing fee to be featured on our platform.'],
        ['question' => 'How are cleaner ratings and reviews calculated?', 'answer' => 'Ratings are based on verified reviews from customers who have used the cleaning service. We use a 5-star system that evaluates quality of work, reliability, communication, value for money, and professionalism. Only verified customers can leave reviews, ensuring authenticity. A cleaner\'s overall rating reflects their average score across all reviews.'],
        ['question' => 'What does the "Verified" badge mean on a cleaner\'s profile?', 'answer' => 'The Verified badge indicates that our team has confirmed the cleaning company\'s business registration, liability insurance, and professional credentials. Verified cleaners have passed our screening process, giving you added confidence that they are a legitimate, insured, and professional operation.'],
        ['question' => 'How can I list my cleaning business on FindMyCleaner?', 'answer' => 'Visit our "List Your Business" page and complete the registration form with your company details, service areas, cleaning categories, and credentials. Once submitted, our team reviews your application and verifies your business information. Approved listings go live within 1-2 business days. You can then manage your profile, respond to quote requests, and collect customer reviews.'],
    ],
    'Insurance & Trust' => [
        ['question' => 'Should a cleaning company be insured and bonded?', 'answer' => 'Absolutely. Always hire a cleaning service that carries general liability insurance and a surety bond. Liability insurance protects you if a cleaner damages your property or is injured on the job. A surety bond provides financial protection if a cleaner fails to complete the work or if theft occurs. Reputable cleaning companies will happily provide proof of insurance and bonding upon request.'],
        ['question' => 'What happens if something is damaged or goes missing during a cleaning?', 'answer' => 'A professional, insured cleaning company will have a process for handling damage claims. Report any issues immediately to the cleaning company and document the damage with photos. Their liability insurance should cover the cost of repair or replacement. On FindMyCleaner, verified cleaners carry confirmed insurance, and you can also leave a review about your experience to help other customers.'],
        ['question' => 'Are cleaning company employees background-checked?', 'answer' => 'Many reputable cleaning companies conduct background checks on their staff, but policies vary. When browsing FindMyCleaner, look for companies that mention background-checked employees in their profile. You can also ask the company directly about their hiring and screening process. This is especially important for residential cleaning, where staff have access to your home.'],
    ],
    'Specialized Cleaning Services' => [
        ['question' => 'What are eco-friendly or green cleaning options?', 'answer' => 'Green/Eco Cleaning uses non-toxic, biodegradable, and environmentally safe products that are better for your health and the planet. These cleaners avoid harsh chemicals, use HEPA-filtered vacuums, and often carry certifications like Green Seal or EPA Safer Choice. On FindMyCleaner, browse our Green/Eco Cleaning category to find environmentally conscious professionals near you.'],
        ['question' => 'What is included in a deep cleaning vs. a standard cleaning?', 'answer' => 'A standard cleaning covers routine tasks like dusting, vacuuming, mopping, bathroom and kitchen surface wipe-down, and trash removal. A deep cleaning goes further with baseboard scrubbing, inside appliance cleaning (oven, refrigerator), window sill and track cleaning, light fixture dusting, cabinet interior wiping, grout scrubbing, and thorough sanitization. Deep cleans are recommended seasonally or before moving in or out.'],
        ['question' => 'What is move-in/move-out cleaning?', 'answer' => 'Move-In/Move-Out Cleaning is a thorough cleaning designed for rental turnovers and home transitions. It typically includes deep cleaning of all rooms, inside cabinets and closets, appliance interiors, window cleaning, baseboard and trim wiping, and sanitization of kitchens and bathrooms. This service helps tenants get their security deposit back and prepares a home for new occupants.'],
        ['question' => 'Do you list cleaners for post-construction cleanup?', 'answer' => 'Yes, Post-Construction Cleanup is one of our 20 service categories. These specialists remove construction dust, debris, adhesive residue, and paint splatters. They typically offer phased cleaning: a rough clean during construction, a detailed clean after the work is done, and a final touch-up clean. Browse our Post-Construction Cleanup category to find experienced professionals near you.'],
        ['question' => 'What does vacation rental cleaning include?', 'answer' => 'Vacation Rental Cleaning is tailored for Airbnb, VRBO, and short-term rental hosts. It includes a full turnover clean between guests: fresh linens and towels, kitchen and bathroom deep clean, restocking supplies, trash removal, and a walkthrough checklist. Many vacation rental cleaners offer same-day turnovers and can coordinate directly with your booking calendar to ensure the property is guest-ready on time.'],
    ],
];

// Flatten FAQs for schema markup
$all_faqs = [];
foreach ($faq_sections as $faqs) {
    $all_faqs = array_merge($all_faqs, $faqs);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/inc_head.php'; ?>
    <?php echo schema_breadcrumb($breadcrumbs); ?>
    <?php echo schema_faq($all_faqs); ?>
</head>
<body>
<?php include 'includes/inc_header.php'; ?>

<!-- Page Header -->
<section class="page-header py-5">
    <div class="container">
        <?php echo render_breadcrumbs($breadcrumbs); ?>
        <h1 class="mb-2" data-aos="fade-up">Frequently Asked Questions</h1>
        <p class="mb-0 opacity-75" data-aos="fade-up" data-aos-delay="100">Everything you need to know about finding cleaning services and using FindMyCleaner</p>
    </div>
</section>

<!-- FAQ Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- FAQ Accordion -->
            <div class="col-lg-8">
                <?php $idx = 0; foreach ($faq_sections as $section_title => $faqs): ?>
                <h2 class="h4 mb-3 <?php echo $idx > 0 ? 'mt-5' : ''; ?>" data-aos="fade-up"><?php echo e($section_title); ?></h2>
                <div class="accordion mb-4" id="faqSection<?php echo $idx; ?>">
                    <?php foreach ($faqs as $i => $faq): ?>
                    <?php $collapse_id = "faq{$idx}_{$i}"; ?>
                    <div class="card border-0 shadow-sm mb-2" data-aos="fade-up">
                        <div class="card-header bg-white border-0 p-0" id="heading_<?php echo $collapse_id; ?>">
                            <h3 class="mb-0">
                                <button class="btn btn-link btn-block text-left text-dark font-weight-bold p-3 collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $collapse_id; ?>" aria-expanded="false" aria-controls="<?php echo $collapse_id; ?>">
                                    <?php echo e($faq['question']); ?>
                                    <i class="ti-angle-down float-right mt-1" style="font-size:12px;"></i>
                                </button>
                            </h3>
                        </div>
                        <div id="<?php echo $collapse_id; ?>" class="collapse" aria-labelledby="heading_<?php echo $collapse_id; ?>" data-parent="#faqSection<?php echo $idx; ?>">
                            <div class="card-body pt-0 text-muted">
                                <?php echo e($faq['answer']); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php $idx++; endforeach; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top:100px;">
                    <!-- Quick Navigation -->
                    <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="mb-3">Quick Navigation</h5>
                            <ul class="list-unstyled mb-0">
                                <?php $idx = 0; foreach ($faq_sections as $section_title => $faqs): ?>
                                <li class="mb-2">
                                    <a href="#faqSection<?php echo $idx; ?>" class="text-muted"><i class="ti-angle-right mr-1" style="font-size:10px;"></i> <?php echo e($section_title); ?></a>
                                </li>
                                <?php $idx++; endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- CTA Card -->
                    <div class="card border-0 shadow-sm text-white" style="background-color:var(--primary);" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body text-center p-4">
                            <h5 class="text-white mb-2">Still Have Questions?</h5>
                            <p class="small opacity-75 mb-3">Our team is here to help you find the right cleaning service for your needs.</p>
                            <a href="/contact" class="btn btn-light btn-sm mr-2">Contact Us</a>
                            <a href="/get-quotes" class="btn btn-outline-light btn-sm">Get Free Quotes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding bg-slate" style="background:linear-gradient(135deg, rgba(27,40,56,0.88), rgba(44,62,80,0.82)), url('/images/cta-cleaner.webp') center/cover no-repeat !important;">
    <div class="container text-center">
        <h2 data-aos="fade-up">Ready to Find Your Cleaner?</h2>
        <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Get free quotes from top-rated cleaning professionals in your area</p>
        <div data-aos="fade-up" data-aos-delay="200">
            <a href="/get-quotes" class="btn btn-light btn-lg mr-3">Get Free Quotes</a>
            <a href="/cleaners" class="btn btn-outline-light btn-lg">Browse Cleaners</a>
        </div>
    </div>
</section>

<?php include 'includes/inc_footer.php'; ?>
