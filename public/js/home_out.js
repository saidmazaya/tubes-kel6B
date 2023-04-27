window.addEventListener("scroll", (event) => {
    let scroll = document.body.scrollHeight - window.scrollY;
    if(scroll < 655){
        //console.log("scroll");
        get_more_posts();
    }
    //console.log(scroll)
});

function get_more_posts(){
    let existing_posts = document.querySelectorAll('.box-post').length;

    $.ajax({
        url : 'http://blog.com/ajax/get_more_posts/'+ existing_posts,
        type : 'GET',
        data : {},
        processData: false,
          // tell jQuery not to process the data
       contentType: false,
       // tell jQuery not to set content-Type
       success : function(data) {
           document.querySelector('.posts-box').innerHTML += data;
          // console.log(data);

       }
   });
}
