import elementAppears from './element-appears'
import { elementReady } from './elements-ready'

export default async function setupLaravelFilemanager () {
  elementAppears('.editor-media-placeholder', mediaEditor => {
    const lfmButton = document.createElement('button')
    lfmButton.innerHTML = 'File Manager'
    lfmButton.classList.add('components-button', 'editor-media-placeholder__button', 'is-button', 'is-default', 'is-large')
    lfmButton.type = 'button'
    lfmButton.addEventListener('click', lfmListener)
    const fileUpload = mediaEditor.querySelector('.components-form-file-upload')
    fileUpload.parentNode.insertBefore(lfmButton, fileUpload.nextSibling)
  })
}

function fireEvent (el, etype) {
  if (el.fireEvent) {
    el.fireEvent('on' + etype)
  } else {
    var evObj = document.createEvent('Events')
    evObj.initEvent(etype, true, false)
    el.dispatchEvent(evObj)
  }
}

function lfmListener (event) {
  const block = event.target.parentNode.parentNode.parentNode
  console.log(block)
  let type
  if (block.querySelector('.wp-block-image') !== null) {
    type = 'Images'
  } else {
    type = 'Files'
  }
  lfm({ type: type }, (url, path) => {
    insertImage(block, url)
  })
}

function lfm (options, cb) {
  let routePrefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager'
  window.open(routePrefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600')
  window.SetUrl = cb
}

async function insertImage (element, url) {
  const urlButton = element.querySelector('.editor-media-placeholder__url-input-container').querySelector('button')
  urlButton.click()
  const formSelector = '.editor-media-placeholder__url-input-form'
  await elementReady(formSelector)
  const urlForm = document.querySelector(formSelector)
  const urlInput = urlForm.querySelector('input')
  urlInput.value = url
  // For some reason we can not click() the submitButton
  // if we do not add a space and fire the change event on the input
  urlInput.value += ' '
  fireEvent(urlInput, 'change')
  const submitButton = urlForm.querySelector('button')
  submitButton.click()
}
