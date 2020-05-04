<template>
    <div>
        <every-year-selector :value.sync="everyYearString" :locale="locale"></every-year-selector>
        <month-selector :value.sync="monthString" :locale="locale"></month-selector>
        <by-day-selector :value.sync="bydayString" :locale="locale"></by-day-selector>
    </div>
</template>

<script>
    import EveryYearSelector from "./EveryYearSelector";
    import MonthSelector from "./MonthSelector";
    import ByDaySelector from "./ByDaySelector";
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
            }

        },
        components: {
            'by-day-selector': ByDaySelector,
            'month-selector': MonthSelector,
            'every-year-selector':EveryYearSelector,

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
                        case 'BYMONTH':
                            self.monthString = val;
                            break;
                        case 'BYDAY':
                            self.bydayString = val;
                            break;
                    }
                });
            },
            setValue() {
                this.value = ('FREQ=YEARLY;'+this.everyYearString+';'+this.monthString+';'+this.bydayString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>