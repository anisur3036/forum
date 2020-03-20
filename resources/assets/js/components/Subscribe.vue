<template>
    <p>
        <button
                class="btn"
                :class="classes"
                @click="subscribe"
                v-text="active ? 'Unsubscribe' : 'Subscribe'">
        </button>
    </p>
</template>
<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-danger' : 'btn-primary'];
            }
        },
        methods: {
            subscribe() {
                axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscriptions');
                this.active = ! this.active;
            }
        }
    }
</script>