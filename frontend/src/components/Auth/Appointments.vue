<template>
  <div class="panel-body">
    <div v-if="orders">
      <vue-form-generator :schema="schema" :model="model" @model-updated="getOrders">
      </vue-form-generator>
      <div class="card" v-for="(order, orderIndex) in orders.data" :key="orderIndex">
        <!-- <img src="" alt="Denim Jeans" style="width: 100%" /> -->
        <h1>{{ order.service_name }}</h1>
        <!-- <p class="price">$19.99</p> -->
        <p>Description: {{ order.desc }}</p>
        <p>Address: {{ order.desc }}</p>
        <p>Time: {{ beautifyDate(order.scheduled_time) }}</p>
        <p>Provider: {{ order.provider_name }}</p>
      </div>
      <br />
      <br />
      <Pagination :links="orders.links" @on-page-click="onPageClick" />
    </div>
    <div v-else>
      <h1>No Orders!</h1>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import Pagination from "./../Widgets/Pagination";
export default {
  data() {
    return {
      orders: null,
      model: {
        from_date: null,
        to_date: null,
      },

      schema: {
        fields: [
          {
            type: "input",
            inputType: "date",
            label: "From Date",
            model: "from_date",
            placeholder: "From Date",
          },
          {
            type: "input",
            inputType: "date",
            label: "To Date",
            model: "to_date",
            placeholder: "To Date",
          },
        ],
      },
    };
  },
  created() {
    this.getOrders();
  },
  methods: {
    onPageClick(pageNumber) {
      this.getOrders(pageNumber);
    },
    async getOrders(pageNumber) {
      const queryObject = {};

      if (this.model.from_date) {
        queryObject.from_date = this.parseDate(this.model.from_date);
      }
      if (this.model.to_date) {
        queryObject.to_date = this.parseDate(this.model.to_date);
      }

      if (this.model.from_date && this.model.to_date) {
        if (moment(this.model.to_date) < moment(this.model.from_date)) {
          this.model.to_date = null;
          this.$toasted.error("From Date can not be greater than To Date");
          return;
        }
      }

      if (pageNumber) {
        queryObject.page = pageNumber;
      }

      const url =
        "user/orders" +
        (Object.keys(queryObject).length !== 0
          ? "?" + this.buildQueryString(queryObject)
          : "");

      let response = await this.$http.get(url);
      // console.log(response);
      if (response.error !== undefined) {
        if (typeof response.error === "object") {
          response.error = Object.entries(response.error)
            .map((err) => err[1])
            .join(", ");
        }
        this.$toasted.error(response.error);
        return;
      }
      this.orders = response.data;
    },
  },
  components: {
    Pagination,
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

.card p {
  padding: 10px;
  text-align: left;
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
