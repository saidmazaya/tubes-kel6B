

let ele_user_setting = document.querySelector('.user_image');
if(ele_user_setting){
    ele_user_setting.onclick = function(){
document.querySelector('.main_user_bar').classList.toggle('main_user_bar_active');
    };
}

window.addEventListener('click', function(e){
    if(document.querySelector('.user_image')){
    if (document.querySelector('.user_image').contains(e.target)){
      // Clicked in box
    } else{
        document.querySelector('.main_user_bar').classList.remove('main_user_bar_active')
    }}
    // show the options of post
    if(e.target.classList.contains('option-icon')){
        let id = e.target.getAttribute('data-option-id');
         document.querySelector('.option-list-display-'+id).style.display = 'block';
    }
    // if click in any space hidden all options bar opened
    let option_elements = document.querySelectorAll('.option-icon');
    option_elements.forEach(function(ele){
        if(ele.contains(e.target)){
            console.log('in');
        }else{
            let id = ele.getAttribute('data-option-id');
            document.querySelector('.option-list-display-'+id).style.display = 'none';
        }

    });

     // show the notification list
    if(e.target.classList.contains('not-icon')){
        get_notification_list();
        document.querySelector('.notification-list-box').style.display = 'block';
    }
    // if clik in any space hidden all options bar opened
    let not_elements = document.querySelector('.notification-list-box');
    if(not_elements.contains(e.target) || e.target.classList.contains('not-icon')){
        //console.log('in');
    }else{
        document.querySelector('.notification-list-box').style.display = 'none';
        //console.log('out');
    }




});
//-------------------------------------------------------------------------------------------------------

// add new list to me
let make_new_list = document.querySelector('.make-new-list');
 if(make_new_list){

     make_new_list.onclick = function(element){

        bootbox.prompt("The Name of New List ", function(result){
            if(result != null){
                let obj = Object.create({});
                let csrf_token = document.querySelector('[name="_token"]').value ;
                obj['_token'] = csrf_token;
                obj['list_name']=result;
                $.post('http://blog.com/writeup/store_list' , obj , function(one , two , there){
            if(one == true){
                location.reload();
            }

        });
            }
        });
     }
 }

//-------------------------------------------------------------------------------------------------------
 // sure massage that you want delet list
let delet_list_all= document.querySelectorAll('.delet-list')  ;
delet_list_all.forEach(function(delet_list){

        delet_list.onclick = function(){
            let name_list = delet_list.getAttribute('data-title');
            bootbox.confirm({
                message: 'do you want to delet <span style="color: red;font-size: 17px;font-weight: 400;">' + name_list + '</span> list ',
                buttons: {
                    confirm: {
                        label: 'Delet',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result == true){
                       delet_list_fun(name_list);
                    }

                }
            });
        }

})

function delet_list_fun(list)
{
    let obj = Object.create({});
                let csrf_token = document.querySelector('[name="_token"]').value ;
                obj['_token'] = csrf_token;
                obj['deleted_list']=list;
                console.log(obj);
    $.post('http://blog.com/writeup/delet_list' , obj , function(one , two , there){
        if(one == true){
            location.reload();
        }
    });
}

//-------------------------------------------------------------------------------------------------------
// go to writeup page but before check that user choose list to this write-up
let form_list = document.querySelector('.list-form');
if(form_list)
{
    form_list.onsubmit = function(e){

        let list_value = document.querySelector('[name="list"]').value;

        console.log(_.isEmpty(list_value));
        if(_.isEmpty(list_value)){
            e.preventDefault();
            bootbox.alert({
                message: "you should choose list !!",
                size: 'small'
            });
        }

    }

}
//---------------------------------------------------------------------------

var save_elemet_number = '0';

document.onclick = function(e){
// save the post
    if(e.target.classList.contains('oc')){
        e.target.classList.add('save_selected');
        let number_of_post_save = e.target.parentElement.parentElement.previousElementSibling.children[0].href.split('/').slice(-1)[0];
        // send request to get the lists of user
        save_elemet_number = number_of_post_save ;
        save_post(number_of_post_save , e.target);
    }

    // unsave post
   // console.log(e.target);
    if(e.target.classList.contains('saved-post')){
        let unsave_post_number = e.target.getAttribute('data-post_number');
        bootbox.confirm({
            message: "you want to delete this post from save list ? ",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-success'
                }
            },
            callback: function (result) {
               // console.log(result);
                if(result == true){
                    e.target.parentElement.classList.add('unsave_post');
                    unsave_post(unsave_post_number);
                }
            }
        });

    }
}



// save post fauncjion

function save_post(number_post , element_selected){

    let obj = Object.create({});
    let csrf_token = document.querySelector('[name="_token"]').value ;
    obj['_token'] = csrf_token;
    //console.log(obj);
    $.post('http://blog.com/ajax/get_lists' , obj , function(one , two , there){
        if(one.status == true){
            //location.reload();
            // get liest of user and disply them to him
            let array_list = [{
                text: 'Choose one...',
                value: '',
            }];
            one.lists.forEach(function(ele , index){
                array_list[index+1] ={
                    text: ele,
                    value:ele,
                }
            })
            //console.log(array_list);
            bootbox.prompt({
                    title: `choose list you want to save in <span class='create_new_list' style="margin-left: 125px;padding: 7px 21px;background: #3097d1;color: white;border-radius: 8px;cursor: pointer;"> Create New List</span>`,
                    inputType: 'select',
                    inputOptions: array_list,
                    callback: function (result) {
                        //console.log(result);
                        if( result != '' && result != null){

                            send_request_to_save_post(number_post , result , element_selected);
                        }else if(result == ''){
                            bootbox.alert("you should choose list ");
                        }
                    }
            });
        }


    });


}
// click on creat new list
window.onclick = function(ele){
if(ele.target.classList.contains('create_new_list')){
    //check if this new list add from main page of save posts or it add from mina page of home
    if(document.querySelector('.create_new_list').classList.contains('click_new_list')){
        // from save posts
        console.log('from save posts');
        new_list(true);
    }else{
        // from home page
        console.log('from home page');

        new_list(false);
    }

}
}


// function for make new list
function  new_list(checked){
    bootbox.prompt("make new list for save posts", function(result){
        if(result != null && result.length > 5){
            let obj = Object.create({});
            let csrf_token = document.querySelector('[name="_token"]').value ;
            obj['_token'] = csrf_token;
            obj['list'] = result ;
            $.post('http://blog.com/ajax/makenewlist' , obj , function(one , two , there){
                if(one.status == true){
                    if(checked == false){
                        document.querySelector('.bootbox-cancel').click();
                    let element_selected_before  = document.querySelector('.save_selected');
                    save_post(save_elemet_number , element_selected_before);
                    }else{
                        bootbox.alert(`new list saved <i style="margin-left: 10px;margin-right: 10px;font-size: 20px;color: #06b006;" class="fa-solid fa-circle-check"></i>`, function(){
                            location.reload();
                        });

                    }

                }else{
                    bootbox.alert({
                        message: "sorry some thing do wrong try again",
                        size: 'small'
                    });
                }
            });
        }else if(result == null){
        }else if(result.length < 5){
            // if name is empty or less than 10 character
            bootbox.alert("list name should be greater than 5 character");
        }
    });
}

function send_request_to_save_post(number , list , element_selected){
    let obj = Object.create({});
    let csrf_token = document.querySelector('[name="_token"]').value ;
    obj['_token'] = csrf_token;
    obj['list_number'] = number ;
    obj['list_name'] = list ;
    $.get('http://blog.com/ajax/savepost' , obj , function(one , two , there){
        if(one.status == true){
            //location.reload();
            bootbox.alert(`post saved <i style="margin-left: 10px;margin-right: 10px;font-size: 20px;color: #06b006;" class="fa-solid fa-circle-check"></i>`, function(){
                element_selected.outerHTML = `<svg class='saved-post' style="cursor: pointer;" width="24" height="24" viewBox="0 0 24 24" fill="none" class="vt"><path data-post_number=${number} class="saved-post" d="M7.5 3.75a2 2 0 0 0-2 2v14a.5.5 0 0 0 .8.4l5.7-4.4 5.7 4.4a.5.5 0 0 0 .8-.4v-14a2 2 0 0 0-2-2h-9z" fill="#000"></path></svg>`;
            });
        }else{
            bootbox.alert("some thing was wrong ");

        }

    });

}



document.addEventListener("click", function(e){
    //------------------------------------------------------------------------
    // delet save list
    if(e.target.classList.contains('delet_save_list')){
        let delet_list_name = e.target.getAttribute('data-save_list_name');
        bootbox.confirm({
            message: "do you want to delet " + delet_list_name + " list",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result == true){
                       delet_save_list(delet_list_name);
                }
            }
        });
    }
    //-----------------------------------------------------
});

// functin for delet save list

function delet_save_list(delet_save_list){
    let obj = Object.create({});
    let csrf_token = document.querySelector('[name="_token"]').value ;
    obj['_token'] = csrf_token;
    obj['delet_save_list'] = delet_save_list;
    $.post('http://blog.com/ajax/delet_save_list' , obj , function(one , two , there){
        console.log(one);
        if(one.status == true){
            bootbox.alert(`List deleted <i style="margin-left: 10px;margin-right: 10px;font-size: 20px;color: #06b006;" class="fa-solid fa-circle-check"></i>`);
            setTimeout(() => {
             location.reload();
            }, 1000);
        }

    });
}

// unsave function

function unsave_post(number_unsave ){
   //console.log(number_unsave);
    let obj = Object.create({});
    let csrf_token = document.querySelector('[name="_token"]').value ;
    obj['_token'] = csrf_token;
    obj['unsave_post'] = number_unsave ;
    $.post('http://blog.com/ajax/unsave_post' , obj , function(one , two , there){
       // console.log(one);
        if(one.status == true){
             document.querySelector('.unsave_post').outerHTML = `<svg width="25" height="25" viewBox="0 0 25 25" fill="none" class="oc" style="cursor: pointer;">
                                                                 <path  d="M18 2.5a.5.5 0 0 1 1 0V5h2.5a.5.5 0 0 1 0 1H19v2.5a.5.5 0 1 1-1 0V6h-2.5a.5.5 0 0 1 0-1H18V2.5zM7 7a1 1 0 0 1 1-1h3.5a.5.5 0 0 0 0-1H8a2 2 0 0 0-2 2v14a.5.5 0 0 0 .8.4l5.7-4.4 5.7 4.4a.5.5 0 0 0 .8-.4v-8.5a.5.5 0 0 0-1 0v7.48l-5.2-4a.5.5 0 0 0-.6 0l-5.2 4V7z" fill="#292929"></path>
                                                                 </svg>` ;
        }else{
            bootbox.alert("something is wrong please try agian ");
        }
    });
}


function get_notification_list(){
    let obj = Object.create({});
    let csrf_token = document.querySelector('[name="_token"]').value ;
    obj['_token'] = csrf_token;
    $.post('http://blog.com/ajax/notifications' , obj , function(one , two , there){
        let notification_list_one_all = '';
        one.forEach(function(one_notification){
            let href = '';
            if(one_notification.type == 'like'){
                href = `http://blog.com/posts/${one_notification.post_id}`;
            }else if(one_notification.type == 'comment'){
                href = `http://blog.com/posts/${one_notification.post_id}/comments`;
            }
            notification_list_one_all += `<a href="${href}" style="text-decoration: none;color: unset;" ><div class="notification-list-one" style="display: flex;margin-top: 5px;margin-bottom: 5px;position: relative;top: 0px;left: 0px;bottom: 0px;right: 0px;align-items: center;">
                                            <div class="box-image-not" style="width: 40px;height: 40px;border-radius: 20px;overflow: hidden;position: relative;top: 0px;">
                                                <img src="${one_notification.image_url}" alt="" style="width: 100%;">
                                            </div>
                                            <p style="font-size: 13px;margin-bottom: 0px;width: 283px;" >${ one_notification.name} make ${ one_notification.type} in your post "${one_notification.post_title}"</p>
                                            <div class="data" >
                                                <p>${ one_notification.time}</p>
                                            </div>
                                        </div></a>`;
        })
         //console.log(one);
         //console.log(notification_list_one_all);
         let end_element = `<div class="view-all" style="position: relative;top:0px">
                                <a href="http://blog.com/writeup/notifications" style="text-decoration: none;color: #fd483d;">
                                   <p>view all notifications</p>
                                </a>
                            </div>`
         if(one.length == 0){

         }
         else{
                document.querySelector('.notification-list').innerHTML = notification_list_one_all + end_element ;

            }
    });
}
