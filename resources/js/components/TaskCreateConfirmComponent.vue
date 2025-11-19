<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form @submit.prevent="submit">
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">Title</label>
                        <!-- <input
                            type="text"
                            id="title"
                            class="col-sm-9 form-control"
                            v-model="task.title"
                            readonly
                        > -->
                        {{ task.title }}
                    </div>
                    <div class="form-group row">
                        <label for="content" class="col-sm-3 col-form-label">Content</label>
                        <!-- <input
                            type="text"
                            id="content"
                            class="col-sm-9 form-control"
                            v-model="task.content"
                            readonly
                        > -->
                        {{ task.content }}
                    </div>
                    <div class="form-group row">
                        <label for="person-in-charge" class="col-sm-3 col-form-label">Person In Charge</label>
                        <!-- <input
                            type="text"
                            id="person-in-charge"
                            class="col-sm-9 form-control"
                            v-model="task.person_in_charge"
                            readonly
                        > -->
                        {{ task.person_in_charge }}
                    </div>

                    <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" @click="backToCreate">
                            back
                        </button>
                        <button type="submit" class="btn btn-primary">
                            submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TaskCreateConfirmComponent',
    data() {
        return {
            task: {
                title: '',
                content: '',
                person_in_charge: '',
            },
        };
    },
    methods: {
        loadDraft() {
            axios.get('/draft/create')
                .then((res) => {
                    if (res.data && res.data.draft) {
                        this.task = res.data.draft;
                    } else {
                        alert('下書きが存在しません。新規登録画面に戻ります。');
                        this.$router.push({ name: 'task.create' });
                    }
                })
                .catch((error) => {
                    console.error(error);
                    alert('下書きの取得に失敗しました。');
                    this.$router.push({ name: 'task.create' });
                });
        },
        submit() {
            axios.post('/api/tasks', this.task)
                .then(() => {
                    return axios.post('/draft/create/clear');
                })
                .then(() => {
                    this.$router.push({ name: 'task.list' });
                })
                .catch((error) => {
                    console.error(error);
                    alert('登録に失敗しました。');
                });
        },
        backToCreate() {
            this.$router.push({ name: 'task.create' });
        },
    },
    mounted() {
        this.loadDraft();
    },
    beforeRouteLeave(to, from, next){
        const scopeCreate = ['task.create', 'task.confirm'];

        if (scopeCreate.includes(to.name)){
            // 新規登録画面・新規登録内容確認画面間の移動はセッションを保持する。
            next();
        } else {
            // 新規登録画面・新規登録内容確認画面から離れる場合はセッション情報を破棄する。
            axios.post('/draft/create/clear')
                .finally(() => next());
        }
    }
};
</script>
