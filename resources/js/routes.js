export default [

    { path: "/dashboard", component: require("./components/Dashboard.vue").default },
    { path: "/services", component: require("./components/Services.vue").default },
    { path: "/categories", component: require("./components/Categories.vue").default },
    { path: "/pages", component: require("./components/Pages.vue").default },
    { path: "/complaints", component: require("./components/Complaints.vue").default },
    { path: "/faqs", component: require("./components/Faqs.vue").default },
    { path: "/galleries", component: require("./components/Galleries.vue").default },
    { path: "/users", component: require("./components/Users.vue").default },
    { path: "/profile", component: require("./components/Profile.vue").default },
    { path: "/forms/validation", component: require("./components/Profile.vue").default },
    { path: "/bookings/authorization", component: require("./components/bookings/BookingAuthorization.vue").default },
    { path: "/bookings/task-assignments", component: require("./components/bookings/TaskAssignment.vue").default },
    { path: "/reports/bookings", component: require("./components/reports/BookingsReport.vue").default },
    { path: "/reports/payments", component: require("./components/reports/PaymentsReport.vue").default },
    { path: "/subscriptions", component: require("./components/Subscriptions.vue").default },

    { path: "*", component: require("./components/NotFound.vue").default }
];
