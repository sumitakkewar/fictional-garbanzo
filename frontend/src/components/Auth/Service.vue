<template>
  <div class="panel-body">
    <h1 v-if="services">{{ services.name }}</h1>
    <div v-if="providers.length > 0">
      <div
        class="card"
        v-for="(provider, providerIndex) in providers"
        :key="providerIndex"
      >
        <h1>{{ provider.name }}</h1>
        <div>
          <button
            class="primary"
            @click="
              () => {
                service_user_id = provider.pivot.id;
                displayModal = true;
              }
            "
          >
            Schedule Appointment!
          </button>
        </div>
      </div>
      <Modal
        v-if="displayModal"
        @on-close="
          () => {
            service_user_id = provider.pivot.id;
            displayModal = false;
          }
        "
      >
        <vue-form-generator
          :schema="schema"
          :model="model"
          :options="formOptions"
          @validated="onValidation"
        >
        </vue-form-generator>
        <button type="submit" @click.prevent="onSubmit" v-if="submitButton">
          Submit
        </button>
      </Modal>
    </div>
    <div v-else>
      <h1>No Providers!</h1>
    </div>
  </div>
</template>
<script>
import Modal from "./../Widgets/Modal";
import moment from "moment";

export default {
  data() {
    return {
      services: null,
      displayModal: false,
      service_user_id: null,
      submitButton: false,
      model: {
        scheduled_time: "",
        desc: "",
        address: "",
      },

      schema: {
        fields: [
          {
            type: "input",
            inputType: "date",
            label: "Scheduled Time",
            model: "scheduled_time",
            placeholder: "Scheduled Time",
            required: true,
            validator: "date",
          },
          {
            type: "input",
            inputType: "textarea",
            label: "Job Description",
            model: "desc",
            min: 15,
            required: true,
            validator: "string",
          },
          {
            type: "input",
            inputType: "textarea",
            label: "Job Address",
            model: "address",
            min: 15,
            required: true,
            validator: "string",
          },
        ],
      },

      formOptions: {
        validateAfterLoad: true,
        validateAfterChanged: true,
        validateAsync: true,
      },
    };
  },
  computed: {
    providers() {
      return this.services
        ? this.services.users.filter((usr) => usr.id !== this.user.id)
        : [];
    },
  },
  created() {
    this.getService();
  },
  methods: {
    async getService() {
      let response = await this.$http.get(`service/${this.$route.params.id}`);
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
      this.services = response.data;
    },
    onValidation(result) {
      this.submitButton = result;
    },
    async onSubmit() {
      let response = await this.$http.post(`service/book`, {
        body: JSON.stringify({
          ...this.model,
          scheduled_time: moment(this.model.scheduled_time).format("DD-MM-YYYY"),
          service_user_id: this.service_user_id,
          latitude: "21.00000",
          longitude: "79.000000",
        }),
      });
      // console.log(response);
      if (response.error !== undefined) {
        if (typeof response.error === "object") {
          response.error = response.error.join(", ");
        }
        this.$toasted.error(response.error);
        return;
      }
      this.$toasted.success("Appointment Booked Successfully!");
      this.service_user_id = null;
      this.displayModal = false;
    },
  },
  components: {
    Modal,
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

.card button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card button:hover {
  opacity: 0.7;
}

.primary {
  background-color: #097ecd !important;
  color: black !important;
}
</style>
