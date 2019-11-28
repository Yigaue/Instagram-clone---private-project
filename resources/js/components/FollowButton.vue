<template>
    <div class="container">
        <button name="" id="" class="btn btn-primary ml-4" href="#" role="button" @click="followUser" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows'],

        data () {
            return{
                id: this.userId,
                status: this.follows,
            };
        },
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            followUser(){
                axios.post('/follow/' + this.id)
                .then((response) => {
                    this.status = ! this.status;
                    console.log(response.data)
                }).catch((errors) => {
                    if(errors.response.status == 401){
                        window.location = '/login';
                    }

                });
            }
        },
        computed: {
            buttonText(){
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }
</script>
