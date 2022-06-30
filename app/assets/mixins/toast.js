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
            }
}
})
