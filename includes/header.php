<?php
if (!headers_sent()) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    header('X-Frame-Options: SAMEORIGIN');
    header('Cache-Control: max-age=3600, must-revalidate');
}

if (!isset($base_path)) {
    $doc_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $site_root = rtrim(str_replace('\\', '/', dirname(__DIR__)), '/');
    if ($doc_root !== '' && strpos(strtolower($site_root), strtolower($doc_root)) === 0) {
        $base_path = substr($site_root, strlen($doc_root));
    } else {
        $base_path = '';
    }
    $base_path = '/' . ltrim($base_path, '/') . '/';
    $base_path = preg_replace('#/+#', '/', $base_path);
}

if (!isset($page_title)) $page_title = 'Sash Technologies — Digital, Creative & Business Services';
if (!isset($page_description)) $page_description = 'Sash Technologies helps businesses grow with web, marketing, design, consulting and operational support.';
if (!isset($page_image)) $page_image = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80';
if (!isset($canonical_path)) $canonical_path = basename($_SERVER['PHP_SELF']);

if (substr($canonical_path, -4) === '.php') {
    $canonical_path = substr($canonical_path, 0, -4);
}
if ($canonical_path === 'index' || $canonical_path === '') {
    $canonical_url = 'https://sashtechnologies.com/';
} else {
    $canonical_url = 'https://sashtechnologies.com/' . ltrim($canonical_path, '/');
}

$current_page = basename($_SERVER['PHP_SELF']);
$all_services = require __DIR__ . '/../data.php';
if (!function_exists('service_url')) {
    function service_url($slug){
        global $base_path;
        return ($base_path ?? '/') . $slug;
    }
}

// JSON-LD Structured Data
$json_ld = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Organization',
            '@id' => 'https://sashtechnologies.com/#organization',
            'name' => 'Sash Technologies',
            'url' => 'https://sashtechnologies.com/',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => 'https://sashtechnologies.com/assets/images/favicon-square.png'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '',
                'contactType' => 'customer service',
                'email' => 'info@sashtechnologies.com',
                'areaServed' => 'US',
                'availableLanguage' => ['English']
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Buffalo',
                'addressRegion' => 'NY',
                'addressCountry' => 'US'
            ],
            'sameAs' => [
                'https://sashtechnologies.com/'
            ]
        ],
        [
            '@type' => 'WebSite',
            '@id' => 'https://sashtechnologies.com/#website',
            'url' => 'https://sashtechnologies.com/',
            'name' => 'Sash Technologies',
            'description' => 'Sash Technologies helps businesses grow with web, marketing, design, consulting and operational support.',
            'publisher' => [
                '@id' => 'https://sashtechnologies.com/#organization'
            ]
        ],
        [
            '@type' => 'WebPage',
            '@id' => $canonical_url . '#webpage',
            'url' => $canonical_url,
            'name' => $page_title,
            'description' => $page_description,
            'isPartOf' => [
                '@id' => 'https://sashtechnologies.com/#website'
            ]
        ]
    ]
];

if (isset($page_schema) && is_array($page_schema)) {
    $json_ld['@graph'][] = $page_schema;
}
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<base href="<?= htmlspecialchars($base_path) ?>">
<title><?= htmlspecialchars($page_title) ?></title>
<meta name="description" content="<?= htmlspecialchars($page_description) ?>">
<link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
<!-- Open Graph Meta Tags -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonical_url) ?>">
<meta property="og:image" content="<?= htmlspecialchars($page_image) ?>">
<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($page_description) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($page_image) ?>">
<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
<?= json_encode($json_ld, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>

</script>
<meta name="theme-color" content="#080b19">
<link rel="icon" href="<?= $base_path ?>favicon.ico" sizes="any">
<link rel="icon" href="<?= $base_path ?>favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= $base_path ?>apple-touch-icon.png">
<link rel="manifest" href="<?= $base_path ?>site.webmanifest">
<link rel="icon" type="image/png" sizes="96x96" href="<?= $base_path ?>favicon-96x96.png">
<?php if ($current_page === 'lead-capture-system.php'): ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WQGMH3BN');</script>
<!-- End Google Tag Manager -->
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= $base_path ?>assets/css/style.css"></head><body><script>(function(){try{if(localStorage.getItem('urd-theme')!=='dark'){document.body.className+=' light'}}catch(e){}})();</script>
<?php if ($current_page === 'lead-capture-system.php'): ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WQGMH3BN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php endif; ?>
<div class="site-noise" aria-hidden="true"></div>
<nav class="nav"><div class="container nav-inner">
<a href="<?= $base_path ?>" class="brand" aria-label="Sash Technologies home"><img src="<?= $base_path ?>assets/images/urdigilogo.png" alt="Sash Technologies logo" class="brand-logo"></a>
<div class="desktop-nav">
<a href="<?= $base_path ?>">Home</a><a href="<?= $base_path ?>about">About</a>
<div class="nav-dropdown"><button type="button">Services <svg class="nav-caret" viewBox="0 0 12 8" aria-hidden="true"><path d="M1.5 1.5 6 6l4.5-4.5"/></svg></button><div class="mega-menu"><div class="mega-intro"><span class="eyebrow">All capabilities</span><h3>One partner for digital growth.</h3><p>Strategy, design, technology, marketing and business support in one coordinated team.</p><a class="text-link" href="<?= $base_path ?>services">Explore all services →</a></div><div class="mega-links"><?php foreach ($all_services as $slug=>$service): ?><a href="<?= service_url($slug) ?>"><span><span class="service-menu-icon"><?= htmlspecialchars(strtoupper(substr($service['title'],0,2))) ?></span><?= htmlspecialchars($service['title']) ?></span><small>View details →</small></a><?php endforeach; ?></div></div></div>
<a href="<?= $base_path ?>portfolio">Portfolio</a><a href="<?= $base_path ?>blog">Articles</a><a href="<?= $base_path ?>faq">FAQs</a><a href="<?= $base_path ?>careers">Careers</a>
</div>
<div class="nav-actions"><button class="theme-toggle" id="theme-toggle" aria-label="Toggle color theme"><span class="theme-icon">◐</span></button><a href="<?= $base_path ?>schedule" class="nav-cta">Book a Call</a><button class="menu-trigger" id="menu-trigger" aria-label="Open menu" aria-expanded="false"><span></span><span></span></button></div>
</div></nav>
<div class="menu-overlay" id="menu-overlay"></div>
<aside class="side-panel" id="side-panel" aria-hidden="true"><div class="panel-head"><a href="<?= $base_path ?>" class="brand"><img src="<?= $base_path ?>assets/images/urdigilogo.png" alt="Sash Technologies logo" class="brand-logo"></a><button id="menu-close" class="menu-close" aria-label="Close menu">×</button></div><div class="panel-scroll"><nav class="panel-nav"><a href="<?= $base_path ?>">Home</a><a href="<?= $base_path ?>about">About</a><details open><summary>Services</summary><div class="panel-service-grid"><?php foreach ($all_services as $slug=>$service): ?><a href="<?= service_url($slug) ?>"><span class="service-menu-icon"><?= htmlspecialchars(strtoupper(substr($service['title'],0,2))) ?></span><?= htmlspecialchars($service['title']) ?></a><?php endforeach; ?></div></details><a href="<?= $base_path ?>portfolio">Portfolio</a><a href="<?= $base_path ?>blog">Articles</a><a href="<?= $base_path ?>faq">FAQs</a><a href="<?= $base_path ?>careers">Careers</a><a href="<?= $base_path ?>contact">Contact</a><a href="<?= $base_path ?>schedule">Schedule a Call</a></nav></div><div class="panel-contact"><span>Let’s talk</span><a href="mailto:info@sashtechnologies.com">info@sashtechnologies.com</a><a href="tel:17164000769">(666) 399-1245</a><p>Buffalo, New York</p><div class="panel-cta-row"><a class="btn btn-primary" href="<?= $base_path ?>contact">Start a project</a><a class="btn btn-ghost" href="<?= $base_path ?>schedule">Book a call</a></div></div></aside>
<main>