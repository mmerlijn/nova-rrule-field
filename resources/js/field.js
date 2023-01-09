import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-rrule-field', IndexField)
  app.component('detail-nova-rrule-field', DetailField)
  app.component('form-nova-rrule-field', FormField)
})
