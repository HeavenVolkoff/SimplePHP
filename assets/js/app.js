window.isReadyDOM(
  function () {
    'use strict'

    Promise.all([
      window.retrieveComponent('post', { limit: 10 }).then(function (fragment) {
        document.getElementById('posts-container').appendChild(fragment)
      })
    ]).then(function () {
      document.getElementById('main').classList.remove('loading')
    }).catch(console.error)
  }
)
