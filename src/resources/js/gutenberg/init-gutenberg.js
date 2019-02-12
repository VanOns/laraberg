import { domReady, editPost, data } from '@frontkom/gutenberg-js';
import { postPage, putPage } from './api-fetch';

function setupSubmit(pageId) {
  let buttonContainer
  let headerExists = setInterval(() => {
    buttonContainer = document.getElementsByClassName('edit-post-header__settings')[0]
    if(buttonContainer) {
      let button = document.createElement('div')
      button.innerHTML = `<button id="submit-page-button" class="components-button editor-post-publish-button is-button is-default is-primary is-large">Submit</button>`
      if (pageId) {
        button.addEventListener('click', (event) => updatePage(event, pageId))
      } else {
        button.addEventListener('click', submitPage)
      }

      buttonContainer.prepend(button)
      clearInterval(headerExists)
    }
  }, 100)
}

function submitPage(event) {
  event.target.disabled = true
  const content = data.select('core/editor').getEditedPostContent()
  postPage({data: { content: content }})
    .then(data => window.location.href = `/laraberg/ui/pages`)
    .catch(() => event.target.disabled = false)
}

function updatePage(event, pageId) {
  event.target.disabled = true
  const content = data.select('core/editor').getEditedPostContent()
  putPage({ data: { content: content }, id: pageId })
    .then(data => window.location.href = `/laraberg/ui/pages/${pageId}`)
    .catch(() => event.target.disabled = false)
}

/**
 * Initialize the Gutenberg editor
 * @param {string} target the element ID to render the gutenberg editor in 
 */
export default function initGutenberg(target, pageId) {
  // Some editor settings
  const editorSettings = { 
    alignWide: true,
    availableTemplates: [],
    allowedBlockTypes: true,
    disableCustomColors: false,
    disablePostFormats: false,
    mediaLibrary: false,
    titlePlaceholder: "Add title",
    bodyPlaceholder: "Write your story",
    isRTL: false,
    autosaveInterval: 0,
    canAutosave: false, // to disable Editor Autosave featured (default: true)
    canPublish: false,  // to disable Editor Publish featured (default: true)
    canSave: false,     // to disable Editor Save featured (default: true)    };
  };

  // Post properties to override
  const overridePost = {};

  // Post properties
  const postType = 'page'; // or 'post'
  const postId = pageId || 0
  //const postId = 0

  //Initializing the editor!
  window._wpLoadGutenbergEditor = new Promise(function (resolve) {
    domReady(function () {
      resolve(editPost.initializeEditor(target, postType, postId, editorSettings, overridePost))
    })
    domReady(() => setupSubmit(pageId))
  })
}