<template>
    <div class="modal" :class="{'is-active' : active}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Create new Job</p>
          <button class="delete modal-close-btn" @click="closeModal" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <label for="name">Name</label>
            <input type="text" class="input" id="name" :value="data.name" />
            <label for="url">Url</label>
            <input type="text" class="input" id="url" :value="data.url" />

            <label for="date" @click="data.date = date">Start date: {{ date }}</label>
            <input type="datetime-local" class="input" id="date" :value="data.date"  />

            <label class="checkbox" for="active" >
              Active
              <input type="checkbox" id="active" :value="data.active" />
            </label>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">Save changes</button>
          <button class="button" @click="closeModal" aria-label="close">
            Cancel
          </button>
        </footer>
      </div>
    </div>
</template>

<script>

export default {
  name: "Modal",
  props: ['title', 'active', 'size' , 'theme', 'border-top'],
  data() {
    return {
      date: this.formatDate(new Date()),
      data:{
        name : "",
        url: "https://",
        date: "",
        active: true
      }
    }
  },
  methods: {
    /**
     * Emits close event to opened modal
     */
    closeModal() {
      this.$emit('closeModal', false)
    },

    padTo2Digits(num) {
        return num.toString().padStart(2, '0');
    },

    formatDate(date) {
      return (
          [
            date.getFullYear(),
            this.padTo2Digits(date.getMonth() + 1),
            this.padTo2Digits(date.getDate()),
          ].join('-') +
          ' ' +
          [
            this.padTo2Digits(date.getHours()),
            this.padTo2Digits(date.getMinutes()),
            this.padTo2Digits(date.getSeconds()),
          ].join(':')
      );
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
