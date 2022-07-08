import Vue from 'vue';
import {toast} from "bulma-toast";

Vue.mixin({
    methods:{
        _toast(message , type)
            {
                toast({
                    message: message,
                    type: type,
                    dismissible: true,
                    closeOnClick: true,
                })
            },
        async getJobs(){
            this.$root.jobs =  await axios.get('/api/jobs?active='+ this.$root.active_job).then(
                data => {
                    return data.data
                })
        },
        async  getBots(){
            this.$root.bots = await axios.get('api/bot').then(res => {return res.data})
        },

        async getChannels(){
            this.$root.channels =  await axios.get('api/channels').then(res => {return res.data})
        },


    }
})
