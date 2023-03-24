<script>
    import { me, token } from '$lib/stores/auth';
    import { onMount } from 'svelte';
    import { goto } from '$app/navigation';
    import {Button, Img, Input} from "flowbite-svelte";

    let username = '';
    let password = '';
    let error = '';

    async function handleSubmit() {
        const authResponse = await fetch('http://localhost:90/api/authenticate', {
            method: 'POST',
            body: JSON.stringify({ username, password })
        });

        const { token: jwtToken, message } = await authResponse.json();
        if (jwtToken) {
            token.set(jwtToken);
            error = '';
            username = '';
            password = '';
        } else {
            error = message;
        }

        const meResponse = await fetch('http://localhost:90/api/me', {
            method: 'GET',
            headers: {
                Authorization: `Bearer ${$token}`
            }
        });

        const user = await meResponse.json();
        if (user) {
            me.set(JSON.stringify(user));
            error = '';
        } else {
            error = 'Could not get user';
        }

        console.log('##############', 'submitting', $me, $token);
    }

    onMount(() => {
        if ($me && $token) {
           console.log('##############', 'redirecting');
           goto('/');
        }
    });
</script>

<div class="content" style="min-height: 483px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- Login Tab Content -->
                <div class="account-content">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7 col-lg-6 login-left">
                            <Img src="/images/login-banner.png" size="img-fluid" alt="Doccure Login"/>
                        </div>
                        <div class="col-md-12 col-lg-6 login-right">
                            <div class="login-header">
                                <h3>Login <span>Doccure</span></h3>
                            </div>
                            <form on:submit={handleSubmit}>
                                <div class="form-group form-focus">
                                    <Input bind:value={username} type="username" class="form-control floating" placeholder="Username"/>
                                </div>
                                <div class="form-group form-focus">
                                    <Input bind:value={password} type="password" class="form-control floating" placeholder="Password"/>
                                </div>
                                <div class="text-right">
                                    <a class="forgot-link" href="forgot-password.html">Forgot Password ?</a>
                                </div>
                                <Button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</Button>
                                <div class="login-or">
                                    <span class="or-line"></span>
                                    <span class="span-or">or</span>
                                </div>
                                <div class="text-center dont-have">Don’t have an account? <a href="register.html">Register</a></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Login Tab Content -->
            </div>
        </div>

    </div>
</div>