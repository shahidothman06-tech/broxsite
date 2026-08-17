(function () {
  var menuBtn = document.getElementById('mobile-menu-toggle');
  var menu = document.getElementById('mobile-menu');
  if (menuBtn && menu) {
    menuBtn.addEventListener('click', function () {
      menu.classList.toggle('hidden');
    });
  }
})();
