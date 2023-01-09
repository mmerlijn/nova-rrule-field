<template>
    <div>
        <EveryXSelector period="months" v-model="everyMonthString" :locale="locale"/>

        <DayOfTheMonthSelector v-model="dayOfTheMonthString"
                               :locale="locale"/>
    </div>
</template>
<script setup>

import DayOfTheMonthSelector from "./DayOfTheMonthSelector.vue";
import EveryXSelector from "./EveryXSelector.vue";
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=MONTHLY;BYMONTHDAY='
    },
    locale: {
        type: String,
        default: 'en',
    }
})
const dayOfTheMonthString = ref('BYMONTHDAY=')
const everyMonthString = ref('')

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
        value.value = 'FREQ=MONTHLY;BYMONTHDAY='
    }
    setForm()
})
watch(everyMonthString, () => {
    setValue()
})
watch(dayOfTheMonthString, () => {
    setValue()
})
onMounted(() => {
    if (!value.value) {
        value.value = 'FREQ=MONTHLY;BYMONTHDAY='
    }
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale]
}
const setForm = () => {
    everyMonthString.value = value.value.split(';').find(x => x.includes('INTERVAL')) || ''
    dayOfTheMonthString.value = value.value.split(';').find(x => x.includes('BYMONTHDAY')) || 'BYMONTHDAY='
}
const setValue = () => {
    value.value = (
        'FREQ=MONTHLY;' +
        (everyMonthString.value.length ? everyMonthString.value + ';' : '') +
        dayOfTheMonthString.value
    ).replace(/;+$/g, '')
}
</script>
