module.exports = {
    "extends": [
        "standard",
        'plugin:react/recommended'
    ],
    "env": {
        "browser": true
    },
    'plugins': [
        'react'
    ],
    'parser': 'babel-eslint',
    "rules": {
        'react/prop-types': [0],
        "sort-imports": ["error", {
            "ignoreCase": false,
            "ignoreDeclarationSort": true,
            "ignoreMemberSort": false,
            "memberSyntaxSortOrder": ["none", "all", "multiple", "single"]
        }]
    },
    'settings': {
        'react': {
            'version': '16.8.6'
        }
    }
};