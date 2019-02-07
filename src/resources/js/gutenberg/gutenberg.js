// Gutenberg imports
import './settings'

// Importing domReady and editPost modules
import { domReady, editPost } from '@frontkom/gutenberg-js';

// Don't forget to import the style
import '@frontkom/gutenberg-js/build/css/block-library/style.css';
import '@frontkom/gutenberg-js/build/css/style.css';

// DOM element id where editor will be displayed
const target = 'laraberg-editor';

// Post properties
const postType = 'post'; // or 'page'
const postId = 123;

// Some editor settings
const settings = {
  alignWide: true,
  availableTemplates: [],
  allowedBlockTypes: true,
  disableCustomColors: false,
  disableCustomFontSizes: false,
  disablePostFormats: false,
  titlePlaceholder: "Add title",
  bodyPlaceholder: "Write your story",
  isRTL: false,
  autosaveInterval: 10,
  styles: [],
  postLock: {
      isLocked: false,
  },
  // @frontkom/gutenberg-js settings
  canAutosave: false,  // to disable the Editor Autosave feature (default: true)
  canPublish: false,   // to disable the Editor Publish feature (default: true)
  canSave: false,      // to disable the Editor Save feature (default: true)
  mediaLibrary: false, // to disable the Media Library feature (default: true)
};

// Post properties to override
const overridePost = {};

//Initializing the editor!
window._wpLoadGutenbergEditor = new Promise(function (resolve) {
  domReady(function () {
      resolve(editPost.initializeEditor(target, postType, postId, settings, overridePost))
  })
})
