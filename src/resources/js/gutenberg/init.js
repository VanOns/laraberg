import { configureAPI } from '../api/api-fetch'
import configureEditor, { clearSubmitFromButtons } from '../lib/configure-editor'
import { domReady, editPost } from '@frontkom/gutenberg-js'
import { editorSettings, overridePost } from './settings'
import { elementReady } from '../lib/element-ready'

// Setup sidebar events
window.customGutenberg = {
  events: {
    'OPEN_GENERAL_SIDEBAR': async (action, store) => {
      // console.log('OPEN_GENERAL_SIDEBAR', action, store)
      await elementReady('.edit-post-sidebar')
      clearSubmitFromButtons()
    },
    'CLOSE_GENERAL_SIDEBAR': async (action, store) => {
      // console.log('CLOSE_GENERAL_SIDEBAR', action, store)
    }
  }
}

/**
 * Initialize the Gutenberg editor
 * @param {string} target the element ID to render the gutenberg editor in
 */
export default function init (target, options = {}) {
  configureAPI(options)
  window._wpLoadGutenbergEditor = new Promise(function (resolve) {
    domReady(async () => {
      const larabergEditor = createEditorElement(target)
      resolve(editPost.initializeEditor(larabergEditor.id, 'page', 0, editorSettings, overridePost))
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
