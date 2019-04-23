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

export const page = {
  content: {
    raw: ''
  },
  title: '',
  templates: '',
  parent: 0,
  link: `${window.location.origin}/preview`,
  permalink_template: `${window.location.origin}/preview`,
  preview_link: `${window.location.origin}/preview`,
  type: 'page',
  status: 'pending',
  id: 0,
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
