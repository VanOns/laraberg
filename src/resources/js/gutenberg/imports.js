import * as hooks from 'gutenberg/packages/hooks'
import * as i18n from 'gutenberg/packages/i18n'
import * as url from 'gutenberg/packages/url'
import apiFetch from 'gutenberg/packages/api-fetch'
import * as autop from 'gutenberg/packages/autop'
import * as blob from 'gutenberg/packages/blob'
import * as blockSerializationDefaultParser from 'gutenberg/packages/block-serialization-default-parser'
import * as escapeHtml from 'gutenberg/packages/escape-html'
import * as element from 'gutenberg/packages/element'
import * as isShallowEqual from 'gutenberg/packages/is-shallow-equal'
import * as compose from 'gutenberg/packages/compose'
import * as reduxRoutine from 'gutenberg/packages/redux-routine'
import * as data from 'gutenberg/packages/data'
import * as dom from 'gutenberg/packages/dom'
import * as htmlEntities from 'gutenberg/packages/html-entities'
import * as shortcode from 'gutenberg/packages/shortcode'
import * as blocks from 'gutenberg/packages/blocks'
import * as keycodes from 'gutenberg/packages/keycodes'
import * as richText from 'gutenberg/packages/rich-text'
import * as components from 'gutenberg/packages/components'
import * as coreData from 'gutenberg/packages/core-data'
import * as date from 'gutenberg/packages/date'
import deprecated from 'gutenberg/packages/deprecated'
import * as notices from 'gutenberg/packages/notices'
import * as nux from 'gutenberg/packages/nux'
import * as tokenList from 'gutenberg/packages/token-list'
import * as viewport from 'gutenberg/packages/viewport'
import * as wordcount from 'gutenberg/packages/wordcount'
import * as blockLibrary from 'gutenberg/packages/block-library'
import domReady from 'gutenberg/packages/dom-ready'
import * as plugins from 'gutenberg/packages/plugins'
import * as editPost from 'gutenberg/packages/edit-post'
import * as a11y from 'gutenberg/packages/a11y'
import * as editor from 'gutenberg/packages/editor'
import * as blockEditor from 'gutenberg/packages/block-editor'
import * as annotations from 'gutenberg/packages/annotations'
import * as blockSerializationSpecParser from 'gutenberg/packages/block-serialization-spec-parser'
import * as formatLibrary from 'gutenberg/packages/format-library'
// import * as listReusableBlocks from 'gutenberg/packages/list-reusable-blocks'
import * as priorityQueue from 'gutenberg/packages/priority-queue'
import * as serverSideRender from 'gutenberg/packages/server-side-render'
import * as dataControls from 'gutenberg/packages/data-controls'
import * as mediaUtils from 'gutenberg/packages/media-utils'

const imports = {
  a11y,
  annotations,
  apiFetch,
  autop,
  blob,
  blockEditor,
  blockLibrary,
  blockSerializationDefaultParser,
  blockSerializationSpecParser,
  blocks,
  components,
  compose,
  coreData,
  data,
  dataControls,
  date,
  deprecated,
  dom,
  domReady,
  editPost,
  editor,
  element,
  escapeHtml,
  formatLibrary,
  hooks,
  htmlEntities,
  i18n,
  isShallowEqual,
  keycodes,
  // listReusableBlocks,
  mediaUtils,
  notices,
  nux,
  plugins,
  priorityQueue,
  reduxRoutine,
  richText,
  serverSideRender,
  shortcode,
  tokenList,
  url,
  viewport,
  wordcount
}

window.wp = {
  ...(window.wp || {}),
  ...imports
}

export default imports
