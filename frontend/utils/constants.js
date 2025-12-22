let Constants = {
   PROJECT_BASE_URL: function() {
      if(location.hostname === "localhost") {
         return "http://localhost/Flower_Shop/backend";
      } else {
         return "https://flowershop-backend-app-rnlqx.ondigitalocean.app";
      }
   },
   USER_ROLE: "customer",
   ADMIN_ROLE: "admin"
}
