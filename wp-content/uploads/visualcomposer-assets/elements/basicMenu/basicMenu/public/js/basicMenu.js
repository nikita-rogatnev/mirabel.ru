(function () {
  vcv.on('basicMenuReady', function() {
    var menuTypeSandwich = document.querySelectorAll("[data-vce-basic-menu]");
    menuTypeSandwich = [].slice.call(menuTypeSandwich);
    if (menuTypeSandwich && menuTypeSandwich.length) {
      menuTypeSandwich.forEach(function (menu) {
        new window.vcvBasicMenu({
          menu: menu
        });
      })
    }
  });

  vcv.on('ready', function () {
    vcv.trigger('basicMenuReady');
  });
})();

