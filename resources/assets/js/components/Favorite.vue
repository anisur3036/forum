<template>
	<div class="level">
		<button type="submit" class="fab-btn" @click="toggle">
			<span :class="classes"></span>
		</button>
		<span v-text="favoritesCount"></span>
	</div>
</template>

<script>
export default {
	props: ['reply'],
  data() {
  	return {
      favoritesCount: this.reply.favoritesCount,
      isFavorited: this.reply.isFavorited,
  	}
  },
  computed: {
  	classes() {
  		return ['glyphicon', this.isFavorited ? 'glyphicon-heart' : 'glyphicon-heart-empty']
  	},
  	endpoint() {
  		return '/replies/' + this.reply.id + '/favorites'
  	}
  },
  methods: {
  	toggle() {
  			this.isFavorited ? this.destroy() : this.create();
  	},
  	create() {
  		axios.post(this.endpoint);
			this.isFavorited = true;
			this.favoritesCount++;  		
  	},
  	destroy() {
  		axios.delete(this.endpoint);
			this.isFavorited = false;
			this.favoritesCount--;
  	}
  }
}
</script>	

<style lang="scss">
	.fab-btn {
		border: 0;
		border-radius: 50%;
		background: transparent;
		outline: none;
	}
	.glyphicon-heart {
		color: orange;
	}
</style>
