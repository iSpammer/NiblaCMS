/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueRouter from 'vue-router';
import {
    Form,
    HasError,
    AlertError
} from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import swal from 'sweetalert2';
import Gate from "./Gate";

window.Vue = require('vue');
Vue.prototype.$gate = new Gate(window.user);

window.Form = Form;
window.swal = swal;


import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})
window.toast = toast;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


Vue.use(VueRouter)
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '20px'
})



Vue.filter("upText", function (text) {
    return text.toUpperCase() + value.slice(1)
})
Vue.filter("myDate", function (Date) {
    return moment(Date).format("MMMM Do YYYY, h:mm:ss a")
})
window.Fire = new Vue();
//GLobal filter
// Vue.filter("date", function(created){
//    return   moment(created).formate("MMMM Do YYYY");
// })
// 0. If using a module system, call Vue.use(VueRouter)S

// 1. Define route components.
// These can be imported from other files

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.
const routes = [{
        path: '/profile',
        component: require('./components/Profile.vue').default
    },
    {
        path: '/home',
        component: require('./components/Dashboard.vue').default
    },
    {
        path: '/developer',
        component: require('./components/Developer.vue').default
    },
    {
        path: '/users',
        component: require('./components/Users.vue').default
    },
    {
        path: '/contracts',
        component: require('./components/Contract.vue').default
    },
    {
        path: '/agents',
        component: require('./components/Agent.vue').default
    }, {
        path: '/projects',
        component: require('./components/Project.vue').default
    },
    {
        path: '/invoice',
        component: require('./components/Invoice.vue').default
    },
    {
        path: '/*',
        component: require('./components/NotFound.vue').default
    }

]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    mode: "history",
    routes // short for routes: routes
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('stats-card', require('./components/StatesCard.vue').default);
Vue.component('ordered-table', require('./components/OrderedTable.vue').default);
Vue.component('chart-card', require('./components/ChartCard.vue').default);
Vue.component('profile-component', require('./components/Profile.vue').default);
Vue.component('dashboard-component', require('./components/Dashboard.vue').default);
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);



Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    el: '#app',
    data: {
        search: ''
    },
    created() {
        this.listenForChanges();

    },
    methods: {

        searchit() {
            Fire.$emit("searching");
        },
        printme() {
            window.print();
        },
        // searchit: _.debounce(() => {
        //     Fire.$emit('searching');
        // },1000),
        listenForChanges() {
            Echo.channel('contracts')
                .listen('ContractPublished', Contract => {
                    if (!('Notification' in window)) {
                        alert('Web Notification is not supported');
                        return;
                    }

                    Notification.requestPermission(permission => {
                        let notification = new Notification('New Contract alert!', {
                            body: Contract.contractName, // content for the alert
                            icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                        });

                        // link to page on clicking the notification
                        notification.onclick = () => {
                            window.open(window.location.href);
                        };
                    });
                })

            Echo.channel('contracts')
                .listen('ContractRemoved', Contract => {
                    if (!('Notification' in window)) {
                        alert('Web Notification is not supported');
                        return;
                    }

                    Notification.requestPermission(permission => {
                        let notification = new Notification('Contract Removed Alert!', {
                            body: Contract.contractName, // content for the alert
                            icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                        });

                        // link to page on clicking the notification
                        notification.onclick = () => {
                            window.open(window.location.href);
                        };
                    });
                })

            Echo.channel('contracts')
                .listen('ContractUpdated', Contract => {
                    if (!('Notification' in window)) {
                        alert('Web Notification is not supported');
                        return;
                    }
                    []
                    Notification.requestPermission(permission => {
                        let notification = new Notification('Contract Updated Alert!', {
                            body: Contract.contractName, // content for the alert
                            icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                        });

                        // link to page on clicking the notification
                        notification.onclick = () => {
                            window.open(window.location.href);
                        };
                    });
                })
            Echo.channel("agents").listen("AgentPublished", post => {
                if (!("Notification" in window)) {
                    alert("Web Notification is not supported");
                    return;
                }

                Notification.requestPermission(permission => {
                    let notification = new Notification("New Agent alert!", {
                        body: post.title, // content for the alert
                        icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                    });

                    // link to page on clicking the notification
                    notification.onclick = () => {
                        window.open(window.location.href);
                    };
                });
            });
            Echo.channel("agents").listen("AgentRemoved", post => {
                if (!("Notification" in window)) {
                    alert("Web Notification is not supported");
                    return;
                }

                Notification.requestPermission(permission => {
                    let notification = new Notification("New Agent alert!", {
                        body: post.title, // content for the alert
                        icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                    });

                    // link to page on clicking the notification
                    notification.onclick = () => {
                        window.open(window.location.href);
                    };
                });
            });
            Echo.channel("agents").listen("AgentUpdated", post => {
                if (!("Notification" in window)) {
                    alert("Web Notification is not supported");
                    return;
                }

                Notification.requestPermission(permission => {
                    let notification = new Notification("New Agent alert!", {
                        body: post.title, // content for the alert
                        icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                    });

                    // link to page on clicking the notification
                    notification.onclick = () => {
                        window.open(window.location.href);
                    };
                });
            });
        }
    }
});
