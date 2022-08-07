<template>
  <div :class="elementSize">
    <field-wrapper :stacked="field.stacked" v-if="field.visible">
      <div
        class="px-6 md:px-8 mt-2 md:mt-0"
        :class="field.stacked ? 'md:pt-2 w-full' : 'w-full md:w-1/5 md:py-5'"
      >
        <slot>
          <form-label
            :label-for="labelFor || field.uniqueKey"
            :class="{ 'mb-2': shouldShowHelpText }"
          >
            {{ fieldLabel }}
            <span v-if="field.required" class="text-red-500 text-sm">
            {{ __('*') }}
          </span>
          </form-label>
        </slot>
      </div>

      <div
        class="mt-1 md:mt-0 pb-5 px-6 md:px-8"
        :class="fieldClasses"
      >
        <slot name="field" />

        <help-text class="mt-2 help-text-error" v-if="showErrors && hasError">
          {{ firstError }}
        </help-text>

        <help-text
          class="help-text mt-2"
          v-if="shouldShowHelpText"
          v-html="field.helpText"
        />
      </div>
    </field-wrapper>
  </div>
</template>

<script>
import HandlesValidationErrors from './mixins/HandlesValidationErrors'
import { mapProps } from './mixins/propTypes'

export default {
  name: 'DefaultField',

  mixins: [HandlesValidationErrors],

  props: {
    field: { type: Object, required: true },
    fieldName: { type: String },
    showErrors: { type: Boolean, default: true },
    fullWidthContent: { type: Boolean, default: false },
    labelFor: { default: null },
    ...mapProps(['showHelpText']),
  },

  mounted() {
    if(this.hasSize) {
      if (this.$parent.$el.classList.contains('fields-tab')) {
        this.$parent.$el.classList.add('flex-dom')
        this.$parent.$el.classList.add('flex-wrap')
        this.$parent.$el.classList.add('flex')
      } else {
        this.$parent.$parent.$el.classList.add('flex-dom')
        this.$parent.$parent.$el.classList.add('flex-wrap')
        this.$parent.$parent.$el.classList.add('flex')
      }

      // Use for eminiarts/nova-tabs package
      if(document.getElementsByClassName('relationship-tabs-panel')){
        var tabs = document.getElementsByClassName('relationship-tabs-panel')
        for(var i = 0; i < tabs.length; i++) {
          tabs.item(i).className += " w-full"
        }
        this.$parent.$el.parentElement.classList.add('flex')
        this.$parent.$el.parentElement.classList.add('flex-wrap')
      }
    }
  },

  computed: {
    /**
     * Return the label that should be used for the field.
     */
    fieldLabel() {
      // If the field name is purposefully an empty string, then let's show it as such
      if (this.fieldName === '') {
        return ''
      }

      return this.fieldName || this.field.name || this.field.singularLabel
    },

    /**
     * Determine help text should be shown.
     */
    shouldShowHelpText() {
      return this.showHelpText && this.field.helpText?.length > 0
    },

    fieldClasses() {
      return this.fullWidthContent
        ? this.field.stacked
          ? 'w-full'
          : 'w-4/5 md:py-5'
        : this.hasSize
          ? 'w-full md:py-5'
          : 'w-1/2 md:py-5'
    },

    elementSize() {
      return this.field.size || 'w-full'
    },

    hasSize() {
      return this.field.size !== undefined;
    },
  },
}
</script>
