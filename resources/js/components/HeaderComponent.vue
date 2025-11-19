<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <span class="navbar-brand mb-0 h1">Vue Laravel SPA</span>
                <div>
                    <router-link v-bind:to="{name: 'task.list'}">
                         <button class="btn btn-success">List</button>
                    </router-link>
                    <!-- ナビゲーション重複してしまうので廃止 -->
                    <!-- <router-link v-bind:to="{name: 'task.create'}"
                                v-on:click.native.prevent="goToTaskCreate"            
                    > -->
                    <button class="btn btn-success" v-on:click="goToTaskCreate">ADD</button>
                    <!-- </router-link> -->
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        methods:{
            goToTaskCreate(){
                axios.post('/draft/create/clear')
                    .finally(() => {
                        this.$router.push({
                            name: 'task.create'
                        });
                    });
            },
        }

    }
    
</script>
