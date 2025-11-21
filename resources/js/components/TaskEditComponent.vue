<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <!-- <form> -->
                <form v-on:submit.prevent="toConfirm">
                    <div class="form-group row">
                        <label for="id" class="col-sm-3 col-form-label">ID</label>
                        <!-- <input type="text" class="col-sm-9 form-control-plaintext" readonly id="id" v-bind:value="taskId"> -->
                        <input type="text" class="col-sm-9 form-control-plaintext" readonly id="id" v-model="task.id">
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">Title</label>
                        <!-- <input type="text" class="col-sm-9 form-control" id="title"> -->
                        <input type="text" class="col-sm-9 form-control" id="title" v-model="task.title">
                        <div v-if="errors.title" class="error text-danger"> {{ errors.title[0] }}</div>
                    </div>
                    <div class="form-group row">
                        <label for="content" class="col-sm-3 col-form-label">Content</label>
                        <!-- <input type="text" class="col-sm-9 form-control" id="content"> -->
                        <input type="text" class="col-sm-9 form-control" id="content" v-model="task.content">
                        <div v-if="errors.content" class="error text-danger"> {{ errors.content[0] }}</div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="person-in-charge" class="col-sm-3 col-form-label">Person In Charge</label>
                        <!-- <input type="text" class="col-sm-9 form-control" id="person-in-charge"> -->
                        <input type="text" class="col-sm-9 form-control" id="person-in-charge" v-model="task.person_in_charge">
                        <div v-if="errors.person_in_charge" class="error text-danger"> {{ errors.person_in_charge[0] }}</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { error } from 'laravel-mix/src/Log';
// import { error } from 'laravel-mix/src/Log';

    export default {
        props: {
            taskId: String
        },
        data: function () {
            return {
                task: {
                    id: '',
                    title: '',
                    content: '',
                    person_in_charge: ''
                },
                errors: {},
            };
        },
        methods: {
            loadTask(){
                axios.get('/draft/edit')
                    .then((res) => {
                        if (res.data && res.data.draft){
                            const draft = res.data.draft;
                            this.task = {
                                id: draft.id || this.taskId,
                                title: draft.title || '',
                                content: draft.content || '',
                                person_in_charge: draft.person_in_charge || '',
                            };
                        } else {
                            return axios.get('/api/tasks/' + this.taskId)
                                .then((res2) => {
                                    this.task = res2.data;
                                });
                        }
                    })
                    .catch((error) => {
                        console.error(error);
                        alert('タスクの取得に失敗しました。');
                        this.$router.push({ name: 'task.list'});
                    });
            },
            // getTask() {
            //     axios.get('/api/tasks/' + this.taskId)
            //         .then((res) => {
            //             this.task = res.data;
            //         });
            // },
            // submit() {
            //     axios.put('/api/tasks/' + this.taskId, this.task)
            //         .then((res) => {
            //             this.$router.push({name: 'task.list'})
            //         });
            // }
            toConfirm() {
                axios.post('/draft/edit', this.task)
                    .then(()=> {
                        this.errors = {}; //エラークリア
                        this.$router.push({
                            name: 'task.editConfirm',
                            params: { taskId: this.task.id}
                        });
                    })
                    .catch((error) => {
                        if (error.response && error.response.status === 422) {
                            //バリデーションエラーの場合dataにセットする
                            this.errors = error.response.data.errors;
                        } else {
                            console.error(error);
                            alert('下書き保存に失敗しました。');
                        }
                    });
            }
        },
        mounted() {
            // this.getTask();
            // 確認画面から戻った場合にキャッシュから入力値を取得する
            this.loadTask();
        }
    }
</script>
