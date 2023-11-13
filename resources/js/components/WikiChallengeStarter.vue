<template>
    <div class="d-md-flex align-items-center">
        <button class="btn btn-success fs-4 px-2 mb-md-0 mb-3 me-3"><strong>Start!</strong></button>
        <div class="d-md-flex">
            <div v-for="user in users" >
                <div class="bg-dark rounded-circle fs-2 text-uppercase d-flex justify-content-center align-items-center mx-1 my-1 border" style="width: 40px;height: 40px;" v-text="user.charAt(0)" :title="user"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: ['Piet', 'Rick', 'Pim', 'Furkan']
        };
    },

    computed: {
        channel() {
            return window.Echo.join()
        }
    },

    methods: {
        
    },


};
</script>
