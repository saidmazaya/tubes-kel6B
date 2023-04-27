
 let AuthID = $('meta[name=userID]').attr('content');
window.Echo.private(`blog.channel.${AuthID}`)
        .listen('MyEvent', (e) => {
            //console.log(e);
            // get data from event
            let image = e.message.image;
            let title = e.message.post_title;
            let user = e.message.user_name;
            let type = e.message.type;
            show_box_notitication(image , title , user , type);

        });


function show_box_notitication(image , title , user , type) {
    playSound('http://blog.com/files/notifications_sound.mp3');
    document.querySelector('.image-notification').src = image;
    if(type == 'like'){
        document.querySelector('.title-notification').innerHTML = `${user} make like in your post "${title}"`;
    }
    if (type == 'comment'){
        document.querySelector('.title-notification').innerHTML = `${user} make comment in your post "${title}"`;
    }

    // increase the count of number of notification
    document.querySelector('.notification-number').innerText = +document.querySelector('.notification-number').innerText + 1 ;
    // show the notification box to user
     document.querySelector('.notifications-message').style.top = '10px';
     setTimeout(() => {
        document.querySelector('.notifications-message').style.top = '-60px';
     }, 4000);
}


// make sound when user receive notification
const playSound = (url) => {
    const audio = new Audio(url);
    audio.play();
  }


  window.Echo.join('online')

  let authid_two = $('meta[name=userID]').attr('content');

  window.Echo.private(`chat.channel.${authid_two}`)
  .listen('Chat', e => {
      //console.log(e);
      if(e.message.type == 'send'){
        document.querySelector('.messages-number').innerText = +document.querySelector('.messages-number').innerText + 1 ;
        playSound('http://blog.com/files/notifications_sound.mp3');

      }

  });
