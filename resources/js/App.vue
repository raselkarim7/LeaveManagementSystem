<template>
    <div>


        <Header />
        <div id="layoutSidenav">
            <Sidebar />

            <div id="layoutSidenav_content">
                <main>
                    <keep-alive>
                        <router-view> </router-view>
                    </keep-alive>

                </main>



                <Footer />


            </div>
        </div>


        
    </div>
</template>

<script>
import Header from './components/Header';
import Sidebar from './components/Sidebar'; 
import Footer from './components/Footer';
export default {
    name: 'App',
    components: {
        Header, 
        Sidebar, 
        Footer
    },
    data() {
        return {

        }
    }
}
</script>

