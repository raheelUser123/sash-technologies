<?php
$services = require __DIR__ . '/data.php';
$page_title = 'Schedule a Strategy Call — Sash Technologies';
$page_description = 'Book a focused strategy call with Sash Technologies. Choose a service, preferred date and time in a simple Calendly-style flow.';
$selected = $_GET['service'] ?? '';
include 'includes/header.php';
?>
<header class="page-hero booking-hero">
  <div class="hero-grid-bg"></div><div class="hero-orb orb-one"></div><div class="hero-orb orb-two"></div>
  <div class="container narrow center reveal">
    <div class="eyebrow">Schedule a call</div>
    <h1>Book your <span class="gradient-text">strategy session.</span></h1>
    <p class="lead center">Choose a service, select your preferred date and time, then tell us what you want to accomplish.</p>
  </div>
</header>
<section class="booking-section">
  <div class="container">
    <form id="lead-form" class="booking-shell form-card multi-step reveal" action="/contact-handler.php" method="post">
      <input type="hidden" name="form_type" value="strategy_call">
      <div class="hp" aria-hidden="true"><label>Leave this field empty<input type="text" name="urd_company_fax" value="" tabindex="-1" autocomplete="new-password"></label></div>
      <aside class="booking-sidebar">
        <div class="booking-brand"><img src="assets/images/urdigilogo.png" alt="Sash Technologies logo" class="brand-logo"></div>
        <div class="booking-duration">30-minute strategy call</div>
        <p>A focused conversation to understand the opportunity, recommend the right approach and define clear next steps.</p>
        <ul class="booking-benefits">
          <li>Discuss goals and challenges</li><li>Review the best service fit</li><li>Clarify scope and timeline</li><li>No pressure or obligation</li>
        </ul>
        <div class="booking-contact"><small>Need help booking?</small><a href="tel:17164000769">(666) 399-1245</a><a href="mailto:info@sashtechnologies.com">info@sashtechnologies.com</a></div>
      </aside>
      <div class="booking-main">
        <div class="form-progress"><span class="active">1</span><span>2</span><span>3</span><span>4</span></div>
        <div class="form-step active">
          <div class="eyebrow">Step 1 of 4</div><h2>What would you like to discuss?</h2><p>Select the service closest to your current need.</p>
          <div class="booking-services">
          <?php foreach ($services as $s): ?>
            <label class="booking-option"><input type="radio" required name="service" value="<?= htmlspecialchars($s['title']) ?>" <?= $selected === $s['title'] ? 'checked' : '' ?>><span><b><?= htmlspecialchars($s['title']) ?></b><small><?= htmlspecialchars($s['description']) ?></small></span></label>
          <?php endforeach; ?>
          </div>
          <div class="form-actions end"><button type="button" class="btn btn-primary next-step">Choose date →</button></div>
        </div>
        <div class="form-step">
          <div class="eyebrow">Step 2 of 4</div><h2>Select a preferred date</h2><p>Pick a date that works for you. We will confirm availability by email.</p>
          <label class="date-picker-card">Preferred date<input required type="date" name="preferred_date" min="<?= date('Y-m-d') ?>"></label>
          <label>Timezone<select name="timezone"><option>Eastern Time (ET)</option><option>Central Time (CT)</option><option>Mountain Time (MT)</option><option>Pacific Time (PT)</option><option>Pakistan Standard Time (PKT)</option><option>Other / confirm by email</option></select></label>
          <div class="form-actions"><button type="button" class="btn btn-ghost prev-step">← Back</button><button type="button" class="btn btn-primary next-step">Choose time →</button></div>
        </div>
        <div class="form-step">
          <div class="eyebrow">Step 3 of 4</div><h2>Choose a preferred time</h2><p>Select a convenient slot. The exact appointment will be confirmed after submission.</p>
          <div class="time-grid"><?php foreach (['9:00 AM','10:00 AM','11:00 AM','12:00 PM','1:00 PM','2:00 PM','3:00 PM','4:00 PM','5:00 PM'] as $t): ?><label class="time-slot"><input required type="radio" name="preferred_time" value="<?= $t ?>"><span><?= $t ?></span></label><?php endforeach; ?></div>
          <div class="form-actions"><button type="button" class="btn btn-ghost prev-step">← Back</button><button type="button" class="btn btn-primary next-step">Your details →</button></div>
        </div>
        <div class="form-step">
          <div class="eyebrow">Step 4 of 4</div><h2>Tell us about yourself</h2>
          <div class="booking-fields"><label>Full name<input required name="name" autocomplete="name"></label><label>Email address<input required type="email" name="email" autocomplete="email"></label><label>Phone number<input name="phone" autocomplete="tel"></label><label>Business / organization<input name="business" autocomplete="organization"></label></div>
          <label>What would make this call useful?<textarea required name="message" placeholder="Share your goals, current challenge, timeline, or any links we should review."></textarea></label>
          <label>Estimated project budget<select name="budget"><option>Not sure yet</option><option>Under $1,000</option><option>$1,000–$3,000</option><option>$3,000–$7,500</option><option>$7,500+</option></select></label>
          <div id="form-status"></div><div class="form-actions"><button type="button" class="btn btn-ghost prev-step">← Back</button><button type="submit" class="btn btn-primary">Request this time</button></div>
        </div>
      </div>
    </form>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
