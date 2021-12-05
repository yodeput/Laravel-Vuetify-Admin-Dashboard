<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ on, attrs }">
      <v-fade-transition mode="out-in">
        <v-icon
          :key="$vuetify.theme.dark"
          v-bind="attrs"
          v-on="on"
          @click="$vuetify.theme.dark = !$vuetify.theme.dark"
        >
          {{ $vuetify.theme.dark ? icons.mdiWeatherSunny : icons.mdiWeatherNight }}
        </v-icon>
      </v-fade-transition>
    </template>
    <span>{{ $vuetify.theme.dark ? $t('message.theme_light') : $t('message.theme_dark') }}</span>
  </v-tooltip>
</template>

<script>
import { mdiWeatherNight, mdiWeatherSunny } from '@mdi/js'

export default {
    setup() {
        return {
            icons: {
                mdiWeatherNight,
                mdiWeatherSunny,
            },
        }
    },
}
</script>

<style>
</style>
