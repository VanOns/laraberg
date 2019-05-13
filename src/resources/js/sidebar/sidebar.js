import CheckboxInput from './checkbox-input'
import RadioInput from './radio-input'
import SelectInput from './select-input'
import TextInput from './text-input'
import TextareaInput from './textarea-input'

const { registerPlugin } = window.wp.plugins
const { PluginSidebar } = window.wp.editPost
const el = window.wp.element.createElement

export default function () {
  registerPlugin('laraberg-sidebar', {
    render: () => {
      return el(PluginSidebar, {
        name: 'laraberg-sidebar',
        icon: 'media-text',
        title: 'Laraberg'
      }, renderElements())
    }
  })
}

function getElements (selector) {
  return Array.from(document.querySelectorAll(`.laraberg-sidebar ${selector}`))
}

function renderInputCheckbox (element, index) {
  return <CheckboxInput key={index} element={element} />
}

function renderInputRadio (elements) {
  return <RadioInput key={elements[0].name} options={elements} />
}

function renderInputSelect (element, index) {
  return <SelectInput key={index} element={element} />
}

function renderInputText (element, index) {
  return <TextInput key={index} element={element} />
}

function renderInputTextarea (element, index) {
  return <TextareaInput key={index} element={element} />
}

function getRadios () {
  const radios = getElements('input[type="radio"]')
  let result = radios.reduce((object, radio) => {
    if (!object[radio.name]) {
      object[radio.name] = []
    }
    object[radio.name].push(radio)
    return object
  }, {})
  return result
}

function renderElements () {
  const elements = []
  elements.push(getElements('input[type="text"]').map(renderInputText))
  elements.push(getElements('input[type="checkbox"]').map(renderInputCheckbox))
  elements.push(getElements('textarea').map(renderInputTextarea))
  elements.push(getElements('select').map(renderInputSelect))

  const radios = getRadios()
  elements.push(Object.keys(radios).map(key => renderInputRadio(radios[key])))

  return el('div',
    { className: 'plugin-sidebar-content laraberg-sidebar-content' },
    elements
  )
}
