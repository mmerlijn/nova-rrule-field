<template>
    <div>
        <strong>{{translate(0)}}</strong>
        <table>

            <tr>
                <td>
                <ul>
                    <li v-for="i in [1,2,3,4,5,6,7]">
                        <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="days[i]" @change="setValue"><span
                                class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                    </li>
                </ul>
            </td>
                <td>
                    <ul>
                        <li v-for="i in [8,9,10,11,12,13,14]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="days[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [15,16,17,18,19,20,21]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="days[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [22,23,24,25,26,27,28]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="days[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [29,30,31]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="days[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
            </tr>
        </table>


    </div>
</template>

<script>
    export default {
        name: "DayOfTheMonthSelector",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'BYMONTHDAY=';
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
                daysNumbers: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
                days: [false, false, false, false, false, false, false, false, false, false, false, false, false,false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false],
                dict: [
                    {value: 0, nl: "Op deze dagen van de maand", en: 'On these days of the month'},
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
                this.days= [false, false, false, false, false, false, false, false, false, false, false, false, false,false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false],
                    params.forEach(function (value) {
                    self.days[value] = true;
                });
            },
            setValue() {
                let daysString = 'BYMONTHDAY=';
                for (let i = 1; i < 32; i++) {
                    if (this.days[i]) {
                        daysString += i + ',';
                    }
                }
                this.value = daysString.replace(/,+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>
    ul {margin:0;padding:0;}
    li {margin:0;padding:0;list-style:none;}
    td {vertical-align: top;}
</style>