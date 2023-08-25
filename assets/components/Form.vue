<script setup>
    
    import axios from 'axios';
    defineProps({
        isSubmitted: Boolean,
    });

    const validateEmail = (email) => {
        if (email.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g)) return true;
        return false;
    }

    const validateForm = (name, surname, email, message) => {
        if (name && surname && message && email && validateEmail(email)) {
            axios.post('/home', {
                name: name,
                surname: surname,
                email: email,
                message: message
            })
            .catch(function (error) {
                return false;
            });
            return true;
        }
        return false;
    }
</script>

<template>
    <div v-if="isSubmitted === false">
        <h1>Hello user! Please, pass your data into this form.</h1>
        <div class="input-form">
            <form method="post">
                <label for="name">Imie:</label><br>
                <input type="text" id="name" name="name" v-model="name" required maxlength="255"><br>

                <label for="surname">Nazwisko:</label><br>
                <input type="text" id="surname" name="surname" v-model="surname" required maxlength="255"><br>

                <label for="email">E-mail:</label><br>
                <input type="email" id="email" name="email" v-model="email" required maxlength="255"><br>

                <label for="message">Treść:</label><br>
                <input type="text" id="message" name="message" v-model="message" required maxlength="1000"><br>
                <input type="submit" value="Submit" @click="validateForm(name, surname, email, message) ? $emit('submit', !isSubmitted) : ``">
            </form>
        </div>
        
    </div>

    <div v-else>
        <h3>You successfully send your data!</h3>
        <table style="width: 100%;">
        <tr>
            <th>Option</th>
            <th>Sended data</th>
            
        </tr>
        <tr>
            <td>Your name</td>
            <td>{{name}}</td>
            
        </tr>
        <tr>
            <td>Your surname</td>
            <td>{{surname}}</td>
        </tr>

        <tr>
            <td>Your email</td>
            <td>{{email}}</td>
        </tr>

        <tr>
            <td>Your text</td>
            <td>{{message}}</td>
        </tr>
        </table>
    </div>
</template>