<template>
    <li class="dropdown" v-if="notifications.length">
        <a href="#" class="dropdown-taggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-bell" v-if="notifications.length"><span style="color: red">{{ notifications.length }}</span></span>
        </a>
        <ul class="dropdown-menu">
            <li v-for="notification in notifications">
                <a :href="notification.data.link" @click="markAsRead(notification)">{{ notification.data.message }}</a>
            </li>
        </ul>
    </li>

</template>

<script>
    export default {
        data() {
            return {
                notifications: false,
            }
        },

        created() {
            axios.get('/profiles/' + window.App.user.name + '/notifications')
                .then(res => this.notifications = res.data);
        },

        methods: {
    // /profiles/{user}/notifications/{notification}
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
            }
        }
    }
</script>