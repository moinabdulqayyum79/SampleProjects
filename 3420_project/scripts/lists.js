"use strict";
window.addEventListener("DOMContentLoaded", () => {
  new Calendar({
    id: '#color-calendar',
    weekdayDisplayType: 'short',
    monthDisplayType: 'long',

    dateChanged: (currentDate, DateEvents) => {
        const expirytext=document.getElementById("expiry");
        let month=currentDate.getMonth()+1;
        let year=currentDate.getFullYear();
        let date=currentDate.getDate();
        
        expirytext.value=year+"-"+month+"-"+date;
      }
})
})
