import qs from 'qs'

const oembedHandler = async (options) => {
    const [path, query] = options.path.split('?')
    const params = qs.parse(query)
    const url = new URL('/laraberg/oembed', window.location.origin)

    url.searchParams.append('url', params.url)

    const res = await fetch(url.toString())
    return await res.json()
}

export default oembedHandler
