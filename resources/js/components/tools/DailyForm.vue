<template>
    <div>
        <every-day-selector :value.sync="everyDayString" :locale="locale"></every-day-selector>
    </div>
</template>

<script>
    import EveryDaySelector from "./EveryDaySelector";
    export default {
        name: "DailyForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=DAILY;INTERVAL=1;';
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
                everyDayString: "INTERVAL=2",
            }

        },
        components: {
            'every-day-selector': EveryDaySelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            everyDayString: function () {
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
                            self.everyDayString= val;
                            break;
                    }
                });
            },
            setValue() {
                this.value = 'FREQ=DAILY;'+this.everyDayString;
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>