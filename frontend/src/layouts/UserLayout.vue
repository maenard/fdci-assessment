<template>
  <q-layout view="hHh lpr lfr">

    <q-page-container>
      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script>
import { defineComponent, defineAsyncComponent } from 'vue';

export default defineComponent({
  name: 'AdminLayout',
  components: {
    //AppHeader: defineAsyncComponent(() => import('components/AppHeader/AppHeader.vue')),
    //SideNav: defineAsyncComponent(() => import('components/SideNav/SideNav.vue')),
  },
});
</script>
