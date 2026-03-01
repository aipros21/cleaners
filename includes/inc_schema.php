<?php
/**
 * JSON-LD Schema.org markup generators
 */

$schema_config = [
    'name' => 'FindMyCleaner',
    'url' => getenv('SITE_URL') ?: 'https://cleaners-247.com',
    'logo' => (getenv('SITE_URL') ?: 'https://cleaners-247.com') . '/images/logo.png',
    'email' => 'info@cleaners-247.com',
    'phone' => '+1-800-FIND-PRO',
    'description' => 'FindMyCleaner connects homeowners with top-rated local cleaners across 20 service categories.',
    'address' => [
        'street' => '',
        'city' => 'Miami',
        'state' => 'FL',
        'zip' => '33101',
        'country' => 'US'
    ],
    'social' => [
        'https://facebook.com/findmycleaner',
        'https://twitter.com/findmycleaner'
    ]
];

function _schema_output($data) {
    return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}

function schema_website() {
    global $schema_config;
    return _schema_output([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $schema_config['name'],
        'url' => $schema_config['url'],
        'description' => $schema_config['description'],
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => $schema_config['url'] . '/search?q={search_term_string}',
            'query-input' => 'required name=search_term_string'
        ]
    ]);
}

function schema_organization() {
    global $schema_config;
    return _schema_output([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $schema_config['name'],
        'url' => $schema_config['url'],
        'logo' => $schema_config['logo'],
        'email' => $schema_config['email'],
        'telephone' => $schema_config['phone'],
        'sameAs' => $schema_config['social'],
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $schema_config['address']['city'],
            'addressRegion' => $schema_config['address']['state'],
            'addressCountry' => $schema_config['address']['country']
        ]
    ]);
}

function schema_local_business($business) {
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'HomeAndConstructionBusiness',
        'name' => $business['business_name'],
        'url' => (getenv('SITE_URL') ?: 'https://cleaners-247.com') . '/cleaner/' . $business['slug'],
        'telephone' => $business['phone'] ?? '',
        'email' => $business['email'] ?? ''
    ];

    if (!empty($business['logo'])) $data['image'] = $business['logo'];
    if (!empty($business['description'])) $data['description'] = $business['description'];

    if (!empty($business['address'])) {
        $data['address'] = [
            '@type' => 'PostalAddress',
            'streetAddress' => $business['address'],
            'addressLocality' => $business['city_name'] ?? '',
            'addressRegion' => $business['state_code'] ?? '',
            'postalCode' => $business['zip_code'] ?? '',
            'addressCountry' => 'US'
        ];
    }

    if (!empty($business['lat']) && !empty($business['lng'])) {
        $data['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude' => $business['lat'],
            'longitude' => $business['lng']
        ];
    }

    if (!empty($business['avg_rating']) && $business['avg_rating'] > 0) {
        $data['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => number_format($business['avg_rating'], 1),
            'reviewCount' => $business['review_count'] ?? 0,
            'bestRating' => '5',
            'worstRating' => '1'
        ];
    }

    return _schema_output($data);
}

function schema_breadcrumb($items) {
    $list = [];
    foreach ($items as $i => $item) {
        $list[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url'] ?? ''
        ];
    }
    return _schema_output([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list
    ]);
}

function schema_article($article) {
    $site_url = getenv('SITE_URL') ?: 'https://cleaners-247.com';
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $article['title'],
        'url' => $site_url . '/blog/' . $article['slug'],
        'datePublished' => $article['published_at'] ?? $article['created_at'],
        'dateModified' => $article['updated_at'] ?? $article['created_at'],
        'author' => [
            '@type' => 'Organization',
            'name' => 'FindMyCleaner'
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'FindMyCleaner',
            'logo' => ['@type' => 'ImageObject', 'url' => $site_url . '/images/logo.png']
        ]
    ];
    if (!empty($article['image'])) $data['image'] = $article['image'];
    if (!empty($article['excerpt'])) $data['description'] = $article['excerpt'];
    return _schema_output($data);
}

function schema_faq($faqs) {
    $items = [];
    foreach ($faqs as $faq) {
        $items[] = [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer']
            ]
        ];
    }
    return _schema_output([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $items
    ]);
}

function schema_item_list($items, $name = '') {
    $list = [];
    foreach ($items as $i => $item) {
        $list[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'url' => $item['url'],
            'name' => $item['name']
        ];
    }
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'itemListElement' => $list
    ];
    if ($name) $data['name'] = $name;
    return _schema_output($data);
}

function schema_review($review, $business) {
    return _schema_output([
        '@context' => 'https://schema.org',
        '@type' => 'Review',
        'reviewRating' => [
            '@type' => 'Rating',
            'ratingValue' => $review['rating'],
            'bestRating' => '5'
        ],
        'author' => ['@type' => 'Person', 'name' => $review['author_name']],
        'datePublished' => $review['created_at'],
        'reviewBody' => $review['content'] ?? '',
        'itemReviewed' => [
            '@type' => 'HomeAndConstructionBusiness',
            'name' => $business['business_name']
        ]
    ]);
}
