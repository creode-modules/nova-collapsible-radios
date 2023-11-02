<template>
  <span>{{ fieldValue }}</span>
</template>

<script>

import {buildHierarchyPath} from '../heirarchyHelper.js';

export default {
  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
        if (!this.field.value) {
            return '-';
        }

        return buildHierarchyPath(this.field.options, this.field.value);
    },
  }
}
</script>
