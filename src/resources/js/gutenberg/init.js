import { configureAPI } from '../api/api-fetch'
import configureEditor, { clearSubmitFromButtons } from '../lib/configure-editor'
import { editorSettings, overridePost } from './settings'
import { elementReady } from '../lib/element-ready'

const { data, domReady, editPost } = window.wp

/**
 * Initialize the Gutenberg editor
 * @param {string} target the element ID to render the gutenberg editor in
 */
export default function init (target, options = {}) {
  configureAPI(options)

  // Disable publish sidebar
  data.dispatch('core/editor').disablePublishSidebar()

  // Disable tips
  data.dispatch('core/nux').disableTips()

  window._wpLoadGutenbergEditor = new Promise(function (resolve) {
    domReady(async () => {
      const larabergEditor = createEditorElement(target)
      try {
        resolve(editPost.initializeEditor(larabergEditor.id, 'page', 1, editorSettings, overridePost))
      } catch (error) {
        console.error(error)
      }
      await elementReady('.edit-post-layout')
      configureEditor(options)
    })
  })
}

/**
 * Creates the element to render the Gutenberg editor inside of
 * @param {string} target the id of the textarea to render the Editor instead of
 * @return {element}
 */
function createEditorElement (target) {
  const element = document.getElementById(target)
  const editor = document.createElement('DIV')
  editor.id = 'laraberg__editor'
  editor.classList.add('laraberg__editor', 'gutenberg__editor', 'block-editor__container', 'wp-embed-responsive')
  element.parentNode.insertBefore(editor, element)
  element.hidden = true

  editorSettings.target = target
  window.Laraberg.editor = editor

  return editor
}
