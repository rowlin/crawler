<template>
  <div>
    <div class="container pt-3">
      <div class="button" @click="showModal = true">
        Add new Job
      </div>
    </div>
    <modal :active="showModal"  size="lg" title="Add new Job" @closeModal="showModal = false"></modal>
  </div>
</template>

<script>
import Modal from "./Modal";
export default {
  name: "TopPanel",
  components:{ Modal },
  data(){
    return{
      showModal: false
    }
  }
}
</script>

<style scoped>

</style>
