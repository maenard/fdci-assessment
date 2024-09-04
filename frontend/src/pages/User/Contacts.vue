<template>
  <q-layout>
    <q-page-container>
      <h1>Contacts</h1>
      <a @click="edit = !edit" style="cursor: pointer; color: blue;">Add</a>
      <a @click="logout" style="cursor: pointer; color: blue;">Logout</a>
      <CustomInput v-model="search" label="Search" type="text" @keyup.enter="getContacts()" />
      <div>
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="border: 1px solid; text-align: left;">Name</th>
              <th style="border: 1px solid; text-align: left;">Company</th>
              <th style="border: 1px solid; text-align: left;">Phone</th>
              <th style="border: 1px solid; text-align: left;">Email</th>
              <th style="border: 1px solid; text-align: left;"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="val in data" :key="val.id">
              <td style="border: 1px solid;">{{ val.name }}</td>
              <td style="border: 1px solid;">{{ val.company }}</td>
              <td style="border: 1px solid;">{{ val.phone }}</td>
              <td style="border: 1px solid;">{{ val.email }}</td>
              <td style="border: 1px solid;">
                <span>
                  <a @click="editItem(val)" style="cursor: pointer; color: blue;">Edit</a>
                  |
                  <a @click="deleteItem(val)" style="cursor: pointer; color: blue;">Delete</a>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <q-pagination
        v-model="current"
        :max="last_page"
        @click="paginate(index)"
        direction-links
      />

      <q-form
        v-if="edit"
        @submit="onSubmit"
        @reset="onReset"
        class="row w-full"
      >
        <div class="col-12 col-md-7 q-pa-lg">
          <div class="full-height flex flex-center column q-py-xl">
            <span class="w-3/4">
              <CustomInput :errorMessage="errors.name ? errors.name[0] : ''" v-model="form.name" label="Name" type="text" />
              <CustomInput :errorMessage="errors.company ? errors.company[0] : ''" v-model="form.company" label="Company" type="text" />
              <CustomInput :errorMessage="errors.phone ? errors.phone[0] : ''" v-model="form.phone" label="Phone" type="text" />
              <CustomInput :errorMessage="errors.email ? errors.email[0] : ''" v-model="form.email" label="Email" type="text" />
            </span>
            <span class="w-3/4 flex justify-between q-mt-md">
              <CustomButton label="Save" type="submit" />
            </span>
          </div>
        </div>

      </q-form>
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import { ref } from 'vue'
import { api } from 'boot/axios'
import { useQuasar } from 'quasar'

export default {
  name: 'ContactsView',
  components: {
    CustomButton: defineAsyncComponent(() => import('components/Widgets/CustomButton.vue')),
    CustomInput: defineAsyncComponent(() => import('components/Widgets/CustomInput.vue')),
  },
  data() {
    return {
      data: [],
      form: {},
      edit: false,
      errors: {},
      search: '',
      current: 1,
      last_page: 1
    };
  },

  watch: {
    current: {
      handler(value){
        this.getContacts()
      }
    },
  },
  methods: {
    editItem(val){
      this.form.id = val.id
      this.form.name = val.name
      this.form.company = val.company
      this.form.phone = val.phone
      this.form.email = val.email
      this.edit = true
    },
    async logout(){
      await api.post('/api/auth/logout', {}).then(res => {
        this.$router.push('/')
      })
      .catch((err) => {
        const { data, status, statusText } = err.response
        const { errors } = data
      })

    },
    async deleteItem(val){
      if (confirm('Are you sure you want to delete this?')) {
        await api.delete(`/api/contacts/delete/${val.id}`, {}).then(res => {
          const { message } = res.data
          alert(message)
          this.getContacts()
        })
        .catch((err) => {
          const { data, status, statusText } = err.response
          const { errors } = data
        })
      }
    },
    async getContacts(){
      const payload = {
        search: this.search ?? '',
        page: this.current ?? 1
      }
      await api.post('/api/contacts/index', payload).then(res => {
        const { body, details } = res.data
        this.data = body
        this.current = details.current_page
        this.last_page = details.last_page
      })
      .catch((err) => {
        const { data, status, statusText } = err.response
        const { errors } = data
      })
    },
    async onSubmit(){
      if (this.form.id){
        await api.patch(`/api/contacts/update/${this.form.id}`, this.form).then(res => {
          this.search = ""
          this.getContacts()
          this.edit = false
          this.form = {}
          this.errors = {}
        })
        .catch((err) => {
          const { data, status, statusText } = err.response
          const { errors } = data
          this.errors = errors
        })
      }else{
        await api.post('/api/contacts/store', this.form).then(res => {
          this.search = ""
          this.getContacts()
          this.edit = false
          this.form = {}
          this.errors = {}
        })
        .catch((err) => {
          const { data, status, statusText } = err.response
          const { errors } = data
          this.errors = errors
        })
      }

    }
  },
  mounted() {
    this.getContacts()
  }
}
</script>
