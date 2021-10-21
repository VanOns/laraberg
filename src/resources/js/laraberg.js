import '../scss/laraberg.scss'

import { initializeEditor } from '@mauricewijnia/block-editor'

export const init = (target, options = {}) => {
  let element = document.getElementById(target)

  if (!element) {
    element = document.querySelector(target)
  }

  if (!element) {
    element = target
  }

  initializeEditor(element)
}
