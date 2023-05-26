"use strict";
let emailvalid = true;
let usernamevalid = true;

window.addEventListener("DOMContentLoaded", () => {
    const emailIsValid = (string) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(string);

    const form = document.querySelector("form");

    form.addEventListener("submit", (ev) => {

        let error = false;
        const emailInput = document.getElementById("email");
        const emailError = emailInput.parentElement.nextElementSibling;

        const password = document.getElementById("password");
        const repassword = document.getElementById("repassword");
        const passwrdError = repassword.parentElement.nextElementSibling;

        if (!emailIsValid(emailInput.value)) {
            emailError.classList.remove("hidden");
            error = true;
        } else {
            emailError.classList.add("hidden");
        }

        if (password.value != repassword.value) {

            passwrdError.classList.remove("hidden");
            error = true;
        } else {
            passwrdError.classList.add("hidden");
        }


        if (error == true) {
            ev.preventDefault();
        }
    });

    const emailID = document.getElementById("email");
    const username = document.getElementById("username");
    const registeredUsername = username.parentElement.nextElementSibling.nextElementSibling;
    const registeredEmail = email.parentElement.nextElementSibling.nextElementSibling;

    emailID.addEventListener("blur", (ev) => {

        const xhr = new XMLHttpRequest();
        xhr.open("GET", "emailcheck.php?email=" + emailID.value);
        xhr.addEventListener("load", (ev) => {

            if (xhr.status == 200) {
                if (xhr.response == 'true') {
                    registeredEmail.classList.remove("hidden");
                } else {
                    registeredEmail.classList.add("hidden");
                }
            } else {
                console.log("connection error");
            }
        });

        xhr.send();
    });

    username.addEventListener("blur", (ev) => {

        const xhr = new XMLHttpRequest();
        xhr.open("GET", "usernamecheck.php?username=" + username.value);
        xhr.addEventListener("load", (ev) => {

            if (xhr.status == 200) {
                if (xhr.response == 'true') {
                    registeredUsername.classList.remove("hidden");
                } else {
                    registeredUsername.classList.add("hidden");
                }
            } else {
                console.log("connection error");
            }
        });

        xhr.send();
    });


    const fname = document.getElementById("fname");
    const lname = document.getElementById("lname");
    const nameError = lname.parentElement.nextElementSibling;

    fname.addEventListener('blur', (ev) => {
        if (fname.value === "" || lname.value === "") {
            nameError.classList.remove("hidden");
            error = true;

        } else {
            nameError.classList.add("hidden");
        }

    });

    lname.addEventListener('blur', (ev) => {
        if (fname.value === "" || lname.value === "") {
            nameError.classList.remove("hidden");
            error = true;

        } else {
            nameError.classList.add("hidden");
        }

    });

});