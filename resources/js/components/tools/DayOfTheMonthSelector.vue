<template>
    <div :class="['m-2 p-2 border border-1 rounded',error?'border-red-600  bg-red-50':'border-gray-300']">
        <strong>{{ translate(0) }}</strong>

        <table>

            <tr>
                <td>
                    <ul>
                        <li v-for="i in [1,2,3,4,5,6,7]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="days[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [8,9,10,11,12,13,14]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="days[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [15,16,17,18,19,20,21]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="days[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [22,23,24,25,26,27,28]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="days[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [29,30,31]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="days[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
</template>
<script setup>
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'BYMONTHDAY='
    },
    locale: {
        type: String,
        default: 'en',
    }
})

//refs
const error = ref(false)
const days = ref([false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false])
const dict = [
    {value: 0, nl: "Op deze dagen van de maand", en: 'On these days of the month'},
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
        value.value = 'BYMONTHDAY='
    }
    setForm()
})
onMounted(() => {
    value.value = value.value || 'BYMONTHDAY='
    setForm()
})
const testError = () => {
    error.value = !value.value.split('=')[1]?.length
}
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale];
}

const setForm = () => {
    testError()
    days.value = [false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false]
    if (value.value.length) {
        value.value.split('=')[1].split(',').forEach(val => {
            days.value[val] = true
        })
    }
}
const setValue = () => {
    let daysString = 'BYMONTHDAY='
    for (let i = 1; i < 32; i++) {
        if (days.value[i]) {
            daysString += i + ','
        }
    }
    value.value = daysString.replace(/,+$/g, '')
}

</script>

<style scoped>
ul {
    margin: 0;
    padding: 0;
}

li {
    margin: 0;
    padding: 0;
    list-style: none;
}

td {
    vertical-align: top;
}
</style>
