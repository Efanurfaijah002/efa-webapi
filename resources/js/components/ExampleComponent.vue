<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> {{ title }}</div>

                    <div v-if="!loading" class="card-body">
                        <button class="btn btn-secondary" @click="aksesApi">
                            Refresh Data
                        </button>

                        <input v-model="katakunci" type="search" placeholder="Masukan Kata Kunci dan Tekan Enter" @change="JalankanPencarian" />

                        <table v-if="!error" 
                        class="table table-bordered">
                            <tr>
                                <td>Nama</td>
                                <td>JK</td>
                                <td>Tanggal Dibuat</td>
                            </tr>

                            <tr 
                            v-for="item in data.data" :key="item.id">
                                <td> {{ item.nama }}</td>
                                <td> {{ item.jk }}</td>
                                <td>{{item.created_at}}</td>
                            </tr>
                        </table>

                        <pagination :data="data" @pagination-change-page="aksesApi"></pagination>

                        <div v-if="error" class="alert alert-warning">
                            {{ error }}
                        </div>

                        <div v-if="loading" class="card-body">
                            loading...
                        </div>
                    </div>
                    <notifications group="foo" />
                </div>
                 <vue-progress-bar></vue-progress-bar>
            </div>
        </div>
    </div>   
</template>

<script>
    export default {
        data(){//property
            return{
                title : 'Data Siswa-Siswa',
                content : 'Contoh Konten',
                error : null,
                loading : false,
                data : {},
                katakunci : ''
            }
        },
        mounted() {//method
            this.aksesApi()
        },

        methods: {
            aksesApi(page = 1, katakunci){
                this.loading = true
                this.$Progress.start()

                const params ={
                    page : page
                }
                
                if (katakunci) {
                    params.katakunci = katakunci
                }
                
                axios.get('/testapi', {
                    params
                })
                   //axios adalah library//get adalah axios//diambil dari web.php
                .then(res => {
                    this.data = res.data //res mengambil semua data data dari variabel data($data) yang  (res.data.data )berada di TestApiController.php
                    this.loading = false
                    this.$Progress.finish()
                    this.$notify({
                        type : 'bg-succes',
                        group: 'foo',
                        title: 'Sukses',
                        text: 'Data berhasil !',
                        duration: -1
                    });
                })//request berhasil
                .catch(error =>{
                    this.error = error
                    this.loading = false
                    this.$Progress.fail()
                    this.$notify({
                        type : 'bg-danger',
                        group: 'foo',
                        title: 'error',
                        text: 'error',
                        duration: -1
                    });
                })//request gagal
            },
            JalankanPencarian(){
                this.aksesApi(1, this.katakunci)
            },
        }
    }
</script>
