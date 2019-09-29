(function() {
  window.vcvBasicMenu = function (options) {
    this.menu = options.menu;
    if (!this.menu) {
      return;
    }
    var resizeElement = this.menu.querySelector('.vce-basic-menu');
    var resizeHelperContainer = this.menu.querySelector('.vce-basic-menu-resize-helper-container');

    if (resizeHelperContainer) {
      resizeElement = resizeHelperContainer;
    }

    if (this.menu.getAttribute('data-vce-basic-menu-to-sandwich') === 'false') {
      this.menu.removeAttribute('data-vcv-basic-menu-collapsed');
      removeResizeListener(resizeElement, handleMenuSize.bind(this));
      return;
    }
    addResizeListener(resizeElement, handleMenuSize.bind(this));
    handleMenuSize.call(this)
  };

  function removeResizeListener (element, fn) {
    if (element && element.__resizeTrigger__) {
      element.__resizeTrigger__.contentDocument.defaultView.removeEventListener('resize', fn)
      element.__resizeTrigger__ = !element.removeChild(element.__resizeTrigger__)
    }
  }

  function addResizeListener (element, fn) {
    if (element.querySelector('.vce-basic-menu-resize-helper')) {
      return;
    }
    var isIE = !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/Edge/));
    if (window.getComputedStyle(element).position === 'static') {
      element.style.position = 'relative';
    }
    var obj = element.__resizeTrigger__ = document.createElement('iframe');
    obj.setAttribute('style', 'display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%; overflow: hidden; opacity: 0; pointer-events: none; z-index: -1;');
    obj.classList.add('vce-basic-menu-resize-helper');
    obj.__resizeElement__ = element;
    obj.onload = function () {
      obj.contentDocument.defaultView.addEventListener('resize', fn);
    };
    obj.type = 'text/html';
    if (isIE) {
      element.appendChild(obj);
    }
    obj.data = 'about:blank';
    if (!isIE) {
      element.appendChild(obj);
    }
  }

  function handleMenuSize () {
    var menu = this.menu;
    var menuWrapper = menu.querySelector('.vce-basic-menu-wrapper');
    var items = menu.querySelectorAll('.vce-basic-menu nav > ul > li');
    var menuRect = menuWrapper.getBoundingClientRect();
    var itemsWidth = 0;

    var sandwichMenuContainer = menu.querySelector('.vce-sandwich-menu-container');
    if (sandwichMenuContainer && sandwichMenuContainer.getAttribute('data-vcv-sandwich-menu-visible')) {
      return;
    }

    items = [].slice.call(items);
    items.forEach(function (item) {
      var itemRect = item.getBoundingClientRect();
      itemsWidth += itemRect.width;
    });

    if (itemsWidth > menuRect.width) {
      if (menu.getAttribute('data-vcv-basic-menu-collapsed') !== 'true') {
        menu.setAttribute('data-vcv-basic-menu-collapsed', 'true')
      }
    } else {
      if (menu.getAttribute('data-vcv-basic-menu-collapsed') !== 'false') {
        menu.setAttribute('data-vcv-basic-menu-collapsed', 'false')
      }
    }
  }
})();