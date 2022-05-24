import fetchHandler from './fetch-handler'
import EditorSettings from "@van-ons/block-editor/dist/interfaces/editor-settings"

const defaultSettings: EditorSettings = {
    fetchHandler,
    mediaUpload: undefined,
    disabledCoreBlocks: [
        'core/freeform',
        'core/shortcode',
        'core/archives',
        'core/tag-cloud',
        'core/block',
        'core/rss',
        'core/search',
        'core/calendar',
        'core/categories',
        'core/more',
        'core/nextpage'
    ]
}

export default defaultSettings
