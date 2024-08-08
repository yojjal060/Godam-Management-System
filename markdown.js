document.addEventListener("DOMContentLoaded", function() {
    let markdown = document.getElementById("markdown-container");
    let profile = document.getElementById("profile-photo");

    if (markdown && profile) {
        profile.addEventListener("click", function() {
            if (markdown.style.display === "none" || markdown.style.display === "") {
                markdown.style.display = "block";
            } else {
                markdown.style.display = "none";
            }
            
        });
    } 
});