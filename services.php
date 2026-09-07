<?php 
$page_title='All Services | Sash Technologies'; 
$page_description='Explore Sash Technologies services across web, marketing, design, consulting, operations, writing, accounting and tax support.'; 
include 'includes/header.php'; 

$service_icons = [
  'web-design' => 'assets/images/SERVICESpage  ICONfor sash technologies/WEB DESIGN.svg',
  'web-hosting' => 'assets/images/SERVICESpage  ICONfor sash technologies/cloud & develop.svg',
  'ecommerce-website' => 'assets/images/SERVICESpage  ICONfor sash technologies/saas solution icon.svg',
  'seo' => 'assets/images/SERVICESpage  ICONfor sash technologies/Software development  icon.svg',
  'digital-marketing' => 'assets/images/SERVICESpage  ICONfor sash technologies/Digital Marketing icon.svg',
  'illustration-service' => 'assets/images/SERVICESpage  ICONfor sash technologies/Graphic Designer icon.svg',
  'social-media-marketing' => 'assets/images/SERVICESpage  ICONfor sash technologies/BRANDING DESIGN ICON.svg',
  'logo-service' => 'assets/images/SERVICESpage  ICONfor sash technologies/LOGO DESIGN ICON.svg',
  'graphic-design' => 'assets/images/SERVICESpage  ICONfor sash technologies/Graphic Designer icon.svg',
  'mobile-design' => 'assets/images/SERVICESpage  ICONfor sash technologies/UI & UX DESIGN ICON.svg',
];
?>
<header class="page-hero"><div class="hero-grid-bg"></div><div class="hero-orb orb-one"></div><div class="container  reveal"><div class="eyebrow">10+ specialist capabilities</div><h1>Everything your business needs to look sharper, work smarter, and grow faster.</h1><p class="lead">Choose a focused service or combine multiple capabilities into one coordinated project.</p><div class="cta-row"><a class="btn btn-primary" href="contact.php">Request a proposal →</a><a class="btn btn-ghost" href="schedule.php">Book a strategy call ↗</a></div></div></header>
<section><div class="container"><div class="service-directory"><?php foreach ($all_services as $slug=>$s): $icon = $service_icons[$slug] ?? 'assets/images/SERVICESpage  ICONfor sash technologies/WEB DESIGN.svg'; ?><a class="service-directory-card reveal" href="<?= $slug ?>.php"><div class="service-thumb"><img src="<?= htmlspecialchars($s['image']) ?>" alt="<?= htmlspecialchars($s['title']) ?>"><div class="service-icon-badge" style="position:absolute; top:12px; left:12px; width:44px; height:44px; background:rgba(8,11,25,0.85); backdrop-filter:blur(8px); border-radius:12px; border:1px solid rgba(122,89,211,0.4); display:flex; align-items:center; justify-content:center; box-shadow:0 8px 20px rgba(0,0,0,0.3);"><img src="<?= htmlspecialchars($icon) ?>" alt="<?= htmlspecialchars($s['title']) ?> Icon" style="width:26px; height:26px; object-fit:contain;"></div></div><div><span class="eyebrow">Specialist service</span><h2 style="display:flex; align-items:center; gap:10px;"><img src="<?= htmlspecialchars($icon) ?>" alt="" style="width:28px; height:28px; vertical-align:middle; filter:drop-shadow(0 2px 8px rgba(122,89,211,0.4));"><?= htmlspecialchars($s['title']) ?></h2><p><?= htmlspecialchars($s['description']) ?></p><span class="text-link">Explore service →</span></div></a><?php endforeach; ?></div></div></section>
<section class="cta-section"><div class="container"><div class="cta-panel reveal"><div><span class="eyebrow">Not sure where to begin?</span><h2>Tell us the goal. We’ll recommend the right combination.</h2><p>Share your priorities and we will shape a clear, practical scope around them.</p><div class="cta-row"><a class="btn btn-primary" href="contact.php">Start a project →</a><a class="btn btn-ghost" href="schedule.php">Book a call →</a></div></div><div class="cta-logo">ST</div></div></div></section><?php include 'includes/footer.php'; ?>