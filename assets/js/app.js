window.isReady(
  function () {
    'use strict'

    var document = window.document

    window.fetch('app/hello', {
      headers: new window.Headers({
        'Accept': 'application/json'
      })
    })
      .then(
        function (response) {
          return response.json()
        }
      )
      .then(
        function (json) {
          if (typeof json === 'object' && json.error) {
            throw new Error(json.error)
          }
        }
      )
      .catch(
        function (error) {
          console.error(error)
        }
      )
  }
)
