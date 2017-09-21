;(function (win, deferred, undef) {
  'use strict'
  var doc = win['document'] || { readyState: 'complete' }

  function wrapper (cb) {
    try {
      cb.call(win)
    } catch (error) {
      console.error(error)
    }
  }

  function execDeferred (type) {
    var i, len, temp

    if (type === 'js') {
      temp = deferred.js
    } else {
      type = 'dom'
      temp = deferred.dom
      win['onload'] = null
      if ('removeEventListener' in doc) {
        doc['removeEventListener']('DOMContentLoaded', execDeferred)
      }
    }

    i = -1
    len = temp.length
    while (++i < len) win.setTimeout(wrapper, 0, temp[i])
    deferred[type] = undef
  }

  function init () {
    execDeferred('js')

    if (
      doc.readyState === 'complete' ||
      (doc.readyState !== 'loading' &&
        doc.documentElement &&
        !doc.documentElement.doScroll)
    ) {
      execDeferred()
    } else {
      win['onload'] = execDeferred
      if ('addEventListener' in doc) {
        doc['addEventListener']('DOMContentLoaded', execDeferred)
      }
    }

    win['init'] = undef
  }

  function isReady (callback, deferred) {
    console.log(arguments)
    if (deferred === undef) win.setTimeout(wrapper, 0, callback)
    else deferred.push(callback)
  }

  win['init'] = init
  win['isReadyJS'] = function (cb) { isReady(cb, deferred.js) } // prettier-ignore
  win['isReadyDOM'] = function (cb) { isReady(cb, deferred.dom) } // prettier-ignore
})(
  (typeof window === 'object' && window) ||
  (typeof self === 'object' && self) || // eslint-disable-line no-undef
    (typeof global === 'object' && global) ||
    this,
  { js: [], dom: [] }
)
