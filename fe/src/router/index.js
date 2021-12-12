import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../views/auth/Login.vue';

import Management from '../views/admin/Management.vue';
import Home from '../views/admin/Dashboard.vue';
import College from '../views/admin/College.vue';
import Courses from '../views/admin/Courses.vue';
import Organization from '../views/admin/Organization.vue';
import Announcements from '../views/admin/Announcements.vue';
import Students from '../views/admin/Students.vue';
import Sections from '../views/admin/Sections.vue';

import Index from '../views/user/Index.vue';
import Members from '../views/user/Members.vue';
import Payments from '../views/user/Payments.vue';
import UserAnnouncement from '../views/user/UserAnnouncement.vue';
import UserChat from '../views/user/Chat.vue';

Vue.use(VueRouter);

const routes = [{
        path: '/',
        name: 'Login',
        meta: {
            hasUser: true,
        },
        component: Login,
    },
    {
        path: '/register',
        name: 'StudentRegister',
        component: () =>
            import ( /* webpackChunkName: "student-register" */ '../views/auth/StudentRegister.vue'),
    },
    {
        path: '/about',
        name: 'About',
        component: () =>
            import ( /* webpackChunkName: "about" */ '../views/About.vue'),
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        meta: { isAdmin: true, requiresLogin: true },
        component: Management,
        children: [{
                path: 'colleges',
                name: 'colleges',
                components: {
                    colleges: College,
                },
            },
            {
                path: 'courses',
                name: 'courses',
                components: {
                    courses: Courses,
                },
            },
            {
                path: 'sections',
                name: 'sections',
                components: {
                    sections: Sections,
                },
            },
            {
                path: 'organizations',
                name: 'organizations',
                components: {
                    organizations: Organization,
                },
            },
            {
                path: 'announcements',
                name: 'announcements',
                components: {
                    announcements: Announcements,
                },
            },
            {
                path: 'students',
                name: 'students',
                components: {
                    students: Students,
                },
            },
            {
                path: '/',
                redirect: { name: 'home' },
            },
        ],
    },
    {
        path: '/user',
        name: 'User',
        meta: { isUser: true, requiresLogin: true },
        component: Index,
        children: [{
                path: 'members',
                name: 'members',
                components: {
                    members: Members,
                },
            },
            {
                path: 'payments',
                name: 'payment',
                components: {
                    payment: Payments,
                },
            },
            {
                path: 'announcements',
                name: 'userannouncement',
                components: {
                    userannouncement: UserAnnouncement,
                },
            },
            {
                path: 'chat',
                name: 'chat',
                components: {
                    chat: UserChat,
                },
            },
        ],
    },
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresLogin) && !localStorage.getItem('auth')) {
        next({ name: 'Login' });
    } else if (to.matched.some((record) => record.meta.hasUser) && localStorage.getItem('auth') && localStorage.getItem('isAdmin')) {
        next({ name: 'Dashboard' });
    } else if (to.matched.some((record) => record.meta.hasUser) && localStorage.getItem('auth') && localStorage.getItem('isUser')) {
        next({ name: 'User' });
    } else {
        next();
    }
});

export default router;