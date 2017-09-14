var sliders = document.querySelectorAll('#sliders li')
var current = 0
var total = sliders.length - 1

window.setInterval(
  function () {
    var index = current ? current - 1 : total

    sliders[index].className = ''
    sliders[current].className = 'slider-active'

    current = current >= total ? 0 : current + 1
  }, 4000)

function scrollToTop (scrollDuration) {
  var scrollStep = -window.scrollY / (scrollDuration / 15)
  var scrollInterval = setInterval(function () {
    if (window.scrollY !== 0) {
      window.scrollBy(0, scrollStep)
    } else {
      clearInterval(scrollInterval)
    }
  }, 15)
}

window.addEventListener('wheel', function () {
  if (window.scrollY >= 300) {
    document.getElementById('btn-up').style.display = 'block'
  } else {
    document.getElementById('btn-up').style.display = 'none'
  }
}, {passive: true})
