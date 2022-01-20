import './bootstrap'

import exampleBlock from './blocks/example-block'
import mediaUploadBlock from './blocks/media-upload-block'
import serverSideRenderBlock from './blocks/server-side-render-block'

exampleBlock()
mediaUploadBlock()
serverSideRenderBlock()

const mediaUpload = ({filesList, onFileChange}) => {
    const files = Array.from(filesList).map(window.URL.createObjectURL)

    onFileChange(files)

    setTimeout(() => {
        const uploadedFiles = Array.from(filesList).map(file => {
            return {
                id: file.name,
                name: file.name,
                url: `https://dummyimage.com/600x400/000/fff&text=${file.name}`
            }
        })
        onFileChange(uploadedFiles)
    }, 1000)
}

Laraberg.init('content', { mediaUpload })
