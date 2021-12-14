<template>
  <div class="panel-body">
    <div v-if="services">
      <div class="card" v-for="(service, serviceIndex) in services" :key="serviceIndex">
        <!-- <img src="" alt="Denim Jeans" style="width: 100%" /> -->
        <h1>{{ service.name }}</h1>
        <!-- <p class="price">$19.99</p> -->
        <!-- <p>
        Some text about the jeans. Super slim and comfy lorem ipsum lorem jeansum. Lorem
        jeamsun denim lorem jeansum.
      </p> -->
        <div>
          <router-link
            :to="{ name: 'service', params: { id: service.id } }"
            class="primary"
            >Want a service?</router-link
          >
          <br />
          <br />
          <button
            v-if="!service.users.some((usr) => usr.id === user.id)"
            @click="registerProvider(service.id)"
          >
            Want to Serve?
          </button>
        </div>
      </div>
    </div>
    <div v-else>
      <h1>No Services!</h1>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      services: null,
    };
  },
  created() {
    this.getServices();
  },
  methods: {
    async getServices() {
      let response = await this.$http.get("service");
      // console.log(response);
      if (response.error !== undefined) {
        alert(response.error);
        return;
      }
      this.services = response.data;
    },
    async registerProvider(serviceId) {
      let response = await this.$http.post("provider/register", {
        body: JSON.stringify({ serviceId: serviceId }),
      });
      // console.log(response);
      if (response.error !== undefined) {
        if (typeof response.error === "object") {
          response.error = response.error.join(", ");
        }
        this.$toasted.error(response.error);
        return;
      }

      const serviceIndex = this.services.findIndex((srv) => srv.id === serviceId);
      this.services[serviceIndex].users.push(this.user);

      this.$toasted.success("Succesfully registered as provider!");
    },
  },
};
</script>

<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
  float: left;
  margin: 10px;
}

.price {
  color: grey;
  font-size: 22px;
}

.card button,
.card a {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
  text-decoration: none;
}

.card button:hover,
.card a:hover {
  opacity: 0.7;
}

.primary {
  background-color: #097ecd !important;
  color: black !important;
}
</style>
