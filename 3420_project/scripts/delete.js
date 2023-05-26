"use strict";
window.addEventListener("DOMContentLoaded", () => {
    const form=document.getElementById("deleteaccount");
    form.addEventListener("submit",(ev)=>{
        if(!confirm("Are you sure you want to delete your account?"))
        ev.preventDefault();
    })
})
