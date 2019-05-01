import addQueryArgs from './add-query-args'
import apiFetch from '../api/api-fetch'

window.wp = {
  apiFetch,
  url: { addQueryArgs }
}

window.userSettings = {
  uid: 2 // Among other things, this uid is used to identify and store editor user preferences in localStorage
}

// set your root path
window.wpApiSettings = {
  root: '/'
}

// Some editor settings
export const editorSettings = {
  target: null,
  alignWide: true,
  availableTemplates: [],
  allowedBlockTypes: true,
  disableCustomColors: false,
  disablePostFormats: false,
  mediaLibrary: false,
  titlePlaceholder: 'Add title',
  bodyPlaceholder: 'Write your story',
  isRTL: false,
  postLock: {
    isLocked: false
  },
  autosaveInterval: 10,
  canAutosave: false, // to disable Editor Autosave featured (default: true)
  canPublish: false, // to disable Editor Publish featured (default: true)
  canSave: false // to disable Editor Save featured (default: true)    };
}

// Post properties to override
export const overridePost = {}
