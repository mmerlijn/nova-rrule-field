<template>
    <div>
        <select v-model="every" @change="setValue"
                class="form-control form-select form-input-bordered mb-3">
            <option v-for="yearly in dict" :value="yearly.value">{{translate(yearly.value)}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "EveryYearSelector",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'INTERVAL=';
                }
            },
            locale: {
                type: String,
                default: () => {
                    return 'en';
                }
            }
        },
        data() {
            return {
                every: 1,
                dict: [
                    {value: 1, nl: "Elk jaar", en: "Every year"},
                    {value: 2, nl: "Om het jaar", en: "Every other year"},
                    {value: 3, nl: "Elk 3e jaar", en: "Every 3rd year"},
                    {value: 4, nl: "Elk 4e jaar", en: "Every 4th year"},
                    {value: 5, nl: "Elk 5e jaar", en: "Every 5th year"},
                    {value: 6, nl: "Elk 6e jaar", en: "Every 6th year"},
                    {value: 7, nl: "Elk 7e jaar", en: "Every 7th year"},
                    {value: 8, nl: "Elk 8e jaar", en: "Every 8th year"},
                    {value: 9, nl: "Elk 9e jaar", en: "Every 9th year"},
                ],
            }
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            }
        },
        created: function () {
            this.setForm();
        },
        methods: {
            translate: function (field) {
                return this.dict.find(x => x.value == field)[this.locale];
            },
            setForm() {
                this.every = this.value.split('=')[1]
            },
            setValue() {
                this.value = 'INTERVAL='+this.every;
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>