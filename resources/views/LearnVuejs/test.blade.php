<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Vuejs</title>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style_testVuejs.css') }}">
</head>
<body>
    <header>Test Vue Js</header>
    
    <div class="container">
        <div id="app">
            <div>Counter: @{{counter}}</div>
            <button v-on:click="handleClick($event, 5)">Click me</button><br>
            <form v-on:submit.prevent="handleSubmitForm">
                <label for="firstName">Nhap First name</label><br>
                <input v-model="firstname" type="text" name="firstName"><br>
                <label for="email">Nhap Email</label><br>
                <input v-model="email" type="text" name="email" id="email">
                <input type="submit" value="Submit">
            </form>
            <p>First name: @{{firstname}} </p>
            <p>Email: @{{email}}</p>
            <p>Full: @{{full}}</p>
        </div>
        <!-- Binding class and style -->
        <div id="app2">
            <div class="demo" v-bind:class="{ active: isActive, error: hasError }">Binding Class</div>
            <button v-on:click="changeClass">Click</button>
            <div v-bind:class="objectClass">Binding Class using computed</div><br>
            <div v-bind:style="{ backgroundImage: 'url('+bg+')', color: activeColor }">
                Style binding
            </div>
            <div v-bind:style="objectStyle">
                Style binding object
            </div>
        </div>
        <hr>
        <!-- COnditional rendering: v-if -->
        <div id="app3">
            <ul class="tab">
                <li v-on:click="changeTab('login')" v-bind:class="{activeTab: check1}">Dang nhap</li>
                <li v-on:click="changeTab('register')" v-bind:class="{activeTab: check2}">Dang ky</li>
            </ul>
            <div class="login" v-if="tabSelected === 'login'">
                <h2>Form Dang Nhap</h2>
                <form action="">
                    <input type="text" placeholder="Nhap name">
                    <input type="password" placeholder="Nhap password">
                </form>
            </div>
            <div class="register" v-else-if="tabSelected === 'register'">
                <h2>Form Dang Ky</h2>
                <form action="">
                    <input type="text" placeholder="Nhap name">
                    <input type="password" placeholder="Nhap password">
                    <input type="password" placeholder="Nhap lai password">

                </form>
            </div>
        </div>
        
        
    </div>   
</body>
<script src="{{ asset('js/test_vuejs.js') }}"></script>
</html>