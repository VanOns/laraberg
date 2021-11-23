import '../scss/laraberg.scss'

import { Editor, initializeEditor, registerBlockType } from '@mauricewijnia/block-editor'
import EditorSettings from "@mauricewijnia/block-editor/dist/interfaces/editor-settings"

import defaultSettings from './default-settings'

const init = (
    target: string|HTMLInputElement|HTMLTextAreaElement,
    settings: EditorSettings = {}
) => {
    let element

    if (typeof target === 'string') {
      element = document.getElementById(target) || document.querySelector(target)
    } else {
      element = target
    }

    initializeEditor(element, { ...defaultSettings, ...settings })
}

export {
  Editor,
  init,
  registerBlockType
}
