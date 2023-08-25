<script setup>
    import axios from 'axios';
    defineProps({
        isSubmitted: Boolean,
    });

    const validate = (name, surname, email, message) => {
        if (name && surname && message && email && email.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g)) {
            axios.post('/home', {
                name: name,
                surname: surname,
                email: email,
                message: message
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
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
                <input type="text" id="name" name="name" v-model="name" required><br>

                <label for="surname">Nazwisko:</label><br>
                <input type="text" id="surname" name="surname" v-model="surname" required><br>

                <label for="email">E-mail:</label><br>
                <input type="email" id="email" name="email" v-model="email" required><br>

                <label for="message">Treść:</label><br>
                <input type="text" id="message" name="message" v-model="message" required><br>
                {{ name }}
                <input type="submit" value="Submit" @click="validate(name, surname, email, message) ? $emit('submit', !isSubmitted) : ``">
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