const routes = [
  {
    path: '/',
    component: () => import('pages/Auth/SignIn.vue'),
  },

  {
    path: '/signup',
    component: () => import('pages/Auth/SignUp.vue'),
  },

  {
    path: '/forgot-password',
    component: () => import('pages/Auth/ForgotPassword.vue'),
  },

  {
    path: '/contacts',
    component: () => import('pages/User/Contacts.vue'),
  },

  {
    path: '/thankyou',
    component: () => import('pages/User/ThankYou.vue'),
  },


  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Public/Error/ErrorNotFound.vue')
  }
]

export default routes
