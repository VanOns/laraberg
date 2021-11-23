import '../scss/laraberg.scss'

import { Editor, initializeEditor, registerBlockType } from '@mauricewijnia/block-editor'
import defaultSettings from './default-settings'

const init = (target, settings = {}) => {
  let element = document.getElementById(target)

  if (!element) {
    element = document.querySelector(target)
  }

  if (!element) {
    element = target
  }

  initializeEditor(element, { ...defaultSettings, ...settings })
}

export {
  Editor,
  init,
  registerBlockType
}
