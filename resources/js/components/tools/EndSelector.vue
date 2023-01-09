<template>
    <div :class="['m-2 mb-4 p-2 border border-1 rounded',error?'border-red-600  bg-red-100':'border-gray-300']">
        <div class="flex gap-2">
            <button @click.prevent="buttonClick('repeat')" type="button" class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900">
                {{ translate('repeat') }}
            </button>
            <button @click.prevent="buttonClick('until')" type="button" class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900">
                {{ translate('until') }}
            </button>
            <input type="date" v-model="until" class="form-control form-input form-input-bordered mb-3"
                   v-if="end==='until'" @input="setValue">
            <button @click.prevent="buttonClick('occurrence')" type="button" class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900">
                {{ translate('occurrence') }}
            </button>
            <input type="number" min="1" v-model="occurrence" class="form-control form-input form-input-bordered mb-3 w-20"
                   v-if="end==='occurrence'" @input="setValue">
        </div>


        <p v-if="end==='repeat'">{{ translate('never_ending') }}</p>
        <p v-if="end==='until'">{{ translate('until') }} {{ until.substring(0, 10).split('-').reverse().join('-') }}</p>
        <p v-if="end==='occurrence'">{{ translate('occurrence') }} {{ occurrence }}</p>
    </div>
</template>
<script setup>
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    locale: {
        type: String,
        default: 'en',
    }
})

//refs
const error = ref(false)
const end = ref('repeat')
const until = ref(new Date().toJSON().slice(0, 10))
const occurrence = ref(1)
const dict = [
    {value: 'add_month', nl: "Maand toevoegen...", en: "Add a month..."},
    {value: 'add_day', nl: "Dag toevoegen...", en: "Add a day..."},
    {value: 'repeat', nl: "Herhaal", en: 'repeat'},
    {value: 'until', nl: 'Tot', en: 'Until'},
    {value: 'occurrence', nl: 'Aantal herhalingen', en: 'Occurrence(s)'},
    {value: 'never_ending', nl: 'Tot oneindig blijven herhalen', en: 'Never ending repeat'}
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
    setForm()
})
onMounted(() => {
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale];
}
const setForm = () => {
    error.value = false
    if (value.value.includes('UNTIL')) {
        let d = value.value.split(';').find(x => x.includes('UNTIL')).split('=')[1]
        if (d.length > 10) {
            until.value = d.substring(0, 4) + '-' + d.substring(4, 6) + '-' + d.substring(6, 8)
            end.value = 'until'
        } else {
            error.value = true
            end.value = 'until'
            until.value = ''
        }
    } else if (value.value.includes('COUNT')) {
        occurrence.value = value.value.split(';').find(x => x.includes('COUNT')).split('=')[1] || 1;
        end.value = 'occurrence'
    } else {
        end.value = 'repeat'
    }
}
const setValue = () => {
    if (end.value === 'until') {
        value.value = 'UNTIL=' + until.value.split("-").join("") + "T000000Z"
    } else if (end.value === 'occurrence') {
        value.value = 'COUNT=' + occurrence.value
    } else {
        value.value = ''
    }

}
const buttonClick = (val) => {
    end.value = val;
    setValue();
}
</script>

