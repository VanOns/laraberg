import { elementRendered } from './element-ready'
import { clearSubmitFromButtons } from './configure-editor'

const { hooks } = window.wp
const actionNamespace = 'laraberg'

export const actions = {
  openSidebar: {
    name: 'LB_OPEN_SIDEBAR',
    callback: clearSubmitFromButtons
  }
}

export default function setupActions () {
  Object.keys(actions).forEach(key => {
    const action = actions[key]
    hooks.addAction(action.name, actionNamespace, action.callback)
  })
  setupOpenSidebar()
}

function setupOpenSidebar () {
  elementRendered('.edit-post-sidebar', () => {
    hooks.doAction(actions.openSidebar.name)
  })
}
