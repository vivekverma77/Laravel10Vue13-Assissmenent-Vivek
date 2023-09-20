import TasksPage from "../pages/TasksPage.vue";
import InfoPage from "../pages/InfoPage.vue";
import LoginPage from "../pages/LoginPage.vue";
import RegisterPage from "../pages/RegisterPage.vue";
import Dashboard from "../components/Dashboard.vue";
import DahboardLayout  from "../components/layouts/Default.vue";

const routes = [
  {
    path: "/",
    component: DahboardLayout,
    meta: {
      auth: true,
    },
    children: [
      {
          name: "dashboard",
          path: '/',
          component: TasksPage,
          meta: {
              title: `Dashboard`
          }
      }
   ]
  },
  {
    path: "/",
    component: DahboardLayout,
    meta: {
      auth: true,
    },
    children: [
      {
          name: "tasks",
          path: '/tasks',
          component: TasksPage,
          meta: {
              title: `Tasks`
          }
      }
   ]
  },
  {
    path: "/",
    component: DahboardLayout,
    meta: {
      auth: true,
    },
    children: [
      {
          name: "info",
          path: '/info',
          component: InfoPage,
          meta: {
              title: 'Info'
          }
      }
   ]
  },
  {
    path: "/login",
    component: LoginPage,
    name: "login",
    meta: {
      guest: true,
    },
  },
  {
    path: "/register",
    component: RegisterPage,
    name: "register",
    meta: {
      guest: true,
    },
  },
 
];

export default routes;
