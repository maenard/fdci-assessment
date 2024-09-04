<template>
  <q-layout>
    <q-page-container>
      <h1>Thank you for registering</h1>
      <CustomButton label="Continue" @click="redirect"/>
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineAsyncComponent } from 'vue'

export default {
  name: 'ThankYou',
  components: {
    CustomButton: defineAsyncComponent(() => import('components/Widgets/CustomButton.vue')),
  },
  methods: {
    redirect(){
      this.$router.push('/contacts')
    }
  },
}
</script>
