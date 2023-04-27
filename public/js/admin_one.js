


let delete_btns = document.querySelectorAll('.delete-user');
delete_btns.forEach(function(btn){
    btn.addEventListener('click', function(e){
        e.preventDefault();
        bootbox.confirm("you sure that you want to delete ?? ", function(result){
            if(result){
                window.location = btn.href;
            }
        });
    });
})


window.addEventListener('click', function(e){
    // make show to option list
    if(e.target.classList.contains('option-icon')){
        let id = e.target.getAttribute('data-option-id');
         document.querySelector('.option-list-display-'+id).style.display = 'block';
    }
    // make hiddent to option list if you click outside 
    let option_elements = document.querySelectorAll('.option-icon');
    option_elements.forEach(function(ele){
        if(ele.contains(e.target)){
            console.log('in');
        }else{
            let id = ele.getAttribute('data-option-id');
            document.querySelector('.option-list-display-'+id).style.display = 'none';
        }

    });
});
