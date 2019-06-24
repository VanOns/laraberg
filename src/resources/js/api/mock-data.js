// Mock data to get the Gutenberg editor to work

export const media = {
  headers: {
    get: value => {
      if (value === 'allow') {
        return ['POST']
      }
    }
  }
}

const date = (new Date()).toISOString()

export const page = {
  id: 1,
  content: {
    raw: '',
    rendered: ''
  },
  date,
  date_gmt: date,
  title: {
    raw: 'Preview page',
    rendered: 'Preview page'
  },
  excerpt: {
    raw: '',
    rendered: ''
  },
  status: 'pending',
  revisions: { count: 0, last_id: 0 },
  parent: 0,
  theme_style: true,
  type: 'page',
  link: `${window.location.origin}/preview`,
  categories: [ ],
  featured_media: 0,
  permalink_template: `${window.location.origin}/preview`,
  preview_link: `${window.location.origin}/preview`,
  _links: {
    'wp:action-assign-categories': [],
    'wp:action-create-categories': []
  },
  // functions
  setContent: (content) => {
    page.content = {
      raw: content
    }
  }
}

export const themes = [{
  theme_supports: {
    formats: ['standard', 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio'],
    'post-thumbnails': true
  }
}]

export const types = {
  page: {
    labels: {},
    name: 'Page',
    rest_base: 'pages',
    slug: 'page',
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
      extras: false
    },
    viewable: false,
    saveable: true,
    publishable: true,
    autosaveable: false
  },
  block: {
    name: 'Blocks',
    rest_base: 'blocks',
    slug: 'wp_block',
    description: '',
    supports: {
      title: true,
      editor: true
    },
    viewable: true
  }
}
