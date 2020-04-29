<template>
            <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Start Bootstrap</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" @click="toogleSideBar" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" @click="handleLogout">Logout</button>
                    </div>
                </li>
            </ul>
        </nav>
</template>

<script>
import * as authService from '../services/auth_service'
import storage from '../utils/storage'
export default {
    name: 'Header', 
    data() {
        return {

        }
    }, 
    methods: {
        toogleSideBar() {
            if (document.body.classList.value === 'sb-sidenav-toggled') {
                 document.body.classList.remove('sb-sidenav-toggled');
            } else {
                document.body.classList.add('sb-sidenav-toggled');
            }
        }, 

        handleLogout: async function () {
            
            try {
                const response = authService.logout(); 
                storage.token.removeToken(); 
                storage.user.removeUser(); 
                storage.roles.removeRoles(); 

                this.$router.go(); 
            } catch (error) {
                
            }
            // console.log('handle logout ------------> '); 
        }
    }
}
</script>