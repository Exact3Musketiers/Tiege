<template>
    <div class="px-3">
        <button v-if="this.challenge.user_id === this.me.id" class="btn btn-success fs-4 px-2" @click="start"><strong>Start!</strong></button>
        <h3 class="pt-3">
            <span v-if="this.users.length === 1">Wachten tot de gang er is...</span>
            <span v-else-if="this.users.length <= 3">Het begint hier al gezellig te worden...</span>
            <span v-else>De hele gang is hier!</span>
        </h3>
        <div class="row gap-3">
            <div class="col mb-4 pe-none" style="max-width: 80px; max-height: 80px;" v-for="user in users">
                <div class="bg-dark rounded-circle fs-1 text-uppercase border d-flex justify-content-center align-items-center" style="width: 80px; height: 80px;" v-text="user.name.charAt(0)"></div>
                <p v-text="user.name" class="text-center text-truncate" style="width: 80px;"></p>
            </div>
        </div>
    </div>
</template>

<script>
const axios = require('axios');

export default {
    props: {
        route: String,
        me: Object,
        challenge: Object,
    },
    data() {
        return {
            users: []
        };
    },

    mounted() {
        window.Echo.join('challengers.' + this.challenge.id)
            .here(users => (this.users = users))
            .joining(user => this.users.push(user))
            .leaving(user => (this.users = this.users.filter(u => (u.id !== user.id))))
            .listen('StartWikiChallenge', (e) => {
                window.location.href = 'http://tiege.test/wiki/' + e.route[this.me.id].id;
            });

    },

    methods: {
        start() {
            axios
                .post(this.route, {
                    users: this.users
                })
        }
    },


};
</script>
