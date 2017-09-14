window.isReady(function () {
  'use strict'
  Array.prototype.forEach.call(
    document.getElementsByClassName('menu-button'),
    function (menuButton) {
      menuButton.addEventListener(
        'click',
        function (event) {
          document.getElementById(
            event.currentTarget.dataset.target
          ).classList.toggle('show')
        }
      )
    }
  )
})
