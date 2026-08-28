<?php $page_title='Careers at Sash Technologies — Join Our Team'; $page_description='Explore open sales positions at Sash Technologies. We are a remote-first team looking for driven, reliable sales and business development professionals.'; include 'includes/header.php'; ?>
<header class="page-hero split-page-hero careers-hero"><div class="hero-orb orb-two"></div><div class="container split-hero-grid"><div class="split-hero-copy reveal"><div class="eyebrow">Careers at Sash Technologies</div><h1>Join a high-energy sales team that grows together.</h1><p class="lead">We are a remote-first team building websites, brands, marketing and business systems — and hiring driven professionals to help great clients find us.</p><div class="cta-row"><a href="#openings" class="btn btn-primary">View open positions →</a><a href="contact.php" class="btn btn-ghost">Questions? Contact us ↗</a></div></div><div class="split-hero-media reveal"><img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=82" alt="Team collaborating on laptops"><div class="hero-media-badge"><strong>3</strong><span>open positions</span></div></div></div></header>
<?php include 'includes/trust-strip.php'; ?>
<section><div class="container"><div class="section-head reveal"><div class="eyebrow">Why join us</div><h2>A team built for reliable delivery.</h2><p>We work remotely, communicate clearly and reward people who own results. You get real targets, real pipeline and room to grow.</p></div><div class="grid grid-3"><article class="card reveal spotlight-card"><span class="card-icon">◉</span><h3>Real targets</h3><p>You work the pipeline, close deals and see your effort turn into signed projects — not busywork.</p></article><article class="card reveal spotlight-card"><span class="card-icon">◎</span><h3>Remote & flexible</h3><p>Work from anywhere on a schedule that fits your life while hitting clear weekly activity and revenue goals.</p></article><article class="card reveal spotlight-card"><span class="card-icon">◇</span><h3>Room to grow</h3><p>Top performers move up quickly — from junior to senior roles, larger accounts and bigger territories.</p></article></div></div></section>
<section id="openings" class="section-alt"><div class="container"><div class="section-head reveal"><div class="eyebrow eyebrow-pink">Open positions</div><h2>Join our team.</h2><p>Pick a role that fits. Every application is read by a person — we reply to everyone.</p></div><div class="grid grid-3 careers-grid">
<article class="card reveal job-card" data-job="Junior Sales Executive" data-location="Remote" data-type="Full-time"><span class="card-icon job-icon">S</span><div class="job-meta"><span class="job-badge">Full-time</span><span class="job-badge">Remote</span></div><h3>Junior Sales Executive</h3><p>Make first contact, qualify inbound leads and keep the pipeline healthy with clear communication and honest follow-through.</p><ul class="job-tags"><li>Sales Outreach</li><li>Cold Calling</li><li>CRM</li><li>Communication</li></ul><button type="button" class="btn btn-primary apply-btn" data-job="Junior Sales Executive" data-location="Remote" data-type="Full-time">Apply Now</button></article>
<article class="card reveal job-card" data-job="Senior Sales Executive" data-location="Remote" data-type="Full-time"><span class="card-icon job-icon">S</span><div class="job-meta"><span class="job-badge">Full-time</span><span class="job-badge">Remote</span></div><h3>Senior Sales Executive</h3><p>Own the full sales cycle, build senior relationships and close proposals directly with a consultative, client-first approach.</p><ul class="job-tags"><li>Sales Strategy</li><li>Negotiation</li><li>Proposals</li><li>Account Management</li></ul><button type="button" class="btn btn-primary apply-btn" data-job="Senior Sales Executive" data-location="Remote" data-type="Full-time">Apply Now</button></article>
<article class="card reveal job-card" data-job="Business Development Executive" data-location="Remote" data-type="Full-time"><span class="card-icon job-icon">B</span><div class="job-meta"><span class="job-badge">Full-time</span><span class="job-badge">Remote</span></div><h3>Business Development Executive</h3><p>Find new opportunities, build partnerships and open up new markets for a growing, delivery-driven team.</p><ul class="job-tags"><li>Market Research</li><li>Partnerships</li><li>Proposals</li><li>Growth</li></ul><button type="button" class="btn btn-primary apply-btn" data-job="Business Development Executive" data-location="Remote" data-type="Full-time">Apply Now</button></article>
</div></div></section>
<section class="cta-section primary-cta-section"><div class="container"><div class="cta-panel primary-cta-panel reveal"><div><span class="eyebrow">Don't see your role?</span><h2>Tell us how you can help.</h2><p>We are always looking for talented, reliable people. Send us your details and we will keep you in mind.</p><div class="cta-row"><button type="button" class="btn btn-primary apply-btn" data-job="General Application" data-location="Remote" data-type="Open">Apply Anyway →</button><a href="contact.php" class="btn btn-ghost">Contact us ↗</a></div></div><div class="cta-logo">ST</div></div></div></section>
<div class="query-popup" id="apply-modal" role="dialog" aria-modal="true" aria-label="Job application form"><div class="query-popup-card apply-popup-card"><div class="query-popup-content apply-popup-content"><button class="query-popup-close" data-apply-close aria-label="Close">×</button><div class="eyebrow">Job application</div><h2 id="apply-job-title">Apply for a position</h2><p class="apply-job-meta" id="apply-job-meta"></p>
<form id="apply-form" class="form-card apply-form" action="<?= $base_path ?>careers-handler.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="form_type" value="job_application">
<input type="hidden" name="position" id="apply-position-input">
<input type="hidden" name="age" id="age-input">
<div class="hp" aria-hidden="true"><label>Leave this field empty<input type="text" name="urd_company_fax" value="" tabindex="-1" autocomplete="new-password"></label></div>
<div class="form-progress"><span data-step="1">1</span><span data-step="2">2</span><span data-step="3">3</span></div>

<fieldset class="form-step active" data-step="1">
<h3>1 · Personal information</h3>
<div class="apply-row"><label class="form-field">First name<input type="text" name="first_name" required autocomplete="given-name"></label><label class="form-field">Last name<input type="text" name="last_name" required autocomplete="family-name"></label></div>
<label class="form-field">Email address<input type="email" name="email" required autocomplete="email"></label>
<label class="form-field">Phone number<input type="tel" name="phone" required autocomplete="tel"></label>
<div class="apply-row"><label class="form-field">Gender<select name="gender"><option value="">Select</option><option>Male</option><option>Female</option><option>Other</option></select></label><label class="form-field">Date of birth<small class="hint">mm/dd/yyyy</small><input type="text" name="dob" id="dob" placeholder="MM/DD/YYYY" onchange="careerSetAge()"></label><label class="form-field">Age<input type="text" id="age" readonly tabindex="-1" placeholder="Auto"></label></div>
<label class="form-field">Location<select name="location" required><option value="">Select your location</option><option>Remote — Pakistan</option><option>Remote — India</option><option>Remote — Philippines</option><option>Remote — Other</option><option>On-site</option></select></label>
<label class="form-field">LinkedIn profile<input type="url" name="linkedin" placeholder="https://linkedin.com/in/..."></label>
<label class="form-field">Portfolio / website<input type="url" name="portfolio" placeholder="https://..."></label>
<div class="form-actions end"><button type="button" class="btn btn-primary apply-next" data-go="2">Continue →</button></div>
</fieldset>

<fieldset class="form-step" data-step="2">
<h3>2 · Documents</h3>
<label class="form-field">Resume / CV (PDF, DOC, DOCX, RTF or TXT — max 5 MB)<input type="file" name="resume" id="resume-file" accept=".pdf,.doc,.docx,.rtf,.txt" required></label>
<p class="form-note" id="resume-name"></p>
<label class="form-field">Why you are a good fit (optional)<textarea name="message" placeholder="Tell us briefly about your sales experience, achievements and availability..."></textarea></label>
<div class="form-actions"><button type="button" class="btn btn-ghost apply-back" data-go="1">← Back</button><button type="button" class="btn btn-primary apply-next" data-go="3">Continue →</button></div>
</fieldset>

<fieldset class="form-step" data-step="3">
<h3>3 · Review & submit</h3>
<div class="review-list" id="review-list"></div>
<label class="form-field review-ok"><input type="checkbox" id="confirm-ok" required> I confirm that the information and resume provided are accurate.</label>
<div id="form-status" class="form-note" role="status"></div>
<div class="form-actions"><button type="button" class="btn btn-ghost apply-back" data-go="2">← Back</button><button type="submit" class="btn btn-primary" id="submit-btn">Submit Application</button></div>
<p class="form-note apply-note">We reply to every application. No third-party recruiters.</p>
</fieldset>
</form>
</div></div></div>
<script>
(function(){
  var modal=document.getElementById('apply-modal');
  var form=document.getElementById('apply-form');
  var title=document.getElementById('apply-job-title');
  var meta=document.getElementById('apply-job-meta');
  var posInput=document.getElementById('apply-position-input');
  var steps=[],dots=[],current=0;
  function refreshSteps(){ steps=Array.prototype.slice.call(form.querySelectorAll('.form-step')); dots=Array.prototype.slice.call(form.querySelectorAll('.form-progress span')); }
  function show(n){
    current=Math.max(0,Math.min(steps.length-1,n));
    steps.forEach(function(el,i){ el.classList.toggle('active',i===current); });
    dots.forEach(function(el,i){ el.classList.toggle('active',i===current); });
    if(current===2){ buildReview(); }
  }
  function stepValid(idx){
    var el=steps[idx]; if(!el) return true;
    var req=el.querySelectorAll('input[required],select[required],textarea[required]');
    for(var i=0;i<req.length;i++){ var f=req[i]; if(!f.value||!f.value.trim()){ f.focus(); if(f.reportValidity) f.reportValidity(); return false; } }
    if(idx===1){ var rf=document.getElementById('resume-file'); if(rf&&!rf.files.length){ alert('Please upload your resume (PDF, DOC, DOCX, RTF or TXT).'); return false; } }
    return true;
  }
  function go(n){ if(n<current){ show(n); return; } if(!stepValid(current)) return; show(n); }
  function fieldVal(name){
    var e=form.querySelector('[name="'+name+'"]'); if(!e) return '';
    if(e.files&&e.files.length) return e.files[0].name;
    if(e.selectedIndex>=0) return e.options[e.selectedIndex].text;
    return e.value.trim();
  }
  function buildReview(){
    var box=document.getElementById('review-list'); if(!box) return;
    var rows=[
      ['Position',fieldVal('position')||'(not set)'],
      ['Full name',fieldVal('first_name')+' '+fieldVal('last_name')],
      ['Email',fieldVal('email')],['Phone',fieldVal('phone')],
      ['Gender',fieldVal('gender')||'—'],['Date of birth',fieldVal('dob')||'—'],['Age',fieldVal('age')||'—'],
      ['Location',fieldVal('location')||'—'],['LinkedIn',fieldVal('linkedin')||'—'],
      ['Portfolio / website',fieldVal('portfolio')||'—'],['Resume',fieldVal('resume')||'—']
    ];
    var h='';
    rows.forEach(function(r){ h+='<div class="rv-row"><span>'+r[0]+'</span><strong>'+r[1]+'</strong></div>'; });
    box.innerHTML=h;
  }
  function careerSetAge(){
    var dob=document.getElementById('dob'),ageEl=document.getElementById('age'),ageInput=document.getElementById('age-input');
    if(!dob||!ageEl||!dob.value) return;
    var m=dob.value.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/),b=m?new Date(+m[3],+m[1]-1,+m[2]):new Date(dob.value);
    if(isNaN(b.getTime())){ ageEl.value=''; if(ageInput)ageInput.value=''; return; }
    var now=new Date(),age=now.getFullYear()-b.getFullYear(),md=now.getMonth()-b.getMonth();
    if(md<0||(md===0&&now.getDate()<b.getDate())) age--;
    ageEl.value=age<0?0:age; if(ageInput)ageInput.value=ageEl.value;
  }
  window.careerSetAge=careerSetAge;
  function openModal(job,loc,type){
    if(title)title.textContent=job;
    if(meta)meta.textContent=(type?type+' · ':'')+(loc||'Remote')+' position';
    if(posInput)posInput.value=job||'';
    form.reset(); var rn=document.getElementById('resume-name'),fs=document.getElementById('form-status'); if(rn)rn.textContent=''; if(fs)fs.textContent='';
    refreshSteps(); show(0);
    if(modal)modal.classList.add('open'); document.body.style.overflow='hidden';
  }
  function closeModal(){ if(modal)modal.classList.remove('open'); document.body.style.overflow=''; }
  document.querySelectorAll('.apply-btn').forEach(function(btn){
    btn.addEventListener('click',function(e){ e.preventDefault(); openModal(btn.dataset.job,btn.dataset.location,btn.dataset.type); });
  });
  document.querySelectorAll('[data-apply-close]').forEach(function(b){ b.addEventListener('click',closeModal); });
  form.querySelectorAll('.apply-next').forEach(function(b){ b.addEventListener('click',function(){ go(parseInt(b.dataset.go,10)); }); });
  form.querySelectorAll('.apply-back').forEach(function(b){ b.addEventListener('click',function(){ show(parseInt(b.dataset.go,10)); }); });
  var rf=document.getElementById('resume-file');
  if(rf){ rf.addEventListener('change',function(){ var nm=document.getElementById('resume-name'); if(nm) nm.textContent=rf.files.length?('Selected: '+rf.files[0].name):''; }); }
  if(modal){
    modal.addEventListener('click',function(e){ if(e.target===modal) closeModal(); });
    document.addEventListener('keydown',function(e){ if(e.key==='Escape'&&modal.classList.contains('open')) closeModal(); });
  }
  form.addEventListener('submit',function(e){
    e.preventDefault();
    if(!stepValid(2)) return;
    var status=document.getElementById('form-status'),btn=document.getElementById('submit-btn');
    btn.disabled=true; btn.textContent='Submitting...';
    if(status)status.textContent='Uploading your application...';
    var fd=new FormData(form);
    fetch(form.getAttribute('action'),{method:'POST',body:fd})
      .then(function(r){ return r.json().catch(function(){ return {success:false,message:'Unexpected server response.'}; }); })
      .then(function(d){
        if(d&&d.success){
          if(status){ status.textContent='✓ '+d.message; status.style.color='#18b583'; }
          btn.textContent='Submitted ✓';
          setTimeout(function(){ closeModal(); btn.disabled=false; btn.textContent='Submit Application'; },1800);
        }else{
          if(status){ status.textContent=(d&&d.message)||'Something went wrong. Please try again.'; status.style.color='#ff5b5b'; }
          btn.disabled=false; btn.textContent='Submit Application';
        }
      })
      .catch(function(){
        if(status){ status.textContent='Network error. Please try again.'; status.style.color='#ff5b5b'; }
        btn.disabled=false; btn.textContent='Submit Application';
      });
  });
})();
</script>
<style>
  .careers-grid{gap:22px;margin-top:10px}
  .job-card{display:flex;flex-direction:column;padding:26px;border:1px solid var(--line);border-radius:20px;background:linear-gradient(145deg,rgba(255,255,255,.055),rgba(255,255,255,.018));box-shadow:0 18px 50px rgba(0,0,0,.12);transition:.25s}
  .job-card:hover{transform:translateY(-5px);border-color:rgba(122,89,211,.55);box-shadow:0 24px 60px rgba(0,0,0,.22)}
  .job-icon{font-family:Barlow,sans-serif;font-weight:800;font-size:18px;letter-spacing:0}
  .job-meta{display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap}
  .job-badge{padding:5px 11px;border:1px solid rgba(122,89,211,.45);border-radius:999px;color:var(--cyan);font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em}
  .job-card h3{font-size:1.5rem;margin:2px 0 10px}
  .job-tags{list-style:none;padding:0;margin:14px 0 22px;display:flex;flex-wrap:wrap;gap:8px}
  .job-tags li{padding:6px 12px;border:1px solid var(--line);border-radius:999px;color:var(--muted);font-size:.76rem;font-weight:600}
  .job-card .btn{margin-top:auto}
  .apply-popup-card{grid-template-columns:1fr!important;max-height:92vh;overflow:auto}
  .apply-popup-card .query-popup-content{display:block}
  .apply-form{padding:6px 0 0}
  .apply-form .form-field{font-size:.86rem}
  .apply-form h3{margin:6px 0 14px;font-size:1.25rem}
  .apply-row{display:grid;grid-template-columns:1fr 1fr;gap:0 16px}
  .apply-row .form-field{min-width:0}
  .hint{display:block;font-size:.7rem;color:var(--muted);font-weight:600;margin-top:2px}
  .review-list{display:grid;gap:8px;margin-bottom:16px}
  .rv-row{display:flex;justify-content:space-between;gap:14px;padding:10px 14px;border:1px solid var(--line);border-radius:12px;background:rgba(255,255,255,.03);font-size:.86rem}
  .rv-row span{color:var(--muted)}
  .rv-row strong{color:var(--text);text-align:right;word-break:break-word}
  .review-ok{display:flex!important;flex-direction:row!important;align-items:center!important;gap:10px!important;font-size:.86rem!important;font-weight:600!important;color:var(--muted)!important}
  .review-ok input{width:auto!important;min-height:auto!important;flex:none!important}
  .apply-note{margin:14px 0 0}
  #resume-name{color:var(--cyan);font-size:.82rem}
  @media(max-width:560px){.apply-row{grid-template-columns:1fr}}
  /* Light-mode fixes for apply popup & career cards */
  body.light .query-popup-card .form-card label,
  body.light .query-popup-card .form-field{color:var(--text)!important}
  body.light .query-popup-card .form-note{color:var(--muted)!important}
  body.light .apply-popup-card .query-popup-close{color:var(--text)!important;border-color:var(--line)!important;background:transparent!important}
  body.light .apply-popup-card .eyebrow{color:var(--cyan)!important}
  body.light .job-badge{color:#7a59d3!important;border-color:rgba(122,89,211,.45)!important;background:rgba(122,89,211,.06)!important}
  body.light .job-tags li{color:#4d5871!important}
  body.light .rv-row span{color:#5e677c!important}
  body.light .rv-row strong{color:#0b1023!important}
</style>
<?php include 'includes/footer.php'; ?>
