import axios from 'axios'

const types = {
  page: {
    labels: {},
    name: 'Page', rest_base: 'pages', slug: 'page',
    supports: {
      author: false,
      comments: false, // hide discussion-panel
      'custom-fields': true,
      document: true, // * hide document tab
      editor: true,
      'media-library': false, // * hide media library
      'page-attributes': false, // hide page-attributes panel
      posts: false, // * hide posts-panel
      revisions: false,
      'template-settings': false, // * hide template-settings panel
      thumbnail: false, // featured-image panel
      title: false, // show title on editor
      extras: false,
    },
    viewable: false,
    saveable: true,
    publishable: true,
    autosaveable: false
  },
  block: {
    name: 'Blocks', rest_base: 'blocks', slug: 'wp_block',
    description: '',
    supports: {
      title: true,
      editor: true
    },
    viewable: true
  }
}

const requests = {
  getBlock: {
    method: 'GET',
    regex: /\/wp\/v2\/blocks\/(\d*)/g,
    run: getBlock
  },
  getBlocks: {
    method: 'GET',
    regex: /\/wp\/v2\/blocks.*/g,
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
    regex: /\/wp\/v2\/users\/\?(.*)/g,
    run: getUsers
  }
}

function getBlock(options, matches) {
  let id = matches[1]
  return axios.get(`/laraberg/blocks/${id}`)
    .then(response => response.data)
}

function getBlocks() {
  return axios.get('/laraberg/blocks')
    .then(response => response.data)
}

function postBlocks(options) {
  return axios.post('/laraberg/blocks', options.data)
    .then(response => response.data)
}

function putBlock(options, matches) {
  let id = matches[1]
  return axios.put(`laraberg/blocks/${id}`, options.data)
    .then(response => response.data)
}

function optionsMedia() {
  let res = {
    headers: {
        get: value => {
            if (value === 'allow') {
                return [ 'POST' ]
            }
        },
    },
  }
  return new Promise(resolve => {
    resolve(res)
  })
}

function getPage() {
  let data = {
    content: {
      raw: ""
    },
    templates: "",
    parent: 0,
    link: `${window.location.origin}/preview`,
    permalink_template: `${window.location.origin}/preview`,
    preview_link: `${window.location.origin}/preview`,
    type: 'page',
    status: 'draft',
    id: 1, // Only matters if we want to do saves through API calls
  };
  return new Promise(resolve => {
    resolve(data)
  })
}

function getTaxonomies() {
  return new Promise(resolve => {
    resolve('ok')
  })
}

function getThemes() {
  let data = [{
    theme_supports: {
      formats: [ 'standard', 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio' ],
      'post-thumbnails': true,
    }
  }]
  return new Promise(resolve => {
    resolve(data)
  })
}

function getTypeBlock() {
  return new Promise(resolve => {
    resolve(types.block)
  })
}

function getTypePage() {
  return new Promise(resolve => {
    resolve(types.page)
  })
}

function getTypes() {
  return new Promise(resolve => {
    resolve(types)
  })
}

function getUsers() {
  return new Promise(resolve => {
    resolve('ok')
  })
}

function matchPath(options) {
  let promise
  Object.keys(requests).forEach((key) => {
    let request = requests[key]
    // Reset lastIndex so regex starts matching from the first character
    request.regex.lastIndex = 0
    let matches = request.regex.exec(options.path)
    if ((options.method === request.method || (!options.method && request.method === 'GET')) && matches && matches.length > 0) {
      promise = request.run(options, matches)
        .catch(error=> console.log(error.response))
    }
  })

  if (!promise) {
    promise = new Promise((resolve, reject) => {
      return reject({
        code: 'api_handler_not_found',
        message: 'API handler not found.',
        data: {
          path: options.path,
          options: options,
          status: 404
        }
      })
    }).catch(error => {
      console.log(error)
    })
  }
  promise.then(data => {
    console.log('apiFetchResponse:\n', data, options)
  })
  return promise
}

export default function apiFetch(options) {
  console.log('apiFetchRequest:\n', options)
  return matchPath(options)
}