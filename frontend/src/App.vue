<template>
  <div id="app">
    <Navbar />
    <div class="main-content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Navbar from "./components/Widgets/Navbar";

export default {
  name: "App",
  components: {
    Navbar,
  },
};
</script>

<style>
.main-content {
  padding: 20px;
  margin-top: 40px;
}
</style>
