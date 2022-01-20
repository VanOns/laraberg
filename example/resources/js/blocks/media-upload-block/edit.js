import React from 'react'

const { MediaPlaceholder } = Laraberg.wordpress.blockEditor

const Edit = ({attributes: { media }, setAttributes}) => {
    return (
        <div>
            <h1>Media Upload Block</h1>
            {
                Object.keys(media).length > 0
                    ? (
                        <div>
                            <pre dangerouslySetInnerHTML={{__html: JSON.stringify(media, null, 2)}}></pre>
                            <button className="button" onClick={() => setAttributes({media: {}})}>Clear</button>
                        </div>
                    )
                    : (
                        <MediaPlaceholder
                            onSelect={(item) => {
                                setAttributes({ media: item })
                            }}
                            allowedTypes={['image']}
                            multiple={false}
                            labels={{ title: 'Upload an image!' }}
                        />
                    )
            }

        </div>
    )
}

export default Edit
