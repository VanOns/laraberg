import './bootstrap'

import exampleBlock from './blocks/example-block'
import mediaUploadBlock from './blocks/media-upload-block'
import serverSideRenderBlock from './blocks/server-side-render-block'

exampleBlock()
mediaUploadBlock()
serverSideRenderBlock()

document.addEventListener('block-editor/init', () => {
    console.log('block-editor/init')
})

const mediaUpload = async ({ filesList, onFileChange }) => {
    const formData = new FormData();
    formData.append('file', filesList[0]);

    try {
        const response = await fetch('http://laraberg.test/upload', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const uploadedFiles = await response.json();
        onFileChange([uploadedFiles]);
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}

Laraberg.init('content', { mediaUpload })
