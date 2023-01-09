<template>
    <div>
        <EveryXSelector period="months" v-model="everyMonthString" :locale="locale"/>

        <ByDaySelector v-model="byDayString"
                       :locale="locale"/>
    </div>
</template>
<script setup>

import ByDaySelector from "./ByDaySelector.vue";
import EveryXSelector from "./EveryXSelector.vue";
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=MONTHLY;BYDAY='
    },
    locale: {
        type: String,
        default: 'en',
    }
})

//refs
const everyMonthString = ref('')
const byDayString = ref('BYDAY=')
const dict = []

const value = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})
watch(value, () => {
    if (!value.value) {
        value.value = 'FREQ=MONTHLY;BYDAY='
    }
    setForm()
})
watch(everyMonthString, () => {
    setValue()
})
watch(byDayString, () => {
    setValue()
})
onMounted(() => {
    if (!value.value) {
        value.value = 'FREQ=MONTHLY;BYDAY='
    }
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale]
}

const setForm = () => {
    everyMonthString.value = value.value.split(';').find(x => x.includes('INTERVAL')) || ''
    byDayString.value = value.value.split(';').find(x => x.includes('BYDAY')) || 'BYDAY='
}
const setValue = () => {
    value.value = ('FREQ=MONTHLY;' +
        (everyMonthString.value.length ? everyMonthString.value + ';' : '') +
        byDayString.value
    ).replace(/;+$/g, '')
}
</script>
