<template>
    <span>{{ field.value }}</span>
</template>

<script>
    export default {
        props: ['resourceName', 'field'],
        data() {
            return {
                dict: [{value:'YEARLY', nl:'jaar', en:'year'},
                    {value:'MONTHLY', nl:'maand', en:'month'},
                    {value:'WEEKLY', nl:'weken', en:'week'},
                    {value:'DAILY', nl:'dagen', en:'day'},
                    {value:'EVERY', nl:'Elke', en:'Every'},
                    {}
                        ]
            }
        },
        mounted: function()
            {
               // this.formatString();
            },
        methods: {
            formatString() {
                self = this;
                let readableString='';
                if(!this.field.value.match(/INTERVAL/g)){
                    readableString += self.translate('EVERY')+" ";
                }
                let params = this.field.value.split(";");

                params.forEach(function(param){
                    switch (param.split('=')[0]) {
                        case 'FREQ':
                            readableString+=self.translate(param.split('=')[1]);
                            break;
                        case 'INTERVAL':
                            if(param.split('=')[1]>1){
                                readableString = param.split('=')[1]+' '+readableString;
                            }
                            break;
                    }
                });
                this.field.value=readableString;

            },
            translate: function (field) {
                return this.dict.find(x => x.value == field)[this.field.locale || 'en'];
            },
        }
    }
</script>
