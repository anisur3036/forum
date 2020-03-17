<template>
  <div :id="'reply-' + id" class="panel panel-default">
    <div class="panel-heading">
      <div class="level">
        <h5 class="flex">
          <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name"></a>
          said
          <span v-text="ago"></span>
        </h5>
        <div v-show="signedIn">
          <favorite :reply="data"></favorite>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <div v-if="editing">
        <div class="form-group">
          <textarea v-model="body" class="form-control"></textarea>
        </div>
        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs link" @click="cancel">Cancel</button>
      </div>
      <div v-else v-text="body"></div>
    </div>
    <div class="panel-footer level" v-if="canUpdate">
      <button type="submit" class="btn btn-xs mr-1" @click="editing = true">Edit</button>
      <button type="submit" class="btn btn-danger btn-xs" @click="destroy">Delete</button>
    </div>
  </div>
</template>
<script>
import Favorite from './Favorite.vue';

export default {
  props: ['data'],
  components: {
    Favorite
  },
  data() {
    return {
      editing: false,
      id: this.data.id,
      body: this.data.body
    };
  },

  computed: {
    signedIn() {
      return window.App.signedIn;
    },
    canUpdate() {
      return this.authorize(user => this.data.user_id == user.id);
    },
    ago() {
      return moment(this.data.created_at).fromNow();
    }
  },
  methods: {
    update() {
      axios.patch('/replies/' + this.data.id, {
        body: this.body
      });
      this.editing = false;
      flash('Updated!');
    },
    cancel() {
      this.editing = false;
      this.body = this.data.body;
    },
    destroy() {
      axios.delete('/replies/' + this.data.id);
      this.$emit('deleted', this.data.id);
    }
  }
};
</script>