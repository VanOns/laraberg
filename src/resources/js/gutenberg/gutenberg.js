// Gutenberg imports
import './settings'

// Importing domReady and editPost modules
import { domReady, editPost } from '@frontkom/gutenberg-js';

// Gutenberg JS Style
import '@frontkom/gutenberg-js/build/css/block-library/style.css';
import '@frontkom/gutenberg-js/build/css/style.css';

// DOM element id where editor will be displayed
const target = 'laraberg-editor';

// Post properties
const postType = 'page'; // or 'post'
const postId = 1; // Only matters if we want to do saves through API calls

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
  canPublish: true,   // to disable the Editor Publish feature (default: true)
  canSave: true,      // to disable the Editor Save feature (default: true)
  mediaLibrary: false, // to disable the Media Library feature (default: true)
};

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

//Initializing the editor!
window._wpLoadGutenbergEditor = new Promise(function (resolve) {
  domReady(function () {
    resolve(editPost.initializeEditor(target, postType, postId, editorSettings, overridePost))
  })
})

//Load reusable blocks

