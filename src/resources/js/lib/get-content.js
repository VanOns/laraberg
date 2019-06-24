const { data } = window.wp

export default function getContent () {
  data.dispatch('core/editor').savePost()
  return data.select('core/editor').getEditedPostContent()
}
