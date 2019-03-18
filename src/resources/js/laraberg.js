import 'babel-polyfill'

import './../scss/laraberg.scss'

// Gutenberg imports
import './gutenberg/settings'
import getContent from './gutenberg/get-content'
import initGutenberg from './gutenberg/init-gutenberg'

window.Laraberg = {
  initGutenberg: initGutenberg,
  getContent: getContent,
  editor: null
}
