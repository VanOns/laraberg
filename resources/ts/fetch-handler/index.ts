import { APIFetchOptions, FetchHandler } from '@mauricewijnia/block-editor/dist/interfaces/fetch-handler'
import Route from './route'
import Router from './router'
import FetchError from "./fetch-error";

const router = new Router([
    new Route('GET', /\/oembed\/1\.0\/proxy\?(.*)/g, (params) => {
        console.log('OEMBED', params)
    }),
    new Route('GET', /\/wp\/v2\/themes/g, (params) => {
        console.log('THEMES', params)
    }),
])

const handlerNotFound = (options: APIFetchOptions): Promise<object> => {
    return new Promise((resolve, reject) => {
        return reject(
            new FetchError(
                {
                    code: 'api_handler_not_found',
                    message: 'API handler not found.',
                    data: {
                        path: options.path,
                        options: options,
                        status: 404
                    }
                }
            )
        )
    })
}

const fetchHandler: FetchHandler = (options: APIFetchOptions): Promise<any> => {
    const route = router.match(options)

    if (!route) {
        return handlerNotFound(options)
    }

    return route.handle(options)
}

export default fetchHandler
