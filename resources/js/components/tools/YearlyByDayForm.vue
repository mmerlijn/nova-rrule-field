<template>
    <div>
        <EveryXSelector period="years" v-model="everyYearString" :locale="locale"/>
        <MonthSelector v-model="monthString" :locale="locale"/>
        <ByDaySelector v-model="byDayString" :locale="locale"/>
    </div>
</template>
<script setup>

import MonthSelector from "./MonthSelector.vue";
import EveryXSelector from "./EveryXSelector.vue";
import ByDaySelector from "./ByDaySelector.vue";
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=YEARLY;BYMONTH=;BYDAY='
    },
    locale: {
        type: String,
        default: 'en',
    }
})

//refs
const monthString = ref("BYMONTH=")
const everyYearString = ref("")
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
        value.value = 'FREQ=YEARLY;BYMONTH=;BYDAY='
    }
    setForm()
})
watch(monthString, () => {
    setValue()
})
watch(everyYearString, () => {
    setValue()
})
watch(byDayString, () => {
    setValue()
})
onMounted(() => {
    if (!value.value) {
        value.value = 'FREQ=YEARLY;BYMONTH=;BYDAY='
    }
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale]
}

const setForm = () => {
    everyYearString.value = value.value.split(';').find(x => x.includes('INTERVAL')) || ''
    monthString.value = value.value.split(';').find(x => x.includes('BYMONTH')) || 'BYMONTH='
    byDayString.value = value.value.split(';').find(x => x.includes('BYDAY')) || 'BYDAY='
}
const setValue = () => {
    value.value = (
        'FREQ=YEARLY;' +
        (everyYearString.value.length ? everyYearString.value + ';' : '') +
        monthString.value + ';' +
        byDayString.value
    ).replace(/;+$/g, '')
}
</script>
