class FetchError extends Error {
    public data: object

    constructor(object: { code: string, message: string, data: object }) {
        super(object.message);
        this.data = object
    }
}

export default FetchError
