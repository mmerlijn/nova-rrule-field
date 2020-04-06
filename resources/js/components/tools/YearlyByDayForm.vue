<template>
    <div>
        <every-year-selector :value.sync="everyYearString" :locale="locale"></every-year-selector>
        <month-selector :value.sync="monthString" :locale="locale"></month-selector>
        <by-day-selector :value.sync="bydayString" :locale="locale"></by-day-selector>
        <end-selector :value.sync="endString" :locale="locale"></end-selector>
    </div>
</template>

<script>
    import EveryYearSelector from "./EveryYearSelector";
    import MonthSelector from "./MonthSelector";
    import ByDaySelector from "./ByDaySelector";
    import EndSelector from "./EndSelector";
    export default {
        name: "MonthlyByDayForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYDAY=1MO';
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
                monthString: "BYMONTH=1",
                everyYearString: "INTERVAL=1",
                bydayString: 'BYDAY=1MO',
                endString: '',
            }

        },
        components: {
            'by-day-selector': ByDaySelector,
            'month-selector': MonthSelector,
            'every-year-selector':EveryYearSelector,
            'end-selector': EndSelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            monthString: function () {
                this.setValue();
            },
            everyYearString: function(){
                this.setValue();
            },
            bydayString: function(){
              this.setValue();
            },
            endString: function(){
                this.setValue();
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
                self = this;
                let params = this.value.split(';');
                params.forEach(function(val){

                    switch(val.split('=')[0]){
                        case 'INTERVAL':
                            self.everyYearString= val;
                            break;
                        case 'BYDAY':
                            self.bydayString = val;
                            break;
                        case 'UNTIL':
                            self.endString = val;
                            break;

                    }
                });
            },
            setValue() {
                this.value = ('FREQ=YEARLY;'+this.everyYearString+';'+this.monthString+';'+this.bydayString+';'+this.endString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>