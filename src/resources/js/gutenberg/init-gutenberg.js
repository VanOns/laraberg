import configureEditor, { clearSubmitFromButtons } from './configure-editor'
import { domReady, editPost } from '@frontkom/gutenberg-js'
import { editorSettings, overridePost } from './settings'
import { elementReady } from './element-ready'

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
export default function initGutenberg (target, options) {
  if (!options) { options = {} }
  // Initializing the editor!
  window._wpLoadGutenbergEditor = new Promise(function (resolve) {
    domReady(async () => {
      let element = document.getElementById(target)
      editorSettings.target = target
      // Create Gutenberg container element and insert at place of target
      let larabergEditor = document.createElement('DIV')
      larabergEditor.id = 'laraberg__editor'
      larabergEditor.classList.add('laraberg__editor', 'gutenberg__editor', 'block-editor__container', 'wp-embed-responsive')
      element.parentNode.insertBefore(larabergEditor, element)
      element.hidden = true
      window.Laraberg.editor = larabergEditor

      resolve(editPost.initializeEditor('laraberg__editor', 'page', 0, editorSettings, overridePost))
      await elementReady('.edit-post-layout')
      configureEditor(options)
    })
  })
}
