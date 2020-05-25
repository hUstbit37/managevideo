// import { render } from "sass";

var vue_test = new Vue({
    el: "#app",
    data: {
        counter: 0,
        firstname: '',
        email: '',
        full: '',
    },
    methods: {
        handleClick(e, number) {
            this.counter += number;
        },
        handleSubmitForm(e) {
            this.full = this.firstname + ' ' + this.email;
        },
        handleMousemoveChild(e) {
            e.stopPropagation();
            console.log('handleMousemoveChild');
        },

    },
});
var bindingClass = new Vue({
    el: '#app2',
    data: {
        isActive: true,
        hasError: null,
        activeColor: 'red',
        bg: 'https://img.freepik.com/free-vector/abstract-technology-particle-background_52683-25766.jpg?size=626&ext=jpg'
    },
    methods: {
        changeClass(e) {
            this.isActive = !this.isActive;
        }
    },
    computed: {
        objectClass() { //cach viet moi es6
            return {
                class1: this.isActive && !this.hasError,
                class2: this.hasError
            }
        },
        objectStyle: function () { //cach viet cu
            return {
                backgroundImage: 'url(' + this.bg + ')',
                color: this.activeColor,
                paddingTop: '15px'
            }
        }
    }
})
var conditionalRendering = new Vue({
    el: '#app3',
    data: {
        tabSelected: null,
        check1: null,
        check2: null
    },
    methods: {
        changeTab(tab) {
            if (tab === 'login') {
                this.check1 = true;
                this.check2 = false;
            } else {
                this.check2 = true;
                this.check1 = false;
            }
            this.tabSelected = tab;

        }
    }
})