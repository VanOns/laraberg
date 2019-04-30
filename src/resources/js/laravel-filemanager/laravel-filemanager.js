export default function (config) {
  const { hooks, element } = window.wp
  const { Component } = element

  class LaravelFilemanager extends Component {
    constructor () {
      super(...arguments)
      this.openModal = this.openModal.bind(this)
      this.onSelect = this.onSelect.bind(this)
      this.state = {
        media: []
      }
    }

    getMediaType (path) {
      const video = ['mp4', 'm4v', 'mov', 'wmv', 'avi', 'mpg', 'ogv', '3gp', '3g2']
      const audio = ['mp3', 'm4a', 'ogg', 'wav']
      const extension = path.split('.').slice(-1).pop()
      if (video.includes(extension)) {
        return 'video'
      } else if (audio.includes(extension)) {
        return 'audio'
      } else {
        return 'image'
      }
    }

    onSelect (url, path) {
      this.props.value = null
      const { multiple, onSelect } = this.props
      const media = {
        url: url,
        type: this.getMediaType(path)
      }
      if (multiple) { this.state.media.push(media) }
      onSelect(multiple ? this.state.media : media)
    }

    openModal () {
      let options = {}
      if (this.props.allowedTypes.length === 1 && this.props.allowedTypes[0] === 'image') {
        options.type = 'image'
      } else {
        options.type = 'file'
      }
      this.openLFM(options, this.onSelect)
    }

    openLFM (options, cb) {
      let routePrefix = (config && config.prefix) ? config.prefix : '/laravel-filemanager'
      window.open(routePrefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600')
      window.SetUrl = cb
    }

    render () {
      const { render } = this.props
      return render({ open: this.openModal })
    }
  }

  hooks.addFilter(
    'editor.MediaUpload',
    'core/edit-post/components/media-upload/replace-media-upload',
    () => LaravelFilemanager
  )
}
