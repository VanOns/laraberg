import { data } from '@frontkom/gutenberg-js'
import { editorSettings } from '../gutenberg/settings'
import { elementRendered } from './element-ready'
import sidebar from '../sidebar/sidebar'
import setupLaravelFilemanager from '../laravel-filemanager/laravel-filemanager'

/**
 * Configures the editor according to the provided options object
 * @param {Object} options
 */
export default function configureEditor (options) {
  setupMedia(options)
  setupSidebar(options)
  setupSubmit(editorSettings.target)
  removeBlockManagement()
  if (options.maxHeight) { setMaxHeight(options.maxHeight) }
  if (options.minHeight) { setMinHeight(options.minHeight) }
  if (options.height) { setHeight(options.height) }
}

/**
 * Set all editor button types to 'button' to prevent submitting the form
 */
export function clearSubmitFromButtons () {
  let buttons = document.getElementById('laraberg__editor').getElementsByTagName('button')
  if (buttons.length > 0) {
    Array.from(buttons).forEach(button => { button.type = 'button' })
  }
}

/**
 * Sets the max-height style value
 * @param {String} maxHeight css value for max-height
 */
function setMaxHeight (maxHeight) {
  const editor = window.Laraberg.editor
  const editPostLayout = editor.querySelector('.edit-post-layout__content')

  editor.style.maxHeight = maxHeight

  editPostLayout.style.maxHeight = `calc(${maxHeight} - 56px)`
  // editPostLayout.style.overflowY = 'auto'
}

/**
 * Sets the min-height style value
 * @param {String} minHeight css value for min-height
 */
function setMinHeight (minHeight) {
  const editor = window.Laraberg.editor
  editor.style.minHeight = minHeight
}

/**
 * Sets the height style value
 * @param {String} height css value for height
 */
function setHeight (height) {
  const editor = window.Laraberg.editor
  editor.classList.add('fixed-height')
  editor.style.height = height
}

/**
 * Setup media upload capabilities according to provided options
 * @param {Object} options the options object provided on initialization
 */
function setupMedia (options) {
  removeUploadButton()
  if (options.laravelFilemanager) {
    setupLaravelFilemanager(options.laravelFilemanager)
  } else {
    data.dispatch('core/blocks').removeBlockTypes('core/cover')
    data.dispatch('core/blocks').removeBlockTypes('core/gallery')
    data.dispatch('core/blocks').removeBlockTypes('core/media-text')
  }
}

function setupSidebar (options) {
  if (options.sidebar) {
    sidebar()
  }
}

/**
 * Makes sure the textarea value gets set to the editor content on submit
 * @param {string} target the textarea to set the value of
 */
function setupSubmit (target) {
  clearSubmitFromButtons()
  const textarea = document.getElementById(target)
  if (textarea.form) {
    textarea.form.addEventListener('submit', event => {
      textarea.value = data.select('core/editor').getEditedPostContent()
      // Clear content "dirty" state.
      data.dispatch('core/editor').savePost()
      return true
    })
  }
}

/**
 * Removes the default upload button from media blocks
 */
function removeUploadButton () {
  elementRendered('.components-form-file-upload button', element => element.remove())
}

/**
 * Removes block management link in menu
 */
function removeBlockManagement () {
  elementRendered('[aria-label^="Manage All Reusable Blocks"]', element => element.remove())
}
