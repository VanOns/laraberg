import React from 'react'
import Edit from './edit'
import Save from './save'

const { registerBlockType } = window.Laraberg

export default () => {
    registerBlockType('example/server-side-render-block', {
        title: 'Server Side Render Block',
        description: 'This is an example ServerSideRender block',
        category: 'text',
        attributes: {
            title: {
                type: 'string',
                default: ''
            },
            subtitle: {
                type: 'string',
                default: ''
            },
            ids: {
                type: 'array',
                default: [null, null]
            },
            user: {
                type: 'object',
                default: { firstName: null, lastName: null }
            }
        },
        edit: Edit,
        save: Save
    })
}
