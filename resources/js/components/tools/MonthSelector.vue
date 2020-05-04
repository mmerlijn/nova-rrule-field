<template>
    <div>
        <strong>{{translate(13)}}</strong>
        <table>
            <tr>
                <td>
                    <label for="JAN"><input id="JAN" type="checkbox" v-model="month[1]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(1)}}</span></label><br>
                    <label for="FEB"><input id="FEB" type="checkbox" v-model="month[2]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(2)}}</span></label><br>
                    <label for="MAA"><input id="MAA" type="checkbox" v-model="month[3]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(3)}}</span></label>
                </td>
                <td>
                    <label for="APR"><input id="APR" type="checkbox" v-model="month[4]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(4)}}</span></label><br>
                    <label for="MAY"><input id="MAY" type="checkbox" v-model="month[5]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(5)}}</span></label><br>
                    <label for="JUN"><input id="JUN" type="checkbox" v-model="month[6]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(6)}}</span></label>

                </td>
                <td>
                    <label for="JUL"><input id="JUL" type="checkbox" v-model="month[7]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(7)}}</span></label><br>
                    <label for="AUG"><input id="AUG" type="checkbox" v-model="month[8]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(8)}}</span></label><br>
                    <label for="SEP"><input id="SEP" type="checkbox" v-model="month[9]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(9)}}</span></label>
                </td>
                <td>
                    <label for="OCT"><input id="OCT" type="checkbox" v-model="month[10]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(10)}}</span></label><br>
                    <label for="NOV"><input id="NOV" type="checkbox" v-model="month[11]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(11)}}</span></label><br>
                    <label for="DEC"><input id="DEC" type="checkbox" v-model="month[12]" @change="setValue"><span
                            class="text-sm ml-3 mr-8">{{translate(12)}}</span></label>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "MonthSelector",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'BYMONTH=';
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
                month: [false, false, false, false, false, false, false, false, false, false, false, false, false],
                dict: [
                    {value: 1, nl: "Januari", en: 'January'},
                    {value: 2, nl: "Februari", en: 'February'},
                    {value: 3, nl: "Maart", en: 'March'},
                    {value: 4, nl: "April", en: 'April'},
                    {value: 5, nl: "Mei", en: 'May'},
                    {value: 6, nl: "Juni", en: 'June'},
                    {value: 7, nl: "Juli", en: 'July'},
                    {value: 8, nl: "Augustus", en: 'August'},
                    {value: 9, nl: "September", en: 'September'},
                    {value: 10, nl: "Oktober", en: 'October'},
                    {value: 11, nl: "November", en: 'November'},
                    {value: 12, nl: "December", en: 'December'},
                    {value: 13, nl: "In deze maanden", en: "In these months"}
                ]
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
                self = this;
                let params = this.value.split('=')[1].split(',');
                this.month = [false, false, false, false, false, false, false, false, false, false, false, false, false];
                params.forEach(function (value) {
                    self.month[value] = true;
                });
            },
            setValue() {
                let monthString = 'BYMONTH=';
                for (let i = 1; i < 13; i++) {
                    if (this.month[i]) {
                        monthString += i + ',';
                    }
                }
                this.value = monthString.replace(/,+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>