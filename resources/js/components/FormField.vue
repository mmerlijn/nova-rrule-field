<template>
    <DefaultField :field="field"
                  :errors="errors"
                  :show-help-text="showHelpText"
                  :full-width-content="fullWidthContent">
        <template #field>
            <Rrule :locale="field.locale" :hide="field.hide" v-model="value" v-on:update:modelValue="handleChange"/>
            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import Rrule from "./tools/Rrule.vue";

export default {
    components: {Rrule},
    mixins: [FormField, HandlesValidationErrors],
    props: ['resourceName', 'resourceId', 'field'],
    methods: {
        handleChange(value) {
            this.value = value
        },
        /*
        * Set the initial, internal value for the field.
        */
        setInitialValue() {
            this.value = this.field.value || 'FREQ=DAILY'
            //console.log(this.value)
        },
        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },
    },


}
</script>

