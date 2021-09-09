module.exports = {
    mode: "jit",
    purge: {
        enabled: true,
        content: [
            './**/*.php',
            './dist/**/*.js'
        ]
    },
    theme: {
        extend : {
            colors : {
                'linkedin' : '#0e76a8'
            }
        }
    },
    variants: {},
    plugins: [],
}