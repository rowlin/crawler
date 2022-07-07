<template>
    <div class="modal" :class="{'is-active' : active}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ title }}</p>
          <button class="delete modal-close-btn" @click="closeModal" aria-label="close"> X</button>
        </header>
        <section class="modal-card-body">
            <label for="name">Name</label>
            <input type="text" class="input is-normal" id="name" v-model="data.name" />
          <div v-if="hasError('name')" >
            <sup class="red">{{ getErrorMessage('name') }}</sup>
          </div>
          <label for="url">Url</label>
            <input type="text" class="input is-normal" id="url" v-model="data.url" />
          <div v-if="hasError('url')">
            <sup class="red" >{{ getErrorMessage('url') }}</sup>
          </div>
            <label class="checkbox" for="active" >
              Active
              <input type="checkbox" id="active" v-model="data.active" />
            </label>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" @click="saveJob">Save changes</button>
          <button class="button" @click="closeModal" aria-label="close">
            Cancel
          </button>
        </footer>
      </div>
    </div>
</template>

<script>

import _toast from '../mixins/toast'
export default {
  name: "Modal",
  props: ['title', 'active', 'size' , 'theme', 'border-top'],
  mixins: ['_toast'],
  data() {
    return {
      error:[],
      data:{
        name : "",
        url: "https://",
        active: false
      }
    }
  },
  created() {
    this.error = [];
  },
  methods: {
    closeModal() {
      this.$emit('closeModal', false)
    },

    setError(data){
      this.error = data;
    },

    saveJob(){
      var current = this;
      axios.post('/api/job/create', this.data )
          .then(function (response) {
            current.closeModal();
            current._toast(response.data.message, 'is-success')
          })
          .catch(function (error){
            if(error.response) {
              current.setError(error.response.data.details.violations);
              current._toast(error.response.data.message, 'is-danger')
            }
          });
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

<style scoped lang="scss">
.modal {
  z-index: 2000;
  overflow-y: scroll;
}
.fade {
  background: rgba(27, 30, 33, 0.4);
}
.modal-title{
  font-family: 'Montserrat', sans-serif;
  font-size: 18px;
  font-weight: 600;
}
.modal-content {
  height: auto;
  border-radius: 0.6rem;
}
button{
  font-size: 18px;
}
.demo__window{
  background-color: #ffffff;
  font-size: 37px;
  padding-top: 8px;
  padding-left: 10px;
}
.dark{
  color: #ffffff;
  font-size: 36px;
  padding-top: 8px;
  padding-left: 10px;
  @media screen and (max-width: 650px) {
    font-size: 30px;
  }
  @media screen and (max-width: 550px) {
    font-size: 22px;
  }
  @media screen and (max-width: 443px) {
    display: flex;
    min-width: 100%;
    justify-content: center;
    align-items: center;
    text-align: center;
  }
}
@media only screen and (max-width: 768px) {
  .modal {
    z-index: 2000;
    overflow-y: scroll;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0 !important;
  }
  .fade {
    background: rgba(27, 30, 33, 0.4);
  }
  .modal-dialog {
    width: 100%;
    max-width: none;
    height: 100%;
    margin: 0;
  }
  .modal-content {
    height: auto;
    border-radius: 0;
  }
}

</style>
