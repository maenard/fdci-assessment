<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex justify-center items-center w-full">
        <q-form
          @submit="onSubmit"
          @reset="onReset"
          class="row shadow-xl md:w-2/4 w-full"
        >
          <div class="col-12 col-md-5 q-pa-lg bg-primary text-white">
            <div class="full-height flex flex-center column q-py-xl">
              <h4 class="text-center">Already Signed up?</h4>
              <p class="text-center">Sign in to your registered account now!</p>
              <span class="w-3/4">
                <CustomButton label="Sign in" btnClass="secondary-btn" type="reset" :onClick="navigateToSignIn" />
              </span>
            </div>
          </div>

          <div class="col-12 col-md-7 q-pa-lg">
            <div class="full-height flex flex-center column q-py-sm">
              <h2 class="text-center font-black">Sign up for an Account</h2>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <CustomInput :errorMessage="errors.name ? errors.name[0] : ''" :modelValue="form.name ?? ''" v-model="form.name" label="Name" inputClass="col-span-2 md:col-span-1" />
                <CustomInput :errorMessage="errors.email ? errors.email[0] : ''" :modelValue="form.email ?? ''" v-model="form.email" label="Email" type="email" inputClass="col-span-2 md:col-span-1" />
                <CustomInput :errorMessage="errors.password ? errors.password[0] : ''" :modelValue="form.password ?? ''" v-model="form.password" label="Password" type="password" inputClass="col-span-2 md:col-span-1" />
                <CustomInput :errorMessage="errors.confirm_password ? errors.confirm_password[0] : ''" :modelValue="form.confirm_password ?? ''" v-model="form.confirm_password" label="Confirm Password" type="password" inputClass="col-span-2 md:col-span-1" />
              </div>

              <CustomButton label="Sign up" type="submit" />
            </div>
          </div>
        </q-form>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import { ref } from 'vue'
import { api } from 'boot/axios'
import { useQuasar } from 'quasar'

export default {
  name: 'SignUp',
  components: {
    CustomButton: defineAsyncComponent(() => import('components/Widgets/CustomButton.vue')),
    CustomInput: defineAsyncComponent(() => import('components/Widgets/CustomInput.vue')),
  },
  data() {
    return {
      form: {},
      errors: {}
    };
  },
  watch:{
    form:{
      handler(value, oldValue){
        this.errors = {}
      },
      deep: true
    }

  },
  methods: {
    signUp() {
    },
    navigateToSignIn() {
      //NOTE: temporary routing
      this.$router.push('/');
    },

    async onSubmit(){
      await api.get('/sanctum/csrf-cookie')
      await api.post('/api/auth/register', this.form)
        .then((response) => {
          this.$router.push('/thankyou')
      })
      .catch((err) => {
        const { data, status, statusText } = err.response
        const { errors } = data
        this.errors = errors

        if (status == 401){
          this.$router.push('/')
        }

      })
    },
    onReset(){

    },
  }
}
</script>
