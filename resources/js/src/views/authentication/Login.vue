<template>
    <div class="auth-wrapper auth-v1">
      <div class="auth-inner">
        <v-card class="auth-card">
          <!-- logo -->
          <v-card-title class="d-flex align-center justify-center py-7">

            <router-link
              to="/"
              class="d-flex align-center"
            >
              <v-img
                src="./assets/images/logos/logo.svg"
                max-height="30px"
                max-width="30px"
                alt="logo"
                contain
                class="me-3 "
              />

              <h2 class="text-2xl font-weight-semibold">
                Materio
              </h2>
            </router-link>
          </v-card-title>

          <!-- title -->
          <v-card-text>
            <p class="text-2xl font-weight-semibold text--primary mb-2">
              Welcome! 👋🏻
            </p>
            <p class="mb-2">
              {{ $t('message.login') }}
            </p>
          </v-card-text>

          <!-- login form -->
          <v-card-text>
            <validation-observer
              ref="observer"
              v-slot="{ invalid }"
            >
              <form @submit.prevent="login">
                <validation-provider
                  v-slot="{ errors }"
                  :name="$t('form.email')"
                  rules="required|email"
                >
                  <v-text-field
                    id="email"
                    required
                    v-model="emailForm"
                    :error-messages="errors"
                    outlined
                    hide-details
                    :label="$t('form.email')"
                    placeholder="john@example.com"
                    class="mb-3"
                  />
                </validation-provider>
                <validation-provider
                  v-slot="{ errors }"
                  :name="$t('form.password')"
                  rules="required"
                >
                  <v-text-field
                    name="password"
                    required
                    v-model="passwordForm"
                    :error-messages="errors"
                    outlined
                    hide-details
                    :type="isPasswordVisible ? 'text' : 'password'"
                    :label="$t('form.password')"
                    placeholder="············"
                    :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                    @click:append="isPasswordVisible = !isPasswordVisible"
                  />
                </validation-provider>
                <div class="d-flex align-center justify-space-between flex-wrap">
                  <div/>

                  <!-- forgot link -->
                  <a
                    href="javascript:void(0)"
                    class="mt-5"
                  >
                    {{ $t('message.forgot_password') }}
                  </a>
                </div>

                <v-btn
                  block
                  color="primary"
                  class="mt-6"
                  @click="login"
                  :disabled="invalid"
                >
                  Login
                </v-btn>
              </form>
            </validation-observer>
          </v-card-text>

          <!-- create new account  -->
          <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2">
            New on our platform?
          </span>
            <router-link :to="{name:'auth-register'}">
              Create an account
            </router-link>
          </v-card-text>

          <!--        &lt;!&ndash; divider &ndash;&gt;
                  <v-card-text class="d-flex align-center mt-2">
                    <v-divider/>
                    <span class="mx-5">or</span>
                    <v-divider/>
                  </v-card-text>

                  &lt;!&ndash; social links &ndash;&gt;
                  <v-card-actions class="d-flex justify-center">
                    <v-btn
                      v-for="link in socialLink"
                      :key="link.icon"
                      icon
                      class="ms-1"
                    >
                      <v-icon :color="$vuetify.theme.dark ? link.colorInDark : link.color">
                        {{ link.icon }}
                      </v-icon>
                    </v-btn>
                  </v-card-actions>-->
        </v-card>
      </div>

      <!-- background triangle shape  -->
      <img
        class="auth-mask-bg"
        height="173"
        :src="`./assets/images/misc/mask-${$vuetify.theme.dark ? 'dark':'light'}.png`"
      >

      <!-- tree -->
      <v-img
        class="auth-tree"
        width="247"
        height="185"
        src="./assets/images/misc/tree.png"
      />

      <!-- tree  -->
      <v-img
        class="auth-tree-3"
        width="377"
        height="289"
        src="./assets/images/misc/tree-3.png"
      />
    </div>
</template>

<script>
import { email, max, required } from 'vee-validate/dist/rules'
import { mdiEyeOffOutline, mdiEyeOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'

export default {
    setup() {
        const isPasswordVisible = ref(false)
        const emailForm = ref('')
        const passwordForm = ref('')

        function login() {
            this.$refs.observer.validate().then(value => {
                const data = {
                    emailOrUsername: emailForm.value,
                    password: passwordForm.value,
                }
                this.$store.dispatch('api/auth/login', data).then(res => {
                }).catch(error => {
                })
            })
        }

        return {
            login,
            isPasswordVisible,
            emailForm,
            passwordForm,

            required,
            email,
            max,

            icons: {
                mdiEyeOutline,
                mdiEyeOffOutline,
            },
        }
    },
}
</script>

<style lang="scss">
@import '~@resources/sass/preset/pages/auth.scss';
</style>
