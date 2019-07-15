import * as MockData from '../api/mock-data'

const { data } = window.wp

export function getContent () {
  data.dispatch('core/editor').savePost()
  return data.select('core/editor').getEditedPostContent()
}

export function setContent (content) {
  MockData.page.setContent(content)
  data.dispatch('core/editor').setupEditorState(MockData.page)
  data.dispatch('core/editor').setupEditor(MockData.page)
}
