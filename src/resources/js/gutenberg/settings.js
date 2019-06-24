// import addQueryArgs from './add-query-args'
import apiFetch from '../api/api-fetch'

window.userSettings = {
  secure: '',
  time: 1234567,
  uid: 1
}

// set your root path
window.wpApiSettings = {
  root: window.location.origin,
  nonce: '1234567890',
  versionString: ''
}

const {
  use,
  createNonceMiddleware,
  createRootURLMiddleware,
  setFetchHandler
} = window.wp.apiFetch

use(createNonceMiddleware(window.wpApiSettings.nonce))
use(createRootURLMiddleware(window.wpApiSettings.root))
setFetchHandler(apiFetch)

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
  autosaveInterval: 9999
}

// Post properties to override
export const overridePost = {}
