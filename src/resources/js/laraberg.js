// import 'babel-polyfill'

import './../scss/laraberg.scss'

import './gutenberg/imports'
import init from './gutenberg/init'
import getContent from './lib/get-content'
import { registerBlock, registerCategory } from './lib/custom-blocks'

const Laraberg = {
  init: init,
  initGutenberg: init,
  getContent: getContent,
  editor: null,
  registerCategory: registerCategory,
  registerBlock: registerBlock
}

window.Laraberg = Laraberg

export default Laraberg
