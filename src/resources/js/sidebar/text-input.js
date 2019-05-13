import Input from './input'
const Text = window.wp.components.TextControl

export default class TextInput extends Input {
  render () {
    return (
      <Text
        label={this.getLabel()}
        value={this.state.value}
        onChange={this.onChange} />
    )
  }
}
