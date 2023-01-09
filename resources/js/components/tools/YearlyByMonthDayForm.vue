<template>
    <div>
        <EveryXSelector period="years" v-model="everyYearString" :locale="locale"/>
        <MonthSelector v-model="monthString" :locale="locale"/>

        <DayOfTheMonthSelector v-model="dayOfTheMonthString"
                               :locale="locale"/>
    </div>
</template>
<script setup>

import DayOfTheMonthSelector from "./DayOfTheMonthSelector.vue";
import EveryXSelector from "./EveryXSelector.vue";
import MonthSelector from "./MonthSelector.vue";
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=YEARLY;BYMONTH=;BYMONTHDAY='
    },
    locale: {
        type: String,
        default: 'en',
    }
})
const everyYearString = ref('')
const monthString = ref("BYMONTH=")
const dayOfTheMonthString = ref('BYMONTHDAY=')


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
        value.value = 'FREQ=YEARLY;BYMONTH=;BYMONTHDAY='
    }
    setForm()
})
watch(everyYearString, () => {
    setValue()
})
watch(monthString, () => {
    setValue()
})
watch(dayOfTheMonthString, () => {
    setValue()
})
onMounted(() => {
    if (!value.value) {
        value.value = 'FREQ=YEARLY;BYMONTH=;BYMONTHDAY='
    }
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale]
}
const setForm = () => {
    everyYearString.value = value.value.split(';').find(x => x.includes('INTERVAL')) || ''
    monthString.value = value.value.split(';').find(x => x.includes('BYMONTH')) || 'BYMONTH='
    dayOfTheMonthString.value = value.value.split(';').find(x => x.includes('BYMONTHDAY')) || 'BYMONTHDAY='
}
const setValue = () => {
    value.value =
        ('FREQ=YEARLY;' +
            (everyYearString.value.length ? everyYearString.value + ';' : '') +
            monthString.value + ';' +
            dayOfTheMonthString.value
        ).replace(/;+$/g, '')

}
</script>
