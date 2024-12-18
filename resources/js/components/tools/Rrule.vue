<template>
    <div>
        <div class="m-2 p-2 border border-1 rounded border-gray-300">
            <select v-model="frequency" @change="setFrequency"
                    class="w-full block form-control form-select form-select-bordered dark:bg-gray-700 dark:text-gray-400 mb-3 rounded px-2">
                <option v-for="item in dict" :value="item.id">{{ translate(item.id) }}</option>
            </select>
        </div>
        <DailyForm v-if="frequency===1" v-model="rrule" :locale="props.locale"/>
        <WeeklyForm v-else-if="frequency===2" v-model="rrule" :locale="props.locale"/>
        <MonthlyByDayForm v-else-if="frequency===3" v-model="rrule" :locale="props.locale"/>
        <MonthlyByMonthDayForm v-else-if="frequency===4" v-model="rrule" :locale="props.locale"/>
        <YearlyByDayForm v-else-if="frequency===5" v-model="rrule" :locale="props.locale"/>
        <YearlyByMonthDayForm v-else-if="frequency===6" v-model="rrule" :locale="props.locale"/>
        <YearlyByWeekForm v-else-if="frequency===7" v-model="rrule" :locale="props.locale"/>
        <EndSelector v-model="endString" :locale="props.locale"/>
        <div class="m-2">
            <RruleHumans v-model="value" :locale="props.locale"/>
        </div>
        <input v-show="!hide"
               id="rrule_preview"
               type="text"
               class="w-full form-control form-input form-input-bordered bg-gray-100 cursor-not-allowed"
               v-model="value"
               readonly="readonly"
        />

        <p v-if="props.hasError" class="my-2 text-danger">
            {{ props.firstError }}
        </p>

    </div>
</template>

<script setup>

import RruleHumans from "./RruleHumans.vue";
import MonthlyByMonthDayForm from "./MonthlyByMonthDayForm.vue";
import MonthlyByDayForm from "./MonthlyByDayForm.vue";
import YearlyByDayForm from "./YearlyByDayForm.vue";
import YearlyByMonthDayForm from "./YearlyByMonthDayForm.vue";
import YearlyByWeekForm from "./YearlyByWeekForm.vue";
import WeeklyForm from "./WeeklyForm.vue";
import DailyForm from "./DailyForm.vue";
import EndSelector from "./EndSelector.vue";
import {computed, onMounted, ref, watch} from "vue";


const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=WEEKLY'
    },
    locale: {
        type: String,
        default: 'en',
    },
    hide: {
        type: Boolean,
        default: true,
    },
    hasError: Boolean,
    firstError: String,
})

//refs
const endString = ref('')
const rrule = ref('FREQ=DAILY');

const frequency = ref(1)
const dict = [
    {id: 1, nl: 'Dagelijks', en: 'Daily', value: 'DAILY', start: 'FREQ=DAILY'},
    {id: 2, nl: 'Wekelijks', en: 'Weekly', value: 'WEEKLY', start: 'FREQ=WEEKLY;BYDAY='},
    {
        id: 3,
        nl: 'Maandelijks bij dag',
        en: 'Monthly by day',
        value: 'MONTHLY',
        start: 'FREQ=MONTHLY;BYDAY='
    },
    {
        id: 4,
        nl: 'Maandelijks bij datum',
        en: 'Monthly by date',
        value: 'MONTHLY',
        start: 'FREQ=MONTHLY;BYMONTHDAY='
    },
    {
        id: 5,
        nl: 'Jaarlijks by dag',
        en: 'Yearly by day',
        value: 'YEARLY',
        start: 'FREQ=YEARLY;BYMONTH=;BYDAY='
    },
    {
        id: 6,
        nl: 'Jaarlijks bij datum',
        en: 'Yearly by date',
        value: 'YEARLY',
        start: 'FREQ=YEARLY;BYMONTH=;BYMONTHDAY='
    },
    {
        id: 7,
        nl: 'Jaarlijks bij weeknr',
        en: 'Yearly by week no',
        value: 'YEARLY',
        start: 'FREQ=YEARLY;BYWEEKNO=;BYDAY='
    },
]

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
        value.value = 'FREQ=WEEKLY'
    }
    setForm()
})
const setFrequency = () => {
    rrule.value = dict.find(x => x.id === frequency.value)['start']
    endString.value = ''
}
watch(rrule, () => {
    setValue()
})
watch(endString, () => {
    setValue()
})
onMounted(() => {
    if (!value.value) {
        value.value = 'FREQ=WEEKLY'
    }
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.id === field)[props.locale]
}

const setForm = () => {
    switch (value.value.split(';')[0].split('=')[1]) {
        case 'DAILY':
            frequency.value = 1;
            rrule.value = 'FREQ=DAILY;' + getAfter('DAILY;')
            break;
        case 'WEEKLY':
            frequency.value = 2;
            rrule.value = 'FREQ=WEEKLY;' + getAfter('WEEKLY;')
            break;
        case 'MONTHLY':
            if (value.value.match(/BYMONTHDAY/g)) {
                frequency.value = 4;
                rrule.value = 'FREQ=MONTHLY;' + getAfter('MONTHLY;')
            } else {
                frequency.value = 3;
                rrule.value = 'FREQ=MONTHLY;' + getAfter('MONTHLY;')
            }
            break;
        case 'YEARLY':
            if (value.value.match(/BYMONTHDAY/g)) {
                frequency.value = 6;
                rrule.value = 'FREQ=YEARLY;' + getAfter('YEARLY;')
            } else if (value.value.match(/BYWEEKNO/g)) {
                frequency.value = 7;
                rrule.value = 'FREQ=YEARLY;' + getAfter('YEARLY;')
            } else {
                frequency.value = 5;
                rrule.value = 'FREQ=YEARLY;' + getAfter('YEARLY;')
            }
            break;
    }
    if (value.value.includes('UNTIL')) {
        endString.value = value.value.split(';').find(x => x.includes('UNTIL'))
    } else if (value.value.includes('COUNT')) {
        endString.value = value.value.split(';').find(x => x.includes('COUNT'))
    } else {
        endString.value = ''
    }
}
const setValue = () => {
    value.value = (rrule.value.replace(/;*$/, '') + ';' + endString.value).replace(/;*$/, '')
}
const getAfter = (val) => {
    let rulePart = value.value.split(val)[1] || ''
    if (rulePart.includes('UNTIL')) {
        rulePart = rulePart.split('UNTIL')[0].replace(/;*$/, '')
    } else if (rulePart.includes('COUNT')) {
        rulePart = rulePart.split('COUNT')[0].replace(/;*$/, '')
    }
    return rulePart.replace(/;*$/, '')
}
</script>

