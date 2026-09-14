<script>
(function(){
  var btn  = document.querySelector('.nav-toggle');
  var menu = document.querySelector('nav > ul');
  if(!btn || !menu) return;

  var subs = [].slice.call(document.querySelectorAll('nav .has-sub'));

  function closeSubs(){
    subs.forEach(function(li){
      li.classList.remove('is-open');
      var t = li.querySelector('.nav-sub-toggle');
      if(t) t.setAttribute('aria-expanded','false');
    });
  }
  function closeMenu(){
    menu.classList.remove('is-open');
    btn.classList.remove('is-open');
    btn.setAttribute('aria-expanded','false');
    closeSubs();
  }

  btn.addEventListener('click', function(){
    var open = menu.classList.toggle('is-open');
    btn.classList.toggle('is-open', open);
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    if(!open) closeSubs();
  });

  /* --- sous-menus (Activités) --- */
  subs.forEach(function(li){
    var toggle = li.querySelector('.nav-sub-toggle');
    if(!toggle) return;
    toggle.addEventListener('click', function(e){
      e.stopPropagation();
      var willOpen = !li.classList.contains('is-open');
      closeSubs();
      li.classList.toggle('is-open', willOpen);
      toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
    });
  });

  /* clic hors du menu : on referme les sous-menus */
  document.addEventListener('click', function(e){
    if(!e.target.closest('nav .has-sub')) closeSubs();
  });

  /* Échap : on referme tout */
  document.addEventListener('keydown', function(e){
    if(e.key !== 'Escape') return;
    var opened = document.querySelector('nav .has-sub.is-open');
    if(opened){
      var t = opened.querySelector('.nav-sub-toggle');
      closeSubs();
      if(t) t.focus();
    } else if(menu.classList.contains('is-open')){
      closeMenu();
      btn.focus();
    }
  });

  menu.querySelectorAll('a').forEach(function(link){
    link.addEventListener('click', closeMenu);
  });

  window.addEventListener('resize', function(){
    if(window.innerWidth > 860){ closeMenu(); }
  });
})();
</script>
