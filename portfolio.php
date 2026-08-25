<?php 
$page_title = 'Portfolio — Sash Technologies'; 
$page_description = 'Explore 40+ selected Sash Technologies websites, brand systems, marketing campaigns, analytics dashboards, and automation case studies.'; 
include 'includes/header.php';

$all_portfolio_items = [
    [
        'title' => 'NovaPay — Fintech & SaaS Platform',
        'cat' => 'Website',
        'code' => 'web',
        'image' => 'assets/images/portfolio/webui/web1.jpeg',
        'desc' => 'Clean SaaS web interface designed for rapid user onboarding, subscription management, and high-conversion signup flows.'
    ],
    [
        'title' => 'Aura Healths — Wellness & Telehealth Portal',
        'cat' => 'Website',
        'code' => 'web',
        'image' => 'assets/images/portfolio/webui/web2.jpeg',
        'desc' => 'Modern responsive digital portal built with patient trust, seamless appointment booking, and intuitive service discovery in mind.'
    ],
    [
        'title' => 'Nexus Cloud — Enterprise Infrastructure Site',
        'cat' => 'Website',
        'code' => 'web',
        'image' => 'assets/images/portfolio/webui/web3.webp',
        'desc' => 'Conversion-focused enterprise website built to showcase cloud infrastructure solutions with speed and executive clarity.'
    ],
    [
        'title' => 'Luxe Living — Real Estate & Property Showcase',
        'cat' => 'Website',
        'code' => 'web',
        'image' => 'assets/images/portfolio/webui/web4.webp',
        'desc' => 'High-end digital property gallery with interactive walkthroughs, premium typography, and instant lead capture forms.'
    ],
    [
        'title' => 'Apex Studio — Creative Agency Digital Hub',
        'cat' => 'Website',
        'code' => 'web',
        'image' => 'assets/images/portfolio/webui/web5.webp',
        'desc' => 'Dynamic agency portfolio website featuring fluid page transitions, dark-mode visual hierarchy, and service positioning.'
    ],
    [
        'title' => 'Vanguard Capital — Wealth Management Web App',
        'cat' => 'Website',
        'code' => 'web',
        'image' => 'assets/images/portfolio/webui/web6.webp',
        'desc' => 'Structured financial web portal presenting complex advisory services with credibility, interactive tools, and clear CTA paths.'
    ],
    [
        'title' => 'Verde Organics — Sustainable Brand Identity',
        'cat' => 'Branding',
        'code' => 'branding',
        'image' => 'assets/images/portfolio/branding/1.jpg',
        'desc' => 'Complete eco-friendly brand identity system featuring organic color palettes, sustainable packaging guidelines, and minimalist typography.'
    ],
    [
        'title' => 'Solstice Energy — CleanTech Visual System',
        'cat' => 'Branding',
        'code' => 'branding',
        'image' => 'assets/images/portfolio/branding/2.jpg',
        'desc' => 'Strategic visual identity direction built around modern energy signals, high-impact brand collateral, and market differentiation.'
    ],
    [
        'title' => 'Urban Craft — Boutique Hospitality Branding',
        'cat' => 'Branding',
        'code' => 'branding',
        'image' => 'assets/images/portfolio/branding/3.jpg',
        'desc' => 'Sophisticated branding exploration balancing premium print collateral, custom iconography, and memorable guest touchpoints.'
    ],
    [
        'title' => 'Kinetix Performance — Athletic Wear Brand Guide',
        'cat' => 'Branding',
        'code' => 'branding',
        'image' => 'assets/images/portfolio/branding/4.jpg',
        'desc' => 'High-energy sportswear brand system using bold typography, athletic rhythm, and flexible identity assets across digital and apparel.'
    ],
    [
        'title' => 'Meridian Global — Executive Advisory Guidelines',
        'cat' => 'Branding',
        'code' => 'branding',
        'image' => 'assets/images/portfolio/branding/5.jpg',
        'desc' => 'Elevated corporate brand identity built to instill trust and authority across investor decks, stationery, and digital channels.'
    ],
    [
        'title' => 'Artisan Coffee Co. — Specialty Roast Brand System',
        'cat' => 'Branding',
        'code' => 'branding',
        'image' => 'assets/images/portfolio/branding/port1.jpg',
        'desc' => 'Craft brand identity featuring artisan packaging textures, custom stamp marks, and retail visual assets.'
    ],
    [
        'title' => 'Zenith AI — Geometric Tech Mark',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/Logo1.webp',
        'desc' => 'Scalable geometric icon and wordmark engineered for seamless adaptability across mobile apps, dark UI, and print collateral.'
    ],
    [
        'title' => 'Pulse Care — Medical & Life Sciences Symbol',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/Logo3.webp',
        'desc' => 'Clean human-centric symbol blending medical cross and vital wave motifs for modern healthcare branding.'
    ],
    [
        'title' => 'Hyperion Cyber — Defense & Security Crest',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/Logo4.webp',
        'desc' => 'Bold shield icon crafted for cyber-defense platforms, communicating resilience, encryption, and enterprise trust.'
    ],
    [
        'title' => 'Orbit Logistics — Global Supply Chain Emblem',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/Logo5.webp',
        'desc' => 'Dynamic interconnected vector emblem representing speed, global connectivity, and streamlined logistics.'
    ],
    [
        'title' => 'EcoFlow — Renewable Energy Brandmark',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/Logo6.webp',
        'desc' => 'Fluid leaf-and-wave monogram crafted for green tech startups and clean energy initiatives.'
    ],
    [
        'title' => 'Veloce Motors — Luxury Automotive Insignia',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/1.webp',
        'desc' => 'Sleek metallic insignia designed for high-performance automotive and luxury transport branding.'
    ],
    [
        'title' => 'Strata Analytics — Data & Intelligence Emblem',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/9.webp',
        'desc' => 'Precision data node emblem built to express intelligence, growth metrics, and cloud analytics.'
    ],
    [
        'title' => 'Horizon Capital — Venture Fund Identity Mark',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/logo2.webp',
        'desc' => 'Minimalist financial brandmark representing upward growth, strategic vision, and investment authority.'
    ],
    [
        'title' => 'Crestview Law — Legal Practice Monogram',
        'cat' => 'Logo Design',
        'code' => 'logo',
        'image' => 'assets/images/portfolio/logo/logo6.webp',
        'desc' => 'Classic monogram emblem refined for modern law firms, combining traditional prestige with crisp digital aesthetics.'
    ]
];

$cat_filter = isset($_GET['cat']) ? strtolower(trim($_GET['cat'])) : 'all';

$filtered_items = [];
if ($cat_filter !== 'all' && in_array($cat_filter, ['web', 'branding', 'logo'])) {
    foreach ($all_portfolio_items as $item) {
        if ($item['code'] === $cat_filter) {
            $filtered_items[] = $item;
        }
    }
} else {
    $filtered_items = $all_portfolio_items;
}

$per = 12;
$page = max(1, (int)($_GET['page'] ?? 1));
$pages = (int)ceil(count($filtered_items) / $per);
if ($pages < 1) $pages = 1;
$page = min($page, $pages);
$slice = array_slice($filtered_items, ($page - 1) * $per, $per);
?>

<header class="page-hero split-page-hero portfolio-hero">
  <div class="hero-orb orb-one"></div>
  <div class="container split-hero-grid">
    <div class="split-hero-copy reveal">
      <div class="eyebrow">Selected work</div>
      <h1>Digital work designed to earn attention and move people to act.</h1>
      <p class="lead">Explore websites, brand systems, campaigns, dashboards, and automations built around clearer journeys and measurable business goals.</p>
      <div class="cta-row">
        <a href="#portfolio-grid" class="btn btn-primary">Explore projects ↓</a>
        <a href="contact.php" class="btn btn-ghost">Start yours ↗</a>
      </div>
    </div>
    <div class="split-hero-media reveal">
      <img src="assets/images/portfolio/logo/Logo1.webp" alt="Logo design portfolio showcase">
      <div class="hero-media-badge">
        <strong><?= count($all_portfolio_items) ?></strong>
        <span>featured projects</span>
      </div>
    </div>
  </div>
</header>

<?php include 'includes/trust-strip.php'; ?>

<section id="portfolio-grid">
  <div class="container">
    <div class="portfolio-filter reveal">
      <span>Explore by capability</span>
      <div>
        <a href="?cat=all#portfolio-grid" class="filter-btn <?= $cat_filter==='all'?'active':'' ?>">All (<?= count($all_portfolio_items) ?>)</a>
        <a href="?cat=web#portfolio-grid" class="filter-btn <?= $cat_filter==='web'?'active':'' ?>">Website</a>
        <a href="?cat=branding#portfolio-grid" class="filter-btn <?= $cat_filter==='branding'?'active':'' ?>">Branding</a>
        <a href="?cat=logo#portfolio-grid" class="filter-btn <?= $cat_filter==='logo'?'active':'' ?>">Logo Designs</a>
      </div>
    </div>

    <div class="portfolio-grid premium-portfolio">
      <?php foreach($slice as $x): ?>
        <article class="portfolio-card reveal" 
                 data-category="<?= htmlspecialchars($x['code']) ?>" 
                 data-title="<?= htmlspecialchars($x['title']) ?>" 
                 data-cat="<?= htmlspecialchars($x['cat']) ?>" 
                 data-img="<?= htmlspecialchars($x['image']) ?>" 
                 data-desc="<?= htmlspecialchars($x['desc']) ?>">
          <a class="portfolio-media portfolio-lightbox-trigger" href="javascript:void(0)" aria-label="View <?= htmlspecialchars($x['title']) ?>">
            <img src="<?= htmlspecialchars($x['image']) ?>" alt="<?= htmlspecialchars($x['title']) ?> showcase" loading="lazy">
            <span>Preview project ↗</span>
          </a>
          <div class="portfolio-copy">
            <small><?= htmlspecialchars($x['cat']) ?></small>
            <h2><?= htmlspecialchars($x['title']) ?></h2>
            <p><?= htmlspecialchars($x['desc']) ?></p>
            <a class="text-link portfolio-lightbox-trigger" href="javascript:void(0)">View project showcase →</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($pages > 1): ?>
      <nav class="pagination" aria-label="Portfolio pages">
        <?php for($p = 1; $p <= $pages; $p++): ?>
          <a class="<?= $p === $page ? 'active' : '' ?>" href="?page=<?= $p ?>&cat=<?= urlencode($cat_filter) ?>#portfolio-grid"><?= $p ?></a>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>
  </div>
</section>

<!-- Portfolio Lightbox Modal -->
<div id="portfolio-modal" class="query-popup portfolio-modal" role="dialog" aria-hidden="true" aria-label="Project showcase detail">
  <div class="query-popup-card portfolio-modal-card">
    <div class="portfolio-modal-media">
      <div class="mac-bar">
        <div class="mac-dots">
          <span class="mac-dot mac-red"></span>
          <span class="mac-dot mac-yellow"></span>
          <span class="mac-dot mac-green"></span>
        </div>
        <div class="mac-url-bar" id="modal-url">urdigitaltech.com/preview</div>
      </div>
      <div class="portfolio-modal-media-inner">
        <img id="modal-img" src="" alt="Project Preview">
        <div class="portfolio-modal-hint">Hover to scroll full page ↕</div>
      </div>
    </div>
    <div class="query-popup-content portfolio-modal-content">
      <button class="query-popup-close modal-close" aria-label="Close modal">×</button>
      <div class="eyebrow" id="modal-cat">Capability</div>
      <h2 id="modal-title" style="font-size:clamp(1.8rem,3.2vw,2.6rem); margin: 6px 0 12px;">Project Title</h2>
      <p id="modal-desc" style="color:var(--muted); line-height:1.65; margin-bottom:24px;">Project description...</p>
      <div class="cta-row" style="margin-top:auto;">
        <a class="btn btn-primary pulse-cta" href="contact.php">Start a similar project →</a>
        <a class="btn btn-ghost" href="schedule.php">Book a call ↗</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('portfolio-modal');
  if (!modal) return;
  const modalImg = document.getElementById('modal-img');
  const modalCat = document.getElementById('modal-cat');
  const modalTitle = document.getElementById('modal-title');
  const modalDesc = document.getElementById('modal-desc');
  const modalUrl = document.getElementById('modal-url');
  const closeBtn = modal.querySelector('.modal-close');

  const setupHoverScroll = () => {
    modalImg.style.transform = 'translateY(0)';
    modalImg.style.transition = 'transform 0.3s ease';

    const inner = modalImg.closest('.portfolio-modal-media-inner') || modalImg.parentElement;
    if (!inner) return;

    const calcAndAttach = () => {
      const containerH = inner.clientHeight;
      const renderedH = modalImg.naturalHeight
        ? (modalImg.naturalHeight * (modalImg.clientWidth / modalImg.naturalWidth))
        : modalImg.clientHeight;
      const scrollDist = Math.max(0, renderedH - containerH);
      const duration = Math.min(8, Math.max(3.5, scrollDist / 250));

      inner.onmouseenter = () => {
        if (scrollDist > 10) {
          modalImg.style.transition = `transform ${duration}s cubic-bezier(0.25, 1, 0.5, 1)`;
          modalImg.style.transform = `translateY(-${scrollDist}px)`;
        }
      };

      inner.onmouseleave = () => {
        modalImg.style.transition = `transform 0.7s cubic-bezier(0.25, 1, 0.5, 1)`;
        modalImg.style.transform = 'translateY(0)';
      };
    };

    if (modalImg.complete) {
      calcAndAttach();
    } else {
      modalImg.onload = calcAndAttach;
    }
  };

  const openModal = (card) => {
    modalImg.src = card.dataset.img;
    modalCat.textContent = card.dataset.cat;
    modalTitle.textContent = card.dataset.title;
    modalDesc.textContent = card.dataset.desc;
    if (modalUrl) {
      const cleanSlug = (card.dataset.title || 'preview').toLowerCase().replace(/[^a-z0-9]+/g, '-');
      modalUrl.textContent = `sashtechnologies.com/${cleanSlug}`;
    }
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    setupHoverScroll();
  };

  const closeModal = () => {
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    modalImg.style.transform = 'translateY(0)';
  };

  document.querySelectorAll('.portfolio-card').forEach(card => {
    card.querySelectorAll('.portfolio-lightbox-trigger').forEach(trigger => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        openModal(card);
      });
    });
  });

  closeBtn?.addEventListener('click', closeModal);
  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
  });
});
</script>

<?php include 'includes/footer.php'; ?>
