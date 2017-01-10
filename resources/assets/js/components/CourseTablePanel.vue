<template>
    <div class="table-responsive">
        <ul class="list-group" v-sortable="{ onUpdate: onUpdate, handle: '.handle' }">
            <li class="list-group-item" v-for="course_table in course_tables">
                <i class="fa fa-arrows-v btn btn-secondary handle" aria-hidden="true"></i>
                <a :href="api + '/' + course_table.id">
                    <i class="fa fa-globe fa-fw" aria-hidden="true" title="公開" v-if="course_table.public"></i>
                    <i class="fa fa-lock fa-fw" aria-hidden="true" title="私人" v-else=""></i>
                    {{ course_table.name }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$nextTick(function () {
                this.fetch();
            });
        },
        data: function () {
            return {
                course_tables: []
            }
        },
        props: [
            'api'
        ],
        methods: {
            fetch: function () {
                this.$http.get(this.api + '/data').then(function (response) {
                    this.course_tables = response.body;
                });
            },
            onUpdate: function (event) {
                this.course_tables.splice(event.newIndex, 0, this.course_tables.splice(event.oldIndex, 1)[0]);
                var idList = [];
                $.each(this.course_tables, function (key, item) {
                    idList.push(item.id);
                });
                //發送請求
                this.$http.post(this.api + '/sort', {
                    idList: idList
                }).then(function (response) {
                    //重新獲取資料
                    this.fetch();
                    //顯示通知
                    alertify.notify('排序已更新', 'success', 5);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            }
        }
    }
</script>
