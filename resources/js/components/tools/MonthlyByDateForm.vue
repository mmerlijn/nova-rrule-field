<template>
<div>
    <every-month-selector :value.sync="everyMonthString" :locale="locale"></every-month-selector>
    <day-of-the-month-selector  :value.sync="dayofthemonthString"
                                :locale="locale"></day-of-the-month-selector>
</div>
</template>

<script>
    import EveryMonthSelector from "./EveryMonthSelector";
    import DayOfTheMonthSelector from "./DayOfTheMonthSelector";

    export default {
        name: "MonthlyByDateForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=MONTHLY;INTERVAL=1;BYMONTHDAY=1';
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
                dayofthemonthString: 'BYMONTHDAY=1',
                everyMonthString: "INTERVAL=1",
            }

        },
        components: {
            DayOfTheMonthSelector,
            'every-month-selector': EveryMonthSelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            dayofthemonthString: function () {
                this.setValue();
            },
            everyMonthString: function(){
                this.setValue();
            },
        },
        created: function () {
            this.setForm();
        },
        methods: {
            translate: function (field) {
                return this.dict.find(x => x.value == field)[this.locale];
            },
            setForm() {
                self = this;
                let params = this.value.split(';');
                params.forEach(function(val){

                    switch(val.split('=')[0]){
                        case 'INTERVAL':
                            self.everyMonthString = val;
                            break;
                        case 'BYMONTHDAY':
                            self.dayofthemonthString = val;
                            break;
                    }
                });
            },
            setValue() {
                this.value = ('FREQ=MONTHLY;'+this.everyMonthString+';'+this.dayofthemonthString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>
