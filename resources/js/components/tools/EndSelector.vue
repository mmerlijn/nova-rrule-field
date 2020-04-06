<template>
    <div>
        <div class="flex-row">
            <button @click.prevent="buttonClick('repeat')" class="bg-primary m-3 p-2 rounded min-w-8">
                {{translate('repeat')}}
            </button>
            <button @click.prevent="buttonClick('until')" class="bg-primary m-3 p-2 rounded min-w-8">
                {{translate('until')}}
            </button>
            <button @click.prevent="buttonClick('occurrence')" class="bg-primary m-3 p-2 rounded min-w-8">
                {{translate('occurrence')}}
            </button>
        </div>
        <input type="date" v-model="until" class="form-control form-input-bordered form-input mb-3"
               v-if="end==='until'" @change="setValue">
        <input type="number" min="1" v-model="occurrence" class="form-control form-input form-input-bordered mb-3"
               v-if="end==='occurrence'" @change="setValue">
        <p v-if="end==='repeat'">{{translate('never_ending')}}</p>
        <br>
    </div>
</template>

<script>
    export default {
        name: "EndSelector",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return '';
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
                dict:
                    [
                        {value: 'add_month', nl: "Maand toevoegen...", en: "Add a month..."},
                        {value: 'add_day', nl: "Dag toevoegen...", en: "Add a day..."},
                        {value: 'repeat', nl: "Herhaal", en: 'repeat'},
                        {value: 'until', nl: 'Tot', en: 'Until'},
                        {value: 'occurrence', nl: 'Aantal herhalingen', en: 'Occurrence(s)'},
                        {value: 'never_ending', nl: 'Tot oneindig blijven herhalen', en: 'Never ending repeat'}
                    ]
                ,
                end: 'repeat',
                until: new Date().toJSON().slice(0,10),
                occurrence: 1,
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
                switch (this.value.split('=')[0]) {
                    case 'UNTIL':

                        let d = this.value.split('=')[1];
                        this.until = d.substring(0, 4) + '-' + d.substring(4, 6) + '-' + d.substring(6, 8);
                        this.end = 'until';
                        break;
                    case 'COUNT':
                        this.occurrence = this.value.split('=')[1];
                        this.end = 'occurrence';
                        break;
                    default:
                        this.end = 'repeat';
                }
            },
            setValue() {
                let endString = '';
                switch (this.end) {
                    case 'repeat':
                        endString = '';
                        break;
                    case 'until':
                        endString += 'UNTIL=' + this.until.split("-").join("") + "T000000Z";
                        break;
                    case 'occurrence':
                        endString += 'COUNT=' + this.occurrence;
                        break;
                }
                this.value = endString;
                this.$emit('update:value', this.value);
            },
            buttonClick(val){
                this.end = val;
                this.setValue();
            }
        }
    }
</script>

<style scoped>

</style>