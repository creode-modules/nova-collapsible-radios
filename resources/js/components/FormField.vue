<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <RadioList :options="field.options" :attribute="field.attribute" :selected="field.value" @change="handleChange"></RadioList>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import RadioList from './RadioList';
import isNil from 'lodash/isNil';

export default {
  mixins: [FormField, HandlesValidationErrors],

  components: { RadioList },

  props: ['resourceName', 'resourceId', 'field'],

  mounted() {
    if (!isNil(this.field.value)) {
      this.expandSelectedOptions();
    }
  },

  data: () => ({
    selectedOption: null,
    expandedOptions: [],
  }),

  methods: {
    fieldDefaultValue() {
      return null;
    },

    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.fieldAttribute, this.value || '')
    },

    /**
     * Clear the current selection for the field.
     */
     clearSelection() {
      this.value = this.fieldDefaultValue();

      if (this.field) {
        this.emitFieldValueChange(this.fieldAttribute, this.value)
      }
    },

    /**
     * Handle the selection change event.
     */
    handleChange(event) {
      var value = event.target.value
      if (isNil(value)) {
        this.clearSelection()
        return
      }

      this.value = value;

      if (this.field) {
        this.emitFieldValueChange(this.fieldAttribute, this.value)
      }
    },

    expandSelectedOptions() {
      this.field.options.forEach(option => {
        if (option.value == this.field.value) {
          this.expandOption(option.parent_id);
        }
      });
    },
  },
}
</script>
