"use strict";
window.addEventListener("DOMContentLoaded", () => {
  const modalbutton=document.getElementsByClassName("modal-button");
  for (let i = 0; i < modalbutton.length; i++) {
      modalbutton[i].addEventListener("click",showModal);
  }
  const modalcontain=document.getElementsByClassName("modal-container")[0];
  const modal=document.getElementsByClassName("modal")[0];
  function showModal(ev){
      let id=ev.target.previousElementSibling.firstElementChild.innerText;
      const xhr=new XMLHttpRequest();
      xhr.open("GET",`populatemodal.php?id=${id}`);
      xhr.addEventListener("load",()=>{
      if(xhr.status!=200){
        console.log("Failure");
      }
      else{
        let resp=xhr.response;
        modal.innerHTML=resp;
        modalcontain.classList.remove("hidden");
        const close=document.querySelector(".modal>button");
        close.addEventListener("click",closemodal);
        const modalform=document.querySelector(".modal form");
        modalform.addEventListener("submit",deleteitem);
      }
      })
      xhr.send();
  
  }
  function closemodal(ev){
    modal.innerHTML="";
    modalcontain.classList.add("hidden");
  }
  const navform=document.getElementsByClassName("nav")[1];
  navform.addEventListener("submit",(ev)=>{
    if(!confirm("Are you sure you want to delete/disable list?"))
      ev.preventDefault();
  })
  function deleteitem(ev){
    if(!confirm("Are you sure you want to delete the item?"))
    ev.preventDefault();
  }
    
})
