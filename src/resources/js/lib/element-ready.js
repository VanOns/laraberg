/**
 * Returns a promise that resolves when an element with a selector appears on the page for the first time.
 * Note: Use elementReadyRAF if this is too slow or unreliable.
 * @param {String} selector querySelector string
 */
export function elementReady (selector) {
  return new Promise((resolve, reject) => {
    const observer = new MutationObserver((mutations) => {
      const elements = document.querySelectorAll(selector)
      elements.forEach(element => {
        if (!element.ready) {
          element.ready = true
          observer.disconnect()
          resolve(element)
        }
      })
    })
    observer.observe(document.documentElement, { childList: true, subtree: true })
  })
}

/**
 * Calls the callback function whenever an element with the selector gets rendered
 * @param {String} selector querySelector string
 * @param {function} callback function to fire when an element gets rendered
 * @returns {MutationObserver} the object that checks for the elements
 */
export function elementRendered (selector, callback) {
  const renderedElements = []
  const observer = new MutationObserver((mutations) => {
    const elements = document.querySelectorAll(selector)
    elements.forEach(element => {
      if (!renderedElements.includes(element)) {
        renderedElements.push(element)
        callback(element)
      }
    })
  })
  observer.observe(document.documentElement, { childList: true, subtree: true })
  return observer
}

/**
 * Returns a promise that resolves when an element with a selector appears on the page for the first time.
 * Functions similarly to elementReady, but instead of using mutation observers we poll on every animation frame.
 * This means that it usually responds faster at the cost of some performance while the function is running.
 * @param {String} selector querySelector string
 */
export async function elementReadyRAF (selector) {
  let element
  while (element == null) {
    element = document.querySelector(selector)
    await rafAsync()
  }
  return Promise.resolve(element)
}

function rafAsync () {
  return new Promise(resolve => {
    window.requestAnimationFrame(resolve)
  })
}
