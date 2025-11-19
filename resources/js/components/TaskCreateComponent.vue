<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <!-- <form> -->
                <form v-on:submit.prevent="toConfirm">
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">Title</label>
                        <!-- <input type="text" class="col-sm-9 form-control" id="title"> -->
                        <input type="text" class="col-sm-9 form-control" id="title" v-model="task.title">
                    </div>
                    <div class="form-group row">
                        <label for="content" class="col-sm-3 col-form-label">Content</label>
                        <!-- <input type="text" class="col-sm-9 form-control" id="content"> -->
                        <input type="text" class="col-sm-9 form-control" id="content" v-model="task.content">
                    </div>
                    <div class="form-group row">
                        <label for="person-in-charge" class="col-sm-3 col-form-label">Person In Charge</label>
                        <!-- <input type="text" class="col-sm-9 form-control" id="person-in-charge"> -->
                        <input type="text" class="col-sm-9 form-control" id="person-in-charge" v-model="task.person_in_charge">
                    </div>
                    <button type="submit" class="btn btn-primary">確認画面へ</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data: function(){
            return {
                
                task:{
                    title: '',
                    content: '',
                    person_in_charge: ''
                }
            }
        },
        created() {
            axios.get('/draft/create')
                .then((res) => {
                    if (res.data && res.data.draft) {
                        const draft = res.data.draft;
                        this.task = {
                            title: draft.title || '',
                            content: draft.content || '',
                            person_in_charge: draft.person_in_charge || ''
                        };
                    } else {
                        this.task = {
                            title: '',
                            content: '',
                            person_in_charge: ''
                        };
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        methods: {
            // submit() {
            //     axios.post('/api/tasks', this.task)
            //         .then((res) => {
            //             this.$router.push({name: 'task.list'});
            //         });
            // }
            toConfirm() {
                axios.post('/draft/create', this.task)
                    .then(() => {
                        this.$router.push({ name: 'task.confirm'});
                    })
                    .catch((error) => {
                        console.error(error);
                        alert('エラー：新規登録に失敗しました。');
                    })
            },
        }
    }
</script>