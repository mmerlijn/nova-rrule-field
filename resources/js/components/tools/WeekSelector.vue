<template>
    <div :class="['m-2 p-2 border border-1 rounded',error?'border-red-600':'border-gray-300']">
        <strong>{{ translate(0) }}</strong>
        <table>

            <tr>
                <td>
                    <ul>
                        <li v-for="i in [1,2,3,4,5,6,7,8,9,10]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="weeks[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [11,12,13,14,15,16,17,18,19,20]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="weeks[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [21,22,23,24,25,26,27,28,29,30]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="weeks[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [31,32,33,34,35,36,37,38,39,40]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="weeks[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [41,42,43,44,45,46,47,48,49,50]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="weeks[i]" @change="setValue" class="checkbox"><span
                                class="text-sm ml-2 mr-6">{{ i }}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [51,52]">
                            <label :for="'p'+i"><input :id="'p'+i" type="checkbox" v-model="weeks[i]" @change="setValue" class="checkbox"><span
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
        default: 'BYWEEKNO='
    },
    locale: {
        type: String,
        default: 'en',
    }
})

//refs
const error = ref(false)
const weeks = ref([false, false, false, false, false, false, false, false, false, false,
    false, false, false, false, false, false, false, false, false, false,
    false, false, false, false, false, false, false, false, false, false,
    false, false, false, false, false, false, false, false, false, false,
    false, false, false, false, false, false, false, false, false, false,
    false, false, false])
const dict = [{value: 0, nl: "Op deze weken van het jaar", en: 'On these weeks of the year'},]

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
        value.value = 'BYWEEKNO='
    }
    setForm()
})
onMounted(() => {
    value.value = value.value || 'BYWEEKNO='
    setForm()
})
const testError = () => {
    error.value = !value.value.split('=')[1]?.length
}
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale]
}

const setForm = () => {
    testError()
    weeks.value = [false, false, false, false, false, false, false, false, false, false,
        false, false, false, false, false, false, false, false, false, false,
        false, false, false, false, false, false, false, false, false, false,
        false, false, false, false, false, false, false, false, false, false,
        false, false, false, false, false, false, false, false, false, false,
        false, false, false]
    if (value.value.length) {
        value.value.split('=')[1].split(',').forEach(val => {
            weeks.value[val] = true
        })
    }
}
const setValue = () => {
    let weekString = 'BYWEEKNO='
    for (let i = 1; i < 53; i++) {
        if (weeks.value[i]) {
            weekString += i + ','
        }
    }
    value.value = weekString.replace(/,+$/g, '')
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
