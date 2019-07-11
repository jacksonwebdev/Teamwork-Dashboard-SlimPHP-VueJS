import config from './config';
import globalCalls from './views/global';
import util from './util';
import Vue from 'vue';
import App from './vues/App.vue';


// Vue.config.productionTip = false;

// IIFE - Immediately Invoked Function Expression
(function($) {

    // The $ is now locally scoped 
    // document is ready. Try to keep all fireable code bootstrapped from here
	$(function() {
        registerEvents();
        initVue();
        globalCalls.initSemanticUI();
    });
    
    var registerEvents = function() {
        // events will go here
        util.log('event registration');
    }

    var initVue = function(){
        // bootstrap app
        new Vue({
            render: h => h(App),
        }).$mount('#dashboard-app');
        util.log('vue initiated');
    }

}( jQuery ) );
