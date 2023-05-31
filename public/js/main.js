// Get the modal element
const modal = document.querySelector(".modal");

// Get the button that opens the modal
const button = document.querySelector(".signin-button");



// Get the span element that closes the modal
const span = document.querySelector(".close");

// When the user clicks on the button, open the modal
function openModal() {
  modal.style.display = "block";
}

// When the user clicks on the span (x), close the modal
function closeModal() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}



const publishButton = document.getElementById('publish-button');
const titleInput = document.querySelector('input[name="judul"]');
const descriptionInput = document.querySelector('textarea[name="deskripsi"]');

function updatePublishButton() {
  if (titleInput.value.trim() && descriptionInput.value.trim()) {
    publishButton.classList.remove('disabled');
  } else {
    publishButton.classList.add('disabled');
  }
}

titleInput.addEventListener('input', updatePublishButton);
descriptionInput.addEventListener('input', updatePublishButton);


// log in
function showLogin() {
  document.getElementById("login-container").style.display = "block";
}


$(document).ready(function() {
  $('.nav-link').on('shown.bs.tab', function() {
    var $elem = $(this);
    var $parent = $elem.parent();
    $parent.addClass('show');
    $parent.siblings().removeClass('show');
  });
});
