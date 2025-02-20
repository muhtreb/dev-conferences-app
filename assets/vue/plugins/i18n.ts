export default {
    install: (app, options) => {
        // inject a globally available $translate() method
        app.config.globalProperties.$t = (key) => {
            return options.translator.trans(key)
        }

        app.provide('i18n', options.translator)
    }
}
