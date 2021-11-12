import '../scss/laraberg.scss'

import {
  Editor,
  initializeEditor,
  registerBlockType
} from '@mauricewijnia/block-editor'

const init = (target, options = {}) => {
  let element = document.getElementById(target)

  if (!element) {
    element = document.querySelector(target)
  }

  if (!element) {
    element = target
  }

  initializeEditor(element)
}

export {
  Editor,
  init,
  initializeEditor,
  registerBlockType
}
