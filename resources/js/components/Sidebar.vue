<template>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <router-link class="nav-link" to="/home"
                        ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </router-link>
                    <!-- 
                    <router-link class="nav-link" to="/home/test-view"
                        v-if="hasPermission('admin')"
                    >
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Test View 
                    </router-link> -->




                    <div class="sb-sidenav-menu-heading">USER Panel</div>
                        

                        <router-link class="nav-link" to="/home/apply-leave" v-if="hasPermission([])">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Apply Leave
                        </router-link>
                        <router-link class="nav-link" to="/home/change-password" v-if="hasPermission([])">
                            <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                            Change Password
                        </router-link>
                        
                    


                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="layout-static.html">Static Navigation</a><a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a></nav>
                    </div>




                    <div class="sb-sidenav-menu-heading">Administrations</div>
                        <router-link class="nav-link" to="/home/employees" v-if="hasPermission(['admin', 'hr'])">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>
                            Employees
                        </router-link>

                        <router-link class="nav-link" to="/home/approve-leave" v-if="hasPermission(['admin', 'hr'])">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                            Approve Leave
                        </router-link>
                    
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Start Bootstrap
            </div>
        </nav>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'Sidebar', 

    computed: {
        ...mapGetters([
            'hasPermission',
        ])
    }
}
</script>