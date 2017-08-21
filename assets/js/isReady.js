(function () {
  'use strict'

  var callbacks = []

  function execCb () {
    var length = callbacks.length
    for (var i = 0; i < length; ++i) callbacks[i].call(window)
    callbacks = null
  }

  function domIsReady () {
    document.removeEventListener('DOMContentLoaded', domIsReady)
    window.removeEventListener('load', domIsReady)
    execCb()
  }

  function isReady (cb) {
    if (callbacks === null) window.setTimeout(cb)
    else callbacks.push(cb)
  }

  function init () {
    var document = window.document

    if (
      document.readyState === 'complete' ||
      (
        document.readyState !== 'loading' &&
        !document.documentElement.doScroll
      )
    ) {
      window.setTimeout(domIsReady)
    } else {
      document.addEventListener('DOMContentLoaded', domIsReady)
      window.addEventListener('load', domIsReady)
    }
  }

  window['init'] = init
  window['isReady'] = isReady
})()
