// listen for remove item button
for (var clickBtn of document.getElementsByClassName("btnRemoveItem")) {
    clickBtn.addEventListener("click",showAlert)
 }

// listen for empty cart button
for (var clickBtn of document.getElementsByClassName("btnEmptyCart")) {
    clickBtn.addEventListener("click",showAlert)
}

// alert function
function showAlert() {
    alert("The item(s) in your cart will be removed!")
}