import {APIFetchOptions} from "@van-ons/block-editor/dist/interfaces/fetch-handler"
import FetchError from "../../errors/fetch-error";

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

export default handlerNotFound
