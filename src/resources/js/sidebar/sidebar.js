import CheckboxInput from './checkbox-input'
import RadioInput from './radio-input'
import SelectInput from './select-input'
import TextInput from './text-input'
import TextareaInput from './textarea-input'

const { editPost, element, plugins } = window.wp
const { Component } = element
const { registerPlugin } = plugins
const { PluginSidebar } = editPost
const el = window.wp.element.createElement

export default function () {
  registerPlugin('laraberg-sidebar', {
    render: () => el(Sidebar)
  })
}

class Sidebar extends Component {
  constructor (props) {
    super(props)
    this.state = {
      elements: []
    }
  }

  componentDidMount () {
    this.getElements()
  }

  getElements () {
    const elements = Array.from(document.querySelectorAll(`.laraberg-sidebar *`))
    let inputs = []
    let radios = []

    elements.forEach((element, index) => {
      if (radios.length > 0 && (element.type !== 'radio' || element.name !== radios[0].name)) {
        inputs.push(this.addInputRadio(radios, index))
        radios = []
      }

      switch (element.type) {
        case 'text':
          inputs.push(this.addInputText(element, index))
          break
        case 'textarea':
          inputs.push(this.addInputTextarea(element, index))
          break
        case 'select-one':
          inputs.push(this.addInputSelect(element, index))
          break
        case 'checkbox':
          inputs.push(this.addInputCheckbox(element, index))
          break
        case 'radio':
          radios.push(element)
          break
      }
    })

    this.setState({
      elements: inputs
    })
  }

  addInputCheckbox (element, index) {
    return <CheckboxInput key={index} element={element} />
  }

  addInputRadio (elements, index) {
    return <RadioInput key={index} options={elements} />
  }

  addInputSelect (element, index) {
    return <SelectInput key={index} element={element} />
  }

  addInputText (element, index) {
    return <TextInput key={index} element={element} />
  }

  addInputTextarea (element, index) {
    return <TextareaInput key={index} element={element} />
  }

  render () {
    return (
      <PluginSidebar name="laraberg-sidebar" icon="media-text" title="Laraberg">
        <div className="plugin-sidebar-content laraberg-sidebar-content">
          {this.state.elements}
        </div>
      </PluginSidebar>
    )
  }
}
