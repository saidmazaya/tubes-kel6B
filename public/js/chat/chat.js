let from_element = document.querySelector('.formchat');
from_element.onsubmit = function(e) {
    e.preventDefault();
    set_message_inchat(document.querySelector('[name="message"]').value);
    let data = new FormData(from_element);
    let csrf_token = document.querySelector('[name="_token"]').value ;
    data.append('_token' ,csrf_token);
    document.querySelector('[name="message"]').value = '';
             $.ajax({
                 url : 'http://blog.com/chat/sendmessage',
                 type : 'POST',
                 data : data,
                 processData: false,
                   // tell jQuery not to process the data
                contentType: false,
                // tell jQuery not to set content-Type
                success : function(data) {
                    //console.log(data);


                }
            });

}

function set_message_inchat($message){
    let all_message = document.querySelector('.chat-box').innerHTML;
    let message_box = all_message + `<div class="media  w-50 ml-auto mb-3 box-message ">
                                    <div class="media-body left-message">
                                    <div class="bg-primary rounded py-2 px-3 mb-2">
                                        <p class="text-small mb-0 text-white">${$message}</p>
                                    </div>
                                    <p class="small text-muted">${formatAMPM(new Date)}</p>
                                    </div>
                                </div>`;
    document.querySelector('.chat-box').innerHTML = message_box;
}

// show online users and show tht last message of user
let online_button = document.querySelector('.online-button');
let recent_button = document.querySelector('.recent-button');

online_button.onclick = function(){
    online_button.classList.add('active-button-box');
    recent_button.classList.remove('active-button-box');
    document.querySelector('.recent-message').style.display = 'none';
    document.querySelector('.online-users').style.display = 'block';

}
recent_button.onclick = function(){
    online_button.classList.remove('active-button-box');
    recent_button.classList.add('active-button-box');
    document.querySelector('.recent-message').style.display = 'block';
    document.querySelector('.online-users').style.display = 'none';
    show_last_messages();
}


function show_last_messages(){
        let data = new FormData();
        let csrf_token = document.querySelector('[name="_token"]').value ;
        data.append('_token' ,csrf_token);
             $.ajax({
                 url : 'http://blog.com/chat/showlastmessages',
                 type : 'POST',
                 data : data,
                 processData: false,
                   // tell jQuery not to process the data
                contentType: false,
                // tell jQuery not to set content-Type
                success : function(data) {
                    console.log(data);
                    if(data.status == true){
                            let recent_element = '';
                            data.data.forEach(one => {
                                recent_element += `<div class="media" style="position: relative;padding: 5px 10px;cursor: pointer;">
                                                        <img src="${one.image}" alt="user" width="50" class="rounded-circle">
                                                            <div class="media-body ml-4" style="width: 80%;">
                                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                                <h6 class="mb-0">${one.name}</h6><small class="small font-weight-bold">${one.time}</small>
                                                                </div>
                                                                <p class="font-italic text-muted mb-0 text-small">${one.message}</p>
                                                            </div>
                                                            <div class="user-box-layout" data-user-id="${one.id}" ></div>
                                                    </div>`;
                            });
                            document.querySelector('.recent-message').innerHTML = recent_element;

                    }
                }
            });
}

// make connection to channel to get the online users

  window.Echo.join('online')
  .here((users) => {
      //console.log(users);
      show_online_users(users);
  })
  .joining((user) => {
    console.log('this user enter');
    //console.log(user);
    add_user_online(user);

  })
  .leaving((user) => {
    console.log('this user leave');
    //console.log(user);
    remove_user_online(user);
  });


function show_online_users(users){
    let user_id = document.querySelector('meta[name=userID]').getAttribute('content');
    let online_box = '';
    users.forEach(user => {
        if(user.id != user_id){
            online_box += `<div class="media user-box" data-user-id-chat="${user.id}" >
                                <img src="${user.image}" alt="user" width="50" class="rounded-circle">
                                <div class="media-body ml-4">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <h6 class="mb-0">${user.name}</h6>
                                </div>
                                </div>
                                <div class="circule-active poing-active" >
                                </div>
                                <div class="user-box-layout" data-user-id="${user.id}" ></div>
                             </div>` ;
        }
    });

    document.querySelector('.online-users').innerHTML = online_box;
}

function add_user_online(user){
    let old_users = document.querySelector('.online-users').innerHTML;

    document.querySelector('.online-users').innerHTML = old_users + `<div class="media user-box" data-user-id-chat="${user.id}">
                                                                        <img src="${user.image}" alt="user" width="50" class="rounded-circle">
                                                                        <div class="media-body ml-4">
                                                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                                                            <h6 class="mb-0">${user.name}</h6>
                                                                        </div>
                                                                        </div>
                                                                        <div class="circule-active poing-active" >
                                                                        </div>
                                                                        <div class="user-box-layout" data-user-id="${user.id}" ></div>
                                                                    </div>`;
}

function remove_user_online(user){
    user_id_remove = user.id ;
    document.querySelector(`[data-user-id-chat="${user_id_remove}"]`).remove();
}


// show the message of user

document.addEventListener('click', function(e) {
    if(e.target.classList.contains('user-box-layout')){
        //console.log(e.target);
        let send_id = e.target.getAttribute('data-user-id');
        document.querySelector('[name="send_to"]').value = send_id;
        let data = new FormData();
        let csrf_token = document.querySelector('[name="_token"]').value ;
        data.append('_token' ,csrf_token);
        data.append('send_id' ,send_id);
             $.ajax({
                 url : 'http://blog.com/chat/getmessages',
                 type : 'POST',
                 data : data,
                 processData: false,
                   // tell jQuery not to process the data
                contentType: false,
                // tell jQuery not to set content-Type
                success : function(data) {
                   // console.log(data);
                    if(data.status == true){
                        show_message(data);
                    }
                }
            });
    }
});

function show_message(data){
    let image_url = data.image;
    let message_box = '';
    data.data.forEach(one => {
        if(one.type == 'send'){
             message_box += `<div class="media  w-50 ml-auto mb-3 box-message ">
                                <div class="media-body left-message">
                                <div class="bg-primary rounded py-2 px-3 mb-2">
                                    <p class="text-small mb-0 text-white">${one.message}</p>
                                </div>
                                <p class="small text-muted">${one.time}</p>
                                </div>
                            </div>`;
        }else{
            message_box +=  `<div class="media w-50 mb-3 right-message" style="justify-content: end;">
                                    <img src="${image_url}" alt="user" width="50" class="rounded-circle">
                                <div class="media-body ml-3">
                                    <div class="bg-light rounded py-2 px-3 mb-2">
                                    <p class="text-small mb-0 text-muted">${one.message}</p>
                                    </div>
                                    <p class="small text-muted">${one.time}</p>
                                </div>
                                </div>`;

        }
        document.querySelector('.chat-box').innerHTML = message_box;
        var element = document.querySelector('.chat-box');
    element.scrollTop = element.scrollHeight;


    });
}




function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
  };




  // for revice message from pusher
  let authid = $('meta[name=userID]').attr('content');

  window.Echo.private(`chat.channel.${authid}`)
  .listen('Chat', e => {
    one  = e.message;
     let  message_box =  `<div class="media w-50 mb-3 right-message" style="justify-content: end;">
                                <img src="${one.image_url}" alt="user" width="50" class="rounded-circle">
                            <div class="media-body ml-3">
                                <div class="bg-light rounded py-2 px-3 mb-2">
                                <p class="text-small mb-0 text-muted">${one.message}</p>
                                </div>
                                <p class="small text-muted">${one.time}</p>
                            </div>
                        </div>`;
    document.querySelector('.chat-box').innerHTML += message_box;
    //console.log(e);

    var element_height = document.querySelector('.chat-box').scrollHeight;
    $('.chat-box').animate({scrollTop: element_height});
  })
