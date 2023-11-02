<template>
    <ul class="radio-list__list">
        <li class="radio-list__list-item" v-for="option in options" :key="option.value">
            <input class="radio-list__input" type="radio" :id="attribute + '-' + option.value"
                :name="attribute"
                :value="option.value"
                @change="handleChange"
                :checked="isSelected(option)"
            >
            <label class="radio-list__label" :for="attribute + '-' + option.value">{{ option.label }}</label>

            <button class="radio-list__toggle-button" @click="toggle(option.value)" v-if="!isExpanded(option.value)" v-show="option.children.length">
                <ExpandIcon />
            </button>

            <button class="radio-list__toggle-button" @click="toggle(option.value)" v-if="isExpanded(option.value)" v-show="option.children.length">
                <CollapseIcon />
            </button>

            <RadioList :options="option.children" :attribute="attribute" v-if="option.children.length" v-show="isExpanded(option.value)" @change="handleChange" :selected="selected" @optionSelected="expand"></RadioList>
        </li>
    </ul>
</template>

<script>
import some from 'lodash/some';
import isNil from 'lodash/isNil';

import ExpandIcon from './Icons/ExpandIcon.vue';
import CollapseIcon from './Icons/CollapseIcon.vue';

export default {
  props: ['options', 'attribute', 'selected'],

  emits: ['change', 'triggerExpand'],

  components: {
    ExpandIcon,
    CollapseIcon,
  },

  mounted() {
    this.$nextTick(() => {
      if (this.optionsContainSelectedValue()) {
        this.expandParents();
      }
    })
  },

  data() {
    return {
      expandedOptions: [],
    }
  },

  methods: {
    toggle(optionId) {
      if (this.expandedOptions.includes(optionId)) {
        this.expandedOptions = this.expandedOptions.filter(item => item !== optionId);
        return;
      }

      this.expandOption(optionId);
    },

    isExpanded(optionId) {
      return this.expandedOptions.includes(optionId);
    },

    isSelected(option) {
      return option.value == this.selected
    },

    handleChange() {
      this.$emit('change', event);
    },

    triggerExpand(optionId) {
      this.$emit('triggerExpand', optionId);
      return this.expandedOptions.includes(optionId);
    },

    expandOption(optionId) {
      this.expandedOptions.push(optionId);
    },

    optionsContainSelectedValue() {
      return some(this.options, option => option.value == this.selected);
    },

    expandParents() {
      // Loop through the options, if one is selected trigger an expand.
      this.options.forEach(option => {
        if (option.value == this.selected) {
          this.$emit('optionSelected', option.parent_id);
        }
      });
    },

    expand(optionId) {
      this.options.forEach(option => {
        if (option.value != optionId) {
          return;
        }

        this.expandOption(optionId);

        if (isNil(option.parent_id)) {
          return;
        }

        this.$emit('optionSelected', option.parent_id);
      });
    }
  },
}
</script>

<style scoped>
    .radio-list__list {
        list-style: none;
        padding-left: 20px;
        display: block;
        flex-basis: 100%;
    }

    .radio-list__list-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
        flex-wrap: wrap;
    }

    .radio-list__input {
      display:block;
        margin-right: 5px;
    }

    .radio-list__label {
      display:block;
        margin-right: 5px;
    }

    .radio-list__toggle-button {
      display: block;
    }
</style>
