<template>
  <div class="panel-body">
    <form>
      <vue-form-generator
        :schema="schema"
        :model="model"
        @validated="onValidation"
        :options="formOptions"
      >
      </vue-form-generator>
      <button type="submit" @click.prevent="onSubmit" v-if="submitButton">Submit</button>
    </form>
  </div>
</template>
<script>
import { AUTH, USER } from "./../../store";

export default {
  data() {
    return {
      submitButton: false,
      model: {
        password: "",
        email: "",
      },

      schema: {
        fields: [
          {
            type: "input",
            inputType: "email",
            label: "E-mail",
            model: "email",
            placeholder: "User's e-mail address",
            required: true,
            validator: "email",
          },
          {
            type: "input",
            inputType: "password",
            label: "Password",
            model: "password",
            min: 6,
            required: true,
            hint: "Minimum 6 characters",
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
  methods: {
    onValidation(result) {
      this.submitButton = result;
    },
    async onSubmit() {
      let response = await this.$http.post("login", {
        body: JSON.stringify(this.model),
      });

      if (response.error !== undefined) {
        if (typeof response.error === "object") {
          response.error = Object.entries(response.error)
            .map((err) => err[1])
            .join(", ");
        }
        this.$toasted.error(response.error);
        return;
      }

      this.setData({
        type: AUTH,
        data: response.data,
      });

      this.getUser();
    },

    async getUser() {
      let response = await this.$http.get("user");

      if (response.error !== undefined) {
        if (typeof response.error === "object") {
          response.error = Object.entries(response.error)
            .map((err) => err[1])
            .join(", ");
        }
        this.$toasted.error(response.error);
        return;
      }

      this.setData({
        type: USER,
        data: response.data,
      });

      this.$router.replace("services");
    },
  },
};
</script>
