import Route from './route'

const routes = [
    new Route('GET', /\/oembed\/1\.0\/proxy\?(.*)/g, () => {
        console.log('OEMBED')
    }),
    new Route('GET', /\/wp\/v2\/themes/g, () => {
        console.log('THEMES')
    }),
]

const fetchHandler = (options) => {
    console.log(options)
}

export default fetchHandler
