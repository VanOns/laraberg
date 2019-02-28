
import 'babel-polyfill'

// Gutenberg imports
import './gutenberg/settings'
import initGutenberg from './gutenberg/init-gutenberg'

import './../scss/laraberg.scss'

window.Laraberg = {
  initGutenberg: initGutenberg,
  editor: null
}
