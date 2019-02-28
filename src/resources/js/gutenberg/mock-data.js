// Mock data to get the Gutenberg editor to work

export const mediaResponse = {
  headers: {
    get: value => {
      if (value === 'allow') {
        return ['POST']
      }
    }
  }
}

export const pageData = {
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
    pageData.content = {
      raw: content
    }
  }
}

export const themesData = [{
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

export const embed = {
  'url': 'https:\/\/twitter.com\/elonmusk\/status\/1100672354932256773',
  'author_name': 'Elon Tusk',
  'author_url': 'https:\/\/twitter.com\/elonmusk',
  'html': '<blockquote class="twitter-tweet" data-width="550" data-dnt="true"><p lang="en" dir="ltr">Some Tesla news<\/p>&mdash; Elon Tusk (@elonmusk) <a href="https:\/\/twitter.com\/elonmusk\/status\/1100672354932256773?ref_src=twsrc%5Etfw">February 27, 2019<\/a><\/blockquote><script async src="https:\/\/platform.twitter.com\/widgets.js" charset="utf-8"><\/script>',
  'width': 550,
  'height': 600,
  'type': 'rich',
  'cache_age': '3153600000',
  'provider_name': 'Twitter',
  'provider_url': 'https:\/\/twitter.com',
  'version': '1.0'
}
