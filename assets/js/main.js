(()=>{
  const body=document.body,theme=document.getElementById('theme-toggle'),saved=localStorage.getItem('urd-theme');
  const updateLogos=()=>{document.querySelectorAll('.brand-logo').forEach(img=>{if(!img.src||img.src.includes('darklogo.png')){const base=document.querySelector('base')?.getAttribute('href')||'';img.src=base+'assets/images/urdigilogo.png'}})};
  if(saved!=='dark')body.classList.add('light'); // light is default when no preference saved
  updateLogos();
  theme?.addEventListener('click',()=>{body.classList.toggle('light');localStorage.setItem('urd-theme',body.classList.contains('light')?'light':'dark');updateLogos()});
  const panel=document.getElementById('side-panel'),overlay=document.getElementById('menu-overlay'),trigger=document.getElementById('menu-trigger'),close=document.getElementById('menu-close');
  function setMenu(open){panel?.classList.toggle('open',open);overlay?.classList.toggle('open',open);panel?.setAttribute('aria-hidden',open?'false':'true');trigger?.setAttribute('aria-expanded',open?'true':'false');body.style.overflow=open?'hidden':''}
  trigger?.addEventListener('click',()=>setMenu(true));close?.addEventListener('click',()=>setMenu(false));overlay?.addEventListener('click',()=>setMenu(false));document.addEventListener('keydown',e=>{if(e.key==='Escape')setMenu(false)});panel?.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));
  const io=new IntersectionObserver(entries=>entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');io.unobserve(e.target)}}),{threshold:.12});document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
  document.querySelectorAll('.spotlight-card').forEach(card=>card.addEventListener('pointermove',e=>{const r=card.getBoundingClientRect();card.style.background=`radial-gradient(420px circle at ${e.clientX-r.left}px ${e.clientY-r.top}px,rgba(122,89,211,.12),rgba(255,255,255,.03) 48%)`}));
  document.querySelectorAll('.multi-step').forEach(form=>{
    const steps=[...form.querySelectorAll('.form-step')],dots=[...form.querySelectorAll('.form-progress span')];let index=0;
    const show=n=>{index=Math.max(0,Math.min(n,steps.length-1));steps.forEach((s,i)=>s.classList.toggle('active',i===index));dots.forEach((d,i)=>d.classList.toggle('active',i<=index));window.scrollTo({top:Math.max(0,form.getBoundingClientRect().top+window.scrollY-110),behavior:'smooth'})};
    form.querySelectorAll('.next-step').forEach(btn=>btn.addEventListener('click',()=>{const required=[...steps[index].querySelectorAll('[required]')];for(const field of required){if(!field.reportValidity())return}show(index+1)}));
    form.querySelectorAll('.prev-step').forEach(btn=>btn.addEventListener('click',()=>show(index-1)));
  });
  document.querySelectorAll('form#lead-form').forEach(form=>form.addEventListener('submit',async e=>{
    e.preventDefault();const btn=form.querySelector('[type="submit"]'),status=form.querySelector('#form-status');const original=btn?.textContent||'Submit';if(btn){btn.disabled=true;btn.textContent='Sending...'}
    try{const response=await fetch(form.getAttribute('action')||'/contact-handler.php',{method:'POST',body:new FormData(form)});const data=await response.json();if(data.success){location.href='/thank-you.php';return}throw new Error(data.message||'Please try again.')}catch(error){if(status)status.innerHTML=`<div class="form-alert">${error.message||'Could not send. Please call (666) 399-1245.'}</div>`;if(btn){btn.disabled=false;btn.textContent=original}}
  }));
})();

// Smooth scrolling with a gentle custom delay
(()=>{document.querySelectorAll('a[href^="#"]').forEach(a=>a.addEventListener('click',e=>{const id=a.getAttribute('href');if(!id||id==='#')return;const target=document.querySelector(id);if(!target)return;e.preventDefault();const start=window.scrollY,end=target.getBoundingClientRect().top+start-90,duration=900,t0=performance.now();const ease=t=>t<.5?4*t*t*t:1-Math.pow(-2*t+2,3)/2;function step(now){const p=Math.min(1,(now-t0)/duration);window.scrollTo(0,start+(end-start)*ease(p));if(p<1)requestAnimationFrame(step)}requestAnimationFrame(step)}));
const search=document.getElementById('faq-search'),buttons=[...document.querySelectorAll('[data-faq-category]')],groups=[...document.querySelectorAll('[data-faq-group]')],empty=document.querySelector('.faq-empty');let category='all';function filterFaq(){const q=(search?.value||'').toLowerCase().trim();let visible=0;groups.forEach(g=>{let gv=0;g.querySelectorAll('.faq-item').forEach(item=>{const okCat=category==='all'||g.dataset.faqGroup===category;const okText=!q||(item.dataset.faqText||'').includes(q);item.hidden=!(okCat&&okText);if(!item.hidden){gv++;visible++}});g.hidden=gv===0});if(empty)empty.hidden=visible!==0}search?.addEventListener('input',filterFaq);buttons.forEach(b=>b.addEventListener('click',()=>{buttons.forEach(x=>x.classList.remove('active'));b.classList.add('active');category=b.dataset.faqCategory;filterFaq()}));
if(!localStorage.getItem('urd-query-popup-seen')){setTimeout(()=>{const popup=document.createElement('div');popup.className='query-popup';popup.innerHTML=`<div class="query-popup-card" role="dialog" aria-modal="true" aria-label="Quick project inquiry"><div class="query-popup-visual"></div><div class="query-popup-content"><button class="query-popup-close" aria-label="Close">×</button><div class="eyebrow">Quick inquiry</div><h2>Need an answer today?</h2><p>Tell us what you are working on, or book a focused strategy call with our team.</p><div class="cta-row"><a class="btn btn-primary pulse-cta" href="contact.php">Start an inquiry →</a><a class="btn btn-ghost" href="schedule.php">Schedule a call ↗</a></div><p class="form-note">No pressure. We will point you toward the clearest next step.</p></div></div>`;document.body.appendChild(popup);requestAnimationFrame(()=>popup.classList.add('open'));const close=()=>{popup.classList.remove('open');setTimeout(()=>popup.remove(),450);localStorage.setItem('urd-query-popup-seen','1')};popup.querySelector('.query-popup-close').onclick=close;popup.addEventListener('click',e=>{if(e.target===popup)close()})},10000)}
})();

// Premium carousel, lead-page icons and scroll-linked process progress
(()=>{
  document.querySelectorAll('[data-review-carousel]').forEach(carousel=>{
    const track=carousel.querySelector('.review-track'),slides=[...carousel.querySelectorAll('.google-review')],prev=carousel.querySelector('.carousel-prev'),next=carousel.querySelector('.carousel-next'),dots=carousel.querySelector('.carousel-dots');
    if(!track||!slides.length)return;let page=0,timer;
    const perPage=()=>innerWidth<=700?1:innerWidth<=1024?2:3;
    const total=()=>Math.ceil(slides.length/perPage());
    const drawDots=()=>{dots.innerHTML='';for(let i=0;i<total();i++){const b=document.createElement('button');b.type='button';b.ariaLabel=`Review page ${i+1}`;b.classList.toggle('active',i===page);b.onclick=()=>go(i);dots.appendChild(b)}};
    const go=n=>{page=(n+total())%total();const gap=18;const width=slides[0].getBoundingClientRect().width;track.style.transform=`translateX(-${page*(width+gap)*perPage()}px)`;drawDots()};
    const auto=()=>{clearInterval(timer);timer=setInterval(()=>go(page+1),5000)};
    prev?.addEventListener('click',()=>{go(page-1);auto()});next?.addEventListener('click',()=>{go(page+1);auto()});carousel.addEventListener('mouseenter',()=>clearInterval(timer));carousel.addEventListener('mouseleave',auto);addEventListener('resize',()=>{page=0;go(0)});go(0);auto();
  });

  const leadRoot=document.querySelector('#strategy-call')?.closest('main');
  if(leadRoot){
    const iconSvgs=[`<svg viewBox="0 0 24 24"><path d="M4 5h16v11H7l-3 3V5Z"/><path d="M8 9h8M8 12h5"/></svg>`,`<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l3 2"/></svg>`,`<svg viewBox="0 0 24 24"><path d="M4 6h16M7 3v6m10-6v6M5 10h14v10H5z"/></svg>`,`<svg viewBox="0 0 24 24"><path d="M4 18V9l8-5 8 5v9"/><path d="M8 18v-5h8v5"/></svg>`,`<svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>`];
    leadRoot.querySelectorAll('.card:not(form),.price-card').forEach((card,i)=>{if(!card.querySelector('.lead-svg-icon')){const icon=document.createElement('span');icon.className='lead-svg-icon';icon.innerHTML=iconSvgs[i%iconSvgs.length];card.prepend(icon)}card.classList.add('reveal','visible')});
    leadRoot.querySelectorAll('section').forEach(s=>s.classList.add('lead-premium-section'));
    const steps=[...leadRoot.querySelectorAll('.step')];if(steps.length){const parent=steps[0].parentElement;parent.classList.add('process-scroll-wrap');const bar=document.createElement('div');bar.className='process-progress';bar.innerHTML='<i></i>';parent.prepend(bar);const update=()=>{const r=parent.getBoundingClientRect(),vh=innerHeight;const progress=Math.max(0,Math.min(1,(vh*.65-r.top)/(r.height-vh*.25)));bar.style.setProperty('--progress',`${progress*100}%`);steps.forEach((step,i)=>step.classList.toggle('is-active',progress>=(i/steps.length)&&progress<((i+1)/steps.length)))};addEventListener('scroll',update,{passive:true});update()}
  }

  document.querySelectorAll('.process-grid').forEach(grid=>{grid.classList.add('process-scroll-wrap');const cards=[...grid.children];const bar=document.createElement('div');bar.className='horizontal-process-progress';bar.innerHTML='<i></i>';grid.prepend(bar);const update=()=>{const r=grid.getBoundingClientRect();const p=Math.max(0,Math.min(1,(innerHeight*.72-r.top)/(r.height+innerHeight*.35)));bar.style.setProperty('--progress',`${p*100}%`);cards.forEach((c,i)=>c.classList.toggle('is-active',p>=(i/cards.length)&&p<((i+1)/cards.length)))};addEventListener('scroll',update,{passive:true});update()});
})();
