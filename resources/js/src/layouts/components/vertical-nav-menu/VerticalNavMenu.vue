<template>
  <v-navigation-drawer
    :value="isDrawerOpen"
    app
    color="transparent"
    floating
    width="260"
    class="app-navigation-menu"
    :right="$vuetify.rtl"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <!-- Navigation Header -->
    <div class="vertical-nav-header d-flex items-center ps-6 pe-5 pt-5 pb-2">
      <router-link
        to="/"
        class="d-flex align-center text-decoration-none"
      >
        <v-img
          :src="'./assets/images/logos/logo.svg'"
          max-height="30px"
          max-width="30px"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        />
        <v-slide-x-transition>
          <h2 class="app-title text--primary">
            MATERIO
          </h2>
        </v-slide-x-transition>
      </router-link>
    </div>

    <!-- Navigation Items -->
    <v-list
      expand
      shaped
      class="vertical-nav-menu-items pr-5"
    >
      <component
        :is="resolveNavItemComponent(item)"
        v-for="(item , index) in navMenu"
        :key="index"
        :to="{ name: item.route }"
        :item="item"
      />
    </v-list>
  </v-navigation-drawer>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
    mdiHomeOutline,
    mdiAlphaTBoxOutline,
    mdiEyeOutline,
    mdiCreditCardOutline,
    mdiTable,
    mdiFileOutline,
    mdiFormSelect,
    mdiAccountCogOutline,
} from '@mdi/js'
import { resolveVerticalNavMenuItemComponent as resolveNavItemComponent } from '@/layouts/utils'
import NavMenuSectionTitle from './components/NavMenuSectionTitle.vue'
import NavMenuGroup from './components/NavMenuGroup.vue'
import NavMenuLink from './components/NavMenuLink.vue'
import navItem from '@/navigation'
import { isUserLoggedIn } from '@/utils'

export default {
    components: {
        NavMenuSectionTitle,
        NavMenuGroup,
        NavMenuLink,
    },
    props: {
        isDrawerOpen: {
            type: Boolean,
            default: null,
        },
    },
    computed: {
        navMenu() {
            const isLoggedIn = isUserLoggedIn()
            if (isLoggedIn && isLoggedIn !== 'undefined') {
                const { menu } = this.$store.state.menu
                const menuArray = []
                menu.forEach((q, i) => {
                    if (q) {
                        if (q.is_header) {
                            menuArray.push({
                                header: true,
                                title: q.label,
                            })
                            if (q.children.length > 0) {
                                q.children.forEach((x, a) => {
                                    menuArray.push({
                                        title: x.label,
                                        route: x.route,
                                        icon: x.icon,
                                    })
                                })
                            }
                        } /* else if (q.is_group) {
                            const menuGroupChild = []
                            if (q.children.length > 0) {
                                q.children.forEach((x, a) => {
                                    menuGroupChild.push({
                                        title: x.label,
                                        route: x.route,
                                    })
                                })
                            }
                            menuArray.push({
                                title: q.label,
                                route: q.route,
                                bi: !q.icon.includes('Icon'),
                                icon: q.icon,
                                children: menuGroupChild,
                            })
                        } */ else {
                            menuArray.push({
                                title: q.label,
                                route: q.route,
                                icon: q.icon,
                            })
                            if (q.children.length > 0) {
                                q.children.forEach((x, a) => {
                                    menuArray.push({
                                        title: x.label,
                                        route: x.route,
                                        icon: x.icon,
                                    })
                                })
                            }
                        }
                    }
                })
                return menuArray
            }
            return []
        },
    },
    setup() {
        return {
            navItem,
            resolveNavItemComponent,
            icons: {
                mdiHomeOutline,
                mdiAlphaTBoxOutline,
                mdiEyeOutline,
                mdiCreditCardOutline,
                mdiTable,
                mdiFileOutline,
                mdiFormSelect,
                mdiAccountCogOutline,
            },
        }
    },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass/preset/variables.scss';

.app-title {
  font-size: 1.25rem;
  font-weight: 700;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.3px;
}

// ? Adjust this `translateX` value to keep logo in center when vertical nav menu is collapsed (Value depends on your logo)
.app-logo {
  transition: all 0.18s ease-in-out;
  .v-navigation-drawer--mini-variant & {
    transform: translateX(-4px);
  }
}

@include theme(app-navigation-menu) using ($material) {
  background-color: map-deep-get($material, 'background');
}

.app-navigation-menu {
  .v-list-item {
    &.vertical-nav-menu-link {
      ::v-deep .v-list-item__icon {
        .v-icon {
          transition: none !important;
        }
      }
    }
  }
}

// You can remove below style
// Upgrade Banner
.app-navigation-menu {
  .upgrade-banner {
    position: absolute;
    bottom: 13px;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>
