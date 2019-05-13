import Input from './input'
const Checkbox = window.wp.components.CheckboxControl

export default class CheckboxInput extends Input {
  constructor (props) {
    super(props)
    this.state = {
      checked: this.props.element.checked
    }
  }

  onChange (checked) {
    this.props.element.checked = checked
    this.setState({ checked: checked })
  }

  render () {
    return (
      <Checkbox
        label={this.getLabel()}
        value={this.props.element.value}
        checked={this.state.checked}
        onChange={this.onChange} />
    )
  }
}
