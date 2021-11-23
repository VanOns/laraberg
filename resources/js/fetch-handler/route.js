class Route {
    method
    regex
    handler

    constructor (method, regex, handler) {
        this.method = method
        this.regex = regex
        this.handler = handler
    }
}

export default Route
