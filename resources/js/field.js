import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-collapsible-radios', IndexField)
  app.component('detail-collapsible-radios', DetailField)
  app.component('form-collapsible-radios', FormField)
})
