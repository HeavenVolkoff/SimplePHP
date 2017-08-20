((window) => {
  'use strict'
  /**
   * @type {?Array}
   */
  let callbacks = []

  function execCb () {
    const length = callbacks.length
    for (let i = 0; i < length; ++i) callbacks[i].call(window, window)
    callbacks = null
  }

  function domIsReady () {
    document.removeEventListener('DOMContentLoaded', domIsReady)
    window.removeEventListener('load', domIsReady)
    isReady()
  }

  /**
   * @param {function()=} cb
   */
  function isReady (cb) {
    if (arguments.length === 0) return execCb()

    if (callbacks === null) cb()
    else callbacks.push(cb)
  }

  function init () {
    const document = window.document

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

  window['isReady'] = isReady
  window['init'] = init
})(typeof window === 'object' ? window : this)
