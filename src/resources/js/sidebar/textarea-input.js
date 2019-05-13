import Input from './input'
const Textarea = window.wp.components.TextareaControl

export default class TextareaInput extends Input {
  render () {
    return (
      <Textarea
        label={this.getLabel()}
        value={this.state.value}
        onChange={this.onChange} />
    )
  }
}
