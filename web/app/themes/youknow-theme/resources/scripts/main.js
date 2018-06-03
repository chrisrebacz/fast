import Vue from 'vue';

import WasThisHelpful from './components/WasThisHelpful.vue';

Vue.component('was-this-helpful', WasThisHelpful);

var app = new Vue({
    el: "#content"
});
