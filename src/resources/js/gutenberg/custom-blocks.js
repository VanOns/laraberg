const { dispatch, select } = window.wp.data
const { registerBlockType } = window.wp.blocks

/**
 * Registers a custom block to the editor
 * @param {string} name The namespaced name of the block (eg: my-module/my-block)
 * @param {Object} block The Gutenberg block object
 */
export function registerBlock (name, block) {
  registerBlockType(name, block)
}

/**
 * Adds a category to the category list
 * @param {String} title - The title for the category (eg: My Category)
 * @param {String} slug - The slug for the category (eg: my-category)
 */
export function registerCategory (title, slug) {
  let category = {
    slug: slug,
    title: title
  }

  const currentCategories = select('core/blocks').getCategories().filter(item => item.slug !== category.slug)
  dispatch('core/blocks').setCategories([ category, ...currentCategories ])
}
