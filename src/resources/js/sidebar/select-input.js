import Input from './input'
const Select = window.wp.components.SelectControl

export default class SelectInput extends Input {
  constructor (props) {
    super(props)
    this.getOptions = this.getOptions.bind(this)
  }

  getOptions () {
    const element = this.props.element
    return Object.keys(element.options).map(key => {
      return {
        label: element[key].text,
        value: element[key].value
      }
    })
  }

  render () {
    return (
      <Select
        label={this.getLabel()}
        options={this.getOptions()}
        value={this.state.value}
        onChange={this.onChange} />
    )
  }
}
