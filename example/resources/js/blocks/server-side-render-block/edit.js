const { serverSideRender: ServerSideRender } = Laraberg.wordpress
const { TextControl } = Laraberg.wordpress.components

const Edit = ({attributes, setAttributes}) => {
    const { title, subtitle, ids, user } = attributes
    return (
        <div>
            <h1>ServerSideRender</h1>
            <h2>Fields</h2>
            <TextControl
                label="Title"
                value={title}
                onChange={(title) => setAttributes({ title })}
            />

            <TextControl
                label="Subtitle"
                value={subtitle}
                onChange={(subtitle) => setAttributes({ subtitle })}
            />

            <h3>Ids</h3>

            <TextControl
                label="ID 1"
                value={ids[0]}
                type="number"
                onChange={(id) => {
                    setAttributes({ ids: [id, ids[1] || null] })
                }}
            />

            <TextControl
                label="ID 2"
                value={ids[1]}
                type="number"
                onChange={(id) => {
                    setAttributes({ ids: [ids[0] || null, id] })
                }}
            />


            <h3>User</h3>

            <TextControl
                label="First Name"
                value={user.firstName}
                onChange={(firstName) => setAttributes({ user: { ...user, firstName } })}
            />

            <TextControl
                label="Last Name"
                value={user.lastName}
                onChange={(lastName) => setAttributes({ user: { ...user, lastName } })}
            />

            <h2>Preview</h2>
            <ServerSideRender
                block="example/server-side-render-block"
                attributes={{
                    title,
                    subtitle,
                    ids,
                    user
                }}
            />
        </div>
    )
}

export default Edit
