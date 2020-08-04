import * as hooks from '../../../../vendor/wordpress/gutenberg/build/hooks'
import * as i18n from '../../../../vendor/wordpress/gutenberg/build/i18n'
import * as url from '../../../../vendor/wordpress/gutenberg/build/url'
import * as apiFetch from '../../../../vendor/wordpress/gutenberg/build/api-fetch'
import * as autop from '../../../../vendor/wordpress/gutenberg/build/autop'
import * as blob from '../../../../vendor/wordpress/gutenberg/build/blob'
import * as blockSerializationDefaultParser from '../../../../vendor/wordpress/gutenberg/build/block-serialization-default-parser'
import * as escapeHtml from '../../../../vendor/wordpress/gutenberg/build/escape-html'
import * as element from '../../../../vendor/wordpress/gutenberg/build/element'
import * as isShallowEqual from '../../../../vendor/wordpress/gutenberg/build/is-shallow-equal'
import * as compose from '../../../../vendor/wordpress/gutenberg/build/compose'
import * as reduxRoutine from '../../../../vendor/wordpress/gutenberg/build/redux-routine'
import * as data from '../../../../vendor/wordpress/gutenberg/build/data'
import * as dom from '../../../../vendor/wordpress/gutenberg/build/dom'
import * as htmlEntities from '../../../../vendor/wordpress/gutenberg/build/html-entities'
import * as shortcode from '../../../../vendor/wordpress/gutenberg/build/shortcode'
import * as blocks from '../../../../vendor/wordpress/gutenberg/build/blocks'
import * as keycodes from '../../../../vendor/wordpress/gutenberg/build/keycodes'
import * as richText from '../../../../vendor/wordpress/gutenberg/build/rich-text'
import * as components from '../../../../vendor/wordpress/gutenberg/build/components'
import * as coreData from '../../../../vendor/wordpress/gutenberg/build/core-data'
import * as date from '../../../../vendor/wordpress/gutenberg/build/date'
import * as deprecated from '../../../../vendor/wordpress/gutenberg/build/deprecated'
import * as notices from '../../../../vendor/wordpress/gutenberg/build/notices'
import * as tokenList from '../../../../vendor/wordpress/gutenberg/build/token-list'
import * as viewport from '../../../../vendor/wordpress/gutenberg/build/viewport'
import * as wordcount from '../../../../vendor/wordpress/gutenberg/build/wordcount'
import * as blockLibrary from '../../../../vendor/wordpress/gutenberg/build/block-library'
import * as domReady from '../../../../vendor/wordpress/gutenberg/build/dom-ready'
import * as plugins from '../../../../vendor/wordpress/gutenberg/build/plugins'
import * as editPost from '../../../../vendor/wordpress/gutenberg/build/edit-post'
import * as a11y from '../../../../vendor/wordpress/gutenberg/build/a11y'
import * as editor from '../../../../vendor/wordpress/gutenberg/build/editor'
import * as blockEditor from '../../../../vendor/wordpress/gutenberg/build/block-editor'
import * as annotations from '../../../../vendor/wordpress/gutenberg/build/annotations'
import * as blockSerializationSpecParser from '../../../../vendor/wordpress/gutenberg/build/block-serialization-spec-parser'
import * as formatLibrary from '../../../../vendor/wordpress/gutenberg/build/format-library'
// import * as listReusableBlocks from '../../../../vendor/wordpress/gutenberg/build/list-reusable-blocks'
import * as priorityQueue from '../../../../vendor/wordpress/gutenberg/build/priority-queue'
import * as serverSideRender from '../../../../vendor/wordpress/gutenberg/build/server-side-render'
import * as dataControls from '../../../../vendor/wordpress/gutenberg/build/data-controls'
import * as mediaUtils from '../../../../vendor/wordpress/gutenberg/build/media-utils'

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
