let appearedElements = []

export default function elementAppears (selector, callback) {
  return checkElement(selector, callback)
}

async function checkElement (selector, callback) {
  let element
  while (element == null) {
    let elements = document.querySelectorAll(selector)
    elements.forEach((el) => {
      if (!appearedElements.includes(el)) {
        element = el
        return element
      }
    })
    await rafAsync()
  }
  appearedElements.push(element)
  checkElement(selector, callback)
  callback(element)
}

function rafAsync () {
  return new Promise(resolve => {
    window.requestAnimationFrame(resolve)
  })
}
