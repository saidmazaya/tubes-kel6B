
let edit_elements = document.querySelectorAll('.edit');
let cancel_elements = document.querySelectorAll('.cancel');
let save_elements = document.querySelectorAll('.save');
edit_elements.forEach(function(element){
    element.onclick =function(){
        if(this.classList.contains('edit-password')){
            this.nextElementSibling.style.display = 'inline';
            this.previousElementSibling.style.display = 'inline';
            this.style.display = 'none';
            document.querySelector('[name="currentpassword"]').removeAttribute('disabled');
            document.querySelector('[name="newpassword"]').removeAttribute('disabled');
            document.querySelector('[name="confirmnewpassword"]').removeAttribute('disabled');
        }else{
            this.parentElement.previousElementSibling.removeAttribute('disabled');
            this.nextElementSibling.style.display = 'inline';
            this.previousElementSibling.style.display = 'inline';
            this.style.display = 'none';
        }


    }
});

cancel_elements.forEach(function(element){
    element.onclick = function(){
        if(this.classList.contains('cancel-password')){
            this.previousElementSibling.style.display = 'inline';
            this.previousElementSibling.previousElementSibling.style.display ='none';
            this.style.display = 'none';
            document.querySelector('[name="currentpassword"]').setAttribute('disabled' , '');
            document.querySelector('[name="newpassword"]').setAttribute('disabled' , '');
            document.querySelector('[name="confirmnewpassword"]').setAttribute('disabled' , '');
        }else{
            this.parentElement.previousElementSibling.setAttribute('disabled' , '');
            this.previousElementSibling.style.display = 'inline';
            this.previousElementSibling.previousElementSibling.style.display ='none';
            this.style.display = 'none';
        }



    }
})

save_elements.forEach(function(element){
    element.onclick = function(){
        let obj = Object.create({});
        var selected = this ;
        if(this.classList.contains('save-password')){
            let current_password = document.querySelector('[name="currentpassword"]').value;
            let new_password = document.querySelector('[name="newpassword"]').value;
            let confirm_password = document.querySelector('[name="confirmnewpassword"]').value;
            let csrf_token = document.querySelector('[name="_token"]').value ;
            obj['_token'] = csrf_token;
            obj['currentpassword'] = current_password;
            obj['newpassword'] = new_password;
            obj['confirmnewpassword'] = confirm_password;
            if(current_password == '' || new_password == '' || confirm_password == ''){
                bootbox.alert(`<i class="fa-solid fa-triangle-exclamation" style="color: #fd483d;font-size: 20px;margin-right: 10px;" ></i>  ` + 'please fill all field' , function(){
                });
            }else{
                senddataaccount(obj , selected);
            }
        }else{

        //console.log(selected);
        var name = selected.parentElement.previousElementSibling.getAttribute('name');
        let csrf_token = document.querySelector('[name="_token"]').value ;
        let value = this.parentElement.previousElementSibling.value ;
        obj['_token'] = csrf_token;
        obj[name]=value;
        senddataaccount(obj , selected);
        }
        //console.log(obj);
    }
})

function senddataaccount(obj , selected){
    $.post('http://blog.com/ajax/account' , obj , function(one , two , there){
            //console.log(one);
            if(one == true){
                selected.parentElement.previousElementSibling.setAttribute('disabled' , '');
                selected.nextElementSibling.style.display = 'inline';
                selected.nextElementSibling.nextElementSibling.style.display = 'none';
                selected.style.display = 'none';
         }else if(one.status == false){
            bootbox.alert(`<i class="fa-solid fa-triangle-exclamation" style="color: #fd483d;font-size: 20px;margin-right: 10px;" ></i>  ` + one.message , function(){
            });
         }else if(one.status == true){
            bootbox.alert(`<i style="margin-left: 10px;margin-right: 10px;font-size: 20px;color: #06b006;" class="fa-solid fa-circle-check"></i> change password is succ` , function(){
            });
         }

        });

}

// make the action to image
let edit_iamge = document.querySelector('.edit-image');
let cancel_image = document.querySelector('.cancel-image');
if(edit_iamge){
    edit_iamge.onclick = function(element){
        this.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.removeAttribute('disabled');
        this.nextElementSibling.style.display = 'inline';
            this.previousElementSibling.style.display = 'inline';
            this.style.display = 'none';
            this.parentElement.previousElementSibling.previousElementSibling.style.background = 'green';
            this.parentElement.previousElementSibling.previousElementSibling.style.cursor = 'pointer';


    }

        cancel_image.onclick = function(){
            this.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.setAttribute('disabled' , '');
            this.previousElementSibling.style.display = 'inline';
            this.previousElementSibling.previousElementSibling.style.display ='none';
            this.style.display = 'none';
            this.parentElement.previousElementSibling.previousElementSibling.style.background = '#00800078';
            this.parentElement.previousElementSibling.previousElementSibling.style.cursor = 'context-menu';
        }

}

// the function run if you choose image
let imagechange = document.querySelector('[name="avatar"]');
if(imagechange){
    document.querySelector('[name="avatar"]').onchange = function(element){
        let image = []
        image.push({
             'name' : this.files[0].name,
             'url' : URL.createObjectURL(this.files[0]),
             'file' : this.files[0] ,
        })
        document.querySelector('.image-profile img').setAttribute('src' , image[0]['url']);
    //console.log(document.querySelector('[name="avatar"]').files[0] );
    };
};

let save_image =document.querySelector('.save-image');
if(save_image){
    document.querySelector('.save-image').onclick = function(element){
        let csrf_token = document.querySelector('[name="_token"]').value ;
        var selected = this ;
        var formData = new FormData();
        formData.append('image', document.querySelector('[name="avatar"]').files[0]);
        formData.append('_token' ,csrf_token);
       // console.log(formData);
                 $.ajax({
                     url : 'http://blog.com/ajax/account',
                     type : 'POST',
                     data : formData,
                     processData: false,
                       // tell jQuery not to process the data
                    contentType: false,
                    // tell jQuery not to set content-Type
                    success : function(data) {
                        //console.log("this is test");
                        console.log(data);
                       selected.parentElement.previousElementSibling.setAttribute('disabled' , '');
                    selected.nextElementSibling.style.display = 'inline';
                    selected.nextElementSibling.nextElementSibling.style.display = 'none';
                    selected.style.display = 'none';

                    }
                });
    }
}



