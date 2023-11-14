<template>
    <div class="p-3">
        <button class="btn btn-success fs-4 px-2" @click="start"><strong>Start!</strong></button>
        <div class="row gap-3 pt-3">
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
    },
    data() {
        return {
            users: [
                {
                    id: 1,
                    name: 'Piet',
                },
                {
                    id: 2,
                    name: 'VoidCallerZ',
                },
                {
                    id: 3,
                    name: 'Furkan',
                },
                {
                    id: 4,
                    name: 'Pim Heijmeriks',
                },
                {
                    id: 5,
                    name: 'Johannes de Vries',
                },
            ]
        };
    },

    computed: {

    },

    methods: {
        start() {
            axios
                .post(this.route, {
                    users: this.users
                })
                .then((response) => {
                    console.log(response);
                });
        }
    },


};
</script>
