import 'babel-polyfill'

import './../scss/laraberg.scss'

// Gutenberg imports
import './gutenberg/settings'
import initGutenberg from './gutenberg/init-gutenberg'

window.Laraberg = {
  initGutenberg: initGutenberg,
  editor: null
}
