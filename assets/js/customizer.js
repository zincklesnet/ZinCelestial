/* ZinCelestial — Customizer Preview JS */
(function($){
'use strict';
if(typeof wp==='undefined'||typeof wp.customize==='undefined') return;
const C = wp.customize;
// Color tokens live preview
const colors=['primary','secondary','accent','success','warning','danger','info','bg','surface','card','border','text'];
colors.forEach(k=>{
  C('color_'+k, v=>v.bind(val=>{
    document.documentElement.style.setProperty('--zc-'+k.replace('_','-'), val);
  }));
});
C('header_height', v=>v.bind(val=>document.documentElement.style.setProperty('--zc-header-h', val+'px')));
C('font_size_base', v=>v.bind(val=>document.documentElement.style.setProperty('font-size', val+'px')));
C('sticky_header', v=>v.bind(val=>{
  document.querySelector('.zc-header')?.classList.toggle('zc-header--sticky', val==='1');
}));
C('show_topbar', v=>v.bind(val=>{
  const tb=document.querySelector('.zc-topbar');
  if(tb) tb.style.display=val==='1'?'':'none';
}));
C('topbar_announcement', v=>v.bind(val=>{
  const el=document.querySelector('.zc-topbar__announcement');
  if(el) el.textContent=val;
}));
C('footer_copyright', v=>v.bind(val=>{
  const el=document.querySelector('.zc-footer-copyright');
  if(el) el.innerHTML=val;
}));
})(jQuery);
