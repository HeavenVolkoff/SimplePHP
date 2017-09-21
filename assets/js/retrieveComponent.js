window.isReadyJS(function () {
  'use strict'

  // Global Window cache
  var URL = window['URL']
  var fetch = window['fetch']
  var Headers = window['Headers']

  // Global variables
  var src = document.getElementById('retrieveComponent').src
  var baseURL = src.substring(0, src.lastIndexOf('/') + 1)
  var components = new Map()
  var baseAppURL = baseURL + '../../app/components/'
  var baseComponentURL = baseURL + '../../components/'

  function unsuccessfulRequestError (component) {
    throw new Error(
      'Failed to retrieve/parse component: ' + component.name + '.\n ' +
      'HTML Request (' +
        'Status: ' + component.response.html.status + ', ' +
        'Data: ' + component.html +
      ')\n ' +
      'MODEL Request (' +
        'Status: ' + component.response.model.status + ', ' +
        'Data: ' + component.model +
      ')'
    ) // prettier-ignore
  }

  function parseResponseBody (response) {
    var parsePromise = Promise.all({
      name: response.name,
      html: response.html.text(),
      model: response.model.json(),
      fragment: null,
      response: response
    })

    if (!(response.html.ok && response.model.ok)) {
      parsePromise = parsePromise.then(unsuccessfulRequestError)
    }

    return parsePromise
  }

  function verifyJSON (json) {
    if (typeof json !== 'object') throw new Error('Received invalid JSON')
    if (json.error) throw new Error(json.error)
    return json.data
  }

  function createDocumentFragmentFromHTMLString (html) {
    var range = document.createRange()
    range.selectNode(document.body)
    return range.createContextualFragment(html)
  }

  function assignComponentData (component, cssClass) {
    var i, data, prop, element, elements, schematic, elemLength
    data = component.model.data
    elements = component.fragment.getElementsByClassName(cssClass)
    schematic = component.model.schematics[cssClass]
    elemLength = elements.length

    if (elemLength !== data.length) {
      throw new Error('Mismatched number of elements')
    }

    i = -1
    while (++i < elemLength) {
      element = elements[i]
      for (prop in schematic) {
        if (schematic.hasOwnProperty(prop) && prop in element) {
          element[prop] = data[i][schematic[prop]]
        }
      }
    }

    return component
  }

  function buildComponent (component) {
    component.model = verifyJSON(component.model)
    component.fragment = createDocumentFragmentFromHTMLString(
      component.html.repeat(component.model.data.length)
    )
    return Object.keys(component.model.schematics).reduce(
      assignComponentData,
      component
    )
  }

  function reduceOptsToURLSearchParams (url, entry) {
    url.searchParams.append(entry[0], entry[1])
    return url
  }

  function retrieveComponent (componentName, opts) {
    return Promise.all({
      name: componentName,
      html: components.has(componentName)
        ? components.get(componentName)
        : fetch(baseComponentURL + componentName + '.html', {
          headers: new Headers({ Accept: 'text/html' })
        }),
      model: fetch(
        Object.entries(opts).reduce(
          reduceOptsToURLSearchParams,
          new URL(baseAppURL + componentName)
        ),
        { headers: new Headers({ Accept: 'application/json' }) }
      )
    })
      .then(parseResponseBody)
      .then(buildComponent)
  }

  window['retrieveComponent'] = retrieveComponent
})
