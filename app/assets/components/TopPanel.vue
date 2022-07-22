<template>
  <div class="container">
    <div class="level m-2 mb-0">
      <div class="level-left">
            <button class="button is-primary m-2 is-rounded"
                    :class="{'is-info' : $root.active_job}"
                    @click="$root.active_job= !$root.active_job; getJobs()"  >
              <span v-if="$root.active_job">Active</span>
              <span v-else>Unactive</span>
            </button>
      </div>

      <div class="level-right">
      <div class="level-item" @click="showModal = true">
       <div class="button">Add new Job</div>
      </div>
      <div class="level-item " @click="showModal_bot = true">
        <div class="button">Add Bots</div>
      </div>
        <div class="level-item " @click="showModal_templates = true">
          <div class="button">Add Templates</div>
        </div>

      </div>
    </div>

    <modal :active="showModal"  size="lg" title="Add new Job" @closeModal="showModal = false"></modal>
    <modal-bot :active="showModal_bot" size="lg" title="Add new bot and Channel" @closeModal="showModal_bot = false"></modal-bot>
    <modal-templates :active="showModal_templates" size="lg" title="Add or edit Template" @closeModal="showModal_templates = false"></modal-templates>
  </div>
</template>

<script>
import getJobs from '../mixins/toast';
import ModalTemplates from "./ModalTemplates";
import Modal from "./Modal";
import ModalBot from "./ModalBot";
export default {
  name: "TopPanel",
  components:{ Modal , ModalBot ,ModalTemplates },
  mixins:['getJobs'],
  data(){
    return{
      showModal: false,
      showModal_bot : false,
      showModal_templates: false
    }
  }
}
</script>

<style scoped>

</style>
