<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form @submit.prevent="submit">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID</label>
                        {{ task.id }}
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        {{ task.title }}
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Content</label>
                        {{ task.content }}
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Person In Charge</label>
                        {{ task.person_in_charge }}
                    </div>

                    <div class="mt-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" @click="backToEdit">
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
    props: {
        taskId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            task: {
                id: '',
                title: '',
                content: '',
                person_in_charge: '',
            },
        };
    },
    methods: {
        // セッションの下書き、またはAPIから現在のタスクを取得
        loadTask() {
            axios.get('/draft/edit')
                .then((res) => {
                    if (res.data && res.data.draft) {
                        const draft = res.data.draft;
                        this.task = {
                            // id: draft.id || `${this.task.id}`,
                            id: `${this.taskId}`,
                            title: draft.title || '',
                            content: draft.content || '',
                            person_in_charge: draft.person_in_charge || '',
                        };
                    } else {
                        // draft が無ければ現在のタスクをAPIから取得
                        return axios.get('/api/tasks/' + this.taskId)
                            .then((res2) => {
                                this.task = res2.data;
                            });
                    }
                })
                .catch((error) => {
                    console.error(error);
                    alert('データの取得に失敗しました。編集画面に戻ります。');
                    this.$router.push({ name: 'task.edit', params: { taskId: `${this.task.id}` } });
                });
        },
        // 編集画面に戻る
        backToEdit() {
            this.$router.push({ name: 'task.edit', params: { taskId: `${this.task.id}` } });
        },
        // この内容で更新
        submit() {
            axios.put('/api/tasks/' + this.taskId, this.task)
                .then(() => axios.post('/draft/edit/clear'))
                .then(() => {
                    this.$router.push({ name: 'task.list' });
                })
                .catch((error) => {
                    console.error(error);
                    alert('更新に失敗しました。');
                });
        },
    },
    mounted() {
        this.loadTask();
    },
        beforeRouteLeave(to, from, next){
        const scopeEdit = ['task.edit', 'task.confirm'];

        if (scopeEdit.includes(to.name)){
            // 登録情報編集画面・編集内容確認画面間の移動はセッションを保持する。
            next();
        } else {
            // 登録情報編集画面・編集内容確認画面から離れる場合はセッション情報を破棄する。
            axios.post('/draft/edit/clear')
                .finally(() => next());
        }
    },
};
</script>
