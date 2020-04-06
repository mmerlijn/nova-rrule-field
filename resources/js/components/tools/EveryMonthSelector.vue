<template>
    <div>
        <select v-model="every" @change="setValue"
                class="form-control form-select form-input-bordered mb-3">
            <option v-for="monthly in dict" :value="monthly.value">{{translate(monthly.value)}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "EveryMonthSelector",
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
                    {value: 1, nl: "Elke maand", en: "Every month"},
                    {value: 2, nl: "Om de maand", en: "Every other month"},
                    {value: 3, nl: "Elke 3e maand", en: "Every 3rd month"},
                    {value: 4, nl: "Elke 4e maand", en: "Every 4th month"},
                    {value: 5, nl: "Elke 5e maand", en: "Every 5th month"},
                    {value: 6, nl: "Elke 6e maand", en: "Every 6th month"},
                    {value: 7, nl: "Elke 7e maand", en: "Every 7th month"},
                    {value: 8, nl: "Elke 8e maand", en: "Every 8th month"},
                    {value: 9, nl: "Elke 9e maand", en: "Every 9th month"},
                    {value: 10, nl: "Elke 10e maand", en: "Every 10th month"},
                    {value: 11, nl: "Elke 11e maand", en: "Every 11th month"},
                    {value: 12, nl: "Elke 12e maand", en: "Every 12th month"},
                    {value: 18, nl: "Elke 18e maand", en: "Every 18th month"},
                    {value: 24, nl: "Elke 24e maand", en: "Every 24th month"},
                    {value: 36, nl: "Elke 36e maand", en: "Every 36th month"},
                    {value: 48, nl: "Elke 48e maand", en: "Every 48th month"},
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