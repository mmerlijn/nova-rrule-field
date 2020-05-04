<template>
    <div>
        <every-year-selector :value.sync="everyYearString" :locale="locale"></every-year-selector>
        <month-selector :value.sync="monthString" :locale="locale"></month-selector>
        <day-of-the-month-selector  :value.sync="dayofthemonthString"
                                    :locale="locale"></day-of-the-month-selector>
    </div>
</template>

<script>
    import EveryYearSelector from "./EveryYearSelector";
    import DayOfTheMonthSelector from "./DayOfTheMonthSelector";
    import MonthSelector from "./MonthSelector";

    export default {
        name: "YearlyByDateForm",
        props: {
            value: {
                type: String,
                //required: true,
//                default: () => {
//                    return 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYMONTHDAY=1';
//                }
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
                everyYearString: 'INTERVAL=1',
                monthString: "BYMONTH=1",
                dayofthemonthString: 'BYMONTHDAY=1',
            }

        },
        components: {
            MonthSelector,
            DayOfTheMonthSelector,
            'every-year-selector': EveryYearSelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            everyYearString: function () {
                this.setValue();
            },
            monthString: function(){
                this.setValue();
            },
            dayofthemonthString: function(){
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
                            self.everyYearString = val;
                            break;
                        case 'BYMONTH':
                            self.monthString = val;
                            break;
                        case 'BYMONTHDAY':
                            self.dayofthemonthString = val;
                            break;
                    }
                });
            },
            setValue() {
                this.value = ('FREQ=YEARLY;'+this.everyYearString+';'+this.monthString+';'+this.dayofthemonthString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>
