import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';
import college from './modules/college';
import courses from './modules/courses';
import sections from './modules/sections';
import organizations from './modules/organization';
import announcement from './modules/announcement';
import students from './modules/students';
import members from './modules/members';
import message from './modules/message';
import payment from './modules/payment';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        college,
        courses,
        organizations,
        sections,
        students,
        members,
        announcement,
        payment,
        message,
    },
});