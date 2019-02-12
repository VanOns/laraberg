import { domReady, editPost, data } from '@frontkom/gutenberg-js';
import { postPage, putPage, newPage } from './api-fetch';

window.test = data

function setupSubmit(isNew) {
  let buttonContainer
  let settingsButton
  let headerExists = setInterval(() => {
    buttonContainer = document.getElementsByClassName('edit-post-header__settings')[0]
    settingsButton = document.getElementsByClassName('dashicons-admin-generic')[0].parentNode.parentNode
    if(settingsButton && buttonContainer) {
      let button = document.createElement('div')
      button.innerHTML = `<button id="submit-page-button" class="components-button editor-post-publish-button is-button is-default is-primary is-large">Save</button>`
      if (isNew) {
        button.addEventListener('click', submitPage)
      } else {
        button.addEventListener('click', data.dispatch('core/editor').savePost)
      }
      buttonContainer.append(button)
      clearInterval(headerExists)
    }
  }, 100)
}

function submitPage(event) {
  event.target.disabled = true
  const content = data.select('core/editor').getEditedPostContent()
  const title = data.select('core/editor').getEditedPostAttribute('title')
  postPage({data: { content: content, title: title }})
    .then(data => window.location.href = `/laraberg/ui/pages/${data.id}`)
    .catch(() => event.target.disabled = false)
}

function updatePage(event, pageId) {
  event.target.disabled = true
  const content = data.select('core/editor').getEditedPostContent()
  const title = data.select('core/editor').getEditedPostAttribute('title')
  putPage({ data: { content: content, title: title }, id: pageId })
    .then(data => window.location.href = `/laraberg/ui/pages/${pageId}`)
    .catch(() => event.target.disabled = false)
}

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
  canSave: true,     // to disable Editor Save featured (default: true)    };
};

// Post properties to override
const overridePost = {};

function attach(target, postId, isNew) {
  //Initializing the editor!
  window._wpLoadGutenbergEditor = new Promise(function (resolve) {
    domReady(function () {
      resolve(editPost.initializeEditor(target, 'page', postId, editorSettings, overridePost))
    })
    domReady(() => {
      setupSubmit(isNew)
    })
  })
}

/**
 * Initialize the Gutenberg editor
 * @param {string} target the element ID to render the gutenberg editor in 
 */
export default function initGutenberg(target, pageId) {
  if (!pageId) {
    editorSettings.canSave = false
    attach(target, 0, true)
  } else {
    attach(target, pageId)
  }
}