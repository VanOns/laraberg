import Route from "./routing/route";
import oembedHandler from "./handlers/oembed-handler";
import themesHandler from "./handlers/themes-handler";

const routes: Route[] = [
    Route.get(/\/oembed\/1\.0\/proxy\?(.*)/g, oembedHandler),
    Route.get(/\/wp\/v2\/themes/g, themesHandler)
]

export default routes
