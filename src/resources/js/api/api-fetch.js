import * as MockData from './mock-data'
import types from './data/types'
import axios from 'axios'
import { editorSettings } from '../gutenberg/settings'
import * as Notices from '../lib/notices'

let routePrefix
let searchCb

/**
 * Requests Gutenberg can make.
 * Each request has a method and a regex to match with the URL provided by Gutenberg.
 * When the matchPath() function matches Gutenberg's request with one of the requests in this object
 * the 'run' function gets executed.
 */
const requests = {
  getBlock: {
    method: 'GET',
    regex: /\/wp\/v2\/blocks\/(\d*)/g,
    run: getBlock
  },
  getBlocks: {
    method: 'GET',
    regex: /\/wp\/v2\/blocks($|[?].*)/g,
    run: getBlocks
  },
  postBlocks: {
    method: 'POST',
    regex: /\/wp\/v2\/blocks.*/g,
    run: postBlocks
  },
  putBlock: {
    method: 'PUT',
    regex: /\/wp\/v2\/blocks\/(\d*)/g,
    run: putBlock
  },
  deleteBlock: {
    method: 'DELETE',
    regex: /\/wp\/v2\/blocks\/(\d*)/g,
    run: deleteBlock
  },
  optionsBlocks: {
    method: 'OPTIONS',
    regex: /\/wp\/v2\/blocks.*/g,
    run: optionsBlocks
  },
  getEmbed: {
    method: 'GET',
    regex: /\/oembed\/1\.0\/proxy\?(.*)/g,
    run: getEmbed
  },
  optionsMedia: {
    method: 'OPTIONS',
    regex: /\/wp\/v2\/media/g,
    run: optionsMedia
  },
  getPage: {
    method: 'GET',
    regex: /\/wp\/v2\/pages\/(\d*)/g,
    run: getPage
  },
  putPage: {
    method: 'PUT',
    regex: /\/wp\/v2\/pages\/(\d*)/g,
    run: putPage
  },
  postPage: {
    method: 'POST',
    regex: /\/wp\/v2\/pages\/(\d*)/g,
    run: postPage
  },
  getSearch: {
    method: 'GET',
    regex: /\/wp\/v2\/search\?search=([^&]*)&per_page=([^&]*)&type=([^&]*)/g,
    run: getSearch
  },
  getTaxonomies: {
    method: 'GET',
    regex: /\/wp\/v2\/taxonomies\?(.*)/g,
    run: getTaxonomies
  },
  getThemes: {
    method: 'GET',
    regex: /\/wp\/v2\/themes/g,
    run: getThemes
  },
  getTypeBlock: {
    method: 'GET',
    regex: /\/wp\/v2\/types\/wp_block/g,
    run: getTypeBlock
  },
  getTypePage: {
    method: 'GET',
    regex: /\/wp\/v2\/types\/page/g,
    run: getTypePage
  },
  getTypes: {
    method: 'GET',
    regex: /\/wp\/v2\/types\?(.*)/g,
    run: getTypes
  },
  getUsers: {
    method: 'GET',
    regex: /\/wp\/v2\/users\/(.*)/g,
    run: getUsers
  }
}

/**
 * Get a reusable block
 * @param {Object} options
 * @param {Array} matches
 */
async function getBlock (options, matches) {
  let id = matches[1]
  let response = await axios.get(`${routePrefix}/blocks/${id}`)
  return response.data
}

/**
 * Get all reusable blocks
 */
async function getBlocks () {
  let response = await axios.get(`${routePrefix}/blocks`)
  return response.data
}

/**
 * Create a reusable block
 * @param {Object} options
 */
async function postBlocks (options) {
  let response = await axios.post(`${routePrefix}/blocks`, options.data)
  return response.data
}

/**
 * Update a reusable block
 * @param {Object} options
 * @param {Array} matches
 */
async function putBlock (options, matches) {
  let id = matches[1]
  let response = await axios.put(`${routePrefix}/blocks/${id}`, options.data)
  return response.data
}

/**
 * Delete a reusable block
 * @param {Object} options
 * @param {Array} matches
 */
async function deleteBlock (options, matches) {
  let id = matches[1]
  let response = await axios.delete(`${routePrefix}/blocks/${id}`)
  return response.data
}

/**
 * Options request for blocks
 * @param {Object} options
 * @param {Array} matches
 */
async function optionsBlocks (options, matches) {
  return []
}

/**
 * Get OEmbed HTML
 * @param {Object} options
 * @param {Array} matches
 */
async function getEmbed (options, matches) {
  let response = await axios.get(`${routePrefix}/oembed?${matches[1]}`)
  return response.data
}

/**
 * Get media mockdata
 */
async function optionsMedia () {
  return MockData.media
}

/**
 * Get page from mockdata and target value
 */
async function getPage () {
  let content = document.getElementById(editorSettings.target).value || ''
  return {
    ...MockData.page,
    content: {
      raw: content
    }
  }
}

/**
 * Mock POST page request
 * @param {Object} options
 */
export async function postPage (options) {
  return {
    ...MockData.page,
    content: {
      raw: options.data
    }
  }
}

/**
 * Mock PUT page request
 * @param {Object} options
 */
export async function putPage (options) {
  return {
    ...MockData.page,
    content: {
      raw: options.data
    }
  }
}

/**
 * Returns searchCb result or an empty array
 * @param {Object} options
 * @param {Array} matches
 * @returns {Array}
 */
export async function getSearch (options, matches) {
  if (!searchCb) return []

  const search = matches[1]
  const perPage = matches[2]
  const type = matches[3]
  const result = await searchCb(search, perPage, type)

  if (Array.isArray(result)) {
    return result
  }

  Notices.error('Search callback must return an Array.')
  return []
}

/**
 * Mock GET taxonomies request
 */
async function getTaxonomies (optons, matches) {
  return 'ok'
}

/**
 * Mock themes request
 */
async function getThemes () {
  return MockData.themes
}

/**
 * Mock post types block request
 */
async function getTypeBlock () {
  return MockData.types.block
}

/**
 * Mock post types page request
 */
async function getTypePage () {
  return MockData.types.page
}

/**
 * Mock post types request
 */
async function getTypes () {
  return types
}

/**
 * Mock users request
 */
async function getUsers () {
  return 'ok'
}

/**
 * Matches a Gutenberg request to the available requests in the requests variable
 * @param {Object} options - options object provided by Gutenberg
 * @returns {Promsie} - promise containing results
 */
function matchPath (options) {
  let promise
  Object.keys(requests).forEach((key) => {
    let request = requests[key]
    // Reset lastIndex so regex starts matching from the first character
    request.regex.lastIndex = 0
    let matches = request.regex.exec(options.path)
    if ((options.method === request.method || (!options.method && request.method === 'GET')) && matches && matches.length > 0) {
      promise = request.run(options, matches)
        .catch(() => Notices.error('Could not complete request.'))
    }
  })

  if (!promise) {
    promise = new Promise((resolve, reject) => {
      return reject(new FetchError({
        code: 'api_handler_not_found',
        message: 'API handler not found.',
        data: {
          path: options.path,
          options: options,
          status: 404
        }
      }))
    }).catch(error => {
      console.log(error)
      Notices.error(`${error.message} ${error.data.data.path}`)
    })
  }
  return promise
}

export default function apiFetch (options) {
  // console.log('apiFetch - options', options)
  const result = matchPath(options)
  result.then(res => {
    // console.log('apiFetch - result', res)
  })
  return result
}

export function configureAPI (options) {
  routePrefix = options.prefix || '/laraberg'
  searchCb = options.searchCb || null
}

class FetchError extends Error {
  constructor (object) {
    super(object.message)
    this.data = object
  }
}
