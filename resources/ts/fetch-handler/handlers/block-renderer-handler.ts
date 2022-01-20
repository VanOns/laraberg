import qs from 'qs'


const blockRendererHandler = async (options) => {
    const matches = /\/wp\/v2\/block-renderer\/(?<namespace>.*)\/(?<block>.*)\?.*/g.exec(options.path)
    const blockName = `${matches?.groups?.namespace}/${matches?.groups?.block}`
    const attributes = options.method === 'POST'
        ? parseAttributesPost(options)
        : parseAttributesGet(options)

    const url = new URL('/laraberg/block-renderer', window.location.origin)
    const res = await fetch(url.toString() + '?' + qs.stringify({ blockName, attributes }))

    return await res.json()
}

const parseAttributesGet = (options) => {
    const [path, query] = options.path.split('?')
    const params = qs.parse(query)
    return params.attributes
}

const parseAttributesPost = (options) => {
    return options.data?.attributes
}

export default blockRendererHandler
