<template>
  <div class="modal" :class="{'is-active' : active}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ title }}</p>
        <button class="delete modal-close-btn" @click="closeModal" aria-label="close"> X</button>
      </header>
      <section class="modal-card-body">

        <div class="columns">
         <div class="column">
           <label for="selected_bot">Select bot or <span class="green pointer" @click="setEmptyBot">add new</span> </label>
            <select v-model="bot" id="selected_bot" class="select is-fullwidth" @change="channel = null; switch_act = 'bot'">
              <option v-for="b in $root.bots" :key="b.id" :value="b">
                {{ b.name }}
              </option>
            </select>
         </div>
          <div class="column">
            <label for="selected_channel">Select channel or <span class="green pointer" @click="setEmptyChannel">add new</span></label>
            <select  v-model="channel" id="selected_channel" class="select is-fullwidth" @change="bot = null ; switch_act = 'channel'"
            >
            <option v-for="(channel , index) in $root.channels" :key="index" :value="channel">
              {{ channel.name }}
            </option>
          </select>
          </div>
        </div>
        <div v-if="switch_act === 'bot'">
          <label for="name">Name</label>
          <input type="text" class="input is-normal" id="name" v-model="bot.name" />
          <div v-if="hasError('name')" >
            <sup class="red">{{ getErrorMessage('name') }}</sup>
          </div>
          <label for="token">Token</label>
          <input type="text" class="input is-normal" id="token" v-model="bot.token" />
          <div v-if="hasError('token')">
            <sup class="red" >{{ getErrorMessage('token') }}</sup>
          </div>
          <label class="checkbox" for="active">
            Active
            <input type="checkbox" id="active" v-model="bot.active" />
          </label>

          <div class="pt-2" @click="bot.is_webhook = !bot.is_webhook">
            <label class="checkbox" for="is_webhook" >Webhook</label>
              <span id="is_webhook" v-if="bot.is_webhook">
                <span class="green" >Active</span>
              </span>
              <span v-else>
                <span class="red" >UnActive</span>
              </span>
          </div>
          <div v-if="bot.id">
            <div  v-for="(button , index) in bot.botButtons" :key="index" class="columns">
              <div class="column">
                <label for="name_" >Name :<sup style="color: red">*</sup></label>
                <input type="text" class="input" id="name_" v-model="button.name">
              </div>
              <div class="column">
                <label for="callback">Callback <sup style="color: red">*</sup></label>
                <input type="text" class="input" id="callback" v-model="button.callback">
              </div>
            </div>
            <button class="button m-2" @click="addButton()">Add button</button>
          </div>
        </div>
        <div v-else>
          <label for="channel_name">Name</label>
          <input type="text" class="input is-normal" id="channel_name" v-model="channel.name" />
          <div v-if="hasError('name')" >
            <sup class="red">{{ getErrorMessage('name') }}</sup>
          </div>
          <label for="chat_id">Chat_id</label>
          <input type="text" class="input is-normal" id="chat_id" v-model="channel.chat_id" />
          <div v-if="hasError('chat_id')">
            <sup class="red" >{{ getErrorMessage('chat_id') }}</sup>
          </div>
        </div>



      </section>
      <footer class="modal-card-foot">
        <div v-if="switch_act === 'bot'">
         <span v-if="bot.id">
           <button   class="button is-success" @click="updateBot">Update</button>
           <button   class="button is-danger" @click="deleteBot">Delete</button>
         </span>
          <span v-else>
            <button class="button is-success m-2" @click="saveBot">Save</button>
          </span>
        </div>
        <div v-else>
          <span v-if="channel.id">
               <button   class="button is-success" @click="updateChannel">Update</button>
          <button   class="button is-danger" @click="deleteChannel">Delete</button>
          </span>
          <span v-else>
            <button class="button is-success" @click="saveChannel">Save</button>
          </span>
        </div>
          <button class="button" @click="closeModal" aria-label="close">
          Cancel
        </button>
      </footer>
    </div>
  </div>


</template>

<script>
export default {
  name: "ModalBot",
  props: ['title', 'active', 'size' , 'theme', 'border-top'],
  mixins: ['_toast' , 'getBots' , 'getChannels'],
  data() {
    return {
      error:[],
      switch_act : 'bot',
      bot:{
        name: "",
        token: "",
        active: true,
        is_webhook: false,
        botButtons: []
      },

      channel:{
        name: "",
        chat_id: ""
      },
    }
  },
  async created() {
    this.error = [];
    await this.getBots();
    await this.getChannels();
  },
  methods: {
    setEmptyBot(){
      this.bot= {
        name: "",
        token: "",
        active: true,
        is_webhook: false
      }
      this.switch_act = 'bot'
    },
    setEmptyChannel(){
      this.channel = {
        name: "",
        chat_id: ""
      }
      this.switch_act = 'channel'
    },

    closeModal() {
      this.$emit('closeModal', false)
    },
    addButton(){
      this.bot.botButtons.push({
        'name': "",
        'callback' : ""
      });
    } ,



    deleteButton(){


    },

    setError(data){
      if(typeof data !== 'undefined')
        this.error = data;
    },

    updateBot(){
      var current = this;
      axios.patch("/api/bot/" + this.bot.id, this.bot )
          .then(function (response) {
            current._toast(response.data.message, 'is-success')
            current.getBots();
          })
          .catch(function (error){
            if(error.response) {
              current.setError(error.response.data.details.violations);
              current._toast(error.response.data.message, 'is-danger')
            }
          });
      this.$nextTick();
    },
    deleteBot(){
      var current = this;
       axios.delete("/api/bot/" + this.bot.id, this.bot )
          .then(function (response) {
            current._toast(response.data.message, 'is-success')
            current.getBots();
          })
          .catch(function (error){
            if(error.response) {
              current._toast(error.response.data.message, 'is-danger')
            }
          });
      this.$nextTick();
      this.setEmptyBot();
    },
    saveBot(){
      var current = this;
      axios.post("/api/bot/create", this.bot )
          .then(function (response) {
            current._toast(response.data.message, 'is-success');
            current.getBots();
            this.closeModal();
          })
          .catch(function (error){
            if(error.response.data) {
              if(error.response.data.details.violations)
                current.setError(error.response.data.details.violations);
              current._toast(error.response.data.message, 'is-danger')
            }
          });
      this.$nextTick();
    },
    updateChannel(){
      var current = this;
      axios.patch("/api/channel/" + this.channel.id, this.channel )
          .then(function (response) {
            current._toast(response.data.message, 'is-success')
            current.getChannels();
          })
          .catch(function (error){
            if(error.response.data) {
              if(error.response.data.details.violations)
                current.setError(error.response.data.details.violations);
              current._toast(error.response.data.message, 'is-danger')
            }
          });
      this.$nextTick();
    },
    deleteChannel(){
      var current = this;
      axios.delete("/api/channel/" + this.channel.id, this.channel )
          .then(function (response) {
            current._toast(response.data.message, 'is-success');
            current.getChannels()
          })
          .catch(function (error){
            if(error.response) {
              current._toast(error.response.data.message, 'is-danger')
            }
          });
      this.$nextTick();
      this.setEmptyChannel();
    },
    saveChannel(){
      var current = this;
      axios.post("/api/channel/create", this.channel )
          .then(function (response) {
            current._toast(response.data.message, 'is-success');
            current.getChannels();
            current.closeModal();
          })
          .catch(function (error){
            if(error.response.data) {
              if(error.response.data.details.violations)
                current.setError(error.response.data.details.violations);
              current._toast(error.response.data.message, 'is-danger')
            }
          });
      this.$nextTick();
    },

    hasError(name){
      if(this.error.length > 0 && this.error.find(data => data.field === name)) return true
      else return false
    },

    getErrorMessage(name) {
      if(this.error.length > 0 && this.error.find(data => data.field === name))
        return  this.error.find(data => data.field === name).message
    }

  }

}
</script>

<style scoped>

.green{
  color: green;
}

.pointer{
  cursor: pointer;
}

</style>
