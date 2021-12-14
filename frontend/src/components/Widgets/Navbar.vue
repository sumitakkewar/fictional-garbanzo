<template>
  <ul>
    <li
      :class="['nav-item'].concat(route.extra !== undefined ? route.extra.class : [])"
      v-for="(route, routeIndex) in isLoggedIn ? routes.auth : routes.nonAuth"
      :key="routeIndex"
    >
      <router-link :to="route.path">{{ route.name === "Profile" ? user.name : route.name }}</router-link>
    </li>
    <li :class="['nav-item', 'right']" v-if="isLoggedIn">
      <a href="#" @click.prevent="logoutUser">Logout</a>
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      routes: {
        auth: [
          {
            name: "Services",
            path: "/services",
          },
          {
            name: "Jobs",
            path: "/jobs",
          },
          {
            name: "Appintment",
            path: "/appointments",
          },
          {
            name: "Profile",
            path: "/profile",
            extra: {
              class: ["right"],
            },
          },
        ],
        nonAuth: [
          {
            name: "Login",
            path: "/",
          },
          {
            name: "Register",
            path: "/register",
          },
        ],
      },
    };
  },
  methods: {
    async logoutUser() {
      const response = await this.$http.get("user/logout");
      if (response.error !== undefined) {
        if (typeof response.error === "object") {
          response.error = response.error.join(", ");
        }
        this.$toasted.error(response.error);
        return;
      }
      this.logout();
      this.$router.replace("home");
    },
  },
};
</script>

<style>
body {
  margin: 0;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
  position: fixed;
  top: 0;
  width: 100%;
}

li,
.nav-item {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}

.active {
  background-color: #04aa6d;
}

.right {
  float: right !important;
}
</style>
