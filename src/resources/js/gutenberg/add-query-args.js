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
  const queryStringIndex = url.indexOf('?')
  const query = queryStringIndex !== -1 ? URL(url.substr(queryStringIndex + 1)) : {}
  const baseUrl = queryStringIndex !== -1 ? url.substr(0, queryStringIndex) : url

  return baseUrl + '?' + stringify({ ...query, ...args })
}
