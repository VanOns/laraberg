import React from 'react'

const Save = ({ attributes: { media } }) => {
    return (
        <div>
            <pre dangerouslySetInnerHTML={{__html: JSON.stringify(media)}}></pre>
        </div>
    )
}

export default Save
