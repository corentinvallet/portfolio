<script>
(function(){
  var btn = document.querySelector('.nav-toggle');
  var menu = document.querySelector('nav ul');
  if(!btn || !menu) return;
  function closeMenu(){
    menu.classList.remove('is-open');
    btn.classList.remove('is-open');
    btn.setAttribute('aria-expanded','false');
  }
  btn.addEventListener('click', function(){
    var open = menu.classList.toggle('is-open');
    btn.classList.toggle('is-open', open);
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  menu.querySelectorAll('a').forEach(function(link){
    link.addEventListener('click', closeMenu);
  });
  window.addEventListener('resize', function(){
    if(window.innerWidth > 860){ closeMenu(); }
  });
})();
</script>
