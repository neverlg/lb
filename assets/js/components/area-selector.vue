<template>
    <em>
        <select class="txt2 txtnobar" id="area-province" @change="changeProvince"><option value="">请选择省</option><option v-for="province in provinces" :value="province.id">{{province.name}}</option></select>
        <select class="txt2" id="area-city" @change="changeCity"><option value="">请选择市</option><option v-for="city in cities" :value="city.id">{{city.name}}</option></select>
        <select class="txt2" id="area-district" @change="changeDistrict" :name="fieldName"><option value="">请选择区县</option><option v-for="district in districts" :value="district.id">{{district.name}}</option></select>
    </em>
</template>

<script>
    var areas = require('areas').areas;
    var provinceIds = require('areas').provinceIds;

    module.exports = {
        props:['name','selectdProvince','selectdCity','selectdDistrict'],
        data:function(){
            return {
                provinces:[],
                cities:[],
                districts:[],
                provinceId:'',
                cityId:'',
                districtId:'',
            };
        },
        watch: {
            provinces: function (values) {
                $('#area-province').val('');
            },
            cities: function (values) {
                $('#area-city').val('');
            },
            districts: function (values) {
                $('#area-district').val('');
            }
        },
        computed:{
            fieldName:function(){
                return this.name || 'areaId';
            }
        },
        mounted:function(){
            var self = this;

            var provinces = [],province;
            for (i in provinceIds){
                if (areas.hasOwnProperty(provinceIds[i])){
                    province = areas[provinceIds[i]];
                    provinces.push({id:province.i,name:province.n});
                }
            }
            this.provinces = provinces;

            var promise = new Promise(function (resolve, reject) {
                if (self.provinces.length > 0 && self.selectdProvince){
                    self.$nextTick(function () {
                        $('#area-province').val(self.selectdProvince);
                        self.changeProvince($('#area-province').get(0));
                        resolve();
                    })
                }
            }).then(function (){
                return new Promise(function (resolve, reject) {
                    if (self.cities.length > 0 && self.selectdCity){
                        self.$nextTick(function () {
                            $('#area-city').val(self.selectdCity);
                            self.changeCity($('#area-city').get(0));
                            resolve();
                        })
                    }
                });
            }).then(function(){
                if (self.districts.length > 0 && self.selectdDistrict){
                    self.$nextTick(function () {
                        $('#area-district').val(self.selectdDistrict);
                        self.changeDistrict($('#area-district').get(0));
                    })
                }
            });
        },
        methods:{
            changeProvince:function(event){
                // var self = this;
                var that = event.target || event;

                this.provinceId = that.value;
                this.cities = [];
                this.cityId = '';
                this.districts = [];
                this.districtId = '';

                if (areas.hasOwnProperty(this.provinceId)){
                    var cities = [],city;
                    province = areas[this.provinceId];
                    for (i in province['c']){
                        city = province['c'][i];
                        cities.push({id:city.i,name:city.n});
                    }
                    this.cities = cities;
                }

                this.$emit('select-province',$(that).parent(),this.provinceId,this.cities);
            },
            changeCity:function(event){
                // var self = this;
                var that = event.target || event;

                this.cityId = that.value;;
                this.districts = [];
                this.districtId = '';

                if (areas.hasOwnProperty(this.cityId)){
                    var districts = [],district;
                    city = areas[this.cityId];
                    for (i in city['c']){
                        district = city['c'][i];
                        districts.push({id:district.i,name:district.n});
                    }
                    this.districts = districts;
                }

                this.$emit('select-city',$(that).parent(),this.cityId,this.districts);
            },
            changeDistrict:function(event){
                var that = event.target || event;

                this.districtId = that.value;
                this.$emit('select-district',$(that).parent(),this.districtId);
            }
        }
    }
</script>