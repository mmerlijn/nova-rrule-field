Nova.booting((Vue, router, store) => {
    Vue.component('index-rrule', require('./components/IndexField'))
    Vue.component('detail-rrule', require('./components/DetailField'))
    Vue.component('form-rrule', require('./components/FormField'))
});
