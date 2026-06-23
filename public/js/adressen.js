const modal = document.getElementById("addressModal");

document.getElementById("openModal").onclick = () => {
    modal.classList.add("show");
};

function closeModal(){
    modal.classList.remove("show");
}

modal.addEventListener("click", function(e){
    if(e.target === modal){
        closeModal();
    }
});