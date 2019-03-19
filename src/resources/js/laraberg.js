import 'babel-polyfill'

import './../scss/laraberg.scss'

// Gutenberg imports
import './gutenberg/settings'
import { registerBlock, registerCategory } from './gutenberg/custom-blocks'
import getContent from './gutenberg/get-content'
import initGutenberg from './gutenberg/init-gutenberg'

const Laraberg = {
  initGutenberg: initGutenberg,
  getContent: getContent,
  editor: null,
  registerCategory: registerCategory,
  registerBlock: registerBlock
}

window.Laraberg = Laraberg

export default Laraberg
