import React from 'react'

const { registerBlockType } = window.Laraberg

export default () => {
  registerBlockType('example/example-block', {
    title: 'Example Block',
    description: 'This is an example block',
    category: 'text',
    attributes: {},
    edit: () => <h1>Edit</h1>,
    save: () => <h1>Save</h1>
  })
}
