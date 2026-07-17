/* ZinCelestial — Compose Bar JS */
(function(){
'use strict';
const ZC_Compose = {
  init(){
    this.bindTrigger();
    this.bindModal();
  },
  bindTrigger(){
    document.querySelectorAll('.zc-compose-bar__trigger').forEach(trigger=>{
      trigger.addEventListener('click', ()=>this.openModal());
    });
    // Action buttons
    document.querySelectorAll('.zc-compose-bar__action-btn').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const type = btn.dataset.composeType || 'text';
        this.openModal(type);
      });
    });
  },
  openModal(type='text'){
    let modal = document.getElementById('zc-compose-modal-overlay');
    if(!modal){
      modal = this.createModal();
      document.body.appendChild(modal);
    }
    modal.classList.add('zc-modal-overlay--open');
    modal.querySelector('.zc-compose-modal__editor')?.focus();
  },
  createModal(){
    const wrap = document.createElement('div');
    wrap.id = 'zc-compose-modal-overlay';
    wrap.className = 'zc-modal-overlay';
    wrap.innerHTML = `
      <div class="zc-modal zc-compose-modal" role="dialog" aria-modal="true" aria-label="Create post">
        <div class="zc-modal__header">
          <h2 class="zc-modal__title">Create Post</h2>
          <button class="zc-modal__close" aria-label="Close">&#x2715;</button>
        </div>
        <div class="zc-modal__body">
          <div contenteditable="true" class="zc-compose-modal__editor" placeholder="What's on your mind?"></div>
          <div class="zc-compose-modal__toolbar">
            <div class="zc-compose-modal__media-btns">
              <button class="zc-compose-modal__media-btn" data-type="photo">📷 Photo</button>
              <button class="zc-compose-modal__media-btn" data-type="video">🎬 Video</button>
              <button class="zc-compose-modal__media-btn" data-type="gif">GIF</button>
              <button class="zc-compose-modal__media-btn" data-type="link">🔗 Link</button>
            </div>
            <button class="zc-compose-modal__submit">Post</button>
          </div>
        </div>
      </div>`;
    // Close button
    wrap.querySelector('.zc-modal__close').addEventListener('click', ()=>this.closeModal(wrap));
    wrap.addEventListener('click', e=>{ if(e.target===wrap) this.closeModal(wrap); });
    document.addEventListener('keydown', e=>{ if(e.key==='Escape') this.closeModal(wrap); });
    // Submit
    wrap.querySelector('.zc-compose-modal__submit').addEventListener('click', ()=>{
      const editor = wrap.querySelector('.zc-compose-modal__editor');
      const content = editor?.textContent?.trim();
      if(!content) return;
      this.submitPost(content, wrap);
    });
    return wrap;
  },
  closeModal(modal){
    modal?.classList.remove('zc-modal-overlay--open');
  },
  submitPost(content, modal){
    const btn = modal?.querySelector('.zc-compose-modal__submit');
    if(btn){ btn.disabled=true; btn.textContent='Posting...'; }
    // BuddyPress activity post via AJAX
    if(typeof bp !== 'undefined' && bp.ajax){
      fetch(ZC.ajaxUrl, {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:new URLSearchParams({action:'post_update',nonce:ZC.nonce,content,object:'user',item_id:ZC.userId,component:'activity','_wpnonce':ZC.nonce}),
      }).then(r=>r.json()).then(d=>{
        if(d.success||d.data){
          this.closeModal(modal);
          location.reload();
        }
      }).finally(()=>{ if(btn){ btn.disabled=false; btn.textContent='Post'; } });
    } else {
      // Fallback: navigate to BP activity page
      this.closeModal(modal);
    }
  },
};
document.addEventListener('DOMContentLoaded', ()=>ZC_Compose.init());
window.ZC_Compose = ZC_Compose;
})();
