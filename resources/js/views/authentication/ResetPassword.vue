<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                    <div class="card-body">
                        <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div>
                        <form>
                            <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" /></div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <router-link class="small" to="/login">Return to login</router-link>
                                <a class="btn btn-primary" href="#">Reset Password</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small">
                            <router-link to="/register">Need an account? Sign up!</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ResetPassword', 
    mounted() {
        // console.log('Reset password.vue === mounted...')
        document.querySelector('body').style.backgroundColor = '#343a40'
    }, 
    destroyed() {
        // console.log('Reset password === destroyed...')
        document.querySelector('body').style.backgroundColor = 'transparent'
    }
    
}
</script>