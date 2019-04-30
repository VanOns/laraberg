/**
 * Shows a success message
 * @param {String} message the message to display
 */
export function success (message) {
  notice('success', message)
}

/**
 * Shows an info message
 * @param {String} message the message to display
 */
export function info (message) {
  notice('info', message)
}

/**
 * Shows an error message
 * @param {String} message the message to display
 */
export function error (message) {
  notice('error', message)
}

/**
 * Shows a warning message
 * @param {String} message the message to display
 */
export function warning (message) {
  notice('warning', message)
}

export function notice (status, message) {
  if (window.wp && window.wp.data) {
    window.wp.data.dispatch('core/notices').createNotice(status, message)
  }
}
