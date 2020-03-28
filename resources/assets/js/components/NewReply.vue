<template>
  <div>
    <div v-if="signedIn">
      <div class="form-group">
        <textarea
          name="body"
          id="body"
          class="form-control"
          cols="30"
          rows="3"
          placeholder="Have something to say?"
          required
          v-model="body"
        ></textarea>
      </div>
      <button type="submit" class="btn btn-default" @click="addReply">Reply</button>
    </div>
    <p v-if="!signedIn" class="center">
      Please
      <a href="/login">login</a> to reply.
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      body: ''
    };
  },

  computed: {
    signedIn() {
      return window.App.signedIn;
    }
  },

  methods: {
    addReply() {
      axios
        .post(location.pathname + '/replies', { body: this.body })
        .then(res => {
          this.body = '';
          flash('Your reply has been posted');
          this.$emit('created', res.data);
        }).catch(error => flash(error.response.data, 'danger'));
    }
  }
};
</script>	

<style lang="scss" scoped>
.center {
  text-align: center;
}
</style>
