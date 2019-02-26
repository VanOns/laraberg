import { domReady, editPost, data } from '@frontkom/gutenberg-js'
import { editorSettings, overridePost } from './settings'
import { pageData } from './mock-data'

/**
 * Makes sure the textarea value gets set to editor content on submit
 * @param {string} target the textarea to set the value of
 */
function setupSubmit (target) {
  clearSubmitFromButtons()
  const textarea = document.getElementById(target)
  textarea.form.addEventListener('submit', () => {
    textarea.value = data.select('core/editor').getEditedPostContent()
    console.log(textarea.value)
  })
}

function clearSubmitFromButtons () {
  // Set all button types in the editor to 'button' to prevent submitting the form
  let buttonsExist = setInterval(() => {
    let buttons = document.getElementById('laraberg__editor').getElementsByTagName('button')
    if (buttons.length > 0) {
      Array.from(buttons).forEach(button => {
        // Call this method on every button click in the editor
        // since opening and closing the settings menu
        // will rerender the buttons and remove their type
        button.addEventListener('click', clearSubmitFromButtons)
        button.type = 'button'
      })
      clearInterval(buttonsExist)
    }
  }, 100)
}

/**
 * Initialize the Gutenberg editor
 * @param {string} target the element ID to render the gutenberg editor in
 */
export default function initGutenberg (target) {
  // Initializing the editor!
  window._wpLoadGutenbergEditor = new Promise(function (resolve) {
    domReady(() => {
      let element = document.getElementById(target)
      // Set editor content to element's value
      if (element.value.length > 0) {
        pageData.setContent(element.value)
      }
      // Create Gutenberg container element and insert at place of target
      let larabergEditor = document.createElement('DIV')
      larabergEditor.id = 'laraberg__editor'
      larabergEditor.classList.add('laraberg__editor', 'gutenberg__editor', 'block-editor__container')
      element.parentNode.insertBefore(larabergEditor, element)
      element.hidden = true

      resolve(editPost.initializeEditor('laraberg__editor', 'page', 0, editorSettings, overridePost))
    })
    domReady(() => {
      setupSubmit(target)
    })
  })
}
