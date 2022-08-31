import _ from 'lodash';
window._ = _;

import 'bootstrap-sass';

window.$ = window.jQuery = import('jquery');

window.Vue = require('vue');

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
