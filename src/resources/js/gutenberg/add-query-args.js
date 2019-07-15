/**
* External dependencies
*/
import URL from 'url'
import { stringify } from 'querystring'

/**
* Appends arguments to the query string of the url
*
* @param  {String} url   URL
* @param  {Object} args  Query Args
*
* @return {String}       Updated URL
*/
export default function addQueryArgs (url, args) {
  const qs = Object.keys(args).map(key => {
    if (key === '_locale' || key === 'per_page') {
      return ''
    } else {
      return `${key}=${encodeURIComponent(args[key])}`
    }
  })

  // if (url === 'edit.php') {
  //   // 'Manage All Reusable Blocks'
  //   if (args.post_type && args.post_type === 'wp_block') {
  //     return `${drupalSettings.path.baseUrl}admin/content/reusable-blocks`
  //   }
  // }
  return url + (qs ? `?${qs.join('&')}` : '')
}
