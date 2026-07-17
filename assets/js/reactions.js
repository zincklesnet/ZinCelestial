/* ZinCelestial — Animated Reactions JS */
(function(){
'use strict';
const EMOJIS={fire:'🔥',star:'⭐',love:'❤️',wow:'😮',laugh:'😂',sad:'😢',angry:'😠',rocket:'🚀'};
const ZC_Reactions={
  init(){
    this.bindToggles();
    this.bindButtons();
    this.setupOverlays();
    this.bindSchemeSwitcher();
  },
  bindToggles(){
    document.addEventListener('click', e => {
      const toggle = e.target.closest('.zc-reactions__toggle');
      if(toggle){
        e.stopPropagation();
        const container = toggle.closest('.zc-reactions');
        const picker = container?.querySelector('.zc-reactions__picker');
        const isOpen = picker?.classList.contains('zc-reactions__picker--open');
        // Close all other pickers
        document.querySelectorAll('.zc-reactions__picker--open').forEach(p=>p.classList.remove('zc-reactions__picker--open'));
        if(!isOpen) picker?.classList.add('zc-reactions__picker--open');
      } else if(!e.target.closest('.zc-reactions__picker')){
        document.querySelectorAll('.zc-reactions__picker--open').forEach(p=>p.classList.remove('zc-reactions__picker--open'));
      }
    });
  },
  bindButtons(){
    document.addEventListener('click', e => {
      const btn = e.target.closest('.zc-reaction');
      if(!btn) return;
      e.stopPropagation();
      const container = btn.closest('.zc-reactions');
      const postId = container?.dataset.postId;
      const postType = container?.dataset.postType || 'post';
      const type = btn.dataset.type;
      if(!postId || !type) return;
      if(!ZC?.isLoggedIn){
        this.showLoginPrompt(container);
        return;
      }
      this.sendReaction(btn, container, postId, type, postType);
    });
  },
  sendReaction(btn, container, postId, type, postType){
    btn.classList.add('zc-reaction--reacting');
    btn.querySelector('.zc-reaction__emoji')?.classList.add('zc-emoji-bounce');
    this.floatEmoji(btn, EMOJIS[type] || '👍');
    fetch(ZC.ajaxUrl, {
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:new URLSearchParams({action:'zc_react',nonce:ZC.nonce,post_id:postId,type:type,post_type:postType}),
    })
    .then(r=>r.json())
    .then(data=>{
      if(data.success){
        this.updateUI(container, data.data);
        this.updateOverlay(postId, data.data.top);
      }
    })
    .catch(()=>{})
    .finally(()=>{
      setTimeout(()=>btn.classList.remove('zc-reaction--reacting'),400);
    });
  },
  updateUI(container, data){
    // Update active state
    container.querySelectorAll('.zc-reaction').forEach(r=>{
      r.classList.remove('zc-reaction--active');
    });
    if(data.user_reaction){
      container.querySelector('[data-type="'+data.user_reaction+'"]')?.classList.add('zc-reaction--active');
    }
    // Update toggle emoji
    const toggle = container.querySelector('.zc-reactions__icon');
    if(toggle && data.top){
      toggle.textContent = EMOJIS[data.top.type] || '👍';
    }
    // Update counts
    Object.entries(data.reactions||{}).forEach(([type,count])=>{
      const btn = container.querySelector('[data-type="'+type+'"]');
      if(!btn) return;
      let countEl = btn.querySelector('.zc-reaction__count');
      if(!countEl && count>0){
        countEl = document.createElement('span');
        countEl.className='zc-reaction__count';
        btn.appendChild(countEl);
      }
      if(countEl){
        if(count > 0){
          countEl.textContent = count;
          countEl.classList.add('zc-reaction__count--pop');
          setTimeout(()=>countEl.classList.remove('zc-reaction__count--pop'),300);
        } else {
          countEl.remove();
        }
      }
    });
    // Close picker
    container.querySelector('.zc-reactions__picker')?.classList.remove('zc-reactions__picker--open');
  },
  updateOverlay(postId, top){
    if(!top) return;
    // Update any overlay on the page for this post
    document.querySelectorAll('[data-overlay-post="'+postId+'"]').forEach(overlay=>{
      overlay.querySelector('.zc-reaction-overlay__emoji').textContent = EMOJIS[top.type]||'';
      overlay.querySelector('.zc-reaction-overlay__count').textContent = top.count;
      overlay.className = 'zc-reaction-overlay zc-reaction-overlay--'+top.type;
    });
  },
  floatEmoji(btn, emoji){
    const el = document.createElement('span');
    el.textContent = emoji;
    el.style.cssText='position:absolute;pointer-events:none;font-size:1.8rem;z-index:999;top:0;left:50%;transform:translateX(-50%);animation:zc-float-up .8s ease forwards';
    btn.appendChild(el);
    setTimeout(()=>el.remove(),900);
    // Inject keyframes once
    if(!document.getElementById('zc-float-up-kf')){
      const s=document.createElement('style');
      s.id='zc-float-up-kf';
      s.textContent='@keyframes zc-float-up{0%{opacity:1;transform:translateX(-50%) translateY(0) scale(1)}100%{opacity:0;transform:translateX(-50%) translateY(-60px) scale(1.5)}}';
      document.head.appendChild(s);
    }
  },
  showLoginPrompt(container){
    const msg = document.createElement('div');
    msg.className = 'zc-login-prompt';
    msg.innerHTML = '<a href="'+ZC.homeUrl+'wp-login.php">'+('Please log in to react')+'</a>';
    msg.style.cssText='position:absolute;background:var(--zc-card);border:1px solid var(--zc-border);border-radius:8px;padding:.5em 1em;font-size:.8rem;z-index:400;white-space:nowrap;bottom:calc(100% + 8px);left:0;box-shadow:var(--zc-shadow-md)';
    container.style.position='relative';
    container.appendChild(msg);
    setTimeout(()=>msg.remove(),2500);
  },
  setupOverlays(){
    // Trending overlay data-overlay-post attribute setup
    document.querySelectorAll('.zc-reaction-overlay').forEach(overlay=>{
      const article = overlay.closest('[id^="post-"],[id^="activity-"]');
      if(article){
        const id = (article.id.match(/\d+/)||[])[0];
        if(id) overlay.dataset.overlayPost = id;
      }
    });
  },
  bindSchemeSwitcher(){
    const sw = document.getElementById('zc-scheme-switcher');
    if(!sw) return;
    const toggle = sw.querySelector('.zc-scheme-switcher__toggle');
    toggle?.addEventListener('click', ()=>{
      const expanded = toggle.getAttribute('aria-expanded')==='true';
      toggle.setAttribute('aria-expanded', !expanded);
      sw.classList.toggle('zc-scheme-switcher--open', !expanded);
    });
    document.addEventListener('click', e=>{
      if(!e.target.closest('#zc-scheme-switcher')){
        toggle?.setAttribute('aria-expanded','false');
        sw.classList.remove('zc-scheme-switcher--open');
      }
    });
    // Scheme buttons
    sw.querySelectorAll('.zc-scheme-btn').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const scheme = btn.dataset.scheme;
        fetch(ZC.ajaxUrl, {
          method:'POST',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body:new URLSearchParams({action:'zc_save_scheme',nonce:ZC.nonce,scheme}),
        })
        .then(r=>r.json())
        .then(d=>{
          if(d.success) location.reload();
        });
      });
    });
    // Mode toggle
    sw.querySelectorAll('.zc-mode-toggle').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const mode = btn.dataset.mode;
        localStorage.setItem('zc_color_mode',mode);
        document.documentElement.setAttribute('data-zc-mode',mode);
        document.documentElement.className = document.documentElement.className.replace(/zc-mode-\w+/,'') + ' zc-mode-'+mode;
        fetch(ZC.ajaxUrl, {
          method:'POST',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body:new URLSearchParams({action:'zc_save_color_mode',nonce:ZC.nonce,mode}),
        });
        toggle?.setAttribute('aria-expanded','false');
        sw.classList.remove('zc-scheme-switcher--open');
      });
    });
  },
};
document.addEventListener('DOMContentLoaded', ()=>ZC_Reactions.init());
window.ZC_Reactions = ZC_Reactions;
})();
