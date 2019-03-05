import { elementReady } from './elements-ready'
import elementAppears from './element-appears'

export default async function setupLaravelFilemanager () {
  elementAppears('.editor-media-placeholder', mediaEditor => {
    let lfmButton = document.createElement('button')
    lfmButton.innerHTML = 'File Manager'
    lfmButton.classList.add('components-button', 'editor-media-placeholder__button', 'is-button', 'is-default', 'is-large')
    lfmButton.type = 'button'
    lfmButton.addEventListener('click', lfmListener)
    let fileUpload = mediaEditor.querySelector('.components-form-file-upload')
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
  let block = event.target.parentNode.parentNode.parentNode
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
  let urlButton = element.querySelector('.editor-media-placeholder__url-input-container').querySelector('button')
  fireEvent(urlButton, 'click')
  let formSelector = '.editor-media-placeholder__url-input-form'
  await elementReady(formSelector)
  let urlForm = document.querySelector(formSelector)
  let urlInput = urlForm.querySelector('input')
  urlInput.setAttribute('value', url)
  fireEvent(urlInput, 'change')
  // TODO: Click submit button
}
