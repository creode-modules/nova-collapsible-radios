<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <p v-if="fullHierarchyName">
        {{ fullHierarchyName }}
      </p>
      <p v-else>
        &mdash;
      </p>
    </template>
  </PanelItem>
</template>

<script>
import {buildHierarchyPath} from '../heirarchyHelper.js';

export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  computed: {
    fullHierarchyName() {
      // To find the full path for the folder.
      return buildHierarchyPath(this.field.options, this.field.value);
    }
  },
}
</script>
