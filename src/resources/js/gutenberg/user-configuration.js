export default function configureEditor (options) {
  if (options.maxHeight) { setMaxHeight(options.maxHeight) }
  if (options.minHeight) { setMinHeight(options.minHeight) }
  if (options.height) { setHeight(options.height) }
}

function setMaxHeight (maxHeight) {
  const contentContainer = window.Laraberg.editor.querySelector('.edit-post-layout__content')
  contentContainer.style.maxHeight = maxHeight
}

function setMinHeight (minHeight) {
  const contentContainer = window.Laraberg.editor.querySelector('.edit-post-layout__content')
  contentContainer.style.minHeight = minHeight
}

function setHeight (height) {
  const contentContainer = window.Laraberg.editor.querySelector('.edit-post-layout__content')
  contentContainer.style.height = height
}
