import { APIFetchOptions } from "@van-ons/block-editor/dist/interfaces/fetch-handler"

class Route {
    public method: string
    public regex: RegExp
    public handler: (params: object) => any

    constructor (method: string, regex: RegExp, handler: (params: object) => any) {
        this.method = method
        this.regex = regex
        this.handler = handler
    }

    static get(regex: RegExp, handler: (params: object) => any): Route {
        return new Route('GET', regex, handler)
    }

    static put(regex: RegExp, handler: (params: object) => any): Route {
        return new Route('PUT', regex, handler)
    }

    static post(regex: RegExp, handler: (params: object) => any): Route {
        return new Route('POST', regex, handler)
    }

    static delete(regex: RegExp, handler: (params: object) => any): Route {
        return new Route('DELETE', regex, handler)
    }

    handle (options: APIFetchOptions): Promise<any> {
        return Promise.resolve(
            this.handler(options)
        )
    }
}

export default Route
