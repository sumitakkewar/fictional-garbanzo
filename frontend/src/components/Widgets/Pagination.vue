<template>
  <div class="pagination">
    <a
      href="#"
      v-for="(link, linkIndex) in links"
      :class="[{ active: link.active }]"
      :key="linkIndex"
      v-html="link.label"
      @click.prevent="jumptoPage(link.url)"
      :disabled="link.url === null"
    ></a>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
      jumptoPage(url){
          if(url){
              this.$emit('on-page-click', url.split('=')[1])
          }
      }
  },
  props: ["links"],
};
</script>

<style>
.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
}

.pagination a.active {
  background-color: #4caf50;
  color: white;
  border-radius: 5px;
}

.pagination a:hover:not(.active) {
  background-color: #ddd;
  border-radius: 5px;
}
</style>
