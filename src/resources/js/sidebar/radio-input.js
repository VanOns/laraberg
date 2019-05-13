const { element } = window.wp
const { Component } = element
const Radio = window.wp.components.RadioControl

export default class RadioInput extends Component {
  constructor (props) {
    super(props)

    this.getLabel = this.getLabel.bind(this)
    this.getOptions = this.getOptions.bind(this)
    this.getSelected = this.getSelected.bind(this)
    this.onChange = this.onChange.bind(this)

    this.state = {
      options: this.getOptions(),
      selected: this.getSelected()
    }
  }

  onChange (option) {
    this.props.options.forEach(radio => {
      if (radio.value === option) radio.checked = true
    })

    this.setState({ selected: option })
  }

  getLabel (option) {
    if (option.labels && option.labels[0]) {
      return option.labels[0].innerText
    } else {
      return null
    }
  }

  getOptions () {
    return this.props.options.map(option => {
      return {
        label: this.getLabel(option),
        value: option.value
      }
    })
  }

  getSelected () {
    const options = this.props.options

    let selected = null
    Object.keys(options).some(key => {
      if (options[key].checked) {
        selected = options[key].value
        return true
      }
    })

    return selected
  }

  render () {
    return (
      <Radio
        options={this.state.options}
        selected={this.state.selected}
        onChange={this.onChange} />
    )
  }
}
