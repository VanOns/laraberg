import { elementReadyRAF, elementRendered } from './element-ready'

let lfmOptions
/**
 * Insert the 'File Manager' button whenever a mediablock appears
 */
export default async function setupLaravelFilemanager (options) {
  lfmOptions = options
  elementRendered('.editor-media-placeholder', (mediaEditor) => {
    const lfmButton = document.createElement('button')
    lfmButton.innerHTML = 'File Manager'
    lfmButton.classList.add('components-button', 'editor-media-placeholder__button', 'is-button', 'is-default', 'is-large')
    lfmButton.type = 'button'
    lfmButton.addEventListener('click', lfmListener)
    const fileUpload = mediaEditor.querySelector('.components-form-file-upload')
    fileUpload.parentNode.insertBefore(lfmButton, fileUpload.nextSibling)
  })
}

/**
 * Event listener for the File Manager button
 * @param {Event} event
 */
function lfmListener (event) {
  const block = event.target.parentNode.parentNode.parentNode

  let options = {}
  if (block.querySelector('.wp-block-image') !== null) {
    options.type = 'Images'
  } else {
    options.type = 'Files'
  }
  if (lfmOptions.prefix) { options.prefix = lfmOptions.prefix }

  openFilemanager(options, (url, path) => {
    insertMedia(block, url)
  })
}

/**
 * Opens a window with Laravel Filemanager
 * @param {Object} options
 * @param {function} cb
 */
function openFilemanager (options, cb) {
  let routePrefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager'
  window.open(routePrefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600')
  window.SetUrl = cb
}

/**
 * Inserts the media object into the media block
 * This is done by putting the URL into the 'Insert from URL' field and submitting the field
 * @param {Element} block the media block to insert the media into
 * @param {*} url the URL of the media
 */
async function insertMedia (block, url) {
  const urlButton = block.querySelector('.editor-media-placeholder__url-input-container').querySelector('button')
  urlButton.click()
  const formSelector = '.editor-media-placeholder__url-input-form'
  await elementReadyRAF(formSelector)
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

/**
 * Fires an event for the provided element
 * @param {Element} el the element to fire the event on
 * @param {String} etype the event type, eg: 'change', 'click', etc...
 */
function fireEvent (el, etype) {
  if (el.fireEvent) {
    el.fireEvent('on' + etype)
  } else {
    const evObj = document.createEvent('Events')
    evObj.initEvent(etype, true, false)
    el.dispatchEvent(evObj)
  }
}
