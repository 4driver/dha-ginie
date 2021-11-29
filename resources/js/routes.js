export default [

    { path: "/dashboard", component: require("./components/Dashboard.vue").default },
    { path: "/services", component: require("./components/Services.vue").default },
    { path: "/bookings", component: require("./components/Bookings.vue").default },
    { path: "/tasks", component: require("./components/Tasks.vue").default },
    { path: "/pages", component: require("./components/Pages.vue").default },
    { path: "/complaints", component: require("./components/Complaints.vue").default },
    { path: "/faqs", component: require("./components/Faqs.vue").default },
    { path: "/galleries", component: require("./components/Galleries.vue").default },
    { path: "/users", component: require("./components/Users.vue").default },
    { path: "/profile", component: require("./components/Profile.vue").default },
    { path: "/forms/validation", component: require("./components/Profile.vue").default },
    { path: "*", component: require("./components/NotFound.vue").default }
];
