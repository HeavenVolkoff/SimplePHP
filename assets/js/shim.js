window.isReadyJS(function () {
  'use strict'
  Promise.all = (function () {
    var originalPromiseAll = Promise.all

    function reconstructPromiseAllObject (arr) {
      var i, obj, length, objectKeys

      i = -1
      obj = {}
      objectKeys = arr[0]
      length = objectKeys.length
      while (++i < length) obj[objectKeys[i]] = arr[i + 1]

      return obj
    }

    function promiseAllWithObject (obj) {
      var i, length, objectKeys, objectValues

      objectKeys = Object.keys(obj)
      length = objectKeys.length
      if (length === 0) return Promise.resolve(obj)

      i = -1
      objectValues = new Array(objectKeys.length + 1)
      objectValues[0] = objectKeys
      while (++i < length) objectValues[i + 1] = obj[objectKeys[i]]
      return originalPromiseAll.call(Promise, objectValues).then(reconstructPromiseAllObject)
    }

    return function modifiedPromiseAll (obj) {
      return (
        obj && typeof obj === 'object'
          ? promiseAllWithObject(obj)
          : originalPromiseAll.call(Promise, obj)
      )
    }
  })()
})
