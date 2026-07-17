/* ZinCelestial — GamiPress Bar JS */
(function(){
'use strict';
const ZC_GamiPress = {
  init(){
    this.setupBarRefresh();
    this.setupFollowButtons();
    this.bindNotifications();
  },
  setupBarRefresh(){
    const bar = document.querySelector('.zc-gamipress-bar');
    if(!bar || !ZC?.isLoggedIn) return;
    // Refresh bar data every 60 seconds
    setInterval(()=>this.refreshData(bar), 60000);
  },
  refreshData(bar){
    if(!ZC?.ajaxUrl) return;
    fetch(ZC.ajaxUrl+'?action=zc_gamipress_data&nonce='+ZC.nonce+'&user_id='+ZC.userId)
      .then(r=>r.json())
      .then(data=>{
        if(!data.success) return;
        const d = data.data;
        // Update XP bar
        const fill = bar.querySelector('.zc-xp-fill');
        if(fill && d.xp_next>0){
          fill.style.width = Math.min(100,(d.xp/d.xp_next)*100)+'%';
        }
        // Update values
        const updateVal = (cls, val) => {
          const el = bar.querySelector(cls+' .zc-gp-bar__value');
          if(el && val !== undefined) el.textContent = val.toLocaleString();
        };
        updateVal('.zc-gp-bar__gzcreds', d.gzcreds);
        updateVal('.zc-gp-bar__rubies', d.rubies);
        updateVal('.zc-gp-bar__zcreds', d.zcreds);
        updateVal('.zc-gp-bar__level', d.level);
        const rankEl = bar.querySelector('.zc-gp-bar__rank .zc-gp-bar__value');
        if(rankEl && d.rank_label) rankEl.textContent = d.rank_label;
        // XP label
        const xpVal = bar.querySelector('.zc-gp-bar__xp .zc-gp-bar__value');
        if(xpVal && d.xp !== undefined) xpVal.textContent = d.xp.toLocaleString()+' XP';
      }).catch(()=>{});
  },
  setupFollowButtons(){
    document.querySelectorAll('.zc-follow-btn').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        if(!ZC?.isLoggedIn){location.href=ZC.homeUrl+'wp-login.php';return;}
        const targetId = btn.dataset.target;
        const isFollowing = btn.classList.contains('zc-follow-btn--following');
        const action = isFollowing ? 'zc_unfollow_user' : 'zc_follow_user';
        btn.disabled = true;
        fetch(ZC.ajaxUrl, {
          method:'POST',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body:new URLSearchParams({action, nonce:ZC.nonce, target_id:targetId}),
        })
        .then(r=>r.json())
        .then(data=>{
          if(data.success){
            const d = data.data;
            btn.classList.toggle('zc-follow-btn--following', d.following);
            btn.textContent = d.following ? 'Following' : 'Follow';
          }
        })
        .finally(()=>btn.disabled=false);
      });
    });
  },
  bindNotifications(){
    const bell = document.querySelector('.zc-user-nav__notifications');
    if(!bell || !ZC?.isLoggedIn) return;
    // Fetch notification count
    fetch(ZC.ajaxUrl+'?action=zc_get_notifications&nonce='+ZC.nonce)
      .then(r=>r.json())
      .then(data=>{
        if(data.success && Array.isArray(data.data) && data.data.length>0){
          let badge = bell.querySelector('.zc-user-nav__badge');
          if(!badge){ badge=document.createElement('span'); badge.className='zc-user-nav__badge'; bell.appendChild(badge); }
          badge.textContent = data.data.length > 9 ? '9+' : data.data.length;
        }
      }).catch(()=>{});
  },
};
document.addEventListener('DOMContentLoaded', ()=>ZC_GamiPress.init());
window.ZC_GamiPress = ZC_GamiPress;
})();
