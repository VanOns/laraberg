import EditorSettings from "@mauricewijnia/block-editor/dist/interfaces/editor-settings";
import { initializeEditor } from "@mauricewijnia/block-editor";
import defaultSettings from "./default-settings";

export const init = (
    target: string|HTMLInputElement|HTMLTextAreaElement,
    settings: EditorSettings = {}
) => {
    let element

    if (typeof target === 'string') {
        element = document.getElementById(target) || document.querySelector(target)
    } else {
        element = target
    }

    initializeEditor(element, { ...defaultSettings, ...settings })
}
