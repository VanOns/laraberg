// import * as Element from '@wordpress/element'

const { element } = window.wp
const { Component } = element

export default class Input extends Component {
  constructor (props) {
    super(props)

    this.getLabel = this.getLabel.bind(this)
    this.onChange = this.onChange.bind(this)

    this.state = {
      value: this.props.element.value
    }
  }

  getLabel () {
    return (this.props.element.labels[0] || {}).innerText || this.props.element.placeholder
  }

  onChange (content) {
    this.props.element.value = content
    this.setState({ value: content })
  }
}
