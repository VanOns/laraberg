import Route from "./routing/route";
import oembedHandler from "./handlers/oembed-handler";
import themesHandler from "./handlers/themes-handler";
import blockRendererHandler from "./handlers/block-renderer-handler";

const routes: Route[] = [
    Route.get(/\/oembed\/1\.0\/proxy\?(.*)/g, oembedHandler),
    Route.get(/\/wp\/v2\/themes/g, themesHandler),
    Route.get(/\/wp\/v2\/block-renderer\/(.*)/g, blockRendererHandler),
    Route.post(/\/wp\/v2\/block-renderer\/(.*)/g, blockRendererHandler)
]

export default routes
