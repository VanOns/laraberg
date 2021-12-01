const oembedHandler = async (params) => {
    const url = new URL('/laraberg/oembed', window.location.origin)
    url.searchParams.append('url', params.url)

    const res = await fetch(url.toString())
    return await res.json()
}

export default oembedHandler
