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
                    <button type="submit" class="btn btn-primary">submit</button>
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
                },

                errors: {},
            };
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
                        this.errors = {};
                        this.$router.push({ name: 'task.confirm'});
                    })
                    .catch((error) => {
                        // console.error(error);
                        // alert('エラー：新規登録に失敗しました。');
                        if (error.response && error.response.status === 422){
                            //バリデーションエラーの場合dataに格納する
                            this.errors = error.response.data.errors;
                        } else {
                            //その他のエラー処理
                            console.error(error);
                        }
                    });
            },
        }
    }
</script>