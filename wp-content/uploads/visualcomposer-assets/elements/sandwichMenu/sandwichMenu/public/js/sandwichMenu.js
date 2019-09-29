/* eslint-disable */
(function () {
  vcv.on('ready', function () {
    var sandwichMenus = document.querySelectorAll("[data-vce-sandwich-menu]");
    var settings = {
      modalSelector: "[data-vce-sandwich-menu-modal]",
      openSelector: "[data-vce-sandwich-menu-open-button]",
      closeSelector: "[data-vce-sandwich-menu-close-button]",
      activeAttribute: "data-vcv-sandwich-menu-visible"
    };

    sandwichMenus.forEach(function(menu) {
      new window.vcvSandwichModal({
        container: menu
      });
      settings.container = menu
      new window.vcvSandwichModal(settings);
    });
  });
})();
/* eslint-enable */
