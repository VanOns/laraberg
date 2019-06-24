export default function () {
  const { hooks, element } = window.wp
  const { Component } = element

  class MockFileUploader extends Component {
    render () {
      return null
    }
  }

  hooks.addFilter(
    'editor.MediaUpload',
    'core/edit-post/components/media-upload/replace-media-upload',
    () => MockFileUploader
  )
}
